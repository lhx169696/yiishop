<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/16
 * Time: 20:53
 */

namespace frontend\controllers;


use backend\models\Goods;
use yii\web\Controller;

class CrontController extends Controller
{
  public function actionTomysql(){
      //取出redis里面的值
        $redisObj=\Yii::$app->redis;
      $redsiValues=$redisObj->get('goods_visits');
       $valueArr=empty($redsiValues)?[]:unserialize($redsiValues);
      if (empty($valueArr)) {
          return true;
      }
      //写入数据库
       foreach ($valueArr as $k=>$v){
            $Goods= Goods::findOne($k);
            $Goods->visites=$Goods->visites+$v;
            if ($Goods->save()!==false){
                    unset($valueArr[$k]);
            }
            sleep(2);
       }
       //删除商品浏览数据
      $redisObj->del('goods_visits');

      if (empty($valueArr)) {
          return true;
      }

      $redisObj->set("goods_visits",serialize($valueArr));

  }


}