import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import ObservableObject = kendo.data.ObservableObject;


declare const gridColumns: kendo.ui.GridColumn[];

export enum ENDPOINTS {
    SZINEK = "Szinek",
    SZINEK_FORM = "SzinekForm",
    REMOVE_SZINEK= "RemoveSzinek"
}

export class ClassSzinek extends ClassUtil{

    url(action: string): string {
        return `/karbantartas/szinek/${action}`;
    }

    async init(){
        const grid = await this.grid(this.div("grid"));


        this.dataBound(grid, () => {
            this.gridButtonList(grid, "edit-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number }
                item.button.onclick = async () => {
                    const response: any = await this.form({id: dataItem.id});
                    grid.dataSource.read();
                    this.message(response.message);
                }
            });
            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number, name: string }
                item.button.onclick = async () => {
                    await this.confirm(`Biztos törli a(z) ${dataItem.name} felszereltséget`, item.button);
                    const response = await this.fetchData(this.url(ENDPOINTS.REMOVE_SZINEK), {id: dataItem.id});
                    grid.dataSource.remove(item.data);
                    this.message(response);
                }
            });
        })

        const createBtn = this.button("create-btn");
        createBtn.onclick = async () => {
            const response = await this.form() as ApiResponse;
            grid.dataSource.pushInsert(0, response.model);
            this.message(response.message);
        }
    }

    async form(data = {}) {
        const url = this.url(ENDPOINTS.SZINEK_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "szinek") as ApiResponse;
                resolve(response)
                await popup.close();
            }
        });
    }


    grid(element: HTMLDivElement): Promise<kendo.ui.Grid> {

        return new Promise((resolve) => {
            const url = this.url(ENDPOINTS.SZINEK);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = gridColumns;
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