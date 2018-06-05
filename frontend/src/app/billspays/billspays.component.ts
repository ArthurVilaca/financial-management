import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';
import { PageEvent } from '@angular/material';

@Component({
  selector: 'app-billspays',
  templateUrl: './billspays.component.html',
  styleUrls: ['./billspays.component.scss']
})
export class BillspaysComponent {
  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search() {
    this.http.get('/billspay')
      .then((data: any) => {
        this.appState.set('billspays', data.dataset.billspays);
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
