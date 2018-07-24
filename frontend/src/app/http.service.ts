import { Injectable } from '@angular/core';
import { ProviderService } from './provider.service'
import { Http, Headers } from '@angular/http';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { MessageDialogComponent } from './message-dialog/message-dialog.component'

@Injectable()
export class HttpService {
  hash: string = "";
  header: HttpHeaders;
  headers: any = {};

  constructor(private router: Router, private provider: ProviderService, private http: HttpClient, private message: MessageDialogComponent) {
    this.hash = this.provider.hash;
    this.headers = {
      'Authorization': this.hash,
    };
    this.header = new HttpHeaders(this.headers);
  }

  generateHeader() {
    this.header = new HttpHeaders(this.headers);
  }

  get(url) {
    return this.http.get('index.php/api' + url, { headers: this.header })
        .toPromise()
        .then((data: any) => {
          return this.validateRequest(data);
        });
  }
      
  validateRequest(data) {
    return new Promise((resolve, reject) => {
      if(data.internalErrorStatus == 800) {
        this.message.openDialog('Erro', JSON.parse(data.message));
        return this.logout();
      }
      resolve(data)
    });
  }

  put(url, post) {
    return this.http.put('index.php/api' + url, post, { headers: this.header })
        .toPromise()
        .then((data: any) => {
          return this.validateRequest(data);
        });
  }

  logout() {
    this.headers = {
      'Authorization': this.hash
    }
    this.generateHeader();
    this.router.navigate(['login']).then(_ => {});
  }

  post(url, data, header?) {
    let headers = this.header;
    if(header) {
      header.Authorization = this.hash;
      headers = new HttpHeaders(header);
    }
    return this.http.post('index.php/api' + url, data, { headers: headers })
        .toPromise()
        .then((data: any) => {
          return this.validateRequest(data);
        });
  }

  serialize(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
          if(obj[p] != null && obj[p] != '' && obj[p] != undefined) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
          }
        }
    return str.join("&");
  }

}
