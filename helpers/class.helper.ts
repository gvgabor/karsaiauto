export class ClassHelper {

    static init() {
        alert("OK");
    }

    static maxZIndex(): number {
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


    static navigate(url: string, target: string = "_self"): void {
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

}