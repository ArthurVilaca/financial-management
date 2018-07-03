import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SearchBillsComponent } from './search-bills.component';

describe('SearchBillsComponent', () => {
  let component: SearchBillsComponent;
  let fixture: ComponentFixture<SearchBillsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SearchBillsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SearchBillsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
