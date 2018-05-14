import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { TaxSelectionComponent } from '../tax-selection/tax-selection.component';

@Component({
  selector: 'app-client',
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.css']
})
export class ClientComponent {
  client: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService, public dialog: MatDialog) {
    this.loadClient();
  }
  
  loadClient() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/clients/' + params['id'])
          .then((data: any) => {
            this.client = data.dataset.client;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  searchZip() {
    if(this.client.zip_code) {
      if(this.client.zip_code.length >= 7) {
        this.http.get('/zipcode/' + this.client.zip_code)
          .then((data: any) => {
            this.client.adress = data.logradouro;
            this.client.adress_district = data.bairro;
            this.client.city = data.localidade;
            this.client.state = data.uf;
          })
          .catch((error) => {
          });
      }
    }
  }

  save() {
    if(this.client.id) {
      this.http.put('/clients/' + this.client.id, this.client)
        .then((data: any) => {
          this.router.navigate(['clientes']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/clients', this.client)
        .then((data: any) => {
          this.router.navigate(['clientes']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

  pushTax() {
    let dialogRef = this.dialog.open(TaxSelectionComponent, {
      width: '80%',
      data: { }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      if(result) {
        this.route.params.subscribe(params => {
          this.http.post('/tax/client/' + params['id'], result)
            .then((data: any) => {
              this.loadClient();
            })
            .catch((error) => {
              this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
            });
        });
      }
    });
  }

}
