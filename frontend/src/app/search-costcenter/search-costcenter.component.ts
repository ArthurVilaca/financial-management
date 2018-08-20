import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-search-costcenter',
  templateUrl: './search-costcenter.component.html',
  styleUrls: ['./search-costcenter.component.scss']
})
export class SearchCostcenterComponent {
  //filter: any = {};

  constructor(
    public dialogRef: MatDialogRef<SearchCostcenterComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) {
      this.filter = data.filter;
  }

  onNoClick(): void {
    this.dialogRef.close(this.filter);
  }

}
