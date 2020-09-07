<?php

use core\utils\Texts;
use core\utils\Tg;
use core\utils\User;

// prevent access from browser

if ($_SERVER['HTTP_USER_AGENT'] != null && !Config::DEBUG_MODE) {
    header("Location: http://" . $_SERVER['SERVER_NAME']);
}

// show errors in browser?

if (Config::DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}


// setup database ReadBeanPHP

switch (strtolower(Config::DATABASE_TYPE)) {
    case 'sqlite':
        $directory = __DIR__ . '/database';
        if (!file_exists($directory)) {
            mkdir($directory);
        }
        $fileName = $directory . 'db.sqlite';
        if (!file_exists($fileName)) {
            file_put_contents($fileName, '');
        }
        R::setup('sqlite:' . $fileName);
        break;
    case 'mysql':
        R::setup('mysql:host=' . Config::DATABASE_HOSTNAME . ';dbname=' . Config::DATABASE_NAME,
            Config::DATABASE_USERNAME, Config::DATABASE_PASSWORD);
        break;
    case 'postgresql':
        R::setup('pgsql:host=' . Config::DATABASE_HOSTNAME . ';dbname=' . Config::DATABASE_NAME,
            Config::DATABASE_USERNAME, Config::DATABASE_PASSWORD);
        break;
        default;
        die('Wrong database type!');

}
R::useWriterCache(true);


// setup Telegram class

Tg::setup(Config::BOT_TOKEN);

// set webhook if not set

if (Config::UPDATE_TYPE == 'webhook') {
    if (Tg::endpoint('getWebhookInfo', [])['result']['url'] != Config::SERVER_URL) {
        Tg::setWebhook(Config::SERVER_URL);
    }
} elseif (Config::UPDATE_TYPE == 'getUpdates') {
    if (Tg::endpoint('getWebhookInfo', [])['result']['url'] != "") {
        Tg::deleteWebhook();
    }
} else {
    die("Wrong update type! Check UPDATE_TYPE in Config.php file.");
}

// setup User class

if (Tg::ChatID() != null) {
    User::setup(Tg::ChatID());
} elseif (Config::DEBUG_MODE) {
    User::setup(Config::DEVELOPER_CHAT_ID);
}

// setup Texts class

Texts::setup(User::getLanguage());

// require all page classes

$files = glob('pages' . '/*.php');
foreach ($files as $file) {
    require_once $file;
}
