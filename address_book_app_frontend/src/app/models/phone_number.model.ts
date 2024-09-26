export interface PhoneNumber {
    id: number;
    phone_number: string;
    contact_id: number;
    created_at?: string;
    updated_at?: string;
}

export interface PhoneNumberForm {
    id: number;
    phone_number: string;
    status: string;
}