import type LocalizationInterface from "./LocalizationInterface";

const LocalizationBy:LocalizationInterface = {
    register:'Рэгістрацыя',
    enter:"Увайсці",
    delete:"Выдаліць",
    add:"Выдаліць",
    edit:"Рэдагаваць",
    errorCodes:{
        0:"Унутраная памылка сэрвісу",
        1:"Памылка валідацыі",
        2:"Памылка запыту да БД",
        3:"Не знойдзена",
        4:"Пароль уведзены няправільна",
        403:"Доступ забаронены",
    }
}

export default LocalizationBy;