import type LocalizationInterface from "./LocalizationInterface";

const LocalizationRu:LocalizationInterface = {
    register:'Регистрация',
    enter:"Войти",
    delete:"Удалить",
    add:"Добавить",
    edit:"Редактировать",
    validation:{
        fNameNull:"Имя не введено",
        lNameNull:"Фамилия не введена",
        dobNull:"Дата рождения не введена",
        dobIncorrect:"Дата рождения введена некорректно",
        passwordNull:"Пароль не введён",
        passwordNotRepeat:"Пароли не совпадают",
    },
    errorCodes:{
        0:"Ошибка сети",
        1:"Ошибка валидации",
        2:"Ошибка запроса к БД",
        3:"Не найдено",
        4:"Пароль введен неверно",
        5:"Неверный формат ввода",
        403:"Доступ запрещён",
        500:"Внутренняя ошибка сервиса",
    }
}

export default LocalizationRu;