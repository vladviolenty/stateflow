abstract class Requests{
    /* eslint-disable-next-line @typescript-eslint/no-explicit-any */
    protected executeGet(url:string):Promise<any>{
        return fetch(url,{
            method:"GET",
            credentials:"include"
        }).then(response=>response.json())
    }
    /* eslint-disable-next-line @typescript-eslint/no-explicit-any */
    protected executePost(url:string,params:FormData):Promise<any>{
        return fetch(url,{
            method:"POST",
            credentials:"include",
            body:params
        }).then(response=>response.json())
    }
}

export default Requests;