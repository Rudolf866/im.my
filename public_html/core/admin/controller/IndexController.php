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
            'limit' => '1',
            'join' => [
                'join_table1' => [
                    'table'=>'join_table1',
                    'fields'=>['id as j_id', 'name as j_name'],
                    'type' => 'left',
                    'where' => ['name'=>'sasha'],
                    'operand' => ['='],
                    'condition' => ['OR'],
                    'on' =>[
                        'table'=>'article',
                        'fields'=>['id','parent_id']
                    ]

                ],
                'join_table2' => [
                    'table'=>'join_table2',
                    'fields'=>['id as j2_id', 'name as j2_name'],
                    'type' => 'left',
                    'where' => ['name'=>'sasha'],
                    'operand' => ['='],
                    'condition' => ['OR'],
                    'on' =>[
                        'table'=>'article',
                        'fields'=>['id','parent_id']
                    ]

                ]
            ]

        ]);


        exit('I am admin panel!');
    }
}