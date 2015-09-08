<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>国际运单详情-CNstorm国际转运为您提供国际运单管理</title>
<meta name="keywords" content="国际运单服务, 国际运单，运单列表，运单信息，运单编号，合并运单，快递公司，转运公司，国际转运，转运中国，中国转运，中国运输，海外转运" />
<meta name="description" content="欢迎来到你的国际运单页面，对你的运输订单状态进行管理" />
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $header_cart; ?>
<?php echo $uc_business; ?>

<div class="user_c_r">
<div class="daigou_list">
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center">
      <div class="inter_orders">
        <div class="dl_head">
          <h3 class="bg2">国际运单详情</h3>
        </div>
        <div class="dl_h_input">
          <div class="dg_dingdan"> 
            
            <!-- 邮寄信息 -->
            <ul class="detail_dd">
              <li class="detail_tras">收件人</li>
              <li class="detail_weigt">寄送国家</li>
              <li class="detail_tiji">联系电话</li>
              <li class="detail_addo">城市</li>
              <li class="detail_o">寄送地址</li>
              <li class="detail_fi">运单状态</li>
              <li class="detail_addo">预付费</li>
              <li class="detail_addt">重量</li>
            </ul>
            <?php 	  
 if ($result) {		  		
			?>
            <div class="daigou_hei">
              <p class="dd_head"><span class="dd_code"><em>订单编号：</em><?php echo $result['sid'];?></span><span class="dd_time"><em>时间：</em><?php echo date("Y-m-d H:i:s",$result['addtime']);?></span></p>
              <ul class="dingdan_table">
                <li class="dt_weight">
                  <dl>
                    <dt><?php echo $result['consignee'];?></dt>
                  </dl>
                </li>
                <li class="dt_weight" id="carrier<?php echo $result['sid'];?>"><?php echo $result['country'];?></li>
                <li class="dt_weight" id="sn<?php echo $result['sid'];?>"><?php echo $result['tel'];?></li>
                <li class="dt_addg"><?php echo $result['city'];?></li>
                <li class="dt_infor bag_name lineheight18"><?php echo $result['address'];?></li>
                <li class="dt_express dt_express_2"> <span class="dt_comp"><?php echo $status;?></span></li>
                <li class="dt_addg">￥<?php echo $result['totalfee'];?></li>
                <li class="dt_quxiao br_none1"><?php echo $result['countweight'];?>g</li>
              </ul>
            </div>
            <?php } ?>
            
            <!-- 邮寄商品列表 -->
            <?php 	  
 if ($order_products) {		?>
            <div class="all_dingdan ml-10">
              <ul class="detail_dd">
                <li class="detail_o">订单信息</li>
                <li class="detail_t">单价（元）</li>
                <li class="detail_th">数量</li>
                <li class="detail_fo">小计</li>
                <li class="detail_fi">重量</li>
                <li class="detail_si">状态</li>
              </ul>
              <?php foreach ($order_products as $products) { $order_product = $products[0];?>
              <div class="dingdan0">
                <p class="dd_head"> 
                  <!-- input class="dd_check" type="checkbox" value="" / --> 
                  <span class="dd_code"><em>订单编号:</em><?php echo $order_product['order_id']; ?></span> <span class="dd_time"><em>时间:</em><?php echo $order_product['uptime']; ?></span></p>
                <table class="zizhu_table" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td width="613" height="98"><table border="0" align="center" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="379" height="98" class="border_r noborder_r"><div class="dt_cloth"> <a href="javascript:void(0);" class=""><img alt="产品图片" src="<?php echo $order_product['img']; ?>"></a>
                                  <dl>
                                    <dt><a target="_blank" href="<?php echo $order_product['producturl']; ?>"><?php echo $order_product['name']; ?></a></dt>
                                    <dd><em>颜色:</em><?php echo $order_product['option_color']; ?> <em class="produ">尺码:</em><?php echo $order_product['option_size']; ?></dd>
                                    <dd class="wait_pay"><em>备注:</em> </dd>
                                  </dl>
                                </div></td>
                              <td width="140" height="98" class="border_r noborder_r" align="center">￥<?php echo $order_product['price']; ?></td>
                              <td width="90" height="98" class="border_r" align="center"><?php echo $order_product['quantity']; ?></td>
                            </tr>
                          </tbody>
                        </table></td>
                        
                      <td width="100" class="border_r"><table border="0" align="center" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td align="center"><span class="price_total_46185"><?php echo $order_product['total']; ?></span><br></td>
                            </tr>
                          </tbody>
                        </table></td>
                        
                      <td width="103" class="dt_quxiao border_r" align="center"><?php echo $order_product['weight']; ?></td>
                      <td width="119" class="" align="center"><?php if(count($products) > 1) {echo "<a href='javascript:void(0);' onclick='extra(".$order_product['order_id'].")'>查看所有商品</a>";} else {echo $status;} ?></td>
                    </tr>
                    <tr class="extra_info_<?php echo($order_product['order_id']); ?>" style="display:none;">
                      <td colspan="4">
                        <table class="zizhu_table" border="0" align="center" cellspacing="0" cellpadding="0">
                          <?php $q = count($products); if($q > 1) { for ($i=1; $i < $q; $i++) { ?>
                            <tr>
                              <td width="613" height="98"><table border="0" align="center" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td width="379" height="98" class="border_r noborder_r"><div class="dt_cloth"> <a href="javascript:void(0);" class=""><img alt="产品图片" src="<?php echo $products[$i]['img']; ?>"></a>
                                          <dl>
                                            <dt><a target="_blank" href="<?php echo $products[$i]['producturl']; ?>"><?php echo $products[$i]['name']; ?></a></dt>
                                            <dd><em>颜色:</em><?php echo $products[$i]['option_color']; ?> <em class="produ">尺码:</em><?php echo $products[$i]['option_size']; ?></dd>
                                            <dd class="wait_pay"><em>备注:</em> </dd>
                                          </dl>
                                        </div></td>
                                      <td width="140" height="98" class="border_r noborder_r" align="center">￥<?php echo $products[$i]['price']; ?></td>
                                      <td width="90" height="98" class="border_r" align="center"><?php echo $products[$i]['quantity']; ?></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                                
                              <td width="100" class="border_r"><table border="0" align="center" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center"><span class="price_total_46185"><?php echo $products[$i]['total']; ?></span><br></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                                
                              <td width="103" class="dt_quxiao border_r" align="center"><?php echo $products[$i]['weight']; ?></td>
                              <td width="119" class="" align="center"></td>
                            </tr>
                          <?php }} ?>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <?php }?>
            </div>
            <?php } ?>
          </div>
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
</body>
</html>