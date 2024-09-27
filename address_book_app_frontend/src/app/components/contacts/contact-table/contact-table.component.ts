import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subject } from 'rxjs';
import { Contact, ContactResponseWithPagination } from '../../../models/contact.model';
import { ContactService } from '../../../services/contacts/contact.service';
import { debounceTime } from 'rxjs/operators';
import Toastify from 'toastify-js';

@Component({
  selector: 'app-contact-table',
  templateUrl: './contact-table.component.html',
  styleUrl: './contact-table.component.scss'
})
export class ContactTableComponent implements OnInit, OnDestroy {
  private searchSubject = new Subject<string>();
  private readonly debounceTimeMs = 300;
  contacts: Contact[] = [];
  contactResponse: ContactResponseWithPagination;
  contactSelected?: Contact;
  searchInput: string = '';
  sortBy?: string;
  sortOrder?: string;
  pageSize?: number;
  page: number = 1;
  pagination: number[] = [];

  constructor(private contactService: ContactService){
    this.contactResponse = {
      current_page: 1,
      data: [],
      first_page_url: '',
      from: 1,
      last_page: 1,
      last_page_url: '',
      next_page_url: '',
      per_page: 10,
      prev_page_url: '',
      to: 1,
      total: 0
    }
  }

  ngOnInit(): void {
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
    if(this.page >= 1 && this.page <= 3) {
      this.pagination = [1,2,3,4,5]
    } else if(this.page >= this.contactResponse.last_page-2 && this.page <= this.contactResponse.last_page){
      this.pagination = [this.contactResponse.last_page - 4, this.contactResponse.last_page - 3, this.contactResponse.last_page - 2, this.contactResponse.last_page - 1, this.contactResponse.last_page];
    } else {
      this.pagination = [this.page - 2, this.page - 1, this.page, this.page + 1, this.page + 2];
    }
  }

  onPageChange(page: number){
    this.page = page;
    this.counter();
    this.loadDataIntoTable();
  }

  onNextPage(){
    if(this.page != this.contactResponse.last_page){
      this.page = this.page + 1;
      this.counter();
      this.loadDataIntoTable();
    }
  }

  onView(contact: Contact){
    this.contactSelected = contact;

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
  
  deleteContact(id: number): void {
    this.contactService.deleteContact(id).subscribe(response => {
      this.showSuccessToast('Contact deleted successfully');
      this.loadDataIntoTable();
    });
  }

  private loadDataIntoTable(searchBy: string = ''): void {
    this.contactService.getAllContacts(searchBy, this.sortBy, this.sortOrder, this.page, this.pageSize).subscribe((response) => {
      this.contacts = response.data.contacts.data;
      this.contactResponse = response.data.contacts;
    });
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
