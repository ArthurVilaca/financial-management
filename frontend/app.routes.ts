import { Routes } from '@angular/router';

import { LoginPageComponent } from './login-page/login-page.component';
import { HomePageComponent } from './home-page/home-page.component';
import { SideNavComponent } from './side-nav/side-nav.component';
import { ProfilesComponent } from './profiles/profiles.component';
import { AdvertisersComponent } from './advertisers/advertisers.component';
import { AdvertiserComponent } from './advertiser/advertiser.component';
import { MediaComponent } from './media/media.component';
import { CommentsComponent } from './comments/comments.component';
import { CommentComponent } from './comment/comment.component';
import { CommentsPendingComponent } from './comments-pending/comments-pending.component';

import { AuthGuard } from './auth.guard';

const SECURE_ROUTES: Routes = [
	{ path: 'usuarios', component: ProfilesComponent },
	{ path: 'home', component: HomePageComponent },
	{ path: 'anunciantes', component: AdvertisersComponent },
	{ path: 'anunciante/novo', component: AdvertiserComponent },
	{ path: 'anunciante/:id', component: AdvertiserComponent },
	{ path: 'anunciante/:id/media', component: MediaComponent },
	{ path: 'anunciante/:id/comentarios', component: CommentsComponent },
	{ path: 'comentarios', component: CommentsPendingComponent },
	{ path: 'comentarios/:comentario', component: CommentComponent },
];

export const rootRouterConfig: Routes = [
	{ path: '', component: LoginPageComponent },
  	{ path: 'login', component: LoginPageComponent },
	{ path: '', component: SideNavComponent, canActivate: [AuthGuard], children: SECURE_ROUTES },
	{ path: '**',  redirectTo: 'login', pathMatch: 'full' },
];
