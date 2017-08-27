<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 22:24
 */

namespace frontend\controllers;
use frontend\models\Cart;
use frontend\models\Member;
use frontend\models\SmsLog;
use gmars\sms\Sms;
use yii\captcha\CaptchaAction;
use yii\captcha\CaptchaValidator;
use yii\db\Exception;
use yii\helpers\Url;
use yii\swiftmailer\Mailer;


class UserController extends SmsController
{
    public function actionList(){
           echo "5555";
    }
    /**
     * @return array
     * 验证码
     */
    public function actions()
    {
        return [
            'code'=>
                ['class'=>CaptchaAction::className(),
                'maxLength'=>4,
                'minLength'=>4,
            ]
        ]
            ; // TODO: Change the autogenerated stub
    }
    /**
     * 注册验证邮箱是否是被注册了
     */
    public function actionMemberemail(){
        $useremail=\Yii::$app->request->post('email');
        $preg='/\w+([-.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        if (!preg_match($preg,$useremail)) {
            echo  json_encode(['status'=>0,'hint'=>'邮箱格式不正确']);
            exit();
        }
        $Memberinfo=Member::find()->where(['email'=>$useremail])->exists();

        if ($Memberinfo){
            echo  json_encode(['status'=>2,'hint'=>'该邮箱已被注册']);
            exit();
        }
        echo  json_encode(['status'=>1,'hint'=>'该邮箱可以注册']);
        exit();
    }



    /**
     * 注册验证用户名是否存在
     */
    public function actionMemberone(){
        $username=\Yii::$app->request->post('username');
//        $preg='/^[a-zA-Z\x{4e00}-\x{9fa5}]{6,20}$/u';
//        if (!preg_match($preg,$username)) {
//            echo  json_encode(['status'=>0,'hint'=>'需要3-20位字符，可由中文、字母、数字和下划线组成']);
//            exit();
//        }
            $Memberinfo=Member::find()->where(['username'=>$username])->exists();

        if ($Memberinfo){
            echo  json_encode(['status'=>2,'hint'=>'用户名已注册，亲尝试请他昵称']);
            exit();
        }
            echo  json_encode(['status'=>1,'hint'=>'该用户名可以注册']);
            exit();
    }

    /**
     * 渲染登陆界面
     */
    public function actionLogin(){

        return $this->render("login");

    }

    /**
     * 登陆
     */
    public function actionLoginto(){

        $date = \Yii::$app->request->post();
        $codeObj = new CaptchaValidator();
        $codeObj->captchaAction = 'user/code';
        if ($codeObj->validate($date['code']) === false) {
            echo "图形验证不正确";
            exit();
        }
        $MemberModel = new Member();
        $MemberModel->load($date);
        $MemberModel->validate(['username','password_hash']);
        if ($MemberModel->hasErrors()) {
            var_dump($MemberModel->getErrors());
            exit();
        }

        try {
            $userInfo=$MemberModel->enter();
            if (\Yii::$app->user->login($userInfo)===false) {
                echo "登陆失败";
                exit();
            }
           //登陆成功将cookie  写入数据库
            $session=\Yii::$app->session;
            $session->set('username',$userInfo->username);
           $Cart=new Cart();
            $Cart->CookietoMysql();
            header("Refresh:3;".Url::to(['home/index']));
            echo "登陆成功,3秒后跳转到购物页面";
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }


    }




    /**
     * @return string
     * 渲染注册页面
     */
    public function actionRegist(){

         return $this->render("regist");
     }

    /**
     * ajax  发送短息
     */
     public function actionCaptchatel(){
         $date = \Yii::$app->request->post();
         //    使用正则表式进行验证
         $rule = '/^1[356789]\d{9}$/';
         if (!preg_match($rule, $date['tel'])) {
             echo json_encode(['status' => 0, 'magess' => '手机号格式不正确']);
             exit();
         }
         //查询sms_log表中的数据  防刷防轰炸
         $log = SmsLog::find()->where(['mobile' => $date['tel']])->orderBy('id desc')->one();
         if (!empty($log) && time() < 120 + $log->create_time) {
             echo json_encode(['status' => 0, 'magess' => '两次发送时间不能小于1分钟']);
             exit();
         }
      //生成验证码
             $code=rand(100000,900000);
     //将验证码写入session
         $session=\Yii::$app->session;
         $session->set('reg'.$date['tel'],$code);
         //发送验证码
         $res=$this->Sms($code, $date['tel']);
         //写入日志
         $ModelSmslog=new SmsLog();
         $ModelSmslog->mobile=$date['tel'];
         $ModelSmslog->service="regist";
         $ModelSmslog->create_time=time();
         $ModelSmslog->ip=\Yii::$app->request->getUserIP();

         $ModelSmslog->content= serialize([
                 'code' => $code,
                 'time' => '2'
             ]);

         if ($res == false) {
             $ModelSmslog->status = 0;
             $ModelSmslog->save();
             echo json_encode(['status' => 0, 'magess' => $ModelSmslog->errors]);
             exit();
         }
         $ModelSmslog->save();
         $ModelSmslog->status = 1;
         echo json_encode(['status' => 1, 'magess' => "短信发送成功"]);
         exit();

     }

    /**
     * 用户注册
     */
     public function actionCreate(){
         $date=\Yii::$app->request->post();

         //验证图像验证码
             $capthaObj= new CaptchaValidator();
             //更改验证码控制器与方法
         $capthaObj->captchaAction='user/code';
         if ($capthaObj->validate($date['code'])===false) {
             echo "图形验证错误";
             exit();
         }
         //验证手机验证码
         $capthaMobile=\Yii::$app->session->get('reg'.$date['Member']['mobile']);

         if ($capthaMobile!=$date['captcha']) {
             echo "验证码输入错误";
             exit();
         }
         //手机验证码通过删除session
           \Yii::$app->session->remove('reg'.$date['Member']['mobile']);
         //实例化
                     $Moember=new Member();
                  $Moember->load($date);
                  $Moember->validate();
         if ($Moember->hasErrors()) {
                 var_dump($Moember->getErrors());
                 exit();
         }

         try{
             $cativetoken=\Yii::$app->security->generateRandomString(64);
             $Moember->active_token=$cativetoken;
             $Moember->active_time=time()+2*24*3600;
             $Moember->add();

                    $content='<p>用户注册<a href="http://www.code268.top/user/active?token='.$cativetoken.'">点击激活</a></p>';
             $this->Email($date['Member']['email'],'会员注册',$content);
                  echo "注册成功";
                  exit();
         }catch ( Exception $e){
               var_dump($e->getMessage());
               exit();
         }


     }


    /**
     * 短信发送
     */



     public function actionTest(){
        $SmsObj=new Sms('ALIDAYU',['appkey'=>'23739507','secretkey'=>'afd37bc3f63f4ce8501d390672836c6d']);
         $res=$SmsObj->send([
             'mobile' => '18382140752',
             'signname' => 'NoStop团队',
             'templatecode' => 'SMS_34015093',
             'data' => [
                 'code' => '150236',
                 'time' => '2',
             ],
         ]);
         var_dump($res);
     }

    /**
     * 邮件发送
     */
     public function Email($email,$title,$content){
                 $mail= \Yii::$app->mailer->compose();
               $res=$mail->setFrom('linhongxin23@126.com')
                   ->setTo($email)
             ->setSubject($title)
             ->setHtmlBody($content)
             ->send();

     }

 public function actionActive(){
         $token=\Yii::$app->request->get('token',"");

     if (empty($token)) {
         echo "参数错误";
         exit();
     }
        $Memderinfo= Member::find()->where(['active_token'=>$token])->one();
     if (empty($Memderinfo)) {
          echo "没有数据";
            exit();
     }
     if (time() > $Memderinfo->active_time) {
         echo "你的邮箱地址已经过期了，请重新注册";
         exit();
     }
     $Memderinfo->status=1;
     if ($Memderinfo->save()==false) {
             var_dump($Memderinfo->getErrors());
             exit();
     }
     header("Refresh:3;".Url::to(['user/login']));
     echo "邮箱验证成功,3秒后跳转到登陆页面.....<a href=".Url::to(['home/index']).">去逛逛看看有没有妹儿</a>";
     exit();

 }
