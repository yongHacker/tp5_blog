<?php
namespace app\index\controller;
use app\index\controller\Base;
class Search extends Base
{
    public function index()
    {
        $keywords = input('keywords');
        if ($keywords){
            $map['title']=['like','%'.$keywords.'%'];
            $searchres = db('article')->where($map)->select();
            $searchres = db('article')->where($map)->order('id desc')->paginate(2,false,array('query'=>array(
                'keywords'=>$keywords,
            )));
            $this->assign(array(
               'searchres'=>$searchres,
               'keywords'=>$keywords,
            ));
        }else{
            $this->assign(array(
                'searchres'=>array(),
                'keywords'=>'暂无数据',
            ));
        }

        return $this->fetch('search');
    }
}
