<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <input type="hidden" name="id" value="<?php echo $id;?>"  id = "id"/>
		  <input type="hidden" name="uid" value="<?php echo $uid;?>"  id = "uid"/>
          <table class="form">
		  
            <tr>
              <td><?php echo $entry_uname; ?></td>
              <td><?php echo $uname; ?></td>
            </tr>
			
			<tr>
				<td>申请时间</td>
				<td><?php echo date('Y-m-d H:i:s',$add_time);?></td>
			</tr>
			
			<tr>
				<td>提现金额</td>
				<td><?php echo $money;?></td>
			</tr>
			
			<tr>
				<td>提现方式</td>
				<td><?php if($type==1){echo '支付宝';}else{echo 'play';}?></td>
			</tr>
			
			<tr>
				<td>流水号</td>
				<td><input name="serial_no" type="text" value="<?php echo $serial_no;?>"></td>
			</tr>
			
            <tr>
              <td>是否受理</td>
              <td>
				<select name="Acceptance_state" >
					<option value="0" <?php if($Acceptance_state==0){echo "selected='selected'";}?> >未受理</option>
					<option value="1" <?php if($Acceptance_state==1){echo "selected='selected'";}?> >正在处理</option>
					<option value="2" <?php if($Acceptance_state==2){echo "selected='selected'";}?> >处理异常</option>
					<option value="3" <?php if($Acceptance_state==3){echo "selected='selected'";}?> >拒绝处理</option>
				</select>
			  </td>
            </tr>
			
            <tr>
              <td>是否成功</td>
              <td>	
				<select name="status">
					<option value="0" <?php if($status==0){echo "selected='selected'";}?> >未成功</option>
					<option value="1" <?php if($status==1){echo "selected='selected'";}?> >已成功</option>
				</select></td>
            </tr>
			
			 <tr>
              <td>备注</td>
              <td>	<textarea cols="30" name="remark" rows="5"> <?php echo $remark;?></textarea></td>
            </tr>
			
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>
<?php echo $footer; ?>