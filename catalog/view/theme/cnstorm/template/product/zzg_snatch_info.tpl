<div class="item_top">
  <h3 class="item_txt"><?php if ( isset( $heading_title ) )  echo $heading_title;?></h3>
  <input type="hidden" name="product_name"  value="<?php if ( isset( $heading_title ) )  echo $heading_title;?>" />
</div>
<div class="item_bott">
  <div class="pictures"> <a class="item_pic" href="javascript:void(0);"> <img src="<?php if ( isset( $goodsimg ) )  echo $goodsimg;?>" alt="<?php if ( isset( $heading_title ) )  echo $heading_title;?>" > </a>
    <?php if(isset($search) && $search){ 
                if(strpos($search,'1688')) { ?>
    <p class="maijia ml10">店铺：<a class="albb" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'taobao')) { ?>
    <p class="maijia ml10">店铺：<a class="taobao" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'tmall')) { ?>
    <p class="maijia ml10">店铺：<a class="tmall" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'jd')) { ?>
    <p class="maijia ml10">店铺：<a class="jd" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'dangdang')) { ?>
    <p class="maijia ml10">店铺：<a class="dangdang" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'amazon')) { ?>
    <p class="maijia ml10">店铺：<a class="amazon" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'mogujie')) { ?>
    <p class="maijia ml10">店铺：<a class="mogujie" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'meilishuo')) { ?>
    <p class="maijia ml10">店铺：<a class="meilishuo" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'vip')) { ?>
    <p class="maijia ml10">店铺：<a class="vipcom" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php }elseif(strpos($search,'jumei')) { ?>
    <p class="maijia ml10">店铺：<a class="jumei" target="_blank" href="<?php echo $storeurl;?>"><?php echo $storename;?></a></p>
    <?php } }?>
    <input type="hidden" id="store_name" name="store_name" value="<?php if(isset($storename)) echo $storename;?>" />
    <input type="hidden" name="store_url" value="<?php if(isset($storeurl))  echo $storeurl;?>" />
    <input type="hidden" name="imgurl" value="<?php if(isset($goodsimg))  echo $goodsimg;?>" />
	<input type="hidden" name="producturl" value="<?php if(isset($producturl))  echo $producturl;?>" />
  </div>
  <div class="inform">
    <ul class="taobao_shop">
      <li class="price"><span >商品价格：</span>
        <input id="price" type="text"  name="searchprice" value="<?php if ( isset( $price ) )  echo $price;?>" />
        &nbsp;元 <strong>如价格不符，请您手动修改。</strong><a href="<?php if (isset($search)) echo $search;?>" target="_blank">点击查看商品详情</a></li>
      <li class="express"><span>国内运费：</span>
        <input type="text" name="searchfreight" value="<?php if ( isset( $isbn ) )  echo $isbn;?>" />
        &nbsp;元 到 广东(深圳) 的运费，如运费有优惠，可手动修改</li>
    </ul>
    <dl class="color">
      <?php if(isset($ean) && !empty($ean)) { ?>
      <dt>选择颜色：</dt>
      <?php }else{  ?>
      <dt></dt>
      <?php }  ?>
      <dd>
        <ul class="color_list">
          <input type="hidden" id="searchcolor" name="searchcolor"  value="<?php echo $searchcolor; ?>" />
          <input type="hidden" id="colorname" name="colorname"  value="<?php echo $colorname; ?>" />
          <?php if(isset($ean) && !empty($ean)) {
                     if($api){
                             foreach($ean as $signal_ean) {?>
          <li><a class="color_wenzi" onclick="click_snatch_color('<?php $getSignal_ean = array_keys($color_number,$signal_ean);  echo str_replace(':','_',($getSignal_ean[0]))?>','<?php echo $signal_ean;?>')" id="<?php $getSignal_ean = array_keys($color_number,$signal_ean);  echo str_replace(':','_',($getSignal_ean[0]))?>"><span><?php echo $signal_ean;?></span></a><i></i></li>
          <?php }
           }else{ 
                       foreach($ean as $signal_ean) {?>
          <li><a class="color_wenzi" onclick="preg_snatch_color('<?php echo $signal_ean;?>')" ><span><?php echo $signal_ean;?></span></a><i></i></li>
          <?php } }}else{ ?>
          <input type="hidden" id="noColor" name="noColor"  value="noColor" />
          <?php }?>
        </ul>
      </dd>
    </dl>
    <dl class="size ml10">
      <?php if(isset($jan) && !empty($jan)) { ?>
      <dt>尺码规格：</dt>
      <?php }else{  ?>
      <dt></dt>
      <?php } ?>
      <dd>
        <ul class="size_list">
          <input type="hidden" id="searchsize" name="searchsize" value="<?php echo $searchsize; ?>" />
          <input type="hidden" id="sizename" name="sizename" value="<?php echo $sizename; ?>" />
		  <input type="hidden" name="type" value="2">
          <?php if(isset($jan) && !empty($jan)) {
                    if($api){
                             foreach($jan as $signal_jan) {?>
          <li><a class="color_wenzi" onclick="click_snatch_size('<?php $getSignal_jan = array_keys($size_number,$signal_jan); echo str_replace(':','_',($getSignal_jan[0]))?>','<?php echo $signal_jan;?>')" id="<?php $getSignal_jan = array_keys($size_number,$signal_jan); echo str_replace(':','_',($getSignal_jan[0]))?>"><span><?php echo $signal_jan; ?></span></a><i></i></li>
          <?php }
          }else{
            foreach($jan as $signal_jan) {?>
          <li><a class="color_wenzi" onclick="preg_snatch_size('<?php echo trim($signal_jan);?>')" ><span><?php echo $signal_jan; ?></span></a><i></i></li>
          <?php }} }else { ?>
          <input type="hidden" id="noSize" name="noSize"  value="noSize" />
          <?php }?>
        </ul>
      </dd>
    </dl>
    <dl class="num ml10">
      <dt>购买数量：</dt>
      <dd> <span class="click_num"><a href="javascript:void(0);" class="click_sub">-</a>
        <input class="num-pallets-input" type="text" name="quantity" value="1"/><a href="javascript:void(0);" class="click_add">+</a></span> 
        <input type="hidden" name="num_iid" value="<?php if ( isset( $num_iid  ) )  echo $num_iid; ?>" />
      </dd>
    </dl>
    <dl class="beizhu ml10">
      <dt>商品备注：</dt>
      <dd>
        <textarea id="note" name="note" placeholder="填写商品备注(可以写下您的购买需求)"></textarea>
      </dd>
    </dl>
    <ul class="gwc_btns">
      <li class="add_gwc"><a href="javascript:void(0);" onclick="list()" >加入商品清单</a></li>
      
    </ul>
    <div id="flyItem" class="fly_item"><img alt="商品图片" src="<?php if(isset($goodsimg)) echo $goodsimg;?>" width="50" height="50" /></div>
  </div>
  <div class="CLR"></div>

  <div class="zizhu_list">
      <ul class="savebox_top">
        <li>
          <h3>自助购商品清单</h3>
        </li>
        <li> <span class="package_num"> <em>共<b><?php echo $selfproduct_total ?></b>件商品</em> </span> </li>
      </ul>
      <ul class="zizhu_head">
        <li class="zizhu_name">商品名称</li>
        <li class="zizhu_num">数量</li>
        <li class="zizhu_color">颜色</li>
        <li class="zizhu_size">尺码</li>
        <li class="zizhu_msg">备注</li>
        <li class="zizhu_ope">操作</li>
      </ul>
      <?php if ($orders) { ?>
      <?php foreach($storenames as $key=>$value) { ?>
      <div class="post_box">
        <?php if(strpos($key,'1688')) { ?>
        <p class="seller">店铺： 
        <a class="albb" target="_blank" href="<?php echo $key; ?>">
        <?php }elseif(strpos($key,'taobao') || strpos($url, 'yao.95095')) { ?>
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
        <?php foreach ($orders as $order) { ?>
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
          <li class="buyin_six"><a onclick="del(<?php echo $order['id'];?>,'cookie')">删除</a></li>
        </ul>
        <?php } } ?>
      </div>
      <?php   } } ?>
      <div class="get_zizhu"><a href="javascript:void(0);" onclick="addorder_selfshopping()">提交自助购</a></div>
    </div>

  <div class="faq">
    <h3><!-- span class="more"><a href="/help.html" target="_blank">More</a></span -->常见问题</h3>
    <div class="list">
      <h4>问：什么是自助型产品整合供应链服务？</h4>
      <p><span class="f14"><b>答：</b></span>由客户自行完成供应链环节采购并发货到CNstorm(深圳)仓库，通过CNstorm进行货品验收、整合，实现流向国际的物流运送服务。</p>
    </div>
    <div class="list">
      <h4>问：我只有外币，如何付款？</h4>
      <p><span class="f14"><b>答：</b></span>我们支持Paypal、国外信用卡等多种充值方式(统一以美元结算)，充值成功后，您只需要提交代购的商品网址，由CNstorm为您代购。</p>
    </div>
    <div class="list">
      <h4>问：我代采购的货品，CNstorm会帮我验货吗？</h4>
      <p><span class="f14"><b>答：</b></span>当然会的，这就是我们的工作，瑕疵、店家发错货或者您临时改变主意想退货等等，我们在国内就会帮您处理。</p>
    </div>
  </div>
