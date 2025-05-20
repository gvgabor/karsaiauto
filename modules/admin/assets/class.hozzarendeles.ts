import {ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import TreeListModel = kendo.data.TreeListModel;

declare const hozzarendelesMenuColumns: kendo.ui.TreeListColumn[];
declare const hozzarendelveMenuColumns: kendo.ui.TreeListColumn[];

export class ClassHozzarendeles extends ClassUtil {


    async hozzarendelesForm(felhasznaloiJogId: number, url: string) {
        const popup = new ClassFormpopup("", "", 1200);
        popup.root.innerHTML = await this.fetchData(url, {id: felhasznaloiJogId});
        const menuElemekGrid = await this.menuElemekGrid(this.div("menu-elemek-grid"), hozzarendelesMenuColumns);
        const hozzarendeltElemekGrid = await this.menuElemekGrid(this.div("hozzarendelt-elemek-grid"), hozzarendelveMenuColumns, felhasznaloiJogId);

        await menuElemekGrid.dataSource.read();
        await hozzarendeltElemekGrid.dataSource.read();


        this.dataBound(menuElemekGrid, () => {
            const grid = menuElemekGrid;
            Array.from(grid.wrapper[0].querySelectorAll(`td[data-name="hozzaad-td"]`) as NodeListOf<HTMLTableCellElement>).forEach(cell => {
                const row = cell.closest("tr")!;
                const dataItem = grid.dataItem(row) as TreeListModel & { id: number, hasChild: boolean }
                const dataSource: kendo.data.TreeListDataSource = grid.dataSource as kendo.data.TreeListDataSource;
                const nodes = dataSource.childNodes(dataItem);
                const parentList: Array<any> = [];
                let parentNodes = dataSource.parentNode(dataItem);

                while (parentNodes) {
                    parentList.push(parentNodes);
                    parentNodes = dataSource.parentNode(parentNodes);
                }


                if (nodes.length != 0) {
                    cell.innerHTML = ``;
                } else {
                    cell.innerHTML = `<button class="btn btn-warning edit-btn"><i class="fa-solid fa-arrow-right-long"></i></button>`;
                    cell.onclick = async () => {
                        hozzarendeltElemekGrid.dataSource.add(dataItem);
                        parentList.forEach(item => {
                            if (!hozzarendeltElemekGrid.dataSource.get(item.id)) {
                                hozzarendeltElemekGrid.dataSource.add(item);
                            }
                        })
                        hozzarendeltElemekGrid.dataSource.fetch();
                    }
                }
            });
        });
        this.dataBound(hozzarendeltElemekGrid, () => {
            const grid = hozzarendeltElemekGrid;
            Array.from(grid.wrapper[0].querySelectorAll(`td[data-name="hozzaad-td"]`) as NodeListOf<HTMLTableCellElement>).forEach(cell => {
                const row = cell.closest("tr")!;
                const dataItem = grid.dataItem(row) as TreeListModel & { id: number, hasChild: boolean }
                const dataSource: kendo.data.TreeListDataSource = grid.dataSource as kendo.data.TreeListDataSource;
                const nodes = dataSource.childNodes(dataItem);
                if (nodes.length != 0) {
                    cell.innerHTML = ``;
                } else {
                    cell.innerHTML = `<button class="btn btn-warning edit-btn"><i class="fa-solid fa-arrow-left-long"></i></button>`;
                    cell.onclick = async () => {
                        grid.dataSource.remove(dataItem);
                        await grid.dataSource.fetch();
                        this.filterGrid(grid, menuElemekGrid);
                    }
                }
            });
            this.filterGrid(grid, menuElemekGrid);
        });

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData();
                const menuIdList = hozzarendeltElemekGrid.dataSource.data().toJSON().map(item => item.id);
                formData.append("felhasznaloiJogId", felhasznaloiJogId.toString());
                formData.append("menuIdList", JSON.stringify(menuIdList));
                formData.append("action", "1");
                await this.fetchForm(url, formData);
                popup.close();
            }
        })
    }

    filterGrid(hozzarendeltElemekGrid: kendo.ui.TreeList, menuElemekGrid: kendo.ui.TreeList) {
        const idList: Array<number> = [...hozzarendeltElemekGrid.dataSource.data().toJSON()].map(item => item.id);
        const filter = {
            logic: "and",
            filters: [] as Array<{ field: string, operator: string, value: number }>
        }
        idList.forEach(item => {
            filter.filters.push({field: "id", operator: "neq", value: item});
        })
        menuElemekGrid.dataSource.filter(filter);
        menuElemekGrid.dataSource.fetch();
    }


    menuElemekGrid(element: HTMLDivElement, columns: Array<kendo.ui.TreeListColumn>, felhasznaloiJogId: number | null = null): Promise<kendo.ui.TreeList> {
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
            transport.read.url = this.url("Menu");
            transport.read.data.felhasznaloiJogId = felhasznaloiJogId;
            const height = element.parentElement!.clientHeight
            const dataSource = new kendo.data.TreeListDataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const grid = jQuery(element).kendoTreeList({
                columns: columns,
                dataSource: dataSource,
                filterable: true,
                pageable: {
                    refresh: true
                },
                autoBind: false,
                scrollable: true,
                height: height
            }).data("kendoTreeList");
            resolve(grid!);
        })


    }

}