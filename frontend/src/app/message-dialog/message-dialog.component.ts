import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { DialogOverviewExampleDialog } from './message-dialog-overview'

@Component({
  selector: 'app-message-dialog',
  templateUrl: './message-dialog.component.html',
  styleUrls: ['./message-dialog.component.css']
})
export class MessageDialogComponent {

  constructor(public dialog: MatDialog) { }

  openDialog(header, text): void {
    let dialogRef = this.dialog.open(DialogOverviewExampleDialog, {
      width: '300px',
      data: { header: header, text: text }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
    });
  }

}
