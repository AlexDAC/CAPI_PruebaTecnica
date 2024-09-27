import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContactTabsComponent } from './contact-tabs.component';

describe('ContactTabsComponent', () => {
  let component: ContactTabsComponent;
  let fixture: ComponentFixture<ContactTabsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ContactTabsComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ContactTabsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
