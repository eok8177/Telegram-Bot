<?php

namespace App\Telegram;

use Telegram;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Actions;

use App\Telegram\TestController;
use App\Telegram\RegisterController;

use App\TelegramUser;
use App\Client;


class TelegramController
{
    private $t_id;

    public function webhook() {

        $resp = false;

        \Telegram::replyWithChatAction(['action' => Actions::TYPING]);

        $telegram = Telegram::getWebhookUpdates()['message'];
        $this->t_id = $telegram['from']['id'];

        //get update from user
        $update = Telegram::commandsHandler(true);
        $message = $update->getMessage()->getText(true);


        $tUser = TelegramUser::find($this->t_id);

        // save telegram user to DB
        if (!$tUser) {
            $tUser = TelegramUser::create(json_decode($telegram['from'],true));
        }

        // $tUser->text = json_encode($telegram);
        $tUser->text = $message;

        if (!$Client = Client::where('t_id', $this->t_id)->first()) $tUser->section = '';

        $tUser->save();


        if($tUser->section == 'register') {

            if ($message == 'Изменить') {
                $tUser->step = '0';
                $tUser->save();
            }

            if ($message == 'Продолжить') {
                $tUser->section = '';
                $tUser->save();
                $this->sendMsg($resp);
                return;
            }

            $resp = RegisterController::index($this->t_id, $message);
        }

        if ($message === 'Регистрация') {
            $tUser->section = 'register';
            $tUser->step = '0';
            $tUser->save();
            $resp = RegisterController::index($this->t_id, $message);
        }

        if ($message === 'Отдать кредит') {
            // Telegram::getCommandBus()->execute('start', '', $update);
        }

        if ($message === 'Контакты') {
            Telegram::getCommandBus()->execute('contacts', '', $update);
            return;
        }

        if ($message === '/test') {
            $resp = TestController::index();
        }

        $this->sendMsg($resp);

    }

    /*
    * Send message to Telegram user
    */
    private function sendMsg($answer = false) {

        if (!$answer) {
            if (!$Client = Client::where('t_id', $this->t_id)->first()) {
                $keyboard = [
                    ['Регистрация']
                ];
            } else {
                $keyboard = [
                    ['Проверить остаток'],
                    ['Отдать кредит'],
                    ['Контакты']
                ];
            }

            $answer = [
                'keyboard' => $keyboard,
                'text' => 'Вас приветствует МФО Бот'
            ];
        }

        $reply_markup = \Telegram::replyKeyboardMarkup([
            'keyboard' => $answer['keyboard'], 
            'resize_keyboard' => true, 
            'one_time_keyboard' => false,
            'selective' => true
        ]);
        $response = \Telegram::sendMessage([
            'chat_id' => $this->t_id, 
            'text' => $answer['text'], 
            'reply_markup' => $reply_markup
        ]);
    }
}
