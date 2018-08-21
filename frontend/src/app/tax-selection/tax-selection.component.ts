import { Component, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { ProviderService } from '../provider.service';
import { HttpService } from '../http.service';

@Component({
  selector: 'app-tax-selection',
  templateUrl: './tax-selection.component.html',
  styleUrls: ['./tax-selection.component.scss']
})
export class TaxSelectionComponent {
  header: any;
  taxes: any[] = [];

  constructor(
    public dialogRef: MatDialogRef<TaxSelectionComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any, private http: HttpService, private appState: ProviderService) {
      this.header = data.header
      this.loadTaxes();
  }

  loadTaxes() {
    this.http.get('/taxes')
      .then((data: any) => {
        this.taxes = data.dataset.taxes;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  setSelected() {
    this.dialogRef.close(this.taxes);
  }

}
