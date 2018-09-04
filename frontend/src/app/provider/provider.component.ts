import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { TaxSelectionComponent } from '../tax-selection/tax-selection.component';

@Component({
  selector: 'app-provider',
  templateUrl: './provider.component.html',
  styleUrls: ['./provider.component.css']
})
export class ProviderComponent {
  provider: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService, public dialog: MatDialog) {
    this.loadProvider();
  }
  
  loadProvider() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/providers/' + params['id'])
          .then((data: any) => {
            this.provider = data.dataset.provider;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  searchZip() {
    if(this.provider.zip_code) {
      if(this.provider.zip_code.length >= 7) {
        this.http.get('/zipcode/' + this.provider.zip_code)
          .then((data: any) => {
            this.provider.adress = data.logradouro;
            this.provider.adress_district = data.bairro;
            this.provider.city = data.localidade;
            this.provider.state = data.uf;
          })
          .catch((error) => {
          });
      }
    }
  }

  save() {
    if(this.provider.id) {
      this.http.put('/providers/' + this.provider.id, this.provider)
        .then((data: any) => {
          this.router.navigate(['fornecedores']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/providers', this.provider)
        .then((data: any) => {
          this.router.navigate(['fornecedores']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

  pushTax() {
    let dialogRef = this.dialog.open(TaxSelectionComponent, {
      width: '80%',
      data: {
        header: 'Seleçao de Taxas'
      }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      for(let i in result) {
        if(result[i].checked) {
          this.route.params.subscribe(params => {
            this.http.post('/tax/provider/' + params['id'], result[i])
              .then((data: any) => {
                this.loadProvider();
              })
              .catch((error) => {
                this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
              });
          });
        }
      }
    });
  }
}
