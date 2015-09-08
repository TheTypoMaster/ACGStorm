<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title><?php echo $heading_title; ?></title>
<meta name="description" content="<?php echo $keywords; ?>" />
<meta name="keywords" content="<?php echo $description; ?>" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/login_register.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/checkCode.js" type="text/javascript"></script>
<script src="catalog/view/javascript/placeholder.js" type="text/javascript"></script>
</head>
<body>
<div class="mainWrap loginwMargins">
	<a href="/" class="logregLogo"><img src="/image/data/logo.png" width="226" height="52" alt="logo"/></a>
	<a href="/" title="返回首页" class="backHome">返回首页</a>
</div>
<div class="login_bg">
	<div class="mainWrap">
		<div class="logregLeft">
			<a href="help-populartools.html&id=4" target="_blank">
				<img src="images/site/login/login_01.jpg" width="467" height="370" alt="<?php echo $text_background; ?>"/>
			</a>
		</div>
		<div class="loginformRight">
			<div class="lrfTop"></div>
			<div class="lrfmiddle">
				<div class="logregForms">
					<div class="lfTops">
						<h3>登录CNstorm</h3>
						<p>还没有账号？&nbsp;&nbsp;<a href="account-register.html">立即注册</a></p>
					</div>
					<form id="" action="<?php echo $action; ?>" method="post"  <?php if(isset($loginSign) && $loginSign>=2){ ?> onSubmit="return validate_login();" <?php } ?>>
                                              <input type="hidden" name="redirect" value="<?php echo $redirect;?>">
						<p class="lfcSplits">
							<input class="input" type="text" name="email" value="<?php echo $email;?>" placeholder="<?php echo $text_address; ?>" AUTOCOMPLETE="OFF"/>
						</p>
						<p class="lfcSplits">
							<input class="input" type="password" name="password" value="<?php echo $password;?>" placeholder="<?php echo $text_password; ?>" AUTOCOMPLETE="OFF"/>
						</p>
						<?php if(isset($loginSign) && $loginSign>=2){ ?>
						<div class="lfcSplits">
							<p class="lfcsp">
								<input class="code_letter input" type="text" value="" id="input" placeholder="<?php echo $text_code; ?>"/>
								<a href="javascript:void(0);" onClick="createCode();">
									<span id="checkCode" class="code_pic"></span>
								</a>
								<span class="change_code"><?php echo $text_clear; ?>
									<br/><a href="javascript:void(0);" onClick="createCode()"><?php echo $text_change; ?></a>
								</span>
							</p>
						</div>
						<?php } ?>
						<?php if ($error_login) { ?>
						<p class="lfcSplits">
							<span class="error-box" style="margin-top:0;"><?php echo $error_login; ?></span>
						</p>
						<?php } ?>
						<p class="lfcSplits">
							<input type="submit" value="<?php echo $text_login; ?>" class="reg_btn"/>
						</p>
						<div class="lfcSplits">
							<div><?php echo $text_cooperative; ?>							
								<p class="lfcsForget">
								<a class="forgot_psw" href="/account-register-newForget.html"><?php echo $text_forgotten; ?></a>
							</p></div>
							<p class="lfcsCooperate">
								
								<a class="sina" href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&response_type=code&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_weibo&scope=follow_app_official_microblog,email"></a>
								<a class="qq" href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100360874&state=9175e816623b111ddb36e19d2b07783d&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq"></a>
								<a class="wechat" href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc77f5c41a5df661b&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_wx&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect"></a>
							</p>
						</div>
					</form>
				</div>
			</div>
			<div class="lrfBotttom"></div>
		</div>
	</div>
</div>
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