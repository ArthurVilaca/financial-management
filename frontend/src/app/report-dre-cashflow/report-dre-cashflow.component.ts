import { Component, OnInit } from '@angular/core';
import {FormControl} from '@angular/forms';
import {MomentDateAdapter} from '@angular/material-moment-adapter';
import {DateAdapter, MAT_DATE_FORMATS, MAT_DATE_LOCALE} from '@angular/material/core';
import {MatDatepicker} from '@angular/material/datepicker';
import { AgGridModule, AgGridNg2 } from 'ag-grid-angular';
import { HttpService } from '../http.service';
import { ProviderService } from '../provider.service';
import { HttpClient } from '@angular/common/http';


@Component({
  selector: 'app-report-dre-cashflow',
  templateUrl: './report-dre-cashflow.component.html',
  styleUrls: ['./report-dre-cashflow.component.scss'],
})
export class ReportDreCashflowComponent implements OnInit {



  date: any;
  length: number;

  columnDefs = [
    {headerName: '', field: '0' },
    {headerName: 'Jan', field: '1' },
    {headerName: 'Fev', field: '2'},
    {headerName: 'Mar', field: '3'},
    {headerName: 'Abr', field: '4'},
    {headerName: 'Mai', field: '5'},
    {headerName: 'Jun', field: '6'},
    {headerName: 'Jul', field: '7'},
    {headerName: 'Ago', field: '8'},
    {headerName: 'Set', field: '9'},
    {headerName: 'Out', field: '10'},
    {headerName: 'Nov', field: '11'},
    {headerName: 'Dez', field: '12'},
    {headerName: 'Total', field: '13'},
  ];

  rowData: any = [];

  constructor(private http: HttpService, private appState: ProviderService, private httpClient: HttpClient) {

    let d = new Date();
    console.log('typeOf', typeof(d.getFullYear()));
    this.date  = d.getFullYear();
    this.search();
   }

  ngOnInit() {

  }

  search(){
    this.http.get('/reports/CashFlow/dre?year=' + this.date)
      .then((data: any) => {
        this.appState.set('reportDreCashFlow', data.dataset.reportDreCashFlow);
        this.rowData = this.appState.provider.reportDreCashFlow;
        this.length = data.dataset.total;
      })
      .catch((error) => {
        console.log(error);
      });
  }

}
