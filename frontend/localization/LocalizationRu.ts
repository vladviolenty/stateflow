import type LocalizationInterface from "./LocalizationInterface";

const LocalizationRu:LocalizationInterface = {
    register:'Регистрация',
    enter:"Войти",
    delete:"Удалить",
    next:"Далее",
    add:"Добавить",
    edit:"Редактировать",
    validation:{
        fNameNull:"Имя не введено",
        lNameNull:"Фамилия не введена",
        dobNull:"Дата рождения не введена",
        emailNull:"Email не введен",
        phoneNull:"Телефон не введен",
        emailIncorrect:"Email введен некорректно",
        phoneIncorrect:"Телефон введен некорректно",
        dobIncorrect:"Дата рождения введена некорректно",
        passwordNull:"Пароль не введён",
        passwordNotRepeat:"Пароли не совпадают",
    },
    services:"Сервисы",
    welcome:"Добро пожаловать",
    profile:"Профиль",
    allowAuth:"Разрешить авторизацию",
    configure:{
        phone:"Настройка телефонов",
        email:"Настройка email адресов",
        session:"Управление сессиями"
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