</div>

<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<script src="catalog/view/javascript/jquery2/parabola.js"></script>
<style type="text/css">
.fly_item {
  border: 2px solid #B30000;
  width: 50px;
  height: 50px;
  overflow: hidden;
  position: absolute;
  visibility: hidden;
  opacity: .5;
  filter: alpha(opacity=50);
}
</style>
<script type="text/javascript">
//获取url参数
function GetQueryString(name) {
   var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
   var r = window.location.search.substr(1).match(reg);
   if (r!=null) return (r[2]); return null;
}
//选择颜色尺码
$(".color_list li").each(function() {
    $(this).click(function() {
        if ($(this).children().hasClass("cannot_choose")) {
            return false;
        } else {
            $(this).addClass('after_choose').siblings().removeClass("after_choose");
        }
    });
});
$(".size_list li").each(function() {
    $(this).click(function() {
        if ($(this).children().hasClass("cannot_choose")) {
            return false;
        } else {
            $(this).addClass('after_choose').siblings().removeClass("after_choose");
        }
    });
});

$(function(){
	var indexUrl=decodeURIComponent(GetQueryString('search'));
	indexUrl=indexUrl.replace('&amp;','&')
	$('input[name=producturl]').val(indexUrl);
})


//加入自助购购物车
function list() {
    var heading_title = $('input[name=product_name]').val();
    var producturl = encodeURIComponent($('input[name=producturl]').val());
    var price =$('#price').val();
    var searchfreight = $('#searchfreight').val();
    var qty = $('input[name=quantity]').val();
    var remark =$('#note').val();
    var img = $('input[name=imgurl]').val();
    var seller = $('.taobao').html();
    var color = $('#colorname').val();
    var size = $('#sizename').val();
    var storename = $('#store_name').val();
    var storeurl = $('input[name=store_url]').val();


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

//提交订单
function addorder_selfshopping(){

if($('input[name=customer_id]').val() ==""){
	$('.userlogin').click();
}else{
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
		window.location.href = "/order-snatch.html";
	}
}

function del(id,type) {

    $.ajax({
        url: 'index.php?route=order/snatch/del_one_selfproduct',
        type: 'POST',
        data: "id=" + id+'&type='+type,
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