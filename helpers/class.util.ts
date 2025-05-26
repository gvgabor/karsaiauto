import ObservableObject = kendo.data.ObservableObject;


export interface ApiResponse<T = any> {
    success: boolean;
    errors: any[];
    message: string;
    model: T;
}

export interface GridDataItem {
    button: HTMLButtonElement,
    row: HTMLTableRowElement,
    data: ObservableObject
}

declare const yii: {
    getCsrfToken: () => string;
};

export class ClassUtil {


    url(action: string) {
        const endPoint = (window.location.origin + window.location.pathname).replace(/\/+$/, '');
        return `${endPoint}/${action}`;
    }


    get schema() {
        return {
            model: {
                id: "id",
                fields: {}
            },
            data: (response: any) => response.data || [],
            total: (response: any) => response.total || 0
        };
    }


    input(id: string) {
        return document.getElementById(id) ?? document.createElement("button");
    }


    message(text: string) {

        const oldItems: HTMLDivElement[] = Array.from(document.querySelectorAll(`div.message-box`));
        const currentPosition = oldItems.reduce((carry) => {
            carry += 90;
            return carry;
        }, 50);


        const messageBox = document.createElement("div");
        messageBox.classList.add("message-box");
        const now = new Date();
        const timeString = now.toLocaleTimeString('hu-HU', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });

        messageBox.style.zIndex = (this.maxZIndex + 1).toString();
        messageBox.innerHTML = text + "&nbsp;" + timeString;
        messageBox.style.top = `${currentPosition}px`;
        document.body.appendChild(messageBox);
        messageBox.ontransitionend = () => {

        }


        requestAnimationFrame(() => messageBox.classList.add("active"));
        messageBox.onclick = () => {
            messageBox.ontransitionend = () => messageBox.remove();
            messageBox.classList.remove("active");
        }

