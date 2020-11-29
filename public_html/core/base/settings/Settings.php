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
    private $lalala = 'lala';

    public function clueProperties($class)
    {
        $baseProperties = [];

        foreach( $this as $name => $item)
        {
            $property = $class::_get($name);

            if(is_array($property) && is_array($item))
            {

                $baseProperties[$name] =  $this->arrayMergeRecursive($this->$name,$property);
                continue;
            }
            if(!$property) $baseProperties[$name] = $this->$name;
        }
        return $baseProperties;
    }

    public function arrayMergeRecursive()
    {
        $arrays = func_get_args();
        $base = array_shift($arrays);

        foreach($arrays as $array)
        {
            foreach($array as $key => $value)
            {
                if(is_array($value) && is_array($base[$key]))
                {
                    $base[$key] = $this->arrayMergeRecursive($base[$key],$value);
                } else {
                    if(is_int($key)){
                        if(!in_array($value,$base)) array_push($base,$value);
                        continue;
                    }
                    $base[$key] = $value;
                }
            }
        }
        return $base;
    }
}