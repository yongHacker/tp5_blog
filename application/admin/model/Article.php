<?php
    namespace app\admin\model;
    use think\Model;

    class Article extends Model{
        //两表关联
        public function cate(){
            return $this->belongsTo('Cate','cateid');
        }



    }



?>