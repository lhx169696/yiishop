<!-- $Id: category_list.htm 17019 2010-01-29 10:10:34Z liuhui $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="/statics/plugins/treegrid/css/jquery.treegrid.css">
    <style type="text/css">
        body{
        ;
        }
        .pagination ul{
            position: relative;
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
    <span class="action-span"><a href="__GROUP__/Category/categoryAdd">添加分类</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品分类 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table width="100%" cellspacing="1" cellpadding="2" id="tree">
            <tr>
                <th>权限名称</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
          <?php foreach ($permission as $rows):?>
            <tr align="center" >
                <td align="left" class="first-cell" >
                        <?= $rows['name']?>
                </td>
                <td width="15%" align="center"><span><?= $rows['description']?></span></td>
                <td width="15%" align="center"><span><?= $rows['created_at']?></span></td>
                <td width="30%" align="center">
                <a href="<?= \yii\helpers\Url::to(['permission/edit','name'=>$rows['name']])?>">编辑</a> |
                <a href="<?= \yii\helpers\Url::to(['permission/delete','name'=>$rows['name']])?>" title="移除" onclick="">移除</a>
                </td>
            </tr>
<?php endforeach;?>
            <tr>

                <td align="right" nowrap="true" colspan="6">
           <span id="page-link" style="border: none; position: relative;left: 750px">

                            <?= \yii\widgets\LinkPager::widget(['pagination'=>$pageobj,
                                'lastPageLabel' => '尾页', 'firstPageLabel' => '首页',
                                'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页',
                                'maxButtonCount' =>7,
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
</form>
<div id="footer">
共执行 1 个查询，用时 0.055904 秒，Gzip 已禁用，内存占用 2.202 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="/statics/js/jquery.2.0.min.js"></script>
<script type="text/javascript" src="/statics/plugins/treegrid/js/jquery.treegrid.js"></script>
<script type="text/javascript">

</script>
</body>
</html>