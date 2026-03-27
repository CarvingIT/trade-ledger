$(document).ready(function(){
    $(".display_website").click(function(){
        const stripeDiv = document.getElementById('page-wrapper')
        window.location.reload();

        if (stripeDiv.style.pointerEvents === 'none') {
            //stripeDiv.style.pointerEvents = 'auto'; // Show the div
            //window.location.reload();
        } else {
            //stripeDiv.style.pointerEvents = 'none'; // Hide the div
        }
    });


 window.laravelCookieConsent = (function () {

            const COOKIE_VALUE = 1;

            const COOKIE_LIFETIME = $("#cookie-lifetime").val();
            const COOKIE_NAME = $("#cookie-name").val();
            const COOKIE_DOMAIN = $("#cookie-domain").val();
            const COOKIE_PATH = $("#cookie-path").val();
            const COOKIE_SAME_SITE = $("#cookie-same-site").val();

//alert(COOKIE_DOMAIN);
//alert(COOKIE_NAME);
//alert(COOKIE_LIFETIME);
            

            function consentWithCookies() {
                //setCookie('{{ $cookieConsentConfig['cookie_name'] }}', 'COOKIE_VALUE', '{{ $cookieConsentConfig['cookie_lifetime'] }}');
                setCookie(COOKIE_NAME, COOKIE_VALUE, COOKIE_LIFETIME);
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');

                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

 function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/' + COOKIE_PATH
                    + COOKIE_SAME_SITE;
            }

            //if (cookieExists("{{ $cookieConsentConfig['cookie_name'] }}")) {
            if (cookieExists(COOKIE_NAME)) {
                hideCookieDialog();
            }

            const buttons = document.getElementsByClassName('js-cookie-consent-agree');

            for (let i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();

});
