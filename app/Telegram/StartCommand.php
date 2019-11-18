<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\TelegramUser;
use App\Client;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';

    /**
     * @var string Command Description
     */
    protected $description = 'Начать работу';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $telegram_user = \Telegram::getWebhookUpdates()['message'];

        $Client = Client::where('t_id', $telegram_user['from']['id'])->first();

        // save telegram user to DB
        if (!$Client) {
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



        $reply_markup = \Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => false,
            'selective' => true
        ]);

        $response = \Telegram::sendMessage([
            'chat_id' => $telegram_user['from']['id'], 
            'text' => 'Welcome', 
            'reply_markup' => $reply_markup
        ]);

    }
}
