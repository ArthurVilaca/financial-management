import { Component, OnInit } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';
import { PageEvent } from '@angular/material';

@Component({
  selector: 'app-clients',
  templateUrl: './clients.component.html',
  styleUrls: ['./clients.component.css']
})
export class ClientsComponent implements OnInit {
  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  ngOnInit() {
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
    this.http.get('/clients?page=' + page + '&pageSize=' + this.pageSize)
      .then((data: any) => {
        this.appState.set('clients', data.dataset.clients);
        this.length = data.dataset.total;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  setPageSizeOptions(setPageSizeOptionsInput: string) {
    this.pageSizeOptions = setPageSizeOptionsInput.split(',').map(str => +str);
  }

}
