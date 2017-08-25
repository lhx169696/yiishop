<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>身份验证</title>
	<link rel="stylesheet" href="/statics/style/base.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/global.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/header.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/login.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/footer.css" type="text/css">
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/statics/images/logo.png" alt="京西商城"></a></h2>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10 regist">
		<div class="login_hd">
			<h2>找回密码</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="<?=\yii\helpers\Url::to(['user/yz'])?>" method="post">
                    <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>"/>
					     <table border="0"  width="500px" height="300px" >

							 <tr><td style="text-align:right ">
                                     <input type="hidden" name="mobile" value="<?=$Memberinfo->mobile?>"/>
                                     请选择验证方式：</td><td><b>手机验证</b></td></tr>
							 <tr><td style="text-align:right ">昵称：</td><td> <font size="4px"><b><?=substr($Memberinfo->username,0,2)."****".substr($Memberinfo->username,7,4)?></b></font></td></tr>
							 <tr><td style="text-align:right ">已验证手机:</td><td><font size="4px"><b><?= substr($Memberinfo->mobile,0,3)."****".substr($Memberinfo->mobile,7,4)?></b></td></tr>
							 <tr><td style="text-align:right ">请填写手机校验码:</td><td>
                                  <input type="hidden" name="Member['mobile'] " value="<?=$Memberinfo->mobile?>">
								 <b>   <input type="text" class="txt" value="" placeholder="请输入短信验证码" style="width: 210px" name="captcha"  id="captcha"/>
                                     <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>
                                 </b>

							 </td></tr>
							 <tr><td colspan="2" align="center"><input type="submit" value="提交"  style="width: 130px; height: 30px ; color: #00a6b2"  /></td></tr>
						 </table>


							<label for="">&nbsp;</label>


				</form>

				
			</div>
			
			<div class="mobile fl">
				<h3>找回密码</h3>			
				<p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
				<p><strong>1069099988</strong></p>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/statics/images/xin.png" alt="" /></a>
			<a href=""><img src="/statics/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/statics/images/police.jpg" alt="" /></a>
			<a href=""><img src="/statics/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
	<script type="text/javascript" src="/statics/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript">
        $(function () {
            $("#get_captcha").click(function () {


                //启用输入框
                $('#captcha').prop('disabled',false);
                var time=120;
                var interval = setInterval(function(){
                    time--;
                    if(time<=0){
                        clearInterval(interval);
                        var html = '获取验证码';
                        $('#get_captcha').prop('disabled',false);
                    } else{
                        var html = time + ' 秒后再次获取';
                        $('#get_captcha').prop('disabled',true);
                    }

                    $('#get_captcha').val(html);
                },1000);




                $.post('<?= \yii\helpers\Url::to(['user/captchatel'])?>',{tel:<?= $Memberinfo->mobile?>,
                        '_csrf-frontend':'<?= Yii::$app->request->csrfToken?>'},
                    function (date) {
                        if (date.status===0) {
                            layer.msg(date.magess, {icon: 2});
                            clearInterval(interval);
                        }else {
                            layer.msg(date.magess, {icon: 1});

                        }
                    },'json');


            })
        });
	</script>
</body>
</html>