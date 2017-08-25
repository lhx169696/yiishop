<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>用户注册</title>
	<link rel="stylesheet" href="/statics/style/base.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/global.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/header.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/login.css" type="text/css">
	<link rel="stylesheet" href="/statics/style/footer.css" type="text/css">
    <link type="text/css" rel="stylesheet" href="http://www.shopadmin.com/statics/plugins/layer/skin/default/layer.css">
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
			<h2>用户注册</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="<?=\yii\helpers\Url::to(['user/create'])?>" method="post">
					<ul>
						<li>
							<label for="">用户名：</label>
                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>"/>
							<input type="text" id="username" class="txt" name="Member[username]" />
							<p id="usertext">3-20位字符，可由中文、字母、数字和下划线组成</p>
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" id="password" class="txt" name="Member[password_hash]" />
							<p id="passwordtext">6-18位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
						</li>
						<li>
							<label for="">确认密码：</label>
							<input type="password" id="repassword" class="txt" name="Member[repassword]" />
							<p id="repasswordtext"> <span>请再次输入密码</p>
						</li>
						<li>
							<label for="">邮箱：</label>
							<input type="text" id="email" class="txt" name="Member[email]" />
							<p id="emailtext">邮箱必须合法</p>
						</li>
						<li>
							<label for="">手机号码：</label>
							<input type="text" class="txt" value="" name="Member[mobile]" id="tel" placeholder=""/>
						</li>
						<li>
							<label for="">验证码：</label>
<!--                            <input type="text" class="txt" value=""  placeholder="请输入短信验证码" name="captcha" disabled="disabled" id="captcha" />-->
                            <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="captcha" disabled="disabled" id="captcha"/>
                            <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>
							
						</li>
						<li class="checkcode">
							<label for="">验证码：</label>
							<input type="text"  name="code" />
							<img id="code" src="<?= \yii\helpers\Url::to(['user/code'])?>" alt="" />
							<span>看不清？<a id="cpCode" href="javascript:void (0)">换一张</a></span>
						</li>
						
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="submit" value="" class="login_btn" />
						</li>
					</ul>
				</form>

				
			</div>
			
			<div class="mobile fl">
				<h3>手机快速注册</h3>			
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
    <script type="text/javascript" src="http://www.shopadmin.com/statics/plugins/layer/layer.js"></script>
	<script type="text/javascript">
        //验证密码
        $("#repassword").blur(function () {
            var password=$("#password").val();
            var repassword=$("#repassword").val();
            if (password !== repassword) {
                $("#repasswordtext").text("两次密码不相同,请重新输入").css('color','red')
            }else {
                $("#repasswordtext").text("").css('color','#AAAAAA')
            }


        });
        //密码正则
        $("#password").blur(function () {
            var password=$("#password").val();
            var reg=/^[a-z0-9_-]{6,18}$/;
            if (reg.test(password)===false) {
                $("#passwordtext").text("密码必须6-18位字符，可使用字母、数字和符号的组合").css('color','red')
            }else {
                $("#passwordtext").text("").css('color','#AAAAAA')
            }
        });
        //  检查邮箱是否存在
        $("#email").blur(function () {
            var email=$("#email").val();
            if(email===""){
                $("#emailtext").text("邮箱不能为空").css('color','red')
                return false;
            }
            $.post('<?=\yii\helpers\Url::to(['user/memberemail'])?>',{email:email,
                '_csrf-frontend':'<?= Yii::$app->request->csrfToken?>'
            },function (date) {
                 if (date.status==0){
                     $("#emailtext").text(date.hint).css('color','red')
                     return false;
                 }
                if (date.status==2){
                    $("#emailtext").text(date.hint).css('color','red')

                }
                if (date.status==1){
                    $("#emailtext").text(date.hint).css('color','#AAAAAA')

                }
            },'json')





        });
//        检查用户是否存在
	$("#username").blur(function () {
        var username=$("#username").val();
            if(username===""){
                $("#usertext").text("用户不能为空").css('color','red')
                return false;
            }
            $.post('<?=\yii\helpers\Url::to(['user/memberone'])?>',{username:username,
            '_csrf-frontend':'<?= Yii::$app->request->csrfToken?>'
            },function (date) {
//                 if (date.status==0){
//                     $("#usertext").text(date.hint).css('color','red')
//                     return false;
//                 }
                if (date.status==2){
                    $("#usertext").text(date.hint).css('color','red')

                }
                if (date.status==1){
                    $("#usertext").text(date.hint).css('color','#AAAAAA')

                }
            },'json')

    });


//短信验证码

		$(function () {
        $("#get_captcha").click(function () {
            var tel=$("#tel").val();
            if (tel==="") {
                layer.msg("手机号不能为空", {icon: 2});
                return false;
            }

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




               $.post('<?= \yii\helpers\Url::to(['user/captchatel'])?>',{tel:tel,
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
//图行验证码
		$(function () {
           $("#cpCode").click(function () {
               $.get('<?=\yii\helpers\Url::to(['user/code'])?>',{refresh:1},function (date) {

                             $("#code").attr("src",date.url)
               },'json')
           }); 
        })
	</script>
</body>
</html>