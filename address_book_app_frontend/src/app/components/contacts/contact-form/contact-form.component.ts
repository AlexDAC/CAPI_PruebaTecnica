import { Component, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import Toastify from 'toastify-js';
import { Contact, FormContact } from '../../../models/contact.model';
import { ContactService } from '../../../services/contacts/contact.service';


@Component({
  selector: 'app-contact-form',
  templateUrl: './contact-form.component.html',
  styleUrl: './contact-form.component.scss'
})
export class ContactFormComponent implements OnInit {
  contactId: number;

  contactForm: FormGroup  = new FormGroup({
    name: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    notes: new FormControl('', [Validators.maxLength(255)]),
    birth_date: new FormControl('', [Validators.required]),
    web_page_url : new FormControl('', [Validators.pattern('(https?://)?([\\da-z.-]+)\\.([a-z.]{2,6})[/\\w .-]*/?'), Validators.maxLength(300)]),
    company_name: new FormControl('', [Validators.maxLength(255)]),
  });

  contactFormData: FormContact;
  constructor(
    private contactService: ContactService,
    private router: Router,
    private route: ActivatedRoute
  ) { 
    this.contactFormData = {
      id: null,
      name: '',
      notes: '',
      birth_date: '',
      web_page_url: '',
      company_name: '',
    };
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
  }

  ngOnInit():void {
    this.loadDataIntoForm();
  }

  private loadDataIntoForm(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    if (this.contactId) {
      this.contactService.getContactById(this.contactId).subscribe(response => {       
        this.contactForm.patchValue(response.data.contact);
      });
    }
  }

  saveContact(): void {
    if (this.contactId) {
      this.contactService.updateContact(this.contactId, this.contactForm.value).subscribe(response => {
        this.showSuccessToast("Contact Updated Successfully");
        this.router.navigate(['/contacts', this.contactId, 'edit']);
      });   
    } else {
      this.contactService.createContact(this.contactForm.value).subscribe(response => {
        this.showSuccessToast("Contact Created Successfully");
        this.router.navigateByUrl('/contacts/' + response.data.contact.id + '/edit',{skipLocationChange:true}).then(()=>{
          this.router.navigate([`/contacts/${response.data.contact.id}/edit`]).then(()=>{
          })
        });
      });
    }  
  }

  hasError(field: string): boolean {
    const errorsObject = this.contactForm.get(field)?.errors ?? {};
    const errors = Object.keys(errorsObject);

    if (errors.length && (this.contactForm.get(field)?.touched || this.contactForm.get(field)?.dirty)) {
      return true;
    }

    return false;
  }
  
  getCurrentError(field: string): string {
    const errorsObject = this.contactForm.get(field)?.errors ?? {};
    const errors = Object.keys(errorsObject);

    if (!errors)
      return '';

    return errors[0];
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