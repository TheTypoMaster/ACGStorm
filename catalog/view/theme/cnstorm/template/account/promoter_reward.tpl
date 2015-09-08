<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>奖励详情</title>
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
			<h2>奖励详情</h2>
		</div>
		<div class="main-contentbox">
			<div class="greybg_border">
				<div class="greybgboxs width220">
					<div class="gboxs_orangebg">
						<p class="gboxs_title">累计发放奖励总额（元）</p>
					</div>
					<p class="gboxs_money"><?php echo $numlastmonth;?></p>
				</div>
				<div class="greybgboxs margin_left10">
					<div class="gboxs_greybg">
						<p class="gboxs_title width285 fl">当月奖励在次月15-18号左右发放</p>
						<p class="gboxs_fgx1 fl"></p>
						<p class="gboxs_title width345 fl">可提现总额（元）</p>
					</div>
					<div class="gboxs_data width285 fl">

						<div class="reward_date">
							<select name="year" id="year">
								<option disabled="disabled" class="time_option" value="0">请选择年</option>
							</select>
							<select naem="month" id="month">
								<option disabled="disabled" class="time_option" value="0" >请选择月</option>
							<select>
							<p class="reward_date_money">      <?php echo $indexTotalfee;?>     </p>
						</div>						
					</div>

					<p class="gboxs_fgx2 fl"></p>
					<div class="gboxs_money width345 fl">
				
						<p class=""><?php echo $numCanQuxian;?></p>
						
					</div>
				</div>
			</div><br/>
			<table class="promoter_count">
				<tbody>
					<tr>
						<td><span class="promoter_count_friend"></span>好友统计</td>
						<td>注册好友：<?php echo $child_reg_num; ?> 人</td>
						<td>消费好友：<?php echo $numChildBuy;?> 人</td>
						<td>详情&nbsp;&nbsp;<select class="promoter_count_select" onchange="MM_jumpMenu(this.value)">
								<option value="1">本月</option>
								<option value="2">全部</option>
								<option value="3">最近三个月</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="promoter_count">
				<thead>
					<tr>
						<th>用户名</th>
						<th>订单国际运费</th>
						<th>注册时间</th>
						<th>签收时间</th>
						<th>您获得的奖励</th>
					</tr>
				</thead>
				<tbody>
					<?php if($rows){ 
						foreach($rows as $v){
					?>
					<tr>
						<td><?php echo  $v['uname'];?></td>
						<td>￥<?php echo  $v['totalfee'];?></td>
						<td><?php echo  $v['date_added'];?></td>
						<td><?php echo  date('Y-m-d H:i:s',$v['confirm_receipt_time']);?></td>
						<td>￥<?php echo  $v['yongjin'];?></td>
					</tr>
					<?php } }else{ ?>
					<tr><td colspan='6'> 暂无数据</td></tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>
<script>
		function MM_jumpMenu(value){
					var url='/account-promoter-reward.html&month='+value;
					window.location.href=url;
		}
</script>
<?php echo $footer; ?>

<script type="text/javascript">
$(function(){
	/*循环出年份和月份*/

	var nowYear = <?php echo date('Y',time());?>;
	var nowMonth = <?php echo date('m',time());?>;
	for(var i = nowYear;i>=2000;i--){
		$("#year").append("<option value='"+i+"'>"+i+"</option>");	
	}
	for(var i = 12;i>=1;i--){
		
		if(i==nowMonth){
			$("#month").append("<option value='"+i+"' selected='selected'>"+i+"</option>");	
		}else{
			$("#month").append("<option value='"+i+"'>"+i+"</option>");	
		}
	}
	$("#year").change(function(){
		var year = $("#year").val();
		$("#month option").not($(".time_option")).remove();
		//如果选的是今年
		if(year==nowYear){
			for(var i = nowMonth;i>=1;i--){
				$("#month").append("<option>"+i+"</option>");	
			}		
		}else{
			for(var i = 12;i>=1;i--){
				$("#month").append("<option>"+i+"</option>");	
			}
		}	
	});
	
	$('#year')[0].selectedIndex=1;
	$('#month').change(function(){
		var month=$(this).val();
		var year;
		if($("#year").val()==''){
			year=nowYear;
		}else{
			year=$("#year").val();
		}
		var data={year:year,month:month}
		$.ajax({
			url:'/account-promoter-evermonth.html',
			data:data,
			datatype:'json',
			type:'post',
			success:function(msg){
				if(msg!=''){
					$('.reward_date_money').html(msg);
				}
			}
		})
	});
	
});
</script>
</body>
</html>