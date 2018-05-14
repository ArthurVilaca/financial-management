import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TaxSelectionComponent } from './tax-selection.component';

describe('TaxSelectionComponent', () => {
  let component: TaxSelectionComponent;
  let fixture: ComponentFixture<TaxSelectionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TaxSelectionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TaxSelectionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
