<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
     <!-- <div class="buttons"><a href="<?php echo $reset; ?>" class="button"><?php echo $button_reset; ?></a></div>-->
    </div>
    <div class="content">
	<table class="form">
        <tbody><tr>
		   <td><?php echo $entry_date_start; ?> <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>  <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
		    <td>用户名 <input type="text" name="username" value="<?php echo $username; ?>" size="6" /></td>
          <td>处理状态： <select name="status" id="status">
                             <option value=''>请选择</option>
                            <option value="0" <?php if($form_status==0){echo "selected='selected'";} ?>>未处理</option>
                            <option value="1" <?php if($form_status==1){echo "selected='selected'";} ?>>已处理</option>
                         </select></td>
          <td>提现方式： <select name="type" id="type">
								<option value=''>请选择</option>
                                <option value="1" <?php if($from_type==1){echo 'selected="selected"';} ?> >支付宝</option>
                                <option value="2" <?php if($from_type==2){echo 'selected="selected"';} ?>>play</option>         
                         </select></td>
          <td style="text-align: right;"><a onclick="filter();" class="button">筛选</a></td>
        </tr>
      </tbody></table>
      <table class="list">
        <thead>
          <tr>
			<td class="center">ID</td>
            <td class="center">用户ID</td>
            <td class="center"><?php echo $uname; ?></td>
            <td class="center"><?php echo $money; ?></td>
			<td class="center"><?php echo $actual_money;?></td>
			<td class="center"><?php echo $type; ?></td>
            <td class="center"><?php echo $serial_no; ?></td>
			<td class="center"><?php echo $addtime; ?></td>
            <td class="center"><?php echo $title_status; ?></td>
			<td class="center"><?php echo $Acceptance_state; ?></td>
			<td class="center"><?php echo $eff_time; ?></td>
			<td class="center"><?php echo $remark; ?></td>
			<td class="center">操作</td>
          </tr>
        </thead>
        <tbody>
          <?php if ($products){ ?>
          <?php foreach ($products as $product) { ?>
          <tr>
		    <td class="center"><?php echo $product['id']; ?></td>
            <td class="center"><?php echo $product['uid']; ?></td>
            <td class="center"><?php echo $product['firstname']; ?></td>
            <td class="center"><?php echo $product['money']; ?></td>
			 <td class="center"><?php echo $product['actual_money']; ?></td>
            <td class="center"><?php if($product['type']==1){echo '支付宝';}else{echo 'play';}?></td>
			<td class="center"><?php echo $product['serial_no']; ?></td>
            <td class="center"><?php echo date('Y-m-d H:i:s',$product['add_time']); ?></td>
            <td class="center"><?php if($product['status']==1){echo '成功';}else{echo '未成功';} ?></td>
           <td class="center"><?php if($product['Acceptance_state']==1){ echo '已受理';}else{echo '未受理';} ?></td>
		   <td class="center"><?php if($product['eff_time'])echo date('Y-m-d H:i:s',$product['eff_time']); ?></td>
		      <td class="center"><?php echo $product['remark']; ?></td>
		   <td class="center"><a href="index.php?route=promotion/tixian_manage/update&token=<?php echo $token;?>&id=<?php echo $product['id'];?>">编辑</a></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="14"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=promotion/tixian_manage&token=<?php echo $token;?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var username = $('input[name=\'username\']').attr('value');
	
	if (username) {
		url += '&username=' + encodeURIComponent(username);
	}
	
	
	
	var status = $("#status option:selected").val();
	
	if (status) {
		url += '&status=' + encodeURIComponent(status);
	}
	var type =$("#type option:selected").val();

	if (type) {
		url += '&type=' + encodeURIComponent(type);
	}
	
	location = url;
}
//--></script> 

<script type="text/javascript">
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
</script> 

<?php echo $footer; ?>