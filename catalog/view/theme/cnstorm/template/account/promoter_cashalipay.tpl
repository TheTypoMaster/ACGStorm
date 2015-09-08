<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>奖励提现-提现到支付宝</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/promoter.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/date_select.css" type="text/css" rel="stylesheet"/>
<script> var edu=<?php echo $numCanQuxian;?>;var isBangding=<?php echo $isbangding;?></script>
<style>
	.hide{display:none}
	.errorMsg{color:red}
</style>
</head>
<body>
<?php echo $header_cart; ?>
<script type="text/javascript" src="catalog/view/javascript/date_select.js"></script>
<script type="text/javascript" src="catalog/view/javascript/promoter.js"></script>
<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<div class="content-right">
		<div class="page-title">
			<h2>奖励提现</h2>
		</div>
		<div class="main-contentbox">
			<div class="awardcash-box">
				<form id="from" action="/account-promoter-addWCFrom.html" method="post" >
					<input type="hidden" name="type" value="1"/>
					<p>1.最低提款金额为10元,最高提款上限金额为5万元（每人每次最高提现总金额为5万元，不限笔数，每月15-18号统一受理）</p>
					<p>2.申请的每笔提款申请将统一收取5%的技术服务费</p>
				<p class="adb-lines">可提现金额：<em class="abd-money"><span id="ed"><?php echo $numCanQuxian;?></span></em> 元</p>
				<?php if($isbangding){?>
					<div class="adb-lines abd-ways">
						<label>请选择提现方式：</label>
						<a href="account-promoter-cashalipay.html" class="abdw-method border_radius active">支付宝</a>
						<a href="account-promoter-cashpaypal.html" class="abdw-method border_radius">paypal</a>
					</div>
					<p class="adb-lines"><span class="hint_icon"></span>您当前选择的提现方式是支付宝</p>
					<div class="adb-lines abd-wayicons">
						<span class="abdwi01 active">
							<i class="abdselect_icon"></i>
						</span>
			<p class="abdwi-infors">支付宝(中国)网络技术有限公司是中国领先的独立第三方支付平台，是阿里巴巴集团的关联公司。<br/>无论您使用的是何种货币账户，支付宝均以人民币进行折算。</p>
					</div>
					<div class="adb-lines">提现金额：
						<input type="tetx" name="money" placeholder="￥00.00" class="border_radius cash-money"/>人民币&nbsp;&nbsp;外币充值汇兑损失约为：3%-3.5%
					</div>
					<p class="hide errorMsg" ><?php echo $error;?></p>
					<div class="adb-lines">
						<input type="submit" value="申请提现" class="border_radius cash-apply"/>
					</div>
					<?php }else{ ?>
						<p class="adb-lines">请先绑定支付宝,请点击<a href="/account-promoter-addalipay.html">【这里】</a></p>
						
					<?php } ?>
				</form>
				<script>
				
					$(function(){
						edu=Number(edu);
						var status=0;
						$('#from').submit(function(){
								if(status){
									return true;
								}else{
									$('input[name=money]').trigger('blur');

									return false;
								}
							})
							
							$('input[name=money]').blur(function(){
							
								var money=$('input[name=money]').val();
								money=Number(money);
								if(edu>0 ){
								
										if(money==''){
											var msg='当前输入金额不能为空';
											$('.errorMsg').removeClass('hide').html(msg);
											status=0;
											return false;
										}else if(edu < money || money < 10 || money > 50000  ){
											var msg='当前输入金额不在范围内';
											$('.errorMsg').removeClass('hide').html(msg);
											status=0;
											return false;
										}else{
											status=1;
											$('.errorMsg').removeClass('hide').html('');
										}
										
									}else{
										var msg='可提现金额为0';
										status=0;
										$('.errorMsg').removeClass('hide').html(msg);
										return false;
									}
							})

					})
				</script>
			</div>
		</div>
	</div>
</div>

</div>
</div>
<?php echo $footer; ?>
</body>
</html>