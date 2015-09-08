<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="UTF-8" />
<title><?php echo $heading_title; ?></title>
<meta name="apple-itunes-app" content="app-id=914402588" />
<meta property="wb:webmaster" content="e864759f92e3d23f" />
<meta name="description" content="<?php echo $meta_description;?>" />
<meta name="keywords" content="<?php echo $meta_keyword;?>">
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/detail.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/jquery2/main1.js"></script>
<script src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<script src="catalog/view/javascript/jquery2/cart.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css">
<script type="text/javascript">
var _mvq = _mvq || [];
_mvq.push(['$setAccount', 'm-92402-0']);
_mvq.push(['$logConversion']);
_mvq.push(['$logData']);
var obj=<?php echo $price_size; ?>
</script>
<style>
  .color_list .noclick{background:#FFF;cursor: not-allowed;}
  .item_bott .color .color_list .noclick a{cursor:not-allowed;color: #DEDEDE;border: 1px dashed #DEDEDE;background: #FFF;}
  .item_bott .color .color_list .noclick a:hover{cursor: not-allowed;color: #DEDEDE; border: 1px dashed #DEDEDE; background: #FFF;}
</style>
</head>
<body style="background:url(/images/cosplay/cosbg.jpg) no-repeat top fixed;">
<?php echo $header_cosplay ?>
<div class="goods_details_bg">
	<div class="cosbgwrap">
		<nav id="breadcrumb" class="child_nav" data-uts-mode="2">
		  <span class="first">你当前的位置：</span>
		  <span class="first">
			<a href="cosplay-main.html">首页</a>
			<i>></i>
		  </span>
		  <?php if($s_categoryName){ ?>
		  <span class="first">
			<a href="/<?php  echo  $path1; ?>-cosplay.html"><?php echo $categoryName; ?></a>
			<i>></i>
		  </span>
		  <span class="first">
			<a href="/<?php  echo  $path; ?>-cosplay.html"><?php echo $s_categoryName; ?></a>
			<i>></i>
		  </span>
		  <?php }else{ ?>
		  <span class="first">
			<a href="/index.php?route=product/favorite">我的最爱</a>
			<i>></i>
		  </span>
		  <?php } ?>
		  <span class="first">
			<a href=""><?php echo $productCategoryName; ?></a>
		  </span>
		</nav>

	  <div class="details wrap">
		<div class="item_cont">
		  <div class="item_cont_l ml10" id="container">
			<div class="item_pic_big" id="imgwrapper">
				<img alt="项目图片" data-zoom-image="<?php if (isset($item_imgs)) echo $item_imgs[0]; ?>" src="<?php if (isset($popup)) echo $popup; ?>" id="zoom_03" width="440" height="440"/>
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
					<b>￥<span id="price"><?php echo $price;?></span></b>如发现价格不一致,请联系
					<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=3291180008&site=qq&menu=yes">在线客服</a>
				</li>
			  </ul>
			</div>
			<div class="item_bott">
			  <dl class="color">
				
				<dd>
				  <ul class="color_list">
					<input type="hidden" id="hcolor" name="hcolor"  value="" />
					<?php if(isset($arrColor) && !empty($arrColor)){echo '<dt style="width: 80px;">颜色分类：</dt>';for($i=0;$i<count($arrColor);$i++) {?>
						<li><a class="color_wenzi" alt="<?php echo $arrColor[$i];?>" onclick="click_cosplay_color('<?php echo $arrColor[$i];?>')"><span><?php echo $arrColor[$i];?></span><i></i></a></li>
					<?php } }else{?>
					<input type="hidden" id="noColor" name="noColor"  value="noColor" />
					<?php }?>
				  </ul>
				</dd>
			  </dl>
			  <dl class="size ml10">
				
				<dd>
				  <ul class="size_list">
					<input type="hidden" id="hsize" name="hsize" value="<?php echo $hsize; ?>" />
					<?php if(isset($arrSize) && !empty($arrColor)){echo '<dt style="width: 80px;">尺码大小：</dt>';for($i=0;$i<count($arrSize);$i++) {?>
					<li>
						<a class="color_wenzi" alt="<?php echo $arrSize[$i]; ?>" onclick="click_cosplay_size('<?php echo $arrSize[$i];?>')">
							<span><?php echo $arrSize[$i]; ?></span><i></i>
						</a>
					</li>
					<?php }}else { ?>
					<input type="hidden" id="noSize" name="noSize"  value="noSize" />
					<?php }?>
				  </ul>
				</dd>
			  </dl>
			  <dl class="num ml10">
				<dt style="width: 80px;">购买数量：</dt>
				<dd> <span class="click_num"><a class="click_sub" href="javascript:void(0);">-</a>
				  <input class="num-pallets-input" type="text" name="quantity" value="1" /><a class="click_add" href="javascript:void(0);">+</a></span> <em class="kucun" style="display;">库存<em>183</em>件</em>
				  <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
				</dd>
			  </dl>
			  <dl class="beizhu ml10">
				<dt style="width: 80px;">商品备注：</dt>
				<dd>
				  <textarea id="note" name="note" placeholder="填写商品备注(可以写下您的特殊要求)" ></textarea>
				</dd>
			  </dl>
			</div>
		  
			<div class="dingdan"> 
			  <a class="purchase" id="button-cosplay-cart" href="javascript:void(0);">加入购物车</a> 
			  <a class="collect" onclick="addToWishList1('<?php echo 'cosplay_'.$product_id; ?>');">加入收藏夹</a> 
			</div>
			<div id="flyItem" class="fly_item"><img alt="项目图片" src="<?php if (isset($item_imgs)) echo $item_imgs[0]; ?>" width="50" height="50" /></div>
		  </div>
		  <div class="CLR"></div>
		</div>
		<div class="item_intro">
		  <div class="about_detail">
			<h4><span>宝贝详情</span></h4>
			<div class="content">
			  <?php echo $description;?>
			</div>
		  </div>
		  <div class="CLR"></div>
		</div>
	  </div>
  </div>
</div>

<script src="catalog/view/javascript/jquery2/cosplaymain.js"></script>
<script src="catalog/view/javascript/jquery2/parabola.js"></script>
<script>
// 绑定点击事件
    $('#button-cosplay-cart').bind('click',
    function(e) {
    if(!$('#noSize').val() && !$('#hsize').val()){
      alert("^_^请您选择宝贝的尺码!");
    }else if (!$('#noColor').val() && !$('#hcolor').val()){
      alert("^_^请您选择宝贝的颜色!");
    }else{
        $.ajax({
            url: 'index.php?route=checkout/cart/addcosplay',
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

    
function click_cosplay_color(select_color) {
	if($('a[alt='+select_color+']').parent().attr('class')!='noclick'){
		$('#hcolor').attr("value",select_color);
	}
}

function click_cosplay_size(select_size) {
    $('#hsize').attr("value",select_size);
}
$(function(){
		setPrice();
})
</script> 

<?php echo $footer ;?>
</body>
</html>