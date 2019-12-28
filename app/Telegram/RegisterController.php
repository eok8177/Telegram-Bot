<?php

namespace App\Telegram;

use App\TelegramUser;
use App\Client;

class RegisterController
{

    private static $table = [
        0 => [
                'field' => 'last_name',
                'text' => 'Ваша Фамилия',
            ],
        1 => [
                'field' => 'first_name',
                'text' => 'Ваше Имя',
            ],
        2 => [
                'field' => 'sur_name',
                'text' => 'Ваше Отчество',
            ],
        3 => [
                'field' => 'dob',
                'text' => 'Дата рождения',
            ],
        4 => [
                'field' => 'address',
                'text' => 'Место рождения',
            ],
        5 => [
                'field' => 'gender',
                'text' => 'Пол',
            ],
        6 => [
                'field' => 'spasport',
                'text' => 'Серия паспорта / № Документа',
            ],
        7 => [
                'field' => 'npasport',
                'text' => '№ паспорта / № Записи',
            ],
        8 => [
                'field' => 'wpasport',
                'text' => 'Кем выдан паспорт',
            ],
        9 => [
                'field' => 'dpasport',
                'text' => 'Дата выдачи паспорта',
            ],
        10 => [
                'field' => 'inn',
                'text' => 'Идентификационный номер',
            ],
        11 => [
                'field' => 'city',
                'text' => 'Проживаю в',
            ],
        12 => [
                'field' => 'country',
                'text' => 'Гражданство',
            ],
        13 => [
                'field' => 'phone_1',
                'text' => 'Номер телефона',
            ],
        14 => [
                'field' => 'phone_2',
                'text' => 'Второй контактный номер',
            ],
    ];

    /**
     * $t_id - telegram id
     * $message - from client
     * return Array(keyboard, text)
     */
    static function index($t_id, $message, $section = 'register')
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

        if ($tUser->step == 0) {
            $text = self::$table[$tUser->step]['text'];
        } elseif ($tUser->step == 15) {
            $client->{self::$table[$tUser->step - 1]['field']} = $message;
        } elseif ($tUser->step > 15) {
            $text = 'Что то не так';
        } else {
            $client->{self::$table[$tUser->step - 1]['field']} = $message;
            $text = self::$table[$tUser->step]['text'];
        }

        $client->save();

        if($tUser->step < 16) {
            if ($message) { //restrict enter "/"
                $tUser->step = $tUser->step + 1;
            } else {
                $text .= ". Повторите ввод";
            }
        }

        $tUser->section = $section;
        $tUser->save();

        $keyboard = [
            ['Изменить']
        ];

        if ($tUser->step == 16) {
            return self::profile($t_id, $message);
        }

        $response = [
            'keyboard' => $keyboard,
            'text' => $text
        ];

        return $response;

    }


    static function profile($t_id, $message)
    {
        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        $text = "";
        foreach (self::$table as $key => $item) {
            $text .= $key." : ".$item['text'].": ".$client->{$item['field']}.PHP_EOL.PHP_EOL;
        }

        $text .= "<b>Выберите пункт для редактирования</b>";

        $keyboard = [
            ['0','1','2','3','4','5','6','7'],
            ['8','9','10','11','12','13','14'],
            ['Отмена']
        ];
        $response = [
            'keyboard' => $keyboard,
            'text' => $text
        ];

        $tUser->section = 'showProfile';
        $tUser->step = 0;
        $tUser->save();

        return $response;
    }

    static function show($t_id, $message)
    {
        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();

        if ($message >= 0 && $message < 15) {
            $text = self::$table[$message]['text'];
        }

        $keyboard = [
            ['Отмена']
        ];
        $response = [
            'keyboard' => $keyboard,
            'text' => $text
        ];

        $tUser->section = 'editProfile';
        $tUser->step = $message;
        $tUser->save();

        return $response;
    }


    static function edit($t_id, $message)
    {

        $tUser = TelegramUser::find($t_id);
        $client = Client::where('t_id', $t_id)->first();


        if (strpos($message, '/') !== false) { //restrict enter "/"
            $message = false;
        }

        if ($message) {
            $client->{self::$table[$tUser->step]['field']} = $message;
        } else {
            $text = "Повторите ввод";
            return self::profile($t_id, $message);
        }
        $client->save();

        return self::profile($t_id, $message);
    }
}
