import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BillspaysComponent } from './billspays.component';

describe('BillspaysComponent', () => {
  let component: BillspaysComponent;
  let fixture: ComponentFixture<BillspaysComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BillspaysComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BillspaysComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
