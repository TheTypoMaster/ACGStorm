<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CNstorm Cosplay商城: 专业玩家的动漫Cosplay服饰和道具商城</title>
<meta name="keywords" content="Cosplay,Cosplay服装,Cosplay衣服,动漫服装,Cosplay道具" />
<meta name="description" content="CNstorm Cosplay商城网罗了全系列的原创动漫Cosplay服饰和周边衍生产品，如动漫主题 周边、影视主题周边、游戏主题周边、Cosplay道具等。Cosplay骨灰级玩家的首选" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/cosplay.css"/>
<script src="catalog/view/javascript/jquery2/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/zzsc.js" type="text/javascript"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.SuperSlide.2.1.1.js"></script>
<link href="catalog/view/theme/cnstorm/stylesheet/stylebanner.css" rel="stylesheet" type="text/css">
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
	<div class="arrival cp_mid">
		<div class="arr_title"><span>新製品を登場！</span></div>
		<div>
			<!-- <img src="/images/cosplay/main_01.jpg" >-->
			<div class="newproduct_box">
				<div class="newproductleft_box">
					<a href="/45_46-cosplay.html" target="_balnk">
						<img src="/image/cache/data/cosplay/_r2_c2.png" width="590" height="500" alt=""/>
					</a>
				</div>
				<div class="newproductright_box">
					<div class="right_top">
						<a href="/7_41-cosplay.html" target="_balnk">
							<img src="/image/cache/data/cosplay/_r2_c4.png" width="590" height="239" alt=""/>
						</a>
					</div>
					<div class="right_down">
						<div class="right_down_left">
							<a href="/6_57-cosplay.html" target="_balnk">
								<img src="/image/cache/data/cosplay/_r4_c4.png" width="285" height="239" alt=""/>
							</a>
						</div>
						<div class="right_down_right">
							<a href="/45_47-cosplay.html" target="_balnk">
								<img src="/image/cache/data/cosplay/_r4_c6.png" width="285" height="239" alt=""/>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- img src="http://img02.taobaocdn.com/imgextra/i2/884297351/TB2arWJbFXXXXc3XXXXXXXXXXXX_!!884297351.jpg" -->
	</div>

	<div class="cp_list">
		<div class="cosModule">
			<a target="_balnk" href="/index.php?route=cosplay/category&sort=viewed">
				<img src="/images/cosplay/product/cosModule01.jpg" width="1200" height="95" alt="人气单品">
			</a>
		</div>
		
		<div class="hotleft">
			<a href="/45_65-cosplay.html" style="background:url(/images/cosplay/product/left-1.jpg) no-repeat;"></a> 
		</div>
		<div class="cl_r">
			<ul>
				<?php foreach($hots as $hot) {  ?>
				<li>
					<a href="<?php echo $hot['href'];?>" target="_blank">
						<img src="<?php echo $hot['image']; ?>" width="213" height="228" alt=""/>
					</a>
					<a href="<?php echo $hot['href'];?>" target="_blank" class="cosplay_name"><?php echo $hot['name'];?></a>
					<p class="cosplay_price">￥<?php echo $hot['price'];?></p>
				</li>  
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="cp_list">
		<div class="cosModule">
		 <a href="/3_9-cosplay.html" target="_blank">
			<img src="/images/cosplay/product/cosModule02.jpg" width="1200" height="95" alt="假发专区">
		 </a>
		</div>

		<div class="hotleft">
			<a href="#" style="background:url(/images/cosplay/product/left-3.jpg) no-repeat;"></a>
		</div>
		<div class="cl_r">
			<ul>
				<?php foreach($short_wig as $short) {  ?>
				<li>
					<a href="<?php echo $short['href'];?>" target="_blank">
						<img src="<?php echo $short['image']; ?>" width="213" height="228" alt=""/>
					</a>
					<a href="<?php echo $short['href'];?>" target="_blank" class="cosplay_name"><?php echo $short['name'];?></a>
					<p class="cosplay_price">￥<?php echo $short['price'];?></p>
				</li>  
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="cp_list">
		<div class="cosModule">
			<a href="/3_11-cosplay.html" target="_blank">
				<img src="/images/cosplay/product/cosModule03.jpg" width="1200" height="95" alt="服装专区">
			</a>
		</div>

		<div class="hotleft">
			<a href="/45_46-cosplay.html" style="background:url(/images/cosplay/product/left-2.jpg) no-repeat;"></a>
		</div>
		<div class="cl_r">
			<ul>
				<?php foreach($long_wig as $long) {  ?>
				<li>
					<a href="<?php echo $long['href'];?>" target="_blank">
						<img src="<?php echo $long['image']; ?>" width="213" height="228" alt=""/>
					</a>
					<a href="<?php echo $long['href'];?>" target="_blank" class="cosplay_name"><?php echo $long['name'];?></a>
					<p class="cosplay_price">￥<?php echo $long['price'];?></p>
				</li>  
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php echo $footer;?>
</body>
</html>