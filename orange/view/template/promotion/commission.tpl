<?php echo $header; ?>
<script src="/catalog/view/javascript/jquery/DatePicker/WdatePicker.js"></script>

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
    <!--  <div class="buttons"><a href="<?php echo $reset; ?>" class="button"><?php echo $button_reset; ?></a></div>-->
    </div>
    <div class="content">
	<table class="form">
        <tbody><tr>
		    <td style="width:250px">开始日期： <input validate=" required:true" name="filter_date_start1" type="text" onfocus="WdatePicker({onpicking:function(dp){call(dp.cal.getNewDateStr(),'filter_date_start1')}})" value="<?php echo $filter_date_start;?>"> </td>
          <td>结束日期：<input  validate=" required:true" name="filter_date_end1" type="text"  onfocus="WdatePicker({onpicking:function(dp){call(dp.cal.getNewDateStr(),'filter_date_end1')}})" value="<?php echo $filter_date_end;?>" >
</td>
		  
				<input type="hidden" name="filter_date_start">
				<input type="hidden" name="filter_date_end">

          <td>用户名： <input type="text" name="username"  value="<?php echo $username;?>"/> </td>
        
          <td style="text-align: right;"><a onclick="filter();" class="button">筛选</a></td>
        </tr>
      </tbody></table>
      <table class="list">
        <thead>
          <tr>
            <td class="center"><?php echo $id; ?></td>
            <td class="center"><?php echo $uname; ?></td>
			<td class="center">注册时间</td>
            <td class="center">最后消费时间</td>
            <td class="center"><?php echo $yjgx; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($products){ ?>
          <?php foreach ($products as $product) { ?>
          <tr>
            <td class="center"><?php echo $product['customer_id']; ?></td>
            <td class="center"><?php echo $product['firstname']; ?></td>
			<td class="center"><?php if($product['regtime']){ echo date('Y-m-d H:i:s',$product['regtime']);}else{echo '';}?></td>
            <td class="center"><?php if($product['confirm_receipt_time']){ echo date('Y-m-d H:i:s',$product['confirm_receipt_time']);}else{echo ''; } ?></td>
			<td class="center"><?php echo $product['yongjin']; ?></td>
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

function call(dp,who){
					if(who=='filter_date_end1'){
						$('input[name=filter_date_end]').val(dp);
					}else{
						$('input[name=filter_date_start]').val(dp);
					}
	}

function filter() {
	url = 'index.php?route=promotion/commission&token=<?php echo $token;?>';
	
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