import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { AddressForm, DataByIdResponse, DataResponse } from '../../models/address.model';

@Injectable({
  providedIn: 'root'
})
export class AddressService {
  private readonly API_URL = environment.apiUrl + 'contacts';
  private url:string = '';
  constructor(private http: HttpClient) { }


  getAllAddressesByContact(
    contactId: number,
    searchBy: string, 
    sortBy?: string, 
    sortOrder?: string, 
    page:number = 1, 
    pageSize: number = 10
  ): Observable<DataResponse> {
    this.url = `${this.API_URL}/${contactId}/addresses?searchBy=${searchBy}`;
    if(sortBy){
      this.url += `&sortBy=${sortBy}`;
    }
    if(sortOrder){
      this.url += `&sortOrder=${sortOrder}`;
    }

    this.url += `&page=${page}&pageSize=${pageSize}`;

    return this.http.get<DataResponse>(this.url);
  }

  getAddressById(id: number): Observable<DataByIdResponse> {
    this.url = `${this.API_URL}/addresses/${id}`;
    return this.http.get<DataByIdResponse>(this.url);
  }
  createAddress(contactId: number, data: AddressForm): Observable<void> {
    return this.http.post<void>(`${this.API_URL}/${contactId}/addresses`, data);
  }

  updateAddress(id: number, data: AddressForm): Observable<void> {
    return this.http.put<void>(`${this.API_URL}/addresses/${id}`, data);
  }

  deleteAddress(id: number): Observable<void> {
    return this.http.delete<void>(`${this.API_URL}/addresses/${id}`);
  }
}
