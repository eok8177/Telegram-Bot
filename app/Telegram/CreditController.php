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
                    $text = 'http://bot.ek.ks.ua/admin/contract/'.$contract->id.'/edit';
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
