<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>国际运单详情-CNstorm国际转运为您提供国际运单管理</title>
<meta name="keywords" content="国际运单服务, 国际运单，运单列表，运单信息，运单编号，合并运单，快递公司，转运公司，国际转运，转运中国，中国转运，中国运输，海外转运" />
<meta name="description" content="欢迎来到你的国际运单页面，对你的运输订单状态进行管理" />
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/order.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $header_cart; ?>
<?php echo $uc_business; ?>
<style type="text/css">
.main{width: 1200px;margin: auto;}
.sod_banner{z-index: 101;position: relative;margin-top: 0px;}
.n_left{float: left;width: 198px;height: 329px;border: 1px solid #cccccc;margin-right: 10px;}
.n_left_title {height: 2px;font-size: 0px;background: #0078D4;}
.title_l{font-size: 15px;color: gray;margin-left: 18px;height: 25px;border-bottom: 1px solid #EAEAEA;}
.content_l{color: gray;margin-left: 8px;margin-right: 8px;margin-top: 10px;}
.track_box { float: left; min-height: 298px; width: 989px; margin-bottom: 98px; }
.track_box .admin_table { height: auto !important; }
.track_box table { margin: 8px; }
.track_box table .td1 { background-color: #D2E2EF; }
.track_box table .tab4 { padding: 18px; background-color: #F5F5F5; }
.track_box table .tab66 { padding: 8px; }
</style>
<div class="content-right">
	<div class="daigou_list">
		<div class="dl_head">
			<h3 class="bg2">国际运单详情</h3>
		</div>
		<ul class="odetails-methodtabs">
			<li class="curr">√支付国际运费<b class="odetails-triangle"></b></li>
			<li>发货<b class="odetails-triangle"></b></li>
		</ul>
		<ul class="odetails-steptips">
			<li class="first-step step-1-done"></li>
			<li class="step-2-done"></li>
			<li class="step-3-done"></li>
			<li class="last-step"></li>
		</ul>
		<ul class="odetails-stepcont">
			<li class="stepcont01">
				<span class="mainColor">提交运单</span>
				<br/><?php if($result['addtime']){ echo date('Y-m-d,H:i:s',$result['addtime']);}?>
			</li>
			<li class="stepcont02">
				<span class="mainColor">包裹派送</span>
				<br/><?php if($result['delivery_time']){  echo date('Y-m-d,H:i:s',$result['delivery_time']);}?>
			</li>
			<li class="stepcont03">
				<span class="mainColor">确认收货</span>
				<br/> <?php if($result['confirm_receipt_time']){  echo date('Y-m-d,H:i:s',$result['confirm_receipt_time']);}?> 
			</li>
			<li class="stepcont04">
				<span class="">评价</span> 
				<br/><?php if($result['commenttime']){  echo date('Y-m-d,H:i:s',$result['commenttime']);}?>
			</li>
		</ul>
		</div>
		
	<!--qwqwq-->	
    <?php if(isset($carrier)){ if ($carrier == 'malay'){?>
	
  <div style="text-align: center;height:auto;">
      <div id="load" align="center">
<img src="/catalog/view/theme/cnstorm/images/loading_data.gif" />
</div> <!-- 首先放一个div，用做loading效果 -->
    <iframe id="trace" style="margin-top:-154px;position:relative;z-index:100;min-height:629px;" src="<?php echo $link ?>" width="980" frameborder="0" scrolling="no"></iframe>
  </div>
	
  <?php }else if ($carrier == 'au') { ?>
  
  <div class="track_box">
    <?php echo $au_text;?>
  </div>
  <?php }else if ($carrier == 'dhlen') { ?>
  
<div style="text-align: center;height:auto;">
    <div id="load" align="center">
<img src="/catalog/view/theme/cnstorm/images/loading_data.gif" />
</div> <!-- 首先放一个div，用做loading效果 -->
  <iframe id="trace" style="margin-top:-51px;position:relative;z-index:100;min-height:688px;" src="<?php echo $link ?>" width="980" frameborder="0" scrolling="no"></iframe>
</div>
  <?php }else{ ?>
  
<div style="text-align: center;height:auto;">
    <div id="load" align="center">
<img src="/catalog/view/theme/cnstorm/images/loading_data.gif" />
</div> <!-- 首先放一个div，用做loading效果 -->
  <iframe id="trace" style="margin-top:-51px;position:relative;z-index:100;min-height:688px;" src="<?php echo $link ?>" width="980" frameborder="0" scrolling="no"></iframe>
</div>

<?php }}else{ ?>
  <div class="track_box">
	<?php if(isset($track_text) && !empty($track_text)){
			echo $track_text;
		}else{
			echo $au_text;
		} ?>
	</div>
<?php } ?>
 

<script type="text/javascript">
    var a = document.getElementById("trace");
    var b = document.getElementById("load");
    var c = document.getElementById("div0");
    if (a) {
    a.onload = function() {
        a.style.display = "block"; //显示
        b.style.display = "none"; //隐藏 
    }
  }else { c.style.display = "block"; }
</script>

	<!--qwqwq-->	
		<p class="odetails-splittitle">收件人信息：</p>
		<ul class="odetails-addressee">
			<li>姓名：<?php echo $result['consignee'];?></li>
			<li>电话：<?php echo $result['tel'];?></li>
			<li>国家 / 区域：<?php echo $result['country'];?></li>
			<li>城市：<?php echo $result['city'];?></li>
			<li>邮编：<?php echo $result['zip'];?></li>
			<li>州/省/区域：<?php echo $result['city'];?></li>
			<li>地址：<?php echo $result['address'];?></li>
		</ul>
		
		<p class="odetails-splittitle">运单信息：</p>
		<ul class="odetails-addressee">
			<li>运单编号：<?php echo $result['sid'];?></li>
			<li>包裹预估重量：<?php echo $result['countweight'];?>g</li>
			<li>实付款：<?php echo $result['totalfee'];?>元</li>
			<li>包裹退款：</li>
			<li>包裹实际重量：<?php echo $result['countweight'];?> </li>
			<li>提交时间：<?php echo date('Y-m-d',$result['addtime']);?></li>
		</ul>
		<p class="odetails-splittitle">增值服务信息：</p>
		<ul class="odetails-addressee">
			<li>打包策略：<?php if($result['dabao']==1){echo '免费方案';}elseif($result['dabao']==2){echo '标准方案';}else if($result['dabao']==3){echo '高级方案';}?></li>
			<li>订单处理：<?php if($result['dingdan']==1){echo '免费方案';}elseif($result['dingdan']==2){echo '标准方案';}else if($result['dingdan']==3){echo '高级方案';}?></li>
			<li>增值服务：<?php if($result['zengzhi']==1){echo '提供大包裹方案';}elseif($result['zengzhi']==2){echo '提供运单拍照';}?></li>
			<li>包装耗材：<?php if($result['baozhuang']==1){echo '免费方案';}elseif($result['baozhuang']==2){echo '标准方案';}else if($result['baozhuang']==3){echo '高级方案';}?></li>
			<li>小费打赏：<?php if($result['donation']){echo $result['donation'];}else{ echo '不打赏';}?></li>
		</ul>
		
		<p class="odetails-splittitle">订单信息：</p>
		<table class="odetails-orderonfors">
			<thead>
				<tr>
					<th>订单信息</th>
					<th>订单编号</th>
					<th>单价（元）</th>
					<th>数量</th>
					<th>合计</th>
					<th>重量（克）</th>
					<th>订单状态</th>
				</tr>
			</thead>
			<tbody>
			<?php
					
				foreach($order_products as $order_product){ 
						foreach($order_product as $v){
					?>
				<tr>
					<td>
						<a href="<?php echo $v['producturl'];?>" title="" target="_blank" class="odo-pic">
							<img src="<?php echo $v['img'];?>" width="63" height="68" alt=""/>
						</a>
						<div class="odo-desc">
					<p class="odo-name">
					<a href="<?php echo $v['producturl'];?>" target="_blank" class="blueColor" title="<?php echo $v['name'];?>"><?php echo $v['name'];?></a>
					</p>
							<p class="odo-spec"><span>颜色：<?php echo $v['option_color'];?></span><span>尺码：<?php echo $v['option_size'];?></p>
							<p class="odo-mark">备注：<?php echo $v['weight'];?></p>
						</div>
					</td>
					<td><?php echo $v['order_product_id']; ?></td>
					<td>￥<?php echo $v['price'];?></td>
					<td><?php echo $v['quantity'];?></td>
					<td>￥<?php echo $v['total'];?></td>
					<td><?php echo $v['weight'];?></td>
					<td><?php switch($v['state']){
										case 0:
											echo '待付款';
									break;
										case 1:
										echo '已付款';
									break;
										case 2:
										echo '已邮寄';
									break;
										case 3:
										echo '已确认收货';
									break;
										case 4:
										echo '无效运单';
									break;
										case 5:
										echo '准备邮寄';
									break;
										case 6:
										echo '待补交运费';
									break;
										case 7:
										echo '信息不全';
									break;
										case 8:
										echo '已评价';
									break;
										case 10:
										echo '待取消';
									break;	} ?></td>
				</tr>
			<?php } 
			
			} ?>	
				
			</tbody>
		</table>
	</div>
</div>
</div>
<?php echo $footer; ?>
</body>
</html>