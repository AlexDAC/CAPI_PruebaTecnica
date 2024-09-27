import { Component, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { PhoneNumber, PhoneNumberForm } from '../../../models/phone_number.model';
import { ActivatedRoute, Router } from '@angular/router';
import { PhoneNumberService } from '../../../services/phone-numbers/phone-number.service';
import Toastify from 'toastify-js';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-contact-phone-numbers-form',
  templateUrl: './contact-phone-numbers-form.component.html',
  styleUrl: './contact-phone-numbers-form.component.scss'
})
export class ContactPhoneNumbersFormComponent implements OnInit {
  phoneNumberSelected?: PhoneNumber[];
  phoneNumberService$?: Subscription;
  phoneNumberId?: number;
  contactId: number;
  phoneNumberForm: FormGroup  = new FormGroup({  
    phone_number: new FormControl('', [Validators.required, Validators.minLength(10), Validators.maxLength(10), Validators.pattern('[0-9]{10}')]),
  });

  phoneNumberFormData: PhoneNumberForm;

  constructor(
    private phoneNumberService: PhoneNumberService,
    private route: ActivatedRoute
  ) { 
    this.phoneNumberFormData = {
      id: null,
      phone_number: '',
    };
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    this.phoneNumberService.getPhoneNumberSelected().subscribe({
      next: (phoneId) => {
        this.phoneNumberId = phoneId;
        this.loadDataIntoForm();
      },
      error: () => {
        this.phoneNumberId = undefined;
      }
    });
  }

  ngOnInit():void {
    this.loadDataIntoForm();
  }

  private loadDataIntoForm(): void {
    if (this.phoneNumberId) {
      this.phoneNumberService.getPhoneNumberById(this.phoneNumberId).subscribe(response => {       
        this.phoneNumberForm.patchValue(response.data.phoneNumber);
      });
    }
  }

  savePhoneNumber(): void {
    if (this.phoneNumberId) {
      this.phoneNumberService.updatePhoneNumber(this.phoneNumberId, this.phoneNumberForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Updated Successfully");
        this.phoneNumberService.setPhoneNumberSelected(0);
        this.phoneNumberService.setReloadPhoneNumberTable(true);
        this.phoneNumberForm.reset();
      });   
    } else {
      this.phoneNumberService.createPhoneNumber(this.contactId, this.phoneNumberForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Created Successfully");
        this.phoneNumberService.setReloadPhoneNumberTable(true);
        this.phoneNumberForm.reset();
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
