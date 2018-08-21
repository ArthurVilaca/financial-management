import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'

@Component({
  selector: 'app-search-bills',
  templateUrl: './search-bills.component.html',
  styleUrls: ['./search-bills.component.scss']
})
export class SearchBillsComponent {
  filter: any = {};

  constructor(
    public dialogRef: MatDialogRef<SearchBillsComponent>, private http: HttpService,
    private appState: ProviderService,
    @Inject(MAT_DIALOG_DATA) public data: any) {
      this.filter = data.filter;
      if(!this.appState.provider.projects) {
        this.searchProjects();
      }
      if(!this.appState.provider.clients) {
        this.searchClients();
      }
  }
  
  onNoClick(): void {
    this.dialogRef.close(this.filter);
  }

  searchProjects() {
    this.http.get('/projects')
      .then((data: any) => {
        this.appState.set('projects', data.dataset.projects);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  searchClients() {
    this.http.get('/clients')
      .then((data: any) => {
        this.appState.set('clients', data.dataset.clients);
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
