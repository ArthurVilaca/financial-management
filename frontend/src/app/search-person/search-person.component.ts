import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-search-person',
  templateUrl: './search-person.component.html',
  styleUrls: ['./search-person.component.scss']
})
export class SearchPersonComponent {
  filter: any = {};

  constructor(
    public dialogRef: MatDialogRef<SearchPersonComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) {
      this.filter = data.filter;
  }
  
  onNoClick(): void {
    this.dialogRef.close(this.filter);
  }

}
