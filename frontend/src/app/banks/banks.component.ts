import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';

@Component({
  selector: 'app-banks',
  templateUrl: './banks.component.html',
  styleUrls: ['./banks.component.scss']
})
export class BanksComponent {

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search() {
    this.http.get('/banks')
      .then((data: any) => {
        this.appState.set('banks', data.dataset.banks);
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
