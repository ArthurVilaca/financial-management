import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['./project.component.scss']
})
export class ProjectComponent {
  projects: any = {
    projects_phases: []
  };

  billspay: any ={}
  providers: any = []
  banks: any = []

  data: any[] = [
    {
      "name": "A Pagar",
      "series": [
        {
          "name": "06-2018",
          "value": 200,
        },
        {
          "name": "07-2018",
          "value": 300,
        },
        {
          "name": "08-2018",
          "value": 280,
        },
        {
          "name": "09-2018",
          "value": 120,
        },
        {
          "name": "10-2018",
          "value": 30,
        }
      ]
    },
  ​
    {
      "name": "A Receber",
      "series": [
        {
          "name": "06-2018",
          "value": 120,
        },
        {
          "name": "07-2018",
          "value": 150,
        },
        {
          "name": "08-2018",
          "value": 160,
        },
        {
          "name": "09-2018",
          "value": 80,
        },
        {
          "name": "10-2018",
          "value": 40,
        }
      ]
    }
  ]

  view: any[] = [900, 400];

  // options
  showXAxis = true;
  showYAxis = true;
  gradient = false;
  showXAxisLabel = true;
  showYAxisLabel = true;
  xAxisLabel = 'Conta';
  yAxisLabel = 'Valor';

  colorScheme = {
    domain: ['#5AA454', '#A10A28', '#C7B42C', '#AAAAAA']
  };

  // line, area
  autoScale = true;

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.loadProject();
    this.loadFillData();
  }



  loadFillData() {
    this.http.get('/clients')
      .then((data: any) => {
        this.appState.set('clients', data.dataset.clients);
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

    this.http.get('/banks')
      .then((data: any) => {
        this.appState.set('banks', data.dataset.banks);
        this.banks = this.appState.provider.banks;
        console.log('banks',this.banks);
      })
      .catch((error) => {
        console.log(error);
      });

      this.http.get('/taxes')
      .then((data: any) => {
        this.appState.set('taxes', data.dataset.taxes);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  addPhase() {
    this.projects.projects_phases.push({});
  }

  loadProject() {
    this.route.params.subscribe(params => {
      if(params['id']) {
        this.http.get('/projects/' + params['id'])
          .then((data: any) => {
            this.projects = data.dataset.projects;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    });
  }

  save() {
    if(this.projects.id) {
      this.http.put('/projects/' + this.projects.id, this.projects)
        .then((data: any) => {
          this.router.navigate(['projetos']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    } else {
      this.http.post('/projects', this.projects)
        .then((data: any) => {
          this.router.navigate(['projetos']).then(_ => {});

         /* this.http.post('/billspay', this.billspay)
        .then((data: any) => {
          this.router.navigate(['contasAPagar']).then(_ => {});
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });*/


        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }
}
