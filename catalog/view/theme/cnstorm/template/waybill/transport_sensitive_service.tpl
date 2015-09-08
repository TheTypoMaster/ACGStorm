<?php echo $header_cart; ?>
<title>提交运单 - 用户在CNstorm淘国货平台提交运输申请</title>
<meta name="keywords" content="代购,cnstorm代购,代购运单,代购网,代购商品" />
<meta name="description" content="会员直接登录CNstorm淘国货平台提交运输申请" />
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/cnstorm/stylesheet/transport_sensitive.css"/>
<body>
<div class="waybill_info">
  <div class="wrap">
    <div class="ship-box">
      <form action="index.php?route=waybill/checkout/mixsendorder" method="post">
        <section class="steps_nav">
          <ul class="shipnav">
            <li class="text1">选择运单信息</li>
            <li class="text2">核对运单总价</li>
            <li class="text3">成功提交运单</li>
          </ul>
        </section>
        <div style="padding: 5px 10px;border: 1px solid #f9dfb2;margin: 10px;background: #ffffe0;float: left;width: 1138px;text-align: center;"> <strong>温馨提示：</strong>2015年1月1日起CNstorm将以自选服务收费方式取代原固定服务费收费方式。<a href="/index.php?route=help/help&qid=12" target="_blank" style="color:#0078b6;">查看详情</a></div>
        <input type="hidden" name="address_id"  value="<?php echo $address_id; ?>">
        <input type="hidden" name="order_id_combination"  value="<?php echo $order_id_combination; ?>">
        <input type="hidden" name="pak"  value="<?php echo $pak; ?>">
        <input type="hidden" name="did"  value="<?php echo $did; ?>">
        <input type="hidden" name="did_sensitive"  value="<?php echo $did_sensitive; ?>">
        <input type="hidden" name="areaid"  value="<?php echo $areaid; ?>">
        <input type="hidden" name="new_order_id_combination"  value="<?php echo $new_order_id_combination; ?>">
        <input type="hidden" name="new_order_id_sensitive"  value="<?php echo $new_order_id_sensitive; ?>">
  
        <section class="value-added">
          <h3>自选增值服务<i>提供全方位的周到服务，满足您的需求，使我们的使命!</i></h3>
          <div class="clearline"></div>
          <div class="value-added-title">
              <div class="sensitive-title">
                <div class="order_number">订单编号</div>
                <div id="order_box" style="display:none">
                  <?php foreach ($new_order_id_sensitive_array as $new_order_id_sensitive_value){ ?>
                    <dd><?php echo $new_order_id_sensitive_value; ?></dd>
                  <?php } ?>
                </div>
                <span>含敏感品运输方式</span>
              </div>
              <div class="normal-title">
                <div class="order_number">订单编号</div>
                <div id="order_box_normal" style="display:none">
                  
                  <?php foreach ($new_order_id_combination_array as $new_order_id_combination_value){ ?>
                    <dd><?php echo $new_order_id_combination_value;?></dd>
                  <?php } ?>
                  
                </div>
                <span>不含敏感品运输方式</span>
              </div>
          </div>
          <div class="clear"></div>
          <div class="value-added-info">
              <div class="sensitive-info">

              <h3><img src="image/menu_identification.jpg">打包策略</h3>
                <ul class="unpack-sensitive">
                  <!-- ? php if($student || !$shippingnumber) { ?>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="radio" name="unpack_sensitive" value="0">
                    <dd class="service-info-title">免费体验</dd>
                    <dd class="service-info-info">学生认证会员专享</dd>
                    <dd class="service-info-price">免费</dd>
                  </li>
                  < ? php } ? -->
                  <li class="service-info checked">
                    <input class="rdoservice" type="radio" name="unpack_sensitive" value="1" checked="checked">
                    <dd class="service-info-title titlechecked">免费方案</dd>
                    <dd class="service-info-info">打包员将快速及合理的为您打包,现已永久免费</dd>
                    <dd class="service-info-price">仅需<i id="unpack_sensitive_fee1">+<?php echo $servicefee_sensitive['unpack_fee1']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="unpack_sensitive" value="2">
                    <dd class="service-info-title">标准方案</dd>
                    <dd class="service-info-info">专属打包员为您打包并优化商品排列,可为您降低大量包裹体积</dd>
                    <dd class="service-info-price">仅需<i id="unpack_sensitive_fee2">+<?php echo $servicefee_sensitive['unpack_fee2']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="unpack_sensitive" value="3">
                    <dd class="service-info-title">高级方案</dd>
                    <dd class="service-info-info">只需要少量费用,专属打包团队将为您设计最完美的打包方案极力降低的包裹体积</dd>
                    <dd class="service-info-price">仅需<i id="unpack_sensitive_fee3">+<?php echo $servicefee_sensitive['unpack_fee3']; ?></i>元</dd>
                  </li>
                </ul>
                
                <div class="clear"></div>

                <h3><img src="image/menu_identification.jpg">订单处理</h3>
                <ul class="checkorder-sensitive">
                  <!-- ? php if($student || !$shippingnumber) { ?>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="radio" name="checkorder_sensitive" value="0">
                    <dd class="service-info-title">免费体验</dd>
                    <dd class="service-info-info">学生认证会员专享</dd>
                    <dd class="service-info-price">免费</dd>
                  </li>
                  < ? php } ? -->
                    <li class="service-info checked">
                    <input class="rdoservice" type="radio" name="checkorder_sensitive" value="1" checked="checked">
                    <dd class="service-info-title titlechecked">免费方案</dd>
                    <dd class="service-info-info">为您检查商品并安全寄出海外,享受最高600元赔付,现已永久免费</dd>
                    <dd class="service-info-price">仅需<i id="checkorder_sensitive_fee1">+<?php echo $servicefee_sensitive['checkorder_fee1']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="checkorder_sensitive" value="2">
                    <dd class="service-info-title">标准方案</dd>
                    <dd class="service-info-info">质检专员为您提供细致商品检查,享受问题商品免费处理及最高1800元赔付</dd>
                    <dd class="service-info-price">仅需<i id="checkorder_sensitive_fee2">+<?php echo $servicefee_sensitive['checkorder_fee2']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="checkorder_sensitive" value="3">
                    <dd class="service-info-title">高级方案</dd>
                    <dd class="service-info-info">只需要少量费用,即可获取专业质检并尊享最高2500元赔付</dd>
                    <dd class="service-info-price">仅需<i id="checkorder_sensitive_fee3">+<?php echo $servicefee_sensitive['checkorder_fee3']; ?></i>元</dd>
                  </li>
                </ul>
                <div class="clear"></div>

                <h3><img src="image/menu_identification.jpg">包装耗材</h3>
                <ul class="wrapper-sensitive">
                  <li class="service-info-wide checked">
                    <input class="rdoservice" type="radio" name="wrapper_sensitive" value="1" checked="checked">
                    <dd class="service-info-title titlechecked">标准耗材</dd>
                    <dd class="service-info-info">标准化包装方案,采用国际邮递标准耗材封装您的商品</dd>
                    <dd class="service-info-price">仅需<i id="wrapper_sensitive_fee1">+<?php echo $servicefee_sensitive['wrapper_fee1']; ?></i>元</dd>
                  </li>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="radio" name="wrapper_sensitive" value="2">
                    <dd class="service-info-title">坚固耗材</dd>
                    <dd class="service-info-info">A+级坚固纸箱+超轻气泡膜封装全力保障货品安全</dd>
                    <dd class="service-info-price">仅需<i id="wrapper_sensitive_fee2">+<?php echo $servicefee_sensitive['wrapper_fee2']; ?></i>元</dd>
                  </li>
                </ul>
                <div class="clear"></div>
                <h3><img src="image/menu_identification.jpg">增值服务<i>(可多选)</i></h3>
                <ul class="valueadded-sensitive">
                  <li class="service-info-wide ">
                    <input class="rdoservice" type="checkbox" name="valueadded_bag_sensitive" value="1">
                    <dd class="service-info-title ">提供大包裹方案</dd>
                    <dd class="service-info-info">若包裹体积重量大于实际体积重量,我司将以邮件或者站内信提供最具性价比的运送方案</dd>
                    <dd class="service-info-price">仅需<i>+1.5</i>元</dd>
                  </li>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="checkbox" name="valueadded_photo_sensitive" value="1">
                    <dd class="service-info-title">提供运单拍照</dd>
                    <dd class="service-info-info">完成包裹打包后,我司将对该包裹进行拍照后并通过邮件发送给您</dd>
                    <dd class="service-info-price">仅需<i>+3.5</i>元</dd>
                  </li>
                </ul>
                <div class="clear"></div>
                <h3><img src="image/menu_identification.jpg">费用估算<i>运单总费用以核对运单总价页面为准,此处仅做参考</i></h3>  
                <ul class="estimate">
                  <li>运费(元)：</li>
                  <li>报关费(元)：</li>
                  <li>耗材费(元)：</li>
                  <li>打包策略(元)：</li>
                  <li>订单处理(元)：</li>
                  <li>大包裹方案(元)：</li>
                  <li>运单拍照(元)：</li>
                </ul>
                <ul class="estimate-value">
                  <li id="estimate_freight_sensitive"><?php echo $freight_sensitive;?></li>
                  <li id="estimate_customerfee_sensitive">8</li>
                  <li id="estimate_wrapper_sensitive"><?php echo $servicefee_sensitive['wrapper_fee1'];?></li>
                  <li id="estimate_unpack_sensitive"><?php echo $servicefee_sensitive['unpack_fee1'];?></li>
                  <li id="estimate_checkorder_sensitive"><?php echo $servicefee_sensitive['checkorder_fee1'];?></li>
                  <li id="estimate_largepackage_sensitive">0</li>
                  <li id="estimate_waybillphoto_sensitive">0</li>
                </ul>
              </div>
              
              <div class="normal-info">
                <h3><img src="image/menu_identification.jpg">打包策略</h3>
                <ul class="unpack-normal">
                  <!-- ? php if($student || !$shippingnumber) { ?>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="radio" name="unpack" value="0">  
                    <dd class="service-info-title">免费体验</dd>
                    <dd class="service-info-info">学生认证会员专享</dd>
                    <dd class="service-info-price">免费</dd>
                  </li>
                  < ? php  } ? -->
                  <li class="service-info checked">
                    <input class="rdoservice" type="radio" name="unpack" value="1" checked="checked">
                    <dd class="service-info-title titlechecked">免费方案</dd>
                    <dd class="service-info-info">打包员将快速及合理的为您打包,现已永久免费</dd>
                    <dd class="service-info-price">仅需<i id="unpack_fee1">+<?php echo $servicefee['unpack_fee1']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="unpack" value="2">
                    <dd class="service-info-title">标准方案</dd>
                    <dd class="service-info-info">专属打包员为您打包并优化商品排列,可为您降低大量包裹体积</dd>
                    <dd class="service-info-price">仅需<i id="unpack_fee2">+<?php echo $servicefee['unpack_fee2']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="unpack" value="3">
                    <dd class="service-info-title">高级方案</dd>
                    <dd class="service-info-info">只需要少量费用,专属打包团队将为您设计最完美的打包方案极力降低的包裹体积</dd>
                    <dd class="service-info-price">仅需<i id="unpack_fee3">+<?php echo $servicefee['unpack_fee3']; ?></i>元</dd>
                  </li>
                </ul>
                <div class="clear"></div>
                <h3><img src="image/menu_identification.jpg">订单处理</h3>
                <ul class="checkorder-normal">
                  <!-- ?php if($student || !$shippingnumber) { ?>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="radio" name="checkorder" value="0">
                    <dd class="service-info-title">免费体验</dd>
                    <dd class="service-info-info">学生认证会员专享</dd>
                    <dd class="service-info-price">免费</dd>
                  </li>
                  < ? php } ? -->
                   <li class="service-info checked">
                    <input class="rdoservice" type="radio" name="checkorder" value="1" checked="checked">
                    <dd class="service-info-title titlechecked">免费方案</dd>
                    <dd class="service-info-info">为您检查商品并安全寄出海外,享受最高600元赔付,现已永久免费</dd>
                    <dd class="service-info-price">仅需<i id="checkorder_fee1">+<?php echo $servicefee['checkorder_fee1']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="checkorder" value="2">
                    <dd class="service-info-title">标准方案</dd>
                    <dd class="service-info-info">质检专员为您提供细致商品检查,享受问题商品免费处理及最高1800元赔付</dd>
                    <dd class="service-info-price">仅需<i id="checkorder_fee2">+<?php echo $servicefee['checkorder_fee2']; ?></i>元</dd>
                  </li>
                  <li class="service-info">
                    <input class="rdoservice" type="radio" name="checkorder" value="3">
                    <dd class="service-info-title">高级方案</dd>
                    <dd class="service-info-info">只需要少量费用,即可获取专业质检并尊享最高2500元赔付</dd>
                    <dd class="service-info-price">仅需<i id="checkorder_fee3">+<?php echo $servicefee['checkorder_fee3']; ?></i>元</dd>
                  </li> 
                </ul>

                <div class="clear"></div>

                <h3><img src="image/menu_identification.jpg">包装耗材</h3>
                <ul class="wrapper-normal">
                  <li class="service-info-wide checked">
                    <input class="rdoservice" type="radio" name="wrapper" value="1" checked="checked">
                    <dd class="service-info-title titlechecked">标准耗材</dd>
                    <dd class="service-info-info">标准化包装方案,采用国际邮递标准耗材封装您的商品</dd>
                    <dd class="service-info-price">仅需<i id="wrapper_fee1">+<?php echo $servicefee['wrapper_fee1']; ?></i>元</dd>
                  </li>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="radio" name="wrapper" value="2">
                    <dd class="service-info-title">坚固耗材</dd>
                    <dd class="service-info-info">A+级坚固纸箱+超轻气泡膜封装全力保障货品安全</dd>
                    <dd class="service-info-price">仅需<i id="wrapper_fee2">+<?php echo $servicefee['wrapper_fee2']; ?></i>元</dd>
                  </li>
                </ul>

                <div class="clear"></div>

                <h3><img src="image/menu_identification.jpg">增值服务<i>(可多选)</i></h3>
                <ul class="valueadded-normal">
                  <li class="service-info-wide ">
                    <input class="rdoservice" type="checkbox" name="valueadded_bag" value="1">
                    <dd class="service-info-title ">提供大包裹方案</dd>
                    <dd class="service-info-info">若包裹体积重量大于实际体积重量,我司将以邮件或者站内信提供最具性价比的运送方案</dd>
                    <dd class="service-info-price">仅需<i>+1.5</i>元</dd>
                  </li>
                  <li class="service-info-wide">
                    <input class="rdoservice" type="checkbox" name="valueadded_photo" value="1">
                    <dd class="service-info-title">提供运单拍照</dd>
                    <dd class="service-info-info">完成包裹打包后,我司将对该包裹进行拍照后并通过邮件发送给您</dd>
                    <dd class="service-info-price">仅需<i>+3.5</i>元</dd>
                  </li>
                </ul>

                <div class="clear"></div>
                
                <h3><img src="image/menu_identification.jpg">费用估算<i>运单总费用以核对运单总价页面为准,此处仅做参考</i></h3>  
                <ul class="estimate">
                  <li>运费(元)：</li>
                  <li>报关费(元)：</li>
                  <li>耗材费(元)：</li>
                  <li>打包策略(元)：</li>
                  <li>订单处理(元)：</li>
                  <li>大包裹方案(元)：</li>
                  <li>运单拍照(元)：</li>
                </ul>
                <ul class="estimate-value">
                  <li id="estimate_freight"><?php echo $freight;?></li>
                  <li id="estimate_customerfee">8</li>
                  <li id="estimate_wrapper"><?php echo $servicefee['wrapper_fee1'];?></li>
                  <li id="estimate_unpack"><?php echo $servicefee['unpack_fee1'];?></li>
                  <li id="estimate_checkorder"><?php echo $servicefee['checkorder_fee1'];?></li>
                  <li id="estimate_largepackage">0</li>
                  <li id="estimate_waybillphoto">0</li>
                </ul>
              </div>
          </div>
          <div class="clear"></div>
          <div class="total">
              <div class="sensitive-total">合计：<i id="estimate_total_sensitive"><?php echo $estimate_total_sensitive;?></i>元</div>
              <div class="normal-total">合计：<i id="estimate_total"><?php echo $estimate_total;?></i>元</div>
          </div>  
          <a href="<?php echo $lasstep;?>"><input class="lasstep"  type="button"  value="上一步"></a>
          <input class="nextstep" type="submit" value="下一步">
        </section>
     </form>
    </div>
  </div>
</div>
</body>
<script src="catalog/view/javascript/jquery2/tosendorder.js"></script>
<?php echo $footer; ?>