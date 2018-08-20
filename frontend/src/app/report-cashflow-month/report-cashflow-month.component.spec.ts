import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportCashflowMonthComponent } from './report-cashflow-month.component';

describe('ReportCashflowMonthComponent', () => {
  let component: ReportCashflowMonthComponent;
  let fixture: ComponentFixture<ReportCashflowMonthComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReportCashflowMonthComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReportCashflowMonthComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
