<?php
    namespace app\admin\validate;
    use think\Validate;

    class Article extends Validate{
        //验证规则
        protected $rule = [
            'title' => 'require|max:25|unique:article',
            'cateid' => 'require'

        ];

        //验证信息提示
        protected $message = [
            'title.require' => '文章名称必须填写',
            'title.max' => '文章名称长度不能大于25',
            'title.unique' => '文章名称不能重复',
            'cateid.require' => '必须选择所属文章'
        ];

        //验证场景
        protected $scene = [
            'add' => ['title','cateid'],
            'edit' => ['title','cateid'],

        ];


    }


?>