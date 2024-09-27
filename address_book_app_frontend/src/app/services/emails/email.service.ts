import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { DataByIdResponse, DataResponse, EmailForm } from '../../models/email.model';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EmailService {
  private readonly API_URL = environment.apiUrl + 'contacts';
  private url:string = '';
  constructor(private http: HttpClient) { }


  getAllEmailsByContact(
    contactId: number,
    searchBy: string, 
    sortBy?: string, 
    sortOrder?: string, 
    page:number = 1, 
    pageSize: number = 10
  ): Observable<DataResponse> {
    this.url = `${this.API_URL}/${contactId}/emails?searchBy=${searchBy}`;
    if(sortBy){
      this.url += `&sortBy=${sortBy}`;
    }
    if(sortOrder){
      this.url += `&sortOrder=${sortOrder}`;
    }

    this.url += `&page=${page}&pageSize=${pageSize}`;

    return this.http.get<DataResponse>(this.url);
  }

  getEmailById(id: number): Observable<DataByIdResponse> {
    this.url = `${this.API_URL}/emails/${id}`;
    return this.http.get<DataByIdResponse>(this.url);
  }

  createEmail(contactId: number, data: EmailForm): Observable<void> {
    return this.http.post<void>(`${this.API_URL}/${contactId}/emails`, data);
  }

  updateEmail(id: number, data: EmailForm): Observable<void> {
    return this.http.put<void>(`${this.API_URL}/emails/${id}`, data);
  }

  deleteEmail(id: number): Observable<void> {
    return this.http.delete<void>(`${this.API_URL}/emails/${id}`);
  }
}
