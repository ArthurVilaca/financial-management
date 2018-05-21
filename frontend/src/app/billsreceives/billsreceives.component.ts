import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';

@Component({
  selector: 'app-billsreceives',
  templateUrl: './billsreceives.component.html',
  styleUrls: ['./billsreceives.component.scss']
})
export class BillsreceivesComponent {

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search() {
    this.http.get('/billsreceive')
      .then((data: any) => {
        this.appState.set('billsreceives', data.dataset.billsreceive);
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
