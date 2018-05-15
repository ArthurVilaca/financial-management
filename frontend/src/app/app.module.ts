import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule } from '@angular/forms';
import { HttpClientModule, HttpClient } from '@angular/common/http';
import { HttpModule } from '@angular/http';

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
import {MatAutocompleteModule, MatNativeDateModule, MAT_DATE_LOCALE} from '@angular/material';
import { MatRadioModule } from '@angular/material/radio';


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
    CostCenterComponent
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
    MatDatepickerModule,
    MatNativeDateModule,
    MatRadioModule,
  ],
  providers: [ ProviderService, HttpService, AuthGuard, HttpClientModule, MessageDialogComponent, { provide: MAT_DATE_LOCALE, useValue: 'pt-BR' }, ],
  bootstrap: [AppComponent],
  entryComponents: [ DialogOverviewExampleDialog, TaxSelectionComponent ]
})
export class AppModule { }
