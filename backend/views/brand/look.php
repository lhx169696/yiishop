<!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 查看品牌信息 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?= \yii\helpers\Url::to(['brand/list'])?>">品牌分类</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 查看品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div"style="background: #FFFFFF">

       <table style="width: 600px;margin-left: 200px" id="general-table" align="center">
            <tr>
                <td class="label">品牌名称:</td>
                <td>
                   <?= $rows->name?>
                </td>
            </tr>
            <tr>
                <td class="label">品牌logo:</td>
                <td>


                    <img src="<?= $rows->logo?>" width="70px"/>
                </td>
            </tr>
            <tr >
                <td class="label">品牌描述:</td>
                <td width="20px">

                    <?= $rows->introduce?>
                </td>
            </tr>
           <tr>
               <td class="label">创建时间:</td>
               <td>
                   <?=  date("Y-m-d",$rows->create_time);?>
               </td>
           </tr>

            <tr>
                <td class="label">排序:</td>
                <td>

                    <?= $rows->sort_num?>
                </td>
            </tr>
            <tr>
                <td class="label">是否上线:</td>
                <td>
                    <?= $rows->sort_num?'是':'否';?>

                </td>
            </tr>

        </table>

</div>

<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>