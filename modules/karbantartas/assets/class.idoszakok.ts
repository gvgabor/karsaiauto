import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";


declare const idoszakokColumns: kendo.ui.GridColumn[];

export enum IdoszakokEndPoints {
    IDOSZAKOK = "Idoszakok",
    IDOSZAKOK_FORM = "IdoszakokForm",
}

export class ClassIdoszakok extends ClassUtil {

    async init() {
        const idoszakokGrid = await this.idoszakokGrid(this.div("idoszakok-grid"));
        const createIdoszakBtn = this.button("create-idoszak-btn");
        createIdoszakBtn.onclick = async () => {
          await  this.createIdoszakForm();
          idoszakokGrid.dataSource.read();
        }
    }

    async createIdoszakForm(data = {}) {
        const url = this.url(IdoszakokEndPoints.IDOSZAKOK_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "idoszakok") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });

    }

    idoszakokGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {

        return new Promise((resolve) => {

            const url = this.url(IdoszakokEndPoints.IDOSZAKOK);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = idoszakokColumns;
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