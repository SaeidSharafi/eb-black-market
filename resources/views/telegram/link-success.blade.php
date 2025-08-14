<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Telegram Account Linked Successfully</title>
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
                max-width: 400px;
                width: 100%;
            }
            .success-icon {
                width: 64px;
                height: 64px;
                background: #10b981;
                border-radius: 50%;
                margin: 0 auto 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .success-icon svg {
                width: 32px;
                height: 32px;
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
            .close-button {
                background: #3b82f6;
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.2s;
            }
            .close-button:hover {
                background: #2563eb;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    ></path>
                </svg>
            </div>
            <h1>Success!</h1>
            <p>
                Your Telegram account has been successfully linked to your
                account. You can now close this window and return to the
                application.
            </p>
            <button class="close-button" onclick="window.close();">
                Close Window
            </button>
        </div>
    </body>
</html>
