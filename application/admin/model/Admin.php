<?php
    namespace app\admin\model;
    use think\Model;
    use think\Db;

    class Admin extends Model{
        //登录处理
        public function login($data){
            $user = Db::name('admin')->where('username','=',$data['username'])->find();
            if ($user){
                if ($user['password']==md5($data['password'])){
                    session('username',$user['username']);
                    session('uid',$user['id']);
                    return 3;//登录验证通过
                }else{
                    return 2;//密码错误
                }

            }else{
                return 1;//用户不存在
            }
        }



    }



?>