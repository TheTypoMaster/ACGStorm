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
   <!--   <div class="buttons"><a href="<?php echo $reset; ?>" class="button"><?php echo $button_reset; ?></a></div>-->
    </div>
    <div class="content">
	<table class="form">
        <tbody><tr>
		     <!-- <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>-->
			
          <td style="width:220px">用户名： <input type="text" name="username"  value="<?php echo $username;?>"/> </td>
          <td style="text-align: right;"><a onclick="filter();" class="button">筛选</a></td>
        </tr>
      </tbody></table>
	    <table class="list">
		  <tr>
		    <td class="center">ID</td>
			<td class="center">用户名</td>
            <td class="center">推广员级别</td>
            <td class="center">注册时间</td>
            <td class="center">最后登录时间</td>
			<td class="center">IP</td>
            <td class="center">消费金额</td>
          </tr>
		  <?php if($PromotionPerson){ ?>
		  <tr>
				<td class="center"><?php echo $PromotionPerson['customer_id']; ?></td>
				<td class="center"><?php echo $PromotionPerson['firstname']; ?></td>
				<td class="center"><?php if($PromotionPerson['grade']==1){echo '普通';}else{echo '高级';} ?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$PromotionPerson['regtime']); ?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$PromotionPerson['logintime']);?> </td>
				<td class="center"><?php echo $PromotionPerson['ip'];?></td>
				<td class="center"><?php if($PromotionPerson['totalfee']){echo $PromotionPerson['totalfee'];}else{echo 0;} ?></td>
		   </tr> 
		   <?php }else { ?>
		   <td class="center" colspan="7">没有数据</td>
		   <?php } ?>
	  </table>
      <table class="list">
        <thead>
          <tr>
            <td class="center"><?php echo $id; ?></td>
            <td class="center"><?php echo $uname; ?></td>
			<td class="center">Email</td>
			<td class="center">推广员级别</td>
            <td class="center"><?php echo $add_time; ?></td>
			<td class="center">IP</td>
			<td class="center"> 商品消费</td>
			<td class="center">国际运单消费</td>
            <td class="center">佣金贡献</td>
			<td class="center">操作</td>
          </tr>
        </thead>
        <tbody>
          <?php if ($chid){ ?>
          <?php foreach ($chid as $v) { ?>
          <tr>
            <td class="center"><?php echo $v['customer_id']; ?></td>
            <td class="center"><?php echo $v['firstname']; ?></td>
			<td class="center"><?php echo $v['email']; ?></td>
			<td class="center"><?php if($v['grade']==2){echo '高级';}else{echo '普通';} ?></td>	
            <td class="center"><?php if($v['addtime']){echo date('Y-m-d H:i:s',$v['addtime']);}else{echo '无';} ?></td>
			<td class="center"><?php echo $v['ip']; ?></td>
			<td class="center"> <?php echo $v['ordertotal'];?></td>
            <td class="center"><?php echo $v['allTotalFee'];?></td>
			<td class="center"><?php echo $v['yongjin']; ?></td>
			<td class="center"><a href="javascript:void(0);" onclick="remove_child(this,<?php echo $v['customer_id']; ?>,<?php echo $v['pid']; ?>)">解除</a></td>
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
<script>
	function remove_child(obj,c_id,p_id){
	if(c_id){
			if(confirm('解除后不可恢复,是否解除?')){
				$.ajax({
					url:'index.php?route=promotion/friends_manage/remove_child&token=<?php echo $token;?>',
					data:{c_id:c_id,p_id:p_id},
					type:'post',
					dataType:'json',
					success:function(msg){
						if(msg== true){
							$(obj).parent().parent().remove();
						}else{
							alert('操作失败,请稍候在试');
						}
					}
				})
			}
		}
	}
</script>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=promotion/friends_manage&token=<?php echo $token;?>';
	
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
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>