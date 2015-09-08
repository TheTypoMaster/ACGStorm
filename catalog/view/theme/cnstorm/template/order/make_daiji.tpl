<title>代寄订单-CNstorm代寄为你提供代寄订单管理</title>
<meta name="keywords" content="代寄服务，代寄订单，代寄列表，订单信息，订单编号，合并订单，快递公司，代寄商品" />
<meta name="description" content="欢迎来到你的代寄订单页面，对你的代寄订单状态进行管理" />
<?php echo $header; ?>


<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="">
        <div class="dl_head">
          <h3 class="bg1"><?php echo $order_daiji;?></h3>
          <div class="all_dingdan">
            <ul class="dingdan_list">
              <li><a href="/index.php?route=order/make">我要代购</a></li>
              <li><a href="/index.php?route=order/snatch">我要自助购</a></li>
              <li><a class="on" href="javascript:void(0);"><?php echo $woyaodaiji;?></a></li>
            </ul>
            <div class="dg_dingdan">
              <div id="service-address-daiji" class="box selfpurchase-address-box">
                <div class="address-memo">
                  <h4>收件人：<?php echo $customer_name;?></h4>
                  <p>收货地址：广东省深圳市宝安区西乡三围航空路30号同安物流园D栋302(信恩世通代寄部)</p>
                  <p>邮编：518101&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话：0755-81466633&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/order-order-order_myhome.html&id=2" target="_blank">使用地址复制工具</a></p>
                  <p class="address-tips">代寄时，不要忘记将您的收货地址修改为上面的收货地址哦！</p>
                </div>
              </div>
              <div class="dj_company">
                <form action="/index.php?route=order/make/daiji_submit" method="post" enctype="multipart/form-data" id="form">
                  <div class="dj_list dj_exp"> <span><?php echo $express_company;?></span>
                    <select name="expresses" id="expresses">
                      <option value="*">请选择快递公司</option>
                      <?php 
	        	   foreach ($expresses as $expresse) { ?>
                      <option value="<?php echo $expresse['name_en']; ?>"><?php echo $expresse['name_cn']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="dj_list dj_num"> <span><?php echo $express_number;?></span>
                    <input name="express_number" id="express_number" type="text" value="" />
                    <b class="red nonum">请输入数字！</b> </div>
                  <div class="dj_list dj_nam"> <span><?php echo $order_daiji_name;?></span>
                    <input name="order_daiji_name"  id="order_daiji_name" type="text" value="" placeholder="如“家人寄来，朋友寄来”"/>
                    <b class="red nosource">请输入包裹来源！</b></div>
                  <div class="dj_list dj_msg"> <span><?php echo $order_Parcel;?></span>
                    <textarea name="order_Parcel" id="order_Parcel" placeholder="填写物品清单，如“鞋子38码两双，衬衫L码两件”"></textarea>
                    <b class="red nonote">请输入包裹备注！</b> </div>
                  <input type="hidden" name="insert_order" value="submit" id="hid">
                  <div class="dj_list">
                    <input class="sure_btn" type="button" value="提交订单" onclick="check();"/>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 