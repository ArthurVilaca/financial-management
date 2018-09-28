import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router } from '@angular/router';
import { Angular5Csv } from 'angular5-csv/Angular5-csv';


@Component({
  selector: 'app-loans',
  templateUrl: './loans.component.html',
  styleUrls: ['./loans.component.scss']
})
export class LoansComponent {

  constructor(private router: Router, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) {
    this.search();
  }

  loans: any = []
  exportExcel: any = []

  search() {
    this.http.get('/loans')
      .then((data: any) => {
        this.appState.set('loans', data.dataset.loans);
        this.loans = this.appState.provider.loans;

        this.loans.forEach(element => {
          this.exportExcel.push({
            bank: element.bank.name,
            interest: element.interest,
            admin_taxes: element.admin_taxes,
            plots: element.plots,
            value_plots: element.value_plots,
            due_date: this.formatDate( new Date(element.due_date.date)),
            issue_date: this.formatDate( new Date(element.issue_date)),
            amount: element.amount
          })
        });
      })
      .catch((error) => {
        console.log(error);
      });
  }

  exportCSV(){
    console.log('exportExcel',this.exportExcel)
    var options = {
      fieldSeparator: ',',
      quoteStrings: '"',
      decimalseparator: '.',
      showLabels: false,
      showTitle: false,
      useBom: false,
      noDownload: false,
      headers: ["Banco", "Juros", "Taxa de Administração", "Número de parcelas", "Valor Parcelas", "Data de Vencimento", "Data de Emissão", "Valor"]
    };

    new Angular5Csv(this.exportExcel, 'Emprestimos', options);
  }

  formatDate(value){
    return value.getDate() + "/" + value.getMonth()+1  + "/" + value.getFullYear();
  }
}
