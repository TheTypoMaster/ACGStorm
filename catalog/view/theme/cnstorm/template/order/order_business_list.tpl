        <form  id="batch_pay_form"  action="http://www.acgstorm.com/index.php?route=checkout/confirm" method="post" />
        
        <ul class="detail_dd2">
          <li class="detail_o pay_all">
            <input id="SelectAll_front" class="SelectAll_front check" name="SelectAll_front" type="checkbox" />
            <label><?php echo $text_check_all; ?></label>
          </li>
          <li class="detail_t pay_click">
            <input type="button" onclick="HasOrder()" value="<?php echo $text_merge_pay; ?>"/>
          </li>
        </ul>
        <?php     
                  if ($orders) {      
                  foreach ($orders as $order) {   
                ?>
        <div class="dingdan0">
          <p class="dd_head">
            <?php if(1 == $order['order_status_id']) { ?>
            <input class="dd_check check" id="<?php echo $order['order_id'];?>" type="checkbox" value="<?php echo $order['order_id'];?>" />
            <?php }else{  ?>
            <input class="dd_check check" id="<?php echo $order['order_id'];?>" type="checkbox" disabled="disabled" value="<?php echo $order['order_id'];?>" />
            <?php } ?>
            <span class="dd_code"><em><?php echo $order_Number;?></em><?php echo $order['order_id'];?></span> <span class="dd_time"><em><?php echo $order_time;?></em><?php echo $order['date_added'];?></span> <span class="dd_code"><em><?php echo $text_store_title; ?></em><a target="_blank" href="<?php echo $order['storeurl'];?>" ><?php echo $order['storename'];?></a></span> </p>
          <table class="zizhu_table" border="0" align="center" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td width="613" height="98"><table border="0" align="center" cellspacing="0" cellpadding="0">
                    <tbody>
                      <?php foreach ($order['product'] as $orde_product) {?>
                      <tr>
                        <td width="379" height="98" class="border_r noborder_r"><div class="dt_cloth"> <a href="javascript:void(0);" class="" ><img src="<?php if(isset($orde_product['img'])) echo $orde_product['img']; else echo '/uploads/big/0b4a96400b2372d25da769647bfe4059.jpg'; ?>" alt="<?php echo $text_product_img; ?>"></a>
                            <dl>
                              <dt><a target="_blank" href="<?php echo urldecode($orde_product['producturl']); ?>" ><?php echo $orde_product['name'];?></a><?php echo $orde_product['name'];?></a></dt>
                              <dd><em><?php echo $order_color;?></em><?php echo $orde_product['color'];?> <em class="produ"><?php echo $order_size;?></em><?php echo $orde_product['size'];?></dd>
                              <dd class="wait_pay"><em><?php echo $order_remark;?></em>
                                <?php if($order['order_status_id']==1){?>
                                <input type="text" id="beizhu_in" value="<?php echo $orde_product['note'];?>" class="beizhu_in<?php echo $orde_product['order_product_id']; ?>">
                                <input id="beizhu_correct" value="<?php echo $text_modify; ?>" type="button" class="<?php echo $orde_product['order_product_id']; ?>" style="<?php if($_SESSION['language'] == 'en') echo 'background: url(../images/ico_en.png) no-repeat -559px -1355px;' ?>" onclick="modify(<?php echo $orde_product['order_product_id']; ?>);" />
                                <span id="mod<?php echo $orde_product['order_product_id']; ?>" style="color:green;"></span>
                                <?php }else{ ?>
                                <?php echo $orde_product['note'];?>
                                <?php } ?>
                              </dd>
                            </dl>
                          </div></td>
                        <td width="140" height="98" class="border_r noborder_r" align="center">￥<?php echo $orde_product['price'];?></td>
                        <td width="90" height="98" class="border_r" align="center"><?php echo $orde_product['quantity'];?></td>
                      </tr>
                      <?php
                          }
                          
                          ?>
                    </tbody>
                  </table></td>
                <td width="100" class="border_r"><table border="0" align="center" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td align="center" class="fs4"><span class="price_total_<?php echo $order['order_id'];?>"><?php echo $order['product_total'];?></span><br>
                          <?php echo $order_shipping;?>+<span class="freight_<?php echo $order['order_id'];?>"><?php echo $order['order_shipping'];?></span></td>
                      </tr>
                    </tbody>
                  </table></td>
                <td width="119" class="border_r" align="center"><?php echo $order['status'];?></td>
                <td width="103" class="dt_quxiao" align="center"><?php if($order['order_status_id']==1){?>
                  <a class="pay_page ml10" onClick="singlePay(<?php echo $order['order_id'];?>)" href="javascript:void(0);"><?php echo $Payment ;?></a> <span class="dd_code pay_cancle" onClick="dede(<?php echo $order['order_id'];?>)"><em><?php echo $order_quxiao;?></em></span>
                  <?php }else if($order['order_status_id']==2){?>
                  
                  <!--已付款-->
                  
                  <?php if ( $order ['creq'] ) { ?>
                  <span class="dd_code" id="c<?php echo $order['order_id']; ?>"><em style="color:green;"><?php echo $text_urged; ?></span>
                  <?php }else{ ?>
                  <span class="dd_code" onclick="modify_c(<?php echo $order['order_id']; ?>);" id="c<?php echo $order['order_id']; ?>"><em><?php echo $text_urged_buy; ?></span>
                  <?php } ?>
                  <?php }else if($order['order_status_id']==4){?>
                  
                  <!--卖家已发货-->
                  
                  <p><a href='javascript:void(0);' class="kuaidi_<?php echo $order['order_id'];?>" onClick="kuaidi(<?php echo $order['order_id'];?>)" url='/index.php?route=order/order/track&expreser=<?php echo $orde_product['express'] ?>&no=<?php echo $orde_product['kuaidi_no'] ?><?php echo $kuaidi_query ?>' ><?php echo $text_check_logistics; ?> </a></p>
                  <p>
                    <?php if ( $order ['preq'] ) { ?>
                    <span class="dd_code" id="p<?php echo $order['order_id']; ?>"><em  style="color:green;"><?php echo $text_requested_photo; ?></span>
                    <?php }else{ ?>
                    <span class="dd_code" onclick="modify_p(<?php echo $order['order_id']; ?>);" id="p<?php echo $order['order_id']; ?>"><em><?php echo $text_photograph_photo; ?></span>
                    <?php } ?>
                  </p>
                  <?php }else if($order['order_status_id']==7){ ?>
                  
                  <!--缺货--> 
                  <span class="dd_code" onClick="dede(<?php echo $order['order_id'];?>,'daigou')"><em><?php echo $order_quxiao;?></em></span>
                  <?php }else if($order['order_status_id']==9){ ?>
                  
                  <!--待补交费用kenne--> 
                  <span class="dd_code pay_cancle" onclick='query_difference('<?php echo $order['order_id'];?>')'><em><?php echo $text_check_agio; ?></em></span> <a class="pay_page" onClick="payback(<?php echo $order['order_id'];?>)" href="javascript:void(0);"><?php echo $text_pay_agio; ?></a> <span class="dd_code pay_cancle" onClick="dede(<?php echo $order['order_id'];?>,'daigou')"><em><?php echo $order_quxiao;?></em></span>
                  <?php }?></td>
              </tr>
              <tr class="track_<?php echo $order['order_id'];?>" id="track" style="display:none;">
                <td colspan="9" align="center"><div class="deliver_info_close_<?php echo $order['order_id'];?>" style="display:none;cursor:pointer;"><img src='http://www.uuch.com/images/share/032.gif'/></br>
                    <?php echo $text_loading; ?></div>
                  <div class="deliver_info_<?php echo $order['order_id'];?>" ></div>
                  <br/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <?php  } }  ?>
        </ul>
        <ul class="detail_dd2" style="border-left:none; border-right:none;">
          <li class="detail_o pay_all">
            <input type="checkbox" name="SelectAll_front" class="SelectAll_front check" id="SelectAll_front">
            <label><?php echo $text_check_all; ?></label>
          </li>
          <li class="detail_t pay_click">
            <input type="hidden" name="batch_pay" id="batch_pay"/>
            <input type="button" onclick="HasOrder()" value="<?php echo $text_merge_pay; ?>">
          </li>
        </ul>
        </form>

      </div>
      <div class="pages_change "><?php echo $pagination; ?></div>
      <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <svg xmlns="http://www.w3.org/2000/svg" width="940px" height="840px" viewBox="0 0 80 60" preserveAspectRatio="none" >
        <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
        </svg> 
      </div>