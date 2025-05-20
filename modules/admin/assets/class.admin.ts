import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import {ClassJelszovaltoztatas} from "./class.jelszovaltoztatas";
import {ClassHozzarendeles} from "./class.hozzarendeles";
import ObservableObject = kendo.data.ObservableObject;
import TreeListModel = kendo.data.TreeListModel;

declare const felhasznalokColumns: kendo.ui.GridColumn[];
declare const felhasznaloiJogokColumns: kendo.ui.GridColumn[];
declare const menuColumns: kendo.ui.TreeListColumn[];


export enum AdminEndPoints {
    FELHASZNALOK = "Felhasznalok",
    FELHASZNALOI_JOGOK = "FelhasznaloiJogok",
    FELHASZNALOK_FORM = "FelhasznalokForm",
    JELSZO_VALTOZTATAS_FORM = "JelszoValtoztatasForm",
    FELHASZNALOI_JOGOK_FORM = "FelhasznaloiJogokForm",
    MENU = "Menu",
    REMOVE_MENU = "RemoveMenu",
    REMOVE_FELHASZNALO = "RemoveFelhasznalo",
    REMOVE_FELHASZNALOI_JOGOK = "RemoveFelhasznaloiJogok",
    MENU_FORM = "MenuForm",
    HOZZARENDELES_FORM = "HozzarendelesForm",
}


export class ClassAdmin extends ClassUtil {


