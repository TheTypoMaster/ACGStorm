  <div class="order_list">
    <ul class="detail_dd">
      <li class="detail_o bag_name" style="width:398px;"><?php echo $order_info;?></li>
      <li class="detail_fo exp_comp" style="width: 198px;"><?php echo $order_company;?></li>
      <li class="detail_fi">
        <select onchange=order_change("three");name="filter_order_status_id" id="filter_order_status_id">
          <option value="*"><?php echo $text_all_order; ?></option>
          <?php foreach ($order_statuses as $order_status) { ?>
          <?php if ( isset( $order_status_id ) &&  $order_status['order_status_id'] == $order_status_id) { ?>
          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </li>
      <li class="detail_si" style="width: 225px;"><?php echo $order_operating; ?></li>
    </ul>
    <?php 	  
  			 if ($orders) {		  
              foreach ($orders as $order) {		
  			?>
    <div class="dingdan0 daigou_hei">
      <p class="dd_head"><span class="dd_code"><em><?php echo $order_Number;?></em><?php echo $order['order_id'];?></span><span class="dd_time"><em><?php echo $order_time;?></em><?php echo $order['date_added'];?></span></p>
      <?php foreach ($order['product'] as $orde_product) {?>
      <ul class="dingdan_table">
        <li class="dt_infor bag_name" style="width:398px;">
          <dl>
            <dt class="dd_code"><em><?php echo $order_baoguo_name;?></em><?php echo $orde_product['name'];?></dt>
            <dd class="wait_pay"><em><?php echo $order_remark;?></em><?php echo $orde_product['note'];?></dd>
          </dl>
        </li>
        <li class="dt_express_add" style="width:198px;"><center><?php echo $orde_product['kuaid_gongsi'];?><br>
          <?php echo $orde_product['kuaidi_no'];?></center></li>
        <li class="dt_status" style="width:98px;"><center><?php echo $order['status'];?></center></li>
        <li class="dt_cancle" style="width: 280px; border-right:0;"><center>
        <?php if($order['order_status_id']==3){?>
        <!--待发货-->
        <a onclick="add_express(<?php echo $order['order_id'];?>);" href="javascript:void(0);"> <?php echo $text_fillin_logistics2; ?></a> / <a onclick="dede(<?php echo $order['order_id'];?>,'daiji');" href="javascript:void(0);"><?php echo $order_quxiao;?></a>
        <?php }else{ if($order['order_status_id']==6){}else if($order['order_status_id']==8){}else{?>
          <!--6已入库8已经提交运送--> 
          <a onclick="dede(<?php echo $order['order_id'];?>);" href="javascript:void(0);"><?php echo $order_quxiao;?></a>
          <?php } ?>
          <a href='javascript:void(0);' class="kuaidi_<?php echo $order['order_id'];?>" onclick="kuaidi(<?php echo $order['order_id'];?>)" url='/index.php?route=order/order/track&expreser=<?php echo $orde_product['express'] ?>&no=<?php echo $orde_product['kuaidi_no'] ?><?php echo $kuaidi_query ?>' ><?php echo $text_check_logistics;?> </a> 
          <?php if($order['order_status_id']==2){?>
          <!--已付款-->
          <p style="cursor:pointer;">
            <?php if ( $order ['creq'] ) { ?>
            <span class="dd_code" id="c<?php echo $order['order_id']; ?>"><em style="color:green;"><?php echo $text_urged; ?></em></span>
            <?php }else{ ?>
            <span class="dd_code" onclick="modify_c(<?php echo $order['order_id']; ?>);" id="c<?php echo $order['order_id']; ?>"><em><?php echo $text_urged_buy; ?></em></span>
            <?php } ?>
          </p>
          <?php }else if($order['order_status_id']==4){?>
          <!--卖家已发货-->
          <p style="cursor:pointer;">
            <?php if ( $order ['preq'] ) { ?>
            <span class="dd_code" id="p<?php echo $order['order_id']; ?>"><em  style="color:green;"><?php echo $text_requested_photo; ?></em></span>
            <?php }else{ ?>
            <span class="dd_code" onclick="modify_p(<?php echo $order['order_id']; ?>);" id="p<?php echo $order['order_id']; ?>"><em><?php echo $text_photograph_photo; ?></em></span>
            <?php } ?>
          </p>
          <?php } ?>
        <?php } ?></center>
        </li>
      </ul>
      <ul class="track_<?php echo $order['order_id'];?>" id="track" style="display:none;">
        <li style="margin: 10px 200px;">
          <div class="express_info_<?php echo $order['order_id'];?>" style="display:none;text-align:center;">
            <select name="btexpresses" id="btexpresses_<?php echo $order['order_id'];?>">
              <option value="*"><?php echo $text_select_express;?></option>
              <?php 
  	        	   foreach ($expresses as $expresse) { ?>
              <option value="<?php echo $expresse['name_en']; ?>"><?php echo $expresse['name_cn']; ?></option>
              <?php } ?>
            </select>
            <b class="red noexpress_<?php echo $order['order_id'];?>"><?php echo $text_select_express;?></b> <?php echo $express_number;?>
            <input name="bt_expressno" id="bt_expressno_<?php echo $order['order_id'];?>" type="text" value="" />
            <b class="red nonum_<?php echo $order['order_id'];?>"><?php echo $text_fillin_nubmer;?></b>
            <input class="bt_btn" type="button" value="<?php echo $text_submit;?>" onclick="bt_express(<?php echo $order['order_id'];?>);"/>
          </div>
          <div class="deliver_info_close_<?php echo $order['order_id'];?>" style="display:none;text-align:center;"><img src='http://www.uuch.com/images/share/032.gif'/></br>
            <?php echo $text_loading;?></div>
          <div class="deliver_info_<?php echo $order['order_id'];?>" ></div>
        </li>
      </ul>
      <?php } ?>
    </div>
    <?php }} ?>
    <div class="pages_change"><?php echo $pagination; ?></div>
  </div>
  <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <svg xmlns="http://www.w3.org/2000/svg" width="940px" height="840px" viewBox="0 0 80 60" preserveAspectRatio="none" >
    <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
    </svg> </div>