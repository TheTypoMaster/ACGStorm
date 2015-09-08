<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title><?php echo $this->document->getTitle(); ?></title>
<meta name="keywords" content="<?php echo $this->document->getKeywords();?>"/>
<meta name="description" content="<?php echo $this->document->getDescription();?>"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/detail.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/global.js"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/product.js" type="text/javascript"></script>
</head>
<body>
<?php echo $header_mall;?>
<script type="text/javascript">
var _mvq = _mvq || [];
_mvq.push(['$setAccount', 'm-92402-0']);
_mvq.push(['$logConversion']);

_mvq.push(['$logData']);
</script>

<div id="breadcrumb" class="child_nav" data-uts-mode="2">
    <span class="first">
        <a href="www.acgstorm.com">首页</a>
        <i>&gt;</i>
    </span>
    <?php for($i=0;$i<count($product_category);$i++){?>
	<span class="first">
		<a href="index.php?route=product/sort&parent_id=<?php echo $product_category[$i]['parent_id'];?>&category_id=<?php echo $product_category[$i]['category_id'];?>"><?php echo $product_category[$i]['name'];?></a>
		<i><?php if($i+1<count($product_category)){echo ">";}?></i>
	</span>
    <?php }?>
</div>

<div class="goods_details_bg">
    <div class="details wrap">
        <div class="item_cont">
            <div class="item_cont_l ml10" id="container">
                <div class="item_pic_big" id="imgwrapper">
                    <img alt="项目图片" data-zoom-image="<?php if (isset($item_imgs)) echo $item_imgs[0]; ?>" src="<?php if (isset($item_imgs)) echo $item_imgs[0]; ?>" id="zoom_03"/>
                </div>
                <div class="item_pic_small" id="gal1">
                    <?php if(isset($item_imgs)){ foreach($item_imgs as $item_img) { ?>
					<a data-zoom-image="<?php echo $item_img; ?>" data-image="<?php echo $item_img; ?>" href="javascript:void(0);">
						<img alt="项目图片" src="<?php echo $item_img; ?>" id="zoom_03">
					</a>
					<?php } } ?>
                </div>
            </div>
            <script type="text/javascript">
			//initiate the plugin and pass the id of the div containing gallery catalog/view/theme/cnstorm/images
			$("#zoom_03").elevateZoom({
				gallery: 'gal1',
				cursor: 'pointer'
			});
			//pass the catalog/view/theme/cnstorm/images to Fancybox
			$("#zoom_03").bind("click",
			function(e) {
				var ez = $('#zoom_03').data('elevateZoom');
				$.fancybox(ez.getGalleryList());
				return false;
			});
            </script>
            <div class="item_cont_r ml10">
                <div class="item_top">
                    <h3 class="item_txt"><?php echo $heading_title;?></h3>
                    <ul class="taobao_shop">
                        <li class="price">
                            <b>￥<span id="price"><?php echo $price;?></span></b>  
                            <a href="help.html" target="_blank">在线客服</a>
                        </li>
                        <li class="express">
                            国内运费：&nbsp;&nbsp;&nbsp;￥<em><?php echo $isbn ?></em>
                        </li>
                        <li class="shop_owner">
                            商品来源：
                            <a target=_blank href="www.acgstorm.com">CNstorm商城</a>
                        </li>
                    </ul>
                </div>
                <div class="item_bott">
                <?php $ean_=false;
                    if($ean){
						foreach($ean as $signal_ean) { 
							if (isset($color_number)){
								  if (array_keys($color_number,$signal_ean)) {
								  $ean_=true;break;
								  }
							 }
						 }
                     }
                    if($ean_){?>
                    <dl class="color">
                        <dt>颜色分类：</dt>
                        <dd>
                            <ul class="color_list">
                                <input type="hidden" id="hcolor" name="hcolor" value="<?php echo $hcolor; ?>"/>
                                <?php if($ean){ foreach($ean as $signal_ean) { 
                                    if (isset($color_number))
                                          if (array_keys($color_number,$signal_ean)) { ?>
								<li>
									<a class="color_wenzi" onclick="click_color('<?php $color = array_keys($color_number,$signal_ean);  echo str_replace(':','_',$color[0])?>')" id="<?php $color = array_keys($color_number,$signal_ean);  echo str_replace(':','_',$color[0])?>">
										<span><?php echo $signal_ean;?></span>
										<i></i>
									</a>
								</li>
								<?php } } }else{?>
								<input type="hidden" id="noColor" name="noColor" value="noColor"/>
								<?php }?>
                            </ul>
                        </dd>
                    </dl>
                    <?php }else{?>
                    <input type="hidden" id="hcolor" name="hcolor" value="<?php echo $hcolor; ?>"/>
                    <input type="hidden" id="noColor" name="noColor" value="noColor"/>
                    <?php }?>
                    <?php $jan_=false;
                    if($jan){
						foreach($jan as $signal_jan) { 
                            if (isset($color_number))
                                if (array_keys($size_number,$signal_jan)) {
                                    $jan_=true;break;
                                }
                             }
					}
                    if($jan_){?>
                    <dl class="size ml10">
                        <dt>尺码大小：</dt>
                        <dd>
                            <ul class="size_list">
                                <input type="hidden" id="hsize" name="hsize" value="<?php echo $hsize; ?>"/>
                                <?php if($jan){
                                foreach($jan as $signal_jan) { 
                                if (isset($color_number))
                                if (array_keys($size_number,$signal_jan)) { ?>
								<li>
									<a class="color_wenzi" onclick="click_size('<?php $size = array_keys($size_number,$signal_jan); echo str_replace(':','_',$size[0])?>')" id="<?php $size = array_keys($size_number,$signal_jan); echo str_replace(':','_',$size[0])?>">
										<span><?php echo $signal_jan; ?></span>
										<i></i>
									</a>
								</li>
								<?php }}}else { ?>
								<input type="hidden" id="noSize" name="noSize" value="noSize"/>
								<?php }?>
                            </ul>
                        </dd>
                    </dl>
                    <?php }else{?>
                    <input type="hidden" id="hsize" name="hsize" value="<?php echo $hsize; ?>"/>
                    <input type="hidden" id="noSize" name="noSize" value="noSize"/>
                    <?php } ?>
                    <dl class="num ml10">
                        <dt>购买数量：</dt>
						<dd>
                            <span class="click_num">
                                <a class="click_sub" href="javascript:void(0);">-</a>
                                <input class="num-pallets-input" type="text" name="quantity" value="1"/>
                                <a class="click_add" href="javascript:void(0);">+</a>
                            </span>
                            <em class="kucun" style="display:none;">库存<em>183</em>件</em>
                            <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>"/>
                        </dd>
                    </dl>
                    <dl class="beizhu ml10">
                        <dt>商品备注：</dt>
                        <dd>
                            <textarea id="note" name="note" placeholder="填写商品备注(可以写下您的特殊要求)"></textarea>
                        </dd>
                    </dl>
                </div>
                <div class="dingdan">
                    <a class="purchase" id="button-cart" href="javascript:void(0);">加入购物车</a>
                    <a class="collect" onclick="addToWishList('<?php echo $product_id; ?>');">加入收藏夹</a>
                </div>
                <div id="flyItem" class="fly_item">
                    <img alt="项目图片" src="<?php if (isset($item_imgs)) echo $item_imgs[0]; ?>" width="50" height="50"/>
                </div>
            </div>
            <div class="CLR"></div>
        </div>
        <div class="item_intro">
            <div class="about_detail">
                <h4><span>宝贝详情</span></h4>
                <div class="content">
                    <?php if ( isset( $prop_imgs ) ) foreach($prop_imgs as $prop_img) { ?>
					<p class="informations">
						<img alt="项目图片" src="<?php echo $prop_img ?>" alt="">
					</p>
					<?php } ?>
                </div>
            </div>
            <div class="shares">
                <h4><span>推荐商品</span></h4>
                <?php if ( isset( $love_products ) ) foreach($love_products as $row) {?>
				<dl class="shares_goods">
					<dt>
						<a target="_blank" href="<?php echo $row['product_id'];?>.html">
							<img alt="项目图片" src='image/<?php echo substr("cache/" . $row["image"], 0, -4) . "-222x222.jpg";?>' onerror="javascript:this.src='/image/product/no_image.jpg';" alt="<?php echo $row['name'];?>"/>
						</a>
					</dt>
					<dd class="usage">
						<a target="_blank" href="<?php echo $row['product_id'];?>.html">
							<?php echo $row[ 'name'];?>
						</a>
					</dd>
					<dd class="money">
						<b>￥<?php echo $row[ 'price']?></b>
					</dd>
				</dl>
				<?php } ?>
            </div>
            <div class="CLR"></div>
        </div>
    </div>
