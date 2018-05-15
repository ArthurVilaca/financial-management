import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';

@Component({
  selector: 'app-cost-centers',
  templateUrl: './cost-centers.component.html',
  styleUrls: ['./cost-centers.component.scss']
})
export class CostCentersComponent {

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search() {
    this.http.get('/cost_centers')
      .then((data: any) => {
        this.appState.set('cost_centers', data.dataset.costCenters);
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
