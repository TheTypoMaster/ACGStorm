<div class="dg_dingdan">
              <ul class="detail_dd">
                <li class="detail_o"><?php echo $order_info;?></li>
                <li class="detail_t"><?php echo $order_price;?></li>
                <li class="detail_th"><?php echo $order_qty;?></li>
                <li class="detail_fo"><?php echo $order_company;?></li>
                <li class="detail_fi">
                  <select onchange=order_change('two'); name="filter_order_status_id" id="filter_order_status_id">
                    <option value="*"><?php echo $text_all_order; ?></option>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if (isset($order_status_id) && $order_status['order_status_id'] == $order_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </li>
                <li class="detail_si"><?php echo $order_operating; ?></li>
              </ul>
              <?php     
         if ($orders) {     
              foreach ($orders as $order) {   
        ?>
              <div class="dingdan0">
                <p class="dd_head"><span class="dd_code"><em><?php echo $order_Number;?></em><?php echo $order['order_id'];?></span><span class="dd_time"><em><?php echo $order_time;?></em><?php echo $order['date_added'];?></span><span class="shop_owner"><em><?php echo $text_store_title; ?></em>
                <?php if(strpos($order['storeurl'],'1688')) { ?>
                      <a class="albb" target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php }elseif(strpos($order['storeurl'],'taobao')) { ?>
                      <a class="taobao" target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php }elseif(strpos($order['storeurl'],'tmall')) { ?>
                      <a class="tmall" target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php }elseif(strpos($order['storeurl'],'jd')) { ?>
                      <a class="jd" target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php }elseif(strpos($order['storeurl'],'dangdang')) { ?>
                      <a class="dangdang" target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php }elseif(strpos($order['storeurl'],'amazon')) { ?>
                      <a class="amazon" target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php }else{ ?>
                      <a target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a>
                      <?php } ?>
                </span></p>
                <table class="zizhu_table" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td width="613" height="98"><table border="0" align="center" cellspacing="0" cellpadding="0">
                          <tbody>
                            <?php foreach ($order['product'] as $orde_product) { ?>
                            <tr>
                              <td width="379" height="98" class="border_r border_b"><div class="dt_cloth"> <a class="" href="javascript:void(0);"><img alt="<?php echo $text_product_img;?>" src="<?php if(isset($orde_product['img'])) echo $orde_product['img']; else echo '/uploads/big/0b4a96400b2372d25da769647bfe4059.jpg'; ?>" ></a>
                                  <dl>
                                    <dt><a href="<?php echo $orde_product['producturl'];?>" target="_blank"><?php echo $orde_product['name'];?></a></dt>
                                    <dd><em><?php echo $order_color;?></em><?php echo $orde_product['color'];?> <em><?php echo $order_size;?></em><?php echo $orde_product['size'];?></dd>
                                    <dd class="wait_pay"><em><?php echo $order_remark;?></em>
                                      <input type="text" id="beizhu_in" value="<?php echo $orde_product['note'];?>">
                                    </dd>
                                  </dl>
                                </div></td>
                              <td width="140" height="98" class="border_r border_b border_b" align="center">￥<?php echo $orde_product['price'];?></td>
                              <td width="90" height="98" class="border_r border_b" align="center"><?php echo $orde_product['quantity'];?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      <td width="90" height="98" class="border_r border_b" align="center"><table border="0" align="center" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td align="center"><div class="dt_express_add">
                                  <?php if($order['order_status_id']==3){?><!--待发货-->
                                  <a href="javascript:void(0);" onClick="dt_express_add(<?php echo $order['order_id'];?>)"><?php echo $text_fillin_logistics;?></a>
                                  <div class="wl_box" id="wl_box_<?php echo $order['order_id'];?>" style="display:none;">
                                    <div class="wl_information"> <span class="wl_com"><?php echo $order_company;?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class="wl_border">
                                      <select name="express_change" id="btexpresses_<?php echo $order['order_id'];?>">
                                        <option value="*"><?php echo $text_select_express;?></option>
                                        <?php foreach ($expresses as $express) { ?>
                                        <option value="<?php echo $express['name_en']; ?>"><?php echo $express['name_cn']; ?></option>
                                        <?php } ?>
                                      </select>
                                      </span> </div>
                                    <div class="wl_information"> <span class="wl_com"><?php echo $text_express_no;?></span>
                                      <input type="text" class="wl_border" id="bt_expressno_<?php echo $order['order_id'];?>" name="bt_expressno_<?php echo $order['order_id'];?>"/>
                                      <input type="hidden" name="hidden" value="hidden" id="hid"/>
                                      <input type="hidden" name="order_id" value="<?php echo $order['order_id'];?>" id="hid"/>
                                    </div>
                                    <div class="wl_update"> <a href="javascript:void(0);" class="tijiao" onclick="bt_express(<?php echo $order['order_id'];?>);"><?php echo $text_submit;?></a> <a href="javascript:void(0);" class="cancelit" onClick="cancelit(<?php echo $order['order_id'];?>)"><?php echo $order_quxiao;?></a> <b class="red noexpress_<?php echo $order['order_id'];?>"><?php echo $text_select_express;?>!</b><b class="red nonum_<?php echo $order['order_id'];?>"><?php echo $text_fillin_nubmer;?></b></div>
                                    <em class="po_top"></em> </div>
                                </div>
                                <?php }else if($order['order_status_id']==4){?><!--卖家已发货-->
                                <a href='javascript:void(0);' class="kuaidi_<?php echo $order['order_id'];?>" onclick="kuaidi(<?php echo $order['order_id'];?>)" url='/index.php?route=order/order/track&expreser=<?php echo $orde_product['express'] ?>&no=<?php echo $orde_product['kuaidi_no'] ?><?php echo $kuaidi_query ?>' ><?php echo $text_check_logistics;?> </a>
                                <?php } ?></td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="119" class="border_r" align="center"><?php echo $order['status'];?></td>
                      <td width="103" align="center"><?php if($order['order_status_id']==6){}else if($order['order_status_id']==8){}else{?><!--6已入库8已经提交运送-->
                        <a onclick="dede(<?php echo $order['order_id'];?>,'zizhu');" href="javascript:void(0);"><?php echo $order_quxiao;?></a>
                        <?php } ?></td>
			
			
		<td width="119" class="border_r" align="center">
			<?php if($order['order_status_id']==2){?><!--已付款-->
				<p style="cursor:pointer;"><?php if ( $order ['creq'] ) { ?>
					<span class="dd_code" id="c<?php echo $order['order_id']; ?>"><em style="color:green;"><?php echo $text_urged; ?></em></span>
				<?php }else{ ?>
					<span class="dd_code" onclick="modify_c(<?php echo $order['order_id']; ?>);" id="c<?php echo $order['order_id']; ?>"><em><?php echo $text_urged_buy; ?></em></span>
				<?php } ?></p>
			<?php }else if($order['order_status_id']==4){?><!--卖家已发货-->
				<p style="cursor:pointer;"><?php if ( $order ['preq'] ) { ?>
					<span class="dd_code" id="p<?php echo $order['order_id']; ?>"><em  style="color:green;"><?php echo $text_requested_photo; ?></em></span>
				<?php }else{ ?>
					<span class="dd_code" onclick="modify_p(<?php echo $order['order_id']; ?>);" id="p<?php echo $order['order_id']; ?>"><em><?php echo $text_photograph_photo; ?></em></span>
				<?php } ?></p>
			<?php } ?>
		</td>


                    </tr>
                    <tr class="track_<?php echo $order['order_id'];?>" id="track" style="display:none;">
                      <td colspan="9" align="center"><div class="deliver_info_close_<?php echo $order['order_id'];?>" style="display:none;cursor:pointer;"><img src='http://www.uuch.com/images/share/032.gif'/></br><?php echo $text_loading;?></div>
                        <div class="deliver_info_<?php echo $order['order_id'];?>" ></div>
                        </br></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <?php } }  ?>
              <div class="pages_change"><?php echo $pagination; ?></div>
            </div>
            <!--
            <div class="pages_change">
              <ul class="list_num">
                <li class="pages_left"><a href="javascript:void(0);">&lt;</a></li>
                <li> </li>
                <li class="number on"><a href="javascript:void(0);">1</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">2</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">3</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">4</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">5</a></li>
                <li> </li>
                <li class="dot">...</li>
                <li class="pages_right"><a href="javascript:void(0);">&gt;</a></li>
                <li> </li>
                <li class="infor">共 50 页，到第</li>
                <li class="go_direct">
                  <input class="gd_input" type="text" value="" />
                </li>
                <li class="infor">页</li>
                <li class="btn"><a href="javascript:void(0);">确定</a></li>
              </ul>
            </div>
            -->
            <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
              <svg xmlns="http://www.w3.org/2000/svg" width="940px" height="840px" viewBox="0 0 80 60" preserveAspectRatio="none" >
                <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
              </svg>
            </div>
          </div>