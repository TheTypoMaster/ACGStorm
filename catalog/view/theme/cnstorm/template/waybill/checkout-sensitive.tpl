<?php echo $header; ?>
<title>代购运单 - 用户在CNstorm代购网上查询代购商品运单情况</title>
<meta name="keywords" content="代购,cnstorm代购,代购运单,代购网,代购商品" />
<meta name="description" content="会员直接登录CNstorm代购网代购运单查询页面,及时核查代购代购商品情况" />
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/cnstorm/stylesheet/transport.css"/>

<body>
<div class="checkout_info">
  <div class="wrap">
    <div class="ship-box">
      
      <form action="index.php?route=checkout/confirm/sendorder" method="post">
      <section class="steps_nav">
        <ul class="checkoutnav">
          <li class="text1">选择运单信息</li>
          <li class="text2">核对运单总价</li>
          <li class="text3">成功提交运单</li>
        </ul>
      </section>
	  
      <input type="hidden" name="waybillbatch_pay" value="<?php echo $waybillbatch_pay;?>">
      <div class="billing_info">
      <h3>运单费用统计(含敏感品)<i>请仔细核对您的各项费用,避免发生不必要的纠纷</i></h3>
      <div class="clearline"></div>
      <table  class="checktable" border="0" align="center" cellspacing="0" cellpadding="0">
        <thead class="checktitle">
        <tr>
          <th>运费(元)</th>
          <th>报关费(元)</th>
          <th>耗材费(元)</th>
          <th>服务费(元)</th>
          <th>优惠费(元)</th>
          <th>结算总额(元)</th> 
        </tr>
        </thead>
        <tr>
          <td><?php echo $freight;?></td>
          <td><?php echo $customsfee;?></td>
          <td><?php echo $wrapperfee;?></td>
          <td><?php echo $serverfee;?></td>
          <td class="discount">
            <dd>积分优惠:<strong id="score_discount">0.00</strong></dd>
            <dd>优惠卷优惠:<strong id="coupon_discount">0.00</strong></dd> 
          </td>
      <td>
        <dd>会员价:<strong id="totalfee"><?php echo $totalfee;?></strong></dd>
        <input type="hidden" name="htotalfee" id="htotalfee" value="<?php echo $totalfee;?>">
        <dd class="oldtotal">原价:<?php echo $oldtotalfee;?></dd>
      </td>
        </tr>    
      </table>
      <h3>运单费用统计(非敏感品)<i>请仔细核对您的各项费用,避免发生不必要的纠纷</i></h3>
      <div class="clearline"></div>
      <table  class="checktable" border="0" align="center" cellspacing="0" cellpadding="0">
        <thead class="checktitle">
        <tr>
          <th>运费(元)</th>
          <th>报关费(元)</th>
          <th>耗材费(元)</th>
          <th>服务费(元)</th>
          <th>优惠费(元)</th>
          <th>结算总额(元)</th> 
        </tr>
        </thead>
        <tr>
        	<td><?php echo $freight_normal;?></td>
        	<td><?php echo $customsfee_normal;?></td>
        	<td><?php echo $wrapperfee_normal;?></td>
        	<td><?php echo $serverfee_normal;?></td>
        	<td class="discount">
        		<dd>积分优惠:<strong id="score_discount_normal">0.00</strong></dd>
        		<dd>优惠卷优惠:<strong id="coupon_discount_normal">0.00</strong></dd> 
        	</td>
			<td>
				<dd>会员价:<strong id="totalfee_normal"><?php echo $totalfee_normal;?></strong></dd>
				<input type="hidden" name="htotalfee_normal" id="totalfee_normal" value="<?php echo $totalfee_normal;?>">
				<dd class="oldtotal">原价:<?php echo $oldtotalfee_normal;?></dd>
			</td>
        </tr>    
      </table>

	  <div style=”clear:both”></div>	
     
       <div class="addinfo">
       <div class="note">
        <div class="add_note"> <a class='note' href='javascript:void(0);' onclick="launch('note')">添加备注</a>
          <ul class="coupons_cont" id='note' style="display: none;">
            <li><i></i></li>
            <li style='margin: 10px;'><span>请输入备注内容：</span></li>
            <li><span class="li2">
              <textarea id="addnote" name="addnote" style=""></textarea>
              </span></li>
          </ul>
        </div>
      </div>

      <div class="coupons">
        <div class="use_coupons"> <a class="coupon" href="javascript:void(0);" onclick="launch('coupon')">使用优惠券</a> 
          <div class="coupons_cont" id="coupon" style="display:none;">
          	<input type="hidden" name="usecoupon"  value="" id="usecoupon"/>
            <div class="your_coupon"> <span>当前可用优惠券：<b><?php echo $coupon_total;?></b> 张</span>
              <ul>
                <li class="yc_l"><a>&lt;</a></li>
                <li><em>1</em>/<?php echo $coupon_total;?></li>
                <li class="yc_r"><a>&gt;</a></li>
              </ul>
            </div>
              <div class="view_amout" style="width:570px;height:80px;overflow:hidden;margin-left:14px">
              <div class="all_amout" style="width:<?php echo count($coupon_info)*190; ?>px;overflow:hidden;height:80px;position:relative">
	            <ul class="coupon_list">
	              <?php foreach($coupon_info as $coupon) { ?>
	              <li id=<?php echo $coupon['cid'];?>  >
	                <dl class="left">
	                  <dt class="deadline"><?php echo date("Y-m-d",$coupon['addtime']). "-" . date("Y-m-d",$coupon['endtime']); ?></dt>
	                  <dd class="money"><em class="price_symbol">￥</em><b class="amout"><?php echo $coupon['money']; ?></b>优惠券</dd>
	                </dl>
	                <dl class="right">
	                  <dt>立</dt>
	                  <dd>即</dd>
	                  <dd>使</dd>
	                  <dd>用</dd>
	                </dl>
	              </li>
	              <?php } ?>
	            </ul>
              </div>
              </div>
            </div>
        </div>
      </div >

      <div class="integral">
        <div class="use_integral"> <a class='score' onclick="launch('score')" href="javascript:void(0);">使用积分抵消部分总额</a>
          <ul class="integral_cont" id='score' style="display: none;">
            <li><i></i></li>
            <li><span>当前可用积分：<b><?php echo $score*0.89 ?></b>（100分=1元）</span></li>
            <li><span>本次使用
              <input id="scoreuse" name="scoreuse" onkeyup="newEqual(<?php echo $score*0.89 ?>);"/>
              分,可抵扣运费 <em id="subAmount">-0.00</em> 元</span></li>
          </ul>
        </div>
      </div>
	  </div>

	  <div class="planinfo">
	  	<dl class="plantitle">增值服务项目(方案/费用(元))</dl>
	  	<dl class="plandetail">
		<?php if(0 == $unpack) {?>
	  	<dd>打包策略: 免费体验,<i>免费</i></dd>
	  	<?php }elseif (1 == $unpack) { ?>
	  	<dd>打包策略: 经济方案,<i>+<?php echo $unpackfee;?></i></dd>
	  	<?php }elseif (2 == $unpack) { ?>
	  	<dd>打包策略: 标准方案,<i>+<?php echo $unpackfee;?></i></dd>
	  	<?php }elseif (3 == $unpack) { ?>
	  	<dd>打包策略: 高级方案,<i>+<?php echo $unpackfee;?></i></dd>
	  	<?php } ?>
		
		<?php if(0 == $unpack) {?>
	  	<dd>订单处理: 免费体验,<i>免费</i></dd>
	  	<?php }elseif (1 == $unpack) { ?>
	  	<dd>订单处理: 经济方案,<i>+<?php echo $checkorderfee;?></i></dd>
	  	<?php }elseif (2 == $unpack) { ?>
	  	<dd>订单处理: 标准方案,<i>+<?php echo $checkorderfee;?></i></dd>
	  	<?php }elseif (3 == $unpack) { ?>
	  	<dd>订单处理: 高级方案,<i>+<?php echo $checkorderfee;?></i></dd>
	  	<?php } ?>
		
		<?php if($valueadded_bag) { ?>
  		<dd>增值服务: 大包裹方案,<i>+1.50</i></dd>
  		<?php } ?>
  		<?php if($valueadded_photo) { ?>
  		<dd>增值服务: 运单拍照,<i>+3.50</i></dd>
  		<?php } ?>
  	  </dl>	

    
		<input class="lasstep"  onclick="laststep(<?php echo $sendorder_id;?>);"  type="button" value="上一步">
		<input class="checkout" type="submit" value="去结算"> 
	  </div>
		
    </div>	

		
  	</form>

    </div>
  </div>
</div>
</body>

<script src="catalog/view/javascript/jquery2/tosendorder.js"></script>
<?php echo $footer; ?>