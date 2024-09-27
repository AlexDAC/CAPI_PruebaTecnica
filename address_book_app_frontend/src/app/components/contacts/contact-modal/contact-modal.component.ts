import { Component, Input } from '@angular/core';
import { Contact } from '../../../models/contact.model';

@Component({
  selector: 'app-contact-modal',
  templateUrl: './contact-modal.component.html',
  styleUrl: './contact-modal.component.scss'
})
export class ContactModalComponent {
  @Input() contact?: Contact;

  constructor() { }
}
