import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BillsreceivesComponent } from './billsreceives.component';

describe('BillsreceivesComponent', () => {
  let component: BillsreceivesComponent;
  let fixture: ComponentFixture<BillsreceivesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BillsreceivesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BillsreceivesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
