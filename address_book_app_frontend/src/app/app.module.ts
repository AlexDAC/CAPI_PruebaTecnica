import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ContactTableComponent } from './components/contacts/contact-table/contact-table.component';
import { ContactFormComponent } from './components/contacts/contact-form/contact-form.component';
import { ContactModalComponent } from './components/contacts/contact-modal/contact-modal.component';
import { ContactTabsComponent } from './components/contacts/contact-tabs/contact-tabs.component';
import { ContactAddressFormComponent } from './components/contacts/contact-address-form/contact-address-form.component';
import { ContactAddressTableComponent } from './components/contacts/contact-address-table/contact-address-table.component';
import { ContactPhoneNumbersTableComponent } from './components/contacts/contact-phone-numbers-table/contact-phone-numbers-table.component';
import { ContactPhoneNumbersFormComponent } from './components/contacts/contact-phone-numbers-form/contact-phone-numbers-form.component';
import { ContactEmailsFormComponent } from './components/contacts/contact-emails-form/contact-emails-form.component';
import { ContactEmailsTableComponent } from './components/contacts/contact-emails-table/contact-emails-table.component';

@NgModule({
  declarations: [
    AppComponent,
    ContactTableComponent,
    ContactFormComponent,
    ContactModalComponent,
    ContactTabsComponent,
    ContactAddressFormComponent,
    ContactAddressTableComponent,
    ContactPhoneNumbersTableComponent,
    ContactPhoneNumbersFormComponent,
    ContactEmailsFormComponent,
    ContactEmailsTableComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    FormsModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
