import {ClassUtil} from "../../helpers/class.util";
import {LandingEndPoint} from "./class.landing";
import {ClassCardetail} from "./class.cardetail";
import ObservableObject = kendo.data.ObservableObject;


export enum JarmuvekEndPoint {
    JARMUVEK_FILTER_DATA_SOURCE = "JarmuvekFilterDataSource",
}

export class ClassJarmuvek extends ClassUtil {


    url(action: string): string {
        return `/index/${action}`;
    }

    async init() {


        const saveFilterBtn = this.button("save-filter-btn");
        const jarmuvekPager1 = this.div("jarmuvek-pager-1");
        const jarmuvekPager2 = this.div("jarmuvek-pager-2");
        const jarmuvekList = await this.jarmuvekList(this.div("jarmuvek-list"), jarmuvekPager1, jarmuvekPager2);
        this.filterSelectIdList.forEach(id => jQuery(this.input(id)).kendoDropDownList({
            filter: "contains",
            height: 400,
            valueTemplate: (data: any) => {
                let template = `<div class="filter-template"><span class="label">${data.text}</span></div>`;
                if (data.value) {
                    template = `<div class="filter-template"><span>${data.text}</span><span class="label">${data.parent()[0].text}</span></div>`
                }
                return template;
            },
            change: () => {
                saveFilterBtn.click();
            }
        }));


        this.dataBound(jarmuvekList, () => {
            const list = jarmuvekList;
            const container = list.content[0];
            if (list.dataSource.data().length == 0) {
                container.classList.add("empty");
                container.innerHTML = `<div><i class="fa-solid fa-truck"></i><span>Sajnos nincs a keresésnek megfelelő jármű</span></div>`
            } else {
                container.classList.remove("empty");
            }
            jarmuvekPager1.style.display = list.dataSource.data().length == 0 ? "none" : "flex";
            jarmuvekPager2.style.display = list.dataSource.data().length == 0 ? "none" : "flex";
            (Array.from(list.wrapper[0].querySelectorAll(`div.autok-list-item`)) as HTMLDivElement[]).forEach(item => {
                const dataItem = list.dataItem(item) as ObservableObject & { id: number };
                (item.querySelector(`div.image-box`)! as HTMLDivElement).onclick = (event) => {
                    console.log(event.clientY)
                    new ClassCardetail(dataItem.id).showDetail();
                }
            });
        });
        (Array.from(document.querySelectorAll(`button.remove-filter-btn`)) as HTMLButtonElement[]).forEach((button) => {
            const hozzadRow: HTMLDivElement = button.closest("div.hozzad-row")!;
            const currentDropDown = jQuery(hozzadRow.querySelector(`select`)!).data("kendoDropDownList") as kendo.ui.DropDownList;
            button.onclick = () => {
                currentDropDown.value("");
                saveFilterBtn.click();
            }
        });
        saveFilterBtn.onclick = async () => {
            const form = document.getElementById("filter-form") as HTMLFormElement;
            const formData = new FormData(form);
            const url = this.url(LandingEndPoint.SAVE_FILTER);
            await this.fetchForm(url, formData);
            jarmuvekList.dataSource.page(1);
        }
    }


    get filterSelectIdList() {
        return [
            "filtermodel-marka",
            "filtermodel-evjarat",
            "filtermodel-vetelar",
            "filtermodel-jarmutipus", "filtermodel-motortipus",
            "filtermodel-valto",
            "filtermodel-teljesitmeny",
            "filtermodel-kilometer", "filtermodel-sorbarendezes"
        ];
    }

    jarmuvekList(element: HTMLDivElement, pager1: HTMLDivElement, pager2: HTMLDivElement): Promise<kendo.ui.ListView> {
        return new Promise((resolve) => {
            const url = this.url(JarmuvekEndPoint.JARMUVEK_FILTER_DATA_SOURCE);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 30,
                transport: transport,
                schema: schema,
                serverPaging: true,
            });
            jQuery(element).kendoListView({
                template: (data: any) => data.template,
                dataSource: dataSource,
                dataBound: event => resolve(event.sender)
            })
            jQuery(pager1).kendoPager({
                responsive: true,
                refresh: true,
                dataSource: dataSource,
            });
            jQuery(pager2).kendoPager({
                responsive: true,
                refresh: true,
                dataSource: dataSource,
                change: () => {
                    const navbar = document.querySelector(`nav.navbar`) as HTMLDivElement;
                    const section = document.querySelector(`section.hero`) as HTMLDivElement;
                    const position = navbar.offsetHeight + section.offsetHeight - 40;
                    window.scrollTo({top: position, behavior: "smooth"});
                }
            })
        });

    }

}