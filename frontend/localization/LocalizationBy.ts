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
        emailNull: "Email не ўведзены",
        phoneNull: "тэлефон не ўведзены",
        emailIncorrect: "Email уведзены некарэктна",
        phoneIncorrect: "тэлефон уведзены некарэктна",
        dobIncorrect: "Дата нараджэння ўведзена некарэктна",
        passwordNotRepeat: "Паролі не супадаюць",
        passwordNull: "Пароль не ўведзены"
    },
    services:"Сэрвісы",
    welcome: "Сардэчна запрашаем",
    profile:"Профіль",
    allowAuth: "Дазволіць аўтарызацыю",
    configure:{
        phone: "Настройка тэлефонаў",
        email: "Настройка email адрасоў",
        session: "Кіраванне сесіямі"
    },
    errorCodes:{
        0:"Памылка сеткі",
        1:"Памылка валідацыі",
        2:"Памылка запыту да БД",
        3:"Не знойдзена",
        4:"Пароль уведзены няправільна",
        5:"Няправільны фармат уводу",
        403:"Доступ забаронены",
        500:"Унутраная памылка сэрвісу",

    }
}

export default LocalizationBy;