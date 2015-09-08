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
       <!-- <dl>
          <dt>共计<b><?php echo $count; ?></b>件产品</dt>
          <dd>合计：<b>￥<?php echo $totalprice; ?></b></dd>
        </dl>-->
		
		<p>购物车里还有<?php echo $surplus;?>件商品</p>
		 <span class="settle_accounts"><a class="btn" href="http://www.acgstorm.com/checkout-cart.html">查看我的购物车</a></span>
       </li>
    </ul>
    
    <?php } ?>