/**
 * 找回密码
 */
  public function actionFindpwd(){

     return $this->render("findpwd");

  }
/**
 * 验证手机号是否存在
 */
     public function actionFindtel(){
       $date=\Yii::$app->request->post();
            $Captcha=new CaptchaValidator();
         $Captcha->captchaAction='user/code';
         if ($Captcha->validate($date['code']) === false) {
             echo "图形验证不正确";
             exit();
         }
         $Memberinfo= Member::find()->where(['mobile'=>$date['tel']])->one();

          if(empty($Memberinfo)){
                  echo "缺少可用的验证方式！" ;
                  exit();
          }
          return $this->render("findtel",['Memberinfo'=>$Memberinfo]);
     }
/**
 * 验证短信
 */
     public function actionYz(){
         $date=\Yii::$app->request->post();
     $capthaMobile=\Yii::$app->session->get('reg'.$date['mobile']);
         if ($capthaMobile!=$date['captcha']) {
             echo "验证码输入错误";
             exit();
         }
         \Yii::$app->session->remove('reg'.$date['mobile']);
         $Memberinfo= Member::find()->where(['mobile'=>$date['mobile']])->one();
         return $this->render("zhmima",['Memberinfo'=>$Memberinfo]);
     }

    /**
     * 更改密码
     */
  public function actionUpdate(){

         $date=\Yii::$app->request->post();
      if (empty($date)) {
          echo "缺少可用的验证方式！" ;
          exit();
      }

      $MemberInfo= Member::find()->where(['mobile'=>$date['mobile']])->one();
      if ($MemberInfo->load($date)==false) {
          var_dump($MemberInfo->getErrors());
          echo "修改用户失败";
          exit();
      }
      $MemberInfo->password_hash=\Yii::$app->security->generatePasswordHash($MemberInfo->password_hash);
      if ($MemberInfo->save(false)==false) {
          echo "更改密码失败";
          exit();
      }
      header("Refresh:3;".Url::to(['user/login']));
      echo "更改密码成功,3秒后跳转到登陆页面.....<a href=".Url::to(['home/index']).">去逛逛看看有没有妹儿</a>";
      exit();
  }

    /**
     * 退出登陆
     */
 public function actionLoginout(){
      \Yii::$app->user->logout();
        \Yii::$app->session->remove('username');
     header("Refresh:2;".Url::to(['home/index']));
     echo "退出成功";
     exit();
 }
}
