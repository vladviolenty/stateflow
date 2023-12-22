import Requests from "@/gateway/Requests";

class WorkflowGateway extends Requests{
    public createNewOrg(
        name:string,
        genericId:string,
        publicFLNames:boolean,
        iv:string,
        salt:string,
        encryptedPassword:string,
        publicKey:string,
        encryptedPrivateKey:string,
    ):Promise<any>{
        const formData = new FormData();
        formData.append("name",name);
        formData.append("genericId",genericId);
        formData.append("publicFLNames",publicFLNames?"1":"0");
        formData.append("iv",iv);
        formData.append("salt",salt);
        formData.append("encryptedPassword",encryptedPassword);
        formData.append("publicKey",publicKey);
        formData.append("encryptedPrivateKey",encryptedPrivateKey);

        return this.executePost("/api/workflow/createOrg",formData);

    }
}

export default WorkflowGateway;