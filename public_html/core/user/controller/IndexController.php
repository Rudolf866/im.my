<?php

namespace core\user\controller;

use core\base\controller\BaseController;

class IndexController extends BaseController
{
    protected $name;

    protected function inputData(){
        $this->name = 'Masha';
        //$template = $this->render(false, ['name'=>'Masha']);
        //exit($template);
    }

    protected function outputData(){

    }
}