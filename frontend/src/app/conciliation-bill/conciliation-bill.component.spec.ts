import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ConciliationBillComponent } from './conciliation-bill.component';

describe('ConciliationBillComponent', () => {
  let component: ConciliationBillComponent;
  let fixture: ComponentFixture<ConciliationBillComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ConciliationBillComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ConciliationBillComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
