<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use App\TelegramUser;
use Telegram\Bot\Commands\Command;

class TelegramController extends Controller
{
    public function webhook() {

        $telegram = Telegram::getWebhookUpdates()['message'];

        $tUser = TelegramUser::find($telegram['from']['id']);

        // save telegram user to DB
        if (!$tUser) {
            $tUser = TelegramUser::create(json_decode($telegram['from'],true));
        }

        //get update from user
        $update = Telegram::commandsHandler(true);

        $message = $update->getMessage();
        $text = trim($message->getText(true));


        $tUser->text = trim($text);
        $tUser->save();

        if ($text === 'Регистрация') {
            Telegram::getCommandBus()->execute('register', '', $update);
        }

        if ($text === 'Отдать кредит') {
            Telegram::getCommandBus()->execute('start', '', $update);
        }

        if ($text === 'Контакты') {
            Telegram::getCommandBus()->execute('contacts', '', $update);
        }

    }
}
