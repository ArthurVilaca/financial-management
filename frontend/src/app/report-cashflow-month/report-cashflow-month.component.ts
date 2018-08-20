import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog, PageEvent } from '@angular/material';
import { Router } from '@angular/router';
import { Sort } from '@angular/material';
import { SearchCostcenterComponent } from '../search-costcenter/search-costcenter.component';

@Component({
  selector: 'app-report-cashflow-month',
  templateUrl: './report-cashflow-month.component.html',
  styleUrls: ['./report-cashflow-month.component.scss']
})
export class ReportCashflowMonthComponent {

  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];
  filter: any = {};


  // MatPaginator Output
  pageEvent: PageEvent;

  sortedData:any;



  constructor(public dialog: MatDialog, private http: HttpService, private appState: ProviderService) {
    this.search();
   }

  ngOnInit() {
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
      this.http.get('/reports?page=' + page + '&pageSize=' + this.pageSize+'&filter='+this.filter)
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

  openFilter() {
    let dialogRef = this.dialog.open(SearchCostcenterComponent, {
      width: '70%',
      height: '400px',
      data: { filter: this.filter }
    });
    dialogRef.afterClosed().subscribe(result => {
      this.filter = result;
      this.search();
    });
  }

}
