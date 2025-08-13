<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Эти данные не соответствуют нашим записям.',
    'password' => 'Предоставленный пароль неверен.',
    'throttle' => 'Слишком много попыток входа. Попробуйте снова через :seconds секунд.',

    // Telegram OAuth
    'telegram' => [
        'or_continue_with' => 'Или продолжить с',
        'secure_authentication' => 'Безопасная аутентификация через Telegram',
        'no_password_required' => 'Пароль не требуется - войдите мгновенно с вашим аккаунтом Telegram',
        'auto_registration' => 'Новые пользователи будут автоматически зарегистрированы',
        'not_configured' => 'Вход через Telegram не настроен',
        'contact_admin' => 'Обратитесь к администратору для включения аутентификации Telegram.',
        'authenticating' => 'Аутентификация через Telegram...',
    ],

];
