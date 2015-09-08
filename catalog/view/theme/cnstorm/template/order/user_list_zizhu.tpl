<?php echo $header; ?>
<title>  自助购订单-CNstorm自助购为你提供自助购订单管理</title>     
<meta name="keywords" content="自助购服务，自助购订单，自助购列表，订单信息，订单编号，合并订单，快递公司，订单状态" />      
<meta name="description" content="欢迎来到你的自助购订单页面，对你的自助购订单状态进行管理" />

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="daigou_list">
        <div class="dl_head">
          <h3 class="bg1">自助购订单</h3>
          <div class="dl_h_input">
            <input class="search_box" type="text" value=""  id="keyworld"/>
            <input class="search_btn" type="button" value="搜索" onclick="keyworld()"/>
            <a href="javascript:void(0);">按时间范围搜索</a></div>
        </div>
        <div class="all_dingdan">
          <ul class="dingdan_list">
            <li><a class="on" href="javascript:void(0);">自助购订单</a></li>
            <li><a href="<?php echo $snatch;?>">我要自助购</a></li>
            <!--<li><a href="javascript:void(0);">我要自助购</a></li>-->
          </ul>
          <div class="dg_dingdan">
            <ul class="detail_dd">
              <li class="detail_o">订单信息</li>
              <li class="detail_t">单价（元）</li>
              <li class="detail_th">数量</li>
              <li class="detail_fo">快递公司</li>
              <li class="detail_fi">
                <select onchange=order_change("zizhu");name="filter_order_status_id" id="filter_order_status_id">
                  <option value="*"></option>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </li>
              <li class="detail_si">操作</li>
            </ul>
            <?php 	  
			 if ($orders) {		  
            foreach ($orders as $order) {		
			?>
            <div class="dingdan0">
              <p class="dd_head"><span class="dd_code"><em>订单编号：</em><?php echo $order['order_id'];?></span><span class="dd_time"><em>时间：</em><?php echo $order['date_added'];?></span><span class="shop_owner"><em>店铺：</em><a target="_blank" href="<?php echo $order['storeurl'] ; ?>"><?php echo $order['storename']; ?></a></span></p>
              <table class="zizhu_table" border="0" align="center" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td width="613" height="98"><table border="0" align="center" cellspacing="0" cellpadding="0">
                        <tbody>
                          <?php foreach ($order['product'] as $orde_product) { 		 ?>
                          <tr>
                            <td width="379" height="98" class="border_r border_b"><div class="dt_cloth"> <a class="" href="javascript:void(0);"><img alt="产品图片" src="<?php echo $orde_product['img']; ?>" ></a>
                                <dl>
                                  <dt><?php echo $orde_product['name'];?></dt>
                                  <dd><em>颜色：</em><?php echo $orde_product['color'];?> <em>尺码：</em><?php echo $orde_product['size'];?></dd>
                                  <dd class="wait_pay"><em>备注：</em>
                                    <input type="text" id="beizhu_in" value="<?php echo $orde_product['note'];?>">
                                </dl>
                              </div></td>
                            <td width="140" height="98" class="border_r border_b border_b" align="center">￥<?php echo $orde_product['price'];?></td>
                            <td width="90" height="98" class="border_r border_b" align="center"><?php echo $orde_product['quantity'];?></td>
                          </tr>
                          <?php 	}	?>
                        </tbody>
                      </table>
                        <td width="100" class="border_r"><table border="0" align="center" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td align="center"><div class="dt_express_add">
                                <?php if($order['status']=="待发货"){?>
                                <a href="javascript:void(0);" onClick="dt_express_add(<?php echo $order['order_id'];?>)">填写物流</a>
                                <div class="wl_box" id="wl_box_<?php echo $order['order_id'];?>" style="display:none;">
                                  <div class="wl_information"> <span class="wl_com">快递公司：</span> <span class="wl_border">
                                    <select name="express_change" id="btexpresses_<?php echo $order['order_id'];?>">
                                      <option value="*">请选择快递公司</option>
                                      <?php foreach ($expresses as $express) { ?>
                                      <option value="<?php echo $express['name_en']; ?>"><?php echo $express['name_cn']; ?></option>
                                      <?php } ?>
                                    </select>
                                    </span> </div>
                                  <div class="wl_information"> <span class="wl_com">物流单号：</span>
                                    <input type="text" class="wl_border" id="bt_expressno_<?php echo $order['order_id'];?>" name="bt_expressno_<?php echo $order['order_id'];?>"/>
                                    <input type="hidden" name="hidden" value="hidden" id="hid"/>
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id'];?>" id="hid"/>
                                  </div>
                                  <div class="wl_update"> <a href="javascript:void(0);" class="tijiao" onclick="bt_express(<?php echo $order['order_id'];?>);">提交</a> <a href="javascript:void(0);" class="cancelit" onClick="cancelit(<?php echo $order['order_id'];?>)">取消</a> <b class="red noexpress_<?php echo $order['order_id'];?>">请选择快递公司！</b><b class="red nonum_<?php echo $order['order_id'];?>">请输入数字单号！</b></div>
                                  </form>
                                  <em class="po_top"></em> </div>
                              </div>
                              <?php }else if($order['status']=="卖家已发货"){?>
                              <a href='javascript:void(0);' class='kuaidi' id="<?php echo $order['order_id'];?>" onclick="kuaidi(<?php echo $order['order_id'];?>)" url='http://www.acgstorm.com/index.php?route=order/order/track&expreser=<?php echo $orde_product['express'] ?>&no=<?php echo $orde_product['kuaidi_no'] ?><?php echo $kuaidi_query ?>' >查看物流 </a>
                              <?php } ?></td>
                          </tr>
                        </tbody>
                      </table></td>
                    <td width="119" class="border_r" align="center"><?php echo $order['status'];?></td>
                    <td width="103" align="center">
                    <a onclick="dede(<?php echo $order['order_id'];?>,'zizhu');" href="javascript:void(0);"><?php echo $order_quxiao;?></a>
                    </td>
                  </tr>
                  <tr class="track_<?php echo $order['order_id'];?>" id="track" style="display:none;">
                    <td colspan="9" align="center"><div class="deliver_info_close_<?php echo $order['order_id'];?>" style="display:none;cursor:pointer;">加载中...</div>
                      <div class="deliver_info_<?php echo $order['order_id'];?>" ></div>
                      </br></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php } }  ?>
           <div class="pages_change"><?php echo $pagination; ?></div>
    
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<?php echo $footer; ?> 
