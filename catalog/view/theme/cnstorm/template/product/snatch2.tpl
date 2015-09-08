<?php echo $header_cart ;?>
<title><?php echo $title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<script>
$(function(){
      var url = 'index.php?route=product/snatch/iteminfo&search=<?php echo urlencode($search); ?>';
      $('#item_info').load(url);
      return false;    
});
</script>
<style type="text/css">
.br-steps { margin: 18px; text-align: center; }
.br-steps .step-line { border-top: 1px dashed lightgray; position: absolute; width: 778px; margin: 8px 108px; }
.br-steps .step-list { display: inline-block; }
.br-steps li { float: left; width: 198px; }
.br-steps li.reach { color: #fb6e52; }
.br-steps li.reach .icon-step { border-color: #fb6e52; background: #fb6e52; }
.br-steps li .icon-step { border-radius: 50%; border: 3px solid gray; width: 10px; height: 10px; display: inline-block; background: white; position: relative; }
.br-steps li .step-intro { padding-top: 4px; }
</style>
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center">
      <div class="gwc_steps">
        <div class="gwc_step_one ml10">

<div class="br-steps">
            <span class="step-line"></span>
            <ul class="step-list">
              <li class="step1 reach"> <s class="icon-step"></s>
                <p class="step-intro">提交采购请求</p>
              </li>
              <li class="step2 unreach"> <s class="icon-step"></s>
                <p class="step-intro">供应商采购</p>
              </li>
              <li class="step3 unreach"> <s class="icon-step"></s>
                <p class="step-intro">质检称重入库</p>
              </li>
              <li class="step3 unreach"> <s class="icon-step"></s>
                <p class="step-intro">提交运输请求</p>
              </li>
              <li class="step4 unreach"> <s class="icon-step"></s>
                <p class="step-intro">海外收货</p>
              </li>
            </ul>
          </div>
          <p id="p_imitation" class="msg_tips">温馨提示：如果您购买的商品中含有空运敏感品(如食品、液体、粉末等)，需经由邮政渠道(EMS/AIR)或DHL敏感品渠道发出，如有疑问请<a href="https://chatserver5.comm100.com/chatwindow.aspx?planId=2633&siteId=121670" target="_blank">联系客服</a>咨询。</p>
          <div class="gwc_get_infor ml10">

            <div class="step2">
             <div class="item_cont_r ml10" id="item_info">
             <div style="height:743px;position:relative;"><img src="catalog/view/theme/cnstorm/images/loading_data.gif" alt="正在加载，请稍等……" style="align-content:center;top:80px;left:300px;position:relative;"/></div>
            </div>
<div class="cartBox" style="float:right;" id="cartBox">
                <?php if (!$logged) { ?>
     <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4">查看购物车中商品，赶快登录吧！</p>

    <?php } else { ?>
    <?php if(!$flag) { ?>
     <span class="space pab"></span> <b class="triangle b pab"></b>
      <p class="tips fs4">购物车中还没有商品，赶快选购吧！</p>
    <?php }else{ ?>
    <ul class="gwcBox">
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer ;?> 