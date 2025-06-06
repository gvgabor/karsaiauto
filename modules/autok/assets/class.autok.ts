import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import Cleave from "cleave.js";
import {ClassUgyfelek, UgyfelekEndPoint} from "./class.ugyfelek";
import ObservableObject = kendo.data.ObservableObject;


declare const autokColumns: kendo.ui.GridColumn[];
declare const dokumentumokColumns: kendo.ui.GridColumn[];

export enum AutokEndPoints {
    AUTOK_FORM = "AutokForm",
    AUTOK = "Autok",
    REMOVE_AUTO = "RemoveAuto",
    TIPUS_UPLOAD = "upload",
    ELADVA_FORM = "EladvaForm",
    DOKUMENTUMOK_DATASOURCE = "DokumentumokDatasource",
    DETAIL = "Detail",
}

export class ClassAutok extends ClassUtil {
    async init() {
        const gridFilterSelector = jQuery(this.div("grid-filter-selector")).kendoButtonGroup({
            index: parseInt(localStorage.getItem("grid-filter-selector") || "0"),
            rounded: "none"
        }).data("kendoButtonGroup") as kendo.ui.ButtonGroup;
        const autokGrid = await this.autokGrid(this.div("autok-grid"));
        this.dataBound(autokGrid, () => {
            const grid = autokGrid;
            this.gridButtonList(grid, "remove-btn").forEach(item => {

                const dataItem = item.data as ObservableObject & {
                    id: number,
                    hirdetes_cime: string,
                    delete_text: string,
                    confirm_text: string,
                    eladva_int: number
                };
                item.button.disabled = dataItem.eladva_int == 1;
                item.button.onclick = async () => {
                    await this.confirm(dataItem.confirm_text, item.button);
                    const response = await this.fetchData(this.url(AutokEndPoints.REMOVE_AUTO), {id: dataItem.id});
                    if (response.success) {
                        grid.dataSource.remove(dataItem);
                        this.message(dataItem.delete_text);
                    }
                }
            });
            this.gridButtonList(grid, "edit-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & {
                    id: number,
                    hirdetes_cime: string,
                    edit_text: string,
                    eladva_int: number
                };

                if (dataItem.eladva_int) {
                    const icon = item.button.querySelector(`i`)!;
                    const newIcon = document.createElement(`i`);
                    newIcon.classList.add("fa-solid", "fa-database");
                    icon.replaceWith(newIcon);
                    item.row.classList.add("eladva");
                    item.button.onclick = () => {
                        this.autoDetail({id: dataItem.id});
                    }
                } else {
                    item.button.onclick = async () => {
                        const response = await this.autoForm({id: dataItem.id});
                        grid.dataSource.pushUpdate(response.model);
                        grid.dataSource.fetch();
                        this.message(dataItem.edit_text)
                    }
                }


            });
            this.gridButtonList(grid, "eladva-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { id: number, eladva_int: number };
                item.button.disabled = dataItem.eladva_int == 1;
                item.button.onclick = async () => {
                    const response = await this.eladvaForm({id: dataItem.id}) as ApiResponse;
                    this.message(response.message);
                    grid.dataSource.pushUpdate(response.model);
                }
            })
        });

        gridFilterSelector.bind("select", () => {
            localStorage.setItem("grid-filter-selector", gridFilterSelector.current().index().toString());
            autokGrid.dataSource.transport.options.read.data.gridFilterSelector = gridFilterSelector.current().index();
            autokGrid.dataSource.read();
        });

        gridFilterSelector.trigger("select");

        const createAutoBtn = this.button("create-auto-btn");
        createAutoBtn.onclick = async () => {
            const response = await this.autoForm();
            autokGrid.dataSource.pushInsert(0, response.model);

        }
    }

    async autoDetail(data = {}) {
        const url = this.url(AutokEndPoints.DETAIL);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        const detailTab = jQuery(this.div("detail-tab")).kendoTabStrip({
            animation: false
        }).data("kendoTabStrip") as kendo.ui.TabStrip;
        detailTab.select(0);
    }

    async eladvaForm(data = {}) {
        const url = this.url(AutokEndPoints.ELADVA_FORM);
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, data);
        ["eladasmodel-eladas_datuma"].forEach(id => {
            const element = document.getElementById(id)!;
            jQuery(element).kendoDatePicker({
                format: "yyyy-MM-dd",
            });
        });

        const ugyfelekDataSource = this.ugyfelekDataSource();
        const eladasmodelEladasUgyfelId = jQuery(this.input("eladasmodel-eladas_ugyfel_id")).kendoDropDownList({
            filter: "contains",
            height: 400,
            dataSource: ugyfelekDataSource,
            dataTextField: "nev",
            dataValueField: "id",
            optionLabel: "Kérem válasszon",
            autoBind: false
        }).data("kendoDropDownList") as kendo.ui.DropDownList;
        const ugyfelId = eladasmodelEladasUgyfelId.element[0].dataset.ugyfelId;
        if (ugyfelId) {
            // @ts-ignore
            eladasmodelEladasUgyfelId.dataSource.transport.options.read.data.ugyfelId = ugyfelId;
            eladasmodelEladasUgyfelId.value(ugyfelId);
        }
        eladasmodelEladasUgyfelId.dataSource.read();

        const ugyfelLetrehozasaBtn = this.button("ugyfel-letrehozasa-btn");
        ugyfelLetrehozasaBtn.onclick = async () => {
            const ugyfelek = new ClassUgyfelek();
            const response = await ugyfelek.ugyfelekForm();
            eladasmodelEladasUgyfelId.dataSource.pushInsert(0, response.model);
            const model = response.model;
            eladasmodelEladasUgyfelId.value(model.id);
        }

        const saveBtn = popup.root.querySelector(`button.save-btn`) as HTMLButtonElement;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                await this.confirm(popup.form.dataset.confirm || "", saveBtn);
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "eladasmodel") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });


    }

    ugyfelekDataSource() {
        const url = this.url(UgyfelekEndPoint.UGYFELEK);
        const schema = this.schema;
        const transport = this.transport;
        transport.read.url = url;
        const dataSource = new kendo.data.DataSource({
            pageSize: 100,
            transport: transport,
            schema: schema,
            serverPaging: true,
            serverFiltering: true,
        });
        return dataSource;
    }

    async autoForm(data = {}): Promise<ApiResponse> {
        const url = this.url(AutokEndPoints.AUTOK_FORM);
        const width: number = Math.min((document.body.offsetWidth - 120), 1600);
        const popup = new ClassFormpopup("", "", width);
        popup.root.innerHTML = await this.fetchData(url, data);
        const formTab: kendo.ui.TabStrip = jQuery(this.div("form-tab")).kendoTabStrip({
            animation: false
        }).data("kendoTabStrip") as kendo.ui.TabStrip;

        [
            "autokmodel-jarmutipus_id",
            "autokmodel-marka_id",
            "autokmodel-motortipus_id",
            "autokmodel-valto_id",
        ].forEach(id => {
            const element = document.getElementById(id)!;
            jQuery(element).kendoDropDownList({
                filter: "contains"
            })
        });

        [
            "autokmodel-kilometer",
            "autokmodel-teljesitmeny",
            "autokmodel-vetelar",
            "autokmodel-gyartasi_ev",
            "autokmodel-akcios_ar",
        ].forEach(id => {
            const element = document.getElementById(id)!;
            new Cleave(element, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                delimiter: ' ',              // szóköz a tagoláshoz (pl. 1 000 000)
                numeralDecimalMark: ',',     // opcionális, ha vesszős tizedes kell
                numeralDecimalScale: 0       // nulla tizedesjegy, ha csak egész szám kell
            });
        });

        [
            "autokmodel-muszaki_ervenyes"
        ].forEach(id => {
            const element = document.getElementById(id)!;
            jQuery(element).kendoDatePicker({
                format: "yyyy-MM",
                depth: "year",
                start: "year"
            })
        })

        formTab.select(0);
        const dokumentumokGrid = await this.dokumentumokGrid(this.div("dokumentumok-grid"));
        this.dataBound(dokumentumokGrid, () => {
            const grid = dokumentumokGrid;
            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject;
                item.button.onclick = async () => {
                    await this.confirm(item.button.parentElement!.dataset.deleteText || "", item.button);
                    grid.dataSource.remove(dataItem);
                }
            });
            this.gridButtonList(grid, "view-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & { dokumentumUrl: string, id: number };
                item.button.disabled = !dataItem.id;
                item.button.onclick = () => {
                    this.navigate(dataItem.dokumentumUrl, "_blank");
                }
            })
        });

        let kTabstripContent: HTMLDivElement = formTab.wrapper[0].querySelector(`div.k-tabstrip-content.k-active`)!;
        const uploadKepekBox = this.div("upload-kepek-box");
        const resizeObserver = new ResizeObserver(() => {
            kTabstripContent = formTab.wrapper[0].querySelector(`div.k-tabstrip-content.k-active`)!;
            uploadKepekBox.style.height = `${kTabstripContent.offsetHeight}px`;
        });

        resizeObserver.observe(kTabstripContent);


        const akciosArBox = this.div("akcios-ar-box");
        const akciosChk = this.input("autokmodel-akcios") as HTMLInputElement
        akciosChk.onchange = () => akciosChk.checked ? akciosArBox.classList.remove("d-none") : akciosArBox.classList.add("d-none");
        akciosChk.dispatchEvent(new Event("change"));


        const autokmodelDokumentumok = this.input("autokmodel-dokumentumok") as HTMLFormElement;

        autokmodelDokumentumok.onchange = () => {
            const files: File[] = autokmodelDokumentumok.files;
            Array.from(files).forEach(item => {
                const name = item.name.substring(0, item.name.lastIndexOf("."));
                const extension = item.name.substring(item.name.lastIndexOf(".") + 1);
                const dataItem = {
                    extension: extension,
                    name: name,
                    uploadName: item.name,
                    file: item,
                }
                dokumentumokGrid.dataSource.insert(0, dataItem);
            });
            autokmodelDokumentumok.value = "";
        }

        const autokImage = this.input("autokmodel-image") as HTMLFormElement;

        if (uploadKepekBox.dataset.images) {
            const images: Array<{
                id: string,
                name: string,
                image: "string"
            }> = JSON.parse(uploadKepekBox.dataset.images);
            images.forEach(item => {
                this.imageBox(uploadKepekBox, item.name, item.image).dataset.id = item.id;
            });
            this.showOrder(uploadKepekBox);
            this.sortImages(uploadKepekBox);
        }


        autokImage.onchange = () => {
            const files = autokImage.files;
            if (files) {
                const observer = new MutationObserver(() => {
                    const children = Array.from(uploadKepekBox.children) as HTMLDivElement[];
                    const childCount: number = children.reduce((carry, item) => {
                        if (item.dataset.tipus == AutokEndPoints.TIPUS_UPLOAD) {
                            carry++;
                        }
                        return carry;
                    }, 0);
                    if (files.length == childCount) {
                        children.forEach(item => item.removeAttribute("data-tipus"));
                        this.showOrder(uploadKepekBox);
                        observer.disconnect();
                    }
                });
                observer.observe(uploadKepekBox, {
                    childList: true
                });
                for (let i = 0; i < files.length; i++) {
                    const current = files[i];
                    const reader = new FileReader();
                    reader.onload = event => {
                        this.imageBox(uploadKepekBox, current.name, event.target?.result as string).dataset.tipus = AutokEndPoints.TIPUS_UPLOAD;
                    }
                    reader.readAsDataURL(current);
                }
                this.sortImages(uploadKepekBox);
            }
        }

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const sorrend = (Array.from(uploadKepekBox.children) as HTMLDivElement[]).map((item, index) => ({
                    index: index + 1,
                    name: item.dataset.name,
                    id: item.dataset.id,
                }));
                formData.append("sorrend", JSON.stringify(sorrend));
                const dokumentumok = dokumentumokGrid.dataSource.data().toJSON();
                formData.append("dokumentumok", JSON.stringify(dokumentumok));

                const dokumetumokFiles: File[] = dokumentumokGrid.dataSource.data().map((item: any) => (item as {
                    file: File
                }).file);

                dokumetumokFiles.forEach((file, index) => {
                    formData.append(`dokumetumokFiles[${index}]`, file);
                });

                const response = await this.fetchForm(url, formData, popup.form, "autokmodel") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });
    }


    dokumentumokGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const url = this.url(AutokEndPoints.DOKUMENTUMOK_DATASOURCE);
            const schema = this.schema;
            schema.model = {
                id: "id",
                fields: {
                    extension: {editable: false}
                }
            }
            const transport = this.transport;
            transport.read.url = url;
            transport.read.data.autokId = element.dataset.autokId;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            const columns = dokumentumokColumns;
            jQuery(element).kendoGrid({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: 800,
                pageable: {
                    refresh: false
                },
                editable: true,
                dataBound: event => resolve(event.sender),
                navigatable: true
            })
        });
    }

    sortImages(element: HTMLDivElement) {
        jQuery(element).kendoSortable({
            filter: ".image-item-box",
            cursor: "move",
            cursorOffset: {
                top: -80,
                left: -100
            },
            hint: (element: JQuery) => {
                const clone = element.clone().css({
                    width: "200px",
                    maxWidth: "200px",
                    height: "160px"
                }).addClass("drag-hint");
                clone.find("img").css({
                    width: "100%",
                    height: "100%",
                    objectFit: "cover",
                    display: "block"
                });
                return clone;
            },
            placeholder: (element: JQuery) => {
                return element.clone().css({
                    opacity: 0.3,
                    width: "200px",
                    height: "160px"
                }).addClass("placeholder").text("IDE JÖHET");
            },
            change: () => this.showOrder(element)
        })
    }

    showOrder(element: HTMLDivElement) {
        element.querySelectorAll(`div.image-item-box:not(.placeholder)`).forEach((element, index) => {
            const orderBox = element.querySelector(`div.order-box`);
            if (orderBox) {
                orderBox.innerHTML = (index + 1).toString();
            }
        })
    }

    imageBox(parent: HTMLDivElement, name: string, src: string) {
        const imageBox = document.createElement("div");
        imageBox.classList.add("image-item-box");
        imageBox.dataset.name = name;
        const image = document.createElement("img");
        const orderBox = document.createElement("div");
        orderBox.classList.add("order-box");
        image.src = src;
        const removeBox = document.createElement("div");
        removeBox.innerHTML = `<i class="fa-solid fa-trash-can"></i>`;
        removeBox.classList.add("remove-box")


        imageBox.appendChild(image);
        imageBox.appendChild(orderBox);
        imageBox.appendChild(removeBox);
        parent.appendChild(imageBox);

        removeBox.onclick = async () => {
            await this.confirm(`Biztosan törli a képet?`, removeBox);
            imageBox.remove();
            this.showOrder(parent);
        }

        return imageBox;
    }

    autokGrid(element: HTMLDivElement): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const url = this.url(AutokEndPoints.AUTOK);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema,
                serverPaging: true,
                serverFiltering: true,
            });
            const columns = autokColumns;
            columns.find(item => item.field == "vetelar")!.template = (data: {
                vetelar: string
            }) => `${kendo.toString(parseInt(data.vetelar), "n0")} Ft`
            const grid = jQuery(element).kendoGrid({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: "100%",
                pageable: {
                    refresh: true
                },
                autoBind: false,
            }).data("kendoGrid") as kendo.ui.Grid;
            resolve(grid);
        })
    }


}