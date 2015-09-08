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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <table class="list">
      <tbody>
        <tr class="filter">
          <td><a href="javascript:location.reload();"><img src="/orange/view/image/refresh.gif" alt="刷新" width="28" height="20"></a></td>
          <td>用户名：<input id="filter_uname" value="" /><a onclick="filter();" class="button">筛选</a></td>
        </tr>
    </table>
    //详细内容
    <table class="list">
      <thead>
        <tr>
          <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="center">ID</td>
          <td class="center">类型</td>
          <td class="center">用户名</td>
          <td class="center">充值方式</td>
          <td class="center">消费类型</td>
          <td class="center">币种</td>
          <td class="center">金额</td>
          <td class="center">换算金额</td>
          <td class="center">账户余额</td>
          <td class="center">备注</td>
          <td class="center">付款时间 / 发生时间</td>
          <td class="center">成功时间</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($orders) {	
			 foreach ($orders as $order) {		
			?>
        <tr>
          <td style="text-align: center;"><?php if ($order['selected']) { ?>
            <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="selected[]" value="<?php if(isset($order['order_id']))  echo $order['order_id']; ?>" />
            <?php } ?></td>
          <td class="center"><?php echo $order['rid']; ?></td>
          <td class="center"><?php echo $order['name']; ?></td>
          <td class="center"><?php echo $order['firstname']; ?></td>
          <td class="center"><?php echo $order['payname']; ?></td>
          <td class="center"><?php echo $order['type']; ?></td>
          <td class="center"><?php echo $order['currency']; ?></td>
          <td class="center"><?php echo $order['amount'] ;?></td>
          <td class="center"><?php echo $order['money'] ;?></td>
          <td class="center"><?php echo $order['accountmoney'];?></td>
          <td class="center"><?php echo $order['remark'];?></td>
          <td class="center"><?php echo $order['addtime'];?></td>
          <td class="center"><?php echo $order['successtime'];?></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
</div>
<script type="text/javascript">
function filter(){
url = 'index.php?route=record/rcrecord&token=<?php echo $token; ?>';
var filter_uname = $("#filter_uname").val();
if(filter_uname){
url += '&filter_uname=' + encodeURIComponent(filter_uname);
}
location = url;
}
</script>
<?php echo $footer; ?>