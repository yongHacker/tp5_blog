<?php
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Loader;
    header("content-type:text/html;charset=utf-8");

    class Tags extends Base{
        /**列表操作
         * @return mixed
         */
        public function  lst(){
            $list = Db('tags')->paginate(2);
            $this->assign('list',$list);
            return $this->fetch('lst');
        }

        /**添加操作
         * @return mixed|void
         */
        public function  add(){
            if(request()->isPost()){
                $data = [
                    'tagname' => input('tagname'),
                ];
                $validate = Loader::validate('Tags');
                if (!$validate->scene('add')->check($data)){
                    $this->error($validate->getError());
                    exit;
                }
                //助手函數 db('admin')->insert($data) 可以不引入Db类
                if(Db::name('Tags')->insert($data)){   //返回插入的数据条数
                    return $this->success('添加Tags标签成功','lst');
                }else{
                    return $this->error('添加Tags标签失敗','add');
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
            $tags = db('tags')->find($id);
            if (request()->isPost()){
               //存储post过来的数据
                $data = [
                    'id' => input('post.id'),
                    'tagname' => input('post.tagname'),
                ];

                //验证用户输入
                $validate = Loader::validate('Tags');
                if (!$validate->scene('edit')->check($data)) {
                    $this->error($validate->getError());
                    exit;
                }
                //更新数据库
                if(db('tags')->update($data)){
                    $this->success('修改Tags标签成功','lst');
                }else{
                    $this->error('修改Tags标签失败','edit');
                }
                return;
            }
            //把根据id查询到的原始数据注册进edit.htm
            $this->assign('tags',$tags);
            return $this->fetch('edit');
        }

        /**
         * 删除操作
         */
        public function del(){
            $id = input('id');

            if (db('Tags')->delete($id)){
                $this->success('删除Tags标签成功','lst');
            }else{
                $this->error('删除Tags标签失败');
            }

        }




    }



?>