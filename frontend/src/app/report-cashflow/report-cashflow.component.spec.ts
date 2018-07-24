import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportCashflowComponent } from './report-cashflow.component';

describe('ReportCashflowComponent', () => {
  let component: ReportCashflowComponent;
  let fixture: ComponentFixture<ReportCashflowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReportCashflowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReportCashflowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
