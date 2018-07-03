import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';
import { PageEvent } from '@angular/material';

@Component({
  selector: 'app-billsreceives',
  templateUrl: './billsreceives.component.html',
  styleUrls: ['./billsreceives.component.scss']
})
export class BillsreceivesComponent {
  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
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
    this.http.get('/billsreceive?page=' + page + '&pageSize=' + this.pageSize)
      .then((data: any) => {
        this.appState.set('billsreceives', data.dataset.billsreceive);
        this.length = data.dataset.total;
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
