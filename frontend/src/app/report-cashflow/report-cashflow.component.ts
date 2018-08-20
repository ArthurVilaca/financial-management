import { Component, OnInit } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog, PageEvent } from '@angular/material';
import { Router } from '@angular/router';
import { Sort } from '@angular/material';

@Component({
  selector: 'app-report-cashflow',
  templateUrl: './report-cashflow.component.html',
  styleUrls: ['./report-cashflow.component.scss']
})
export class ReportCashflowComponent  {

  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];

  // MatPaginator Output
  pageEvent: PageEvent;


  billsExpenses: any[] = [];
  billsReceive: any[] = [];
  sortedData: any[] = [];
  filter: string = 'Efetuada';
  /*filter: any = {
    prevista: true,
    efetuada: true
  }*/

  constructor(public dialog: MatDialog, private router: Router, private message: MessageDialogComponent,
    private http: HttpService, private appState: ProviderService) {
    this.search();
   }

  search($event?) {
    /*this.http.get('/reports/expenses?filter=' + this.filter)
      .then((data: any) => {
        this.billsExpenses = data.dataset.billspaysExpenses;
        this.sortedData = this.billsExpenses;
        console.log('this.billsExpenses',this.billsExpenses)
      })
      .catch((error) => {
        console.log(error);
      });*/

      if($event){
        this.pageEvent = $event;
        this.pageSize = $event.pageSize;
      }
      let page = 0;
      if(this.pageEvent) {
        page = this.pageEvent.pageIndex;
      }
      this.http.get('/reports?page=' + page + '&pageSize=' + this.pageSize)
        .then((data: any) => {
          console.log('DataGet',data);
          this.appState.set('billPayReceive', data.dataset.billPayReceive);
          this.sortedData = this.appState.provider.billPayReceive;
          this.length = data.dataset.total;
        })
        .catch((error) => {
          console.log(error);
        });
  }

  sortData(sort: Sort) {
    const data = this.billsExpenses.slice();
    if (!sort.active || sort.direction === '') {
      this.sortedData = data;
      return;
    }

  this.sortedData = data.sort((a, b) => {
    const isAsc = sort.direction === 'asc';
    switch (sort.active) {
      case 'name': return this.compare(a.name, b.name, isAsc);
      case 'recipes': return this.compare(a.recipes, b.recipes, isAsc);
      case 'expenses': return this.compare(a.expenses, b.expenses, isAsc);
      case 'profit': return this.compare(a.profit, b.profit, isAsc);
      default: return 0;
    }
    });
  }

  compare(a, b, isAsc) {
    return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
  }
}
