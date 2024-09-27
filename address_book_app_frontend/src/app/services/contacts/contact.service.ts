import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { Contact, ContactResponse, DataByIdResponse, DataResponse, FormContact } from '../../models/contact.model';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ContactService {
  private readonly API_URL = environment.apiUrl + 'contacts';
  private url:string = '';

  constructor(private http: HttpClient) { }

  getAllContacts(
    searchBy: string, 
    sortBy?: string, 
    sortOrder?: string, 
    page:number = 1, 
    pageSize: number = 10
  ): Observable<DataResponse> {
    this.url = `${this.API_URL}?searchBy=${searchBy}`;
    if(sortBy){
      this.url += `&sortBy=${sortBy}`;
    }
    if(sortOrder){
      this.url += `&sortOrder=${sortOrder}`;
    }

    this.url += `&page=${page}&pageSize=${pageSize}`;

    return this.http.get<DataResponse>(this.url);
  }

  getContactById(id: number): Observable<DataByIdResponse> {
    this.url = `${this.API_URL}/${id}`;
    return this.http.get<DataByIdResponse>(this.url);
  }

  createContact(data: FormContact): Observable<DataByIdResponse> {
    return this.http.post<DataByIdResponse>(`${this.API_URL}`, data);
  }

  updateContact(id: number, data: FormContact): Observable<DataByIdResponse> {
    return this.http.put<DataByIdResponse>(`${this.API_URL}/${id}`, data);
  }

  deleteContact(id: number): Observable<void> {
    return this.http.delete<void>(`${this.API_URL}/${id}`);
  }
}
