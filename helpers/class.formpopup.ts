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
        this.root.style.zIndex = `${this.maxZIndex + 1}`

        this.layer = document.createElement("div");
        this.layer.classList.add("form-popup-layer")

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


    close() {
        return new Promise<void>((resolve) => {
            this.root.ontransitionend = (event) => {
                if (event.propertyName == "top" || event.propertyName == "border-bottom-color") {
                    this.root.remove();
                    this.layer.remove();
                    resolve();
                    if (this.prev) {
                        this.prev.classList.remove("back");
                    }
                }
            }
            this.root.classList.remove("active");
        })

    }

}

