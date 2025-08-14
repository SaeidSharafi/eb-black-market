<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Connect Telegram Account</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                    Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                margin: 0;
                padding: 20px;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                background: white;
                border-radius: 12px;
                padding: 40px;
                text-align: center;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                width: 100%;
            }
            .telegram-icon {
                width: 64px;
                height: 64px;
                margin: 0 auto 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .telegram-icon svg {
                color: white;
            }
            h1 {
                color: #1f2937;
                margin: 0 0 16px 0;
                font-size: 24px;
            }
            p {
                color: #6b7280;
                margin: 0 0 24px 0;
                line-height: 1.5;
            }
            .widget-container {
                margin: 20px 0;
                min-height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .debug-info {
                background: #f3f4f6;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                padding: 15px;
                margin: 20px 0;
                font-size: 14px;
                color: #374151;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="telegram-icon">
                <svg class="mx-1" id="Livello_1"
                     data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 240 240"><defs><linearGradient id="linear-gradient" x1="120" y1="240" x2="120" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#1d93d2"/><stop offset="1" stop-color="#38b0e3"/></linearGradient></defs><title>Telegram_logo</title><circle cx="120" cy="120" r="120" fill="url(#linear-gradient)"/><path d="M81.229,128.772l14.237,39.406s1.78,3.687,3.686,3.687,30.255-29.492,30.255-29.492l31.525-60.89L81.737,118.6Z" fill="#c8daea"/><path d="M100.106,138.878l-2.733,29.046s-1.144,8.9,7.754,0,17.415-15.763,17.415-15.763" fill="#a9c6d8"/><path d="M81.486,130.178,52.2,120.636s-3.5-1.42-2.373-4.64c.232-.664.7-1.229,2.1-2.2,6.489-4.523,120.106-45.36,120.106-45.36s3.208-1.081,5.1-.362a2.766,2.766,0,0,1,1.885,2.055,9.357,9.357,0,0,1,.254,2.585c-.009.752-.1,1.449-.169,2.542-.692,11.165-21.4,94.493-21.4,94.493s-1.239,4.876-5.678,5.043A8.13,8.13,0,0,1,146.1,172.5c-8.711-7.493-38.819-27.727-45.472-32.177a1.27,1.27,0,0,1-.546-.9c-.093-.469.417-1.05.417-1.05s52.426-46.6,53.821-51.492c.108-.379-.3-.566-.848-.4-3.482,1.281-63.844,39.4-70.506,43.607A3.21,3.21,0,0,1,81.486,130.178Z" fill="#fff"/></svg>

            </div>

            <h1>Connect Your Telegram Account</h1>
            <p>
                Hello {{ $user->name }}, click the button below to link your
                Telegram account and receive notifications about your listings.
            </p>

            <div class="widget-container">
                <script
                    async
                    src="https://telegram.org/js/telegram-widget.js?22"
                    data-telegram-login="{{ $botUsername }}"
                    data-size="large"
                    data-auth-url="{{ $callbackUrl }}"
                    data-request-access="write"
                ></script>
            </div>

            <p style="font-size: 12px; color: #9ca3af">
                If the Telegram widget doesn't appear above, make sure JavaScript is
                enabled in your browser
            </p>
        </div>

        <script>
            // Check if widget loaded
            setTimeout(function () {
                const widgets = document.querySelectorAll(
                    'iframe[src*="oauth.telegram.org"]'
                );
                if (widgets.length === 0) {
                    console.warn(
                        "Telegram widget iframe not found after 3 seconds"
                    );
                } else {
                    console.log(
                        "Telegram widget iframe found:",
                        widgets.length
                    );
                }
            }, 3000);
        </script>
    </body>
</html>
