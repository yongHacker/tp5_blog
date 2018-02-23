<?php
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Loader;
    //use think\Validate;
    use app\admin\model\Cate as CateModel;
    header("content-type:text/html;charset=utf-8");

    class Cate extends Base{
        /**列表操作
         * @return mixed
         */
        public function  lst(){
            $list = CateModel::paginate(2);
            $this->assign('list',$list);
            return $this->fetch('lst');
        }

        /**添加操作
         * @return mixed|void
         */
        public function  add(){
            if(request()->isPost()){
                $data = [
                    'catename' => input('post.catename'),
                ];
                $validate = Loader::validate('Cate');
                if (!$validate->scene('add')->check($data)){
                    $this->error($validate->getError());
                    exit;
                }
                //助手函數 db('cate')->insert($data) 可以不引入Db类
                if(Db::name('cate')->insert($data)){   //返回插入的数据条数
                    return $this->success('添加栏目成功','lst');
                }else{
                    return $this->error('添加栏目失敗','add');
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
            $cates = db('cate')->find($id);
            if (request()->isPost()){
               //存储post过来的数据
                $data = [
                    'id' => input('post.id'),
                    'catename' => input('post.catename'),
                ];
                //验证用户输入
                $validate = Loader::validate('Cate');
                if (!$validate->scene('edit')->check($data)) {
                    $this->error($validate->getError());
                    exit;
                }
                //更新数据库
                if(db('cate')->update($data)){
                    $this->success('修改栏目成功','lst');
                }else{
                    $this->error('修改栏目失败','edit');
                }
                //退出脚本，不继续下面的语句
                return;
            }
            //把根据id查询到的原始数据注册进edit.htm
            $this->assign('cates',$cates);
            return $this->fetch('edit');
        }

        /**
         * 删除操作
         */
        public function del(){
            $id = input('id');

            if (db('cate')->delete($id)){
                $this->success('删除栏目成功','lst');
            }else{
                $this->error('删除栏目失败');
            }

        }




    }



?>