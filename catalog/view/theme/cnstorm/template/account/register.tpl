<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title><?php echo $heading_title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/login_register.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/checkCode.js" type="text/javascript"></script>
<script src="catalog/view/javascript/placeholder.js" type="text/javascript"></script>
<script type="text/javascript">
var _mvq = window._mvq || [];window._mvq = _mvq;
_mvq.push(['$setAccount', 'm-92402-0']);
_mvq.push(['$setGeneral', 'register', '', /*用户名*/ 'huangkun', /*用户id*/ Math.random()]);
_mvq.push(['$logConversion']);
</script>
</head>
<body>
<div class="mainWrap loginwMargins">
	<a href="/" class="logregLogo"><img src="/image/data/logo.png" width="226" height="52" alt="logo"/></a>
	<a href="/" title="返回首页" class="backHome">返回首页</a>
</div>
<div class="login_bg">
  <div class="wrap">
    <div class="mainWrap">
      <div class="logregLeft"> 
        <!--<p><?php echo $text_share; ?></p>--> 
        <p class="lfcscImg"><img src="images/site/login/register_01.jpg" width="385" height="345" alt="注册送200积分，终身免服务费"/></p>
        <div class="co-login"> <p>使用合作网站账号登录</p>
          <p class="lfcsCooperate"> <a class="sina" href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&redirect_uri=http%3A%2F%2Fwww.acgstorm.com%2Findex.php%3Froute%3Daccount%2Flogin%2Flogin_weibo&response_type=code"></a> <a class="qq" href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100360874&state=9175e816623b111ddb36e19d2b07783d&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq"></a> <a class="wechat" href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc77f5c41a5df661b&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_wx&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect"></a> </p>
        </div>
      </div>
      <div class="loginformRight">
        <div class="lrfTop"></div>
        <div class="lrfmiddle">
          <div class="logregForms">
            <div class="lfTops">
              <h3>注册CNstorm</h3>
              <p>已有账号？&nbsp;&nbsp;<a href="account-login.html">立即登录</a></p>
            </div>
            <form id="reg" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div style="display:none">
                <?php if($ReturnUrl){ ?>
                <input type="hidden" name="ReturnUrl" value="<?php echo $ReturnUrl;?>"/>
                <?php } ?>
              </div>
              <p class="lfcSplits">
                <input class="input" type="text"  name="email" id="email" value="<?php echo $email; ?>" placeholder="邮箱地址"/>
                <?php if ($error_email) { ?>
                <span class="error"><em><?php echo $error_email; ?></em></span>
                <?php } ?>
                <span id="errorMessage_email"></span> </p>
              <div class="lfcSplits">
                <?php if ($nick){ ?>
                <input class="input" type="hidden" name="tname" value="<?php echo $nick; ?>" placeholder="昵称"/>
                <?php } ?>
                <?php if ($oauthuid){ ?>
                <input class="input" type="hidden" name="oauthuid" value="<?php echo $oauthuid; ?>"/>
                <?php } ?>
                <input class="input" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="昵称"/>
                <?php if ($error_firstname) { ?>
                <span class="error"><em><?php echo $error_firstname; ?></em></span>
                <?php } ?>
                <span id="errorMessage_name"></span> </div>
              <p class="lfcSplits">
                <input class="input" type="password" name="password" id="password" value="<?php echo $password; ?>" placeholder="密码"/>
                <?php if ($error_password) { ?>
                <span class="error"><em><?php echo $error_password; ?></em></span>
                <?php } ?>
                <span id="errorMessage_pwd"></span> </p>
              <p class="lfcSplits">
                <input class="input" type="password" name="confirm" id="confirm" value="<?php echo $confirm; ?>" placeholder="确认密码"/>
                <?php if ($error_confirm) { ?>
                <span class="error"><em><?php echo $error_confirm; ?></em></span>
                <?php } ?>
                <span id="errorMessage_pwded"></span> </p>
              <div class="lfcSplits">
                <p class="lfcsp">
                  <input class="code_letter input" type="text" value="" id="input" placeholder="<?php echo $text_code; ?>"/>
                  <a href="javascript:void(0);" onClick="createCode();"> <span id="checkCode" class="code_pic"></span> </a> <span class="change_code"><?php echo $text_clear; ?> <br/>
                  <a href="javascript:void(0);" onClick="createCode()"><?php echo $text_change; ?></a> </span> </p>
                <span id="errorMessage_code"></span> </div>
              <?php if ($text_agree) { ?>
              <div class="lfcSplits">
                <div class="reg_check">
                  <?php if ($agree) { ?>
                  <input id="chkbox" class="li_checkbox" type="checkbox" name="agree" value="1" checked="checked" />
                  <?php } else { ?>
                  <input id="chkbox" class="li_checkbox" type="checkbox" name="agree" value="1" checked="checked" />
                  <?php } ?>
                  <label for="chkbox">我已阅读并同意<a href="help-agreement.html" target="_blank"><b>《<?php echo $text_Agreemen; ?>》</b></a></label>
                  <?php if ($error_warning) { ?>
                  <div class="error error_txt"><em><?php echo $error_warning; ?></em></div>
                  <?php } ?>
                </div>
              </div>
              <div class="lfcSplits">
                <input type="submit" value="注册" class="reg_btn">
                <?php } else { ?>
                <div class="lfcSplits">
                  <input type="submit" value="<?php echo $text_submit; ?>" class="reg_btn" />
                </div>
                <?php } ?>
                <?php if (isset($u)){ ?>
                <input type="hidden" name="uhid" value="<?php echo $u; ?>" />
                <?php } ?>
              </div>
            </form>
          </div>
        </div>
        <div class="lrfBotttom"></div>
      </div>
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