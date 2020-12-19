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

        $files['gallery_img'] =['new_red.png'];
        $files['img'] ='main_img.jpg';


        $_POST['id'] = 7;
        $_POST['name'] = 'Oksana';
        $_POST['content'] ="<p>New' book</p>";
        $_POST['price'] = 1250;

        $res = $db->edit($table);

        exit('id ='. $res['id'] . 'Name =' . $res['name']);
    }
}