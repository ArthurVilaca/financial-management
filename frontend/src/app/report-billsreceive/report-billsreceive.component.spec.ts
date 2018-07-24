import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportBillsreceiveComponent } from './report-billsreceive.component';

describe('ReportBillsreceiveComponent', () => {
  let component: ReportBillsreceiveComponent;
  let fixture: ComponentFixture<ReportBillsreceiveComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ReportBillsreceiveComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ReportBillsreceiveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
