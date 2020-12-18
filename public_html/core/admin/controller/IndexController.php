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

        $color =['red','blue','black'];

        $res = $db->get($table,[
            'fields' => ['id','name'],
            'where' => ['name' =>'Masha','surname'=>'Sergeevna','fio'=>'Andrey','car' => 'Porshe','color'=>$color],
            'operand' => ['IN', 'LIKE%','<>','=','NOT IN'],
            'condition' => ['OR','AND'],
            'order' => ['fio', 'name'],
            'order_direction' => ['DESC'],
            'limit' => '1'

        ]);


        exit('I am admin panel!');
    }
}