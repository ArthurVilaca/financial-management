import { Component, OnInit } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog } from '@angular/material';
import { Router } from '@angular/router';
import { Sort } from '@angular/material';

@Component({
  selector: 'app-report-cashflow',
  templateUrl: './report-cashflow.component.html',
  styleUrls: ['./report-cashflow.component.scss']
})
export class ReportCashflowComponent  {

  billspays: any[] = [];
  sortedData: any[] = [];
  filter: any = {
    prevista: true,
    efetuada: true
  }

  constructor(public dialog: MatDialog, private router: Router, private message: MessageDialogComponent,
    private http: HttpService, private appState: ProviderService) {
    this.search();
   }

  search() {
    this.http.get('/reports/billspay?' + this.http.serialize(this.filter))
      .then((data: any) => {
        this.billspays = data.dataset.billspays;
        this.sortedData = this.billspays;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  sortData(sort: Sort) {
    const data = this.billspays.slice();
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
