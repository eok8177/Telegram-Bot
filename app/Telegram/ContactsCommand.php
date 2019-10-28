<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ContactsCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'contacts';

    /**
     * @var string Command Description
     */
    protected $description = 'Контакты';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $text = 'Контакты:'.PHP_EOL;
        $text .= 'тел: 05012345678'.PHP_EOL;
        $text .= 'e-mail: mail@mail.com'.PHP_EOL;

        $this->replyWithMessage(compact('text'));
    }
}
