import { Component, OnInit } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog, PageEvent } from '@angular/material';
import { Router } from '@angular/router';
import { Sort } from '@angular/material';
import {FormControl} from '@angular/forms';
import {MomentDateAdapter} from '@angular/material-moment-adapter';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import {MatDatepicker} from '@angular/material/datepicker';

// Depending on whether rollup is used, moment needs to be imported differently.
// Since Moment.js doesn't have a default export, we normally need to import using the `* as`
// syntax. However, rollup creates a synthetic default module and we thus need to import it using
// the `default as` syntax.
import * as _moment from 'moment';
// tslint:disable-next-line:no-duplicate-imports
import {default as _rollupMoment, Moment} from 'moment';

const moment = _rollupMoment || _moment;

// See the Moment.js docs for the meaning of these formats:
// https://momentjs.com/docs/#/displaying/format/
export const MY_FORMATS = {
  parse: {
    dateInput: 'MM/YYYY',
  },
  display: {
    dateInput: 'MM/YYYY',
    monthYearLabel: 'MMM YYYY',
    dateA11yLabel: 'LL',
    monthYearA11yLabel: 'MMMM YYYY',
  },
};

@Component({
  selector: 'app-report-cashflow',
  templateUrl: './report-cashflow.component.html',
  styleUrls: ['./report-cashflow.component.scss'],
  providers: [
    // `MomentDateAdapter` can be automatically provided by importing `MomentDateModule` in your
    // application's root module. We provide it at the component level here, due to limitations of
    // our example generation script.
    {provide: DateAdapter, useClass: MomentDateAdapter, deps: [MAT_DATE_LOCALE]},

    {provide: MAT_DATE_FORMATS, useValue: MY_FORMATS},
  ],
})
export class ReportCashflowComponent  {

  filterDate = moment();

  chosenYearHandler(normalizedYear: Moment) {
    const ctrlValue = this.filterDate;
    ctrlValue.year(normalizedYear.year());
    this.filterDate = ctrlValue;
  }

  chosenMonthHandler(normlizedMonth: Moment, datepicker: MatDatepicker<Moment>) {
    const ctrlValue = this.filterDate;
    ctrlValue.month(normlizedMonth.month());
    this.filterDate = ctrlValue;
    datepicker.close();
  }

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

      let date = this.filterDate.toDate();
      let month = date.getMonth();
      let year = date.getFullYear();
      let numberDays = this.getDaysInMonth(month,year);
      let filter = ({
        month: month,
        year: year,
        numberDays: numberDays
      });

      let filterJson = JSON.stringify(filter);

      this.http.get('/reports?page=' + page + '&pageSize=' + this.pageSize+ '&filter=' + filterJson)
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

  getDaysInMonth(month,year) {
    // Here January is 1 based
    //Day 0 is the last day in the previous month
   return new Date(year, month, 0).getDate();
    // Here January is 0 based
    // return new Date(year, month+1, 0).getDate();
  };
}
