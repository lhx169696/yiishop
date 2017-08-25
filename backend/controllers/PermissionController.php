<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/2
 * Time: 22:53
 */

namespace backend\controllers;

use backend\models\AuthItem;
use yii;
class PermissionController extends BaseController
{
    public function actionDelete(){
        $dateName=Yii::$app->request->get("name");
        if (AuthItem::deleteAll(['name'=>$dateName])) {
            echo "删除成功";
        }
    }
    public function actionAdd(){

       return $this->render("add");
    }
    public function actionCreate(){
        $date=Yii::$app->request->post();
          $auth=Yii::$app->authManager;
        $createPost=$auth->createPermission($date['name']);
        $createPost->description=$date['description'];
        if ($auth->add($createPost)) {
            echo "添加权限成功";
        }
    }

    public function actionList(){
        $page=yii::$app->request->get('p');
        $page=isset($page)?$page:1;
        $page=($page-1>=0)?$page-1:0;
        $pagesize=7;
        $date=AuthItem::find()->where(['type'=>2]);
        $count= $date->count();
        $brandlist= $date->offset($page*$pagesize)->limit($pagesize)->all();
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
        return   $this->render("list",['permission'=>$brandlist,'pageobj'=>$pageobr,'count'=>$tatol]);
    }
    public function actionEdit(){
          $dateName=Yii::$app->request->get("name");

        $date=AuthItem::find()->where(['name'=>$dateName])->one();

        return  $this->render("edit",['permission'=>$date]);
    }

    /**
     *没有做修改
     */
    public function actionUpdete(){
        $date=Yii::$app->request->post();

        $auth=Yii::$app->authManager;
        $createPost=$auth->createPermission($date['toname']);
        $createPost->name=$date['name'];
        $createPost->description=$date['description'];
        if ($auth->update($date,$createPost)) {
            echo "修改权限成功";
        }

    }


}