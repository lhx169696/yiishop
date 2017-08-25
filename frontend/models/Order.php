<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/9
 * Time: 22:27
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class Order extends ActiveRecord
{

     public function getSub(){
         return $this->hasMany(SubOrder::className(),['order_id'=>'id']);
     }

}