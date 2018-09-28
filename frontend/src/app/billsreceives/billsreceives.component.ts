import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { Angular5Csv } from 'angular5-csv/Angular5-csv'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';
import { PageEvent } from '@angular/material';
import { SearchBillsComponent } from '../search-bills/search-bills.component';
import { MatDialog } from '@angular/material';

@Component({
  selector: 'app-billsreceives',
  templateUrl: './billsreceives.component.html',
  styleUrls: ['./billsreceives.component.scss']
})
export class BillsreceivesComponent {
  length = 100;
  pageSize = 10;
  billsreceive: any = [];
  exportExcel: any = []
  userName: string;
  pageSizeOptions = [5, 10, 25, 100];
  filter: any = {};
  total = 0

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService, public dialog: MatDialog) {
    this.search();
    if(!this.appState.provider.banks) {
      this.searchBanks();
    }
  }

  searchBanks() {
    this.http.get('/banks')
      .then((data: any) => {
        this.appState.set('banks', data.dataset.banks);
      })
      .catch((error) => {
        console.log(error);
      });
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
    this.http.get('/billsreceive?page=' + page + '&pageSize=' + this.pageSize + '&' + this.http.serialize(this.filter))
      .then((data: any) => {
        this.appState.set('billsreceives', data.dataset.billsreceive);
        this.billsreceive = data.dataset.billsreceive;
        this.billsreceive.forEach(element => {
          this.exportExcel.push({
            name: element.name,
            status: element.status,
            conciliation: element.conciliation,
            amount: element.amount,
            bank: this.getBank(element.banks_id),
            due_date: element.payment_date,
            type: element.type,
            emloyee: element.employee
          });
        });
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
      if(result) {
        this.filter = result;
        this.search();
      }
    });
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
      headers: ["Nome", "Status","Conciliação", "Valor", "Banco","Data de Vencimento", "Tipo", "Usuário"]
    };
    new Angular5Csv(this.exportExcel, 'ContasAReceber', options);
  }

  getBank(id) {
    for(let i in this.appState.provider.banks) {
      if(this.appState.provider.banks[i].id == id) {
        return this.appState.provider.banks[i].name;
      }
    }
    return '';
  }
}
