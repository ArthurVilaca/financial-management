import { Routes } from '@angular/router';


import { AuthGuard } from './auth.guard';

const SECURE_ROUTES: Routes = [
];

export const rootRouterConfig: Routes = [
	{ path: '', component: SideNavComponent, canActivate: [AuthGuard], children: SECURE_ROUTES },
	{ path: '**',  redirectTo: 'login', pathMatch: 'full' },
];
