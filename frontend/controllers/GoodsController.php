<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 15:18
 */

namespace frontend\controllers;
include_once '../../common/vendors/wxpay/lib/WxPay.Api.php';
include_once '../../common/vendors/wxpay/lib/WxPay.Notify.php';
include_once '../../common/vendors/phpqrcode/phpqrcode.php';
include_once '../../common/vendors/sphinx/sphinxapi.php';
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsImages;
use Codeception\Module\Yii1;
use frontend\models\Cart;
use frontend\models\Order;
use yii;
use yii\web\Controller;

class GoodsController extends Controller
{

    /**
     * 使用sphinx搜索
     */
    public function actionSearch(){
          //获取post传递的值
        $keywords=Yii::$app->request->post('keywords');
        //实例化插件 Sphinx
        $SphinxObj=new \SphinxClient();
        //链接数据kuip   端口配置文件见端口
        $SphinxObj->SetServer("127.0.0.1",9312);
        //传入keywords的值 返回查询到的数据
        $res=$SphinxObj->Query($keywords);
        $arrId=null;
        //$res ["matches"] 判断如果有值
        if (!empty($res ["matches"])) {
            //取出查询到的数据的id
            $arrId=implode(",",array_keys($res ["matches"]));
            // 从数据库 查询
            $Goods=Goods::find()->where("id IN({$arrId})")->all();

            foreach ($Goods as $k=>$v){
                //将关键字上颜色
                $date=$SphinxObj->BuildExcerpts($v->toArray(),'mysql',$keywords,
                    ["before_match"=>"<b style='color: red'>"]);

                $Goods[$k]->name=$date[1];
                $Goods[$k]->keywords=$date[10];
            }
            $GoodsCategory=GoodsCategory::find()->asArray()->all();
            return  $this->render("list",['Goods'=>$Goods,'categorys'=>$GoodsCategory]);
        }else{
            header('location:'.yii\helpers\Url::to(['home/index'],true));

        }

    }




    /**
     * 需要重点研究
     */
    public function actionList(){
         $catid=Yii::$app->request->get('catid',0);
        if ($catid==0) {
            echo "没有该分类";
            exit();
        }

        $Categoryid=$catid;
        $CategoryModel=GoodsCategory::find()->where(['id'=>$catid])->one();
        //判断不是3级分类就查出 id
        if ($CategoryModel->level!==3) {
            $Categoryone= GoodsCategory::find()
                ->where(['pid'=>$catid,'status'=>1])
                ->select('id')
                ->asArray()
                ->all();
            $arrtwo=[];
            if (!empty($Categoryone)) {
              foreach ($Categoryone as $id){
                  $arrtwo[]=$id['id'];
              }
                $caidtwo=implode(",",$arrtwo);
                //拼接  id
                $Categoryid=$caidtwo.','.$catid;
                $Categorythere= GoodsCategory::find()->where("pid IN({$caidtwo})")->select('id')->asArray()->all();
                $arrthere=[];
                if (!empty($Categorythere)) {
                    foreach ($Categorythere as $id){
                        $arrthere[]=$id['id'];
                    }
                    //数组转化string
                    $caidthere=implode(",",$arrthere);
                    $Categoryid=$caidthere.','.$catid;
                }

            }


        }
              $Goods=Goods::find()->where("category_id IN({$Categoryid})")->all();
        $GoodsCategory=GoodsCategory::find()->asArray()->all();
          return  $this->render("list",['Goods'=>$Goods,'categorys'=>$GoodsCategory]);

    }

    /**
     * 商品详情
     */
    public function actionDetail(){
        $id = Yii::$app->request->get("id", 0);
        if (empty($id)) {
            echo "参数错误";
            exit();
        }

        //将商品访问次数  写入redis
                     $redisObj=Yii::$app->redis;
                     $redisData=$redisObj->get("goods_visits");
                   $redisData=empty($redisData)?[]:unserialize($redisData);
        if (isset($redisData[$id])) {
            $redisData[$id]+=1;

        }else{
            $redisData[$id]=1;
        }
        $redisData=serialize($redisData);
        $redisObj->set("goods_visits",$redisData);

            $fileUrl="goodsdetail/goods_".$id.".html";
        //判断文件夹是否存在
        if (file_exists($fileUrl)) {
            //文件创建时间
            if (fileatime($fileUrl)+7200>time()) {
                 include $fileUrl;
                 exit();
            }
        }
        $GoodsOne = Goods::findOne($id);
        return $this->render("detail", ['GoodsOne' => $GoodsOne]);
    }

