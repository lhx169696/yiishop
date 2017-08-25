<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 23:44
 */

namespace backend\models;



use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;


class GoodsQuery extends ActiveQuery
{
    public function behaviors() {
        return [
             NestedSetsQueryBehavior::className()
        ];
    }
}