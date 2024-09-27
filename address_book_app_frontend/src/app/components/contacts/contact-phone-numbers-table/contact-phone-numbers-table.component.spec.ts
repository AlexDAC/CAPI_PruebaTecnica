import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContactPhoneNumbersTableComponent } from './contact-phone-numbers-table.component';

describe('ContactPhoneNumbersTableComponent', () => {
  let component: ContactPhoneNumbersTableComponent;
  let fixture: ComponentFixture<ContactPhoneNumbersTableComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ContactPhoneNumbersTableComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ContactPhoneNumbersTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
