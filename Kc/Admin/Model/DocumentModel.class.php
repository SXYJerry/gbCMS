<?php
/**
 * Created by PhpStorm.
 * User: xq
 * Date: 16-1-17
 * Time: 下午11:13
 */

namespace Admin\Model;

use Think\Model;

class DocumentModel extends Model implements Atc
{
    //protected $tableName = '';
    public $id;

    public function editor(){

    }

    public function addAtc($cate){  //添加文档
        $atc_id =$this->add();
        if($atc_id==false){
            $this->error='添加失败';
            return false;
        }
        $cate_atc = M('cate_atc');
        $cate_atc->atc_id = $atc_id;
        $cate_atc->cate = $cate ;
        $cate_atc->title = $this->title ;
        $cate_atc->createtime = date() ;
        $cate_atc->model_id = M('model')->field('id')->where(['name'=>$this->trueTableName])->find();
        $cate_atc->status=1;
        if($cate_atc->add()){
            return true;
        }else{
            $this->delete();
            $this->error='添加失败';
            return false;
        }
    }

    public function deleteAtc(){

    }

    public function detail(){
        $status = $this->query("select status from {$this->trueTableName} WHERE id=$this->id");
        //var_dump($status);
        $atcInfo = $this->where('id=%d',$this->id)->find();
        if($atcInfo['status']==1){
            //$atcInfo = $this->query("select title from {$this->trueTableName} WHERE id=$this->id");



            return $atcInfo;
        }else{
            return 'h';//$this->getDbError();
            //返回状态信息
        }

    }

}