    /**
     * @return string
     * 购物车
     */
       public function actionAddcart()
       {

           $date = Yii::$app->request->get();
           if(empty($date)){
               echo "参数错误";
                  exit();
           }

           //判断是否  游客
           if (Yii::$app->user->isGuest) {
               $this->cartCookie($date);
               $cookieCart=Yii::$app->request->cookies->getValue("frontend_value");
               $carts=unserialize($cookieCart);
               if (isset($carts[$date['goods_id']])) {
                   $carts[$date['goods_id']]+=$date['goods_num'];
               }else{
                   $carts[$date['goods_id']]=$date['goods_num'];
               }
               $goodsAdrr=array_keys($carts);
               $goods=Goods::findAll($goodsAdrr);
           }else{
              //如果不是游客
              $CartGoods= Cart::find()->where(['goods_id'=>$date['goods_id']
                   ,'user_id'=>Yii::$app->user->identity->getId(),
                   'status'=>2])->one();
              //2 如果数据库中的待支付数据为空直接写入当前数据
               if (empty($CartGoods)) {
                      $CartModel=new Cart();
                      $CartModel->goods_id=$date['goods_id'];
                      $CartModel->goods_num=$date['goods_num'];
                      $CartModel->status=2;
                      $CartModel->create_time=time();
                       $CartModel->user_id=Yii::$app->user->identity->getId();
                   if ($CartModel->save()==false) {
                         echo "加入购物车失败";
                         exit();
                   }
               }else{
                   //2 如果有数据 再次基础上加上
                   $CartGoods->goods_num  += $date["goods_num"];
                   if ($CartGoods->save()==false) {
                       echo "加入购物车失败";
                       exit();
                   }
               }
              //查出所有待支付状态的数据
               $mysqlCart= Cart::find()->where(['user_id'=>Yii::$app->user->identity->getId(),'status'=>2])->asArray()->all();
              //构造和cooke 一样的数据
               $goods = [];
               $carts = [];
               if (!empty($mysqlCart)) {
                  foreach ($mysqlCart as $v){
                      $carts[$v['goods_id']] = $v['goods_num'];
                  }
                   $goods=Goods::findAll(array_keys($carts));
               }

           }
           return $this->render("cart",['goods'=>$goods,'carts'=>$carts]);


       }

    /**
     * @param $date
     * @return bool
     * 访问过的数据加入cookei
     */
       private function cartCookie($date){
            //实例化cookie
        $cookieobj= Yii::$app->request->cookies;
           $cookieCart =$cookieobj->getValue('frontend_value');
           if (empty($cookieCart)) {
               $newCart=[$date['goods_id']=>$date['goods_num']];
               $serDate=serialize($newCart);
               Yii::$app->response->cookies->add(new yii\web\Cookie([
                         'name'=>'frontend_value',
                         'value'=>$serDate
               ]));
               return true;
           }
           //反序列化
           $oldCart=unserialize($cookieCart);
           if (isset($oldCart[$date['goods_id']])) {
               $oldCart[$date['goods_id']]+=$date['goods_num'];
           }else{
               $oldCart[$date['goods_id']]=$date['goods_num'];
           }
           //序列化
           $serDate=serialize($oldCart);
           Yii::$app->response->cookies->add(new yii\web\Cookie([
               'name'=>'frontend_value',
               'value'=>$serDate
           ]));
           return true;
       }

    /**
     * 购物车的异步
     */
        public function actionChangenum(){
               $date=Yii::$app->request->get();
               //根据用户id  和  status  查出购物车
                  $CartDate= Cart::find()->where(['user_id'=>Yii::$app->user->identity->getId(),'status'=>2,'goods_id'=>$date['goods_id']])->one();
            if (empty($CartDate)) {
                return false;
            }
            $CartDate->goods_num=$date['goods_num'];
            if ($CartDate->save()===false) {
                  return false;
            }
            return true;
        }

