import { Component, OnInit } from '@angular/core';
import { ContactService } from '../../../services/contacts/contact.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Contact } from '../../../models/contact.model';
import { PhoneNumber } from '../../../models/phone_number.model';
import { PhoneNumberService } from '../../../services/phone-numbers/phone-number.service';

@Component({
  selector: 'app-contact-tabs',
  templateUrl: './contact-tabs.component.html',
  styleUrl: './contact-tabs.component.scss'
})
export class ContactTabsComponent implements OnInit {
  contactId?: number;
  contactData?: Contact;
  
  constructor(
    private contactService: ContactService,
    private route: ActivatedRoute,
  ) { }

  ngOnInit(): void {
    this.loadDataIntoForm();
  }

  getFormTitle(): string {
    return this.contactId ? 'Edit Contact Information' : 'New Contact';
  }

  private loadDataIntoForm(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    if (this.contactId) {
      this.contactService.getContactById(this.contactId).subscribe(response => {       
        this.contactData = response.data.contact;
      });
    }
  }
}
