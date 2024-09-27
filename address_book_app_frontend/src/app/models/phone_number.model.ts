export interface PhoneNumber {
    id: number;
    phone_number: string;
    contact_id: number;
    created_at?: string;
    updated_at?: string;
}

export interface PhoneNumberForm {
    id: number | null;
    phone_number: string;
}

export interface DataResponse{
    data: Response;
    message: string;
}

export interface Response {
    phoneNumbers: PhoneNumberResponseWithPagination;
}

export interface PhoneNumberResponseWithPagination{
    current_page: number;
    data: PhoneNumber[] | [];
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
    data: PhoneNumberResponse;
}

export interface PhoneNumberResponse {
    phone_number: PhoneNumber;
}