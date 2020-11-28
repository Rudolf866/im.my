<?php


namespace core\base\controllers;

use core\base\settings\Settings;


class RouteController
{
    static private $_instance;

    private function __clone()
    {

    }

    static public function getInstance()
    {
        if(self::$_instance instanceof self)
        {
            return self::$_instance;
        }
        return self::$_instance = new self;
    }

    private function __construct()
    {
  //        $arr = ['1','2','3','4'];
  //        print_arr($arr);
            $s = Settings::_get('routes');
            exit();
    }

}