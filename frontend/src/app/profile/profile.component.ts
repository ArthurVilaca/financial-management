import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent {
  profile: any = {};

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
  }

  save() {
    this.http.post('/profile', this.profile)
      .then((data: any) => {
        this.router.navigate(['home']).then(_ => {});
      })
      .catch((error) => {
        this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
      });
  }
}
