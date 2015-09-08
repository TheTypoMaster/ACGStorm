<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="UTF-8" />
<meta name="apple-itunes-app" content="app-id=914402588" />
<meta property="wb:webmaster" content="e864759f92e3d23f" />
<link rel="canonical" href="http://www.acgstorm.com/">
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-header.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-other.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-footer-page.css"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/jquery2/main.js"></script>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<style type="text/css">
.search ul { position: absolute; top: -28px; left: -2px; }
.search ul li { float: left; padding: 4px 12px; /*border: 2px solid #fb6e52; border-radius: 4px;*/ border-bottom: 0; color: gray; }
.search ul li.on, .search ul li:hover { color: white; background: #fb6e52; }
.search ul li.mid { border-left: 0; border-right: 0; }
.end p{text-align:right;font-szie:14px;font-weight:bold }
</style>
</head>

<body>
<div class="view-div-bg"></div>
<div class="order_cover_bg"></div>
<div class="topbar">
  <div class="wrap fs2" style="position:relative;overflow:visible;">
    <div class="fl" style="position: relative"> <span class="WLto">欢迎莅临CNstorm！</span><a class="online b" href="/help.html">联系客服</a>
      <div class="order_cover" signtip="<?php if (isset($signtip)) echo $signtip; ?>"  style="position: absolute;z-index:1000000;left:665px;top:135px;display:none"> <img src="catalog/view/theme/cnstorm/images/order/user_center_covar.png"/>
        <div class="close_order_cover" style="position:absolute;width:60px;height: 25px;cursor:pointer;top:100px;left:550px;"></div>
      </div>
    </div>
    <div class="fr">
      <?php if (!$logged) { ?>
      <a href="<?php echo $login;?>" rel="nofollow">登录</a></span><i class="long">|</i><a href="<?php echo $register;?>" rel="nofollow">注册</a>
      <?php } else { ?>
      <?php echo $text_logged; ?>
      <?php } ?>
      <!--<a href="#">登录</a></span><i class="long">
    |</i><a href="#">注册</a><i class="long">--><i class="long">|</i>
	  <a href="<?php echo $order;?>">用户中心</a><i class="long">|</i>
	  <span class="tools pre">
		<span class="sublink pab none">
			<a href="<?php echo $freight;?>">物流运费</a>
			<a href="<?php echo $populartools;?>&id=12">包裹查询</a>
			<a href="<?php echo $populartools;?>&id=10">费用估算</a>
			<a href="<?php echo $populartools;?>&id=9">尺码换算</a>
			<a href="<?php echo $populartools;?>&id=4">代购助手</a>
		</span>
		<span class="intool pre dik">常用工具<b class="b pab"></b></span>
	  </span><i class="long">|</i>
	  <a href="<?php echo $help;?>">帮助中心</a><i class="long">|</i>
	  <a href="javascript:translatePage();" id="translateLink">繁體</a><i class="long">|</i>
	  <a target="_blank" href="index.php?route=app/appload" class="app_down"><span class="ico_app_down"></span><span class="QR_app_down"></span>手机客户端</a><i class="long">|</i>
	  <a target="_blank" href="index.php?route=business/main">商户版</a><i class="long">|</i>
	  <a href="javascript:void(0);" class="map_menu_title">网站导航</a>
		<div class="website_navigation">
			<span class="webnav_close_icon">&times;</span>
			<div class="webnav_boxs menu_boxs1">
				<h4 class="webnav_title">综合电商</h4>
				<ul class="webnav_lists">
					<li>
						<a href="www.acgstorm.com" target="_blank">CNstorm商城<span class="hot_icon"></span></a>
					</li>
					<li>
						<a href="http://www.taobao.com" target="_blank" rel="nofollow">淘宝网</a>
					</li>
					<li>
						<a href="http://www.jd.com" target="_blank" rel="nofollow">京东商城</a>
					</li>
					<li>
						<a href="http://www.tmall.com" target="_blank" rel="nofollow">天猫</a>
					</li>
					<li>
						<a href="http://www.suning.com/" target="_blank" rel="nofollow">苏宁易购</a>
					</li>
					<li>
						<a href="http://www.1688.com" target="_blank" rel="nofollow">阿里巴巴</a>
					</li>
					<li>
						<a href="http://www.z.cn" target="_blank" rel="nofollow">亚马逊</a>
					</li>
					<li>
						<a href="http://www.yhd.com" target="_blank" rel="nofollow">1号店</a>
					</li>
					<li>
						<a href="http://www.dangdang.com" target="_blank" rel="nofollow">当当网</a>
					</li>
				</ul>
			</div>
			<div class="webnav_boxs menu_boxs2">
				<h4 class="webnav_title">服装服饰</h4>
				<ul class="webnav_lists">
					<li>
						<a href="http://www.vip.com" target="_blank" rel="nofollow">唯品会</a>
					</li>
					<li>
						<a href="http://www.moonbasa.com" target="_blank" rel="nofollow">梦芭莎</a>
					</li>
					<li>
						<a href="http://www.fclub.cn" target="_blank" rel="nofollow">聚尚网</a>
					</li>
					<li>
						<a href="http://www.shishangqiyi.com" target="_blank" rel="nofollow">时尚起义</a>
					</li>
					<li>
						<a href="http://www.xiu.com" target="_blank" rel="nofollow">走秀网</a>
					</li>
					<li>
						<a href="http://www.lamiu.com" target="_blank" rel="nofollow">兰缪</a>
					</li>
					<li>
						<a href="http://www.mogujie.com" target="_blank" rel="nofollow">蘑菇街</a>
					</li>
					<li>
						<a href="http://www.meilishuo.com" target="_blank" rel="nofollow">美丽说</a>
					</li>
				</ul>
			</div>
			<div class="webnav_boxs menu_boxs3">
				<h4 class="webnav_title">特色美食</h4>
				<ul class="webnav_lists">
					<li>
						<a href="index.php?route=product/sort&parent_id=201" target="_blank" rel="nofollow">家乡风味</a>
					</li>
					<li>
						<a href="http://www.tangtangwu.cn" target="_blank" rel="nofollow">糖糖屋</a>
					</li>
					<li>
						<a href="http://www.morefood.com" target="_blank" rel="nofollow">猫诚食品</a>
					</li>
					<li>
						<a href="http://gz.womai.com" target="_blank" rel="nofollow">我买网</a>
					</li>
					<li>
						<a href="http://www.lingshikong.com" target="_blank" rel="nofollow">零食控</a>
					</li>
				</ul>
			</div>
			<div class="webnav_boxs menu_boxs4">
				<h4 class="webnav_title">礼品馈赠</h4>
				<ul class="webnav_lists">
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=229" target="_blank">办公文具</a>
					</li>
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=223" target="_blank">国粹文化</a>
					</li>
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=225" target="_blank">游戏动漫<span class="new_icon"></span></a>
					</li>
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=227" target="_blank">潮流装扮</a>
					</li>
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=224" target="_blank">装饰摆设</a>
					</li>
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=228" target="_blank">美容健康</a>
					</li>
					<li>
						<a href="index.php?route=product/sort&parent_id=222&category_id=226" target="_blank">电子数码</a>
					</li>
				</ul>
			</div>
		</div>

	</div>
  </div>
</div>
<div class="logoWrap wrap pre"> <a class="logo b dk thid" href="<?php echo $home; ?>" rel="nofollow">时尚便捷的留学生及华人购物服务平台</a>
  <div class="search pab">
    <ul id="searchUl">
      <li class="on" data-href="/index.php?route=product/snatch">代购</li>
	  
      <!--li class="mid" data-href="/index.php?route=order/snatch">自助购</li-->
      <li class="mid" data-href="/index.php?route=product/zzg_snatch">自助购</li>
	  
      <li data-href="/index.php?route=order/make/order_daiji">代寄</li>
      <li data-href="/index.php?route=product/search">站内搜索</li>
    </ul>
    <input type="button" class="schBtn fr" id="button-search" value="我要代购" />
    <input id="search" class="schText" x-webkit-speech="" placeholder="粘贴您想购买的中国购物网站的商品地址"  type="text">
  </div>
  <div class="barCart pab" id="shopCart">
    <div class="barBox fs4"> <em class="fr" id="cartCount"><?php echo $count; ?></em> <span class="pre fl"><i class="b pab"></i><a href="<?php echo $shopping_cart; ?>" rel="nofollow">购物车</a></span> </div>
    <?php if(!$flag) { ?>
    <div class="cartBox pab none"> <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4">购物车中还没有商品，赶快选购吧！</p>
    </div>
    <?php }else{ ?>
    <!--购物车-->
    <ul class="gwcBox pab none">
      <li><b class="triangle b pab"></b></li>
      <?php foreach($products as $product) { ?>
      <li class="line"> <img src="<?php echo $product['thumb']; ?>" alt="缩略图" />
        <dl>
          <dt><a href="javscript:void(0);"><?php echo $product['name']; ?></a></dt>
          <dd>￥<b><?php echo $product['price']; ?></b><em>x</em><b><?php echo $product['quantity']; ?></b></dd>
        </dl>
      </li>
      <?php } ?>
      <li class="end">
        <!--<dl>
          <dt>共计<b><?php echo $count; ?></b>件产品</dt>
          <dd>合计：<b>￥<?php echo $totalprice; ?></b></dd>
        </dl>-->
		<?php if($surplus > 0){ ?>
			<p>购物车里还有<?php echo $surplus; ?>件商品</p>
		<?php } ?>
        <span class="settle_accounts"><a class="btn" href="<?php echo $shopping_cart; ?>">查看我的购物车</a></span> </li>
    </ul>
    
    <?php } ?>
  </div>
</div>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default.css"/>
</html>