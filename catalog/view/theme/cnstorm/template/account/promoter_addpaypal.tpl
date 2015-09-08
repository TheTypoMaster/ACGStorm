<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>奖励提现-添加paypal</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/promoter.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/date_select.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $header_cart; ?>
<script type="text/javascript" src="catalog/view/javascript/date_select.js"></script>
<script type="text/javascript" src="catalog/view/javascript/promoter.js"></script>
<style>
.errorMsg{padding-left:140px;color:red}
</style>
<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<div class="content-right">
		<div class="page-title">
			<h2>添加paypal</h2>
		</div>
		<div class="main-contentbox">
			<div class="awardcash-box">
				<div class="withdraw-add <?php if($step==1){?> <?php }else{ ?> hide <?php } ?>"   >
					<p class="wa-steps-title">
						<label class="wast-chars text-align-left">提现到paypal</label>
						<label class="wast-chars text-align-center">安全验证</label>
						<label class="wast-chars text-align-right">完成</label>
					</p>
				
					<span class="wa-steps-icon  <?php if($step==1){ ?> wasi01 <?php }else{ ?> hide <?php } ?>d01"></span>
					<div class="wa-content">
						<p class="wac-title">提现到我的paypal</p>
						<p class="wac-hint"><span class="hint_icon"></span>您可以设置一个paypal帐号，提示：默认绑定第一个提款方式，保存后将无法修改</p>
					<form id="form" action="/account-promoter-sendEmail.html" method="post" onsubmit="return checkFrom()">
							<input type="hidden" name="type" value="2">
							<input type="hidden" name="href" value="/account-promoter-addpaypal.html">
							<p  class="errorMsg" ></p>
							
							<div class="wac-cash-method">
								<label class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真实姓名：</label>
								<input type="text" name="paypal_name" class="border_radius cash-money"/>
							</div>
							
							<div class="wac-cash-method">
								<label class="">paypal email地址：</label>
								<input type="text" name="paypal_email" class="border_radius cash-money"/>
							</div>
							
							<div class="wac-cash-method">
								<input type="submit" value="点击发送" class="border_radius cash-apply" style="margin-left:160px;"/>
							</div>
						</form>
						
					</div>
				</div>
					<script>
			
						function checkFrom(){
						var account=$.trim($('input[name=paypal_email]').val());
						var errorMsg=$('.errorMsg');
						var name=$.trim($('input[name=paypal_name]').val());
							if(name==''|| name.length < 2){
								var msg='真实姓名输入有误';
								errorMsg.html(msg);
								return false;
							}
	
							if(account ==''){
								var msg='邮箱地址不能为空';
								errorMsg.html(msg);
								return false;
							}else{
							
								 var pe=/^[^\@]+@.*\.[a-z]{2,6}$/;
								if(!account || !pe.test(account) ) {
									msg='请输入符合规范的邮箱地址';
									errorMsg.html(msg);
								
									return false;
											} else {
												$.ajax({
													type: "POST",
													url: "index.php?route=account/promoter/checkemail",
													data: {email:account,type:2},
													success: function(flag) {  
														if(flag > 0) {
															msg="该邮箱已经存在";
															errorMsg.html(msg);
														}else{
															msg="邮箱可以使用";
														//	alert(msg);
														}
													}
												});
											}
										}
							}
							</script>

				<div class="withdraw-add   <?php if($step==2){?>wasi02 <?php }else{ ?> hide <?php } ?> ">
					<p class="wa-steps-title">
						<label class="wast-chars text-align-left">提现到paypal</label>
						<label class="wast-chars text-align-center">安全验证</label>
						<label class="wast-chars text-align-right">完成</label>
					</p>
					<span class="wa-steps-icon <?php if($step==2){?>wasi02 <?php }else{ ?> hide <?php } ?>"></span>
					<div class="wa-content">
						<p class="wac-title">安全验证</p>
						<p class="wac-hint"><span class="hint_icon"></span>验证码已经发送到<?php echo $_SESSION['account_email'];?>，请快去查收吧~</p>
						<p class="errorMsg"></p>
						
							<div class="wac-cash-method">
								<label class="">请输入已发送到邮箱里的四位验证码</label>
								<input type="text" name="paypal_code" class="border_radius cash-money"/>
								<input type="button" value="确认" class="border_radius checkPaypalCode cash-apply"/>
								<input type="button" value="上一步" onclick="window.location.href='/account-promoter-addpaypal.html'" class="border_radius cash-apply"/>
							
							</div>
						
						<script>
							$(function(){
								$('.checkPaypalCode').click(function(){
									var code=$.trim($('input[name=paypal_code]').val());
									var errorMsg=$('.errorMsg');
									if(code==''||code.length<4){
										var msg='请输入正确的验证码';
										errorMsg.html(msg);
									}else{
										$.post('/account-promoter-ajaxCheckPaypal.html',{paypal_code:code},function(msg){
											if(msg==111){
												var msg='';
												errorMsg.html(msg);
												window.location.href='/account-promoter-addAccount.html';
											}else if(msg==222){
												var msg='验证码错误';
												errorMsg.html(msg);
											}else if(msg==999){
												var msg='验证码过期';
												errorMsg.html(msg);
											}
										});
									}
									
								})
							})
						</script>
					</div>
				</div>

				<div class="withdraw-add <?php if($step==3){?> <?php }else{ ?> hide <?php } ?> ">
					<p class="wa-steps-title">
						<label class="wast-chars text-align-left">提现到paypal</label>
						<label class="wast-chars text-align-center">安全验证</label>
						<label class="wast-chars text-align-right">完成</label>
					</p>
					<span class="wa-steps-icon wasi03"></span>
					<div class="wa-content wa-content-success">
					<?php if($account_status==1 ){ ?>
						<p class="wac-title"><span class="hint_icon"></span>您的提现账号是:<?php echo $account;?></p>
						<p class="wac-hint"><input type="button" value='点击跳转提现页面' onclick="window.location.href='/account-promoter-cashpaypal.html'"/></p>
						<?php }else{ ?>
						<p class="wac-title">服务器繁忙，请稍后在试！</p>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</div>
<?php echo $footer; ?>
</body>
</html>