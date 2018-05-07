import { Routes } from '@angular/router';

import { HomeComponent } from './home/home.component';
import { SideNavComponent } from './side-nav/side-nav.component';
import { LoginComponent } from './login/login.component';

import { AuthGuard } from './auth.guard';

const SECURE_ROUTES: Routes = [
	{ path: 'home', component: HomeComponent },
];

export const rootRouterConfig: Routes = [
	{ path: '', component: LoginComponent },
	{ path: 'login', component: LoginComponent },
	{ path: '', component: SideNavComponent, canActivate: [AuthGuard], children: SECURE_ROUTES },
	{ path: '**',  redirectTo: 'login', pathMatch: 'full' },
];
