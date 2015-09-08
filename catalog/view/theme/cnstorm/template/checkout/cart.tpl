<?php echo $header_cart ;?>
<title>CNstorm代购购物车-简单提交代购商品到购物车</title>
<meta name="keywords" content="购物车，代购商品，提交购物车，代购结算，淘宝购物车" />
<meta name="description" content="身在海外，只需添加代购或自助购商品到您的购物车，CNstorm代购平台为你搞定一切"/>
<script  src="catalog/view/javascript/jquery2/ToolTip.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<script  src="catalog/view/javascript/jquery2/global.js"></script>
<script  src="catalog/view/javascript/jquery2/cart.js"></script>
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
          <div style="padding: 5px 10px;border: 1px solid #f9dfb2;margin: 10px 0 10px 18px;background: #ffffe0;float: left;width: 1138px;text-align: center;"> <strong>温馨提示：</strong>购物车的商品提交结算成功以后，会先寄送到CNstorm(深圳)的中转中心，进入您的<a href="/order-order-order_myhome.html" target="_blank" style="color:#0078b6;">专属仓库</a>，再由您自由组合选择寄送至您的海外地址。 </div>
          <form id='makeorder' action="<?php echo $action; ?>" method="post" >
            <div class="gwc_goods">
            <div class="buy_it">
              <div class="header">
                <div class="h_chk">
                  <div class="bi_checkall">
                    <input id="SelectAll" type="checkbox" value="true" name="SelectAll" class="check-all check"/>
                    <label for="SelectAll"> 全选 </label>全选
				  </div>
                </div>
                <div class="h_item"> 商品名称 </div>
                <div class="h_price"> 单价(元) </div>
                <div class="h_amount"> 数量 </div>
                <div class="h_total"> 小计(元) </div>
                <div class="h_ope"> 操作 </div>
              </div>
              <?php if ($cart_count == 0) { ?>
              <div class="pls_shop">来都来了，不买点什么吗？</div>
            <?php } else { $i=0 ; foreach ($storenamearray as $storeurl=>$val) { ?>
              <div class="shops_s ml10" id="<?php echo "shops_s".$i++;?>" >
                <div class="shop_name">
                  <div class="shop_checkbox">
                    <input class="shop_check check" id="shop_check_<?php echo $i; ?>" type="checkbox" name="orders" />
                    <label for="shop_check_<?php echo $i; ?>"> </label>
                  </div>
                  <p class="shop_admin"> 店铺： <a target="_blank" href="<?php echo $val['storeurl'];?>">
                    <?php if(strpos($val['storeurl'], '1688')) { ?>
                    <span class="sho_n albb"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'taobao')) { ?>
                    <span class="sho_n taobao"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'tmall')) { ?>
                    <span class="sho_n tmall"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'jd')) { ?>
                    <span class="sho_n jd"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'dangdang')) { ?>
                    <span class="sho_n dangdang"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'amazon')) { ?>
                    <span class="sho_n amazon"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'mogujie')) { ?>
                    <span class="sho_n mogujie"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'meilishuo')) { ?>
                    <span class="sho_n meilishuo"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'vip')) { ?>
                    <span class="sho_n vipcom"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'jumei')) { ?>
                    <span class="sho_n jumei"> <?php echo $val['storename']; ?> </span>
                    <?php }elseif(strpos($val['storeurl'], 'product-mall.html')!==false) { ?>
                    <span class="sho_n unknown"><?php echo $val['storename']; ?></span>
                    <?php }else{ ?>
                    <span class="sho_n unknown">Cosplay商城</span>
                    <?php } ?>
                    </a> 运费：￥ <span class="postAge_s"> </span> </p>
                </div>
                <div class="contents">
                  <?php foreach ($products as $product) { ?>
                  <?php if ($product['storeurl'] == $storeurl) {?>
                  <div class="bundles" id="bundles">
                    <ul class="bundles_list">
                      <li>
                        <dl class="bl_checkbox">
                          <input class="gwc_choos check" id="<?php echo $product['key'];?>" name="items"
                                                                            type="checkbox" value="<?php echo $product['key'];?>" />
                          <label for="<?php echo $product['key'];?>" class="check_label"> </label>
                        </dl>
                      </li>
                      <li> <a class="gwc_tu" target="_blank" href="<?php echo $product['producturl'];?>"> <img src="<?php echo $product['thumb']; ?>" alt="缩略图" onmouseover="toolTip('<img src=<?php echo $product['thumb']; ?> height=240 width=240>')"
                                                                            onmouseout="toolTip()"> </a> </li>
                      <li class="gwc_conts">
                        <dl>
                          <dt> <a target="_blank" href="<?php echo $product['producturl'];?>"> <?php echo $product[ 'name']; ?> </a> </dt>
                          <dd> 备注：
                            <input type="text" id="beizhu_in" class="<?php echo "beizhu_in".$product['key']; ?>" value="<?php if ($product[ 'note']) echo $product['note']; else echo '请输入您的特殊需求。'?>" />
                            <input id="beizhu_correct" value="修改" type="button" onclick="javascript:cnstorm.cart.modify(this,'<?php echo $product['key']; ?>',<?php echo $product['quantity']; ?>,<?php echo intval($this->customer->getId()); ?>);" />
                          </dd>
                        </dl>
                      </li>
                      <li class="the_colour">
                        <dl>
                          <dt> 颜色： <?php echo $product[ 'color']; ?> </dt>
                          <dd> 尺码： <?php echo $product[ 'size']; ?> </dd>
                        </dl>
                      </li>
                      <li class="the_price"><b class="single_price"> <?php echo $product[ 'price']; ?> </b> </li>
                      <li class="the_amouts"><span class="click_num"> <a class="reduce" href="javascript:void(0);"> - </a>
                        <input class="purchase-quantity" data-key="<?php echo $product['key']?>" type="text" value="<?php echo $product['quantity']; ?>" />
                        <input class="purchase-customer-id" type="hidden" value="<?php echo $this->customer->getId(); ?>" />
                        <a class="add" href="javascript:void(0);"> + </a> </span> </li>
                      <li class="the_nums">
                        <dl>
                          <dt><b class="count_mon"> <?php echo $product['total']; ?> </b> </dt>
                          <dd> <span>卖家运费：<em class="postAge"> <?php echo $product['yunfei']; ?> </em> </span> </dd>
                        </dl>
                      </li>
                      <li class="the_deletes"> <a onclick="cnstorm.cart.addToWishList1('<?php if($product['cart_session_id']) echo $product['cart_session_id'];?>');">移入收藏夹</a>
                        <dd> <a class="delete-product-cart" data-key="<?php echo $product['key'];?>" onclick="cnstorm.cart.deleteproduct(this,<?php echo intval($this->customer->getId());?>)">删除</a></dd>
                      </li>
                    </ul>
                  </div>
                  <?php }} ?>
                </div>
              </div>
              <?php }} ?>
            </div>
            <div class="delete_it ml10">
            <div class="gwc_intotal">
              <div class="gs_checkall">
                <div class="gs_checkbox">
                  <input id="chkbx" type="checkbox" class="check-all check">
                  <label for="chkbx"> 勾选购物车内所有商品 </label>
                  全选 </div>
                <a class="gs_del" id="gs_del" href="javascript:cnstorm.cart.deleteAll();"> 删除选中的商品 </a></div>
              <!-- span class="gi_yun"> 运费：￥ <em id="postAge_all" class="postAge_all"> </em> </span -->
              <div class="gs_btn">
                <input type='button' value='立即下单' class="gs_xiad" onclick='makeorder()'/>
              </div>
              <span class="gi_mon"> 合计（含卖家运费）：￥ <b id="allPr" class="allPr"> </b> </span><span class="gi_num"> 已选： <em id="product_all"> 0 </em> 件 </span> </div>
            <div class="gwc_surebtn">
              <div class="gs_checkall">
                <div class="gs_btn">
                  <input type="hidden" id="total_amount" name="total_amount" value="" />
                  <input type="hidden" id="total_freight" name="total_freight" value=""/>
                  <input type="hidden" id="wanna_buy" name="wanna_buy" value="" />
                  <!-- a class="gs_conti" href="<?php echo $favorite;?>"> 继续购物 </a --> 
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="list_wrap">
          <ul class="product_list">
            <?php if ( isset($orders) )  foreach($orders as $product) {  ?>
            <li> <a target="_blank" href="<?php echo  $product['producturl'];?>"><img src="<?php if(1 == $product['source']) echo 'image/'.$product['img']; else echo $product['img'] ?>" alt="<?php echo $product['name']; ?>"></a> <a target="_blank" class="introduce" href="<?php echo  $product['producturl'];?>"><?php echo $product['name']; ?></a> <strong class="current_price">￥<b><?php echo $product['price']; ?></b></strong> </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $footer ;?> 