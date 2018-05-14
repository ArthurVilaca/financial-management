import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-employee',
  templateUrl: './employee.component.html',
  styleUrls: ['./employee.component.scss']
})
export class EmployeeComponent {
  employee: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/employees/' + params['id'])
          .then((data: any) => {
            this.employee = data.dataset.employee;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  searchZip() {
    if(this.employee.zip_code) {
      if(this.employee.zip_code.length >= 7) {
        this.http.get('/zipcode/' + this.employee.zip_code)
          .then((data: any) => {
            this.employee.adress = data.logradouro;
            this.employee.adress_district = data.bairro;
            this.employee.city = data.localidade;
            this.employee.state = data.uf;
          })
          .catch((error) => {
          });
      }
    }
  }

  save() {
    if(this.employee.id) {
      this.http.put('/employees/' + this.employee.id, this.employee)
        .then((data: any) => {
          this.router.navigate(['funcionarios']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/employees', this.employee)
        .then((data: any) => {
          this.router.navigate(['funcionarios']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

}
