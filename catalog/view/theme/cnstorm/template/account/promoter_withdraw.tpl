<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>提现查询</title>
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
<script src="catalog/view/javascript/jquery/DatePicker/WdatePicker.js"></script>

<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<div class="content-right">
		<div class="page-title">
			<h2>提现查询</h2>
		</div>
			<div class="withdraw_query">
				<label><span class="wq_data_icon"></span>申请时间：</label>
				 <input  validate=" required:true" name="filter_date_start1" type="text"  onfocus="WdatePicker({onpicking:function(dp){call(dp.cal.getNewDateStr(),'filter_date_start1')}})" value="<?php echo $filter_date_start; ?>" >
				<label>至</label>
			  <input  validate=" required:true" name="filter_date_end1" type="text" 
			  onfocus="WdatePicker({onpicking:function(dp){call(dp.cal.getNewDateStr(),'filter_date_end1')}})" value="<?php echo $filter_date_end; ?>" >
				<input type="hidden" name="filter_date_start">
				<input type="hidden" name="filter_date_end">
				<select class="withdraw_query_select" name="selectMonth" onchange="MM_jumpMenu(this.value)">
					<option value="1" <?php if($month==1){echo "selected='true'";} ?> >本月</option>
					<option value="2" <?php if($month==2){echo "selected='true'";} ?>>全部</option>
					<option value="3" <?php if($month==3){echo "selected='true'";} ?>>最近三个月</option>
				</select>
				<input type="button" value="查询" onclick="select_time()" class="wq_submit"/>
			</div>
		<script>
				function call(dp,who){
					if(who=='filter_date_end1'){
						$('input[name=filter_date_end]').val(dp);
					}else{
						$('input[name=filter_date_start]').val(dp);
					}
				}
				function MM_jumpMenu(value){
					var url='/account-promoter-withdraw.html&month='+value;
					window.location.href=url;
				}
		</script>
		<div class="main-contentbox">
			<table class="promoter_count">
				<thead>
					<tr>
						<th>提款金额</th>
						<th>手续费</th>
						<th>提款方式</th>
						<th>提现流水号</th>
						<th>提交时间</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody>
				<?php if($rows){ 
						foreach($rows as $v){
					?>
					<tr>
						<td>￥<?php echo $v['money'];?></td>
						<td>￥<?php if($v['sxf']==0){echo $v['money']*0.05;}else{ echo $v['sxf'];}?></td>
						<td><?php if($v['type']==1){ echo '支付宝';}else{echo 'Paypal';}?></td>
						<td><?php echo $v['serial_no'];?></td>
						<td><?php if($v['add_time']){ echo date('Y-m-d H:i:s',$v['add_time']);}else{ echo ''; }?></td>
						<td><?php if($v['status']==0){ echo '处理中';}else{echo '已处理'; }?></td>
					</tr>
					<?php
						 }
					   }else{
					?>
					<tr><td colspan="6">暂无数据</td></tr>
					<?php }?>
				</tbody>
			</table>
			 <div class="pages_change"><?php echo $pagination; ?></div>
		</div>
	</div>
</div>
</div>
</div>
<script>
	function select_time() {
		url = '/account-promoter-withdraw.html';

		var filter_date_start = $('input[name=filter_date_start]').attr('value');
		
		if (filter_date_start) {
			url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
		}

		var filter_date_end = $('input[name=filter_date_end]').attr('value');
		
		if (filter_date_end) {
			url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
		}		
		location = url;
	}
</script>

<?php echo $footer; ?>
</body>
</html>