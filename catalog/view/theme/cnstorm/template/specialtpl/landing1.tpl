<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>免费注册-CNstorm.com</title>
<meta name="keywords" content="代购用户免费注册,服务费全免,用户登录，新加坡代购，美国代购，海外华人代购,淘宝代购,留学生代购,国内代购,团购,拼单购"/>
<meta name="description" content="华人代购中国商品免费注册，华人代购淘宝免费注册" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/business.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/topic.css"/>
</head> 
<body>
<div class="wrap">
	<div class="top">
		<a href="/" class="logo" rel="nofollow">时尚便捷的留学生及华人购物服务平台</a>
		<a href="/account-register.html" title="免费注册" class="logoRight" target="_blank"><img src="/catalog/view/theme/cnstorm/specialimages/landing/635551125044367886.gif" alt="免费注册"></a>
	</div>
	<div class="link">
		<h5>立即注册，即有机会获得<strong>“服务费全免”</strong>优惠</h5>
		<p class="list">
			<a href="/account-register.html" class="ht regself">邮箱注册</a>
			<a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100360874&state=9175e816623b111ddb36e19d2b07783d&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq" class="ht regQQ">QQ</a>
			<a href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&redirect_uri=http%3A%2F%2Fwww.acgstorm.com%2Findex.php%3Froute%3Daccount%2Flogin%2Flogin_weibo&response_type=code" class="ht regweibo">微博</a>
		</p>
	</div>
	<div class="test">
		<img src="/images/special/landing1.png">
		<img src="/catalog/view/theme/cnstorm/specialimages/landing/z2.jpg">
		<img src="/catalog/view/theme/cnstorm/specialimages/landing/z3.jpg">
	</div>
	<div class="test2">
		<img src="/catalog/view/theme/cnstorm/specialimages/landing/z_1.png">
		<img src="/catalog/view/theme/cnstorm/specialimages/landing/z_2.png" class="i2">
		<img src="/catalog/view/theme/cnstorm/specialimages/landing/z_3.png">
	</div>
	<div class="reg_com">
		<div class="ushLong">
			<h1>TA们在说</h1>
			<?php foreach ($comments as $comment){ ?>
			<div class="user_sayhi">
				<?php if($comment[ 'face']){?>
				<img class="user_sayhiface" src="<?php echo $comment['face'];?>" alt="<?php echo $comment['uname'];?>">
				<?php }else{ ?>
				<img class="user_sayhiface" src="uploads/big/0b4a96400b2372d25da769647bfe4059.jpg" alt="<?php echo $comment['uname'];?>">
				<?php } ?>
				<ul class="user_sayhiinfo">
					<li class="info-data">
						<span class="user_sayhiname"><?php echo $comment[ 'uname'];?></span>
						<span class="user_sayhidate"><?php echo $comment[ 'from'];?></span>
					</li>
					<li class="user_sayhicontent">
						<a href="information-comments.html" rel="nofollow" target="_blank" title="点击查看更多">
							<p><?php echo mb_substr($comment[ 'message'],0,38, 'utf-8'). "...";?></p>
						</a>
					</li>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="link">
		<h5>立即注册，即有机会获得<strong>“服务费全免”</strong>优惠</h5>
		<p class="list">
			<a href="/account-register.html" class="ht regself">邮箱注册</a>
			<a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100360874&state=9175e816623b111ddb36e19d2b07783d&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq" class="ht regQQ">QQ</a>
			<a href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&redirect_uri=http%3A%2F%2Fwww.acgstorm.com%2Findex.php%3Froute%3Daccount%2Flogin%2Flogin_weibo&response_type=code" class="ht regweibo">微博</a>
		</p>
	</div>
</div>
<?php echo $footer_business ?>
</body>
</html>