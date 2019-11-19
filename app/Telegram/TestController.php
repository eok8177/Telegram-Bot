<?php

namespace App\Telegram;

use App\TelegramUser;
use App\Client;

class TestController
{

    static function index()
    {

        $resp = [
            'text' => "Тестовый контроллер",
            'keyboard' => [
                ['/start'],
                ['/test']
            ]
        ];

        return $resp;


    }
}
