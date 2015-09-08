<?php echo $header; ?>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="daigou_list">
        <div class="dl_head">
          <h3 class="bg1">自助购订单</h3>
          <div class="dl_h_input">
            <input class="search_box" type="text" value="请输入关键字进行搜索" />
            <input class="search_btn" type="button" value="搜索" />
            <a href="javascript:void(0);">按时间范围搜索</a></div>
        </div>
        <div class="all_dingdan">
          <ul class="dingdan_list">
            <li><a href="index.php?route=order/make">我要代购</a></li>
            <li><a class="on" href="<?php echo $snatch_cul;?>">我要自助购</a></li>
            <li><a href="index.php?route=order/make/order_daiji">我要代寄</a></li>
          </ul>
          <div class="dg_dingdan">
            <div class="need_daigou heights">
              <div id="service-address" class="box selfpurchase-address-box">
                <div class="address-memo">
                  <h3>收件人：<?php echo $customer_name;?></h3>
                  <p>收货地址：广东省深圳市宝安区西乡三围航空路30号同安物流园D栋302(信恩世通代寄部)</p>
                  <p>邮编：518101&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话：0755-81466633&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="order-order-order_myhome.html&id=2" target="_blank">使用地址复制工具</a></p>
                  <p class="address-tips">自助购时，不要忘记将您的收货地址修改为上面的收货地址哦！</p>
                </div>
              </div>
              <p>
              <form action="<?php echo $action; ?>" method="post">
                <input  placeholder="请输入自采购商品链接地址" name="daigouurl" value="" class="input_text"/>
                <input type="submit" value="获取商品信息" class="input_button"/>
                <input type="hidden" name="producturl" id="producturl" value="<?php echo $url; ?>" />
              </form>
              </p>
              <?php if($url) { ?>
              <div class="item_cont_r ml10">
                <div class="item_top">
                  <h3 class="item_txt" id="heading_title"><?php echo $heading_title;?></h3>
                </div>
                <div class="item_bott">
                  <div class="pictures"> <a href="javascript:void(0);" class="item_pic"> <img src="<?php echo $goodsimg;?>" id="img" alt="<?php echo $heading_title;?>" /> </a>
                    <?php if(strpos($url,'1688')) { ?>
                    <p class="maijia ml10">店铺：<a class="albb" target="_blank" href="<?php echo $storeurl;?>" id="shop">
                    <?php }elseif(strpos($url,'taobao')) { ?>
                    <p class="maijia ml10">店铺：<a class="taobao" target="_blank" href="<?php echo $storeurl;?>" id="shop">
                    <?php }elseif(strpos($url,'tmall')) { ?>
                    <p class="maijia ml10">店铺：<a class="tmall" target="_blank" href="<?php echo $storeurl;?>" id="shop">
                    <?php }elseif(strpos($url,'jd')) { ?>
                    <p class="maijia ml10">店铺：<a class="jd" target="_blank" href="<?php echo $storeurl;?>" id="shop">
                    <?php }elseif(strpos($url,'dangdang')) { ?>
                    <p class="maijia ml10">店铺：<a class="dangdang" target="_blank" href="<?php echo $storeurl;?>" id="shop">
                    <?php }elseif(strpos($url,'amazon')) { ?>
                    <p class="maijia ml10">店铺：<a class="amazon" target="_blank" href="<?php echo $storeurl;?>" id="shop">
                    <?php } ?>
                    <?php echo $storename;?></a></p>
                    <input type="hidden"  id="storename" name="storename" value="<?php echo $storename;?>"/>
                    <input type="hidden"  id="storeurl"  name="storeurl" value="<?php echo $storeurl;?>"/>
                  </div>
                  <div class="inform">
                    <ul class="taobao_shop">
                      <li class="price"><span id="price">商品价格：</span>
                        <input id="price2" type="text"  name="searchprice" value="<?php echo $price;?>" />
                        &nbsp;元 如读取错误，请您手动修改。</li>
                      <li class="express"><span>国内运费：</span>
                        <input type="text" id="searchfreight" name="searchfreight" value="<?php echo $isbn;?>" />
                        &nbsp;元 如读取错误，请您手动修改。</li>
                    </ul>
                    <dl class="num ml10">
                      <dt>购买数量：</dt>
                      <dd> <span class="click_num"><a href="javascript:void(0);" class="click_sub">-</a>
                        <input id="qty" class="num-pallets-input" type="text" name="quantity" value="1"/>
                        <a href="javascript:void(0);" class="click_add">+</a></span> </dd>
                    </dl>
                    <dl class="color ml10">
                      <dt>颜色分类：</dt>
                      <dd>
                        <ul class="color_list">
                          <input type="hidden" id="zizhucolor" name="zizhucolor"  value="" />
                          <?php if($ean) {
                                     if($api){
                                             foreach($ean as $signal_ean) {?>
                          <li id="color_wenzi2"><a class="color_wenzi" onclick="click_zizhu_color('<?php $getSignal_ean = array_keys($color_number,$signal_ean);  echo str_replace(':','_',($getSignal_ean[0]))?>', '<?php echo $signal_ean; ?>')" id="<?php $getSignal_ean = array_keys($color_number,$signal_ean);  echo str_replace(':','_',($getSignal_ean[0]))?>"><span><?php echo $signal_ean;?></span></a><i></i></li>
                           <?php }
                           }else{ 
                                       foreach($ean as $signal_ean) {?>
                          <li><a class="color_wenzi" onclick="preg_zizhu_color('<?php echo trim($signal_ean);?>')" ><span><?php echo $signal_ean;?></span></a><i></i></li>
                          <?php } }}else{ ?>
                          <input type="hidden" id="noColor" name="noColor"  value="noColor" />
                          <?php }?>
                        </ul>
                      </dd>
                    </dl>
                    <dl class="size ml10">
                      <dt>尺码大小：</dt>
                      <dd>
                        <ul class="size_list">
                          <input type="hidden" id="zizhusize" name="zizhusize" value="" />
                          <?php if($jan){
                                        if($api){
                                             foreach($jan as $signal_jan) {?>
                          <li><a class="color_wenzi" onclick="click_zizhu_size('<?php $getSignal_jan = array_keys($size_number,$signal_jan); echo str_replace(':','_',($getSignal_jan[0]))?>' , '<?php echo $signal_jan; ?>')" id="<?php $getSignal_jan = array_keys($size_number,$signal_jan); echo str_replace(':','_',($getSignal_jan[0]))?>"><span><?php echo $signal_jan; ?></span></a><i></i></li>
                          <?php }
                          }else{
                          	foreach($jan as $signal_jan) {?>
                          <li><a class="color_wenzi" onclick="preg_zizhu_size('<?php echo trim($signal_jan);?>')" ><span><?php echo $signal_jan; ?></span></a><i></i></li>
                          <?php }} }else { ?>
                          <input type="hidden" id="noSize" name="noSize"  value="noSize" />
                          <?php } ?>
                        </ul>
                      </dd>
                    </dl>
                    <dl class="beizhu ml10">
                      <dt>商品备注：</dt>
                      <dd>
                        <textarea id="remark"  placeholder="填写商品备注(可以写下您的特殊要求)"></textarea>
                      </dd>
                    </dl>
                    <ul class="gwc_btns">
                      <li class="add_goods_list"><a href="javascript:void(0);" onclick="list()">加入商品清单</a></li>
                    </ul>
                  </div>
                  <div class="CLR"></div>
                </div>
              </div>
              <?php } ?>
              <div class="zizhu_list">
                <ul class="savebox_top">
                  <li>
                    <h3>自助购商品清单</h3>
                  </li>
                  
                  <li> <span class="package_num"> <em>共<b><?php echo $selfproduct_total ?></b>件商品</em> </span> </li>
                </ul>
                <ul class="zizhu_head ml10">
                  <li class="zizhu_name">商品名称</li>
                  <li class="zizhu_num">数量</li>
                  <li class="zizhu_color">颜色</li>
                  <li class="zizhu_size">尺码</li>
                  <li class="zizhu_msg">备注</li>
                  <li class="zizhu_ope">操作</li>
                </ul>
                <?php if ($orders) {	?>
                <?php foreach($storenames as $key=>$value) { ?>
                <div class="post_box">
                    <?php if(strpos($key,'1688')) { ?>
                    <p class="seller">店铺：<a class="albb" target="_blank" href="<?php echo $key; ?>">
                    <?php }elseif(strpos($key,'taobao')) { ?>
                    <p class="seller">店铺：<a class="taobao" target="_blank" href="<?php echo $key; ?>">
                    <?php }elseif(strpos($key,'tmall')) { ?>
                    <p class="seller">店铺：<a class="tmall" target="_blank" href="<?php echo $key; ?>">
                    <?php }elseif(strpos($key,'jd')) { ?>
                    <p class="seller">店铺：<a class="jd" target="_blank" href="<?php echo $key; ?>">
                    <?php }elseif(strpos($key,'dangdang')) { ?>
                    <p class="seller">店铺：<a class="dangdang" target="_blank" href="<?php echo $key; ?>">
                    <?php }elseif(strpos($key,'amazon')) { ?>
                    <p class="seller">店铺：<a class="amazon" target="_blank" href="<?php echo $key; ?>">
                    <?php } ?>
                  <?php echo $value ;?></a></p>
                  <?php foreach ($orders as $order) {	?>
                  <?php if($order['store_name'] == $value) {?>
                  <ul class="buy_in">
                    <li class="buyin_one">
                      <dl>
                        <dt><img src="<?php echo  $order['img']  ?>" alt="订单"></dt>
                        <dd><?php echo  $order['product_name']  ?></dd>
                      </dl>
                    </li>
                    <li class="buyin_two"><?php echo  $order['qty'] ; ?></li>
                    <li class="buyin_three">
                      <?php if($order['color']) echo $order['color'];  ?>
                    </li>
                    <li class="buyin_four"> <?php echo $order['size'];?></li>
                    <li class="buyin_five">
                      <?php if($order['remark']) echo $order['remark'] ; ?>
                    </li>
                    <li class="buyin_six"><a onclick="del(<?php echo $order['id'];?>)">删除</a></li>
                  </ul>
                  <?php } } ?>
                </div>
                <?php 	}	}	?>
                <div class="get_zizhu"><a href="javascript:void(0);" onclick="addorder_selfshopping()">提交自助购</a></div>
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
<script type="text/javascript">
function list() {
    var heading_title = document.getElementById('heading_title').innerHTML;
    var producturl = encodeURIComponent(document.getElementById('producturl').value);
    var price = document.getElementById('price2').value;
    var searchfreight = document.getElementById('searchfreight').value;
    var qty = document.getElementById('qty').value;
    var remark = document.getElementById('remark').value;
    var img = document.getElementById('img').src;
    var seller = document.getElementById('shop').innerHTML;
    var color = document.getElementById('zizhucolor').value;
    var size = document.getElementById('zizhusize').value;
    var storename = document.getElementById('storename').value;
    var storeurl = document.getElementById('storeurl').value;
    var addForm = document.getElementById('addForm');

    if (!$('#noSize').val() && !size) {
        alert("请选择尺码。");

    } else if (!$('#noColor').val() && !color) {
        alert("请选择颜色。");
    } else {
        $.ajax({
            type: "post",
            url: "index.php?route=order/snatch/ajax_taobao_order",
            data: "heading_title=" + heading_title + "&price=" + price + "&producturl=" + producturl + "&searchfreight=" + searchfreight + "&qty=" + qty + "&remark=" + remark + "&seller=" + seller + "&img=" + img + "&color=" + color + "&size=" + size + "&storename=" + storename + "&storeurl=" + storeurl,
            success: function(msg) {
               location.replace(location);
            }
        });
    }

}


function addorder_selfshopping()
{
    $.ajax({
        url: 'index.php?route=order/snatch/addorder_self',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            alert("下单成功！");
            window.location.href = "index.php?route=order/order/order_two";
        },
        error: function(data) {
            alert("下单失败!");
        }
    });

}

function del(id) {

    $.ajax({
        url: 'index.php?route=order/snatch/del_one_selfproduct',
        type: 'POST',
        data: "id=" + id,
        dataType: 'json',
        success: function(data) {
            alert("删除成功！");
            location.replace(location);
        },
        error: function(data) {
            alert("删除失败!");
        }
    });

}


function dede(l) {
    window.location.href = "index.php?route=order/order/order_daigou&order_dede_id=" + l;
}


function insert() {
    window.location.href = "index.php?route=order/order/order_zizhu&insert=insert";
}

</script> 
