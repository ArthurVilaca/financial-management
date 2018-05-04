import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, Router } from '@angular/router';
import { ProviderService } from './provider.service';

@Injectable()
export class AuthGuard implements CanActivate {

  constructor(private router: Router, private appState: ProviderService) {}

  public canActivate(route: ActivatedRouteSnapshot) {
    if(this.appState.provider.user) {
      return true;
    }
    return false;
    // const token = localStorage.getItem('token');
    // let tokenIsExpired = false;

    // if(token == null || token == undefined) {
    //     tokenIsExpired = true;
    // }

    // // more validations
    // if (tokenIsExpired) {
    //   this.router.navigateByUrl('/login');
    //   return false;
    // }

    // return true;
  }
}