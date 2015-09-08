<title>我的仓库-欢迎您来到CNstorm代购用户中心</title>
<meta name="keywords" content="用户中心，代购订单，自助购订单，转运订单，订单管理，仓储管理，运输管理，代购充值，优惠券，代寄订单" />
<meta name="description" content="cnstorm代购用户中心为你提供查看或管理代购订单，自助购订单，转运订单，及时尊享CNstorm专业客服团队及完善的售后保障体系"  />
<meta name="robots” content="nofollow” />
<?php echo $header_cart; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>可邮寄订单</h2>
    <span class="faqs"> <a href="/help.html" class="link-faq" title='使用帮助'>FAQ</a> </span></div>
  <div class="save_box" id="save_box_1">
    <form action="<?php echo $order_myhome_uqdate; ?>" method="post" enctype="multipart/form-data" id="form">
      <ul class="savebox_nav">
        <li>
          <div class="st_checkbox">
            <input id="savebox_chkbox" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);aaa();" />
            <label for="savebox_chkbox"><?php echo $text_check_all; ?></label>
          </div>
        </li>
        <li><em style="width:398px;">订单信息</em></li>
        <li><em style="width:68px;">数量</em></li>
        <li><em style="width:76px;"><?php echo $text_order_no; ?></em></li>
        <li><em style="width:168px;"><?php echo $text_come_time; ?></em></li>
        <li><em style="width:68px;">来源商家</em></li>
        <li><em style="width:89px;"><?php echo $text_weight; ?></em></li>
        <li><em style="width:38px;">属性</em></li>
        <!-- li class="detail_fi">
          <select onchange="order_change('myhome');"  name="filter_order_status_id" id="filter_order_status_id">
            <option value="*"></option>
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </li -->
      </ul>
      <?php if ($orders) {      
            foreach ($orders as $order) {   
      ?>
      <table class="storebox_cont">
        <tr>
          <td class="box_one">
            <div class="choose">
              <?php if($order['order_weight']) { ?>
              <?php if ($order['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" onclick="aaa();" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" onclick="aaa();"/>
              <?php } ?>
              <?php }else{  ?>
              <input disabled="disabled" type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" onclick="aaa();"/>
              <?php }  ?>
            </div>
          </td>
          <?php foreach ($order['product'] as $orde_product) { ?>
          <td class="box_two">
         
              <dl>
                <dt><a href="<?php echo $orde_product['producturl']; ?>" target="_blank"> <img src="<?php echo $orde_product['img']; ?>" /></a></dt>
                <dd><a style="display:block;font-size:12px;padding-left:10px;" href="<?php echo $orde_product['producturl']; ?>" target="_blank"> <?php echo mb_substr($orde_product['name'], 0, 21,"UTF-8")?> </a></dd>
              </dl>
              
            </td>
          <td class="box_three box_40"><?php if(array_key_exists('quantity',$orde_product)){echo intval($orde_product['quantity']);}?></td>
          <?php }?>
          <td class="box_three box_40"><?php echo $order['order_id'];?></td>
          <td class="box_four box_40"><?php echo $order['date_added'];?></td>
          <td class="box_five box_40"><?php if(array_key_exists('shop',$order)){echo $order['shop'];}?></td>
          <td class="box_five box_40"><?php echo $order['order_weight'];?>g</td>
          <td class="box_six box_40"><?php echo $order['order_sensitive'];?></td>
          <!-- td class="box_seven box_40"><?php echo $order['status'];?></td -->
        </tr>
      </table>
      <?php }} ?>
      <div class="storagebox_cont">
      <ul class="savebox_top">
        <li>
          <div class="st_checkbox">
            <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);aaa();" />
            <label for="savebox_chkbox"><?php echo $text_check_all; ?></label>
          </div>
        </li>
      </ul>
      <div class="creat_waybill">
      <span><?php echo $text_chosen; ?><b  id="hj">0</b><?php echo $text_chosen2; ?><b id="weight">0
    </form>
    </b>g</span> <a onclick="judgeweight()" class="button"><?php echo $text_create_waybill ; ?></a> </div>
</div>
</div>
</div>
</div>

<?php echo $footer; ?>
</body>
<script src="catalog/view/javascript/jquery2/uc_business.js"></script> 