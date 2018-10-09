import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportDreCashflowComponent } from './report-dre-cashflow.component';

describe('ReportDreCashflowComponent', () => {
  let component: ReportDreCashflowComponent;
  let fixture: ComponentFixture<ReportDreCashflowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReportDreCashflowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReportDreCashflowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
