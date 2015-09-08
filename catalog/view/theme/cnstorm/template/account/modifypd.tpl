<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>找回密码</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robots" content="nofollow" />
<link rel="stylesheet" href="catalog/view/theme/cnstorm/css/base.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-logreg.css"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/placeholder.js"></script>

</head>
<body>
<div class="mainWrap loginwMargins">
	<a href="/" class="logregLogo"><img src="images/site/login/logregLogo.jpg" width="182" height="57" alt="logo"/></a>
	<a href="/" title="返回首页" class="backHome">返回首页</a>
</div>
<script>
</script>
<div class="wrapBox">
	<div class="mainWrap">
	
	<?php if($is_valid){ ?>
		<!--StepThree[[-->
		<div class="forgetBoxs ">
			<span class="forgetIcon fiStep03"></span>
			<p class="fisDepicts">
				<label>填写邮箱</label>
				<label class="textCenter">验证身份</label>
				<label class="mainColor textRight">设置新密码</label>
				<label class="fistrLast">完成</label>
			</p>
			<div class="forgetForms">
			
			<input type="hidden" name="code" value="<?php echo $code;?>"/>
			<input type="hidden" name="vcode" value="<?php echo $vcode;?>"/>
			
			
			<input type="hidden" name="step" value="1"/>
				<p class="lfcSplits">
					<input type="password" value="" name="password" placeholder="请输入新密码"/>
				</p>
				<p class="lfcSplits">
					<input type="password" value=""  name="confirm" placeholder="请再次输入新密码"/>
				</p>
				<p class="lfcSplits">
					<a href="javascript:void(0);" alt="3" class="forgetBtn">下一步</a>
				</p>
			
			</div>
		</div>
		<!--StepThree]]-->
		
		<!--StepFour[[-->
		<div class="forgetBoxs hide">
			<span class="forgetIcon fiStep04"></span>
			<p class="fisDepicts">
				<label>填写邮箱</label>
				<label class="textCenter">验证身份</label>
				<label class="textRight">设置新密码</label>
				<label class="fistrLast mainColor">完成</label>
			</p>
			<div class="forgetForms">
				<p class="ffSends"><b class="mainColor">新密码设置成功</b><br/>请牢记您的新密码&nbsp;
					<a href="/order.html" class="ffRestlogin">重新登录</a>
				</p>
			</div>
		</div>
		<!--StepFour]]-->
		<?php }else{ ?>
		<h2 style="text-align:center">您好，您请求的链接已超时失效点击【<a href="/account-logout.html">这里</a>】重新获取</h2>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var forgetBtn=$(".forgetBtn");
	var code=$('input[name=code]').val();
	var vcode=$('input[name=vcode]').val();
	forgetBtn.click(function(){
	 var password=$('input[name=password]').val();
	 var span=$('#errorMessage_pwd');
		if(password.length <6){
				msg='请输入6位以上密码';
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				return;
			}else{
			span.html('').removeClass('redcolor').addClass('gree');
		}

		var confirm=$.trim($('input[name=confirm]').val());
		var span=$('#errorMessage_pwded');
		
		if(confirm.length<6){
				msg='请输入6位以上确认密码';
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				return;
			}else{
				if(confirm != $('input[name=password]').val()){
					msg='两次密码不一致';
					span.removeClass('gree');span.html(msg).addClass('redcolor');
					return false;
				}else{
				var data={
					password:password,
					code:code,
					vcode:vcode
				}
				
				var confirmInput=$('.forgetBoxs').eq(0);
				
				var successMsg=$('.forgetBoxs').eq(1);
				
				$.post('/index.php?route=account/modifypd/confirmPwd',data,function(msg){
					if(msg){
						confirmInput.hide();
						successMsg.show();
					}
				})
			}
		}
	})
});

function sendRegPwdEmail(email){
	$.get('/index.php?route=account/register/sendRegPwdEmail&email='+email);
}
</script>
</body>
</html>