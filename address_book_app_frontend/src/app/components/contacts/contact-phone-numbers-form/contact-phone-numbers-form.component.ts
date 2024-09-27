import { Component, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { PhoneNumber, PhoneNumberForm } from '../../../models/phone_number.model';
import { ActivatedRoute, Router } from '@angular/router';
import { PhoneNumberService } from '../../../services/phone-numbers/phone-number.service';
import Toastify from 'toastify-js';

@Component({
  selector: 'app-contact-phone-numbers-form',
  templateUrl: './contact-phone-numbers-form.component.html',
  styleUrl: './contact-phone-numbers-form.component.scss'
})
export class ContactPhoneNumbersFormComponent implements OnInit {
  phoneNumberSelected?: PhoneNumber[];
  phoneNumberId?: number;
  contactId: number;
  phoneNumberForm: FormGroup  = new FormGroup({  
    phone_number: new FormControl('', [Validators.required, Validators.minLength(10), Validators.maxLength(10), Validators.pattern('[0-9]{10}')]),
  });

  phoneNumberFormData: PhoneNumberForm;

  constructor(
    private phoneNumberService: PhoneNumberService,
    private router: Router,
    private route: ActivatedRoute
  ) { 
    this.phoneNumberFormData = {
      id: null,
      phone_number: '',
    };
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
  }

  ngOnInit():void {
    this.loadDataIntoForm();
  }

  getPhoneNumber(){
    console.log(this.phoneNumberService.getPhoneNumberSelected());
    this.phoneNumberSelected = this.phoneNumberService.getPhoneNumberSelected();
  }

  private loadDataIntoForm(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    if (this.contactId) {
      this.phoneNumberService.getPhoneNumberById(this.contactId).subscribe(response => {       
        this.phoneNumberForm.patchValue(response.data.phone_number);
      });
    }
  }

  savePhoneNumber(): void {
    if (this.contactId && this.phoneNumberId) {
      this.phoneNumberService.updatePhoneNumber(this.contactId, this.phoneNumberForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Updated Successfully");
        this.router.navigate(['/contacts', this.contactId, 'edit']);
      });   
    } else {
      this.phoneNumberService.createPhoneNumber(this.contactId, this.phoneNumberForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Created Successfully");
        this.router.navigateByUrl('/contacts/' + this.contactId + '/edit',{skipLocationChange:true}).then(()=>{
          this.router.navigate([`/contacts/${this.contactId}/edit`]).then(()=>{
          })
        });
      });
    }  
  }

  hasError(field: string): boolean {
    const errorsObject = this.phoneNumberForm.get(field)?.errors ?? {};
    const errors = Object.keys(errorsObject);

    if (errors.length && (this.phoneNumberForm.get(field)?.touched || this.phoneNumberForm.get(field)?.dirty)) {
      return true;
    }

    return false;
  }
  
  getCurrentError(field: string): string {
    const errorsObject = this.phoneNumberForm.get(field)?.errors ?? {};
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
