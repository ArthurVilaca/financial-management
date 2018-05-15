import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-cost-center',
  templateUrl: './cost-center.component.html',
  styleUrls: ['./cost-center.component.scss']
})
export class CostCenterComponent {
  cost_centers: any = {};

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadData();
  }
  
  loadData() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/cost_centers/' + params['id'])
          .then((data: any) => {
            this.cost_centers = data.dataset.costCenter;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  save() {
    if(this.cost_centers.id) {
      this.http.put('/cost_centers/' + this.cost_centers.id, this.cost_centers)
        .then((data: any) => {
          this.router.navigate(['centroDeCustos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/cost_centers', this.cost_centers)
        .then((data: any) => {
          this.router.navigate(['centroDeCustos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }

}
