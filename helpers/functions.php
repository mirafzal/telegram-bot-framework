<?php

use core\utils\Texts;
use core\utils\Tg;
use core\utils\User;

function sendMessage($text, $keyboard = null)
{
    $content = ['chat_id' => Tg::ChatID(), 'text' => $text];
    if ($keyboard != null) $content['reply_markup'] = $keyboard;
    Tg::sendMessage($content);
}

function handleCurrentPage()
{

    // For example:
    // User::getPage() returns 'start'.
    // Then we call handle() method of corresponding page class,
    // in this example Start.php class

    $pageClassName = ucfirst(User::getPage());
    $pageClassName::handle();
}

function broadcastMessage($text)
{
    // While broadcasting, when php sends messages,
    // it cannot answer 'ok' to the telegram requests.
    // So, telegram sends requests again and again,
    // while your server does not answer
    // because of this, instead of sending one message once
    // to one user, it sends one message multiple times
    // and bot does not stop spamming.
    //
    // To solve this problem, we create a temporary file
    // when we start broadcasting and delete it after
    // broadcast.
    //
    // Also, when we send a message to the user,
    // telegram sends request and that request contains
    // information about if the message delivered.
    // If response contains 'ok', the message is delivered
    // else not. So we can count number of delivered messages
    // and this is number of active users.
    // Other users blocked your bot.

    if (!file_exists(__DIR__ . '/bc.tmp')) {
        file_put_contents(__DIR__ . '/bc.tmp', ".");
        sendMessage('broadcast_start_info');
        $usersChatIds = R::getCol("SELECT chat_id FROM users");
        $successCount = 0;
        $failCount = 0;
        foreach ($usersChatIds as $chatId) {
            $response = Tg::sendMessage(['chat_id' => $chatId, 'text' => $text]);
            $response['ok'] ? $successCount++ : $failCount++;
            sleep(1);
        }
        sendMessage(Texts::get('broadcast_complete_info', $successCount, $failCount));
        unlink(__DIR__ . '/bc.tmp');
    } else {
        sendMessage("Another message is being sent at the moment. Try later.");
    }
}