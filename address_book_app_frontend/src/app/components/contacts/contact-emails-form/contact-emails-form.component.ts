import { Component, OnInit } from '@angular/core';
import Toastify from 'toastify-js';
import { ActivatedRoute, Router } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Email, EmailForm } from '../../../models/email.model';
import { EmailService } from '../../../services/emails/email.service';

@Component({
  selector: 'app-contact-emails-form',
  templateUrl: './contact-emails-form.component.html',
  styleUrl: './contact-emails-form.component.scss'
})
export class ContactEmailsFormComponent implements OnInit {
  email?: Email[];
  phoneNumberId?: number;
  contactId: number;
  emailForm: FormGroup  = new FormGroup({  
    email: new FormControl('', [Validators.required, Validators.maxLength(255), Validators.pattern("^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$")]),
  });

  emailFormData: EmailForm;

  constructor(
    private emailService: EmailService,
    private router: Router,
    private route: ActivatedRoute
  ) { 
    this.emailFormData = {
      id: null,
      email: '',
    };
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
  }

  ngOnInit():void {
    this.loadDataIntoForm();
  }

  private loadDataIntoForm(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    if (this.contactId) {
      this.emailService.getEmailById(this.contactId).subscribe(response => {       
        this.emailForm.patchValue(response.data.Email);
      });
    }
  }

  savePhoneNumber(): void {
    if (this.contactId && this.phoneNumberId) {
      this.emailService.updateEmail(this.contactId, this.emailForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Updated Successfully");
        this.router.navigate(['/contacts', this.contactId, 'edit']);
      });   
    } else {
      this.emailService.createEmail(this.contactId, this.emailForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Created Successfully");
        this.router.navigateByUrl('/contacts/' + this.contactId + '/edit',{skipLocationChange:true}).then(()=>{
          this.router.navigate([`/contacts/${this.contactId}/edit`]).then(()=>{
          })
        });
      });
    }  
  }

  hasError(field: string): boolean {
    const errorsObject = this.emailForm.get(field)?.errors ?? {};
    const errors = Object.keys(errorsObject);

    if (errors.length && (this.emailForm.get(field)?.touched || this.emailForm.get(field)?.dirty)) {
      return true;
    }

    return false;
  }
  
  getCurrentError(field: string): string {
    const errorsObject = this.emailForm.get(field)?.errors ?? {};
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
