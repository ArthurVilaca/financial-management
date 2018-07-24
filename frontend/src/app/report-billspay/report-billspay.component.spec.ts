import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportBillspayComponent } from './report-billspay.component';

describe('ReportBillspayComponent', () => {
  let component: ReportBillspayComponent;
  let fixture: ComponentFixture<ReportBillspayComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReportBillspayComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReportBillspayComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
