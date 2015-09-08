<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>邀请规则</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/promoter.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $header_cart; ?>
<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<div class="content-right">
		<div class="page-title">
			<h2>邀请规则</h2>
		</div>
		<div class="main-contentbox">
			<h3 class="greybg-fontsize16">邀请方式：复制链接给好友注册</h3>
			<div class="promoter-links">
				<label class="fl">推荐链接：</label>
				<input type="text" class="fl" id="Fcode" value="强烈推荐你来！<?php echo $url; ?>我注册了CNstorm账号，这里不但可以淘国货，服务也很赞，更可以赚佣金哦，我已经月入过万了！"/>
				<a href="javascript:;" onclick="copy()" class="mainBg fl">复制链接</a>
				<script>
				function copy(){
							var cont=document.getElementById('Fcode'); 
							cont.select();
							if (navigator.userAgent.indexOf('Firefox') >= 0){
									alert('内容已选中,请使用CTRL+C复制内容！');
							}else{  
								document.execCommand('Copy'); 
								alert('复制成功！');
							}
						}
				</script>
			</div>
			<h3 class="greybg-fontsize16">推广员规则：</h3>
			<div class="contentbox-infors">
				<h6>一、普通推广员</h6>
				<p>1.每位在CNstorm注册的会员，均可以成为推广员，推广员的级别为普通。</p>
				<p>2.您推荐注册的好友，在CNstorm消费（产生了国际运单的消费记录）您将获得该运费额度的4%的现金奖励，因此，您好友在CNstorm的国际运单消费额度高低与您的收入成正比。</p>
				<h6>二、高级推广员</h6>
				<p>1.只要成功推荐3名好友消费（有国际运单消费）则可成为高级推广员。</p>
				<p>2.高级推广员的好友消费（国际运单消费），可获得该运费额度的6%现金奖励。</p>
				<p>3.当用户满足晋升高级推广员的条件，在次日零点（参考时间为世界标准时间UTC的次日0点，比北京时间慢8个小时）生效，晋升成为高级推广员。</p>
			<h6>三、奖励计算与发放</h6>
			<p>1.推广员等级变更（通常为升级），在新等级生效当天零点（世界标准时间），奖励方式将按照新等级的奖励规则计算，比如您在普通推广员阶段是享受4%的国际运单消费返利，晋升到高级推广员后，则可享受6%的返利。</p>
				<p>2.当推广员所推荐的好友消费，并签收了包裹（需是国际运单），该笔奖金自动发放到推广员账户上。</p>
				<p>3.关于推广员每个月推广奖励结算，对应的提现申请将在次月的15-18号进行处理，发放到推广员的CNstorm账户上，到账时间一般为3-5个工作日，如遇节假日则会顺延。</p>
				<p>4.提现金额最低10元起受理，每位用户单笔最高提现金额不超过5万元，提现不限笔数，每月15-18号统一受理提现申请。</p>
				<p>5.每笔提现申请，CNstorm将收取5%的技术服务费，用于建设和发展CNstorm平台，希望能够为广大CNstorm用户提供更优质的服务。</p>
				<h6>四、赚钱小攻略</h6>
				<p>1.每成功邀请一位好友且该好友购物成功并收到所购商品后（国际运单），即可获得对应的返利，邀请越多，现金返利越多，不设上限。</p>
				<p>2.记得哦，所推广的好友是国际运单才能获得现金返利哦（国内运单无效）。</p>
				<p>3.建议复制链接到各种论坛，社区，QQ群等地方，微博微信也行哦，可能会有意想不到的惊喜！</p>
				<h6>五、我们的优势</h6>
				<p>1.推荐好友的返利上不封顶，好友所产生的每一单国际运单，推广员即可从中获得4%或者6%的返利，不存在一个好友只能享受一次返利的情况，轻轻松松赚钱，搞不好还可以往家里寄钱哦~</p>
				<p>2.CNstorm推荐好友所得返利是真正的money哦，不会像一些平台做得噱头十足，而返现的只是抵用券（有效期还很短），CNstorm返给推广员的是真金白银，可申请提现哦！购物赚钱一举两得，心动不如行动！</p>
				<h6>六、温馨提示</h6>
				<p>1.现推广员规则会依据平台的运营情况进行相应的调整，届时以官方公告通知为准。</p>
				<p>2.若推广员采用作弊手段恶意推广，或者推荐的好友身份异常，一经核实，CNstorm保留拒绝支付奖励或删除相应好友的权利。</p>
				<p>3.在法律许可范围内，CNstorm对该推广员规则保留最终解释权。</p>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<?php echo $footer; ?>
</body>
</html>