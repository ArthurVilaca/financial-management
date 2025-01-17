import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-billsreceive',
  templateUrl: './billsreceive.component.html',
  styleUrls: ['./billsreceive.component.scss']
})
export class BillsreceiveComponent {
  billsreceive: any = {};
  filter: string = "RECEITA";
  deductions: any [];

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadBillsreceive();
    console.log('USERS', this.appState.provider);

  }

  loadBillsreceive() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/billsreceive/' + params['id'])
          .then((data: any) => {
            this.appState.set('billsreceive',data.dataset.billsreceive);
            this.billsreceive = this.appState.provider.billsreceive;

            if(this.billsreceive.invoice_date != '') {
              this.billsreceive.invoice_date = new Date(this.billsreceive.invoice_date);
            }
            if(this.billsreceive.payment_date != '') {
              this.billsreceive.payment_date = new Date(this.billsreceive.payment_date);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }

      this.http.get('/loadDeductions/' + params['id'])
        .then((data: any) => {
          this.deductions = data.dataset.banks;
        })
        .catch((error) => {
          console.log(error);
        });
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
      })
      .catch((error) => {
        console.log(error);
      });
  }

  generateInvoice(){

    this.billsreceive.projectInvoice = 'INVOICE';

    this.http.post('/billsreceive', this.billsreceive)
        .then((data: any) => {

          this.message.openDialog('Aviso !!!', 'Nota afiscal gerada com sucesso!');
          this.router.navigate(['contasAReceber']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });

  }

  save() {
    if(this.billsreceive.id) {
      this.http.put('/billsreceive/' + this.billsreceive.id, this.billsreceive)
        .then((data: any) => {
          this.router.navigate(['contasAReceber']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.billsreceive.user = this.appState.provider.user.name;
      console.log('billsreceive',this.billsreceive);
      this.http.post('/billsreceive', this.billsreceive)
        .then((data: any) => {
          this.router.navigate(['contasAReceber']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

}
