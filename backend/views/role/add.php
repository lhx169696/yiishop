<!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="/statics/zTree_v3-master/css/zTreeStyle/zTreeStyle.css">
</head>
<body>
<h1>
    <span class="action-span"><a href="__GROUP__/Category/categoryList">商品分类</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加分类 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="<?= \yii\helpers\Url::to(['role/create'])?>" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken?>"/>
            <tr>

                <td class="label">角色名称:

                </td>
                <td>

                    <input type='text' name='name' maxlength="20" value='' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>

                <td class="label" >选择权限:</td>

                <td>
                    <?php foreach ($model as $v):?>
                   <input type="checkbox" name="permission[]" value="<?= $v->name?>"/> <?= $v->description?>
                    <?php endforeach;?>
                </td>
            </tr>
            <tr>
                <td class="label" >角色描述:</td>

                <td>
                    <textarea rows="7" cols="30" name="description"></textarea>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>

<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="/statics/js/jquery.2.0.min.js"></script>
<script type="text/javascript" src="/statics/zTree_v3-master/js/jquery.ztree.core.min.js"></script>

</body>
</html>