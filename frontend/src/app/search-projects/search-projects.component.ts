import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-search-projects',
  templateUrl: './search-projects.component.html',
  styleUrls: ['./search-projects.component.scss']
})
export class SearchProjectsComponent {

  filter: any = {};

  constructor(
    public dialogRef: MatDialogRef<SearchProjectsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) {
      this.filter = data.filter;
  }

  onNoClick(): void {
    this.dialogRef.close(this.filter);
  }

}
