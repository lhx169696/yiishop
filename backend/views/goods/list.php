<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .pagination ul{
            position: absolute;
            right: 20px;
        }

        .pagination li{
            display: inline;
            float: left;


        }
    </style>
</head>
<body>
<h1>
    <span class="action-span"><a href="__GROUP__/Goods/goodsAdd">添加新商品</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?=\yii\helpers\Url::to(['goods/list'])?>" name="searchForm" method="post">
        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken?>"/>
        <img src="/statics/images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        关键字 <input type="text" name="keywords" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>货号</th>
                <th>价格</th>
                <th>上架</th>
                <th>精品</th>
                <th>新品</th>
                <th>热销</th>
                <th>推荐排序</th>
                <th>库存</th>
                <th>操作</th>
            </tr>
            <foreach name="list" item="val">
                <<?php foreach ($modelGoods as $row):?>
            <tr>
                <td align="center"><?= $row->id?></td>
                <td align="center" class="first-cell"><span><?= $row->name?></span></td>
                <td align="center"><span onclick=""><?= $row->goods_on?></span></td>
                <td align="center"><span><?= $row->price?></span></td>
                <td align="center"><img src="/statics/images/<?= $row->status ? 'yes':'no'?>.gif"/></td>
                <td align="center"><img src="/statics/images/<?= $row->is_bast ? 'yes':'no'?>.gif"/></td>

                <td align="center"><img src="/statics/images/<?= $row->is_new ? 'yes':'no'?>.gif"/></td>

                <td align="center"><img src="/statics/images/<?= $row->is_hot ? 'yes':'no'?>.gif"/></td>
                <td align="center"><span><?= $row->sort_num?></span></td>
                <td align="center"><span><?= $row->goods_num?></span></td>
                <td align="center">

                <a href="<?=\yii\helpers\Url::to(['goods/edit','id'=>$row->id])?>" title="编辑"><img src="/statics/images/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="<?=\yii\helpers\Url::to(['goods/delete','id'=>$row->id])?>" onclick="" title="回收站"><img src="/statics/images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php endforeach;?>
                <tr>

                    <td align="right" nowrap="true" colspan="12">
           <span id="page-link" style="border: none;  position: relative;left: 750px">

                            <?= \yii\widgets\LinkPager::widget(['pagination'=>$pageobj,
                                'lastPageLabel' => '尾页', 'firstPageLabel' => '首页',
                                'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页',
                                'maxButtonCount' => 7,
                            ])?>

                        </span>
                        <span id="turn-page" style="position: relative; right: 250px">
                        总计 <span id="totalRecords"><?=$count['count']?></span>
                        个记录分为 <span id="totalPages"><?=  ceil( $count['count']/$count['pagesize']); ?></span>
                        页当前第 <span id="pageCurrent"><?=$count['page']==0?1:$count['page'];?></span>
                        页，每页 <input type='text' size='3' id='pageSize' value="<?=$count['pagesize']?>" />
                    </span>

                    </td>

                </tr>
        </table>

    <!-- 分页开始 -->

</form>

<div id="footer">
共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>