        setTimeout(() => {
            messageBox.ontransitionend = () => messageBox.remove();
            messageBox.classList.remove("active");
        }, 3000);

    }

    /**
     *
     * @param {string} model
     * @param {HTMLFormElement} form
     * @param {Object} errors
     */
    showFormError(model: string, form: HTMLFormElement, errors: Array<any>) {

        form.querySelectorAll(`div.error-box`).forEach(item => item.remove());

        for (const [key, value] of Object.entries(errors)) {
            /**@type {HTMLDivElement | null} **/
            const fieldBox: HTMLDivElement | null = form.querySelector(`div.field-${model}-${key}`) as HTMLDivElement | null;
            const errorBox = document.createElement("div");
            errorBox.classList.add("error-box");
            errorBox.style.zIndex = (this.maxZIndex + 1).toString();
            errorBox.innerHTML = value[0];
            if (fieldBox) {
                fieldBox.appendChild(errorBox);
                requestAnimationFrame(() => errorBox.classList.add("show"));
            }
        }
    }

    gridButtonList(grid: kendo.ui.Grid, className: string) {
        const buttonList = Array.from(grid.wrapper[0].querySelectorAll(`button.${className}`) as NodeListOf<HTMLButtonElement>);

        return buttonList.map(item => {
            const row = item.closest('tr')!
            const data = grid.dataItem(row);
            const gridDataItem: GridDataItem = {
                button: item,
                row: row,
                data: data,
            }
            return gridDataItem;
        })
    }

    async fetchDelete(url: string, id: number) {
        const response = await fetch(`${url}/${id}`, {
            method: "DELETE",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": yii.getCsrfToken(),
            },
        });

        let responseData;

        try {
            responseData = await response.json();
        } catch (e) {
            responseData = null;
        }

        if (response.status == 200) {
            return responseData;
        } else {
            const message = responseData?.message || "Sikertelen törlés";
            throw new Error(message);
        }

    }

    async fetchForm(url: string, formData: globalThis.FormData, form: HTMLFormElement | null = null, modelName: string | null = null, addlayer = true): Promise<ApiResponse> {

        return new Promise(resolve => {

            const formPopup: HTMLDivElement | null = document.querySelector(`div.form-popup`);
            if (formPopup) {
                const loader = document.createElement("div");
                loader.classList.add("loader");
                loader.style.zIndex = (this.maxZIndex + 1).toString();
                loader.innerHTML = `˛<img alt="nincs" src="/images/YTup.gif">`;
                formPopup.appendChild(loader);
            }


            const success = [200, 201, 202];
            const layer = document.createElement("div");
            if (addlayer) {
                layer.classList.add("popup-layer");
                layer.style.zIndex = (this.maxZIndex + 1).toString();
                document.body.appendChild(layer);
                layer.classList.add("animate");
            }

            formData.append("_csrf", yii.getCsrfToken());
            let status: number;
            fetch(url, {
                method: "POST",
                body: formData
            }).then(response => {
                if (layer) {
                    layer.remove();
                    document.querySelectorAll(`div.loader`).forEach(item => item.remove());
                }
                status = response.status;
                const contentType = response.headers.get("Content-Type") || "";
                if (contentType.includes("application/json")) {
                    return response.json();
                } else {
                    throw new Error("A válasz nem JSON formátumú.");
                }
            }).then(data => {
                if (success.includes(status)) {
                    resolve(data);
                } else {
                    if (modelName && form) {
                        this.showFormError(modelName, form, data.errors);
                    }
                }
            })
        });
    }

    async fetchData(url: string, data: Object = {}, addlayer = true) {
        const def = jQuery.Deferred();
        const formData = new FormData();
        const layer = document.createElement("div");

        if (addlayer) {
            layer.classList.add("popup-layer");
            layer.style.zIndex = (this.maxZIndex + 1).toString();
            document.body.appendChild(layer);
            layer.classList.add("animate");
        }

        formData.append("_csrf", yii.getCsrfToken());
        for (const [key, value] of Object.entries(data)) {
            formData.append(key, value);
        }

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // Ezzel mondjuk meg, hogy ajax kérés
            },
            body: formData,
            method: "POST"
        });
        const status = response.status;

        if (status == 403) {
            alert(await response.text());
            document.querySelectorAll(`div.form-popup-layer`).forEach(item => item.remove());
            document.querySelectorAll(`div.form-popup`).forEach(item => item.remove());
            if (layer) {
                layer.remove();
            }
            return false;
        }


        let responseData;
        const contentType = response.headers.get("content-type");

        if (typeof contentType === "string" && contentType.includes("application/json")) {
            responseData = await response.json();
        } else {
            responseData = await response.text();
        }

        if (layer) {
            layer.remove();
        }

        def.resolve(responseData);
        return def;
    }

    urlPart(action: string): string {
        const path = new URL(window.location.href);
        const pathmame = path.pathname;
        return `${pathmame}/${action}`;
    }

    /**
     * @return {Object}
     */
    get transport(): {
        read: {
            type: string;
            url: string | null;
            data: { [key: string]: any };
            dataType: string;
        }
    } {
        const data: { [key: string]: any } = {};
        data._csrf = yii.getCsrfToken(); // Feltételezi, hogy a "yii" globális objektumot használhatja
        return {
            read: {
                type: "POST",
                url: null, // Alapértelmezett érték null
                data: data,
                dataType: "json"
            }
        };
    }


    confirm(text: string, element: HTMLElement) {
        const def = jQuery.Deferred();
        const popover = jQuery(element).kendoPopover({
            body: () => {
                return `<div class="confirm-body"><div>${text}</div><div><button class="btn btn-primary btn" data-name="no-btn">Nem</button><button class="btn btn-danger btn" data-name="yes-btn">Igen</button></div></div>`
            },
            position: "left",
            header: () => {
                return "Megerősítés"
            },
            showOn: "click",
            show: event => {
                const noBtn = event.sender.popup.element?.[0]?.querySelector(`button[data-name="no-btn"]`) as HTMLElement;
                if (noBtn) {
                    noBtn.onclick = () => {
                        event.sender.hide();
                    };
                }
                const yesBtn = event.sender.popup.element?.[0]?.querySelector(`button[data-name="yes-btn"]`) as HTMLElement;
                if (yesBtn) {
                    yesBtn.onclick = () => {
                        def.resolve();
                        event.sender.hide();
                    };
                }
            },
            hide: () => {
                document.body.querySelectorAll(`div.confirm-body`).forEach(item => {
                    item.closest(`div.k-animation-container`)?.remove();
                })
            }
        }).data("kendoPopover");

        if (popover) {
            // @ts-ignore
            popover.show();
        }
        return def;
    }

    button(id: string): HTMLButtonElement {
        return document.getElementById(id) as HTMLButtonElement;
    }

    div(id: string): HTMLDivElement {
        return document.getElementById(id) as HTMLDivElement;
    }

    async delete(url: string, id: string | number): Promise<any> {
        const urlWithParams = new URL(window.location.origin + "/" + this.pascalToKebab(url));
        urlWithParams.searchParams.append("id", id.toString());

        try {
            const response = await fetch(urlWithParams.toString(), {
                method: "DELETE",
                headers: {
                    'X-CSRF-Token': yii.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                // A hibát előbb naplózzuk, majd kidobjuk újra (felsőbb rétegek számára biztosítva)
                console.error("Hiba a válaszban:", data.message || 'Ismeretlen hiba történt.');
                // throw new Error(data.message || 'Ismeretlen hiba történt.');
            }

            return data;
        } catch (error: any) {
            console.error("DELETE hiba:", error.message);
            // Továbbadjuk a hibát
            throw error;
        }
    }

    get maxZIndex(): number {
        let maxZ = 0;
        const elements = document.getElementsByTagName('*');

        for (let i = 0; i < elements.length; i++) {
            const z = window.getComputedStyle(elements[i]).zIndex;
            const zIndex = parseInt(z, 10);
            if (!isNaN(zIndex)) {
                maxZ = Math.max(maxZ, zIndex);
            }
        }

        return maxZ;
    }

    navigate(url: string, target: string = "_self"): void {
        const link = document.createElement("a");
        link.href = url;
        document.body.appendChild(link);
        link.target = target;
        link.click();
        link.remove();
    }

    pascalToKebab(str: string): string {
        return str.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
    }

    /**
     * @param element HTML elem
     * @param url adat URL
     * @param autoBind automatikus kötés
     * @param columns
     * @return {Promise<kendo.ui.Grid>}
     */
    grid(element: HTMLDivElement, url: string, autoBind: boolean = true, columns = []): Promise<kendo.ui.Grid> {
        return new Promise((resolve) => {
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });


            const grid = jQuery(element).kendoGrid({
                columns: columns,
                dataSource: dataSource,
                filterable: this.filterable,
                height: "100%",
                pageable: {
                    refresh: true
                },
                autoBind: autoBind,
            }).data("kendoGrid");

            if (!grid) {
                throw new Error("Failed to initialize kendoGrid.");
            }

            if (autoBind) {
                grid.bind("dataBound", () => resolve(grid));
            } else {
                resolve(grid);
            }
        });
    }

    get filterable() {
        return {
            extra: false,
            operators: {
                string: {
                    contains: "Tartalmazza",
                    eq: "Egyenlő"
                }
            }
        };
    }

    /**
     * @param grid kendo grid objektum
     * @param callback hívási vissza
     * @param call hívható
     */
    dataBound(grid: kendo.ui.Grid | kendo.ui.TreeList, callback: () => void, call: boolean = true): void {
        grid.bind("dataBound", callback);
        if (call) {
            callback();
        }
    }
}