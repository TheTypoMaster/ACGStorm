<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="UTF-8" />
<title>代购分享- CNstorm用户分享代购商品</title>
<meta name="Description" content="CNstorm代购用户分享频道每日更新，新鲜趣味不停歇！由代购商品用户为您推荐，保证个个都是'代购精选'"/>
<meta name="Keywords" content="韩国代购，代购商品，新加坡代购，美国代购，海外华人代购,淘宝代购,留学生代购,国内代购,服装代购，化妆品代购，食品代购，礼物代购，首饰代购"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link rel="canonical" href="http://www.acgstorm.com/" type="text/css"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/mall.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script  src="catalog/view/javascript/jquery2/global.js"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script src="catalog/view/javascript/composite.js" type="text/javascript"></script></script>
</head>
<body>
<?php echo $header_mall;?>
<div class="wrapBox">
	<!--banner[[-->
	<div class="topBanner tbPosition">
		<ul class="bannerBox">
			<?php if (!empty($lunbopics)){ $i=0; foreach($lunbopics as $lunbopic){ $i=$i+1;?>
			<li><a href="<?php echo $lunbopic['url'] ?>" target="_blank"><img src="image/<?php echo $lunbopic['image'] ?>" width="1200" height="400" alt="<?php echo $lunbopic['name'] ?>"></a></li>
			<?php } }?>
		</ul>
		<div class="bannerWrap">
			<div class="bannerDots">
				<?php  if (!empty($lunbopics)){ $i=0; foreach($lunbopics as $lunbopic){ $i=$i+1; ?>
				<a href="javascript:void(0);" class="bdTrigger <?php if($i==1){echo "curr";} ?>"></a>
				<?php } } ?>
			</div>
			<div class="mallNotices">
				<p class="mnTitles"><i></i>公告</p>
				<?php  if (!empty($bulletins)){  foreach($bulletins as $bulletin){?>
				<a href="index.php?route=help/announcement&id=2&bid=<?php echo $bulletin['bulletin_id'];?>" target="_blank" class="mnNews"><?php echo $bulletin['name'];?></a>
				<?php } } ?>
				<!--<a href="javascript:void(0);" class="mnNews"><label class="mainColor">[活动]</label>新用户晒单送抵扣券。</a>-->
				<a href="account-register.html" target="_blank" class="mnLogin mainBg" title="免费注册">免费注册</a>
				<a href="account-login.html" target="_blank" class="mnLogin mainBg" title="立即登录">立即登录</a>
				<p>使用快捷登录：
					<a href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&redirect_uri=http%3A%2F%2Fwww.acgstorm.com%2Findex.php%3Froute%3Daccount%2Flogin%2Flogin_weibo&response_type=code" class="xinlang" title="使用新浪登录"></a>
					<a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100360874&state=9175e816623b111ddb36e19d2b07783d&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq" class="qq" title="使用QQ登录"></a>
					<a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc77f5c41a5df661b&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_wx&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect" class="weixin" title="微信登陆"></a>
				</p>
			</div>
		</div>
	</div>
	<!--banner]]-->

	<div class="wrap">
		<div class="mallThemeArea">
			<a href="/index.php?route=product/sort&parent_id=201" title="">
				<img src="images/site/mall/mall_01.jpg" width="398" height="180" alt="家乡风味"/>
			</a>
			<a href="account-register.html" title="">
				<img src="images/site/mall/mall_02.jpg" width="398" height="180" alt="领豪礼，抢先注册"/>
			</a>
			<a href="/index.php?route=product/sort&parent_id=233" title="">
				<img src="images/site/mall/mall_03.jpg" width="398" height="180" alt="活动达人"/>
			</a>
			<a href="/index.php?route=product/sort&parent_id=212" title="">
				<img src="images/site/mall/mall_04.jpg" width="398" height="180" alt="开运风水"/>
			</a>
			<a href="/index.php?route=product/sort&parent_id=222" title="">
				<img src="images/site/mall/mall_05.jpg" width="398" height="180" alt="礼品馈赠"/>
			</a>
			<a href="/index.php?route=product/sort&parent_id=63" title="">
				<img src="images/site/mall/mall_06.jpg" width="398" height="180" alt="生活居家"/>
			</a>
		</div>
	</div>

	<!--推荐产品列表[[-->
	<div class="mrtconts">
		<?php for ($j=0;$j<count($categoryids);$j++){  ?>
		<div class="mallRecommendation" data-slide="<?php echo $j+1;?>">
			<div class="mrTops mrtBorColor<?php echo $j+1;?>">
				<h3 class="mrtFontColor<?php echo $j+1;?> fl"><?php echo $j+1; ?>F <?php echo $categoryids[$j]['name']; ?></h3>
				<a href="index.php?route=product/sort&parent_id=<?php echo $categoryids[$j]['category_id'];?>" target="_blank" class="fr" title="更多">更多</a>
			</div>
			<ul class="mrLists" id="mrlfLiColor<?php echo $j+1;?>">
				<li>
					<a href="index.php?route=product/sort&parent_id=<?php echo $categoryids[$j]['category_id'];?>" target="_blank">
						<img src="images/site/mall/mall_pro0<?php echo $j+1;?>.jpg" width="240" height="300" alt=""/>
					</a>
				</li>
				<?php foreach ($products_categoryid_info as $product_categoryid_info) {   
				 if($categoryids[$j]['category_id'] == $product_categoryid_info['category_product_id']) { ?>   
				<li>
					<div class="mrlItems">
						<a href="<?php echo $product_categoryid_info['href'];?>" target="_blank"><img src="<?php echo 'image/'.$product_categoryid_info['thumb']; ?>" width="222" height="222" alt="<?php echo $product_categoryid_info['name']; ?>" onerror="javascript:this.src='/image/product/no_image.jpg';"/></a>
						<a href="<?php echo $product_categoryid_info['href'];?>" target="_blank"><?php echo $product_categoryid_info['name']; ?></a>
						<p class="mrliPrices"><em class="mainColor">¥<?php echo $product_categoryid_info['price']; ?></em></p>
					</div>
				</li>
				<?php } } ?> 
			</ul>
		</div>
		<?php }?>
		<!--楼层快捷键[[-->
		<ul class="mallFloors" id="mfLists">
			<?php for ($j=0;$j<count($categoryids);$j++){  ?>
			<li>
				<a href="javascript:void(0);" data-slide="<?php echo $j+1;?>" <?php if($j==1){?>class="on"<?php } ?>>
					<label class="mflNums"><?php echo $j+1;?>F</label>
					<label class="mflChars"><?php echo $categoryids[$j]['name']; ?></label>
				</a>
			</li>
			<?php }?>
		</ul>
		<!--楼层快捷键]]-->
	</div>
	<!--推荐产品列表]]-->

	<div class="mTrys">
		<div class="wrap">
			<h2 class="tryNotice">欢迎来到CNstorm，身在海外，轻松代购全中国。</h2>
			<a class="tryBtn" target="_blank" href="/newbie.html">立即体验</a></div>
		</div>
	</div>
</div>
<?php echo $footer;?>
</body>
</html>