import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";


declare const arvalasztoColumns: kendo.ui.GridColumn[];

export enum ArakEndPoints {
    ARVALASZTO_FORM = "ArvalasztoForm",
    ARVALASZTO = "Arvalaszto",
}

export class ClassArak extends ClassUtil {
    async init() {
        const arvalasztoGrid = await this.arvalasztoGrid(this.div("arvalaszto-grid"));

        const createArvalasztoBtn = this.button("create-arvalaszto-btn");
        createArvalasztoBtn.onclick = async () => {
            await this.arvalasztoForm();
            arvalasztoGrid.dataSource.read();
        }
    }


    arvalasztoGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const url = this.url(ArakEndPoints.ARVALASZTO);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = arvalasztoColumns;

            ['kezdo_osszeg', 'veg_osszeg'].forEach(fieldName => {
                columns.find(item => item.field == fieldName)!.template = (data: { [key: string]: any }) => {
                    return data[fieldName] ? `${kendo.toString(data[fieldName], "n0")} Ft` : "";
                }
            })

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
        });
    }

    async arvalasztoForm(data = {}) {
        const url = this.url(ArakEndPoints.ARVALASZTO_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);

        ['arvalaszto-kezdo_osszeg', 'arvalaszto-veg_osszeg'].forEach(item => {
            const element = document.getElementById(item)!;
            jQuery(element).kendoNumericTextBox({
                format: "n0",
                decimals: 0
            })
        });

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "arvalaszto") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });
    }

}