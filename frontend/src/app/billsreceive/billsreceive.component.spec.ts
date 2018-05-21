import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BillsreceiveComponent } from './billsreceive.component';

describe('BillsreceiveComponent', () => {
  let component: BillsreceiveComponent;
  let fixture: ComponentFixture<BillsreceiveComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BillsreceiveComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BillsreceiveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
