import type LocalizationInterface from "./LocalizationInterface";

const LocalizationUa:LocalizationInterface = {
    register:'Реєстрація',
    enter:"Увійти",
    delete:"Видалити",
    add:"Додати",
    edit:"Редагувати",
    validation:{
        fNameNull: "Ім'я не введено",
        lNameNull:"прізвище не введено",
        dobNull: "Дата народження не введена",
        dobIncorrect: "Дата народження введена некоректно",
        passwordNotRepeat: "Паролі не співпадають",
        passwordNull:"Пароль не введено"
    },
    errorCodes:{
        0:"Помилка мережі",
        1:"Помилка валідації",
        2:"Помилка запиту до БД",
        3:"Не знайдено",
        4:"Пароль введено невірно",
        5:"Неправильний формат введення",
        403:"Доступ заборонено",
        500:"Внутрішня помилка сервісу",
    }
}

export default LocalizationUa;