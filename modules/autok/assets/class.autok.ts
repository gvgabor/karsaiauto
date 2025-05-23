import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";
import ObservableObject = kendo.data.ObservableObject;


declare const autokColumns: kendo.ui.GridColumn[];

export enum AutokEndPoints {
    AUTOK_FORM = "AutokForm",
    AUTOK = "Autok",
    REMOVE_AUTO = "RemoveAuto",
    TIPUS_UPLOAD = "upload",
}

export class ClassAutok extends ClassUtil {
    async init() {
        const autokGrid = await this.autokGrid(this.div("autok-grid"));

        this.dataBound(autokGrid, () => {
            const grid = autokGrid;
            this.gridButtonList(grid, "remove-btn").forEach(item => {
                const dataItem = item.data as ObservableObject & {
                    id: number,
                    hirdetes_cime: string,
                    delete_text: string,
                    confirm_text: string,
                };
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
                    edit_text: string
                };
                item.button.onclick = async () => {
                    const response = await this.autoForm({id: dataItem.id});
                    grid.dataSource.pushUpdate(response.model);
                    this.message(dataItem.edit_text)
                }
            });
        })

        const createAutoBtn = this.button("create-auto-btn");
        createAutoBtn.onclick = async () => {
            const response = await this.autoForm();
            autokGrid.dataSource.pushInsert(0, response.model);

        }
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
            "autok-jarmutipus_id",
            "autok-marka_id",
            "autok-motortipus_id",
            "autok-valto_id",
        ].forEach(id => {
            const element = document.getElementById(id)!;
            jQuery(element).kendoDropDownList({
                filter: "contains"
            })
        });

        [
            "autok-kilometer",
            "autok-teljesitmeny",
            "autok-vetelar",
            "autok-gyartasi_ev",
        ].forEach(id => {
            const element = document.getElementById(id)!;
            jQuery(element).kendoNumericTextBox({
                decimals: 0,
                format: "n0",
            })
        });

        [
            "autok-muszaki_ervenyes"
        ].forEach(id => {
            const element = document.getElementById(id)!;
            jQuery(element).kendoDatePicker({
                format: "yyyy-MM",
                depth: "year",
                start: "year"
            })
        })

        formTab.select(0);
        const kTabstripContent: HTMLDivElement = formTab.wrapper[0].querySelector(`div.k-tabstrip-content`)!;
        const uploadKepekBox = this.div("upload-kepek-box");
        const resizeObserver = new ResizeObserver(() => {
            uploadKepekBox.style.height = `${kTabstripContent.offsetHeight}px`;
        });

        resizeObserver.observe(kTabstripContent);


        const autokImage = this.input("autok-image") as HTMLFormElement;

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
                const response = await this.fetchForm(url, formData, popup.form, "autok") as ApiResponse;
                resolve(response)
                popup.close();
            }
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