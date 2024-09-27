export interface Email {
    id: number;
    email: string;
    Email_id: number;
    created_at?: string;
    updated_at?: string;
}

export interface EmailForm {
    id: number | null;
    email: string;
}

export interface DataResponse{
    data: Response;
    message: string;
}

export interface Response {
    emails: EmailResponseWithPagination;
}

export interface EmailResponseWithPagination{
    current_page: number;
    data: Email[] | [];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string;
    per_page: number;
    prev_page_url: string;
    to: number
    total: number,
}


export interface DataByIdResponse {
    data: EmailResponse;
}

export interface EmailResponse {
    email: Email;
}