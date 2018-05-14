import { Component, OnInit } from '@angular/core';
import { ProviderService } from '../provider.service'

@Component({
  selector: 'app-side-nav',
  templateUrl: './side-nav.component.html',
  styleUrls: ['./side-nav.component.css']
})
export class SideNavComponent implements OnInit {

  constructor(private appState: ProviderService) { }

  ngOnInit() {
  }

}
