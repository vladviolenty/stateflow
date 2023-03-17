import type LocalizationInterface from "./LocalizationInterface";

const LocalizationRu:LocalizationInterface = {
    register:'Регистрация',
    enter:"Войти",
    delete:"Удалить",
    add:"Добавить",
    edit:"Редактировать",
    errorCodes:{
        0:"Внутренняя ошибка сервиса",
        1:"Ошибка валидации",
        2:"Ошибка запроса к БД",
        3:"Не найдено",
        4:"Пароль введен неверно",
        403:"Доступ запрещён",
    }
}

export default LocalizationRu;