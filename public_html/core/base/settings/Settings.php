<?php


namespace core\base\settings;


class Settings
{
    static private $_instance;

    private $routes = [
        'admin' =>[
            'name' => 'admin',
            'path' => 'core/admin/controllers/',
            'hrUrl' => false
        ],
        'settings' =>[
            'path' => 'core/base/settings'
        ],
        'plugins' =>[
            'path' => 'core/plugins',
            'hrUrl' => false
        ],
        'user' =>[
            'path' => 'core/user/controllers/',
            'hrUrl' => true,
            'routes' =>[

            ]
        ],
        'default' =>[
            'controller' =>'IndexController',
            'InputMethod' => 'InputData',
            'OutputMethod' => 'OutputData'
        ]
    ];

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    static public function _get($property)
    {
        return self::instance()->$property;
    }

    private $templateArr = [
        'text'=> ['name','phone','address'],
        'textarea'=> ['content','keywords']

        ];

    static public function instance()
    {
        if (self::$_instance instanceof self)
        {
            return self::$_instance;
        }
        return self::$_instance = new self;
    }
}