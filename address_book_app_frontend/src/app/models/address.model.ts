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
    id: number;
    street: string;
    external_number: string;
    internal_number?: string;
    neighbourhood: string;
    zip_code: string;
    city: string;
    state: string;
    country: string;
    status: string;
}