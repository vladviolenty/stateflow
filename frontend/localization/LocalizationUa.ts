import type LocalizationInterface from "./LocalizationInterface";

const LocalizationUa:LocalizationInterface = {
    register:'Реєстрація',
    enter:"Увійти",
    delete:"Видалити",
    add:"Додати",
    edit:"Редагувати",
    errorCodes:{
        0:"Внутрішня помилка сервісу",
        1:"Помилка валідації",
        2:"Помилка запиту до БД",
        3:"Не знайдено",
        4:"Пароль введено невірно",
        403:"Доступ заборонено",
    }
}

export default LocalizationUa;