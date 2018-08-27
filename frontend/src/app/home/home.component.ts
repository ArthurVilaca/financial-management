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
          "name": "2017",
          "value": 200,
        },
        {
          "name": "2018",
          "value": 300,
        },
        {
          "name": "2019",
          "value": 280,
        }
      ]
    },
  ​
    {
      "name": "A Receber",
      "series": [
        {
          "name": "2017",
          "value": 120,
        },
        {
          "name": "2018",
          "value": 150,
        },
        {
          "name": "2019",
          "value": 160,
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
