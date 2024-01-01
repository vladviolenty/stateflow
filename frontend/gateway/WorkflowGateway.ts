import Requests from "@/gateway/Requests";

class WorkflowGateway extends Requests{
    public getMyOrg():Promise<any>{
        return this.executeGet("/api/workflow/getOrgList");
    }

    public getOrgItem(
        orgUUID:string
    ):Promise<any>{
        const formData = new FormData();
        formData.append("uuid",orgUUID);
        return this.executeGet("/api/workflow/getOrgItem");
    }

    public createNewOrg(
        name:string,
        genericId:string,
        publicFLNames:string,
        iv:string,
        salt:string,
        encryptedPassword:string,
        publicKey:string,
        encryptedPrivateKey:string,
        encryptedCreatedAt:string,
    ):Promise<any>{
        const formData = new FormData();
        formData.append("name",name);
        formData.append("genericId",genericId);
        formData.append("publicFLNames",publicFLNames);
        formData.append("iv",iv);
        formData.append("salt",salt);
        formData.append("encryptedPassword",encryptedPassword);
        formData.append("publicKey",publicKey);
        formData.append("encryptedPrivateKey",encryptedPrivateKey);
        formData.append("encryptedCreatedAt",encryptedCreatedAt);
        return this.executePost("/api/workflow/createOrg",formData);
    }
}

export default WorkflowGateway;