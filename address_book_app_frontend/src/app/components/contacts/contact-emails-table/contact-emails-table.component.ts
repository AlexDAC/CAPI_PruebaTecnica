import { Component, OnDestroy, OnInit } from '@angular/core';
import { Subject, Subscription } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import Toastify from 'toastify-js';
import { ActivatedRoute } from '@angular/router';
import { EmailService } from '../../../services/emails/email.service';
import { Email, EmailResponseWithPagination } from '../../../models/email.model';

@Component({
  selector: 'app-contact-emails-table',
  templateUrl: './contact-emails-table.component.html',
  styleUrl: './contact-emails-table.component.scss'
})
export class ContactEmailsTableComponent  implements OnInit, OnDestroy {
  private searchSubject = new Subject<string>();
  private readonly debounceTimeMs = 300;
  emails: Email[] = [];
  emailService$?: Subscription;
  reloadTable:boolean = false;
  emailResponse?: EmailResponseWithPagination;
  contactId?: number;
  emailSelected?: Email;
  searchInput: string = '';
  sortBy?: string;
  sortOrder?: string;
  pageSize?: number;
  page: number = 1;
  pagination: number[] = [];

  constructor(private emailService: EmailService, private route: ActivatedRoute){
    this.emailService.getReloadEmailTable().subscribe({
      next: (reload) => {
        this.reloadTable = reload;
        this.loadDataIntoTable();
      },
      error: () => {
        this.reloadTable = false;
      }
    });
  }

  ngOnInit(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadDataIntoTable();
    this.searchSubject.pipe(debounceTime(this.debounceTimeMs)).subscribe((searchValue) => {
      this.performSearch(searchValue);
    });
    
  }

  ngOnDestroy() {
    this.searchSubject.complete();
  }

  counter() {
    if(this.emailResponse){
      if(this.emailResponse.data.length > 0){
        if(this.emailResponse.last_page >= 1 && this.emailResponse.last_page <= 5) {
          for(let i=0; i<this.emailResponse.last_page; i++){
            this.pagination[i] = i + 1;
          }
        } else if(this.page >= this.emailResponse.last_page-2 && this.page <= this.emailResponse.last_page){
          this.pagination = [this.emailResponse.last_page - 4, this.emailResponse.last_page - 3, this.emailResponse.last_page - 2, this.emailResponse.last_page - 1, this.emailResponse.last_page];
        } else {
          this.pagination = [this.page - 2, this.page - 1, this.page, this.page + 1, this.page + 2];
        }
      }
    }
  }


  onPageChange(page: number){
    this.page = page;
    this.loadDataIntoTable();
  }

  onNextPage(){
    if(this.page != this.emailResponse?.last_page){
      this.page = this.page + 1;
      this.loadDataIntoTable();
    }
  }

  editEmail(emailId: number){
    this.emailService.setEmailSelected(emailId);
  }

  onPreviousPage(){
    if(this.page != 1){
      this.page = this.page - 1;
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
    this.loadDataIntoTable(searchValue)
  }
  
  deleteEmail(id: number): void {
    this.emailService.deleteEmail(id).subscribe(response => {
      this.showSuccessToast('Phone number deleted successfully');
      this.loadDataIntoTable();
    });
  }

  private loadDataIntoTable(searchBy: string = ''): void {
    if(this.contactId){
      this.emailService.getAllEmailsByContact(this.contactId ,searchBy, this.sortBy, this.sortOrder, this.page, this.pageSize).subscribe((response) => {
        this.emails = response.data.emails.data;
        this.emailResponse = response.data.emails;
        this.counter();
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
