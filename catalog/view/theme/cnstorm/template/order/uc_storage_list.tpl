<title><?php echo $text_mystore_head; ?></title>
<?php echo $header; ?>

<script charset="UTF-8" type="text/javascript">
window.onload=function(){  
  $('#save_box_1').hide();
  $('#save_box_2').hide();
        $('#pc1').removeClass('on');
        $('#save_box_'+<?php if (isset($id)) echo $id ?>).fadeIn();
        $('#pc'+<?php if (isset($id)) echo $id ?>).addClass('on');
}
</script>


<div class="goods_details_bg">
<div class="yhzx wrap">
<div class="user_center">
<?php echo $column_left ;?>
<div class="all_dingdan">
<ul class="dingdan_list">
  <li><a id="pc1" href="javascript:void(0);" class="on"><?php echo $text_mystore_list; ?></a></li>
  <li><a id="pc2" href="javascript:void(0);"><?php echo $text_mystore_address; ?></a></li>
</ul>

<div class="save_box" id="save_box_1">
<form action="<?php echo $order_myhome_uqdate; ?>" method="post" enctype="multipart/form-data" id="form">
  <ul class="savebox_top" style="border-bottom:none; border-top:none;">
    <li>
      <div class="st_checkbox">
        <input id="savebox_chkbox" type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);aaa();" />
        <label for="savebox_chkbox"><?php echo $text_check_all; ?></label>
      </div>
    </li>
  </ul>
  <ul class="savebox_nav">
    <li><em class="sn_one"><?php echo $text_package_info; ?></em></li>
    <li><em style="width:100px;"><?php echo $text_order_no; ?></em></li>
    <li><em style="width:155px;"><?php echo $text_come_time; ?></em></li>
    <li><em style="width:75px;">单件商品重量</em></li>
    <li><em style="width:100px;"><?php echo $text_weight; ?></em></li>
    <li><em style="width:60px;">商品属性</em></li>
    <li class="detail_fi">
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
    </li>
  </ul>
  <?php if ($orders) {      
            foreach ($orders as $order) {   
      ?>
  <table class="storebox_cont"><tr>
    <td class="box_two">
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
    <div>
	  <table class="detail">
            <?php foreach ($order['product'] as $orde_product) { ?>
	    <tr><td><a href="<?php echo $orde_product['producturl']; ?>" target="_blank">
	      <img src="<?php echo $orde_product['img']; ?>" /></a></td>
	      <td><a style="display:block;font-size:12px;padding-left:10px;" href="<?php echo $orde_product['producturl']; ?>" target="_blank">
              <?php echo mb_substr($orde_product['name'], 0, 21,"UTF-8")?>
            </a></td></tr>
            <?php }?>
          </table>
    </div>
    </td>
    <td class="box_three box_40"><?php echo $order['order_id'];?></td>
    <td class="box_four box_40"><?php echo $order['date_added'];?></td>
    <?php if (count(explode('g',$order['order_signal_weight']))>2){ ?>
    <td class="box_five box_40"><?php echo $order['order_signal_weight'];?></td>
    <?php }else{ ?>
    <td class="box_five box_40"><?php echo $order['order_weight'];?>g</td>
    <?php } ?>
    <td class="box_five box_40"><?php echo $order['order_weight'];?>g</td>
    <td class="box_six box_40"><?php echo $order['order_sensitive'];?></td>
    <td class="box_seven box_40"><?php echo $order['status'];?></td>
  </tr></table>
  <?php
          }
          }
          ?>
  <div class="storagebox_cont">
    <ul class="savebox_top">
      <li>
        <div class="st_checkbox">
          <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);aaa();" />
          <label for="savebox_chkbox"><?php echo $text_check_all; ?></label>
        </div>
      </li>
      
      <!--<input name="soids" id="soids" value="" type="hidden"/>-->
    </ul>


    <div class="creat_waybill"> <span><?php echo $text_chosen; ?><b  id="hj">0</b><?php echo $text_chosen2; ?><b id="weight">0</form></b>g</span> 
    <a onclick="judgeweight()" class="button"><?php echo $text_create_waybill ; ?></a> </div>


  </div>
