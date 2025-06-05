import {ClassUtil} from "../../helpers/class.util";
import {ClassCardetail} from "./class.cardetail";
import ObservableObject = kendo.data.ObservableObject;


export enum LandingEndPoint {
    AKCIOS_DATASOURCE = "AkciosDatasource",
    SAVE_FILTER = "SaveFilter",
    TYPE_AKCIOS = 1,
    TYPE_KIEMELT = 2,

}

export class ClassLanding extends ClassUtil {
    async init() {
        ["filtermodel-marka", "filtermodel-evjarat", "filtermodel-vetelar"].forEach(id => {
            jQuery(this.input(id)).kendoDropDownList({
                filter: "contains",
                height: 400
            })
        });

        const akciosAutokList = await this.akciosAutokList(this.div("akcios-autok-list"), LandingEndPoint.TYPE_AKCIOS);
        const kiemeltAutokList = await this.akciosAutokList(this.div("kiemelt-autok-list"), LandingEndPoint.TYPE_KIEMELT);

        const kiemeltAutokLabel = document.getElementById("kiemelt-autok-label")!;
        const akciosAutokLabel = document.getElementById("akcios-autok-label")!;

        this.dataBound(kiemeltAutokList, () => {
            const list = kiemeltAutokList;
            kiemeltAutokLabel.style.display = list.dataSource.data().length == 0 ? "none" : "block";
            (Array.from(list.wrapper[0].querySelectorAll(`div.autok-list-item`)) as HTMLDivElement[]).forEach(item => {
                const dataItem = list.dataItem(item) as ObservableObject & { id: number, oldal: string };
                (item.querySelector(`div.image-box`)! as HTMLDivElement).onclick = () => {
                    if (this.isMobile()) {
                        this.navigate(dataItem.oldal);
                    } else {
                        new ClassCardetail(dataItem.id).showDetail();
                    }
                }
            });
        });

        this.dataBound(akciosAutokList, () => {
            const list = akciosAutokList;
            akciosAutokLabel.style.display = list.dataSource.data().length == 0 ? "none" : "block";
            (Array.from(list.wrapper[0].querySelectorAll(`div.autok-list-item`)) as HTMLDivElement[]).forEach(item => {
                const dataItem = list.dataItem(item) as ObservableObject & { id: number, oldal: string };
                (item.querySelector(`div.image-box`)! as HTMLDivElement).onclick = () => {
                    if (this.isMobile()) {
                        this.navigate(dataItem.oldal);
                    } else {
                        new ClassCardetail(dataItem.id).showDetail();
                    }
                }
            });
        });


        const saveFilterBtn = this.button("save-filter-btn");
        saveFilterBtn.onclick = async () => {
            const form = document.getElementById("filter-form") as HTMLFormElement;
            const formData = new FormData(form);
            const url = this.url(LandingEndPoint.SAVE_FILTER);
            const response = await this.fetchForm(url, formData);
            this.navigate(response.url);
        }

    }


    url(action: string): string {
        return `/index/${action}`;
    }


    akciosAutokList(element: HTMLElement, type: number): Promise<kendo.ui.ListView> {

        return new Promise((resolve) => {
            const url = this.url(LandingEndPoint.AKCIOS_DATASOURCE);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            transport.read.data.type = type;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            jQuery(element).kendoListView({
                template: (data: any) => data.template,
                dataSource: dataSource,
                dataBound: event => resolve(event.sender)
            })
        })


    }

}