import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';

@Component({
  selector: 'app-route-orientation',
  templateUrl: './route-orientation.component.html',
  styleUrls: ['./route-orientation.component.scss']
})
export class RouteOrientationComponent {
  routes: any[] = [];

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    console.log(this.router.url)
  }

  getRoutes(route) {
    this.routes = route.split('/');
  }

}
