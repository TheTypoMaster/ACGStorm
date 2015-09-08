<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>登录弹框</title>
    <link rel="stylesheet" type="text/css" href="https://miscssl.360buyimg.com/lib/skin/2013/base.css" media="all">
    <link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/login_form_box.css"/>
	<script type="text/javascript" src="https://miscssl.360buyimg.com/jdf/lib/jquery-1.6.4.js"></script>
    <link charset="utf-8" rel="stylesheet" href="https://miscssl.360buyimg.com/jdf/1.0.0/ui/tips/1.1.0/tips.css"></head>
	<script src="catalog/view/theme/cnstorm/wbox/wbox.js"></script>
<body marginwidth="0" marginheight="0">
<div class="login-form">
    <div class="login-box">
        <div class="mt">
            <h1>CNstorm会员</h1>
            <div class="extra-r">
                <div class="regist-link"><a href="https://reg.jd.com/reg/person?ReturnUrl=http%3A%2F%2Fwww.jd.com" target="_blank" clstag="pageclick|keycount|20150112ABD|10"><b></b>立即注册</a></div>
            </div>
        </div>
    
        <div class="mc">
            <div class="form">
				<div class="errormsg" style="color:red;text-align:center;height:18px"></div>
                <form id="formlogin" method="post" onsubmit="return false;">
                    <input type="hidden" id="uuid" name="uuid" value="d932fa5d-d639-4fcc-a48c-b2bd86d92603">
                    <input type="hidden" name="machineNet" id="machineNet" value="" class="hide">
                    <input type="hidden" name="machineCpu" id="machineCpu" value="" class="hide">
                    <input type="hidden" name="machineDisk" id="machineDisk" value="" class="hide">
                    <input type="hidden" name="oAQqYGaNjB" value="XhnOB">
                    <div class="item item-fore1">
                        <label for="loginname" class="login-label name-label"></label>
                        <input id="loginname" type="text" class="itxt" name="loginname" tabindex="1" autocomplete="off" placeholder="邮箱">
                        <span class="clear-btn"></span>
                    </div>
                    <div id="entry" class="item item-fore2">
                        <label class="login-label pwd-label" for="nloginpwd"></label>
                  
                        <input type="password" id="nloginpwd" name="nloginpwd" class="itxt itxt-error" tabindex="2" autocomplete="off" placeholder="密码">
                        <input type="hidden" name="loginpwd" id="loginpwd" value="" class="hide">
                        <span class="clear-btn"></span>
                        <span class="capslock" style="display: none;"><b></b>大小写锁定已打开</span>
                    </div>
          
             
                    <div class="item item-fore5">
                        <div class="login-btn">
                            <a href="javascript:;" class="btn-img btn-entry" id="loginsubmit" tabindex="6" >登&nbsp;&nbsp;&nbsp;&nbsp;录</a>
                        </div>
                    </div>
                </form>
            </div>
        
            <div class="coagent">
                <h5>使用合作网站账号登录：</h5>
                <ul>
                    <li>
                        <a class="xinlang" href="javascript:;" alt="https://api.weibo.com/oauth2/authorize?client_id=2144919427&amp;redirect_uri=http%3A%2F%2Fwww.acgstorm.com%2Findex.php%3Froute%3Daccount%2Flogin%2Flogin_weibo&amp;response_type=code">新浪</a>
                        <span class="line">|</span>
                    </li>
                    <li>
                       <a class="qq" href="javascript:;" alt="https://graph.qq.com/oauth2.0/authorize?response_type=code&amp;client_id=100360874&amp;state=9175e816623b111ddb36e19d2b07783d&amp;redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq">qq</a>
                    </li>
                   
                </ul>
            </div>

        </div>
    </div>
</div>

  <script type="text/javascript">
	  function getCookie(c_name){
		if (document.cookie.length>0){
		  c_start=document.cookie.indexOf(c_name + "=")
		  if (c_start!=-1)
			{ 
			c_start=c_start + c_name.length+1 
			c_end=document.cookie.indexOf(";",c_start)
			if (c_end==-1) c_end=document.cookie.length
			return unescape(document.cookie.substring(c_start,c_end))
			} 
		  }
		return ""
	}
		function CloseWebPage(){
		 if (navigator.userAgent.indexOf("MSIE") > 0) {
		  if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
		   window.opener = null;
		   window.close();
		  } else {
		   window.open('', '_top');
		   window.top.close();
		  }
		 }
		 else if (navigator.userAgent.indexOf("Firefox") > 0) {
		  window.location.href = 'about:blank ';
		 } else {
		  window.opener = null;
		  window.open('', '_self', '');
		  window.close();
		 }
	}
	$('.xinlang,.qq').bind('click',function(){
		var url=$(this).attr('alt');
		$('.wBox_close', window.parent.document).click();
		window.parent.window.location.href=url;
	});
	
	$('#loginsubmit').click(function(){
			var runUrl=encodeURIComponent(getCookie('runUrl'));
			runUrl="http://www.acgstorm.com/index.php?route=product/zzg_snatch&search="+runUrl;
			var data={email:$('#loginname').val(),password:$('#nloginpwd').val(),isAjax:1,redirect:runUrl};
			$.ajax({
				url:'/index.php?route=account/login',
				data:data,
				type:'POST',
				dataType:'html',
				success:function(msg){
					if(msg){
						$('.errormsg').html(msg);
					}else{
							$('.wBox_close', window.parent.document).click();
							//window.parent.window.location.href=runUrl;
							window.parent.window.location.href='/order-snatch.html';
					}
				},
			})
		}
	);
  </script>

</body></html>