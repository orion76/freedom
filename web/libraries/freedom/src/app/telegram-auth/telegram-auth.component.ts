import {Component, Input, OnInit, ViewEncapsulation} from '@angular/core';

@Component({
  selector: 'telegram-auth',
  template: `
      <script async
              [src]="src"
              [attr.data-telegram-login]="login"
              [attr.data-size]="size"
              [attr.data-onauth]="onTelegramAuth"
              [attr.data-request-access]="request_access"></script>
  `,
  styles: [],
  encapsulation: ViewEncapsulation.ShadowDom
})
export class TelegramAuthComponent implements OnInit {

  @Input() src = 'https://telegram.org/js/telegram-widget.js?14';
  @Input() login = 'samplebot';
  @Input() size = 'large';
  @Input() request_access = 'write';

  constructor() {
  }

  ngOnInit(): void {
  }
  onTelegramAuth(user) {
    alert('Logged in as ' + user.first_name + ' ' + user.last_name + ' (' + user.id + (user.username ? ', @' + user.username : '') + ')');
  }
}
