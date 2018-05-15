import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-bank',
  templateUrl: './bank.component.html',
  styleUrls: ['./bank.component.scss']
})
export class BankComponent {
  bank: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadData();
  }
  
  loadData() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/banks/' + params['id'])
          .then((data: any) => {
            this.bank = data.dataset.bank;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  save() {
    if(this.bank.id) {
      this.http.put('/banks/' + this.bank.id, this.bank)
        .then((data: any) => {
          this.router.navigate(['bancos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/banks', this.bank)
        .then((data: any) => {
          this.router.navigate(['bancos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

}