    /**
     * @return string
     * 提交订单页面
     */
        public function actionOrderinfo(){
                 if (Yii::$app->user->isGuest){
                     header("Refresh:3;".yii\helpers\Url::to(['user/login']));
                     echo "你还有没有登陆,3秒后跳转到登陆页面.....<a href=".yii\helpers\Url::to(['user/login']).">马上去登陆</a>";
                       exit();
                 }
          $Cart=Cart::find()->where(['user_id'=>Yii::$app->user->identity->getId(),'status'=>2])->all();
              return    $this->render("orderinfo",['cart'=>$Cart]);
        }

    public function actionConfirmorder(){
        $Cart=Cart::find()->where(['user_id'=>Yii::$app->user->identity->getId(),'status'=>2])->all();
        if (empty($Cart)) {
            echo "参数错误";
            exit();
        }
              /**
               *   `goods_count` int(11) DEFAULT NULL,
              `goods_cat` int(11) DEFAULT NULL,
              `amount` decimal(10,0) DEFAULT NULL,
              `status` int(1) DEFAULT NULL,
              `create_time` int(11) DEFAULT NULL,
              `order_no` varchar(20) DEFAULT NULL,
               * 向主表中添加信息
               */
              $count=0;
                 $amount=0;
           foreach ($Cart as $v)  {
               $count+=$v->goods_num;
               $amount+=$v->goods_num*$v->goods->price;
           }
        $transObj =Yii::$app->db->beginTransaction();
          $ModelOder= new Order();
      $ModelOder->goods_cat=count($Cart);
        $ModelOder->goods_count=$count;
        $ModelOder->amount=$amount;
        $ModelOder->status=2;
        $ModelOder->create_time=time();
        $ModelOder->order_no=Yii::$app->security->generateRandomString(15);
        if ($ModelOder->save()===false) {
            $transObj->rollBack();
              echo  "生成订单失败";
              exit();
        }
/**
 * `order_id` int(11) DEFAULT NULL,
`goods_id` int(11) DEFAULT NULL,
`goods_num` int(11) DEFAULT NULL,
`goods_name` varchar(255) DEFAULT NULL,
`price` decimal(10,2) DEFAULT NULL,
 * 向附表添加数据
 */
              $SubArr=[];
            foreach ($Cart as $v){
                $SubArr[]=[
                    'order_id'=>$ModelOder->id,
                    'goods_id'=>$v->goods_id,
                    'goods_num'=>$v->goods_num,
                    'goods_name'=>$v->goods->name,
                    'price'=>$v->goods->price
                ];
            }
            $SubOrder=Yii::$app->db->createCommand()->batchInsert('{{%sub_order}}',['order_id','goods_id','goods_num','goods_name','price'],$SubArr)->execute();
        if ($SubOrder==false) {
            $transObj->rollBack();
            echo  "生成订单失败";
            exit();
        }
          $transObj->commit();

           $userid= Yii::$app->user->identity->getId();
             Yii::$app->db->createCommand()->update('{{%cart}}',['status'=>1],"user_id=$userid AND status=2")->execute();
        $wxurl=$this->Wxpayorder($ModelOder->id);
        return $this->render("successorder",['wxurl'=>$wxurl,'order_no'=>$ModelOder->order_no]);
    }


    /**
     * @param $orderid
     * @return string
     * 微信支付url
     */

    public function Wxpayorder($orderid){
            $oderinfo=Order::findOne($orderid);
            $Product=[];
            foreach ($oderinfo->sub as $v){
                $Product[] +=$v ->goods_id;
            }
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($oderinfo->sub[0]->goods_name);
        $input->SetAttach(Yii::$app->params['attach']);
        $input->SetOut_trade_no($oderinfo->order_no);
        $input->SetTotal_fee((int)($oderinfo->amount*100));
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url(Yii::$app->params['notify_url']);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id(implode("_",$Product));
        $result = $this->GetPayUrl($input);
        $url2 = $result["code_url"];

        $filename=\Yii::$app->security->generateRandomString(10);
        \QRcode::png($url2,"qrcode/".$filename.'.png');
         return yii\helpers\Url::base(true)."/qrcode/".$filename.'.png';
    }

    /**
     * @param $input
     * @return \成功时返回
     * url地址返回
     */
    public function GetPayUrl($input)
    {
        if($input->GetTrade_type() == "NATIVE")
        {
            $result = \WxPayApi::unifiedOrder($input);
            return $result;
        }
    }






}