import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import ObservableObject = kendo.data.ObservableObject;


declare const ugyfelekColumns: kendo.ui.GridColumn[];

export enum UgyfelekEndPoint {
    UGYFELEK_FORM = "UgyfelekForm",
    UGYFELEK = "Ugyfelek",
    REMOVE_UGYFEL = "RemoveUgyfel",
    MAGAN = 1,
    CEG = 2,
}

export class ClassUgyfelek extends ClassUtil {

    url(action: string): string {
        return `/autok/ugyfelek/${action}`;
    }

    async init() {
        const ugyfelekGrid = await this.ugyfelekGrid(this.div("ugyfelek-grid"));
        this.dataBound(ugyfelekGrid, () => {
            const grid = ugyfelekGrid;
            grid.autoFitColumn("email");
            grid.autoFitColumn("lakcim");
            this.gridButtonList(grid, "edit-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number };
                item.button.onclick = async () => {
                    const response = await this.ugyfelekForm({id: dataItem.id});
                    this.message(response.message);
                    grid.dataSource.pushUpdate(response.model);
                }
            });
            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number };
                item.button.onclick = async () => {
                    await this.confirm(grid.wrapper[0].dataset.deleteConfirm!, item.button);
                    const url = this.url(UgyfelekEndPoint.REMOVE_UGYFEL);
                    const response = await this.fetchData(url, {id: dataItem.id});
                    this.message(response);
                    grid.dataSource.remove(dataItem);
                }
            })
        })

        const createUgyfelBtn = this.button("create-ugyfel-btn");
        createUgyfelBtn.onclick = async () => {
            const response: ApiResponse = await this.ugyfelekForm();
            this.message(response.message);
            ugyfelekGrid.dataSource.insert(0, response.model);
        }
    }

    async ugyfelekForm(data: Object = {}): Promise<ApiResponse> {
        const url = this.url(UgyfelekEndPoint.UGYFELEK_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        const ugyfelekTipus = jQuery(this.input("ugyfelek-tipus")).kendoDropDownList({
            filter: "contains"
        }).data("kendoDropDownList") as kendo.ui.DropDownList;
        ugyfelekTipus.bind("change", () => {
            const cegData = this.div("ceg-data");
            const maganData = this.div("magan-data");
            cegData.classList.add("d-none");
            maganData.classList.add("d-none");
            const value = parseInt(ugyfelekTipus.value());

            if (value == UgyfelekEndPoint.MAGAN) {
                maganData.classList.remove("d-none")
            }

            if (value == UgyfelekEndPoint.CEG) {
                cegData.classList.remove("d-none");
            }
        });

        ugyfelekTipus.trigger("change");

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "ugyfelek") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });
    }


    ugyfelekGrid(element: HTMLElement): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const url = this.url(UgyfelekEndPoint.UGYFELEK);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema,
                serverPaging: true,
                serverFiltering: true
            });
            const columns = ugyfelekColumns;
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