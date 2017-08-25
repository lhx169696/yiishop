<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/10
 * Time: 21:02
 */

namespace frontend\controllers;

include_once '../../common/vendors/wxpay/lib/WxPay.Api.php';
include_once '../../common/vendors/phpqrcode/phpqrcode.php';
include_once '../../common/vendors/sphinx/sphinxapi.php';
use yii\web\Controller;
class TestController extends Controller
{
//    WxPayUnifiedOrder
    public function actionTest()
    {
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("腾讯充值中心-QQ会员充值");
        $input->SetAttach("深圳分店");
        $input->SetOut_trade_no(\Yii::$app->security->generateRandomString(20));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://lhx.azxs.net/checkout/notifytwo");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");
        $result = $this->GetPayUrl($input);
        $url2 = $result["code_url"];

        $filename = \Yii::$app->security->generateRandomString(10);
        \QRcode::png($url2, $filename . '.png');
        echo Url::base(true) . "/" . $filename . '.png';

    }

    private function GetPayUrl($input)
    {
        if ($input->GetTrade_type() == "NATIVE") {
            $result = \WxPayApi::unifiedOrder($input);
            return $result;
        }
    }
/**
 * 商品搜索用例
 */
  public function actionSphinx(){
         $SphinxObj=new \SphinxClient();
         $SphinxObj->SetServer("127.0.0.1",9312);
          $res=$SphinxObj->Query("华");
      if (!empty($res ["matches"])) {
            $arrId=implode(",",array_keys($res ["matches"]));
      }
          echo "<pre>";
          var_dump($res);exit();
  }



}