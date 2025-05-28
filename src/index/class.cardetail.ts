import {ClassUtil} from "../../helpers/class.util";
import {ClassFormpopup} from "../../helpers/class.formpopup";


export enum detailEndPoint {
    AUTO_DETAIL = "AutoDetail",
}

export class ClassCardetail extends ClassUtil {

    private readonly autoId: Number = 0;


    url(action: string): string {
        return `/index/${action}`;
    }

    constructor(autoId: Number) {
        super();
        this.autoId = autoId;
    }

    async showDetail() {
        const url = this.url(detailEndPoint.AUTO_DETAIL);
        const width = Math.min(1200, document.body.offsetWidth);
        const popup = new ClassFormpopup("", "", width);
        popup.root.innerHTML = await this.fetchData(url, {id: this.autoId});

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

        const show = (newidx: number) => {
            slides.forEach(item => item.classList.remove("active"));
            idx = newidx;
            slides[idx].classList.add("active");
            thumbSlider.scrollTo({
                left: (thumbSlider.children[idx] as HTMLDivElement).offsetLeft - thumbSlider.offsetLeft,
                behavior: "smooth"
            })
            // thumbSlider.children[idx].scrollIntoView({behavior: "smooth"});
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