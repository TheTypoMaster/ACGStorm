<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>我的任务</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/member.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $header_cart; ?>
<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<div class="contentbox-right">
		<div class="member-content">
			<h3 class="title-splits">推荐任务</h3>
			<div class="task-boxs f_l">
				<div class="task-lefticon"><span class="tli_icon1"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">每天签到</h2>
					<p class="task-supplement">每天签到可以拿积分又可获得1点成长值</p>
					<p class="task-situation">完成情况：<em>0</em>/1次</p>
					<p class="task-situation">成长值奖励：+<em>1</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do">做任务</a>
				</div>
			</div>
			<div class="task-boxs f_r">
				<div class="task-lefticon"><span class="tli_icon2"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">每天答题</h2>
					<p class="task-supplement">每天答题可以拿积分又可获得1点成长值</p>
					<p class="task-situation">完成情况：<em>1</em>/1次</p>
					<p class="task-situation">成长值奖励：+<em>1</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do task-complete">已完成</a>
				</div>
			</div>
			<div class="task-boxs f_l">
				<div class="task-lefticon"><span class="tli_icon3"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">每天消费</h2>
					<p class="task-supplement">每天消费至多能获得50点成长值</p>
					<p class="task-situation">完成情况：<em>0</em>/1次</p>
					<p class="task-situation">成长值奖励：+<em>5</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do">做任务</a>
				</div>
			</div>
			<div class="task-boxs f_r">
				<div class="task-lefticon"><span class="tli_icon4"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">首次充值</h2>
					<p class="task-supplement">首次充值成功后可获得50点成长值</p>
					<p class="task-situation">完成情况：<em>0</em>/1次</p>
					<p class="task-situation">成长值奖励：+<em>50</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do">做任务</a>
				</div>
			</div>
		</div>
		<div class="member-content">
			<h3 class="title-splits">热门任务</h3>
			<div class="task-boxs f_l">
				<div class="task-lefticon"><span class="tli_icon5"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">累计消费</h2>
					<p class="task-supplement">累计消费金额达到5000元  次日结算</p>
					<div class="task-situation">
						<div class="task-progress">
							<div class="task-progress-unfinished"></div>
							<div class="task-progress-complete tpc-16" title="16%"></div>
						</div>
						<em>800</em>/5000
					</div>
					<p class="task-situation">成长值奖励：+<em>100</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do">做任务</a>
				</div>
			</div>
			<div class="task-boxs f_r">
				<div class="task-lefticon"><span class="tli_icon6"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">运单单数</h2>
					<p class="task-supplement">国际运单累计达到100单  次日结算</p>
					<div class="task-situation">
						<div class="task-progress">
							<div class="task-progress-unfinished"></div>
							<div class="task-progress-complete tpc-15" title="15%"></div>
						</div>
						<em>15</em>/100
					</div>
					<p class="task-situation">成长值奖励：+<em>50</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do">做任务</a>
				</div>
			</div>
			<div class="task-boxs f_l">
				<div class="task-lefticon"><span class="tli_icon7"></span></div>
				<div class="task-rigthconts">
					<h2 class="task-title">国际运费</h2>
					<p class="task-supplement">国际运费累计达到5000元  次日结算</p>
					<div class="task-situation">
						<div class="task-progress">
							<div class="task-progress-unfinished"></div>
							<div class="task-progress-complete tpc-60" title="60%"></div>
						</div>
						<em>3000</em>/5000
					</div>
					<p class="task-situation">成长值奖励：+<em>50</em>点</p>
					<a href="javascript:void(0);" target="_blank" class="task-do">做任务</a>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
(function(){
	for(var i=0;i<100;i++){
		$(".task-progress .tpc-"+i+"").css({"width":i+"%"});
	}
})();
</script>
</body>
</html>