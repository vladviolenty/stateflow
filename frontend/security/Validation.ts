class Validation{
    public isEmail(value:string):boolean{
        const result = value.match(/^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$/);
        return result!==null;
    }
}

export default new Validation();