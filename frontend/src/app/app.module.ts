import { BrowserModule } from '@angular/platform-browser';
import { NgModule, LOCALE_ID } from '@angular/core';
import { registerLocaleData } from '@angular/common';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule, FormControl ,ReactiveFormsModule} from '@angular/forms';

import { HttpClientModule, HttpClient } from '@angular/common/http';
import { HttpModule } from '@angular/http';
import localePt from '@angular/common/locales/pt';

registerLocaleData(localePt);

import { ProviderService } from './provider.service';
import { HttpService } from './http.service';
import { AuthGuard } from './auth.guard';

// routes
import { RouterModule } from '@angular/router';
import { rootRouterConfig } from './app.routes';

// material
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatDialogModule } from '@angular/material/dialog';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { MatIconModule } from '@angular/material/icon';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatMenuModule } from '@angular/material/menu';
import { MatListModule } from '@angular/material/list';
import { MatCardModule } from '@angular/material/card';
import { MatTabsModule } from '@angular/material/tabs';
import { MatSelectModule } from '@angular/material/select';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatAutocompleteModule, MatNativeDateModule, MAT_DATE_LOCALE } from '@angular/material';
import { MatRadioModule } from '@angular/material/radio';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatChipsModule } from '@angular/material/chips';
import { MatSortModule } from '@angular/material/sort';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatCheckboxModule} from '@angular/material/checkbox';





import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { SideNavComponent } from './side-nav/side-nav.component';
import { MessageDialogComponent } from './message-dialog/message-dialog.component';
import { DialogOverviewExampleDialog } from './message-dialog/message-dialog-overview';
import { ClientsComponent } from './clients/clients.component';
import { ClientComponent } from './client/client.component';
import { TaxesComponent } from './taxes/taxes.component';
import { TaxComponent } from './tax/tax.component';
import { ProfileComponent } from './profile/profile.component';
import { ProvidersComponent } from './providers/providers.component';
import { ProviderComponent } from './provider/provider.component';
import { EmployeesComponent } from './employees/employees.component';
import { EmployeeComponent } from './employee/employee.component';
import { RouteOrientationComponent } from './route-orientation/route-orientation.component';
import { TaxSelectionComponent } from './tax-selection/tax-selection.component';
import { BanksComponent } from './banks/banks.component';
import { BankComponent } from './bank/bank.component';
import { CostCentersComponent } from './cost-centers/cost-centers.component';
import { CostCenterComponent } from './cost-center/cost-center.component';
import { ProjectsComponent } from './projects/projects.component';
import { ProjectComponent } from './project/project.component';
import { BillspaysComponent } from './billspays/billspays.component';
import { BillspayComponent } from './billspay/billspay.component';
import { BillsreceivesComponent } from './billsreceives/billsreceives.component';
import { BillsreceiveComponent } from './billsreceive/billsreceive.component';
import { SearchBillsComponent } from './search-bills/search-bills.component';
import { SearchPersonComponent } from './search-person/search-person.component';
import { ReportsComponent } from './reports/reports.component';
import { ReportBillspayComponent } from './report-billspay/report-billspay.component';
import { ReportBillsreceiveComponent } from './report-billsreceive/report-billsreceive.component';
import { ReportCashflowComponent } from './report-cashflow/report-cashflow.component';
import { SearchProjectsComponent } from './search-projects/search-projects.component';
import { AgGridModule } from 'ag-grid-angular';

import { NgxChartsModule } from '@swimlane/ngx-charts';
import { LoansComponent } from './loans/loans.component';
import { LoanComponent } from './loan/loan.component';
import { PaymentMethodsComponent } from './payment-methods/payment-methods.component';
import { PaymentMethodComponent } from './payment-method/payment-method.component';
import { BankReconciliationComponent } from './bank-reconciliation/bank-reconciliation.component';
import { ConciliationComponent } from './conciliation/conciliation.component';
import { ConciliationBillComponent } from './conciliation-bill/conciliation-bill.component';
import { ReportCashflowMonthComponent } from './report-cashflow-month/report-cashflow-month.component';
import { ReportDreCashflowComponent } from './report-dre-cashflow/report-dre-cashflow.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    SideNavComponent,
    MessageDialogComponent,
    DialogOverviewExampleDialog,
    ClientsComponent,
    ClientComponent,
    TaxesComponent,
    TaxComponent,
    ProfileComponent,
    ProvidersComponent,
    ProviderComponent,
    EmployeesComponent,
    EmployeeComponent,
    RouteOrientationComponent,
    TaxSelectionComponent,
    BanksComponent,
    BankComponent,
    CostCentersComponent,
    CostCenterComponent,
    ProjectsComponent,
    ProjectComponent,
    BillspaysComponent,
    BillspayComponent,
    BillsreceivesComponent,
    BillsreceiveComponent,
    SearchBillsComponent,
    SearchPersonComponent,
    ReportsComponent,
    ReportBillspayComponent,
    ReportBillsreceiveComponent,
    ReportCashflowComponent,
    SearchProjectsComponent,
    LoansComponent,
    LoanComponent,
    PaymentMethodsComponent,
    PaymentMethodComponent,
    BankReconciliationComponent,
    ConciliationComponent,
    ConciliationBillComponent,
    ReportCashflowMonthComponent,
    ReportDreCashflowComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    RouterModule.forRoot(rootRouterConfig, { useHash: true }),
    HttpClientModule,
    HttpModule,
    MatInputModule,
    MatButtonModule,
    MatDialogModule,
    MatSidenavModule,
    MatProgressBarModule,
    MatIconModule,
    MatToolbarModule,
    MatMenuModule,
    MatListModule,
    MatCardModule,
    MatTabsModule,
    MatSelectModule,
    MatDatepickerModule,
    MatAutocompleteModule,
    MatNativeDateModule,
    MatRadioModule,
    MatExpansionModule,
    MatPaginatorModule,
    MatChipsModule,
    MatSortModule,
    AgGridModule.withComponents([]),
    NgxChartsModule,
    MatCheckboxModule,
    MatFormFieldModule,
    ReactiveFormsModule,
  ],
  providers: [ ProviderService, HttpService, AuthGuard, HttpClientModule, MessageDialogComponent, { provide: MAT_DATE_LOCALE, useValue: 'pt-BR' }, { provide: LOCALE_ID, useValue: 'pt-BR' }],
  bootstrap: [AppComponent],
  entryComponents: [ DialogOverviewExampleDialog, TaxSelectionComponent, SearchBillsComponent, SearchPersonComponent, SearchProjectsComponent ]
})
export class AppModule { }
