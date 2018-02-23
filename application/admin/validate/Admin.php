<?php
    namespace app\admin\validate;
    use think\Validate;

    class Admin extends Validate{
        //验证规则
        protected $rule = [
            'username' => 'require|max:25|unique:admin',
            'password' => 'require',
        ];

        //验证信息提示
        protected $message = [
            'username.require' => '管理员名称必须填写',
            'username.max' => '管理员名称长度不能大于25',
            'password.require' => '管理员密码必须填写',
        ];

        //验证场景
        protected $scene = [
            'add' => ['username'=>'require|max:25', 'password'],
            'edit' => ['username'=>'require','password'],

        ];


    }


?>