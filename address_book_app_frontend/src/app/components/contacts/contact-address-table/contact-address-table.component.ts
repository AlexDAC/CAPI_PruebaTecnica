import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import Toastify from 'toastify-js';
import { ActivatedRoute } from '@angular/router';
import { AddressService } from '../../../services/addresses/address.service';
import { Address, AddressResponseWithPagination } from '../../../models/address.model';

@Component({
  selector: 'app-contact-address-table',
  templateUrl: './contact-address-table.component.html',
  styleUrl: './contact-address-table.component.scss'
})
export class ContactAddressTableComponent implements OnInit, OnDestroy {
  private searchSubject = new Subject<string>();
  private readonly debounceTimeMs = 300;
  addresses: Address[] = [];
  addressResponse?: AddressResponseWithPagination;
  contactId?: number;
  addressSelected?: Address;
  searchInput: string = '';
  sortBy?: string;
  sortOrder?: string;
  pageSize?: number;
  page: number = 1;
  pagination: number[] = [];

  constructor(private addressService: AddressService, private route: ActivatedRoute){
   
  }

  ngOnInit(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadDataIntoTable();
    this.searchSubject.pipe(debounceTime(this.debounceTimeMs)).subscribe((searchValue) => {
      this.performSearch(searchValue);
    });
    this.counter();
  }

  ngOnDestroy() {
    this.searchSubject.complete();
  }

  counter() {
    if(this.addressResponse && this.addressResponse.data.length > 0){
      if(this.addressResponse.data.length > 0){
  
        if(this.page >= 1 && this.page <= 3) {
          this.pagination = [1,2,3,4,5]
        } else if(this.page >= this.addressResponse.last_page-2 && this.page <= this.addressResponse.last_page){
          this.pagination = [this.addressResponse.last_page - 4, this.addressResponse.last_page - 3, this.addressResponse.last_page - 2, this.addressResponse.last_page - 1, this.addressResponse.last_page];
        } else {
          this.pagination = [this.page - 2, this.page - 1, this.page, this.page + 1, this.page + 2];
        }
      }
    }
  }

  onPageChange(page: number){
    this.page = page;
    this.counter();
    this.loadDataIntoTable();
  }

  onNextPage(){
    if(this.page != this.addressResponse?.last_page){
      this.page = this.page + 1;
      this.counter();
      this.loadDataIntoTable();
    }
  }

  editAddress(address: Address){
    this.addressSelected = address;
  }

  onPreviousPage(){
    if(this.page != 1){
      this.page = this.page - 1;
      this.counter();
      this.loadDataIntoTable();
    }
  }

  onChangeSize(size: number){
    this.pageSize = size;
    this.page = 1;
    this.loadDataIntoTable();
  }

  onChangeOrder(column: string){
    this.sortBy = column;
    if(this.sortOrder){
      this.sortOrder = this.sortOrder === 'ascending'? 'descending' : 'ascending';
    } else {
      this.sortOrder = 'ascending';
    }
    this.loadDataIntoTable();
  }

  onSearch(): void {
    this.searchSubject.next(this.searchInput);
  }

  performSearch(searchValue: string) {
    this.page = 1;
    this.counter();
    this.loadDataIntoTable(searchValue)
  }
  
  deleteAddress(id: number): void {
    this.addressService.deleteAddress(id).subscribe(response => {
      this.showSuccessToast('Address deleted successfully');
      this.loadDataIntoTable();
    });
  }

  private loadDataIntoTable(searchBy: string = ''): void {
    if(this.contactId){
      this.addressService.getAllAddressesByContact(this.contactId ,searchBy, this.sortBy, this.sortOrder, this.page, this.pageSize).subscribe((response) => {
        this.addresses = response.data.addresses.data;
        console.log(this.addresses);
        this.addressResponse = response.data.addresses;
      });
    }
  }

  private showSuccessToast(message: string): void {
    Toastify({
      text: message,
      close: true,
      gravity: "bottom",
      position: "center",
      stopOnFocus: true,
      style: {
        background: "#189586",
      }
    }).showToast();
  }

}
