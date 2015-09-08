<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>奖励提现-提现到paypal</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/promoter.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/date_select.css" type="text/css" rel="stylesheet"/>
<script> var edu='<?php echo $numCanQuxian;?>';var hl='<?php echo $hl;?>';var sxf='<?php echo $sxf;?>';var isbangding='<?php echo $isbangding;?>' </script>
<style>
	.hide{display:none}
	.errorMsg{color:red}
	#usd{color:blue}
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
				<form id="from" action="/account-promoter-addWCFrom.html" method="post">
					<input type="hidden" name="type" value="2"/>
					<input name="usd" type="hidden" value="" />
					<p>1.最低提款金额为10元,最高提款上限金额为5万元（每人每次最高提现总金额为5万元，不限笔数，每月15-18号统一受理）</p>
					<p>2.申请的每笔提款申请将统一收取5%的技术服务费</p>
					<p class="adb-lines">可提现金额：<em class="abd-money"><?php echo $numCanQuxian;?></em>元</p>
					<?php if($isbangding){?>
					<div class="adb-lines abd-ways">
						<label>请选择提现方式：</label>
						<a href="account-promoter-cashalipay.html" class="abdw-method border_radius">支付宝</a>
						<a href="account-promoter-cashpaypal.html" class="abdw-method border_radius active">paypal</a>
					</div>
					<p class="adb-lines"><span class="hint_icon"></span>您当前选择的提现方式是paypal</p>
					<div class="adb-lines abd-wayicons">
						<span class="abdwi02 active">
							<i class="abdselect_icon"></i>
						</span>
						<p class="abdwi-infors">Paypal全球最大的在线支付平台，可通过国际信用卡和各国银行卡，实现即时付款！<br/>所有使用的货币均以美元进行折算。</p>
					</div>
					<div class="adb-lines">提现金额：
						<input type="tetx" name="money"   placeholder="￥00.00" class="border_radius cash-money"/>人民币&nbsp;&nbsp;外币充值汇兑损失约为：3%-3.5%
						<p><br/>实际提现到账： $<span id="usd">0.00</span>&nbsp;&nbsp;美元，当前汇率：1人民币元=0.16美元</p>
					</div>
					<p class="hide errorMsg" ><?php echo $error;?></p>
					<div class="adb-lines">
						<input type="submit" value="申请提现" class="border_radius cash-apply"/>
					</div>
					<?php }else{ ?>
						<p class="adb-lines">请先绑定Paypal账号,请点击<a href="/account-promoter-addpaypal.html">【这里】</a></p>
						<?php } ?>
				</form>
			</div>
		</div>
	</div>
</div>
			<script>
					$(function(){
						edu=Number(edu);
						var state=false;
					$('input[name=money]').blur(function(){
								var money=$(this).val();
								money=Number(money);
								if(edu>0 ){
										if(money==''){
											var msg='当前输入金额不能为空';
											$('.errorMsg').removeClass('hide').html(msg);
											return false;
										}
										
										if(edu < money ){
											var msg='可提现金额小于当前输入金额';
											$('.errorMsg').removeClass('hide').html(msg);
											return false;
										}
										
										if(money < 10 || money > 50000 ){
											var msg='当前输入金额不在范围内';
											$('.errorMsg').removeClass('hide').html(msg);
											return false;
										}
										
										if( edu > 0 && money !='' && money < edu && money >= 10 && money < 50000 ){
											$('.errorMsg').html('');
												money = money - money*sxf;
												var usd = money *hl ;
												console.log(usd);
												usd=usd.toFixed(2);
												$('#usd').html(usd);
												$('input[name=usd]').val(usd);
												state=true;
										}
								}else{
										var msg='可提现金额为0';
										$('.errorMsg').removeClass('hide').html(msg);
										return false;
								}
					});
							
						$('#from').submit(function(){
						
								if(state){	
									return true;
								}else{
									return false;
								}
								
							})
					})
				</script>

</div>
</div>
<?php echo $footer; ?>
</body>
</html>