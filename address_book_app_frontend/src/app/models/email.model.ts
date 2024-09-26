export interface Email {
    id: number;
    email: string;
    contact_id: number;
    created_at?: string;
    updated_at?: string;
}

export interface EmailForm {
    id: number;
    email: string;
    status: string;
}