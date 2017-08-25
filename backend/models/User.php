<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/2
 * Time: 22:51
 */

namespace backend\models;



use yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $repassword;



  public function rules()
  {
      return [
          [['username', 'repassword', 'password_hash','status'],'required'],
          ['password_hash' ,'compare','compareAttribute'=>'repassword'],
          ['email','email']

      ];
  }

    public static function findIdentity($id)
    {
            return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
           return  $this->id;
    }

    public function getAuthKey()
    {
            return   $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return  $authKey===$this->getAuthKey();
    }

      public function login(){
        $username=$this->username;

          $password=$this->password_hash;

      $userinfo=static::findOne(['username'=>$username,'status'=>1]);

          if (empty($userinfo)) {

              throw new Exception('用户不存在');
          }
//          var_dump(Yii::$app->security->validatePassword($password,$userinfo->password_hash));exit();
          if (!Yii::$app->security->validatePassword($password,$userinfo->password_hash)) {
              throw new Exception('密码错误');
          }
          return $userinfo;

      }

    public function getAuthassignment(){
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

}