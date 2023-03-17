import Requests from "./Requests";
import type {response} from "@/gateway/Interfaces/GeneralGatewayInterfaces";
import type {
    checkAuthResponse,
    emailEditItem,
    emailListResponseItem
} from "@/gateway/Interfaces/DashboardGatewayIntefaces";

class DashboardGateway extends Requests{
    private token = "";

    constructor(token:string) {
        super();
        this.token = token;
    }

    public formDataToken():FormData{
        const formData = new FormData();
        formData.append("token",this.token);
        return formData;
    }

    public checkAuth(token:string):Promise<response<checkAuthResponse>>{
        const formData = new FormData();
        formData.append("token",token);
        return this.executePost("/api/id/checkAuth",formData);
    }

    public getEmailList():Promise<response<emailListResponseItem[]>>{
        const formData = this.formDataToken();
        return this.executePost("/api/id/email/get",formData);
    }
    public getEmailItem(id:number):Promise<response<emailEditItem>>{
        const formData = this.formDataToken();
        formData.append("id",String(id));
        return this.executePost("/api/id/email/getItem",formData);

    }
    public addNewEmail(emailEncrypted:string,emailHash:string,allowAuth:boolean):Promise<response<emailListResponseItem[]>>{
        const formData = this.formDataToken();
        formData.append("emailEncrypted",emailEncrypted);
        formData.append("emailHash",emailHash);
        formData.append("allowAuth",allowAuth?"1":"0");
        return this.executePost("/api/id/email/add",formData);
    }

    public editEmailItem(id:number,emailEncrypted:string,emailHash:string,allowAuth:boolean):Promise<response<emailListResponseItem[]>>{
        const formData = this.formDataToken();
        formData.append("itemId",String(id));
        formData.append("emailEncrypted",emailEncrypted);
        formData.append("emailHash",emailHash);
        formData.append("allowAuth",allowAuth?"1":"0");
        return this.executePost("/api/id/email/add",formData);
    }

    public deleteEmail(id:number):Promise<response<emailListResponseItem[]>>{
        const formData = this.formDataToken();
        formData.append("id",String(id));
        return this.executePost("/api/id/email/delete",formData);
    }
}

export default DashboardGateway;