<script src="catalog/view/javascript/jquery2/orderlist.js"></script> 
<style type="text/css">.global-subheader, .i-banner, .uc-main { min-width: 1200px; } </style>
<div class="global-subheader">
  <ul class="wrap global-subnav">
    <li class='global-subnav-item'> <a href="<?php echo $order_one; ?>">账户首页</a> </li>
    <li <?php if ($make == $currentUrl) echo "class='global-subnav-item-current global-subnav-item'";else echo "class='global-subnav-item'"; ?>> <a href="<?php echo $make; ?>">下单</a> </li>
    <li <?php if ($order_one == $currentUrl || $order_two == $currentUrl || $order_three == $currentUrl || $storage == $currentUrl) echo "class='global-subnav-item-current global-subnav-item'";else echo "class='global-subnav-item'"; ?>> <a href="order.html">订单&物流</a> </li>
    <li <?php if ($msg == $currentUrl) echo "class='global-subnav-item-current global-subnav-item'";else echo "class='global-subnav-item'"; ?>> <a href="account-webnews.html">消息&咨询</a> </li>
    <li <?php if ($account == $currentUrl) echo "class='global-subnav-item-current global-subnav-item'";else echo "class='global-subnav-item'"; ?>> <a href="index.php?route=account/edit">账户管理</a> </li>
	<li class="global-subnav-item"><a href="www.acgstorm.com" title="商城">商城&nbsp;<span class="mall_hot">hot<span></a></li>
  </ul>
</div>
<div class="i-banner">
  <div class="i-banner-message"> <a id="J-portal-message" class="message-entrance" href="https://couriercore.alipay.com/messager/new.htm" target="_blank" title="点击展开消息" > <i class="iconfont message-back" title="点击展开消息"></i> <span class="message-fore"> <i class="iconfont"></i> <span class="message-count">5</span> </span> </a> </div>
  <div class="i-banner-content wrap">
    <div class="i-banner-portrait fn-left">
	<a href="account-edit.html&amp;id=2">
	<img src="<?php echo $face; ?>" onerror="javascript:this.src='uploads/big/8e29b70d15afde06f19b45c76906a693.jpg';" alt="头像">
	<span class="change_photos"></span><em>修改头像</em></a></div>
    <div class="i-banner-main">
      <p> <span><?php echo $time_name;?>, <a href="#" target="_blank" title="<?php echo $customer_name;?>"><?php echo $customer_name;?></a> </span>喝杯茶吧，让精神抖擞起来 </p>
      <p> 邮箱： <a href="#" target="_blank" title="<?php echo $customer_email;?>"><?php echo $customer_email;?></a> <i>|</i> 余额：￥
        <?php if (isset($money)) echo $money; ?>
        <a class="userInfo-balance" href="index.php?route=account/rmbaccount/onlinecharge" target="_blank">充值</a> <!-- i>|</i> 上次登录时间：2014.12.05 14:47:38 --></p>
    </div>
  </div>
