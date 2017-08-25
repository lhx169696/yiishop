<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 22:15
 */

namespace backend\controllers;

use yii;
use backend\models\GoodsCategory;

class CategoryController extends BaseController
{
    /**
     * 删除
     */
      public function actionDelete(){
          $id=Yii::$app->request->get('id',0);
          $dateone=GoodsCategory::findOne($id);
          if ($dateone->children()->exists()){
              GoodsCategory::deleteAll(['pid'=>$dateone->id]);
              echo "成功删除父类节点以及子节点";
          }
          GoodsCategory::deleteAll(['id'=>$id]);
          echo "成功删除子节点";
      }

    /**
     * 修改
     */
    public function actionUpdate(){
        $date=Yii::$app->request->post();
        $dateone=GoodsCategory::findOne($date["id"]);

        if ($dateone->pid==$date['GoodsCategory']['pid']) {

            if (!$dateone->load($date) || !$dateone->save()) {
                    var_dump($dateone->getErrors());
                    exit();
            }
            echo "修改成功";
            exit();
        }
        if ($dateone->children()->exists()) {

            echo  "本节点下有子节点，不能修改上一级节点";
            exit();
        }
        //删除子节点

        $delres=GoodsCategory::deleteAll(['id'=>$date["id"]]);

           $GoodsModel=new GoodsCategory();
        $GoodsModel->load($date);

           $predate=GoodsCategory::findOne($date['GoodsCategory']['pid']);
        $result=$GoodsModel->appendTo($predate);
        if ($result===false) {
            var_dump($GoodsModel->getErrors());
            exit();
        }

        echo "修改成功";
    }

    public function actionEdit(){
       $id=Yii::$app->request->get('id',0);
        if (empty($id)) {
            echo "参数不对";
            exit();
        }

        $Goods=GoodsCategory::find()
            ->select(['id','pid','name'])
            ->orderBy('left_key asc')->asArray()->all();
        $date=GoodsCategory::findOne($id);
     return $this->render("edit",['model'=>$date,'goods'=>json_encode($Goods)]);
    }


    /**
     * @return string
     * 显示
     */
    public function actionList(){
             $Goodsmodel=GoodsCategory::find()
                 ->orderBy('left_key asc')
                 ->asArray()->all();

      return  $this->render("list",['Goodsmodel'=>$Goodsmodel]);
    }

    /**
     * @return string
     * 添加页面渲染
     */
    public function actionAdd(){
        $Goodsmodel=new GoodsCategory();
        $Goods=GoodsCategory::find()
            ->select(['id','pid','name'])
       ->orderBy('left_key asc')->asArray()->all();


        return $this->render('add',['model'=>$Goodsmodel, 'goods'=>json_encode($Goods) ]);
    }

    /**
     * 添加分类
     */
    public function actionCreate(){

       $date=Yii::$app->request->post();
        $Goodsmodel=new GoodsCategory();
        $Goodsmodel->load($date);
        $parentobj=GoodsCategory::findOne($date['GoodsCategory']['pid']);
        $result=$Goodsmodel->appendTo($parentobj);
        if ($result===false) {
            var_dump($Goodsmodel->getErrors());
            exit();
        }

        echo "数据提交成功";
    }

}