</div>
<div class="save_box" id="save_box_2" style="display:none;">
  <h3 class="storage_address"><?php echo $text_mystore_address2; ?></h3>
  <table  border="0" align="center" cellpadding="0" cellspacing="0" class="storage_list">
    <tbody>
      <tr>
        <td class="left">收货人(Name)：</td>
        <td class="right"><table  border="0" cellpadding="0" cellspacing="0" class="storage_right">
            <tbody>
              <tr>
                <td width="659"><?php echo $customer_name;?>  （<b>重要</b>）</td>
                <input id="copy_txt0" type="hidden" value="<?php echo $customer_name;?>" />
                <td><a class="copy_btn" data-clipboard-target="copy_txt0" data="0" href="javascript:void(0);">复制</a></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td class="left">省(State)：</td>
        <td class="right"><table  border="0" cellpadding="0" cellspacing="0" class="storage_right">
            <tbody>
              <tr>
                <td width="659" id='copy_txt1'>广东</td>
                <td><a class="copy_btn" data-clipboard-target="copy_txt1" data="1" href="javascript:void(0);">复制</a></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td class="left">城市(City)：</td>
        <td class="right"><table  border="0" cellpadding="0" cellspacing="0" class="storage_right">
            <tbody>
              <tr>
                <td width="659" id='copy_txt2'>深圳市</td>
                <td><a class="copy_btn" data-clipboard-target="copy_txt2" data="2" href="javascript:void(0);">复制</a></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td class="left">地址(Address)：</td>
        <td class="right"><table  border="0" cellpadding="0" cellspacing="0" class="storage_right">
            <tbody>
              <tr>
                <td width="659">宝安区西乡三围航空路30号同安物流园D栋302(信恩世通代寄部) （<b>重要</b>）</td>
                <input id='copy_txt3' type="hidden" value="宝安区西乡三围航空路30号同安物流园D栋302(信恩世通代寄部)" />
                <td><a class="copy_btn" data-clipboard-target="copy_txt3" data="3" href="javascript:void(0);">复制</a></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td class="left">邮编(Zip Code)：</td>
        <td class="right"><table  border="0" cellpadding="0" cellspacing="0" class="storage_right">
            <tbody>
              <tr>
                <td width="659" id='copy_txt4'>518101</td>
                <td><a class="copy_btn" data-clipboard-target="copy_txt4" data="4" href="javascript:void(0);">复制</a></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td class="left none_bott">电话(Tel)：</td>
        <td class="right none_bott"><table  border="0" cellpadding="0" cellspacing="0" class="storage_right">
            <tbody>
              <tr>
                <td width="659" id='copy_txt5'>0755-81466633</td>
                <td><a class="copy_btn" data-clipboard-target="copy_txt5" data="5" href="javascript:void(0);">复制</a></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
  <p class="notice"><?php echo $text_mystore_introduction; ?></p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php echo $footer; ?> 
<script type="text/javascript" src="catalog/view/javascript/jquery2/ZeroClipboard.min.js" ></script>
<script>
//----------复制按钮
ZeroClipboard.config( { swfPath: 'catalog/view/javascript/jquery2/ZeroClipboard.swf' } );
var clip = new ZeroClipboard( $(".copy_btn") );
clip.on("copy", function(e){
  alert('复制成功！');
});
//----------

function aaa() {
    var nums = 0;
    var chestr = "";
    var chk = document.getElementsByName('selected[]');
    for (var i = 0; i < chk.length; i++) {
        if (chk[i].checked) {
            nums++;
            chestr += chk[i].value + ",";
        }
    }
    document.getElementById('hj').innerHTML = nums;
    //$('#soids').val(chestr);
    $.ajax({
        type: "GET",
        url: "index.php?route=order/order/ajax_weight",
        data: "chestr=" + chestr,
        success: function(msg) {
            document.getElementById('weight').innerHTML = msg;
        }
    });
}

function judgeweight() {
  if($('#weight').html() > 0)  
    $('#form').submit();
  else  
    alert("请选择有重量的商品提交运单");
}
</script> 