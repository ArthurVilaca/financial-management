import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-search-bills',
  templateUrl: './search-bills.component.html',
  styleUrls: ['./search-bills.component.scss']
})
export class SearchBillsComponent {
  filter: any = {};

  constructor(
    public dialogRef: MatDialogRef<SearchBillsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) {
      this.filter = data.filter;
  }

  onNoClick(): void {
    this.dialogRef.close(this.filter);
  }
}
