<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8
 * Time: 17:48
 */

namespace frontend\controllers;
include 'statics/plugins/sms/api_sdk/aliyun-php-sdk-core/Config.php';
include_once 'statics/plugins/sms/api_sdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once 'statics/plugins/sms/api_sdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';
use Dysmsapi\Request\V20170525\SendSmsRequest;
use yii\web\Controller;

class SmsController extends Controller
{


    /**
     * sdk短信发送
     */
    public function Sms($code,$tel){
        //此处需要替换成自己的AK信息
        $accessKeyId = "LTAIYs1Xty2gvNNE";
        $accessKeySecret = "jXyUey9sA5ywX4dViWIzAHdoL1hLl0";
        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = "cn-hangzhou";

        //初始化访问的acsCleint        DefaultProfile DefaultAcsClient
        $profile = \DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        \DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient= new \DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        //必填-短信接收号码
        $request->setPhoneNumbers("$tel");
        //必填-短信签名
        $request->setSignName("top团队");
        //必填-短信模板Code
        $request->setTemplateCode("SMS_76350066");
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        $request->setTemplateParam("{\"code\":\"$code\",\"time\":\"2\"}");
        //选填-发送短信流水号
        $request->setOutId("1234");

        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);
         return  $acsResponse["Message"]=="OK"?true:false;

}

}