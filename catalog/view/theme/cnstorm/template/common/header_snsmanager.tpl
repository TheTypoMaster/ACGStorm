<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="canonical" href="http://www.acgstorm.com/">
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/comment.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/header.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/footer.css"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/jquery2/main.js"></script>
<script src="catalog/view/javascript/jquery2/sns.js"></script>

<!--Begin Comm100 Live Chat Code-->
<script type="text/javascript">
    var Comm100API=Comm100API||{chat_buttons:[]};
    Comm100API.chat_buttons.push({code_plan:2633,div_id:'comm100-button-2633'});
	Comm100API.site_id=121670;Comm100API.main_code_plan=2633;
    (function(){
        var lc=document.createElement('script'); 
        lc.type='text/javascript';lc.async=true;
        lc.src='https://chatserver.comm100.com/livechat.ashx?siteId='+Comm100API.site_id;
        var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(lc,s);
    })();
</script>
<style>
    .nav{}
    .nav li a{padding:0 40px;}
    .search{left:519px}
</style>
<!--End Comm100 Live Chat Code-->

</head>

<body>
        <div class="view-div-bg">
        </div>
<div id="stu_verify">
   <a href="<?php echo $student;?>" target='_blank'>
    
   </a>
     <span onclick='noAd()'></span>
</div>
<div class="topbar">
  <div class="wrap fs2">
    <div class="fl"> <span class="WLto">欢迎莅临CNstorm！</span><a class="online b" id="comm100-button-2633" href="#">在线客服</a> </div>
    <div class="fr"> <span>
      <?php if (!$logged) { ?>
      <a href="<?php echo $login;?>" rel="nofollow">登录</a></span><i class="long">|</i><a href="<?php echo $register;?>" rel="nofollow">注册</a>
      <?php } else { ?>
      <?php echo $text_logged; ?>
      <?php } ?>
      <!--<a href="#">登录</a></span><i class="long">
    |</i><a href="#">注册</a><i class="long">--> 
      
      <i class="long">|</i><a href="<?php echo $order;?>">用户中心</a> <i class="long">|</i> <span class="tools pre"> <span class="sublink pab none"><a href="<?php echo $freight;?>">物流运费</a><a href="<?php echo $populartools;?>&id=2">包裹查询</a><a href="<?php echo $populartools;?>">费用估算</a><a href="<?php echo $populartools;?>&id=3">尺码换算</a></span><span class="intool pre dik">常用工具<b class="b pab"></b></span> </span><i class="long">|</i> <a href="<?php echo $help;?>">帮助中心</a>
      <i class="long">|</i><a href="javascript:translatePage();" id="translateLink">繁體</a><i class="long">|</i><a target="_blank" href="index.php?route=app/appload" class="app_down"><span class="ico_app_down"></span><span class="QR_app_down"></span>手机客户端</a></div>
  </div>
</div>
<div class="logoWrap wrap pre"> <a class="logo b dk thid" href="<?php echo $home; ?>" rel="nofollow">时尚便捷的留学生及华人购物服务平台</a>
  <div class="search pab">
    <input type="button" class="schBtn fr" id="button-search" value="我要代购" />
    <input id="search" class="schText" x-webkit-speech="" placeholder="粘贴您想购买的中国购物网站的商品地址"  type="text">
  </div>
  <div class="barCart pab" id="shopCart">
    <div class="barBox fs4"> <em class="fr" id="cartCount"><?php echo $count; ?></em> <span class="pre fl"><i class="b pab"></i><a href="<?php echo $shopping_cart; ?>" rel="nofollow">购物车</a></span> </div>
    <?php if (!$logged) { ?>
    <div class="cartBox pab none"> <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4">查看购物车中商品，赶快登录吧！</p>
    </div>
    <?php } else { ?>
    <?php if(!$flag) { ?>
    <div class="cartBox pab none"> <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4">购物车中还没有商品，赶快选购吧！</p>
    </div>
    <?php }else{ ?>
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
        <dl>
          <dt>共计<b><?php echo $count; ?></b>件产品</dt>
          <dd>合计：<b>￥<?php echo $totalprice; ?></b></dd>
        </dl>
        <span class="settle_accounts"><a class="btn" href="<?php echo $shopping_cart; ?>">去购物车结算</a></span> </li>
    </ul>
    <?php }} ?>
  </div>
</div>
<div class="nav">
  <ul class="wrap fs6">
    <li><a href="<?php echo $home; ?>" rel="nofollow">首页</a></li>
    <li><a href="<?php echo $procurement; ?>" rel="nofollow">代购</a></li>
    <li><a href="<?php echo $selfshopping; ?>" rel="nofollow">自助购</a></li>
    <li><a href="<?php echo $express; ?>" rel="nofollow">国际速递</a></li>
    <li><a href="<?php echo $favorite; ?>" rel="nofollow">推荐购</a></li>
    <li><a href="<?php echo $social; ?>" rel="nofollow">晒尔<span class="new_nav"></span></a></li>
    <li><a href="<?php echo $freight; ?>" rel="nofollow">国际运费</a></li>
    <li><a href="<?php echo $newbie; ?>" rel="nofollow">新手教学</a></li>
    <li><a href="<?php echo $comments; ?>" rel="nofollow">用户评价</a></li>
  </ul>
</div>
