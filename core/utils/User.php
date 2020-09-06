<?php

namespace core\utils;

use Config;
use R;

class User
{
    /**
     * @var int
     */
    private static $chatId;
    private static $userBean;

    /**
     * @param int $chatId
     */
    public static function setup($chatId)
    {
        self::$chatId = $chatId;
        self::$userBean = R::findOne('users', 'chat_id = :chatId', [':chatId' => self::$chatId]);

        // check if user already exists, else create new one

        if (self::$userBean == null) {
            self::$userBean = R::dispense('users');
            self::$userBean['chat_id'] = $chatId;
            self::setLanguage(Config::DEFAULT_LANGUAGE);
            self::setPage('start');
            R::store(self::$userBean);
        }
    }

    public static function isAdmin()
    {
        return in_array(self::$chatId, Config::ADMINS);
    }

    public static function get($key)
    {
        return self::$userBean->$key;
    }

    public static function set($key, $value)
    {
        self::$userBean->$key = $value;
        R::store(self::$userBean);
    }

    public static function setLanguage($language) {
        Texts::setup($language);
        self::$userBean->language = $language;
        R::store(self::$userBean);
    }

    public static function getLanguage() {
        return self::$userBean->language;
    }

    public static function setPage($page)
    {
        self::set('page', $page);
    }

    public static function getPage()
    {
        return self::get('page');
    }
}