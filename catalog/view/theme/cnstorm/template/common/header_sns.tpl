<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html"; charset="UTF-8" />
<meta name="apple-itunes-app" content="app-id=914402588" />
<link rel="canonical" href="http://www.acgstorm.com/">
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/sns_header.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/sns.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/footer.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/banner/banner.css"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/jquery2/main.js"></script>
<script src="catalog/view/javascript/jquery2/jquery.elevatezoom.js"></script>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<script src="catalog/view/javascript/jquery2/account.js"></script>
<script src="catalog/view/javascript/jquery2/sns.js"></script>
<script src="catalog/view/javascript/jquery2/jquery-banner.js"></script>
<title>晒尔社区</title>
<!--Begin Comm100 Live Chat Code-->
<script type='text/javascript'>
    //顶部banner关闭
    function cls_banner() {
        $(".stu_verify").slideUp();
        //clearTimeout(change_bnnr);
    }
    /*学生认证头部banner
    var c_bn = 1;
    var change_bnnr;
    var cba_3='index.php?route=special/1212';
    var cba_4='special-student.html'
    var cba_1='index.php?route=social/social';
    var cba_2='index.php?route=special/newyear';
    $('.stu_verify').hover(function(){
      clearInterval(change_bnnr);
    },function(){
      change_bnnr = setInterval("change_bn()",2000);
    })
    function change_bn(){
         if(c_bn==1){
             $('.stu_verify').css({background:"url('images/special/dual11/dual12_entrance.jpg') center no-repeat"});
             $('.change_banner_href').attr({href:cba_3});c_bn++; 
         }else if(c_bn==1){
             $('.stu_verify').css({background:"url('catalog/view/theme/cnstorm/images/banner_sm_3.jpg') center no-repeat"});
             $('.change_banner_href').attr({href:cba_4});c_bn++;
         } else if(c_bn==2){
             $('.stu_verify').css({background:"url('images/special/dual11/dual11_main_entrance.png') center no-repeat"});
             $('.change_banner_href').attr({href:cba_2});c_bn=1; 
         }
         change_bnnr = setTimeout("change_bn()",2000);           
    }
if (document.all){window.attachEvent("onload", function(){change_bn});}//IE
else{window.addEventListener('load',change_bn,false);}
*/
</script>

<!--End Comm100 Live Chat Code-->
</head>

<body onload="change_bn()">
        <div class="view-div-bg"></div>
        <div class="view-oneImage-div-bg"></div>
        <div class="view-video-div-bg"></div>
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
    <ul>
      <li class="on" data-href="/index.php?route=product/snatch">代购</li>
      <li class="mid" data-href="/index.php?route=order/snatch">自助购</li>
      <li data-href="/index.php?route=order/make/order_daiji">代寄</li>
      <li data-href="/index.php?route=product/search">站内搜索</li>
    </ul>
    <input type="button" class="schBtn fr" id="button-search" value="我要代购" />
    <input id="search" class="schText" x-webkit-speech="" placeholder="粘贴您想购买的中国购物网站的商品地址"  type="text">
  </div>
  <div class="barCart pab" id="shopCart">
    <div class="barBox fs4"> <em class="fr" id="cartCount"><?php echo $count; ?></em> <span class="pre fl"><i class="b pab"></i><a href="<?php echo $shopping_cart; ?>" rel="nofollow">购物车</a></span> </div>
    <?php if (!$logged) { ?>
    <div class="cartBox pab none" style="display:none"> <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4" >查看购物车中商品，赶快登录吧！</p>
    </div>
    <?php } else { ?>
    <?php if(!$flag) { ?>
    <div class="cartBox pab none" > <span class="space pab"></span> <b class="triangle b pab"></b>
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
    <!--li><a href="<?php echo $favorite; ?>" rel="nofollow">推荐购</a></li>li-->
    <li><a href="<?php echo $social; ?>" rel="nofollow">晒尔<span class="new_nav"></span></a></li>
    <li><a href="<?php echo $freight; ?>" rel="nofollow">国际运费</a></li>
    <li><a href="<?php echo $newbie; ?>" rel="nofollow">新手教学</a></li>
    <li><a href="<?php echo $comments; ?>" rel="nofollow">用户评价</a></li>
  </ul>
</div>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/normalize.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<script src="catalog/view/javascript/pl/js/snap.svg-min.js"></script>