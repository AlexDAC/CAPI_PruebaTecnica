import { Address } from "./address.model";
import { Email } from "./email.model";
import { PhoneNumber } from './phone_number.model';

export interface Contact {
    id: number;
    name: string;
    notes: string;
    birth_date: string;
    web_page_url: string;
    company_name: string;
    addresses?: Address[];
    emails?: Email[];
    phone_numbers?: PhoneNumber[];    
    created_at?: string;
    updated_at?: string;
}

export interface FormContact {
    id: number | null;
    name: string;
    notes: string;
    birth_date: string;
    web_page_url: string;
    company_name: string;
}

export interface DataResponse{
    data: Response;
    message: string;
}

export interface Response {
    contacts: ContactResponseWithPagination;
}

export interface ContactResponseWithPagination{
    current_page: number;
    data: Contact[] | [];
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
    data: ContactResponse;
}

export interface ContactResponse {
    contact: Contact;
}