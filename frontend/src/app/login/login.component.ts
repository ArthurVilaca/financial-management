import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  constructor(private router: Router) { }

  login() {
    this.router.navigate(['home']).then(_ => {});
  }
}
