<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/9
 * Time: 11:56
 */

namespace frontend\models;

use backend\models\Goods;
use Yii;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{

    public function CookietoMysql(){
       $CartCookie=Yii::$app->request->cookies->getValue("frontend_value");
        $cart = unserialize($CartCookie);
        if (empty($cart)) {
              return true;
        }
        //查询该用户数据库中是否有待支付数据
           $CartDate=Cart::find()->where(['user_id'=>Yii::$app->user->identity->getId(),'status'=>2])
               ->select(['goods_id','goods_num','id'])
               ->all();
        if (empty($CartDate)) {
            $newCart=[];
               foreach ($cart as $k=>$v){
                   $newCart[]=[
                       'goods_id'=>$k,
                       'goods_num'=>$v,
                       'status'=>2,
                       'user_id'=>Yii::$app->user->identity->getId(),
                       'create_time'=>time()
                   ];
               }
          return  Yii::$app->db->createCommand()->batchInsert('{{%cart}}',['goods_id','goods_num','status','user_id','create_time'],$newCart)->execute();
        }
        //查询该用户数据库中有待支付数据   就数据分离
         foreach ($CartDate as $v){

             if(isset($cart[$v['goods_id']])){
                    $model=static::findOne($v['id']);
                 $model->goods_num += $cart[$v['goods_id']];
                     $model->save();

                     unset($cart[$v['goods_id']]);

             }

         }
                if (!empty($cart)){
                   $addCart=[];
                   foreach ($cart as $k=>$v){
                       $addCart[]=[
                           'goods_id'=>$k,
                           'goods_num'=>$v,
                           'status'=>2,
                           'user_id'=>Yii::$app->user->identity->getId(),
                           'create_time'=>time()
                       ];

                   }

                    return  Yii::$app->db->createCommand()->batchInsert('{{%cart}}',['goods_id','goods_num','status','user_id','create_time'],$addCart)->execute();

                }
        return true;
    }

    public function getGoods(){
         return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }


}