<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'test';

    /**
     * @var string Command Description
     */
    protected $description = 'Test command, Get a list of commands';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $user = \App\User::find(1);

        $this->replyWithMessage(['text' => 'Почта пользователя в laravel: '.$user->email]);

        $telegram_user = \Telegram::getWebhookUpdates()['message'];
        $text = sprintf('%s: %s'.PHP_EOL, 'Ваш номер чата', $telegram_user['from']['id']);
        $text .= sprintf('%s: %s'.PHP_EOL, 'Ваше имя пользователя в телеграм', $telegram_user['from']['username']);

        $this->replyWithMessage(compact('text'));
    }
}
