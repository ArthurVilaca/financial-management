import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { PageEvent } from '@angular/material';

@Component({
  selector: 'app-cost-centers',
  templateUrl: './cost-centers.component.html',
  styleUrls: ['./cost-centers.component.scss']
})
export class CostCentersComponent {
  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search($event?) {
    if($event){
      this.pageEvent = $event;
      this.pageSize = $event.pageSize;
    }
    let page = 0;
    if(this.pageEvent) {
      page = this.pageEvent.pageIndex;
    }
    this.http.get('/cost_centers?page=' + page + '&pageSize=' + this.pageSize)
      .then((data: any) => {
        this.appState.set('cost_centers', data.dataset.costCenters);
        this.length = data.dataset.total;
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
