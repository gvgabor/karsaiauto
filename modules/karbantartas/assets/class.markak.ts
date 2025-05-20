import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import ObservableObject = kendo.data.ObservableObject;


declare const markakColumns: kendo.ui.GridColumn[];

export enum MarkakEndPoints {
    MARKAK = "Markak",
    MARKAK_FORM = "MarkakForm",
    REMOVE_MARKA = "RemoveMarka",
}


export class ClassMarkak extends ClassUtil {
    async init() {
        const markakGrid = await this.markakGrid(this.div("markak-grid"));

        this.dataBound(markakGrid, () => {
            const grid = markakGrid;
            this.gridButtonList(grid, "edit-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number }
                item.button.onclick = async () => {
                    await this.markaForm({id: dataItem.id});
                    grid.dataSource.read();
                }
            });

            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number, name: string }
                item.button.onclick = async () => {
                    await this.confirm(`Biztos törli a(z) ${dataItem.name} márkát`, item.button);
                    await this.fetchData(this.url(MarkakEndPoints.REMOVE_MARKA), {id: dataItem.id});
                    grid.dataSource.remove(item.data);
                }
            });
        })

        const createMarkaBtn = this.button("create-marka-btn");
        createMarkaBtn.onclick = async () => {
            await this.markaForm();
            markakGrid.dataSource.read();
        }
    }


    async markaForm(data = {}) {
        const url = this.url(MarkakEndPoints.MARKAK_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "markak") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });

    }

    markakGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {

        return new Promise((resolve) => {
            const url = this.url(MarkakEndPoints.MARKAK);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = markakColumns;
            jQuery(element).kendoGrid({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: "100%",
                pageable: {
                    refresh: true
                },
                dataBound: event => resolve(event.sender)
            })
        })


    }

}