<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/30
 * Time: 22:07
 */

namespace backend\controllers;
use backend\models\Goods;
use backend\models\GoodsDetail;
use backend\models\GoodsImages;
use yii;

use backend\models\Brand;
use backend\models\GoodsCategory;

class GoodsController extends BaseController
{
    public function actionUpdate(){
        $date=Yii::$app->request->post();
//        var_dump($date["Goods"]["category_id"]);exit();
       $Goodsdate= Goods::findOne($date['Goods']['id']);
        $Goodsdate->load($date);
        if ($Goodsdate->save()===false) {
            var_dump($Goodsdate->getErrors());
            exit();
        }
         $GoodsDetail=GoodsDetail::findOne(['goods_id'=>$Goodsdate->id]);
        $GoodsDetail->load($date);
        $GoodsDetail->goods_id=$Goodsdate->id;
        if ($GoodsDetail->save()===false) {
            echo "GoodsDetail修改失败";
            exit();
        }
        if (!empty($date["GoodsImages"]["url"])) {
            $GoodsImages = new GoodsImages();
            $arr = [];
            foreach ($date["GoodsImages"]["url"] as $url) {
                $arr[] = [
                    'goods_id' =>$Goodsdate->id,
                    'url' => $url,
                    'status' => $date["Goods"]["status"],
                    'sort_num' => $date["Goods"]["sort_num"],
                    'create_time' => time()
                ];
            }
            $res = Yii::$app->db->createCommand()->batchInsert('{{%goods_images}}',
                ['goods_id', 'url', 'status', 'sort_num', 'create_time'], $arr)->execute();
            if ($res === false) {
                throw  new yii\db\Exception("保存图片失败");

            }
        }
        echo "成功修改";

    }

    /**
     * @return string
     * 回显
     */

    public function actionEdit(){
         $id=Yii::$app->request->get('id',0);


//        var_dump($goodsdetail);
        $dateGoods=Goods::findOne($id);
        $goodsimages=$dateGoods->goodsimages;
        $goodsdetail=$dateGoods->goodsdetail;

        $Goods=GoodsCategory::find()
            ->select(['id','pid','name'])
            ->orderBy('left_key asc')->asArray()->all();
        $brand=Brand::find()->asArray()->all();
        $date=GoodsCategory::findOne($dateGoods->category_id);
        return $this->render("edit",['goods'=>json_encode($Goods),
            'brand'=>$brand
        ,'goodsdetail'=>$goodsdetail,
            'goodsimages'=>$goodsimages,
            'dateGoods'=>$dateGoods,
            'model'=>$date,
            ]);

    }

    /**
     * 删除
     */
    public function actionDelete(){
        $id=Yii::$app->request->get('id',0);
        if (!Goods::deleteAll(['id'=>$id])) {
            echo "删除商品失败";
            exit();
        }
        if (!GoodsImages::deleteAll(['goods_id'=>$id])) {
            echo "删除商品图片失败";
            exit();
        }
        if (!GoodsDetail::deleteAll(['goods_id'=>$id])) {
            echo "删除商品描述失败";
            exit();
        }

      echo "删除成功";
    }
    public function cationLook(){

    }

    /**
     * @return string
     * 显示列表
     */
    public function actionList(){
        $page=yii::$app->request->get('p');
        $page=isset($page)?$page:1;
        $page=($page-1>=0)?$page-1:0;
        $pagesize=3;

        $keywords=Yii::$app->request->post("keywords","");

        $modelGoods=Goods::find();
        if (!empty($keywords)) {
            $modelGoods->where("`name` like '%{$keywords}%' OR keywords like '%{$keywords}%'");
        }
        $count= $modelGoods->count();
        $goods= $modelGoods->offset($page*$pagesize)->limit($pagesize)->all();
        $congif=[
            'totalCount'=>$count,
            'defaultPageSize'=>$pagesize,
            'pageParam'=>'p',
        ];
        $pageobr=new yii\data\Pagination($congif);
        $tatol=[
            'count'=>$count,
            'page'=>$page,
            'pagesize'=>$pagesize,

        ];

        return $this->render("list",['modelGoods'=>$goods,'pageobj'=>$pageobr,'count'=>$tatol]);
    }

    public function actionCreate(){
      $date=Yii::$app->request->post();
        $Goodsmodel=new Goods();
        $res=$Goodsmodel->
        creategoods($date);
        if ($res) {
            echo "成功";
        }
    }
     public function actionAdd(){
         $Goods=GoodsCategory::find()
             ->select(['id','pid','name'])
             ->orderBy('left_key asc')->asArray()->all();
          $brand=Brand::find()->asArray()->all();
       return $this->render("add",['goods'=>json_encode($Goods),'brand'=>$brand]);
     }


}