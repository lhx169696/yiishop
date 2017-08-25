
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        body{
           ;
        }
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
    <span class="action-span"><a href="<?= \yii\helpers\Url::to(['brand/add'])?>">添加品牌</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 品牌列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?php \yii\helpers\Url::to(['brand/list'])?>" name="searchForm" method="get">

        关键字 <input type="text" name="keyword" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->

    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>品牌名称</th>
                <th>品牌描述</th>
                <th>排序</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>

                <?php  foreach ($brandbase as $rows):?>
            <tr>

                <td width="25%" align="center" >
                    <?= $rows->name?>
                    <span> <img src="<?= $rows->logo?>" width="60"  border="0" style="margin-left:3em" />
                </span></td>
                <td class="first-cell"  width="30%"><?= mb_substr($rows->introduce,0,28) ?>......</td>
                <td width="10%" align="center"><?= $rows->sort_num?></span></td>

                <td width="5%"><img src="/statics/images/<?= $rows->status?'yes':'no'; ?>.gif" /></td>


                <td width="15%" align="center"><?= date("Y-m-d",$rows->create_time)?></span></td>

                <td align="center" width="20%">
                <a href="<?= \yii\helpers\Url::to(['brand/look','id'=>$rows->id])?>" title="查看"><img src="/statics/images/icon_view.gif" width="16" height="16" border="0" /></a>
                <a href="<?= \yii\helpers\Url::to(['brand/edit','id'=>$rows->id])?>" title="编辑"><img src="/statics/images/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="<?= \yii\helpers\Url::to(['brand/delete','id'=>$rows->id])?>" onclick="" title="回收站"><img src="/statics/images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr>
                <?php endforeach;?>
            <tr>

                <td align="right" nowrap="true" colspan="6">
           <span id="page-link" style="border: none; position: relative;left: 750px">

                            <?= \yii\widgets\LinkPager::widget(['pagination'=>$pageobj,
                                'lastPageLabel' => '尾页', 'firstPageLabel' => '首页',
                                'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页',
                                'maxButtonCount' => 7,
                            ])?>

                        </span>
                    <span id="turn-page" style="position: relative; right: 270px">
                        总计 <span id="totalRecords"><?=$count['count']?></span>
                        个记录分为 <span id="totalPages"><?=  ceil( $count['count']/$count['pagesize']); ?></span>
                        页当前第 <span id="pageCurrent"><?=$count['page']==0?1:$count['page'];?></span>
                        页，每页 <input type='text' size='3' id='pageSize' value="<?=$count['pagesize']?>" />


                    </span>

                </td>

            </tr>

        </table>



    </div>



<div id="footer" >
共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>

</html>