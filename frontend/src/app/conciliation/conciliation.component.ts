import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { PageEvent } from '@angular/material';
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog } from '@angular/material';

@Component({
  selector: 'app-conciliation',
  templateUrl: './conciliation.component.html',
  styleUrls: ['./conciliation.component.scss']
})
export class ConciliationComponent {
  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];
  filter: any = {};
  total = 0

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(public dialog: MatDialog, private http: HttpService, private appState: ProviderService) { }

  ngOnInit() {
    this.search();
  }

  search($event?) {
    if($event){
      this.pageEvent = $event;
      this.pageSize = $event.pageSize;
    }
    let page = 0;
    if(this.pageEvent) {
      page = this.pageEvent.pageIndex;
    }
    this.http.get('/bills?page=' + page + '&pageSize=' + this.pageSize + '&' + this.http.serialize(this.filter))
      .then((data: any) => {
        this.appState.set('bills', data.dataset.bills);
        this.length = data.dataset.total;
        this.total = data.dataset.amount;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  openFilter() {
    let dialogRef = this.dialog.open(SearchBillsComponent, {
      width: '70%',
      height: '400px',
      data: { filter: this.filter }
    });
    dialogRef.afterClosed().subscribe(result => {
      this.filter = result;
      this.search();
    });
  }

  getBank(id) {
    for(let i in this.appState.provider.banks) {
      if(this.appState.provider.banks[i].id == id) {
        return this.appState.provider.banks[i].name;
      }
    }
    return '';
  }

  conciliate() {
    
  }
}
