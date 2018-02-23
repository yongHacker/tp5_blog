<?php
    namespace app\admin\controller;
    use app\admin\controller\Base;
    use think\Db;
    use think\Loader;
    //use think\Validate;
    use app\admin\model\Article as ArticleModel;
    header("content-type:text/html;charset=utf-8");

    class Article extends Base{
        /**列表操作
         * @return mixed
         */
        public function  lst(){
            $list = ArticleModel::paginate(2);
//            $list = db('article')->alias('a')->join('cate c','c.id=a.cateid')->field(
//                'a.id,a.title,a.pic,a.author,a.state,c.catename')->paginate(2);
            $this->assign('list',$list);
            return $this->fetch('lst');
        }

        /**添加操作
         * @return mixed|void
         */
        public function  add(){
            if(request()->isPost()){
                $data = [
                    'title' => input('post.title'),
                    'author' => input('post.author'),
                    'desc' => input('post.desc'),
                    'keywords' => str_replace('，',',',input('post.keywords')),
                    'content' => input('post.content'),
                    'cateid' => input('post.cateid'),
                    'time' => time(),
                ];
                if (input('state')=='on'){
                    $data['state'] = 1;
                }
                //$_FILES 文件上传变量
                if ($_FILES['pic']['tmp_name']){
                    $file = request()->file('pic');
                    $info = $file->move(ROOT_PATH.'public'.DS.'static/uploads');
                    $data['pic'] = $info->getSaveName();    //得到文件存储路径
                }
                $validate = Loader::validate('Article');
                if (!$validate->scene('add')->check($data)){
                    $this->error($validate->getError());
                    exit;
                }
                //助手函數 db('article')->insert($data) 可以不引入Db类
                if(Db::name('article')->insert($data)){   //返回插入的数据条数
                    return $this->success('添加文章成功','lst');
                }else{
                    return $this->error('添加文章失敗','add');
                }
                return;
            }
            $cateres=db('cate')->select();
            $this->assign('cateres',$cateres);
            return $this->fetch('add');
        }

        /**
         * 修改操作
         */
        public function edit(){
            $id=input('id');
            $articles = db('article')->find($id);
            $cateres=db('cate')->select();
            if (request()->isPost()){
               //存储post过来的数据
                $data = [
                    'id' => input('post.id'),
                    'title' => input('post.title'),
                    'author' => input('post.author'),
                    'desc' => input('post.desc'),
                    'keywords' => str_replace('，',',',input('post.keywords')),
                    'content' => input('post.content'),
                    'cateid' => input('post.cateid'),
                    'time' => time(),
                ];
                //存储特殊数据
                if (input('state')=='on'){
                    $data['state']=1;
                }else{
                    $data['state']=0;
                }
                if ($_FILES['pic']['tmp_name']){
                    $file = request()->file('pic');
                    $info = $file->move(ROOT_PATH.'public'.DS.'static/uploads');
                    $data['pic'] = $info->getSaveName();
                }
                //验证用户输入
                $validate = Loader::validate('Article');
                if (!$validate->scene('edit')->check($data)) {
                    $this->error($validate->getError());
                    exit;
                }
                //更新数据库
                if(db('article')->update($data)){
                    $this->success('修改文章成功','lst');
                }else{
                    $this->error('修改文章失败','edit');
                }
                //退出脚本，不继续下面的语句
                return;
            }
            //把根据id查询到的原始数据注册进edit.htm
            $this->assign('cateres',$cateres);
            $this->assign('articles',$articles);
            return $this->fetch('edit');
        }

        /**
         * 删除操作
         */
        public function del(){
            $id = input('id');

            if (db('article')->delete($id)){
                $this->success('删除文章成功','lst');
            }else{
                $this->error('删除文章失败');
            }

        }




    }



?>