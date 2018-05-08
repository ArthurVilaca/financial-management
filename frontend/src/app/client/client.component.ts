import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-client',
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.css']
})
export class ClientComponent {
  client: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) { }

  save() {
    this.http.post('/clients', this.client)
      .then((data: any) => {
      })
      .catch((error) => {
        this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
      });
  }

}
