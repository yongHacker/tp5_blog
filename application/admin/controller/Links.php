<?php
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Loader;
    //use think\Validate;
    use app\admin\model\Links as LinksModel;
    header("content-type:text/html;charset=utf-8");

    class Links extends Base{
        /**列表操作
         * @return mixed
         */
        public function  lst(){
            $list = LinksModel::paginate(2);
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
                    'title' => input('title'),
                    'url' => input('url'),
                    'desc' => input('desc'),
                ];
                $validate = Loader::validate('Links');
                if (!$validate->scene('add')->check($data)){
                    $this->error($validate->getError());
                    exit;
                }
                //助手函數 db('admin')->insert($data) 可以不引入Db类
                if(Db::name('links')->insert($data)){   //返回插入的数据条数
                    return $this->success('添加链接成功','lst');
                }else{
                    return $this->error('添加链接失敗','add');
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
            $linkss = db('links')->find($id);
            if (request()->isPost()){
               //存储post过来的数据
                $data = [
                    'id' => input('post.id'),
                    'title' => input('post.title'),
                    'url' => input('post.url'),
                    'desc' => input('post.desc'),
                ];

                //验证用户输入
                $validate = Loader::validate('Links');
                if (!$validate->scene('edit')->check($data)) {
                    $this->error($validate->getError());
                    exit;
                }
                //更新数据库
                if(db('links')->update($data)){
                    $this->success('修改链接成功','lst');
                }else{
                    $this->error('修改链接失败','edit');
                }
                return;
            }
            //把根据id查询到的原始数据注册进edit.htm
            $this->assign('linkss',$linkss);
            return $this->fetch('edit');
        }

        /**
         * 删除操作
         */
        public function del(){
            $id = input('id');

            if (db('links')->delete($id)){
                $this->success('删除链接成功','lst');
            }else{
                $this->error('删除链接失败');
            }

        }




    }



?>