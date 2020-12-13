<?php

namespace core\user\controller;

use core\base\controller\BaseController;

class IndexController extends BaseController
{
    protected $name;

    protected function inputData(){

        $num = '1.5';
        $this->clearNum($num);
        exit();

    }
}