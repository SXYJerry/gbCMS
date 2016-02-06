<?php
/**
 * Created by PhpStorm.
 * User: xq
 * Date: 15-12-10
 * Time: 下午11:18
 */

namespace Admin\Controller;
use Admin\Model\ArticleModel;
use Admin\Model\CateModel;
use Home\Model\AritcleModel;
use Think\Controller;



class ArticleController extends Controller
{
    public function index($cate,$id){
        $article =
        $this->display();
    }

    public function listView($cate){
        $list= M('cate_atc');
        $list->where(['cate'=>$cate])->select();

    }

    public function detail($mid,$id){
        $modelInfo=get_model_info($mid);  //获取模型信息
        $article = D($modelInfo['name']);
        $article->id = $id;
        $atcInfo = $article->detail();
        if(!is_array($atcInfo)){
            //$this->error($atcInfo);
            //$this->ajaxreturn($article->getDbError());
        }
        $atcInfo['content']=htmlspecialchars_decode($atcInfo['content']);
        $this->assign($atcInfo);
        //var_dump($atcInfo);
        //var_dump($article->getError());
        $this->display(T($modelInfo['view_detail']));
    }

    /**
     * 文档控制台
     * @param $cate
     */
    public function admin($cate){
        $cateInfo = new CateModel();
    }

    /**
     * 添加文章
     * @param $cate 栏目
     * @param $mid  文档模型
     */
    public function addAtc($cate=1,$mid=''){
        if($mid==''){
            $mid=get_cate_Model($cate)[0]; //获取栏目对应的模型
        }
        $modelInfo=get_model_info($mid);  //获取模型信息

        if(IS_POST){
            $article = D($modelInfo['name']);    //建立模型对象
            //$article = new ArticleModel();
            //$article->id=$id;
        if(!$article->validate($modelInfo['rules'])->validate($modelInfo['rules'])->create()){

                $this->ajaxreturn($article->getError());//;
                //echo $article->getError();
                //$this->ajaxreturn($article->getError());
        }else{
            $article->status=1;
            $article->createtime=date();
            if(!$article->add()){        //提交内容
                $this->ajaxreturn($article->getDbError());
                echo $modelInfo['name'];
            }
                $this->ajaxreturn('添加成功');
            }
        }else{
                $this->display(T($modelInfo['view_edit']));
        }
    }

    /**编辑文章
     * @param $cate
     * @param string $id
     */
    public function editor($cate,$id=''){
        $atcModel=get_document_Model($cate);        //获取模型信息
        D($atcModel['name']);    //建立模型对象

        if(IS_POST){
            $article = new ArticleModel();
            $article->id=$id;
            if(!$article->validate($atcModel['rules'])->create()){             //验证是否合法
                $this->ajaxreturn($article->getError());//;
                //$this->ajaxreturn($article->getError());
            }else{
                $article->status=1;
                if(!$article->save()){        //提交内容
                    $this->ajaxreturn($article->getDbError());
                }
                $this->ajaxreturn('添加成功');
            }
        }else{
            $this->display();
        }
    }

}