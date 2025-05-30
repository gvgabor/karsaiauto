import {ClassUtil} from "../../helpers/class.util";
import {ClassFormpopup} from "../../helpers/class.formpopup";


export enum detailEndPoint {
    AUTO_DETAIL = "AutoDetail",
}

export class ClassCardetail extends ClassUtil {

    private readonly autoId: Number = 0;
    private popup: ClassFormpopup | null = null;


    url(action: string): string {
        return `/index/${action}`;
    }

    constructor(autoId: Number) {
        super();
        this.autoId = autoId;
    }

    get carViewPopup() {
        return this.popup;
    }

    async showDetail(admin: boolean = false) {
        let url = this.url(detailEndPoint.AUTO_DETAIL);
        if (admin) {
            const adminUrl: URL = new URL(url, window.location.origin);
            adminUrl.searchParams.set("admin", "1");
            url = adminUrl.toString();
        }

        const width = Math.min(1200, document.body.offsetWidth);
        const popup = new ClassFormpopup("", "", width);
        this.popup = popup;
        popup.root.innerHTML = await this.fetchData(url, {id: this.autoId});


        document.querySelectorAll(`section`).forEach(item => item.classList.add("blur"));
        document.querySelectorAll(`nav`).forEach(item => item.classList.add("blur"));

        const formPopupLayer: HTMLDivElement = document.querySelector(`div.form-popup-layer`) as HTMLDivElement;
        formPopupLayer.style.cursor = "pointer";
        formPopupLayer.onclick = () => popup.close();

        const ypos = window.scrollY + 50;
        popup.root.classList.add("fixed");
        popup.root.style.setProperty("--ypos", `${ypos}px`);

        const slides = document.querySelectorAll('.simple-slider .slide');
        let idx = 0;
        slides[idx].classList.add("active");
        const thumbSlider = this.div("thumb-slider");
        const counterBox = this.div("counter-box");
        counterBox.innerHTML = `1/${slides.length}`

        const show = (newidx: number) => {
            slides.forEach(item => item.classList.remove("active"));
            idx = newidx;
            counterBox.innerHTML = `${newidx + 1}/${slides.length}`
            slides[idx].classList.add("active");
            thumbSlider.scrollTo({
                left: (thumbSlider.children[idx] as HTMLDivElement).offsetLeft - thumbSlider.offsetLeft,
                behavior: "smooth"
            })
        }

        const prevBtn = this.button("prev-btn");
        const nextBtn = this.button("next-btn");

        nextBtn.onclick = () => show(Math.min(idx + 1, slides.length - 1));
        prevBtn.onclick = () => show(Math.max(idx - 1, 0));


        const thumbSlideList: HTMLDivElement[] = Array.from(thumbSlider.querySelectorAll(`div.thumb-slide`)) as HTMLDivElement[];
        thumbSlideList.forEach(item => {
            item.onclick = () => {
                const index = Array.from(item.parentElement!.children).indexOf(item);
                show(index);
            }
        });

        thumbSlider.onwheel = (event) => {
            if (event.deltaY === 0) {
                return;
            }
            event.preventDefault();
            thumbSlider.scrollLeft += Math.trunc(event.deltaY);
        }

    }

}