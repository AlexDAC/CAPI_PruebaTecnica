import { Component, EventEmitter, OnDestroy, OnInit, Output } from '@angular/core';
import { PhoneNumber, PhoneNumberResponseWithPagination } from '../../../models/phone_number.model';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import { PhoneNumberService } from '../../../services/phone-numbers/phone-number.service';
import Toastify from 'toastify-js';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-contact-phone-numbers-table',
  templateUrl: './contact-phone-numbers-table.component.html',
  styleUrl: './contact-phone-numbers-table.component.scss'
})
export class ContactPhoneNumbersTableComponent implements OnInit, OnDestroy {
  private searchSubject = new Subject<string>();
  private readonly debounceTimeMs = 300;
  phoneNumbers: PhoneNumber[] = [];
  phoneNumberResponse?: PhoneNumberResponseWithPagination;
  contactId?: number;
  phoneNumberSelected?: PhoneNumber;
  searchInput: string = '';
  sortBy?: string;
  sortOrder?: string;
  pageSize?: number;
  page: number = 1;
  pagination: number[] = [];

  constructor(private phoneNumberService: PhoneNumberService, private route: ActivatedRoute){
   
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
    if(this.phoneNumberResponse && this.phoneNumberResponse.data.length > 0){
      if(this.phoneNumberResponse.data.length > 0){
  
        if(this.page >= 1 && this.page <= 3) {
          this.pagination = [1,2,3,4,5]
        } else if(this.page >= this.phoneNumberResponse.last_page-2 && this.page <= this.phoneNumberResponse.last_page){
          this.pagination = [this.phoneNumberResponse.last_page - 4, this.phoneNumberResponse.last_page - 3, this.phoneNumberResponse.last_page - 2, this.phoneNumberResponse.last_page - 1, this.phoneNumberResponse.last_page];
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
    if(this.page != this.phoneNumberResponse?.last_page){
      this.page = this.page + 1;
      this.counter();
      this.loadDataIntoTable();
    }
  }

  editPhoneNumber(phoneNumber: PhoneNumber){
    this.phoneNumberSelected = phoneNumber;
    this.sendPhoneNumberData();
  }

  sendPhoneNumberData(){
    this.phoneNumberService.setPhoneNumberSelected(this.phoneNumberSelected);

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
  
  deletePhoneNumber(id: number): void {
    this.phoneNumberService.deletePhoneNumber(id).subscribe(response => {
      this.showSuccessToast('Phone number deleted successfully');
      this.loadDataIntoTable();
    });
  }

  private loadDataIntoTable(searchBy: string = ''): void {
    if(this.contactId){
      this.phoneNumberService.getAllPhoneNumbersByContact(this.contactId ,searchBy, this.sortBy, this.sortOrder, this.page, this.pageSize).subscribe((response) => {
        this.phoneNumbers = response.data.phoneNumbers.data;
        this.phoneNumberResponse = response.data.phoneNumbers;
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
