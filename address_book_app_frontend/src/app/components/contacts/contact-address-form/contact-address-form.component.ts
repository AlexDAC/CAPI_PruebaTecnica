import { Component, OnInit } from '@angular/core';
import Toastify from 'toastify-js';
import { ActivatedRoute, Router } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Address, AddressForm } from '../../../models/address.model';
import { AddressService } from '../../../services/addresses/address.service';

@Component({
  selector: 'app-contact-address-form',
  templateUrl: './contact-address-form.component.html',
  styleUrl: './contact-address-form.component.scss'
})
export class ContactAddressFormComponent implements OnInit {
  addressSelected?: Address[];
  phoneNumberId?: number;
  contactId: number;
  addressForm: FormGroup  = new FormGroup({  
    street: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    external_number: new FormControl('', [Validators.required, Validators.maxLength(5)]),
    internal_number: new FormControl(''),
    neighbourhood: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    zip_code: new FormControl('', [Validators.required, Validators.maxLength(5)]),
    city: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    state: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    country: new FormControl('', [Validators.required, Validators.maxLength(255)])
  });

  addressFormData: AddressForm;

  constructor(
    private addressService: AddressService,
    private router: Router,
    private route: ActivatedRoute
  ) { 
    this.addressFormData = {
      id: null,
      street: '',
      external_number: '',
      internal_number: '',
      neighbourhood: '',
      zip_code: '',
      city: '',
      state: '',
      country: ''
    };
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
  }

  ngOnInit():void {
    this.loadDataIntoForm();
  }

  private loadDataIntoForm(): void {
    this.contactId = Number(this.route.snapshot.paramMap.get('id'));
    if (this.contactId) {
      this.addressService.getAddressById(this.contactId).subscribe(response => {       
        this.addressForm.patchValue(response.data.address);
      });
    }
  }

  savePhoneNumber(): void {
    if (this.contactId && this.phoneNumberId) {
      this.addressService.updateAddress(this.contactId, this.addressForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Updated Successfully");
        this.router.navigate(['/contacts', this.contactId, 'edit']);
      });   
    } else {
      this.addressService.createAddress(this.contactId, this.addressForm.value).subscribe(response => {
        this.showSuccessToast("Phone Number Created Successfully");
        this.router.navigateByUrl('/contacts/' + this.contactId + '/edit',{skipLocationChange:true}).then(()=>{
          this.router.navigate([`/contacts/${this.contactId}/edit`]).then(()=>{
          })
        });
      });
    }  
  }

  hasError(field: string): boolean {
    const errorsObject = this.addressForm.get(field)?.errors ?? {};
    const errors = Object.keys(errorsObject);

    if (errors.length && (this.addressForm.get(field)?.touched || this.addressForm.get(field)?.dirty)) {
      return true;
    }

    return false;
  }
  
  getCurrentError(field: string): string {
    const errorsObject = this.addressForm.get(field)?.errors ?? {};
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
