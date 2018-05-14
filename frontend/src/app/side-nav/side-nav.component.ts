import { Component } from '@angular/core';
import { ProviderService } from '../provider.service'
import { HttpService } from '../http.service'

@Component({
  selector: 'app-side-nav',
  templateUrl: './side-nav.component.html',
  styleUrls: ['./side-nav.component.css']
})
export class SideNavComponent {

  constructor(private appState: ProviderService, private http: HttpService) { }

  logout() {
    this.http.logout();
  }
}
