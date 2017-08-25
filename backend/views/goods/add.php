<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加新商品 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/statics/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/statics/styles/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/statics/plugins/webuploader/webuploader.css">
    <link  rel="stylesheet" type="text/css" href="/statics/zTree_v3-master/css/zTreeStyle/zTreeStyle.css">
    <link type="text/css" rel="stylesheet" href="/statics/plugins/layer/skin/default/layer.css">
</head>
<body>
<h1>
    <span class="action-span"><a href="__GROUP__/Goods/goodsList">商品列表</a>
    </span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加新商品 </span>
    <div style="clear:both"></div>
</h1>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="<?= \yii\helpers\Url::to(['goods/create'])?>" method="post">
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken?>"/>
                    <td><input type="text" name="Goods[name]" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品货号： </td>
                    <td>
                        <input type="text" name="Goods[goods_on]" value="" size="20"/>
                        <span id="goods_sn_notice"></span><br />
                        <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <input type="text" id="pid_show" disabled/>
                        <input type="hidden" name="Goods[category_id]" value="" id="pid"/>
                        <ul id="treeDemo" class="ztree"></ul>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
                        <select name="Goods[brand_id]">
                            <?php foreach ($brand as $v):?>
                            <option value="<?= $v['id']?>"><?= $v['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="Goods[price]" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品数量：</td>
                    <td>
                        <input type="text" name="Goods[goods_num]" size="8" value=""/>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="Goods[status]" value="1"/> 是
                        <input type="radio" name="Goods[status]" value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="Goods[is_best]" value="1" /> 精品
                        <input type="checkbox" name="Goods[is_new]" value="1" /> 新品
                        <input type="checkbox" name="Goods[is_hot]" value="1" /> 热销
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐排序：</td>
                    <td>
                        <input type="text" name="Goods[sort_num]" size="5" value="100"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">商品关键词：</td>
                    <td>
                        <input type="text" name="Goods[keywords]" value="" size="40" /> 用空格分隔
                    </td>
                </tr>
                <tr>
                    <td class="label">商品图片：</td>
                    <td>
<!--                        <input type="file" name="goods_img" size="35" />-->
                        <div id="uploader-demo">
                            <!--用来存放item-->
                            <div id="fileList" class="uploader-list"></div>
                            <div id="filePicker">选择图片</div>
                            <span class="notice-span" id="noticeGoodsSN">双击删除图片哦。</span>
                            <div id="img"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
<!--                        <textarea name="goods_brief" cols="40" rows="3"></textarea>-->
                        <script id="editor" name="GoodsDetail[detail]" type="text/plain" style="width:650px;height:400px;"></script>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />

            </div>
        </form>
    </div>
</div>

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="/statics/js/jquery.2.0.min.js"></script>
<script type="text/javascript" src="/statics/zTree_v3-master/js/jquery.ztree.core.min.js"></script>
<script type="text/javascript" src="/statics/plugins/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="/statics/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/statics/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/statics/plugins/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/statics/plugins/layer/layer.js"></script>
<script type="text/javascript">
    $(function () {
        $("#img").on('dblclick','img', function(event) {
            var that=$(this);
            var     src=that.attr('src');
            $('.goodssrc').each(function(i,v){
                if(that.attr('src')=== v.value){
                    var input=$(this);
                    that.remove();
                    input.remove();
                }
            });
        });
    });

    var setting = {
        data: {
            simpleData: {
                enable: true,
                pIdKey:'pid'
            }
        },
        callback:{
            onClick:dealclick
        }
    };
    function dealclick(evet,treeid,treenode) {
        $('#pid').val(treenode.id)
        $('#pid_show').val(treenode.name)
    }

    var zNodes =<?= $goods?>

        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,
        duplicate :true,
        // swf文件路径
        swf: '/statics/plugins/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: '<?= \yii\helpers\Url::to(['base/upload'])?>',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/jpg,image/jpeg,image/png'   //修改这行
        },
        formData : {'_csrf-backend':'<?php echo Yii::$app->request->csrfToken;?>'}

    })
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function(file,date) {
         if(date.status){
             var input="<input type='hidden' class='goodssrc' value='"+date.url+"'  name='GoodsImages[url][]'/>";
              $('.uploader-list').append(input);

             var img="<img src='"+date.url+"' width='80' />";
             $('#img').append(img);
             layer.msg(date.message, {icon: 1});

         }else {
             layer.msg("图片上传失败", {icon: 2});
         }
    })
        //上传失败
        uploader.on( 'uploadComplete', function(file) {
            $( '#'+file.id ).find('.progress').remove();
        })
    var ue = UE.getEditor('editor');
</script>
</body>
</html>