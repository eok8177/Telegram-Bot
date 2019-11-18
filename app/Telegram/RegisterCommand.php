<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\TelegramUser;
use App\Client;

class RegisterCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'register';

    /**
     * @var string Command Description
     */
    protected $description = 'Регистрация';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $telegram_user = \Telegram::getWebhookUpdates()['message'];

        $tUser = TelegramUser::find($telegram_user['from']['id']);

        $client = Client::where('t_id', $telegram_user['from']['id'])->first();

        if (!$client) {
            $client = new Client;
            $client->t_id = $telegram_user['from']['id'];
            $client->save();
        }

        $message = Command::getUpdate()->getMessage()->getText(true);

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

        $reply_markup = \Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => false,
            'selective' => true
        ]);
        $response = \Telegram::sendMessage([
            'chat_id' => $telegram_user['from']['id'], 
            'text' => $text, 
            'reply_markup' => $reply_markup
        ]);

    }
}
