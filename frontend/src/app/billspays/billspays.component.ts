import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';

@Component({
  selector: 'app-billspays',
  templateUrl: './billspays.component.html',
  styleUrls: ['./billspays.component.scss']
})
export class BillspaysComponent {

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search() {
    this.http.get('/billspay')
      .then((data: any) => {
        this.appState.set('billspays', data.dataset.billspay);
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
