<?php


namespace core\admin\controller;


use core\base\controller\BaseController;
use core\admin\model\Model;

class IndexController extends BaseController
{
    protected function inputData()
    {
        $db = Model::instance();

        $table = 'article';

        $res = $db->get($table,[
            'fields' => ['id','name'],
            'where' => ['id' => 1, 'name' =>'Rudik'],
            'operand' => ['=', '<>'],
            'condition' => ['AND'],
            'order' => ['fio', 'name'],
            'order_direction' => ['ASC','DESC'],
            'limit' => '1'

        ]);


        exit('I am admin panel!');
    }
}