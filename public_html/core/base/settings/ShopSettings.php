<?php


namespace core\base\settings;


class ShopSettings extends Settings
{
    static private $_instance;

    private $templateArr = [
        'text'=> ['price','short'],
        'textarea'=> ['goods_content']

    ];

    static public function _get($property)
    {
        return self::instance()->$property;
    }

    static public function instance()
    {
        if (self::$_instance instanceof self)
        {
            return self::$_instance;
        }
        return self::$_instance = new self;
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }
}