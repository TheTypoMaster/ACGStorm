<!DOCTYPE html>
<html lang="zh-CN">
<head> 
<meta charset="UTF-8"/>
<title><?php echo $heading_title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/stylesheet/cosplay.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/stylebanner.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
<?php echo $header_cosplay ?>

<div class="banner1">
	<div class="banner-box">
		<div class="bd">
			<ul>          	    
				<li style="background:#F3E5D8;">
					<a href="javascript:void(0);">
						<img src="/images/cosplay/002.jpg" width="1200" height="400" alt=""/>
					</a>
				</li>
				<li style="background:#fbe3e1">
					<a href="javascript:void(0);">
						<img src="images/cosplay/003.jpg" width="1200" height="400" alt=""/>
					</a>
				</li>
				<li style="background:#fcd77e;">
					<a href="javascript:void(0);">
						<img src="images/cosplay/005.jpg" width="1200" height="400" alt=""/>
					</a>
				</li>
				<li style="background:#c5e5fd">
					<a href="javascript:void(0);">
						<img src="images/cosplay/004.jpg" width="1200" height="400" alt=""/>
					</a>
				</li>  
			</ul>
		</div>
		<div class="banner-btn">
				<div class="hd"><ul></ul></div>
			</div>
		<div class="cos_menu">
			<ul class="cp_nav">
				<li>
					<dl class="nav_warp">
						<dt> <a target="_blank" href="#">热卖专区</a> </dt>
						<dd> 
							<a class="" target="_blank" href="/index.php?route=cosplay/category&sort=viewed">人气热卖</a> 
							<a class="" target="_blank" href="/index.php?route=cosplay/category&sort=date_modified">所有宝贝</a> 
						</dd>
					</dl>
				</li>
				<!--<li>
					<dl class="nav_warp">
						<dt> <a target="_blank" href="#">新品上架</a> </dt>
						<dd> 
							<a class="" target="_blank" href="/index.php?route=cosplay/category&sort=price">综合排序</a> 
							<a class="" target="_blank" href="/index.php?route=cosplay/category&sort=sort_order">最新上架</a> 
						</dd>
					</dl>
				</li>-->
				<?php for($i=0;$i<count($categoryids);$i++) {  ?>
				<li>
					<dl class="nav_warp">
						<dt> <a target="_blank" href="<?php echo $categoryids[$i]['href'];?>"><?php echo $categoryids[$i]['name']; ?></a> </dt>
						<dd> 
							<?php foreach ($s_categoryids as $s_categoryid) { if($s_categoryid['s_parent_category_id'] == $categoryids[$i]['category_id']) {  ?> 
							<a class="hot" target="_blank" href="<?php echo $s_categoryid['href'];?> "><?php echo $s_categoryid['name']; ?></a> 
							<?php } } ?>
						</dd>
					</dl>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
	$(function(){
		$(".prev,.next").hover(function(){
			$(this).stop(true,false).fadeTo("show",0.9);
		},function(){
			$(this).stop(true,false).fadeTo("show",0.4);
		});
		$(".banner-box").slide({
			titCell:".hd ul",
			mainCell:".bd ul",
			effect:"fold",
			interTime:3500,
			delayTime:500,
			autoPlay:true,
			autoPage:true, 
			trigger:"click" 
		});
	});
	</script>
</div>




<div class="cosbgwrap">
	<div class="colsplay_main">
		<?php if(isset($indexParent)){ ?>
		<div class="cosplay_breadcrumb"> <i> <?php echo $indexParent,'>>',$indexCartgory;?></i></span></div>
		<div class="cosplay_sort"  <?php if( isset($is_display) && $is_display == 0 ){ ?> style="display:none"<?php } ?> >排序：
			<span><a href="<?php echo $indexPath;?>&sort=viewed&order=DESC">人气</a></span>
			<span><a href="<?php echo $indexPath;?>&sort=date_modified&order=DESC">最新</a></span>
			<span><a href="<?php echo $indexPath;?>&sort=price&order=ASC">价格</a></span>
		</div>
		<?php  }else{ ?>
		<div class="cosplay_breadcrumb"> <i> <?php echo $indexCartgory;?></i></span></div>
		<?php } ?>
		<div class="cosplay_category_product">
			<?php foreach($products as $product)  { ?>
			<div class="cosplay_product">
				<ul>
				  <li>
					<a target='_blank' href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name'];?>"></a>
					<span class="cosplay_price">￥<?php echo $product['price']; ?></span>
					<a class="cosplay_name"><?php echo $product['name'];?></a>
				  </li>
				</ul>
			</div>
			<?php } ?>
		</div>
		<div class="pages_change"><?php echo $pagination; ?></div>
	</div>
</div>
<?php echo $footer;?>
</body>
</html>