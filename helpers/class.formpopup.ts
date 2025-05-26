import {ClassUtil} from "./class.util";

export class ClassFormpopup extends ClassUtil {

    public readonly root: HTMLDivElement;
    public readonly layer: HTMLDivElement;
    public form!: HTMLFormElement;
    public prev: HTMLDivElement;

    constructor(title: string = "Karsai autó", content: string = "", width: number = 800) {
        super();

        this.prev = document.querySelector(`div.form-popup`) as HTMLDivElement;
        if (this.prev) {
            this.prev.classList.add("back");
        }


        this.root = document.createElement("div");
        this.root.classList.add("form-popup")
        this.root.style.width = `${width}px`

        this.layer = document.createElement("div");
        this.layer.classList.add("form-popup-layer")

        const style = document.createElement("style");
        // language=CSS
        style.innerText = this.style();

        document.head.appendChild(style);
        document.body.appendChild(this.layer);
        this.layer.style.zIndex = (this.maxZIndex + 1).toString();
        document.body.appendChild(this.root);
        this.root.style.zIndex = (this.maxZIndex + 1).toString();
        const observer = new MutationObserver(() => {
            const closeBox = this.root.querySelector(`div.close-box`);
            if (closeBox) {
                (closeBox as HTMLDivElement).onclick = () => this.close();
                (closeBox as HTMLDivElement).style.cursor = "pointer";
                this.form = this.root.querySelector(`form`)!;
                observer.disconnect();
            }

            requestAnimationFrame(() => this.root.classList.add("active"));
        });

        observer.observe(this.root, {
            childList: true,
        });
    }


    style() {
        return `.form-popup-layer {position: fixed;inset: 0;background: rgba(0, 0, 0, 0.2);}  .form-popup {background: transparent;position: absolute;top: 0;left: 50%;transition: 0.5s;transform: translateX(-50%);opacity: 0;pointer-events: none;}  .form-popup.back {transition-delay: 0.5s;transform: translateX(-52%) translateY(-10px);}  .form-popup > .card {opacity: 0;transition: 0.5s;}  .form-popup.active > .card {box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);border: none;opacity: 1;}  .form-popup.active {opacity: 1;top: 120px;pointer-events: all;}  .form-popup .card-footer {display: flex;justify-content: flex-end;}  .form-popup .close-box i {transition: 0.5s;}  .form-popup .close-box:hover i {color: red;transform: rotate(360deg) scale(1.5);} `
    }

    close() {
        this.root.ontransitionend = (event) => {
            if (event.propertyName == "top") {
                this.root.remove();
                this.layer.remove();
                if (this.prev) {
                    this.prev.classList.remove("back");
                }
            }
        }
        this.root.classList.remove("active");
    }

}

