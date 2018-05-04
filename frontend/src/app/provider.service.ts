import { Injectable } from '@angular/core';

@Injectable()
export class ProviderService {
  hash: string = "98f4aa5c-2cfc-4727-9bbd-72b229a63e1f";
  provider: any = {};

  constructor() { }

  set(type, data) {
    this.provider[type] = data;
  }

}
