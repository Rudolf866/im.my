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

        $files['gallery_img'] =['red.png','blue.png','black.png'];
        $files['img'] ='main_img.jpg';
//
//        $c = json_encode($table);
//
//        echo addslashes($c).'<br>';
//
//        exit(print_arr(json_decode($c)));

        $res = $db->add($table,[
            'fields' => ['name' =>'Katay','content' =>'Hello','price'=>'120'],
            'except' => ['name'],
            'files' => $files
        ]);


        exit('id ='. $res['id'] . 'Name =' . $res['name']);
    }
}