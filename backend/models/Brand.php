<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 11:27
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Brand extends ActiveRecord
{
public function rules()
{
    return[
        [['name','introduce','sort_num','status'],'required']
    ]; // TODO: Change the autogenerated stub
}


}