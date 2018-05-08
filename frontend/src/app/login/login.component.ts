import { Component } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { MessageDialogComponent } from '../message-dialog/message-dialog.component'
import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  login: any = {
    username: '',
    password: ''
  };

  constructor(private router: Router, private route: ActivatedRoute, private message: MessageDialogComponent, private http: HttpService, private appState: ProviderService) { }

  onSubmit() {
    this.http.post('/login', this.login)
      .then((data: any) => {
        this.appState.set('user', data.dataset);
        this.http.headers['token'] = this.appState.provider.user.token;
        this.http.generateHeader();

        // setting localStorage
        window.localStorage.setItem('login', this.appState.provider.user);

        this.router.navigate(['home']).then(_ => {});
      })
      .catch((error) => {
        console.log(error)
        this.message.openDialog('Atenção', 'Erro ao fazer login, favor entrar em contato com o administrador!');
      });

  }
}
