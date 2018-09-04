import { Routes } from '@angular/router';

import { HomeComponent } from './home/home.component';
import { SideNavComponent } from './side-nav/side-nav.component';
import { LoginComponent } from './login/login.component';
import { ClientsComponent } from './clients/clients.component';
import { ClientComponent } from './client/client.component';
import { TaxesComponent } from './taxes/taxes.component';
import { TaxComponent } from './tax/tax.component';
import { ProvidersComponent } from './providers/providers.component';
import { ProviderComponent } from './provider/provider.component';
import { EmployeesComponent } from './employees/employees.component';
import { EmployeeComponent } from './employee/employee.component';
import { ProfileComponent } from './profile/profile.component';
import { BanksComponent } from './banks/banks.component';
import { BankComponent } from './bank/bank.component';
import { CostCentersComponent } from './cost-centers/cost-centers.component';
import { CostCenterComponent } from './cost-center/cost-center.component';
import { BillspayComponent } from './billspay/billspay.component';
import { BillspaysComponent } from './billspays/billspays.component';
import { BillsreceiveComponent } from './billsreceive/billsreceive.component';
import { BillsreceivesComponent } from './billsreceives/billsreceives.component';
import { ProjectComponent } from './project/project.component';
import { ProjectsComponent } from './projects/projects.component';
import { ReportsComponent } from './reports/reports.component';
import { ReportBillspayComponent } from './report-billspay/report-billspay.component';
import { ReportBillsreceiveComponent } from './report-billsreceive/report-billsreceive.component';
import { LoansComponent } from './loans/loans.component';
import { LoanComponent } from './loan/loan.component';
import { PaymentMethodsComponent } from './payment-methods/payment-methods.component';
import { PaymentMethodComponent } from './payment-method/payment-method.component';
import { BankReconciliationComponent } from './bank-reconciliation/bank-reconciliation.component';

import { AuthGuard } from './auth.guard';

const SECURE_ROUTES: Routes = [
	{ path: 'home', component: HomeComponent },
	{ path: 'perfil', component: ProfileComponent },
	{ path: 'clientes', component: ClientsComponent },
	{ path: 'cliente/novo', component: ClientComponent },
	{ path: 'cliente/:id', component: ClientComponent },
	{ path: 'impostos', component: TaxesComponent },
	{ path: 'imposto/novo', component: TaxComponent },
	{ path: 'imposto/:id', component: TaxComponent },
	{ path: 'fornecedores', component: ProvidersComponent },
	{ path: 'fornecedor/novo', component: ProviderComponent },
	{ path: 'fornecedor/:id', component: ProviderComponent },
	{ path: 'funcionarios', component: EmployeesComponent },
	{ path: 'funcionario/novo', component: EmployeeComponent },
	{ path: 'funcionario/:id', component: EmployeeComponent },
	{ path: 'bancos', component: BanksComponent },
	{ path: 'banco/novo', component: BankComponent },
	{ path: 'banco/:id', component: BankComponent },
	{ path: 'centroDeCustos', component: CostCentersComponent },
	{ path: 'centroDeCusto/novo', component: CostCenterComponent },
	{ path: 'centroDeCusto/:id', component: CostCenterComponent },
	{ path: 'contasAPagar', component: BillspaysComponent },
	{ path: 'contaAPagar/novo', component: BillspayComponent },
	{ path: 'contaAPagar/:id', component: BillspayComponent },
	{ path: 'contasAReceber', component: BillsreceivesComponent },
	{ path: 'contaAReceber/novo', component: BillsreceiveComponent },
	{ path: 'contaAReceber/:id', component: BillsreceiveComponent },
	{ path: 'projetos', component: ProjectsComponent },
	{ path: 'projeto/novo', component: ProjectComponent },
	{ path: 'projeto/:id', component: ProjectComponent },
	{ path: 'relatorios', component: ReportsComponent },
	{ path: 'relatorio/contasAPagar', component: ReportBillspayComponent },
	{ path: 'relatorio/contasAReceber', component: ReportBillsreceiveComponent },
	{ path: 'emprestimos', component: LoansComponent },
	{ path: 'emprestimo/novo', component: LoanComponent },
	{ path: 'emprestimo/:id', component: LoanComponent },
	{ path: 'metodosPagamentos', component: PaymentMethodsComponent },
	{ path: 'metodosPagamento/novo', component: PaymentMethodComponent },
	{ path: 'metodosPagamento/:id', component: PaymentMethodComponent },
	{ path: 'conciliacaoBancaria/:id', component: BankReconciliationComponent },
];

export const rootRouterConfig: Routes = [
	{ path: '', component: LoginComponent },
	{ path: 'login', component: LoginComponent },
	{ path: '', component: SideNavComponent, canActivate: [AuthGuard], children: SECURE_ROUTES },
	{ path: '**',  redirectTo: 'login' },
];
