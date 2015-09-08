<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>奖励提现-添加支付宝</title>
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
<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<style>
		.color_red{color:red}
		.color_green{color:green}
		.pf135{padding-left:135px}
		.pf200{padding-left:200px}
	</style>
	<div class="content-right">
		<div class="page-title">
			<h2>添加支付宝</h2>
		</div>
		<div class="main-contentbox">
			<div class="awardcash-box">
				<div class="withdraw-add <?php if($step==1){?> <?php }else{ ?> hide <?php } ?> ">
					<p class="wa-steps-title">
						<label class="wast-chars text-align-left">提现到支付宝</label>
						<label class="wast-chars text-align-center">安全验证</label>
						<label class="wast-chars text-align-right">完成</label>
					</p>
					
					
				<span class="wa-steps-icon wasi01 d01"></span>
					
					<div class="wa-content">
						<p class="wac-title">提现到我的支付宝</p>
						<p class="wac-hint"><span class="hint_icon"></span>提示：默认绑定第一个提款方式，保存后将无法修改</p>
						<form action="/account-promoter-saveAliUname.html" method="post" onsubmit="return checkFrom()">
						
							<input type="hidden" name="type" value="1">
							<input type="hidden" name="href" value="/account-promoter-addalipay.html">
								<p class="msg" class="color_red pf135" ></p>
							<div class="wac-cash-method">
								<label class="wac-cm-label">支付宝帐号：</label>
								<input type="text" name="apipay_account" class="border_radius cash-money"/>
							</div>
							<div class="wac-cash-method">
								<label class="wac-cm-label">支付宝真实姓名：</label>
								<input type="text" name="apipay_name" class="border_radius cash-money"/>
							</div>
							<div class="wac-cash-method">
						
								<input type="submit" value="保存修改" class="border_radius cash-apply" style="margin-left:160px;"/>
							</div>
						</form>
					</div>
				</div>
				<script>
				
					function checkFrom(){
						var account=$.trim($('input[name=apipay_account]').val());
						var name=$.trim($('input[name=apipay_name]').val());
						var errormsg=$('.msg');
						if(account ==''){
							var msg='支付宝账号不能为空';
							errormsg.html(msg);
							return false;
						}
						
						if(name ==''){
								var msg='支付宝真实姓名不能为空';
								errormsg.html(msg);
								return false;
						}
					
					}
					
				</script>

				
				<div class="withdraw-add <?php if($step==2){?>wasi02 <?php }else{ ?> hide <?php } ?> ">
					<p class="wa-steps-title">
						<label class="wast-chars text-align-left">提现到支付宝</label>
						<label class="wast-chars text-align-center">安全验证</label>
						<label class="wast-chars text-align-right">完成</label>
					</p>
					<span class="wa-steps-icon wasi02"></span>
					<div class="wa-content">
						<p class="wac-title">安全验证</p>
						<p class="wac-hint"><span class="hint_icon"></span>为确保您的账户安全，我们将通过邮箱发送一个验证码来核实您确是该账户的真实拥有者。</p>
						<form action="" method="post">
						<p class="color_red pf200"id="emallmsg"></p>
							<div class="wac-cash-method">
								<label class="">第一步：发送验证码到我的邮箱</label>
								<input type="text" name="apipay_send" class="border_radius cash-money"/>
								<input type="button" value="发送" class="border_radius cash-apply sendaliemail"/>
							</div>
							<div class="wac-cash-method">
								<label class="">第二步：输入邮箱接收的验证码</label>
								<input type="text" name="apipay_code" class="border_radius cash-money"/>
								<input type="button" value="确认" class="border_radius cash-apply codeCheck"/>
							</div>
						</form>
					</div>
				</div>
<script>
var wait_time = 60; //设置秒数(单位秒) 
var secs_time = 0;   

function time(){
	for(var i=1;i<=wait_time;i++) 
	{ 
	 window.setTimeout("sTimer("+i+")",i*1000); 
	} 
}

function sTimer(num) { 
 if(num==wait_time) 
 { 
  $('.sendaliemail').val("发送"); 
  $('.sendaliemail').attr('disabled',false); 
 } 
 else 
 { 
  secs_time=wait_time-num; 
  $('.sendaliemail').val(secs_time);
 
 } 
	}

$(function(){
	
$('.sendaliemail').click(function(){

	var account=$.trim($('input[name=apipay_send]').val());
	var errorMsg=$('#emallmsg');
	var button=$(this);
	if(account==''){
		msg='邮箱不能为空';
		errorMsg.removeClass('color_green').addClass('color_red').html(msg);
		return false;
	}else{
	
		 var pe=/^[^\@]+@.*\.[a-z]{2,6}$/;
								if(!account || !pe.test(account) ) {
									msg='请输入符合规范的邮箱地址';
									errorMsg.removeClass('color_green').addClass('color_red').html(msg);
									return false;
											} else {
												$.ajax({
													type: "POST",
													url: "index.php?route=account/promoter/checkemail",
													data: {email:account,type:1},
													success: function(flag) {  
														if(flag > 0) {
															msg="该邮箱已经存在";
															errorMsg.removeClass('color_green').addClass('color_red').html(msg);
															return false;
														}else{
															button.attr("disabled", "disabled");
															time();
															msg="邮箱可以使用";
															errorMsg.removeClass('color_red').addClass('color_green').html(msg);
															$.post('/account-promoter-sendEmail.html',{email:account,type:1},function(data){
																if(data == 1){
																	msg='邮件已发送';
																	errorMsg.removeClass('color_red').addClass('color_green').html(msg);
																}
															});
														}
													}
												});
											}
	}
});

$('.codeCheck').click(function(){
		var code=$.trim($('input[name=apipay_code]').val());
		var errorMsg=$('#emallmsg');
	if(code==''){
			errorMsg.removeClass('color_green').addClass('color_red').val('验证码不能为空');
			return false;
	}else{
		
		$.ajax({
			url:'/account-promoter-ajaxCheckCode.html',
			type:'post',
			data:'ali_code='+code,
			dataType:'json',
			success:function(msg){
				if(msg==111){
					errorMsg.removeClass('color_red').addClass('color_green').html('验证成功');
					window.location.href='/account-promoter-addAccount.html';
				}else if(msg==222){
					errorMsg.removeClass('color_green').addClass('color_red').html('验证码错误');
				}else if(msg==999){
					errorMsg.removeClass('color_green').addClass('color_red').html('验证码过期 请重新发送');
				}
			}
		})
	}
})


})
</script>

				<div class="withdraw-add <?php if($step==3){?> <?php }else{ ?> hide <?php } ?>">
					<p class="wa-steps-title">
						<label class="wast-chars text-align-left">提现到支付宝</label>
						<label class="wast-chars text-align-center">安全验证</label>
						<label class="wast-chars text-align-right">完成</label>
					</p>
					<span class="wa-steps-icon wasi03"></span>
					<div class="wa-content wa-content-success">
						<p class="wac-title"><span class="hint_icon"></span>您的提现方式已经更新完毕！账号：<?php echo $account;?></p>
				<p class="wac-hint"><input type="button" value='点击跳转提现页面' onclick="window.location.href='/account-promoter-cashalipay.html'"/></p>
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