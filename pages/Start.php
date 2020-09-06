<?php

use core\utils\Page;
use core\utils\Texts;
use core\utils\User;

class Start implements Page
{

    static function show()
    {
        User::setPage('start');
        sendMessage(Texts::get('greetings'));
    }

    static function handle()
    {
        sendMessage(Texts::get('handler_text'));
    }
}