<?php
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Loader;
    use app\admin\model\Admin as AdminModel;
    header("content-type:text/html;charset=utf-8");

    class Admin extends Base{
        /**列表操作
         * @return mixed
         */
        public function  lst(){
            $list = AdminModel::paginate(2);
            $this->assign('list',$list);
            return $this->fetch('lst');
        }

        /**添加操作
         * @return mixed|void
         */
        public function  add(){
            if(request()->isPost()){
                /*  验证类的形式
                    $validate = new Validate([
                    'username' => 'require|max:25',
                    'password' => 'require|max:25',
                ]);
                */
                $data = [
                    'username' => input('username'),
                    'password' => md5(input('password')),
                ];
                $validate = Loader::validate('Admin');
                if (!$validate->scene('add')->check($data)){
                    dump($validate->getError());
                }
                //助手函數 db('admin')->insert($data) 可以不引入Db类
                if(Db::name('admin')->insert($data)){   //返回插入的数据条数
                    return $this->success('添加管理員成功','lst');
                }else{
                    return $this->error('添加管理員失敗','add');
                }
                return;
            }
            return $this->fetch('add');
        }

        /**
         * 修改操作
         */
        public function edit(){
            $id=input('id');
            $admins = db('admin')->find($id);
            if (request()->isPost()){
               //存储post过来的数据
                $data = [
                    'id' => input('post.id'),
                    'username' => input('username'),
                    'password' => input('password'),
                ];
                //判断用户是否输入空密码
                if (input('password')){
                    $data['password'] = md5(input('password'));
                }else{
                    $data['password'] = $admins['password'];
                }
                //验证用户输入
                $validate = Loader::validate('Admin');
                if (!$validate->scene('edit')->check($data)) {
                    $this->error($validate->getError());
                    exit;
                }
                //更新数据库
                if(db('admin')->update($data)){
                    $this->success('修改管理员成功','lst');
                }else{
                    $this->error('修改管理员失败','edit');
                }
                return;
            }
            //把根据id查询到的原始数据注册进edit.htm
            $this->assign('admins',$admins);
            return $this->fetch('edit');
        }

        /**
         * 删除操作
         */
        public function del(){
            $id = input('id');
            if ($id != 1){
                if (db('admin')->delete($id)){
                    $this->success('删除管理员成功','lst');
                }else{
                    $this->error('删除管理员失败');
                }
            }else{
                $this->error('系统管理员不能删除');
            }

        }

        /**
         * 注销
         */
        public function logout(){
            session(null);
            $this->success('注销成功','Login/index');
        }




    }



?>