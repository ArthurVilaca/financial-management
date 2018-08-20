import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SearchCostcenterComponent } from './search-costcenter.component';

describe('SearchCostcenterComponent', () => {
  let component: SearchCostcenterComponent;
  let fixture: ComponentFixture<SearchCostcenterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SearchCostcenterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SearchCostcenterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
