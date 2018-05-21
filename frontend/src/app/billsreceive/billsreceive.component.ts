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

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadBillsreceive();
  }
  
  loadBillsreceive() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/billsreceive/' + params['id'])
          .then((data: any) => {
            this.billsreceive = data.dataset.billsreceive;
          })
          .catch((error) => {
            console.log(error);
          });
      }
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
