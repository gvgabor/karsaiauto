import {ClassUtil} from "../../helpers/class.util";


export enum LandingEndPoint {
    AKCIOS_DATASOURCE = "AkciosDatasource",
    TYPE_AKCIOS = 1,
    TYPE_KIEMELT = 2,
}

export class ClassLanding extends ClassUtil {
    async init() {
        const akciosAutokList = await this.akciosAutokList(this.div("akcios-autok-list"), LandingEndPoint.TYPE_AKCIOS);
        console.log("=>(class.landing.ts:13) akciosAutokList", akciosAutokList);
        const kiemeltAutokList = await this.akciosAutokList(this.div("kiemelt-autok-list"), LandingEndPoint.TYPE_KIEMELT);
        console.log("=>(class.landing.ts:15) kiemeltAutokList", kiemeltAutokList);
    }


    url(action: string): string {
        return `/index/${action}`;
    }


    akciosAutokList(element: HTMLElement, type: number): Promise<kendo.ui.ListView> {

        return new Promise((resolve) => {
            const url = this.url(LandingEndPoint.AKCIOS_DATASOURCE);
            const schema = this.schema;
            const transport = this.transport;
            transport.read.url = url;
            transport.read.data.type = type;
            const dataSource = new kendo.data.DataSource({
                pageSize: 100,
                transport: transport,
                schema: schema
            });
            jQuery(element).kendoListView({
                template: (data: any) => data.template,
                dataSource: dataSource,
                dataBound: event => resolve(event.sender)
            })
        })


    }

}