<?php

namespace App\Telegram;

use App\TelegramUser;
use App\Client;
use App\Contract;

class CreditController
{

    static function check($t_id, $message)
    {
        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        $keyboard = [
            ['На главную']
        ];

        switch ($tUser->step) {
            case '0':
                $text = 'Введите номер договора';
                $tUser->step = 1;
                break;
            case '1':
                // Здесь проверять в БД наличие договора
                if (!$contract = Contract::where('number', $message)->first()) {
                    $text = 'Данного номера договора не существует. Убедитесь в правильности вводимых данных и повторите еще раз';
                    $tUser->step = 1;
                } else{
                    $text = 'Сумма кредита: '.$contract->amount.PHP_EOL;
                    $text .= 'Минимальная сумма погашения: '.$contract->min_summ.PHP_EOL;
                    $text .= 'Остаток суммы на погашение: '.$contract->saldo;

                    $keyboard = [
                        ["Погасить частично \u{1F4B8}" , "Погасить всю сумму \u{1F4B8}"],
                        ['На главную']
                    ];
                }
                break;
            case '2': //Частично
                $text = 'Введите сумму';
                $tUser->step = 3;
                break;
            case '3': //Частично введна сумма - выдаем ссылку
                $text = 'https://api.fondy.eu/api/checkout?button=8kh7iswi5m4j3psuxxv2n41qzibc9z9q&summ='.$message;
                $tUser->section = '';
                break;
            default:
                $text = 'Что то не так';
                break;
        }
        $tUser->save();


        $resp = [
            'text' => $text,
            'keyboard' => $keyboard
        ];

        return $resp;
    }

    static function pay($t_id, $message)
    {
        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        switch ($tUser->step) {
            case '0':
                $text = 'Введите номер договора';
                $tUser->step = 1;
                break;
            case '1':
                // Генерировать ссылку
                if (!$contract = Contract::where('number', $message)->first()) {
                    $text = 'Данного номера договора не существует. Убедитесь в правильности вводимых данных и повторите еще раз';
                    $tUser->step = 1;
                } else{
                    $text = 'https://api.fondy.eu/api/checkout?button=8kh7iswi5m4j3psuxxv2n41qzibc9z9q';
                    $tUser->section = '';
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
