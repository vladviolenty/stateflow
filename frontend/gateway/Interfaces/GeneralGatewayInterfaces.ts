interface successResponse<T>{
    success:true,
    data:T
}

interface successResponseText{
    success:true,
    text:string
}

interface errorResponse{
    success:false,
    text:string,
    code:number
}

type response<T> = successResponse<T>|errorResponse
type responseText = successResponseText|errorResponse

export type {response,responseText}