import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RouteOrientationComponent } from './route-orientation.component';

describe('RouteOrientationComponent', () => {
  let component: RouteOrientationComponent;
  let fixture: ComponentFixture<RouteOrientationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RouteOrientationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RouteOrientationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
