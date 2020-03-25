<?php

class App
{
    static $db = null;

    static function getDatabase()
    {
        if (!self::$db) {
            self::$db = new Database('sidiDB', 'sidichahid', 'blogPHPdojo');
        }
        return self::$db;
    }
    static function redirect($page) {
        header("Location: $page");
        exit();
    }

    static function getAuth() {
        return new Auth(Session::getInstance(), ['restriction_msg' => 'non autorisé']);
    }
}
