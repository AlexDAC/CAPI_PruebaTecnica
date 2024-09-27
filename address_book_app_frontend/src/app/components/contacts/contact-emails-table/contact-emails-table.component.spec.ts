import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContactEmailsTableComponent } from './contact-emails-table.component';

describe('ContactEmailsTableComponent', () => {
  let component: ContactEmailsTableComponent;
  let fixture: ComponentFixture<ContactEmailsTableComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ContactEmailsTableComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ContactEmailsTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
