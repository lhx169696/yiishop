<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 10:38
 */

namespace backend\controllers;

use backend\filters\Accss;
use backend\models\GoodsImages;
use crazyfd\qiniu\Qiniu;
use function PHPSTORM_META\elementType;
use yii;

use yii\web\Controller;
use yii\web\UploadedFile;

class BaseController extends Controller
{
    /**
     * $ak = 'sss'; GK-XAcnwiJwHLYzv3gURAlwaY7WtReBIfrycxlRr
    $sk = 'sss'; SuC8NFn2F9z3Mi5KoicAatj9TEIlej11v2we2_N5
    $domain = 'http://demo.domain.com/';os7biyvg3.bkt.clouddn.com
    $bucket = 'demo'; shop
     *
     */
    public function actions()
    {
        return [
            'captha'=>[
                'class'=>yii\captcha\CaptchaAction::className(),
                'maxLength'=>4,
                'minLength'=>4
            ]
        ]; // TODO: Change the autogenerated stub
    }
//
    public function behaviors()
    {
        return [[
            'class'=>Accss::className()
        ]
        ]; // TODO: Change the autogenerated stub
    }

    public  function actionUpload(){
//        $fileimg=$_FILES['logofile'];
        $fileimg= array_shift($_FILES) ;
        if (empty($fileimg)) {
            echo json_encode(['status'=>0,'message'=>"文件为空"]);
            exit();
        }
        $config=Yii::$app->params['qiniu'];
        $QiniuObj=new Qiniu($config['accessKey'],$config['secretKey'],$config['domain'],$config['bucket']);

       $key= Yii::$app->security->generateRandomString(20);
  try{
      $QiniuObj->uploadFile($fileimg["tmp_name"],$key);
  }catch (\HttpException $e){
      echo json_encode(['status'=>0,'message'=>$e->getMessage()]);
      exit();
  }

       $url= $QiniuObj->getLink($key);


        echo json_encode(['status'=>1,'message'=>"图片上传成功",'url'=>'http://'.$url]);

    }
    public  function actionWebuploader(){

         $files= array_shift($_FILES) ;


        if (empty($files)) {
            echo json_encode(['status'=>0,'message'=>"文件为空"]);
            exit();
        }
        $config=Yii::$app->params['qiniu'];
        $QiniuObj=new Qiniu($config['accessKey'],$config['secretKey'],$config['domain'],$config['bucket']);

        $key= Yii::$app->security->generateRandomString(20);
        try{
            $QiniuObj->uploadFile($fileimg["tmp_name"],$key);
        }catch (\HttpException $e){
            echo json_encode(['status'=>0,'message'=>$e->getMessage()]);
            exit();
        }

        $url= $QiniuObj->getLink($key);
        echo json_encode(['status'=>1,'message'=>"图片上传成功",'url'=>'http://'.$url]);

    }

    public function actionDeleteimg(){
        $src=Yii::$app->request->get('src');
        if (GoodsImages::deleteAll(['url'=>$src])) {
          echo  json_encode(['status'=>1,'masges'=>'删除成功']);
        }else{
          echo  json_encode(['status'=>2,'masges'=>'失败']);
        }


    }



}