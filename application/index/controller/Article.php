<?php
namespace app\index\controller;
use app\index\controller\Base;
header("content-type:text/html;charset=utf-8");
class Article extends Base
{
    public function index()
    {
        $articleId = input('articleId');
        $cates = db('cate')->find($articleId);
        $articles = db('article')->find($articleId);
        $ralatres = $this->ralat($articles['keywords'],$articles['id']);
        db('article')->where('id',$articleId)->setInc('click');
        $recres = db('article')->where(array('cateid'=>$cates['id'],'state'=>1))->limit(8)->select();
        $this->assign(array(
           'articles'=>$articles,
            'cates'=>$cates,
            'recres'=>$recres,
            'ralatres'=>$ralatres,
        ));
        return $this->fetch('article');
    }

    public function ralat($keywords,$id){
        $arr = explode(',',$keywords);//将字符串转换为数组
        static $ralatres = array();
        //遍历数组
        foreach ($arr as $v){
            //根据单个关键字查询
            $map['keywords'] = array('like','%'.$v.'%');
            //不查询自己本身
            $map['id'] = array('neq',$id);
            $artres = db('article')->where($map)->order('id desc')->limit(8)->select();
            //将$artres加进$ralatres数组
            $ralatres = array_merge($ralatres,$artres);
        }
        if ($ralatres) {
            //调用common.php中arr_unique()方法
            $ralatres = arr_unique($ralatres);
            return $ralatres;
        }else{
            return null;
        }
    }

}
