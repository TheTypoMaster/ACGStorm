<div class="item_top">
  <h3 class="item_txt"><?php if ( isset( $heading_title ) )  echo $heading_title;?></h3>
  <input type="hidden" name="product_name" value="<?php if ( isset( $heading_title ) )  echo $heading_title;?>" />
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
		   <input type="hidden" id="p_type" name="type"  value="1" />
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
      <li class="add_gwc"><a id="button-cart-snatch" href="javascript:void(0);">加入购物车</a></li>
      <li class="go_gwc"><a href="index.php?route=product/snatch">继续下单</a></li>
    </ul>
    <div id="flyItem" class="fly_item"><img alt="商品图片" src="<?php if(isset($goodsimg)) echo $goodsimg;?>" width="50" height="50" /></div>
  </div>
  <div class="CLR"></div>
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
<script>
var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document.querySelector("#shopCart");
// 抛物线运动
var myParabola = funParabola(eleFlyElement, eleShopCart, {
    speed: 400,
    curvature: 0.002,    
    complete: function() {
		var numberCart = $('#cartCount').text();
		var numberItem = $('.num-pallets-input').val();
		var newtotal = parseInt(numberCart)+parseInt(numberItem);
        eleFlyElement.style.visibility = "hidden";
        eleShopCart.querySelector("em").innerHTML = newtotal;
    }
});

//商品详细页选择商品数量new
    $(".num-pallets-input").each(function(i) {
        var t = $(".num-pallets-input");
        $(".click_add").eq(i).click(function() {
            var num = t.eq(i).val();
            if (num < 1000) {
                t.eq(i).val(parseInt(t.eq(i).val()) + 1);
            }

        })
        $(".click_sub").eq(i).click(function() {
            var num = t.eq(i).val();
            if (num > 1) {
                t.eq(i).val(parseInt(t.eq(i).val()) - 1);
            }
        })

        //keyup
        $('.num-pallets-input').eq(i).keyup(function(e) {
            if ($(this).val() == "") {
                $(this).val(1);
            }
            if (e.which < 48 || e.which > 57) {
                $(this).val(function(index, value) {
                    var len = value.length;
                    return value.replace(/[^0-9]/ig, ""); //剔除非数字
                });
            }
            if ($(this).val() > 500) {
                $(this).val(500);
            }
            var value = parseInt($(this).val())
            $(this).val(value);
        });
    });

//商品详细页点击选择颜色或尺寸
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
 
   
// 绑定点击事件
    $('#button-cart-snatch').bind('click',
    function(e) {     
		if(!$('#noColor').val() && !$('#colorname').val()){
		    swal({
                  title: "^_^请您选择宝贝的颜色!",
                  timer: 2000
                });
			
		}else if(!$('#noSize').val() && !$('#sizename').val()){
             swal({
                  title: "^_^请您选择宝贝的尺码!",
                  timer: 2000
                });
		}else if(!$('#store_name').val()){
             swal({
                  title: "",
                  text: "^_^信息获取不全，稍候小C为您重新获取宝贝信息!",
                  timer: 2000
                });
             window.location.reload(); 
             
		}else{
		
		
        $.ajax({
            url: 'index.php?route=checkout/cart/addsearch',
            type: 'post',
            data: $('.goods_details_bg input[type=\'text\'], .goods_details_bg input[type=\'hidden\'], .goods_details_bg input[type=\'radio\']:checked, .goods_details_bg input[type=\'checkbox\']:checked, .goods_details_bg select, .goods_details_bg textarea,.goods_details_bg input[name=\'type\']'),
            dataType: 'json',
            success: function(json) {
                if (json) {
                    
                   //guanzhiqiang 20150528
                  $.post("index.php?route=common/header_cart/getproducts",function(result){
                      $("#shopCart").append(result.cartlist);
					  
                      $("#shopCart2 em,#cartCount").text(result.count);
                  },"json");
                    
                   swal({
                      title: "添加宝贝成功!",
                      type: "success",
                      timer: 2000
                    });

                }
            },
            error: function(json) {
                swal({
                      title: "添加宝贝失败!",
                      type: "error",
                      timer: 2000
                    });
            }
        }); 
		
		}
    });
</script> 


              
           


