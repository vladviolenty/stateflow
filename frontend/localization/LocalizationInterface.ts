import type {errorCodeList} from "./CustomInterfaces";

interface LocalizationInterface{
    register:string,
    enter:string,
    next:string,
    delete:string,
    add:string,
    edit:string,
    validation:{
        fNameNull:string,
        lNameNull:string,
        dobNull:string,
        emailNull:string,
        phoneNull:string,
        phoneIncorrect:string,
        emailIncorrect:string,
        dobIncorrect:string,
        passwordNull:string
        passwordNotRepeat:string,
    },
    services:string,
    welcome:string,
    profile:string,
    allowAuth:string,
    configure:{
        phone:string,
        email:string,
        session:string
    }
    errorCodes:Record<errorCodeList,string>
}

export default LocalizationInterface;