import { Component } from '@angular/core';
import { HttpService } from '../http.service'

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {
  alerts: any[] = [];

  constructor(private http: HttpService) {
    this.loadAlerts();
  }

  loadAlerts() {
    this.http.get('/alerts')
      .then((data: any) => {
        this.alerts = data.dataset.alerts;
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
