import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { DataByIdResponse, DataResponse, PhoneNumber, PhoneNumberForm } from '../../models/phone_number.model';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PhoneNumberService {
  private readonly API_URL = environment.apiUrl + 'contacts';
  private url:string = '';
  phoneNumberSelected = new BehaviorSubject<number>(0);
  reloadPhoneNumberTable = new BehaviorSubject<boolean>(false);
  constructor(private http: HttpClient) { }

  
  setPhoneNumberSelected(phoneNumberId: number){
    this.phoneNumberSelected.next(phoneNumberId);
  }

  getPhoneNumberSelected(){
    return this.phoneNumberSelected.asObservable();
  }

  setReloadPhoneNumberTable(reload: boolean) {
    this.reloadPhoneNumberTable.next(reload);
  }

  getReloadPhoneNumberTable(){
    return this.reloadPhoneNumberTable.asObservable();
  }

  getAllPhoneNumbersByContact(
    contactId: number,
    searchBy: string, 
    sortBy?: string, 
    sortOrder?: string, 
    page:number = 1, 
    pageSize: number = 10
  ): Observable<DataResponse> {
    this.url = `${this.API_URL}/${contactId}/phone-numbers?searchBy=${searchBy}`;
    if(sortBy){
      this.url += `&sortBy=${sortBy}`;
    }
    if(sortOrder){
      this.url += `&sortOrder=${sortOrder}`;
    }

    this.url += `&page=${page}&pageSize=${pageSize}`;

    return this.http.get<DataResponse>(this.url);
  }

  getPhoneNumberById(id: number): Observable<DataByIdResponse> {
    this.url = `${this.API_URL}/phone-numbers/${id}`;
    return this.http.get<DataByIdResponse>(this.url);
  }

  createPhoneNumber(contactId: number, data: PhoneNumberForm): Observable<void> {
    return this.http.post<void>(`${this.API_URL}/${contactId}/phone-numbers`, data);
  }

  updatePhoneNumber(id: number, data: PhoneNumberForm): Observable<void> {
    return this.http.put<void>(`${this.API_URL}/phone-numbers/${id}`, data);
  }

  deletePhoneNumber(id: number): Observable<void> {
    return this.http.delete<void>(`${this.API_URL}/phone-numbers/${id}`);
  }
}