</div>
<div class="uc-main">
  <div class="wrap">
    <div class="nav-left">
      <div class="menu-postbr"> <a class="ui-button" href="order-make.html">立即下单</a>
        <p class="assist-marketing first"><em>海量</em> 中国商户任您选</p>
        <p class="assist-marketing"><em>1</em> 分钟完成下单</p>
      </div>
      <div class="menu-postbr">
		<ul>
			<h3>订单管理</h3>
			<li <?php if ($order_one == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $order_one; ?>">代采购订单</a> </li>
			<li <?php if ($order_two == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $order_two; ?>">自采购订单</a> </li>
			<li <?php if ($order_three == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $order_three; ?>">代邮寄订单</a> </li>
			
				
			<li	<?php if (strpos($currentUrl,"order-order-cosplaymall.html")!==false){ echo 'class="current"';} ?>><a href="order-order-cosplaymall.html">商城订单</a></li>
			<li <?php if ($storage == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $storage; ?>">可邮寄订单</a> </li>
			<li <?php if ($wishlist == $currentUrl) echo "class='current'"; ?>> <a href="/account-wishlist.html">已收藏商品</a> </li>
			<li <?php if ($cancel == $currentUrl) echo "class='current'"; ?>> <a href="/order-cancel.html">待取消订单</a> </li>
		</ul>
      </div>
      <div class="menu-postbr">
        <ul>
          <h3>运单管理</h3>
          <li <?php if ($sendorder == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $sendorder; ?>">所有运单</a> </li>
		   <li <?php if ($cancelso == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $cancelso; ?>">待取消运单</a> </li>
          <li <?php if ($address == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $address; ?>">收货地址簿</a> </li>
		  
        </ul>
      </div>
      <div class="menu-postbr">
        <ul>
          <h3>消息咨询</h3>
          <li <?php if ($msg == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $msg; ?>">站内消息</a> </li>
          <li <?php if ($advisory == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $advisory; ?>">客服咨询</a> </li>
        </ul>
      </div>
      <div class="menu-postbr">
        <ul>
          <h3>账户管理</h3>
          <li <?php if ($account == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $account; ?>">账户资料</a> </li>
          <li <?php if ($rmbaccount == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $rmbaccount; ?>">充值记录</a> </li>
          <li <?php if ($expense == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $expense; ?>">消费记录</a> </li>
          <li <?php if ($coupons == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $coupons; ?>">我的优惠券</a> </li>
          <li <?php if ($scorerecord == $currentUrl) echo "class='current'"; ?>> <a href="<?php echo $scorerecord; ?>">我的积分</a> </li>
        </ul>
      </div>
	  

	  <div class="menu-postbr">
        <ul>
          <h3>邀请好友</h3>
          <li>
			<a href="account-promoter.html" title="邀请规则">邀请规则</a>
		  </li>
          <li>
			<a href="account-promoter-reward.html" title="奖励详情">奖励详情</a>
		  </li>
          <li class="showOrder">
			<a href="javascript:void(0);" title="奖励提现"><i class="tabFuhao">+</i>奖励提现</a>
		  </li>
		  <div class="tabShoporder">
			<a href="account-promoter-cashalipay.html">提现到支付宝</a>
			<a href="account-promoter-cashpaypal.html">提现到Paypal</a>
		  </div>
		    <li class="showOrder">
			<a href="javascript:void(0);" title="添加提现方式"><i class="tabFuhao">+</i>添加提现方式</a>
		  </li>
		  <div class="tabShoporder">
			<a href="account-promoter-addalipay.html">支付宝</a>
			<a href="account-promoter-addpaypal.html">Paypal</a>
		  </div>
          <li>
			<a href="account-promoter-withdraw.html" title="提现查询">提现查询</a>
		  </li>
        </ul>
      </div>
	 
	  <!--
	  <div class="menu-postbr">
        <ul>
          <h3>我的会员</h3>
          <li>
			<a href="account-member.html" title="会员介绍">会员介绍</a>
		  </li>
          <li>
			<a href="account-member-task.html" title="我的任务">我的任务</a>
		  </li>
        </ul>
      </div>
	  -->
    </div>
    <script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script> 
<script type="text/javascript">
  $(function(){
    $(document).on('click','.pages_change ul li a',function(){
      var loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 400, easingIn : mina.easeinout } );
      var url = $(this).attr('href');
      loader.show();
      window.scrollTo(0,475);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
          loader.hide();
          setTimeout(function(){$('#dvContent').html(data);}, 500);
        }
      });
      return false;
    });
	
	/*用户中心菜单加个商城订单导航下拉菜单 CNstorm商城 COSPLAY商城*/
	$(".showOrder").click(function(){
		$(this).next("div.tabShoporder").toggle();
		if($(this).next("div.tabShoporder").css("display")=="none"){
			$(this).find(".tabFuhao").text("+");
		}else{
			$(this).find(".tabFuhao").text("-");
		}
	});
});
</script>