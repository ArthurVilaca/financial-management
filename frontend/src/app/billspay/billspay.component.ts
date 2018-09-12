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
  filter : String = "DESPESA";
  providers: any;
  projects: any;

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadBillspay();
  }

  loadBillspay() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/billspay/' + params['id'])
          .then((data: any) => {
            this.billspay = data.dataset.billspay;
            if(this.billspay.invoice_date != '') {
              this.billspay.invoice_date = new Date(this.billspay.invoice_date);
            }
            if(this.billspay.payment_date != '') {
              this.billspay.payment_date = new Date(this.billspay.payment_date);
            }
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

    this.http.get('/cost_centers?filter='+this.filter)
      .then((data: any) => {

        this.appState.set('cost_centers', data.dataset.costCenters);
      })
      .catch((error) => {
        console.log(error);
      });

    this.http.get('/projects')
      .then((data: any) => {
        this.appState.set('projects', data.dataset.projects);
        this.projects = this.appState.provider.projects;
      })
      .catch((error) => {
        console.log(error);
      });

    this.http.get('/providers')
      .then((data: any) => {
        this.appState.set('providers', data.dataset.providers);
        this.providers = this.appState.provider.providers;
      })
      .catch((error) => {
        console.log(error);
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
