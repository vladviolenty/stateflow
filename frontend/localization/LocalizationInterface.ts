import type {errorCodeList} from "@/localization/CustomInterfaces";

interface LocalizationInterface{
    register:string,
    enter:string,
    delete:string,
    add:string,
    edit:string,
    validation:{
        fNameNull:string,
        lNameNull:string,
        dobNull:string,
        dobIncorrect:string,
        passwordNull:string
        passwordNotRepeat:string,
    },
    errorCodes:Record<errorCodeList,string>
}

export default LocalizationInterface;