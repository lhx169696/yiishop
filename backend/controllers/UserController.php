<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 1:56
 */

namespace backend\controllers;

use backend\models\AuthAssignment;
use backend\models\AuthItemChild;
use backend\models\User;
use Yii;
use backend\models\AuthItem;
use yii\captcha\CaptchaValidator;
use yii\db\Exception;
use yii\helpers\Url;

class UserController extends BaseController
{
    /**
     * 修改用户
     */
    public  function actionUpdate(){
           $date=Yii::$app->request->post();
              $user=User::findOne($date['id']);

        if (!$user->load($date)) {
            var_dump($user->getErrors());
            echo "修改用户失败";
            exit();
        }
        $user->password_hash=Yii::$app->security->generatePasswordHash($user->password_hash);

        if ($user->save(false)===false) {
            echo "修改用户失败";
        }
        AuthAssignment::deleteAll(['user_id'=>$user->id]);

        if (!empty($date['role'])) {
            foreach ($date['role'] as $v){

                $auth=Yii::$app->authManager;
                $roleobj=$auth->getRole($v);

                if ($auth->assign($roleobj,$user->id)===false) {
                    echo '给用户添修改角色失败';
                }
            }
        }

          echo "成功";

    }

    /**
     * 删除用户
     */
    public function actionDelete(){
        $id=Yii::$app->request->get('id',"");
        if (User::deleteAll(['id'=>$id]) && AuthAssignment::deleteAll(['user_id'=>$id])) {
            echo "删除成功";
        }

    }

    /**
     * @return string
     * 显示
     */
    public function actionList(){
            $user=new User();
         $user=User::find()->all();
            $res=AuthAssignment::find()->all();
        return $this->render("list",['model'=>$user,'res'=>$res]);


    }

    /**
     * @return string
     * 回显页面
     */
    public function actionEdit(){
        $id=Yii::$app->request->get('id');
          $user= User::findOne($id);
        $role=AuthItem::find()->where(['type'=>1])->all();
              $AuthAssignment= AuthAssignment::find()->where(['user_id'=>$user->id])->all();

      return  $this->render('edit',['role'=>$role,'user'=>$user,'AuthAssignment'=>$AuthAssignment]);
    }

    /**
     * @return \yii\web\Response
     * 退出登陆
     */


    public function actionLoginout(){
        if (Yii::$app->user->logout()) {
            return $this->redirect(Url::to(['user/login']));
        }

    }

    /**
     * @return string
     * 登陆页面
     */
    public function actionLogin(){
       return $this->render('login');
    }

    /**
     * 登陆中
     */
    public function actionLogintodo(){
       $date=Yii::$app->request->post();

       $Captcha=new CaptchaValidator();
   $Captcha->captchaAction = 'user/captha';
        if ($Captcha->validate($date["captcha"])===false) {
                   echo "验证码错误";
                   exit();
        }


        try{
            $user=new User();
            if ($user->load($date)==false) {
                var_dump($user->getErrors()) ;
                echo "绑定数据失败";
                exit();
            }
            if ($userinfo= $user->login()) {
                Yii::$app->user->login($userinfo);
                return $this->redirect(Url::to(['home/index']));
            }

        }catch (Exception $e){
            var_dump($e->getMessage());
        }

    }

    /**
     * 添加用户
     */
    public function actionCreate(){
         $date=Yii::$app->request->post();
        //添加用户

         $user=new User();
        $user->load($date);

        if (!$user->load($date) || !$user->validate()) {
            var_dump($user->getErrors());
            echo "添加用户失败";
            exit();
        }

        $user->password_hash=Yii::$app->security->generatePasswordHash($user->password_hash);

        if ($user->save(false)===false) {
            echo "添加用户失败";
        }

         //给用户分配角色

        if (!empty($date['role'])) {
                  foreach ($date['role'] as $v){
                      $auth=Yii::$app->authManager;
                       $roleobj=$auth->getRole($v);
                      if ($auth->assign($roleobj,$user->id)===false) {
                           echo '给用户添加角色失败';
                      }
                  }
        }
          echo "成功";
    }

    /**
     * @return string
     * 添加用户页面
     */
  public function actionAdd(){
      $role=AuthItem::find()->where(['type'=>1])->all();
      return $this->render("add",['role'=>$role]);

  }

  public function actionNot(){

      return $this->render("not");
  }



}