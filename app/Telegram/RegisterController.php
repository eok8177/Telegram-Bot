<?php

namespace App\Telegram;

use App\TelegramUser;
use App\Client;

class RegisterController
{

    /**
     * $t_id - telegram id
     * $message - from client
     * return Array(keyboard, text)
     */
    static function index($t_id, $message)
    {

        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        if (!$client) {
            $client = new Client;
            $client->t_id = $t_id;
            $client->save();
        }

        if (strpos($message, '/') !== false) { //restrict enter "/"
            $message = false;
        }

        switch ($tUser->step) {
            case '0':
                $text = 'Ваша Фамилия';
                break;

            case '1':
                $client->last_name = $message;
                $text = 'Ваше Имя';
                break;

            case '2':
                $client->first_name = $message;
                $text = 'Ваше Отчество';
                break;

            case '3':
                $client->sur_name = $message;
                $text = 'Дата рождения';
                break;

            case '4':
                $client->dob = $message;
                $text = 'Место рождения';
                break;

            case '5':
                $client->address = $message;
                $text = 'Пол';
                break;

            case '6':
                $client->gender = $message;
                $text = 'Серия паспорта / № Документа';
                break;

            case '7':
                $client->spasport = $message;
                $text = '№ паспорта / № Записи';
                break;

            case '8':
                $client->npasport = $message;
                $text = 'Кем выдан паспорт';
                break;

            case '9':
                $client->wpasport = $message;
                $text = 'Дата выдачи паспорта';
                break;

            case '10':
                $client->dpasport = $message;
                $text = 'Идентификационный номер';
                break;

            case '11':
                $client->inn = $message;
                $text = 'Проживаю в';
                break;

            case '12':
                $client->city = $message;
                $text = 'Гражданство';
                break;

            case '13':
                $client->country = $message;
                $text = 'Номер телефона';
                break;

            case '14':
                $client->phone_1 = $message;
                $text = 'Второй контактный номер';
                break;

            case '15':
                $client->phone_2 = $message;
                break;

            default:
                $text = 'Что то не так';
                break;
        }

        $client->save();

        if($tUser->step < 16) {
            if ($message) { //restrict enter "/"
                $tUser->step = $tUser->step + 1;
            } else {
                $text .= ". Повторите ввод";
            }
        }

        $tUser->section = 'register';
        $tUser->save();

        $keyboard = [
            ['Изменить']
        ];

        if ($tUser->step == 16) {

            $text = "$client->last_name  $client->first_name  $client->sur_name  $client->dob  $client->address  $client->gender  $client->spasport  $client->npasport  $client->wpasport  $client->dpasport  $client->inn  $client->city  $client->country  $client->phone_1  $client->phone_2";


            $keyboard = [
                ['Продолжить'],
                ['Изменить']
            ];

        }

        $response = [
            'keyboard' => $keyboard,
            'text' => $text
        ];

        return $response;

    }
}
