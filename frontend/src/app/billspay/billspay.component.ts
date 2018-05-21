import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-billspay',
  templateUrl: './billspay.component.html',
  styleUrls: ['./billspay.component.scss']
})
export class BillspayComponent {
  billspay: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadBillspay();
  }
  
  loadBillspay() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/billspay/' + params['id'])
          .then((data: any) => {
            this.billspay = data.dataset.billspay;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  save() {
    if(this.billspay.id) {
      this.http.put('/billspay/' + this.billspay.id, this.billspay)
        .then((data: any) => {
          this.router.navigate(['contasAPagar']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/billspay', this.billspay)
        .then((data: any) => {
          this.router.navigate(['contasAPagar']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }
}
