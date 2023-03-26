import type LocalizationInterface from "./LocalizationInterface";

const LocalizationEn:LocalizationInterface = {
    register:'Register',
    enter:"Sign in",
    delete:"Delete",
    add:"Add",
    edit:"Edit",
    validation:{
        fNameNull:"First name is not entered",
        lNameNull:"Surname not entered",
        dobNull:"Date of birth not entered",
        dobIncorrect:"Date of birth entered incorrectly",
        passwordNotRepeat:"Passwords don't match",
        passwordNull:"Password not entered"
    },
    errorCodes:{
        0:"Network error",
        1:"Validation Error",
        2:"Error request to database",
        3:"Not found",
        4:"Incorrect password",
        5:"Invalid input format",
        403:"Access denied",
        500:"Internal server error",
    }
}

export default LocalizationEn;