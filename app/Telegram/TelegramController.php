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

        logger('TUser: ' . $tUser->section .' '. $tUser->step);
        logger('message: ' . $message);

        // Сброс на начало
        if ($message === 'Отмена' || $message == 'На главную' || $message == 'Продолжить') {
            $tUser->section = '';
            $tUser->step = '0';
            $tUser->save();
            $this->sendMsg();
            return;
        }


        // Обработка секции
        if($tUser->section == 'register') {
            if ($message == 'Изменить') {
                $tUser->step = '0';
                $tUser->save();
            }
            $resp = RegisterController::index($this->t_id, $message);
        }

        if ($tUser->section == 'check') {
            //TODO записывать № договора
            if ($message == "Погасить частично \u{1F4B8}") {
                $tUser->step = '2';
                $tUser->save();
            }
            if ($message == "Погасить всю сумму \u{1F4B8}") {
                $tUser->step = '3';
                $tUser->save();
            }
            $resp = CreditController::check($this->t_id, $message);
        }

        if ($tUser->section == 'pay') {
            $resp = CreditController::pay($this->t_id, $message);
        }

        if($tUser->section == 'showProfile') {
            //TODO Проверять ввод только цифры
            // if (!is_int($message)) {
            //     $tUser->section = '';
            //     $tUser->save();
            //     $this->sendMsg($resp);
            //     return;
            // }

            $resp = RegisterController::show($this->t_id, $message);
        }

        if($tUser->section == 'editProfile') {
            $resp = RegisterController::edit($this->t_id, $message);
        }



        // Обработка комманд

        if ($message === 'Регистрация') {
            $tUser->section = 'register';
            $tUser->step = '0';
            $tUser->save();
            $resp = RegisterController::index($this->t_id, $message);
        }

        if ($message === "Проверить остаток \u{1F4B0}") {
            $tUser->section = 'check';
            $tUser->step = '0';
            $tUser->save();
            $resp = CreditController::check($this->t_id, $message);
        }

        if ($message === "Отдать кредит \u{1F4B8}") {
            $tUser->section = 'pay';
            $tUser->step = '0';
            $tUser->save();
            $resp = CreditController::pay($this->t_id, $message);
        }

        if ($message === "Профиль") {
            $tUser->section = 'profile';
            $tUser->step = '0';
            $tUser->save();
            $resp = RegisterController::profile($this->t_id, $message);
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
                    ["Проверить остаток \u{1F4B0}", "Отдать кредит \u{1F4B8}"],
                    ["Профиль", 'Контакты']
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
            'reply_markup' => $reply_markup,
            'parse_mode' => 'html'
        ]);
    }
}
