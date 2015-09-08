<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/css/service-default.css?v=20150418"/>
</head>
<body>
<?php echo $header2 ?>
<div class="banner">
  <div class="ma1200">
    <div class="us_box">
      <div class="us_box_content">
        <?php if (!$logged) { ?>
        <div class="lg_label"><strong>登陆CNstorm</strong></div>
        <form id="login" action="/index.php?route=account/login" method="post">
          <div class="lg_input">
            <input class="input" type="text" name="email" value="" placeholder="邮箱地址/用户名" autocomplete="OFF">
          </div>
          <div class="lg_input lg_pd">
            <input class="input" type="password" name="password" value="" placeholder="密码" autocomplete="OFF">
          </div>
          <div><span>
            <input type="checkbox" id="auto_login" name="auto_login" value="1">
            记住我</span><span class="fr"><a href="#">忘记密码</a></span> </div>
          <div class="login_btn">
            <input type="submit" value="立即登录">
            <a href="/account-register.html">免费注册</a> </div>
        </form>
        <div class="coperation">
          <dt>使用合作网站账号登录:</dt>
          <dd><a class="xinlang" href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&amp;redirect_uri=http%3A%2F%2Fwww.acgstorm.com%2Findex.php%3Froute%3Daccount%2Flogin%2Flogin_weibo&amp;response_type=code"></a></dd>
          <dd><a class="qq" href="https://graph.qq.com/oauth2.0/authorize?response_type=code&amp;client_id=100360874&amp;state=9175e816623b111ddb36e19d2b07783d&amp;redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq"></a></dd>
        </div>
        <?php } else { ?>
        <div class="lg_label"><strong>欢迎使用CNstorm</strong></div>
        <div class="u_info"><img src="<?php echo $face; ?>" class="fl">
          <div class="u_info_r">
            <p><span><?php echo $text_logged; ?>，上午好~</span><a class="fr" href="/account-logout.html">登出</a></p>
            <a href="/order.html">用户中心</a></div>
        </div>
        <?php } ?>
        <div class="quick-panel">
          <ul class="quick-links">
            <li class="inquire"><a href="/index.php?route=help/populartools&amp;id=12" target="_blank">
              <p></p>
              包裹查询</a></li>
            <li class="cost"><a href="/index.php?route=help/populartools&amp;id=10" target="_blank">
              <p></p>
              费用估算</a></li>
            <li class="size"><a href="/index.php?route=help/populartools&amp;id=9" target="_blank">
              <p></p>
              尺码换算</a></li>
            <li class="tool"><a href="/index.php?route=help/populartools&amp;id=4" target="_blank">
              <p></p>
              代购助手</a></li>
            <li class="help"><a href="/help.html" target="_blank">
              <p></p>
              帮助中心</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="announcement">
  <div class="ma1200">
    <ul class="bottominfo-notice">
      <li>公告：</li>
      <li><a href="index.php?route=help/announcement&amp;id=2&amp;bid=52" target="_blank">【活动】新用户晒单送抵扣券</a></li>
      <li><a href="index.php?route=help/announcement&amp;id=2&amp;bid=58" target="_blank">清明放假公告</a></li>
      <li><a href="index.php?route=help/announcement&amp;id=2&amp;bid=20" target="_blank">社区总版规（试行）</a></li>
      <li><a href="index.php?route=help/announcement&amp;id=2&amp;bid=25" target="_blank">手机app上线，代购新方法！</a></li>
    </ul>
  </div>
