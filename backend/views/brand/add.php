
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加品牌 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="/statics/plugins/uploadify/uploadify.css">
    <link type="text/css" rel="stylesheet" href="/statics/plugins/layer/skin/default/layer.css">

    <style type="text/css">
        img{
            display: none;
        }
        #upload-handle{
            height: 20px;
            background-color: green;
            width: 80px;
            line-height: 20px;
            text-align: center;
            color: #ffffff;
            border-radius: 5px;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?= \yii\helpers\Url::to(['brand/list'])?>">品牌分类</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <?php
    $from=\yii\widgets\ActiveForm::begin(['action'=>\yii\helpers\Url::to(['brand/create'])]);
    ?>
       <table width="100%" id="general-table">
            <tr>
                <td class="label">品牌名称:</td>
                <td>
                   <?= $from->field($model,'name')->label(false)?>
                </td>
            </tr>
            <tr>
                <td class="label">品牌logo:</td>
                <td>
                    <input type="file" id="file_upload" style="display: none;"/>

                    <div id="upload-handle" ><img src="/statics/images/no.gif"> 点击上传</div>
                    <span class="notice-span" style="display:block"  id="warn_brandlogo">请上传图片，做为品牌的LOGO！</span>

                    <img src=""  id="show_logo"  width="50"/>
                    <?= $from->field($model,'logo')->hiddenInput(['id'=>'logo'])->label(false);?>

                </td>
            </tr>
            <tr>
                <td class="label">品牌描述:</td>
                <td>
                    <?= $from->field($model,'introduce')->textarea(['rows'=>5,'cols'=>30])->label(false);?>
                </td>
            </tr>
            <tr>
                <td class="label">排序:</td>
                <td>
                    <?= $from->field($model,'sort_num')->label(false)?>
                </td>
            </tr>
            <tr>
                <td class="label">是否上线:</td>
                <td>
                    <?= $from->field($model,'status')->label(false)->radioList([0=>'否',1=>'是'])?>
                </td>
            </tr>

        </table>
        <div class="button-div">
            <?= \yii\helpers\Html::submitButton('确定')?>
            <?= \yii\helpers\Html::resetInput('重置')?>
        </div>
<?php
 \yii\widgets\ActiveForm::end();
?>
</div>

<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="/statics/js/jquery.2.0.min.js"></script>
<script type="text/javascript" src="/statics/plugins/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/statics/plugins/layer/layer.js"></script>
<script type="text/javascript">
    document.getElementById('upload-handle').onclick = function(){

        document.getElementById('file_upload').click();
    };
      document.getElementById("file_upload").onchange=function () {
              fromobj=new FormData;
          file=document.getElementById("file_upload").files[0];
          fromobj.append('logofile',file);
          fromobj.append('_csrf-backend','<?php echo Yii::$app->request->csrfToken;?>');
         xmlreq= new XMLHttpRequest();
         xmlreq.onloadstart=function (e) {
             console.log(e);
         }
          xmlreq.onloadend=function () {
                 console.log(xmlreq.response);
              date=JSON.parse(xmlreq.response);
               if(date.status){
                   layer.msg(date.message, {icon: 1});
              $("#show_logo").attr('src',date.url).css('display','block')
                    $("#logo").val(date.url)
               }else {
                   layer.msg("图片上传失败", {icon: 2});
               }


          }
          xmlreq.open('POST','<?= \yii\helpers\Url::to(['base/upload'])?>',true)
          xmlreq.send(fromobj);
      }
       var btn=document.getElementById('btn');
//         btn.onclick(function () {
//             alert('5555555')
//         });
</script>
<!--<script type="text/javascript">-->
<!---->
<!--    $(function() {-->
<!--        $('#file_upload').uploadify({-->
<!--            'swf'      : '/statics/plugins/uploadify/uploadify.swf',-->
<!--            'formData'  : {-->
<!--                '_csrf-backend' : '--><?php //echo \Yii::$app->request->csrfToken;?>//'
//            },
//            'uploader' : '<?//= \yii\helpers\Url::to(['base/upload'])?>//',
//            'buttonText' : '请选择logo',
//
//
//
//            'onUploadSuccess' : function(file,date) {
//               date=JSON.parse(date);
//               if(date.status){
//                   layer.msg(date.message, {icon: 1});
//              $("#show_logo").attr('src',date.url)
//                    $("#logo").val(date.url)
//               }else {
//                   layer.msg("图片上传失败", {icon: 2});
//               }
//
//            }
//
//
//        })
//    })
<!--//</script>-->
</body>

</html>