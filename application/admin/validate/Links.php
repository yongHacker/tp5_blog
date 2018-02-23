<?php
    namespace app\admin\validate;
    use think\Validate;

    class Links extends Validate{
        //验证规则
        protected $rule = [
            'title' => 'require|max:25',
            'url' => 'require',
        ];

        //验证信息提示
        protected $message = [
            'title.require' => '链接名称必须填写',
            'title.max' => '链接名称长度不能大于25',
            'url.require' => '链接url必须填写',
        ];

        //验证场景
        protected $scene = [
            'add' => ['title','url'],
            'edit' => ['title','url'],

        ];


    }


?>