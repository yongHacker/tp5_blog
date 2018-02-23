<?php
namespace app\index\controller;
use app\index\controller\Base;
class Index extends Base
{

    public function index()
    {
       $articles = db('article')->order('id asc')->paginate(4);
       $this->assign(array(
          'articles'=>$articles,
       ));
       return $this->fetch('index');
    }
}
