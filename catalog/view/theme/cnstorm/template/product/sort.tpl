<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title><?php echo $this->document->getTitle(); ?></title>
<meta name="keywords" content="<?php echo $this->document->getKeywords();?>"/>
<meta name="description" content="<?php echo $this->document->getDescription();?>"/>
<meta name="robots" content="nofollow" />
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/mall.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script  src="catalog/view/javascript/jquery2/global.js"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
</head>
<body>
<?php echo $header_mall; ?>
<div class="wrapBox">
	<!--banner[[-->
	<div class="sortBanner" style="background: #FF6B4F">
		<ul class="sortBannerBox">
			<li>
				<a href="javascript:void(0);" target="_blank">
					<img src="images/site/mall/banner_default.jpg" width="1200" height="250" alt="122"/>
				</a>
			</li>
		</ul>
	</div>
	<!--banner]]-->
	
	<!--主体内容[[-->
	<div class="wrap">
		<div class="sortTypes">
			<ul class="stUl">
                <li <?php if($category_id<=0){echo 'class="curr"';}?>>
					<a href="?route=product/sort&parent_id=<?php echo $parent_id;?>">全部商品</a>
				</li>
				<?php for ($i=0;$i<count($category);$i++){  ?>
				<li <?php if($category_id==$category[$i]['category_id']){echo 'class="curr"';}elseif($category[$i]['category_id']==$i+1){echo 'class="last"';}?>>
					<a href="?route=product/sort&parent_id=<?php echo $parent_id;?>&category_id=<?php echo $category[$i]['category_id'];?>"><?php echo $category[$i]['name'];?></a>
				</li>
                <?php }?>
			</ul>
		</div>
		<div class="slpwSplits">
			<div class="slproWrap">
				<div class="sortLists">
                    <?php if(!empty($products_categoryid_info)){ foreach ($products_categoryid_info as $product_categoryid_info) {?>
					<div class="slProducts">
						<a href="<?php echo $product_categoryid_info['href'];?>" target="_blank">
							<img src="<?php echo 'image/'.$product_categoryid_info['thumb']; ?>" width="218" height="218" alt="<?php echo $product_categoryid_info['name']; ?>" onerror="javascript:this.src='/image/product/no_image.jpg';"/>
						</a>
                        <a href="<?php echo $product_categoryid_info['href'];?>" class="slpNames" target="_blank"><i class="sorticon_01"></i><?php echo $product_categoryid_info['name']; ?></a>
						<p class="slpPrices">￥<em><?php echo $product_categoryid_info['price']; ?></em></p>
					</div>
                    <?php }}?>
				</div>
			</div>
			<div class="pages_change">
				<?php echo $pagination;?>
			</div>
		</div>
	</div>
	<!--主体内容]]-->
	
	<!--新手教学[[-->
	<div class="mTrys">
		<div class="wrap">
			<h2 class="tryNotice">欢迎来到CNstorm，身在海外，轻松代购全中国。</h2>
			<a class="tryBtn" target="_blank" href="/newbie.html">立即体验</a>
		</div>
	</div>
	<!--新手教学]]-->
</div>
<?php echo $footer ?>
</body>
</html>