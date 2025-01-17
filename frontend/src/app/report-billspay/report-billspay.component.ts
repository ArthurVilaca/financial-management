import { element } from 'protractor';
import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog } from '@angular/material';
import { Router } from '@angular/router';
import { Sort } from '@angular/material';
import { Angular5Csv } from 'angular5-csv/Angular5-csv';

@Component({
  selector: 'app-report-billspay',
  templateUrl: './report-billspay.component.html',
  styleUrls: ['./report-billspay.component.scss']
})
export class ReportBillspayComponent {
  billspays: any[] = [];
  sortedData: any[] = [];

  columnDefs = [
    {headerName: 'Id', field: 'id' },
    {headerName: 'Nome', field: 'name' },
    {headerName: 'R$', field: 'amount'},
    {headerName: 'Nº de Contas', field: 'bills'},
    {headerName: 'Tipo', field: 'typeCost'},
  ];

  rowData = [];
  exportExcel: any = []


  filter: any = {
    prevista: true,
    efetuada: true
  }

  constructor(public dialog: MatDialog, private router: Router, private message: MessageDialogComponent,
    private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  search() {
    this.http.get('/reports/expenses?' + this.http.serialize(this.filter))
      .then((data: any) => {
        this.billspays = data.dataset.billspaysExpenses;
        this.rowData = this.billspays;
        this.rowData.forEach(element => {
          this.exportExcel.push({
            name: element.name,
            amount: element.amount,
            bills: element.bills,
            type: element.type,
            typeCost: element.typeCost
          });
        });
        this.sortedData = this.billspays;
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
      if(result) {
        console.log(result)
        this.filter = result;
        this.search();
      }
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
        case 'bills': return this.compare(a.bills, b.bills, isAsc);
        case 'amount': return this.compare(a.amount, b.amount, isAsc);
        default: return 0;
      }
    });
  }

  compare(a, b, isAsc) {
    return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
  }

  exportCSV(){
    var options = {
      fieldSeparator: ',',
      quoteStrings: '"',
      decimalseparator: '.',
      showLabels: false,
      showTitle: false,
      useBom: false,
      noDownload: false,
      headers: ["Nome Centros de Custo (Contas a Pagar)","Valor", "Nº de Contas", "Tipo", "Tipo Centro de Custo"]
    };

    new Angular5Csv(this.exportExcel, 'RelatórioContasPagarCentroCusto', options);
  }
}
