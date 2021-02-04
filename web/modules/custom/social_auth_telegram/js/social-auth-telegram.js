(function ($) {

    'use strict';
    Drupal.behaviors.socialAuthTelegram = {
        attach: function (context, settings) {
            let iframeName = document.getElementById('telegram-login-freedom_pdd_bot');
            let iframeContent = iframeName.contentDocument;
            let css = '.tgme_widget_login_button{font-size: 0;height: 3rem;width: 3rem;border-radius: 2rem;}';
            let style = document.createElement('style');
            iframeContent.body.appendChild(style);
            style.appendChild(document.createTextNode(css));
        }
    };
})(jQuery)
