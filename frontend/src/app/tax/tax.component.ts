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
    reference: 'RECEITA',
    type: 'FEDERAL'
  };

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/taxes/' + params['id'])
          .then((data: any) => {
            this.tax = data.dataset.tax;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  save() {
    if(this.tax.id) {
      this.http.put('/taxes/' + this.tax.id, this.tax)
        .then((data: any) => {
          this.router.navigate(['impostos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/taxes', this.tax)
        .then((data: any) => {
          this.router.navigate(['impostos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

}
