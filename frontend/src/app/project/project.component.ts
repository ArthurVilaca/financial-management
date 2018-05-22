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
        })
        .catch((error) => {
          this.message.openDialog('Atenção', 'Erro ao tentar salvar, favor entrar em contato com o administrador!');
        });
    }
  }
}