</div>
<div class="ma1200">
  <div class="welcome">
    <div class="area">
      <p > <a class="arr-elem" href="/information-comments.html">客户评价<span class="arr-move"><i></i></span></a> </p>
    </div>
  </div>
  <div class="simple_intro">
    <div class="index-left">
      <div class="cns-service">
        <div class="service-tab">
          <ul class="clearfix" id="tab_menu">
            <li class="li-0 on">
              <div class="l-line"></div>
              <a href="###" id="###c-tab-1">代购</a>
              <div class="r-line"></div>
            </li>
            <li class="li-1">
              <div class="l-line"></div>
              <a href="###" id="###c-tab-2">自助购</a>
              <div class="r-line"></div>
            </li>
            <li class="li-2">
              <div class="l-line"></div>
              <a href="###" id="###c-tab-3">国际转运</a>
              <div class="r-line"></div>
            </li>
          </ul>
        </div>
        <div class="detail-tab-body">
          <div id="c-tab" class="service-content">
            <div class="tab-list">
              <div class="title"><span class="title-h">代购：您选商品，我们为您购买，合并打包寄送到海外。</span><a target="_blank" href="/dotbuyservice/" class="ml20">查看详情</a></div>
              <div class="other">
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/1/1.gif"></p>
                  <div class="text">
                    <p class="mt10">使用方法</p>
                    <p class="mt5">提交商品链接并支付</p>
                  </div>
                </div>
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/1/2.gif"></p>
                  <div class="text">
                    <p class="mt10">提供服务</p>
                    <p class="mt5">代购、验货、仓储、邮寄</p>
                  </div>
                </div>
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/1/3.gif"></p>
                  <div class="text">
                    <p class="mt10">支付方式</p>
                    <p class="mt5">Paypal、支付宝、微信、国际信用卡</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="c-tab" class="service-content hide">
            <div class="tab-list">
              <div class="title"><span class="title-h">自助购：您自行网购并寄至cnstorm仓库，我们为您转运至海外。</span><a target="_blank" href="/diybuyservice/" class="ml20">查看详情</a></div>
              <div class="other">
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/2/1.gif"></p>
                  <div class="text">
                    <p class="mt10">使用方法</p>
                    <p class="mt5">自行网购并寄至cnstorm</p>
                  </div>
                </div>
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/2/2.gif"></p>
                  <div class="text">
                    <p class="mt10">提供服务</p>
                    <p class="mt5">收货、验货、仓储、邮寄</p>
                  </div>
                </div>
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/2/3.gif"></p>
                  <div class="text">
                    <p class="mt10">服务特点</p>
                    <p class="mt5">集中打包，邮寄更省钱</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="c-tab" class="service-content hide">
            <div class="tab-list">
              <div class="title"><span class="title-h">转运：您将个人物品通过我们为您转运至海外。</span><a target="_blank" href="/expresservice/" class="ml20">查看详情</a></div>
              <div class="other">
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/3/1.gif"></p>
                  <div class="text">
                    <p class="mt10">使用方法</p>
                    <p class="mt5">通过cnstorm将个人物品寄至海外</p>
                  </div>
                </div>
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/3/2.gif"></p>
                  <div class="text">
                    <p class="mt10">提供服务</p>
                    <p class="mt5">收货、仓储、集中打包邮寄</p>
                  </div>
                </div>
                <div class="other-li">
                  <p class="icon fl"><img src="http://static.cnstorm.com/images/rank/3/3.gif"></p>
                  <div class="text">
                    <p class="mt10">服务特点</p>
                    <p class="mt5">集中打包，邮寄更省钱</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="index_right"><a data-type="3" data-tmpl="320x250" data-tmplid="187" data-rd="2" data-style="2" data-border="1" href="#"></a></div>
  </div>
  <div class="ad_bar"><a href="/social.html" target="_blank"><img src="images/site/index/jpeg.jpg"></a></div>
  <div class="private_box">
    <h3 class="society-title">
      <dt></dt>
      <span style="color: #e61e43;">他们刚买</span><a class="more" href="product-favorite.html" target="_blank"></a>
      <ul class="mall_catagory">
        <a href="index.php?route=product/types&path=59_59" target="_blank">
        <li>潮流服饰</li>
        </a> <a href="index.php?route=product/types&path=60_60" target="_blank">
        <li>精品鞋靴</li>
        </a> <a href="index.php?route=product/types&path=61_61" target="_blank">
        <li>箱包配饰</li>
        </a> <a href="index.php?route=product/types&path=62_62" target="_blank">
        <li>手机数码</li>
        </a> <a href="index.php?route=product/types&path=63_63" target="_blank">
        <li>生活家居</li>
        </a> <span class="bottom-indicator"></span>
      </ul>
    </h3>
    <div class="list_wrap">
      <ul class="product_list">
        <?php if ( isset($products) )  foreach($products as $product) {  ?>
        <li> <a target="_blank" href="<?php echo  $product['producturl'];?>"><img src="<?php if(1 == $product['source']) echo 'image/'.$product['img']; else echo $product['img'] ?>" alt="<?php echo $product['name']; ?>"></a> <a target="_blank" class="introduce" href="<?php echo  $product['producturl'];?>"><?php echo $product['name']; ?></a> <strong class="current_price">￥<b><?php echo $product['price']; ?></b></strong> </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="promotions">
    <h3 class="society-title">优惠资讯<span class="bottom-line"></span></h3>
    <div class="promo_contents">
      <ul>
        <li><img src="http://gtms04.alicdn.com/tps/i4/TB1Q63oHpXXXXayXFXXQO4D5VXX-440-180.jpg"></li>
        <li><img src="http://gtms03.alicdn.com/tps/i3/TB1TTD6HpXXXXcmaXXXuPxD5VXX-440-180.png"></li>
        <li><img src="http://gtms02.alicdn.com/tps/i2/TB1FxshHpXXXXXxXpXXQO4D5VXX-440-180.jpg"></li>
      </ul>
    </div>
  </div>
  <div class="comments">
    <h3 class="society-title">TA们在说<span class="bottom-line"></span></h3>
    <?php foreach ($comments as $comment){ ?>
    <a onClick="seeComment()">
    <div class="user" style="background: #FFF;"> <span class="user_photo">
      <?php if($comment['face']) { ?>
      <img src="<?php echo $comment['face']; ?>" alt="<?php echo $comment['uname']; ?>">
      <?php }else{  ?>
      <img src="uploads/big/0b4a96400b2372d25da769647bfe4059.jpg" alt="<?php echo $comment['uname']; ?>">
      <?php } ?>
      </span>
      <div class="comment_contents">
        <div class="user_infor"> <span class="user_name"><?php echo $comment['uname']; ?></span> <span class="user_city"><?php echo $comment['from']; ?></span></div>
        <p class="user_comment"><?php echo mb_substr($comment['message'],0,38,'utf-8')."...";?></p>
      </div>
    </div>
    </a>
    <?php  } ?>
  </div>
</div>
<script type="text/javascript">
$(function() {
$(".service-tab li").each(function(i){
    $(this).hover(function() {
        $(this).addClass('on').siblings().removeClass('on');
        $(".service-content").eq(i).show().siblings().hide();
    });
    });
 });
    </script> 
<script type="text/javascript">
    (function(win,doc){
        var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0];
        if (!win.alimamatk_show) {
            s.charset = "gbk";
            s.async = true;
            s.src = "http://a.alimama.cn/tkapi.js";
            h.insertBefore(s, h.firstChild);
        };
        var o = {
            pid: "mm_30152379_3454790_11226648",/*推广单元ID，用于区分不同的推广渠道*/
            appkey: "",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/
            unid: "",/*自定义统计字段*/
            type: "click" /* click 组件的入口标志 （使用click组件必设）*/
        };
        win.alimamatk_onload = win.alimamatk_onload || [];
        win.alimamatk_onload.push(o);
    })(window,document);
</script> 
<?php echo $footer ?>