import type LocalizationInterface from "./LocalizationInterface";

const LocalizationBy:LocalizationInterface = {
    register:'Рэгістрацыя',
    enter:"Увайсці",
    delete:"Выдаліць",
    add:"Выдаліць",
    edit:"Рэдагаваць",
    validation:{
        fNameNull: "Ім'я не ўведзена",
        lNameNull: "Прозвішча не ўведзена",
        dobNull:"Дата нараджэння не ўведзена",
        dobIncorrect: "Дата нараджэння ўведзена некарэктна",
        passwordNotRepeat: "Паролі не супадаюць",
        passwordNull: "Пароль не ўведзены"
    },
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