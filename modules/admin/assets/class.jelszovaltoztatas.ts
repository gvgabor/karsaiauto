import {ClassUtil} from "../../../helpers/class.util";
import {ClassFormpopup} from "../../../helpers/class.formpopup";

export class ClassJelszovaltoztatas extends ClassUtil {

    async valtoztatasForm(felhasznaloId: number, url: string) {
        const popup = new ClassFormpopup();
        popup.root.innerHTML = await this.fetchData(url, {id: felhasznaloId});

        const saveBtn: HTMLButtonElement = popup.root.querySelector(`button.save-btn`) as HTMLButtonElement;

        return new Promise((resolve) => {
            saveBtn.onclick = async () => {
                const formData = new FormData(popup.form);
                const response = await this.fetchForm(url, formData, popup.form, "felhasznalok", true);
                resolve(response);
                popup.close();
            }
        })
    }

}