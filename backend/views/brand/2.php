<!-- $Id: category_list.htm 17019 2010-01-29 10:10:34Z liuhui $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
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
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <tr>

                <th>品牌名称</th>
                <th>品牌描述</th>
                <th>排序</th>
                <th>状态</th>
                <th>操作</th>
            </tr>

            <?php  foreach ($brandbase as $rows):?>
            <tr align="center" class="0">
                <td align="left" class="first-cell" >
                    <span><?= $rows->name?></span>
                <img src="<?= substr($rows->logo,1,strlen($rows->logo))?>" width="40" height="40" border="0" style="margin-left:0em" />

                </td>
                <td width="15%"><?= $rows->introduce?></td>
                <td width="15%" align="center"><?= $rows->sort_num?></span></td>
                <td width="15%"><img src="/statics/images/<?= $rows->status?'yes':'no'; ?>.gif" /></td>

                <td width="30%" align="center">
                <a href="__GROUP__/Category/categoryEdit?cat_id=<{$val.cat_id}>">编辑</a> |
                <a href="__GROUP__/Category/categoryDelete?cat_id=<{$val.cat_id}>" title="移除" onclick="">移除</a>
                </td>
            </tr>

           <?php endforeach;?>
        </table>
    </div>
</form>
<div id="footer">
共执行 1 个查询，用时 0.055904 秒，Gzip 已禁用，内存占用 2.202 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>