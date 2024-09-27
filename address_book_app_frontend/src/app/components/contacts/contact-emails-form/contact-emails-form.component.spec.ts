import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContactEmailsFormComponent } from './contact-emails-form.component';

describe('ContactEmailsFormComponent', () => {
  let component: ContactEmailsFormComponent;
  let fixture: ComponentFixture<ContactEmailsFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ContactEmailsFormComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ContactEmailsFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
