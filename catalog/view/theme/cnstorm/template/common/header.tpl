<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="UTF-8" />
<meta name="apple-itunes-app" content="app-id=914402588" />
<meta property="wb:webmaster" content="e864759f92e3d23f" />
<title> <?php echo $meta_title; ?></title>
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name="keywords" content="<?php echo $meta_keyword; ?>">
<link rel="canonical" href="http://www.acgstorm.com/">
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-header.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-logreg.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-other.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default-footer-page.css"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/jquery2/main.js"></script>
<script src="catalog/view/javascript/jquery2/jquery.elevatezoom.js"></script>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<script src="catalog/view/javascript/jquery2/account.js"></script>
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
<style type="text/css">
.white { color: white !important; }
.support { position: relative; margin-top: 71px; }
.support ul li:first-child { padding: 4px 2px; }
.support ul li { padding: 4px 5px; color: #b5b5b5; }
.support ul li a { color: #b5b5b5; }
.support ul li:hover { background: 0; color: #b5b5b5; }
.support ul li a:hover { color: #f40; }
</style>
</head>
<body>
<div class="view-div-bg"></div>
<div class="order_cover_bg"></div>
<div class="topbar">
  <div class="wrap fs2">
    <div class="fl" style="position: relative"> <span class="WLto"><?php echo $text_welcomeTo; ?></span><span class="tools pre"> <span class="sublink pab none"> <a href="<?php echo $freight;?>"><?php echo $text_freightLogistics; ?></a> <a href="<?php echo $populartools;?>&id=12"><?php echo $text_checkParcel; ?></a> <a href="<?php echo $populartools;?>&id=10"><?php echo $text_costEstimating;?></a> <a href="<?php echo $populartools;?>&id=9"><?php echo $text_sizeConversion;?></a> <a href="<?php echo $populartools;?>&id=4"><?php echo $text_PurchasingAssistant;?></a> </span> <span class="intool pre dik"><?php echo $text_commonTools;?> <b class="b pab"></b> </span> </span> 
      <!--
      <a href="<?php if (isset($commented_total)){ echo 'social-snsmanager.html'; }else{ echo 'account-login.html'; } ?>"><?php echo $text_community;?></a>
      < ?php if (isset($commented_total)){ ?>&nbsp;<span style="color:red;">(<?php echo $commented_total; ?>)</span><php } ?--> 
      <i class="long">|</i>
      <?php if ($status == 'cn'){ ?>
      <span class="tools pre"><span class="sublink pab none"><a href="<?php echo $curUrl; ?>&l=1">English</a> </span> <span class="intool pre dik"><a class="intool pre dik" href="javascript:translatePage();" id="translateLink"><?php echo $text_traditional;?></a><b class="b pab"></b></span> </span>
      <?php }else{ ?>
      <span class="tools pre"> <span class="sublink pab none"> <a class="intool pre dik" href="javascript:translatePage();" id="translateLink"><?php echo $text_traditional;?></a></span> <span class="intool pre dik"><a href="<?php echo $curUrl; ?>&l=1">简体中文</a> <b class="b pab"></b> </span> </span>
      <?php } ?>
      <div class="order_cover" signtip="<?php echo $signtip; ?>"  style="position: absolute;z-index:1000000;left:665px;top:135px;display:none"> <img src="catalog/view/theme/cnstorm/images/order/user_center_covar.png"/>
        <div class="close_order_cover" style="position:absolute;width:60px;height: 25px;cursor:pointer;top:100px;left:550px;"></div>
      </div>
    </div>
    <div class="fr"> <span>
      <?php if (!$logged) { ?>
      <a href="<?php echo $login;?>" rel="nofollow"><?php echo $text_login; ?></a></span><i class="long">|</i><a href="<?php echo $register;?>" rel="nofollow"><?php echo $text_register; ?></a>
      <?php } else { ?>
      <?php echo $text_logged; ?> <a href="<?php if (isset($num_webnews)){ echo 'account-webnews.html'; }else{ echo 'account-login.html'; } ?>">新消息</a>
      <?php if (isset($num_webnews)){ ?>
      &nbsp;<span style="color:red;">(<?php echo $num_webnews; ?>)</span>
      <?php } ?>
      <?php } ?>
      <i class="long">|</i> <a href="<?php echo $order;?>"><?php echo $text_userCenter; ?></a> <i class="long">|</i> <a href="<?php echo $help;?>"><?php echo $text_helpCenter;?></a> <i class="long">|</i><a target="_blank" href="index.php?route=app/appload" class="app_down"> <span class="ico_app_down"></span> <span class="QR_app_down"></span><?php echo $text_mobilePhoneClient; ?> </a> <i class="long">|</i> <a href="<?php echo $shopping_cart; ?>" rel="nofollow" target="_blank"><?php echo $text_shopping_cart; ?></a><span style="color:red;" id="shopCart">(<?php echo $count; ?>)</span></div>
  </div>
</div>
<div class="logoWrap wrap pre"> <a class="logo b dk thid" href="<?php echo $home; ?>" rel="nofollow"><?php echo $text_chineseShoppingServicePlatform; ?></a><!-- img src="/images/site/common/h-ny.jpg" style="margin: 18px;" -->
  <div class="search pab">
    <ul id="searchUl">
      <li class="on" data-href="/index.php?route=product/snatch">代购</li>
	  <?php if($customer_id){ ?>
      <li class="mid" data-href="/index.php?route=order/snatch">自助购</li> 
	  <?php }else{ ?>
	   <li class="mid" data-href="/index.php?route=product/zzg_snatch">自助购</li> 
	  <?php } ?>
      <li data-href="/index.php?route=order/make/order_daiji">代寄</li>
      <li data-href="/index.php?route=product/search">站内搜索</li>
    </ul>
    <input type="button" class="schBtn fr" id="button-search" value="<?php echo $text_searchOrOrder; ?>" />
    <input id="search" class="schText" x-webkit-speech="" placeholder="<?php echo $text_pasteShoppingAddress; ?>"  type="text">
    <div class="support">
      <ul style="display: block;width:545px">
        <li>支持商家:</li>
        <li><a target="_blank" rel="nofollow" href="http://www.taobao.com">淘宝</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.tmall.com">天猫</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.yhd.com">1号店</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.vip.com">唯品会</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.z.cn">亚马逊中国</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.jd.com">京东</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.dangdang.com">当当</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.meilishuo.com">美丽说</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.mogujie.com">蘑菇街</a></li>
        <li><a target="_blank" rel="nofollow" href="http://www.1688.com">阿里巴巴</a></li>
      </ul>
    </div>
  </div>
  <div class="h-newbie"><a href=<?php echo $newbie; ?>><img src="images/site/common/header01.png" width="181" height="71" alt="海外如何买国货，1分钟快速了解"></a></div>
  <!-- div class="barCart pab" id="shopCart">
    <div class="barBox fs4"> <em class="fr" id="cartCount"><?php echo $count; ?></em> <span class="pre fl"><i class="b pab"></i><a href="<?php echo $shopping_cart; ?>" rel="nofollow"><?php echo $text_shopping_cart; ?></a></span> </div>
    <?php if (!$logged) { ?>
    <div class="cartBox pab none"> <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4"><?php echo $text_checkCartShopping; ?></p>
    </div>
    <?php } else { ?>
    <?php if(!$flag) { ?>
    <div class="cartBox pab none"> <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4"><?php echo $text_quickShopping; ?></p>
    </div>
    <?php }else{ ?>
    <ul class="gwcBox pab none">
      <li><b class="triangle b pab"></b></li>
      <?php foreach($products as $product) { ?>
      <li class="line"> <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $text_thumb; ?>" />
        <dl>
          <dt><a href="javscript:void(0);"><?php echo $product['name']; ?></a></dt>
          <dd>￥<b><?php echo $product['price']; ?></b><em>x</em><b><?php echo $product['quantity']; ?></b></dd>
        </dl>
      </li>
      <?php } ?>
      <li class="end">
        <dl>
          <dt><?php echo $text_total; ?><b><?php echo $count; ?></b><?php echo $text_productes; ?></dt>
          <dd><?php echo $text_total; ?><b>￥<?php echo $totalprice; ?></b></dd>
        </dl>
        <span class="settle_accounts"><a class="btn" href="<?php echo $shopping_cart; ?>"><?php echo $text_goCart; ?></a></span> </li>
    </ul>
    <?php }} ?>
  </div --> 
</div>
<div class="nav">
  <ul class="wrap fs6">
    <li><a href="<?php echo $home; ?>">首页</a></li>
    <li><a href="<?php echo $procurement; ?>">服务与价格</a></li>
    <span class="sub_nav"> <a href="<?php echo $procurement; ?>">代购</a> <a href="<?php echo $selfshopping; ?>">自助购</a> <a href="<?php echo $express; ?>" style="border-right:0;">国际转运</a></span>
    <!--li><a href="<?php echo $favorite; ?>">推荐购</a></li>li-->
    <!--li><a href="<?php echo $cosplay; ?>">Cosplay</a></li-->
    <li><a href="social.html">晒尔社区<span class="new_nav"></span></a></li>
    <li><a href="<?php echo $freight; ?>">国际运费</a></li>
    <li><a href="<?php echo $comments; ?>">用户评价</a></li>
    <li><a href="/index.php?route=business/main" class="nav_hot" target="_blank">商户版<span class="hot_nav"></span></a></li>
  </ul>
</div>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default.css"/>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/normalize.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<script src="catalog/view/javascript/pl/js/snap.svg-min.js"></script>
