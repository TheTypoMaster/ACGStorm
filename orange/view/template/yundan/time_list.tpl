<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<style type="text/css">
	.outBound, .confirm {width: 18px; height: 18px;}
</style>
<div id="content">
  <div class="content" style="font-family: Microsoft Yahei;">
    <div align="center"><img src="/image/data/logo.png" width="198" height="auto"></div>
    <div align="center" style="line-height: 58px;font-size: 16px;font-weight: bold;">运单<?php echo $order_id ;?>时间清单</div>
    <span class="scannerSpan" style="display:none;">请稍等...</span>
    <form action="<?php if ( isset($action) ) echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table width="100%" border="1" cellpadding="0" cellspacing="0" align="center" >
     
        <tr>
          <td align="center">运单ID</td>
          <td align="center">待付款时间</td>
          <td align="center">已下单时间</td>
          <td align="center">待邮寄时间</td>
          <td align="center">已邮寄时间</td>
          <td align="center">已评价时间</td>
     
        </tr>
     
        <tr>
          <td align="center">&nbsp;<?php echo $order_id ;?></td>
          <td align="center">&nbsp;<?php echo $addtime ;?></td>
          <td align="center">&nbsp;<?php echo $order_time ;?></td>
          <td align="center">&nbsp;<?php echo $ready_send_time ;?></td>
          <td align="center">&nbsp;<?php echo $delivery_time ;?></td>
          <td align="center">&nbsp;<?php echo $commenttime ;?></td>
        </tr>
    
        <tr>
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