</div>
<script src="catalog/view/javascript/jquery2/parabola.js"></script>
<script>
/*
// 加入购物车动态效果;元素以及其他一些变量
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

// 绑定点击事件
    $('#button-cart').bind('click',
    function(e) {
    if(!$('#noSize').val() && !$('#hsize').val()){
      alert("请选择尺码。");
      
    }else if (!$('#noColor').val() && !$('#hcolor').val()){
      alert("请选择颜色。");
    }else{
      
    if (eleFlyElement && eleShopCart) {
              // 滚动大小
      
      e=e||event;
            var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
                scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;

            eleFlyElement.style.left = e.clientX + scrollLeft + "px";
            eleFlyElement.style.top = e.clientY + scrollTop + "px";
            eleFlyElement.style.visibility = "visible";
            
            // 需要重定位
            myParabola.position().move();  
       
     alert("text-align");
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('.goods_details_bg input[type=\'text\'], .goods_details_bg input[type=\'hidden\'], .goods_details_bg input[type=\'radio\']:checked, .goods_details_bg input[type=\'checkbox\']:checked, .goods_details_bg select, .goods_details_bg textarea'),
            dataType: 'json',
            success: function(json) {
                if (json) {
                    //window.location.href="/index.php?route=product/favorite"; 
                }
            },
            error: function(json) {
                //alert("failed");
            }
        });
    }
    }
    });
*/
// 绑定点击事件
$('#button-cart').bind('click',
    function(e) {
    if(!$('#noSize').val() && !$('#hsize').val()){
      alert("^_^请您选择宝贝的尺码!");
    }else if (!$('#noColor').val() && !$('#hcolor').val()){
      alert("^_^请您选择宝贝的颜色!");
    }else{
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('.goods_details_bg input[type=\'text\'], .goods_details_bg input[type=\'hidden\'], .goods_details_bg input[type=\'radio\']:checked, .goods_details_bg input[type=\'checkbox\']:checked, .goods_details_bg select, .goods_details_bg textarea'),
            dataType: 'json',
            success: function(json) {
                if (json) {
                     alert("添加宝贝成功!");
                }
            },
            error: function(json) {
                alert("添加宝贝失败!");
            }
        });
    
    }
});
</script> 
<?php echo $footer ;?>
</body>
</html>