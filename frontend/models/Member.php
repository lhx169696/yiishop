<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 22:31
 */

namespace frontend\models;


use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\IdentityInterface;

class Member extends ActiveRecord implements IdentityInterface
{
public $repassword;
    public function rules()
    {
        return [
            [['username','password_hash','mobile'],'required'],
           [['active_token','active_time','repassword'],'safe'],
            ['email','email'],
            ['repassword','compare','compareAttribute'=>'password_hash']

        ]; // TODO: Change the autogenerated stub
    }

    public static function findIdentity($id)
    {
          return static::findOne($id);
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
       return $this->id;
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        return  $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
       return $authKey===$this->getAuthKey();
    }

    /**
     * @return bool
     * @throws Exception
     * 用户注册
     */
    public function add(){
       $this->password_hash=\Yii::$app->security->generatePasswordHash($this->password_hash);
        $this->created_at=time();
        $this->status=3;

        if ($this->save(false)==false) {
               throw new Exception('注册失败亲稍后尝试');
        }
        return true;
    }
  /**
   * 登陆
   */
  public function enter(){
      $password_hash=$this->password_hash;
      $username=$this->username;
        $MemberInfo=static::find()->where(['username'=>$username,'status'=>1])->one();
      if ($MemberInfo==false) {
          throw new Exception("该用户不存在或没有激活");
      }
      if (\Yii::$app->security->validatePassword($password_hash,$MemberInfo->password_hash)==false) {
          throw new Exception("密码不正确");
      }
      return $MemberInfo;
  }

/**
 * 更改密码
 */



}