import type LocalizationInterface from "@/localization/LocalizationInterface";

const LocalizationEn:LocalizationInterface = {
    register:'Register',
    enter:"Sign in",
    delete:"Delete",
    add:"Add",
    edit:"Edit",
    errorCodes:{
        0:"Внутренняя ошибка сервиса",
        1:"Validation Error",
        2:"Ошибка запроса к БД",
        3:"Not found",
        4:"Incorrect password",
        403:"Access deninded",
    }
}

export default LocalizationEn;