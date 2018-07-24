import { Component, OnInit } from '@angular/core';
import { HttpService } from '../http.service'
import { ProviderService } from '../provider.service'
import { PageEvent } from '@angular/material';
import { SearchPersonComponent } from '../search-person/search-person.component';
import { MatDialog } from '@angular/material';

@Component({
  selector: 'app-providers',
  templateUrl: './providers.component.html',
  styleUrls: ['./providers.component.css']
})
export class ProvidersComponent implements OnInit {
  filter: any = {};
  length = 100;
  pageSize = 10;
  pageSizeOptions = [5, 10, 25, 100];

  // MatPaginator Output
  pageEvent: PageEvent;

  constructor(public dialog: MatDialog, private http: HttpService, private appState: ProviderService) {
  }

  ngOnInit() {
    this.search();
  }

  search($event?) {
    if($event){
      this.pageEvent = $event;
      this.pageSize = $event.pageSize;
    }
    let page = 0;
    if(this.pageEvent) {
      page = this.pageEvent.pageIndex;
    }
    this.http.get('/providers?page=' + page + '&pageSize=' + this.pageSize + '&' + this.http.serialize(this.filter))
      .then((data: any) => {
        this.appState.set('providers', data.dataset.providers);
        this.length = data.dataset.total;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  setPageSizeOptions(setPageSizeOptionsInput: string) {
    this.pageSizeOptions = setPageSizeOptionsInput.split(',').map(str => +str);
  }

  openFilter() {
    let dialogRef = this.dialog.open(SearchPersonComponent, {
      width: '70%',
      height: '400px',
      data: { filter: this.filter }
    });
    dialogRef.afterClosed().subscribe(result => {
      this.filter = result;
      this.search();
    });
  }

}
