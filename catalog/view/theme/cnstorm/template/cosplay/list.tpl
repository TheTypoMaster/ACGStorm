<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CNstorm Cosplay商城: 专业玩家的动漫Cosplay服饰和道具商城</title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/stylesheet/cosplay.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
</head>
<body >
<?php echo $header_cosplay ?>

<div class="banner">
	<div class="cp_mid">
		<ul class="cp_nav">
		  <li>
			<dl class="nav_warp">
			  <dt> <a target="_blank" href="#">热卖专区</a> </dt>
			  <dd> 
				<a class="" target="_blank" href="cosplay-category.html&sort=viewed">人气热卖</a> 
				<a class="" target="_blank" href="cosplay-category.html&sort=date_modified">所有宝贝</a> 
			  </dd>
			</dl>
		  </li>
		  <li>
			<dl class="nav_warp">
			  <dt> <a target="_blank" href="#">新品上架</a> </dt>
			  <dd> 
				  <a class="" target="_blank" href="cosplay-category.html&sort=price">综合排序</a> 
				<a class="" target="_blank" href="cosplay-category.html&sort=sort_order">最新上架</a> 
			  </dd>
			</dl>
		  </li>
		  <?php for($i=0;$i<count($categoryids);$i++) {  ?>
		  <li>
			<dl class="nav_warp">
			  <dt> <a target="_blank" href="#"><?php echo $categoryids[$i]['name']; ?></a> </dt>
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

<div class="cosbgwrap">
	<div class="cp_search cp_mid"> <span class="s_title"> 自助搜索 </span>
	  <div class="skin-box-bd">

		  <ul>
			<li class="keyword">
			  <label for="keyword">
				<input type="text" size="18" name="keyword" autocomplete="off" value="<?php echo $filter_name; ?>" class="keyword-input"  />
			  </label>
			</li>
			<li class="submit">
			  <input value="搜索"  class="search_btn" type="button">
			</li>
			<li><span>热门搜索:&nbsp;&nbsp;</span> <a target="_blank" href="/cosplay-list-search.html&keyword=love live">love live</a> 
			<a target="_blank" href="/cosplay-list-search.html&keyword=高达">高达</a>
			<a target="_blank" href="/cosplay-list-search.html&keyword=刀剑乱舞">刀剑乱舞</a></li>
		  </ul>

	  </div>
	</div>
	<script>
	$(function(){
		$('.search_butn').click(function(){
			var keyword=$.trim($('input[name=keyword]').val());
			if(keyword==''){
				alert('请输入关键字');
				return false;
			}
			var keyword=$('.keyword-input').val();
			var url='/index.php?route=cosplay/list/search&keyword='+keyword;
			window.open(url);	
		})
		$('.keyword-input').focus(function(){
		
			$(this).keyup(function(event) {
			var k = event.keyCode;
				if(k==13){
					if($(this).val() !=""){
							var url='/index.php?route=cosplay/list/search&keyword='+$(this).val();
							window.open(url);	
					}
				}
			})
		})
	})
	</script>
	<div class="cp_list">
	  <div class="cl_r">
		<ul>
		  <?php foreach($products as $product){ ?>
		  <li>
		  <a target="_blank"  href="cosplay-product.html&product_id=<?php echo $product['product_id'];?>">
			<img src="<?php echo $product['thumb']; ?>">
		  </a>
		  <p class="cosplay_name"><?php echo $product['name'];?></p>
		  <p class="cosplay_price">￥<?php echo $product['price'];?></p>
		  </li>  
		<?php } ?>
		</ul>
	  </div>
	</div>
	<div class="pagination"><?php echo $pagination;?></div>
	<div class="clear"></div>
</div>
<?php echo $footer;?>
</body>
</html>