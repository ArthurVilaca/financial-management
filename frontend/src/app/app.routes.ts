import { Routes } from '@angular/router';

import { HomeComponent } from './home/home.component';
import { SideNavComponent } from './side-nav/side-nav.component';
import { LoginComponent } from './login/login.component';
import { ClientsComponent } from './clients/clients.component';
import { ClientComponent } from './client/client.component';
import { TaxesComponent } from './taxes/taxes.component';
import { TaxComponent } from './tax/tax.component';

import { AuthGuard } from './auth.guard';

const SECURE_ROUTES: Routes = [
	{ path: 'home', component: HomeComponent },
	{ path: 'clientes', component: ClientsComponent },
	{ path: 'cliente/novo', component: ClientComponent },
	{ path: 'cliente/:id', component: ClientComponent },
	{ path: 'impostos', component: TaxesComponent },
	{ path: 'imposto/novo', component: TaxComponent },
	{ path: 'imposto/:id', component: TaxComponent },
];

export const rootRouterConfig: Routes = [
	{ path: '', component: LoginComponent },
	{ path: 'login', component: LoginComponent },
	{ path: '', component: SideNavComponent, canActivate: [AuthGuard], children: SECURE_ROUTES },
	{ path: '**',  redirectTo: 'login', pathMatch: 'full' },
];
