<?php echo $header_cart; ?>
<title>提交运单 - 用户在CNstorm淘国货平台提交运输申请</title>
<meta name="keywords" content="代购,cnstorm代购,代购运单,代购网,代购商品" />
<meta name="description" content="会员直接登录CNstorm淘国货平台提交运输申请" />
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/cnstorm/stylesheet/transport.css"/>
<body>
<div class="waybill_info">
  <div class="wrap">
    <div class="ship-box">
      <form action="index.php?route=waybill/transport/getfee" method="post">
        <div class="steps_nav">
          <ul class="shipnav">
            <li class="text1">选择运单信息</li>
            <li class="text2">核对运单总价</li>
            <li class="text3">成功提交运单</li>
          </ul>
        </div>
        <div style="padding: 5px 10px;border: 1px solid #f9dfb2;margin: 10px;background: #ffffe0;float: left;width: 1138px;text-align: center;"> <strong>温馨提示：</strong>跟服务费时代说拜拜！北京时间6月25日上午10点起永久免收服务费，CNstorm以真正实惠回报用户，淘国货不止省了一点点！<a href="/index.php?route=help/announcement&id=2&bid=64" target="_blank" style="color:#0078b6;">查看详情</a></div>
        <div class="shipping_addr mt18">
          <h3>1 选择收货地址<i>为保证您的包裹邮寄时效性及送达率,请在下方点选或新增您的收货地址!</i></h3>
          <input type="hidden" name="address_count" id="address_count" value="<?php echo $address_count; ?>">
          <div id="address_wrap " class="address">
            <?php if ($address) { foreach ($address as $addres) { ?>
            <div class="option_box" id="<?php echo "old_address_".$addres['address_id'];?>" >
              <input id="<?php echo  $addres['address_id']?>" class="rdoAddress" type="radio" name="address_id" value="<?php echo  $addres['address_id']?>">
              <label class="address_lbl" data_address="<?php echo $addres['address_id']; ?>" for="<?php echo  $addres['address_id'];?>">
              <span class="btnEditAddress_new" addressid="<?php echo  $addres['address_id'];?>" title="修改地址" onClick="edit_address('<?php echo  $addres['address_id'];?>')">修改</span> <span class="btnEditAddress_del" addressid="<?php echo  $addres['address_id'];?>" title="删除地址"  onclick="del_address('<?php echo  $addres['address_id'];?>')">删除</span>
              <p> <span class="addr_name"><?php echo $addres['lastname']; ?></span> <span class="addr_con"><?php echo $addres['name']."-".$addres['city']."-".$addres['address_details']; ?></span> <span class="addr_num"><?php echo substr_replace($addres['telephone'],'****',3,4);?></span> </p>
              </label>
              <div class="clear"></div>
            </div>
            <?php } } ?>
            <div class="add_option_box">
              <label class="add_address_lbl" onclick="addnewaddr()">
              <div class="addr_newadd" ></div>
              </label>
            </div>
          </div>
          <div class="open_addr"><a href="javascript:void(0)" class="stri_open">展开收货地址<span></span></a></div>
          <div class="write_addr" id="address_info">
            <input id="country_en" type="hidden" value=""/>
            <input id="city_en" type="hidden" value=""/>
            <div class="newaddress_title"> <span>添加新地址</span> <span class="newaddress_close" ><a onClick="newaddress_close()">X</a></span> </div>
            <div class="newaddress_info">
              <input id="newaddress_id" type="hidden" value="" />
              <div class="addr"> <span class="addr_l">收件人：</span> <i>*</i>
                <input type="text"  class="newaddr_name"   id="lastname" placeholder="请输入收件人真实姓名" value="">
                <span class="error" id="no_name"><em>请输入收件人真实姓名</em><i></i></span> </div>
              <div class="addr"> <span class="addr_l">收货地址：</span> <i>*</i>
                <select name="country_id"  id="country_id" class="newaddr_countrycity"  onchange="show_city(this)">
                  <option value="">国家</option>
                  <?php foreach ($countries as $country) { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                </select>
                <select name="zone_id" id="zone_id" class="newaddr_countrycity" onChange="this_city()">
                  <option value="">州/省/郡</option>
                </select>
                <span id="no_add" class="error"><em>请选择收货地址的国家</em><i></i></span> </div>
              <div class="addr"> <span class="addr_l">详细地址：</span> <i>*</i>
                <input class="newaddr_details" id="addressdetails" value="" placeholder="请输入详细地址，例如城市以及路名或街道地址，门牌号">
                <span id="no_details" class="error "><em>请输入收货地址的详细地址</em><i></i></span> </div>
              <div class="addr"> <span class="addr_l">邮政编码：</span> <i>*</i>
                <input type="text" id="postcode" value="" placeholder="请输入邮政编码" class="newaddr_postcode">
                <span id="no_postcode" class="error "><em>请输入收货地址邮政编码,仅支持数字 字母</em><i></i></span> </div>
              <div class="addr"> <span class="addr_l">联系电话：</span> <i>*</i>
                <input type="text" id="tel" value="" placeholder="请输入收件人联系号码" class="newaddr_tel">
                <span id="no_tel" class="error "><em>请输入收件人联系电话,仅支持数字 '+' '-'</em><i></i></span> </div>
              <div class="addr"> <a href="javascript:void(0);" class="btn" onClick="save_address()">保存</a> </div>
            </div>
          </div>
          <div class="dlg_bg" id="dlg_bg" > </div>
          <div class="address_btns_wrap">
            <div class="address_more" style="display:none"></div>
            <a class="add_address_btn" href="javascript:void(0)"></a> </div>
        </div>
        <div class="send_layer">
          <div class="shipping_items mt18">
            <h3>2 确认包裹信息</h3>
            <div class="simplify-pak"><span class="info_cut_pic"><span class="cut_tip"></span></span>是否精简包装:&nbsp;&nbsp;
              <input type="radio" name="pak" value="1"/>
              是&nbsp;&nbsp;
              <input type="radio" name="pak" value="0" checked />
              否 </div>
            <div id="shipping_good_info">
              <input type="hidden" name="order_id_combination" id="order_id_combination"   value="<?php echo $order_id_combination; ?>">
              <input type="hidden" name="sensitive" id="sensitive" value="<?php echo $sensitive;?>">
              <input type="hidden" name="brand" id="brand" value="<?php echo $brand;?>">
              <table class="infor_tab" border="0" align="center" cellspacing="0" cellpadding="0">
                <thead class="infor_title">
                  <tr>
                    <th width="698" class="align_l">商品信息</th>
                    <th width="240">商品属性</th>
                    <th width="138">操作</th>
                    <th width="98">物品重量(g)</th>
                  </tr>
                </thead>
                <?php if($order_info){ foreach ($order_info as $info) { ?>
                <?php if($info['good_info']){  for($i=0;$i<count($info['good_info']);$i++){?>
                <tr>
                  <td><?php if($info['good_info'][$i]['img']){ ?>
                    <a class="good_img" target="_blank" href="<?php echo $info['good_info'][$i]['producturl'];?>"><img src="<?php echo $info['good_info'][$i]['img'];?>"></a>
                    <?php }else{ ?>
                    <a class="good_img" href="#"><img src="images/post/cnstorm.jpg"></a>
                    <?php } ?>
                    <dl class="good_info">
                      <dd class="good_name"><a target="_blank" href="<?php echo $info['good_info'][$i]['producturl'];?>"><?php echo $info['good_info'][$i]['name'];?></a></dd>
                      <dd> <span class="good_color">颜色:<strong><?php echo $info['good_info'][$i]['option_color'];?></strong></span> <span class="good_size">尺码:<strong><?php echo $info['good_info'][$i]['option_size'];?></strong></span> </dd>
                    </dl></td>
                  <td><?php if(2 == $info['good_info'][$i]['order_sensitive']){ ?>
                    <dd class="sensitive">敏感品</dd>
                    <?php }else{ ?>
                    <dd class="sensitive"></dd>
                    <?php } ?>
                    <?php if(2 == $info['good_info'][$i]['order_branding']){ ?>
                    <dd class="sensitive">品牌</dd>
                    <?php }else{ ?>
                    <dd class="sensitive"></dd>
                    <?php } ?>
                    <?php if(2 == $info['good_info'][$i]['order_huge']){ ?>
                    <dd class="sensitive">重抛</dd>
                    <?php }else{ ?>
                    <dd class="sensitive"></dd>
                    <?php } ?></td>
                  <?php if($i === 0){ ?>
                  <td class="layback" rowspan="<?php echo count($info['good_info']);?>"><a onClick="layback(<?php echo $info['order_id'];?>)">放回仓库</a></td>
                  <td class="weight" rowspan="<?php echo count($info['good_info']);?>"><?php echo $info['weight'];?></td>
                  <?php }else{ ?>
                  <?php } ?>
                </tr>
                <?php }} ?>
                <?php }} ?>
              </table>
              <input type="hidden" name="weight" id="weight" value="<?php echo $total_weight;?>">
              <div class="total_weights">重量合计：<b> <?php echo $total_weight; ?> </b> g</div>
            </div>
          </div>
          <div class="carrier mt18">
            <h3>3 选择运输方式<i>超多专业物流路线供您选择，以最优质的服务回报您！</i></h3>
            <div class="ex_content">
              <div class="ex-title">
                <div class="ah0">运输方式</div>
                <div class="s-line">|</div>
                <div class="ah1">首重价格(<span class="rmb">￥</span>)</div>
                <div class="s-line">|</div>
                <div class="ah2">续重价格(<span class="rmb">￥</span>)</div>
                <div class="s-line">|</div>
                <div class="ah3">限重(g)</div>
                <div class="s-line">|</div>
                <div class="ah4">预计时效</div>
                <div class="s-line">|</div>
                <div class="ah5">线路特点</div>
              </div>
              <div class="ex-list" id="ex_list">
                <div class="loading">
                  <p class="area-notice">您还没有选择收货地址哦!快去选择吧^-^</p>
                </div>
              </div>
            </div>
            <div class="next_btn">
              <input id="de_button" style="display:none" class="nextstep" type="submit" value="下一步">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
<script src="catalog/view/javascript/jquery2/tosendorder.js"></script>
<?php echo $footer; ?>