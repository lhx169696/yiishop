<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11
 * Time: 20:34
 */

namespace frontend\controllers;


use frontend\models\Order;
use frontend\models\SmsLog;
use yii\web\Controller;
include_once '../../common/vendors/wxpay/lib/WxPay.Api.php';
class CheckoutController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 支付成功调用
     */
    public function actionNotifytwo()
    {
        $data = $GLOBALS['HTTP_RAW_POST_DATA'];
        $obj = (array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($obj['return_code']!=='SUCCESS') {
            $smsLog = new SmsLog();
            $smsLog->content = 111111;
            $smsLog->save();
        }
        //订单支付成功
        $smsLog = new SmsLog();
        $smsLog->content = serialize($obj);
        $smsLog->status = 1;
        $smsLog->create_time = time();
        $smsLog->save();
        $Orderone=Order::find()->where(['order_no'=>$obj['out_trade_no']])->one();
        $Orderone->status=1;
        $Orderone->save();
        //支付成功响应
        $successReulst = "<xml>
                                  <return_code><![CDATA[SUCCESS]]></return_code>
                                  <return_msg><![CDATA[OK]]></return_msg>
                              </xml>";

        echo $successReulst;


    }

    /**
     * 异步 请求是否支付 以及成功
     */
    public function actionQrorder(){
        $date=\Yii::$app->request->get();
          $input=    new \WxPayUnifiedOrder();
          //传入订单编号
        $input->SetOut_trade_no($date['order_no']);
        $res=\WxPayApi::orderQuery($input);
        if ($res['return_code']=='SUCCESS'){
                          if($res['trade_state']=='SUCCESS'){
                          echo    json_encode(['status'=>1,'message'=>'支付成功']);
                          exit();
                          }

        }


    }




}