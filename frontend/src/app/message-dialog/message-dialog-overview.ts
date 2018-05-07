import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
    selector: 'dialog-overview-dialog',
    templateUrl: './dialog-overview.html',
})
export class DialogOverviewExampleDialog {
    header: string = '';
    text: string = '';
    constructor(
      public dialogRef: MatDialogRef<DialogOverviewExampleDialog>,
      @Inject(MAT_DIALOG_DATA) public data: any) {
        this.header = data.header;
        this.text = data.text;
    }
  
    onNoClick(): void {
      this.dialogRef.close();
    }
  
}