import { Component } from '@angular/core';
import { HttpService } from '../http.service'

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent {
  alerts: any[] = [];
  data: any[] = [
    {
      "name": "A Pagar",
      "series": [
        {
          "name": "06-2018",
          "value": 200,
        },
        {
          "name": "07-2018",
          "value": 300,
        },
        {
          "name": "08-2018",
          "value": 280,
        },
        {
          "name": "09-2018",
          "value": 120,
        },
        {
          "name": "10-2018",
          "value": 30,
        }
      ]
    },
  ​
    {
      "name": "A Receber",
      "series": [
        {
          "name": "06-2018",
          "value": 120,
        },
        {
          "name": "07-2018",
          "value": 150,
        },
        {
          "name": "08-2018",
          "value": 160,
        },
        {
          "name": "09-2018",
          "value": 80,
        },
        {
          "name": "10-2018",
          "value": 40,
        }
      ]
    }
  ]

  view: any[] = [900, 400];

  // options
  showXAxis = true;
  showYAxis = true;
  gradient = false;
  showXAxisLabel = true;
  showYAxisLabel = true;
  xAxisLabel = 'Conta';
  yAxisLabel = 'Valor';

  colorScheme = {
    domain: ['#5AA454', '#A10A28', '#C7B42C', '#AAAAAA']
  };

  // line, area
  autoScale = true;

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
