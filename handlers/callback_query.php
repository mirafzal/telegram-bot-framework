<?php

use core\utils\Tg;

Tg::answerCallbackQuery(['callback_query_id' => Tg::Callback_ID(), 'text' => 'Callback data: ' . Tg::Text(), 'show_alert' => false]);
Tg::deleteMessage(['chat_id' => Tg::ChatID(), 'message_id' => Tg::MessageID()]);