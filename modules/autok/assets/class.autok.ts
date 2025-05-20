import {ApiResponse, ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";


export enum AutokEndPoints {
    AUTOK_FORM = "AutokForm"
}

export class ClassAutok extends ClassUtil {
    init() {
        const createAutoBtn = this.button("create-auto-btn");
        createAutoBtn.onclick = () => {
            this.autoForm();
        }
    }

    async autoForm(data = {}) {
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
        // const kepekList = this.kepekList(this.div("kepek-list"));
        const uploadKepekBox = this.div("upload-kepek-box");

        const autokImage = this.input("autok-image") as HTMLFormElement;
        autokImage.onchange = () => {
            const files = autokImage.files;
            uploadKepekBox.innerHTML = "";
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const current = files[i];
                    const reader = new FileReader();
                    reader.onload = event => {
                        const imageBox = document.createElement("div");
                        imageBox.classList.add("image-item-box")
                        const image = document.createElement("img");
                        image.src = event.target?.result as string;
                        imageBox.appendChild(image);
                        uploadKepekBox.appendChild(imageBox);
                    }
                    reader.readAsDataURL(current);
                }

            }
        }

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`)!;
        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "markak") as ApiResponse;
                resolve(response)
                popup.close();
            }
        });
    }

    kepekList(element: HTMLDivElement): kendo.ui.ListView {
        const kepekList = jQuery(element).kendoListView({
            template: function (data: any) {
                console.log(data);
                return "alma";
            }
        }).data("kendoListView");
        return kepekList;
    }

}