import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContactPhoneNumbersFormComponent } from './contact-phone-numbers-form.component';

describe('ContactPhoneNumbersFormComponent', () => {
  let component: ContactPhoneNumbersFormComponent;
  let fixture: ComponentFixture<ContactPhoneNumbersFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ContactPhoneNumbersFormComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ContactPhoneNumbersFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
