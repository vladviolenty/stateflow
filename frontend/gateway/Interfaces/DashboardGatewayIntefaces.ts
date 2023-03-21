interface checkAuthResponse{
    userId:number
}

interface emailListResponseItem{
    id:number,
    email:string
}

interface phoneListResponseItem{
    id:number,
    phone:string
}

interface emailEditItem{
    emailEncrypted:string,
    allowAuth:boolean
}

export type {checkAuthResponse,emailListResponseItem,emailEditItem,phoneListResponseItem}