    async init() {
        const adminTab = jQuery(this.div("admin-tab")).kendoTabStrip({
            animation: false,
            navigatable: true,
            activate: async (event: kendo.ui.TabStripActivateEvent) => {
                const grid = event.contentElement?.querySelector(`div.grid`);
                if (grid) {
                    if (grid.id == "menu-grid") {
                        jQuery((grid as HTMLDivElement)).data("kendoTreeList")?.refresh();
                    } else {
                        jQuery((grid as HTMLDivElement)).data("kendoGrid")?.refresh();
                    }
                }
            }
        }).data("kendoTabStrip") as kendo.ui.TabStrip;
        adminTab.select(2);
        const felhasznalokGrid = await this.felhasznalokGrid(this.div("felhasznalok-grid"));
        const felhasznaloiJogokGrid = await this.felhasznaloiJogokGrid(this.div("felhasznaloi-jogok-grid"));
        const menuGrid = await this.menuGrid(this.div("menu-grid"));

        this.dataBound(menuGrid, () => {
            const grid = menuGrid;
            grid.autoFitColumn("sorrend");
            Array.from(grid.wrapper[0].querySelectorAll(`td[data-name="edit-td"]`) as NodeListOf<HTMLTableCellElement>).forEach(cell => {
                cell.innerHTML = `<button class="btn btn-warning edit-btn"><i class='fa fa-pen-alt'></i></button>`;
                const row = cell.closest(`tr`)!;
                const dataItem = grid.dataItem(row) as TreeListModel & { id: number };
                cell.onclick = async () => {
                    await this.menuForm({id: dataItem.id});
                    grid.dataSource.read();
                }
            })
            Array.from(grid.wrapper[0].querySelectorAll(`td[data-name="delete-td"]`) as NodeListOf<HTMLTableCellElement>).forEach(cell => {
                const row = cell.closest(`tr`)!;
                const dataItem = grid.dataItem(row) as TreeListModel & {
                    id: number,
                    menu_name: string,
                    hasChild: boolean
                };

                if (dataItem.hasChild) {
                    cell.innerHTML = ``
                } else {
                    cell.innerHTML = `<button class="btn btn-danger remove-btn"><i class='fa fa-trash-alt'></i></button>`
                    cell.onclick = async () => {
                        await this.confirm(`Biztosan töli a <strong>${dataItem.menu_name}</strong> elemet?`, cell);
                        await this.fetchDelete(this.url(AdminEndPoints.REMOVE_MENU), dataItem.id);
                        grid.dataSource.read();
                    }
                }


            })
        })

        this.dataBound(felhasznaloiJogokGrid, () => {
            const grid = felhasznaloiJogokGrid;

            this.gridButtonList(grid, "edit-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & {
                    id: number,
                    jogosultsag_neve: string,
                    felhasznalok_szama: number
                };
                item.button.onclick = async () => {
                    const response = await this.felhasznaloiJogokForm({id: dataItem.id});
                    grid.dataSource.pushUpdate(response.model);
                }
            });


            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & {
                    id: number,
                    jogosultsag_neve: string,
                    felhasznalok_szama: number
                };
                item.button.onclick = async () => {
                    await this.confirm(`Biztos törli <strong> ${dataItem.jogosultsag_neve} </strong>jogosultságot?`, item.button);
                    await this.fetchDelete(this.url(AdminEndPoints.REMOVE_FELHASZNALOI_JOGOK), dataItem.id);
                    grid.dataSource.remove(dataItem);
                }
            });

            Array.from(grid.wrapper[0].querySelectorAll(`button.hozzarendeles-btn`) as NodeListOf<HTMLButtonElement>)
                .forEach(item => {
                    const row = item.closest("tr")!;
                    const dataItem = grid.dataItem(row) as ObservableObject & {
                        id: number,
                        jogosultsag_neve: string,
                        felhasznalok_szama: number
                    };
                    item.onclick = async () => {
                        const url = this.url(AdminEndPoints.HOZZARENDELES_FORM);
                        const hozzarendeles = new ClassHozzarendeles();
                        await hozzarendeles.hozzarendelesForm(dataItem.id, url);
                    };
                });
        });

        this.dataBound(felhasznalokGrid, () => {
            const grid = felhasznalokGrid;

            this.gridButtonList(grid, "edit-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { felhasznaloi_nev: string, id: number };
                item.button.onclick = async () => {
                    const response = await this.felhasznalokForm({id: (dataItem as unknown as { id: number }).id});
                    grid.dataSource.pushUpdate(response.model);
                };
            });

            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number, felhasznaloi_nev: string };
                item.button.onclick = async () => {
                    await this.confirm(`Biztos törli <strong> ${dataItem.felhasznaloi_nev} </strong>felhasználót?`, item.button);
                    await this.fetchDelete(this.url(AdminEndPoints.REMOVE_FELHASZNALO), dataItem.id);
                    grid.dataSource.remove(dataItem);
                }
            });

            this.gridButtonList(grid, "jelszo-valtoztatas-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number, felhasznaloi_nev: string };
                item.button.onclick = async () => {
                    const url = this.url(AdminEndPoints.JELSZO_VALTOZTATAS_FORM);
                    const id = dataItem.id;
                    const jelszovaltoztatas = new ClassJelszovaltoztatas();
                    await jelszovaltoztatas.valtoztatasForm(id, url);
                }
            });
        })

        const createFelhasznaloBtn = this.button("create-felhasznalo-btn");
        createFelhasznaloBtn.onclick = async () => {
            const response = await this.felhasznalokForm();
            felhasznalokGrid.dataSource.insert(0, response.model);
        }

        const createFelhasznaloiJogBtn = this.button("create-felhasznaloi-jog-btn");
        createFelhasznaloiJogBtn.onclick = async () => {
            const response = await this.felhasznaloiJogokForm();
            felhasznaloiJogokGrid.dataSource.insert(0, response.model);
        }
        const createMenuBtn = this.button("create-menu-btn");
        createMenuBtn.onclick = async () => {
            await this.menuForm();
            menuGrid.dataSource.read();
        }
    }

    async menuForm(data = {}) {
        const url = this.url(AdminEndPoints.MENU_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);

        jQuery(this.input("menu-sorrend")).kendoNumericTextBox({
            format: "n0",
            decimals: 0,
            spinners: false
        });

        jQuery(this.input("menu-parent_id")).kendoDropDownList({
            filter: "contains",
            height: 400,
            valueTemplate: (data: { text: string }) => {
                return `${data.text.toString().replaceAll("-", `&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;`)}`;
            },
            template: (data: { text: string }) => {
                return `${data.text.toString().replaceAll("-", `&nbsp;<i class="fa fa-arrow-right"></i>&nbsp;`)}`;
            }
        })

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "menu") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });
    }

    async felhasznaloiJogokForm(data = {}): Promise<{ model: Object }> {
        const url = this.url(AdminEndPoints.FELHASZNALOI_JOGOK_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "felhasznaloijogok");
                resolve(response);
                popup.close();
            }
        })
    }

    async felhasznalokForm(data: Object = {}): Promise<{ success: boolean, errors: Array<any>, model: Object }> {
        const popup = new ClassFormpopup();
        const url = this.url(AdminEndPoints.FELHASZNALOK_FORM);
        popup.root.innerHTML = await this.fetchData(url, data);
        jQuery(this.input("felhasznalok-felhasznaloi_jog")).kendoDropDownList({
            filter: "contains",
        })
        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "felhasznalok") as ApiResponse;
                resolve(response);
                popup.close();
            }
        })
    }

    felhasznaloiJogokGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = this.url(AdminEndPoints.FELHASZNALOI_JOGOK);
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });


            const columns = felhasznaloiJogokColumns;
            jQuery(element).kendoGrid({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: "100%",
                pageable: {
                    refresh: true
                },
                sortable: true,
                dataBound: event => resolve(event.sender)
            })
        })
    }

    /**@type {kendo.ui.Grid} **/
    felhasznalokGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const schema = this.schema;
            const transport = this.transport;
            console.log(this.url(AdminEndPoints.FELHASZNALOK))
            transport.read.url = this.url(AdminEndPoints.FELHASZNALOK);
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = felhasznalokColumns;
            jQuery(element).kendoGrid({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: "100%",
                sortable: true,
                pageable: {
                    refresh: true
                },
                dataBound: event => resolve(event.sender)
            })
        })
    }

    menuGrid(element: HTMLDivElement): Promise<kendo.ui.TreeList> {
        return new Promise((resolve) => {
            const schema = this.schema;
            // @ts-ignore
            schema.model = {
                id: "id",
                parentId: "parent_id",
                expanded: true,
                fields: {
                    // @ts-ignore
                    parent_id: {nullable: true, field: "parent_id"}
                }
            }
            const transport = this.transport;
            transport.read.url = this.url(AdminEndPoints.MENU);
            const dataSource = new kendo.data.TreeListDataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = menuColumns;
            const observer = new ResizeObserver((entries) => {
                const kGridContent = element.querySelector(`div.k-grid-content`);
                if (kGridContent) {
                    (kGridContent as HTMLDivElement).style.height = `${element.closest(`div.admin-tab`)!.clientHeight - 204}px`
                    console.log(entries);
                    console.log({
                        heigh: element.clientHeight,
                        element: element,
                        parent: element.closest(`div.admin-tab`)
                    })
                }

            });
            observer.observe(element);
            jQuery(element).kendoTreeList({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: "100%",
                pageable: {
                    refresh: true
                },
                dataBound: event => resolve(event.sender)
            });
        })

    }

}