<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 10:18
 */

namespace frontend\controllers;


use backend\models\GoodsCategory;
use yii\web\Controller;

class HomeController extends Controller
{
    /**
     * @return string
     * 首页
     */
    public function actionIndex(){
            $Goods=GoodsCategory::find()->asArray()->all();
          return $this->render('index',['categorys'=>$Goods]);
    }


}