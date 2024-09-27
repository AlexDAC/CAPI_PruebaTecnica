import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContactAddressTableComponent } from './contact-address-table.component';

describe('ContactAddressTableComponent', () => {
  let component: ContactAddressTableComponent;
  let fixture: ComponentFixture<ContactAddressTableComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ContactAddressTableComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ContactAddressTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
