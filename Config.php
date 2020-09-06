<?php


class Config
{
    // webhook or getUpdates
    // currently support only for webhook
    // when change this parameter
    // open SERVER_URL in browser
    const UPDATE_TYPE = 'webhook';

    // bot token
    // take it from
    // https://telegram.me/BotFather
    const BOT_TOKEN = '';

    // server url for webhook
    // url must have ssl certificate
    // For example:
    // https://example.com/sample-bot/index.php
    // To set webhook automatically,
    // open this SERVER_URL in browser
    const SERVER_URL = '';

    // your id to replace chat_id,
    // when accessing from browser
    // in debug mode
    // you can get it from
    // https://t.me/JsonResultBot
    const DEVELOPER_CHAT_ID = 1234;

    // Default language for users,
    // for this language you need to create
    // corresponding strings.php file.
    // For example, if you set default language
    // to 'ru', you need to create
    // strings.php file at directory
    // localization/ru/strings.php
    const DEFAULT_LANGUAGE = 'en';

    // debug mode to check errors in browser
    const DEBUG_MODE = true;

    // database type:
    // SQLite, MySQL or PostgreSQL
    const DATABASE_TYPE = 'sqlite';

    // hostname, usually localhost
    const DATABASE_HOSTNAME = 'localhost';

    // database name
    const DATABASE_NAME = '';

    // database username, for local servers usually 'root'
    const DATABASE_USERNAME = '';

    // database password, for local servers usually 'root' or without password
    const DATABASE_PASSWORD = '';

    // list of administrators
    const ADMINS = [
        self::DEVELOPER_CHAT_ID,

    ];
}