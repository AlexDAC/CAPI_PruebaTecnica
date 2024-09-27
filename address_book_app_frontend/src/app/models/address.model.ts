export interface Address {
    id: number;
    street: string;
    external_number: string;
    internal_number?: string;
    neighbourhood: string;
    zip_code: string;
    city: string;
    state: string;
    country: string;
    full_address: string;
    created_at?: string;
    updated_at?: string;
}

export interface AddressForm {
    id: number | null;
    street: string;
    external_number: string;
    internal_number?: string;
    neighbourhood: string;
    zip_code: string;
    city: string;
    state: string;
    country: string;
}

export interface DataResponse{
    data: Response;
    message: string;
}

export interface Response {
    addresses: AddressResponseWithPagination;
}

export interface AddressResponseWithPagination{
    current_page: number;
    data: Address[] | [];
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
    data: AddressResponse;
}

export interface AddressResponse {
    addresses: Address;
}


