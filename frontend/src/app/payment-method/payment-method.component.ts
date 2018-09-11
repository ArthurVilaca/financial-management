import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-payment-method',
  templateUrl: './payment-method.component.html',
  styleUrls: ['./payment-method.component.scss']
})
export class PaymentMethodComponent {
  paymentMethod: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/paymentMethods/' + params['id'])
          .then((data: any) => {
            this.paymentMethod = data.dataset.paymentMethods;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });

    this.http.get('/banks')
      .then((data: any) => {
        this.appState.set('banks', data.dataset.banks);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  save() {
    if(this.paymentMethod.id) {
      this.http.put('/paymentMethods/' + this.paymentMethod.id, this.paymentMethod)
        .then((data: any) => {
          this.router.navigate(['metodosPagamentos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/paymentMethods', this.paymentMethod)
        .then((data: any) => {
          this.router.navigate(['metodosPagamentos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }
}
