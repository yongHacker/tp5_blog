<?php
namespace app\index\controller;
use app\index\controller\Base;
class Cate extends Base
{
    public function index()
    {
        $cateid = input('cateid');
        //查询当前栏目名称
        $cates = db('cate')->find($cateid);
        //查询当前栏目下的文章
        $articleres = db('article')->where(array('cateid'=>$cateid))->paginate(1);
        $this->assign(array(
            'articleres'=>$articleres,
            'cates'=>$cates
            ));
        return $this->fetch('cate');
    }
}
