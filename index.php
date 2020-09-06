<?php

use core\utils\Tg;

require_once 'vendor/autoload.php';

switch (Tg::getUpdateType()) {
    case Tg::MESSAGE:
        // handle global commands
        if (Tg::Text() == '/start') {
            Start::show();
        } else {
            // if it is not global command
            // handle by page
            handleCurrentPage();
        }
        break;
    case Tg::CALLBACK_QUERY:
        require_once 'handlers/callback_query.php';
        break;
    case Tg::INLINE_QUERY:
        require_once 'handlers/inline_query.php';
        break;
    case Tg::EDITED_MESSAGE:
        require_once 'handlers/edited_message.php';
        break;
    case Tg::CHANNEL_POST:
        require_once 'handlers/channel_post.php';
        break;
}