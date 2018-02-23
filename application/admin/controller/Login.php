<?php
    namespace app\admin\controller;
    use think\Controller;
    use app\admin\model\Admin;


    header("content-type:text/html;charset=utf-8");

    class Login extends Controller{

        public function index(){
            if (request()->isPost()){
                $data = input('post.');
                $admin = new Admin();
                if ($admin->login($data)==1){
                    $this->error('用户不存在');
                }elseif ($admin->login($data)==2){
                    $this->error('密码错误');
                }elseif ($admin->login($data)==3){
                    $this->success('登录通过','Index/index');
                }
            }
            return $this->fetch('login');
        }






    }



?>