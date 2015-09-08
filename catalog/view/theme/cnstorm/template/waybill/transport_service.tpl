<?php echo $header_cart; ?>
<title>提交运单 - 用户在CNstorm淘国货平台提交运输申请</title>
<meta name="keywords" content="代购,cnstorm代购,代购运单,代购网,代购商品" />
<meta name="description" content="会员直接登录CNstorm淘国货平台提交运输申请" />
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/cnstorm/stylesheet/transport.css"/>
<body>
<div class="waybill_info">
  <div class="wrap">
    <div class="ship-box">
      <form action="index.php?route=waybill/checkout" method="post">
        <div class="steps_nav">
          <ul class="shipnav">
            <li class="text1">选择运单信息</li>
            <li class="text2">核对运单总价</li>
            <li class="text3">成功提交运单</li>
          </ul>
        </div>
        <div style="padding: 5px 10px;border: 1px solid #f9dfb2;margin: 10px;background: #ffffe0;float: left;width: 1138px;text-align: center;"> <strong>温馨提示：</strong>2015年1月1日起CNstorm将以自选服务收费方式取代原固定服务费收费方式。<a href="/index.php?route=help/help&qid=12" target="_blank" style="color:#0078b6;">查看详情</a></div>
        <input type="hidden" name="address_id"  value="<?php echo $address_id; ?>">
        <input type="hidden" name="order_id_combination"  value="<?php echo $order_id_combination; ?>">
        <input type="hidden" name="pak"  value="<?php echo $pak; ?>">
        <input type="hidden" name="did"  value="<?php echo $did; ?>">
        <input type="hidden" name="did_sensitive"  value="<?php echo $did_sensitive; ?>">
        <input type="hidden" name="areaid"  value="<?php echo $areaid; ?>">
        <div class="value-added">
          <h3>4 自选增值服务<i>提供全方位的周到服务，满足您的需求，是我们的使命!</i></h3>
          <div id="value-added-info" style="display:block;">
            <div class="unpack">
              <h4>打包策略</h4>
              <div class="service-title">
                <div class="ah">服务方案</div>
                <div class="ah1">服务说明</div>
                <div class="ah">服务价格(元)</div>
              </div>
              <div class="service-list"> 
                <!-- ? php if($student || !$shippingnumber) { ?>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="unpack"  value="0">
                  <label>免费体验</label>
                  </span> <span class="service-instruction">学生认证会员专享</span> <span class="service-price">免费</span> </div>
                <? php  }  ?> -->
                <div class="service-info checked"> <span class="service-num">
                  <input type="radio" name="unpack"  value="1" checked="checked">
                  <label>免费方案</label>
                  </span> <span class="service-instruction">打包员将快速及合理的为您打包,现已永久免费</span> <span class="service-price">仅需<i id="unpack_fee1">+<?php echo $servicefee['unpack_fee1']; ?></i></span> </div>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="unpack"  value="2">
                  <label>标准方案</label>
                  </span> <span class="service-instruction">专属打包员为您打包并优化商品排列,可为您降低大量包裹体积</span> <span class="service-price">仅需<i id="unpack_fee2">+<?php echo $servicefee['unpack_fee2']; ?></i> </span> </div>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="unpack"  value="3">
                  <label>高级方案</label>
                  </span> <span class="service-instruction">只需要少量费用,专属打包团队将为您设计最完美的打包方案极力降低的包裹体积</span> <span class="service-price">仅需<i id="unpack_fee3">+<?php echo $servicefee['unpack_fee3']; ?></i></span> </div>
              </div>
            </div>
            <div class="checkorder">
              <h4>订单处理</h4>
              <div class="service-title">
                <div class="ah">服务方案</div>
                <div class="ah1">服务说明</div>
                <div class="ah">服务价格(元)</div>
              </div>
              <div class="service-list"> 
                <!-- ? php if($student || !$shippingnumber) { ?>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="checkorder"  value="0">
                  <label>免费体验</label>
                  </span> <span class="service-instruction">学生认证会员专享</span> <span class="service-price">免费</span> </div>
                < ? php }  ? -->
                <div class="service-info checked"> <span class="service-num">
                  <input type="radio" name="checkorder"  value="1" checked="checked">
                  <label>免费方案</label>
                  </span> <span class="service-instruction">为您检查商品并安全寄出海外,享受最高600元赔付,现已永久免费</span> <span class="service-price">仅需<i id="checkorder_fee1">+<?php echo $servicefee['checkorder_fee1']; ?></i></span> </div>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="checkorder"  value="2">
                  <label>标准方案</label>
                  </span> <span class="service-instruction">质检专员为您提供细致商品检查,享受问题商品免费处理及最高1800元赔付</span> <span class="service-price">仅需<i id="checkorder_fee2">+<?php echo $servicefee['checkorder_fee2']; ?></i></span> </div>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="checkorder"  value="3">
                  <label>高级方案</label>
                  </span> <span class="service-instruction">只需要少量费用,即可获取专业质检并尊享最高2500元赔付</span> <span class="service-price">仅需<i id="checkorder_fee3">+<?php echo $servicefee['checkorder_fee3']; ?></i></span> </div>
              </div>
            </div>
            <div class="valueadded">
              <h4>增值服务</h4>
              <div class="service-title">
                <div class="ah">服务方案</div>
                <div class="ah1">服务说明</div>
                <div class="ah">服务价格(元)</div>
              </div>
              <div class="service-list">
                <div class="service-info checkbox"> <span class="service-num">
                  <input type="checkbox"  name="valueadded_bag"  value="1">
                  <label>提供大包裹方案</label>
                  </span> <span class="service-instruction">若包裹体积重量大于实际体积重量,我司将以邮件或者站内信提供最具性价比的运送方案</span> <span class="service-price">仅需<i>+1.5</i></span> </div>
                <div class="service-info checkbox"> <span class="service-num">
                  <input type="checkbox"  name="valueadded_photo"  value="1">
                  <label>提供运单拍照</label>
                  </span> <span class="service-instruction">完成包裹打包后,我司将对该包裹进行拍照后并通过邮件发送给您</span> <span class="service-price">仅需<i>+3.5</i></span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="value-added" >
          <h3>5 包装耗材<i>我们将为您的宝贝提供最优质的包装材料，保障宝贝安全的送到您的手中!</i></h3>
          <div id="wrapper-info" style="display:block;">
            <div class="wrapper">
              <h4>包装材料</h4>
              <div class="service-title">
                <div class="ah">服务方案</div>
                <div class="ah1">服务说明</div>
                <div class="ah">服务价格(元)</div>
              </div>
              <div class="service-list">
                <div class="service-info checked"> <span class="service-num">
                  <input type="radio" name="wrapper"  value="1" checked="checked">
                  <label>标准耗材</label>
                  </span> <span class="service-instruction">标准化包装方案,采用国际邮递标准耗材封装您的商品</span> <span class="service-price">仅需<i id="wrapper_fee1">+<?php echo $servicefee['wrapper_fee1']; ?></i></span> </div>
                <div class="service-info"> <span class="service-num">
                  <input type="radio" name="wrapper"  value="2">
                  <label>坚固耗材</label>
                  </span> <span class="service-instruction">A+级坚固纸箱+超轻气泡膜封装全力保障货品安全</span> <span class="service-price">仅需<i id="wrapper_fee2">+<?php echo $servicefee['wrapper_fee2']; ?></i></span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="value-added" >
          <h3>6 小费打赏<i>资金将帮助CNstorm发展及提供更多优质服务, 10%将进入壹基金慈善捐款账户!</i></h3>
          <div class="donation_l">
            <ul>
              <li>
                <input type="radio" id="radio1" name="d_value" value="0" checked="checked"/>
                不打赏</li>
              <li>
                <input type="radio" id="radio2" name="d_value" value="5"/>
                5元</li>
              <li>
                <input type="radio" id="radio3" name="d_value" value="20"/>
                20元</li>
              <li>
                <input type="radio" id="radio4" name="d_value" value="50"/>
                50元</li>
            </ul>
            <p>赏金自填：
              <input type="text" id="custom_donation" onkeyup="newDonation()">
              元 </p>
          </div>
          <div class="donation_r"><img src="http://www.onefoundation.cn/Public/static/images/logo.jpg" class="fl"><span>由李连杰先生发起成立的创新型公益组织，以“尽我所能，人人公益”为愿景，致力于搭建专业透明的壹基金公益平台，专注于灾害救助、儿童关怀、公益人才培养三大公益领域。<a href="http://www.onefoundation.cn/" target="_blank">基金官网</a><br>
            您的捐赠额：<b>0</b>元 (赏金10%，每月1号公示)</span></div>
        </div>
        <div class="value-added" >
          <div class="estimate">
            <h4>费用估算<i>提交运单费用以核对运单总价页面为准，此处仅作参考</i></h4>
            <div class="clearline"></div>
            <table  class="checktable" border="0" align="left" cellspacing="0" cellpadding="0">
              <thead class="checktitle">
                <tr>
                  <th>运费(元)</th>
                  <th>报关费(元)</th>
                  <th>耗材费(元)</th>
                  <th>打包策略(元)</th>
                  <th>订单处理(元)</th>
                  <th>大包裹方案(元)</th>
                  <th>运单拍照(元)</th>
                  <th>打赏额(元)</th>
                  <th>估算总额(元)</th>
                  <th></th>
                </tr>
              </thead>
              <tr>
                <td id="estimate_freight"><?php echo $freight;?></td>
                <td id="estimate_customerfee">8</td>
                <td id="estimate_wrapper"><?php echo $servicefee['wrapper_fee1'];?></td>
                <td id="estimate_unpack"><?php echo $servicefee['unpack_fee1'];?></td>
                <td id="estimate_checkorder"><?php echo $servicefee['checkorder_fee1'];?></td>
                <td id="estimate_largepackage">0</td>
                <td id="estimate_waybillphoto">0</td>
                <td id="estimate_donation">0</td>
                <td colspan="2" id="estimate_total"><?php echo $estimate_total;?></td>
              </tr>
            </table>
          </div>
          <input type="hidden" name="donation" class="donamount" value="0">
          <div class="next_btn"> <a href="<?php echo $lasstep;?>">
            <input class="lasstep"  type="button"  value="上一步">
            </a>
            <input class="nextstep" type="submit" value="下一步">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
<script src="catalog/view/javascript/jquery2/tosendorder.js"></script>
<?php echo $footer; ?>