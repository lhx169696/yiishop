<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/2
 * Time: 22:52
 */

namespace backend\controllers;


use backend\models\AuthItemChild;
use yii;


use backend\models\AuthItem;


class RoleController extends BaseController
{
    /**
     *
     */
    public function actionUpdeta(){
        $date=Yii::$app->request->post();
        $auth=Yii::$app->authManager;
        $createRole=$auth->createRole($date['nameto']);
        $auth->removeChildren($createRole);
//       var_dump()   ;
//          exit();

        $createRole=$auth->createRole($date['nameto']);
        $createRole->name=$date['name'];
        $createRole->description=$date['description'];
        if ($auth->update($date,$createRole)===false) {
            echo "修改角色失败";
            exit();
        }
//        添加角色的权限到auth——itme——child表
        if (!empty($date['permission'])) {
            foreach ($date['permission'] as $v){
                $permissionobj=$auth->getPermission($v);
                if ($auth->addChild($createRole,$permissionobj)===false) {
                    echo "修改分配权限出错";
                    exit();
                }
            }
        }

       echo "修改成功";
    }
    public function actionEdit(){
        $dateName=Yii::$app->request->get("name");
        $dateone= AuthItem::find()->where(['type'=>1,'name'=>$dateName])->one();
          $chlie=AuthItemChild::find()->where(['parent'=>"$dateone->name"])->all();
        $date= AuthItem::find()->where(['type'=>2])->all();

        return   $this->render("edit",['model'=>$date,'modelone'=>$dateone,'chlie'=>$chlie]);
    }

    public function actionDelete(){
        $dateName=Yii::$app->request->get("name");
        if (AuthItem::deleteAll(['name'=>$dateName])) {
            echo "删除成功";
        }
    }
   public function actionAdd(){
      $date= AuthItem::find()->where(['type'=>2])->all();
     return   $this->render("add",['model'=>$date]);
   }
  public function actionCreate(){
       $date=Yii::$app->request->post();
       //添加authitem表
     $auth=Yii::$app->authManager;
      $createRole=$auth->createRole($date['name']);
      $createRole->description=$date['description'];
      if ($auth->add($createRole)===false) {
            echo "添加角色失败";
            exit();
      }
      //添加角色的权限到auth——itme——child表
      if (!empty($date['permission'])) {
          foreach ($date['permission'] as $v){
              $permissionobj=$auth->getPermission($v);
              if ($auth->addChild($createRole,$permissionobj)===false) {
                   echo "分配权限出错";
                   exit();
              }
          }
      }
      echo  "成功";
  }


  public function actionList(){
      $date=AuthItem::find()->where(['type'=>1])->all();
      return  $this->render("list",['permission'=>$date]);
  }


}