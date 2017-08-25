<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 11:29
 */

namespace backend\controllers;

use yii;
use backend\models\Brand;

class BrandController  extends BaseController
{
    /**
     * 删除
     */
    public function actionDelete(){
        $id= Yii::$app->request->get('id');
        $dateid=Brand::findOne($id);
         if(Brand::deleteAll(['id' => $id])){

             echo "删除成功";
         }
    }

    /**
     * @return string
     * 回显
     */
    public function actionEdit(){

        $id= Yii::$app->request->get('id');
         $date=Brand::findOne(['id'=>$id]);
         return $this->render("edit",['model'=>$date]);
    }

    /**
     * 修改数据
     */
  public function actionUpdate(){
           $id=Yii::$app->request->get('id');
        $dateid=Brand::findOne(intval($id));
        $date=Yii::$app->request->post();

        
      $dateid->logo=$date['Brand']['logo'];
      $dateid->load($date);
      if ($dateid->save()==false) {
          echo '修改品牌失败';
          exit();
      }
      echo '修改品牌成功';
      exit();
  }
    /**
     * 查看品牌
     */
   public function actionLook(){
//       $model=new Brand();
       $id=Yii::$app->request->get('id');
          $date=Brand::findOne($id);

        return  $this->render("look",['rows'=>$date]);
   }

    /**
     * @return string
     * 品牌列表
     */
   public function actionList(){
       $page=yii::$app->request->get('p');
       $page=isset($page)?$page:1;
       $page=($page-1>=0)?$page-1:0;
       $pagesize=5;

        $keyword= Yii::$app->request->get('keyword',"");
       $brandbase= Brand::find();
       if (!empty($keyword)) {

           $brandbase->where("`name` like '%{$keyword}%' OR introduce like '%{$keyword}%'");
       }
      $count= $brandbase->count();
      $brandlist= $brandbase->offset($page*$pagesize)->limit($pagesize)->all();
       $congif=[
           'totalCount'=>$count,
           'defaultPageSize'=>$pagesize,
           'pageParam'=>'p',
       ];
       $pageobr=new yii\data\Pagination($congif);
         $tatol=[
             'count'=>$count,
             'page'=>$page,
             'pagesize'=>$pagesize,

         ];

    return   $this->render("list",['brandbase'=>$brandlist,'pageobj'=>$pageobr,'count'=>$tatol]);

   }
    /**
     * @return string
     * 添加品牌是界面
     */
    public function actionAdd(){
    $model=new Brand();
      return $this->render("add",['model'=>$model]);

    }

    /**
     * 添加品牌
     */
    public function actionCreate(){
         $BrandBase =new Brand();
         $date=Yii::$app->request->post();
//           $image= yii\web\UploadedFile::getInstance($BrandBase,'logo');
//         $path="./statics/upload/".Yii::$app->security->generateRandomString(20).".".$image->extension;
//        if ($image->saveAs($path)==false) {
//             echo '上传图片出错';
//        }
        if(!$BrandBase->load($date) || !$BrandBase->validate()){
              var_dump($BrandBase->getErrors());
              exit();
        }

          $BrandBase->logo=$date['Brand']['logo'];
          $BrandBase->create_time=time();
        if ($BrandBase->save($date)) {
              echo '添加品牌成功';
              exit();
        }
    }
}