<?php

namespace App\Telegram;

use App\TelegramUser;
use App\Client;

class CreditController
{

    static function check($t_id, $message)
    {
        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        switch ($tUser->step) {
            case '0':
                $text = 'Введите номер договора (123456)';
                $tUser->step = 1;
                break;
            case '1':
                // Здесь проверять в БД наличие договора
                if ($message == '123456') {
                    $text = 'Сумма кредита: 12000 грн'.PHP_EOL;
                    $text .= 'Минимальная сумма погашения: 500 грн/мес'.PHP_EOL;
                    $text .= 'Остаток суммы на погашение: 2500 грн';
                    $tUser->section = '';
                } else {
                    $text = 'Данного номера договора не существует. Убедитесь в правильности вводимых данных и повторите еще раз';
                    $tUser->step = 1;
                }
                break;
            default:
                $text = 'Что то не так';
                break;
        }
        $tUser->save();


        $resp = [
            'text' => $text,
            'keyboard' => [
                ['На главную']
            ]
        ];

        return $resp;
    }

    static function pay($t_id, $message)
    {
        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        switch ($tUser->step) {
            case '0':
                $text = 'Введите номер договора (123456)';
                $tUser->step = 1;
                break;
            case '1':
                // Генерировать ссылку
                if ($message == '123456') {
                    $text = 'https://bot.ek.ks.ua';
                    $tUser->section = '';
                } else {
                    $text = 'Данного номера договора не существует. Убедитесь в правильности вводимых данных и повторите еще раз';
                    $tUser->step = 1;
                }
                break;
            default:
                $text = 'Что то не так';
                break;
        }
        $tUser->save();


        $resp = [
            'text' => $text,
            'keyboard' => [
                ['На главную']
            ]
        ];

        return $resp;
    }
}
