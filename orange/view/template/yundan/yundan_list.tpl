<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<style type="text/css">
	.outBound, .confirm {width: 18px; height: 18px;}
</style>
<div id="content">
  <div class="content" style="font-family: Microsoft Yahei;">
    <div align="center"><img src="/image/data/logo.png" width="198" height="auto"></div>
    <div align="center" style="line-height: 58px;font-size: 16px;font-weight: bold;">运单<?php echo $order_id ;?>发货清单</div>扫描商品快递号：
    <input type="text" class="scannerInput" style="height:28px;width:180px;border:1px solid #ccc;padding-left:10px;margin-bottom:15px;" />
    <span class="scannerSpan" style="display:none;">请稍等...</span>
    <form action="<?php if ( isset($action) ) echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table width="100%" border="1" cellpadding="0" cellspacing="0" align="center" >
        <tr>
          <td align="left">用户名字:<?php echo $consignee ;?></td>
          <td align="left">国家:<?php echo $country ;?></td>
          <td align="left">商品数量:<?php echo $sum ;?></td>
          <td align="left">运输方式:<?php echo $express ;?></td>
          <td align="left" colspan="3"><?php echo $dabao ;?>&nbsp;<?php echo $dingdan ;?>&nbsp;<?php echo $baozhuang ;?>&nbsp;<?php echo $zengzhi ;?></td>
        </tr>
        <tr>
          <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">序号</td>
          <td align="center">商品名称</td>
          <td align="center">订单ID</td>
          <td align="center">来源商家</td>
          <td align="center">数量</td>
          <td align="center">库管出库确认</td>
          <td align="center">打包员确认</td>
        </tr>
        <?php 
		  if($results){
		  
		    foreach ($results as $key => $result) { 
			?>
        <tr>
          <td align="center">&nbsp;<?php echo $result['totalnum']+1 ;?></td>
          <td align="center">&nbsp;<a href="<?php echo $result['producturl'];?>" target="_blank"><?php echo $result['name'] ;?></a></td>
          <td align="center">&nbsp;<?php echo $result['product_id'] ;?></td>
          <td align="center">&nbsp;<?php echo $result['mpn'] ;?></td>
          <td align="center">&nbsp;<?php echo $result['quantity'] ;?></td>
          <td align="center">&nbsp;
	    <input type="hidden" class="hidSid" value="<?php echo $result['kuaidi_no']; ?>" />
	    <?php if ($result['outBound']==1){ ?>
	    <input class="outBound" type="checkbox" checked>
	    <?php }else{ ?>
	    <input class="outBound" type="checkbox">
	    <?php } ?></td>
          <td align="center">&nbsp;
            <input class="confirm" type="checkbox" ></td>
        </tr>
        <?php
		 }
		  }
		  ?>
        <tr >
          <td colspan="8" align="right">感谢阁下选择CNstorm，我们竭诚为您提供极致国际购物及运输体验!<br/>
            TeL:(0086)75581466633</br>
            Mailbox：support@cnstorm.com</br>
            CNstorm(ShenZhen) Co.,Ltd. All rights reserved.</td>
        </tr>
      </table>
    </form>
  </div>
</div>
</div>
<script>
$(".scannerInput").keydown(function(event){
	var event =event||window.event;
	var scannerValue = $(".scannerInput").val();
	if (event.keyCode == 13){
		$(".scannerSpan").show();
		var i = 0;
		$(".hidSid").each(function(index){
			var self = $(this);
			if (self.val() == scannerValue){
				$.ajax({
					url:'index.php?route=yundan/yundan/outBound&token=<?php echo $token; ?>',
					dataType:"json",
					data:{product_id:scannerValue},
					type:"POST",
					success:function(req){
						$(".scannerSpan").hide();
						self.next().attr({checked:true});
						$(".scannerInput").val('');
						$(".scannerInput").focus();
					},
					error:function(){
						alert('请求失败');
						$(".scannerInput").val('');
						$(".scannerInput").focus();
					}
				});
			}else{
				i++;
			}
			if (i == $(".hidSid").length){
				$(".scannerSpan").hide();
				alert('运单里没有此商品');
				$(".scannerInput").val('');
				$(".scannerInput").focus();
			}
		});
	}
});
</script>