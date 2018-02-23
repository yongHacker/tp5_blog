<?php
    namespace app\admin\validate;
    use think\Validate;

    class Tags extends Validate{
        //验证规则
        protected $rule = [
            'tagname' => 'require|max:25|unique:tags',
        ];

        //验证信息提示
        protected $message = [
            'tagname.require' => 'Tags标签名称必须填写',
            'tagname.max' => 'Tags标签名称长度不能大于25',
            'tagname.unique' => 'Tags标签名称不能重复',
        ];

        //验证场景
        protected $scene = [
            'add' => ['tagname'],
            'edit' => ['tagname'],
        ];


    }


?>