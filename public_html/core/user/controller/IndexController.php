<?php

namespace core\user\controller;

use core\base\controller\BaseController;

class IndexController extends BaseController
{
    protected $name;

    use trait1, trait2{
        trait1::who insteadof trait2;
        trait2::who as who2;

    }


    protected function inputData(){

        $this->who();
        $this->who2();

        exit();
        $name = 'Ivan';

        $content = $this->render('',compact('name'));
        $header = $this->render(TEMPLATE.'header');
        $footer = $this->render(TEMPLATE.'footer');


        return compact('header','content','footer');

    }
}