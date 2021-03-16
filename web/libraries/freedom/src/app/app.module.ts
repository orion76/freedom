import {ApplicationRef, DoBootstrap, Injector, NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';

import {AppComponent} from './app.component';
import {TelegramAuthComponent} from './telegram-auth/telegram-auth.component';
import {createCustomElement} from '@angular/elements';

@NgModule({
  declarations: [
    AppComponent,
    TelegramAuthComponent
  ],
  imports: [
    BrowserModule
  ],
  providers: [],
  entryComponents: [TelegramAuthComponent]
})
export class AppModule implements DoBootstrap {
  constructor(private injector: Injector) {
  }

  ngDoBootstrap(appRef: ApplicationRef): void {
    const el = createCustomElement(TelegramAuthComponent, {injector: this.injector});
    customElements.define('telegram-auth', el);
  }
}
