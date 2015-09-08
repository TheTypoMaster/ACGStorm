<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>找回密码</title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/login_register.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/placeholder.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/checkCode.js" type="text/javascript"></script>
</head>
<body>
<div class="mainWrap loginwMargins">
	<a href="/" class="logregLogo"><img src="images/site/login/logregLogo.jpg" width="182" height="57" alt="logo"/></a>
	<a href="/" title="返回首页" class="backHome">返回首页</a>
</div>
<div class="wrapBox">
	<div class="mainWrap">
		<!--StepOne[[-->
		<div class="forgetBoxs">
			<span class="forgetIcon fiStep01"></span>
			<p class="fisDepicts">
				<label class="mainColor">填写邮箱</label>
				<label class="textCenter">验证身份</label>
				<label class="textRight">设置新密码</label>
				<label class="fistrLast">完成</label>
			</p>
			<div class="forgetForms">

			<p class="lfcSplits">
				<input type="text" name="email" value="" placeholder="请输入注册邮箱"/><span id="errorMessage_email"></span>
				<input type="hidden" value="1" name="step">
			</p>
			<div class="lfcSplits">
				<p class="lfcsp">
					<input type="text" value="" placeholder="验证码" class="code_letter"/>
					
					<span id="checkCode" ></span>
					<span class="change_code">看不清？<br>
						<a href="javascript:void(0);" onclick="createCode()">换一张</a>
					</span>
					<span id="errorMessage_code"></span>
				</p>
				<span id="errorMessage_code"></span>
			</div>
			<p class="lfcSplits">
				<a href="javascript:void(0);"  alt="1" class="forgetBtn">下一步</a>
				<span class="tishi">正在发送邮件请稍等...</span>
			</p>
			
			</div>
		</div>
		<!--StepOne]]-->
		
		<!--StepTwo[[-->
		<div class="forgetBoxs hide">
			<span class="forgetIcon fiStep02"></span>
			<p class="fisDepicts">
				<label>填写邮箱</label>
				<label class="mainColor textCenter">验证身份</label>
				<label class="textRight">设置新密码</label>
				<label class="fistrLast">完成</label>
			</p>
			<div class="forgetForms">
			<input type="hidden" value="2" name="step">
				<p class="ffSends hide">验证邮件已发送，请您登录邮箱<br/>点击重置密码链接重设密码。</p>
				<p class="error hide">验证邮件已发送，请您登录邮箱<br/>点击重置密码链接重设密码。</p>
			</div>
		</div>
		<!--StepTwo]]-->
		

		
	
	</div>
</div>
<script type="text/javascript">
$(function(){
	var forgetBtn=$(".forgetBtn");
	var step=$('input[name=step]').val();
	forgetBtn.click(function(){
	 if(step==1){
		var inputCode=$.trim($('.code_letter').val()).toUpperCase();//取得输入的验证码并转化为大写 
		var span_code=$('#errorMessage_code');
		indexCode = codeObj.toUpperCase();//默认选出的验证码
		if(inputCode.length <4){
			msg='请输入4位验证码';
			span_code.removeClass('gree');span_code.html(msg).addClass('redcolor');
			return false;
		}else{
		  if(inputCode != indexCode ) { //若输入的验证码与产生的验证码不一致时
				msg="验证码输入错误";
				span_code.removeClass('gree');span_code.html(msg).addClass('redcolor');//验证码输入错误
				createCode();//刷新验证码		        		   	  
				return false;
			}else { //输入正确时	   			   			
				span_code.html('').removeClass('redcolor').addClass('gree');
			}  
		}
		var email=$.trim($('input[name=email]').val());
		var span_email=$('#errorMessage_email');
		if(email==''){
			msg='邮箱不能为空';
			span_email.html(msg).addClass('redcolor');
			return false;
		}else{
			 var pe=/^[^\@]+@.*\.[a-z]{2,6}$/;
			if(!email || !pe.test(email) ) {
				msg='请输入符合规范的邮箱地址';
				span_email.removeClass('gree');span_email.html(msg).addClass('redcolor');
				return false;
			} else {
				$('.forgetBtn').hide();
				
				var thisIndex=$(this).parent().parent().parent().parent().index();
				$.ajax({
					type: "POST",
					url: "index.php?route=account/register/checkemail",
					data: "email=" + email ,
					success: function(flag) {  
						if(flag==1) {
							span_email.html('').removeClass('redcolor').addClass('gree');
							sendRegPwdEmail(email);
						}else{
							msg="该邮箱不存在";
							span_email.removeClass('gree');span_email.html(msg).addClass('redcolor');
							return false;
						}
					}
				});
			   
			}
		}

	 }
	 
	
	});
});

function sendRegPwdEmail(email){
	var thisIndex=$(".forgetBtn").parent().parent().parent().parent().index();
	$.post('/index.php?route=account/register/sendRegPwdEmail',{email:email},function(data){

		if(data==1){
		
				$(".forgetBoxs").eq(thisIndex).addClass("hide");
				$(".forgetBoxs").eq(thisIndex+1).removeClass("hide");
				$('.ffSends').show();
		}else{
				$(".forgetBoxs").eq(thisIndex).addClass("hide");
				$(".forgetBoxs").eq(thisIndex+1).removeClass("hide");
				$('.error').show();
			
			
		}
	});
}
</script>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49083828-1', 'cnstorm.com');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
</script>
<script type="text/javascript">
var _mvq = window._mvq || []; 
window._mvq = _mvq;
_mvq.push(['$setAccount', 'm-92402-0']);

_mvq.push(['$setGeneral', '', '', /*用户名*/ '', /*用户id*/ '']);//如果不传用户名、用户id，此句可以删掉
_mvq.push(['$logConversion']);
(function() {
	var mvl = document.createElement('script');
	mvl.type = 'text/javascript'; mvl.async = true;
	mvl.src = ('https:' == document.location.protocol ? 'https://static-ssl.mediav.com/mvl.js' : 'http://static.mediav.com/mvl.js');
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(mvl, s); 
})();	
</script>
</body>
</html>