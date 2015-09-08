<!DOCTYPE html>
<html lang="zh-CN"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" charset="UTF-8"/>
<title>海外代购用户评价-评价CNstorm代购中国商品的服务质量</title>
<meta name="keywords" content="海外代购,服务评价,代购评价,新加坡代购，美国代购,海外华人代购,淘宝代购,留学生代购,国内代购"/>
<meta name="description" content="非常感谢留学生、华人使用CNstorm代购服务，感谢你们对海外代购包裹服务的评价"/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/general.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
</head>
<body>
<?php echo $header_transport ?>
<div class="goods_details_bg">
	<div class="details wrap">
		<div class="item_intro">
			<div class="about_detail width_940">
				<h4><span>用户评论</span></h4>
				<div class="ucRateClear">
					<div class="ucRateTags">
						<div class="ucrateScore fl">
							<p class="ucPraise">
								<b><?php echo $good_rate_detail[ 'goodrate'];?><sub>%</sub></b>好评率
							</p>
						</div>
						<p class="ucrtLabel fl">买过的人觉得</p>
						<div class="ucRateInfors fl">
							<div class="ucriScores">
								<p class="usrisItems fl">
									<b class="fl">宝贝与描述相符：</b>
									<span class="score-value-no score-value-<?php echo str_replace('.','d',$good_rate_detail['semblance']);?>">
										<em></em>
									</span>
									<label><?php echo $good_rate_detail[ 'semblance'];?></label>
								</p>
								<p class="usrisItems fl">
									<b class="fl">CNstorm服务态度：</b>
									<span class="score-value-no score-value-<?php echo str_replace('.','d',$good_rate_detail['manner']);?>">
										<em></em>
									</span>
									<label><?php echo $good_rate_detail[ 'manner'];?></label>
								</p>
								<p class="usrisItems fl">
									<b class="fl">国际运输的时效：</b>
									<span class="score-value-no score-value-<?php echo str_replace('.','d',$good_rate_detail['delivery']);?>">
										<em></em>
									</span>
									<label><?php echo $good_rate_detail[ 'delivery'];?></label>
								</p>
								<p class="usrisItems fl">
									<b class="fl">CNstorm发货速度：</b>
									<span class="score-value-no score-value-<?php echo str_replace('.','d',$good_rate_detail['efficient']);?>">
										<em></em>
									</span>
									<label><?php echo $good_rate_detail[ 'efficient'];?></label>
								</p>
							</div>
							<div class="ucRateTagsInner">
								<a href="javascript:void(0);">很实用</a>
								<a href="javascript:void(0);">性价比很高</a>
								<a href="javascript:void(0);">包装不错哦</a>
								<a href="javascript:void(0);">整体感觉不错</a>
								<a href="javascript:void(0);">速度很快</a>
								<a href="javascript:void(0);">客服贴心</a>
								<a href="javascript:void(0);">服务很赞</a>
								<a href="javascript:void(0);">运费超便宜</a>
							</div>
						</div>
						<div class="ucAdvice fr">
							<a href="order-sendorder.html">评价运单，赚积分。</a>
						</div>
					</div>
				</div>
				<div class="users_comment" id="dvContent" style="position:relative;">
					<div class="contents">
						<?php if (isset($comments)) foreach($comments as $comment){ ?>
						<div class="uc_content reply">
							<?php if($comment[ 'face']){ ?>
							<img class="img" src="<?php echo $comment['face'];?>" alt=""/>
							<?php }else{ ?>
							<img class="img" src="uploads/big/0b4a96400b2372d25da769647bfe4059.jpg" alt="头像"/>
							<?php } ?>
							<ul class="listone">
								<li class="left">CNstorm会员：<?php echo $comment[ 'uname'] ?></li>
								<li class="right">来自：<?php echo $comment[ 'from'] ?></li>
							</ul>
							<ul class="listtwo">
								<li class="corner"></li>
								<li class="dashed">
									<div><?php echo $comment[ 'message'] ?></div>
									<!----查看原图-->
									<div class="view-image-div-box">
										<div class="view-image-div-close"></div>
										<img src="<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])) echo $comment['multyimg']; else if (isset($curImg)) echo $curImg;?>"/>
									</div>
									<!---查看原图结束---->
									<!---初始点击图-->
									<div class="bask_rec_images view-image-list">
										<?php if(!empty($comment[ 'multyimg']) && !is_array($comment['multyimg']) && file_exists($comment[ 'multyimg'])){ ?>
										<img style="float:none" width="150" height="150" src="<?php  echo $comment['multyimg'];?>"/>
										<?php }else if(!empty($comment[ 'multyimg']) && is_array($comment['multyimg'])){ ?>
										<img style="float:none" width="150" height="150" src="<?php  echo $curImg;?>"/>
										<?php } ?>
									</div>
									<div class="bask_image_box">
										<div class="bask_image_box_op">
											<span class="up_down"></span>
											<span class="updown">收起</span>
											<span class="res"></span>
											<span img_src="<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])) echo $comment['multyimg']; else if (isset($curImg)) echo $curImg;?>" class="viewres">查看原图</span>
										</div>
										<div class="bask_image_big">
											<img src="<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])) echo $comment['multyimg']; else if (isset($curImg)) echo $curImg;?>"/>
										</div>
										<div class="bask_iamge_sm">
											<ul class="bask_iamge_sm_ul">
												<?php if(!empty($comment[ 'multyimg']) && !is_array($comment['multyimg'])){ ?>
												<li>
													<img width="76" height="76" src="<?php echo $comment['multyimg']; ?>"/>
													<span></span>
												</li>
												<?php }else if(is_array($comment[ 'multyimg'])){ foreach($comment['multyimg'] as $v){ ?>
												<li>
													<img width="76" height="76" src="<?php echo $v; ?>"/>
													<span></span>
												</li>
												<?php } } ?>
											</ul>
										</div>
									</div>
								</li>
								<li class="reply_txt">
									<dl>
										<dt></dt>
										<dd>
										<?php if ($comment[ 'reply']){ echo $comment[ 'reply'];}else{ ?>
										满意的话下次要继续使用CNstorm哦！O(∩_∩)O~
										<?php } ?>
										</dd>
									</dl>
								</li>
							</ul>
							<div class="clr"></div>
						</div>
						<?php } ?>
					</div>
					<div class="pages_change"><?php echo $pagination; ?></div>
				</div>
			</div>
			<div class="shares width_250">
				<dl class="shares_goods">
					<a href="procurement.html" target="_blank"><img src="image/comment_ad.jpg" alt="comment"/></a>
				</dl>
			</div>
			<div class="shares width_250">
				<h4><span>大家最爱</span></h4>
                                <?php if(isset($love_products)){ foreach($love_products as $row){?>
				<dl class="shares_goods">
					<dt>
						<a href="<?php echo $row['product_id'];?>.html" target="_blank">
							<img alt="<?php echo $row['name'];?>" src='image/<?php echo substr("cache/" . $row["image"], 0, -4) . "-222x222.jpg";?>' onerror="javascript:this.src='/image/product/no_image.jpg';"/>
						</a>
					</dt>
					<dd class="usage">
						<a href="<?php echo $row['product_id'];?>.html" target="_blank"><?php echo $row['name'];?></a>
					</dd>
					<dd class="money">￥<b><?php echo $row['price']; ?></b></dd>
				</dl>
                                <?php }}?>
			</div>
			<div class="CLR"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).on('click', '.list_num li a',function(){
	var url = $(this).attr('href');
	window.scrollTo(0, 475);
	$.ajax({
		type: 'GET',
		url: url,
		success: function(data) {
			$('#dvContent').html(data);
		}
	});
	return false;
});
</script>
<?php echo $footer ?>
</body>
</html>