import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BillspayComponent } from './billspay.component';

describe('BillspayComponent', () => {
  let component: BillspayComponent;
  let fixture: ComponentFixture<BillspayComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BillspayComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BillspayComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
