import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-tax',
  templateUrl: './tax.component.html',
  styleUrls: ['./tax.component.css']
})
export class TaxComponent {
  tax: any = {
    type: 'RECEITA'
  };

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) { }

  save() {
    this.http.post('/taxes', this.tax)
      .then((data: any) => {
      })
      .catch((error) => {
        this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
      });
  }

}
