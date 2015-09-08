<?php echo $header; ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery.autocomplete.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery.autocomplete.css" rel="stylesheet" />
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> 商户认证申请记录</h1>
    </div>
    <div class="content">
      <table class="list">
      <tbody>
        <tr class="filter">
          <td><a href="javascript:location.reload();"><img src="/orange/view/image/refresh.gif" alt="刷新" width="28" height="20"></a></td>
          <td>用户名：<input autocomplete="off" id="filter_uname" value="" name="filter_order_id"/><a onclick="filter();" class="button">筛选</a></td>
        </tr>
    </table>
    <table class="list">
      <thead>
        <tr>
          <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="center">ID</td>
          <td class="center">商户名</td>
          <td class="center">商家类型</td>
          <td class="center">行业</td>
          <td class="center" width="500">网站 URL</td>
          <td class="center">出售地点</td>
          <td class="center">申请时间</td>
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
            <input type="checkbox" name="selected[]" value="<?php if ( isset($order['order_id']) ) echo $order['order_id']; ?>" />
            <?php } ?></td>
          <td class="center"><?php echo $order['aid']; ?></td>
          <td class="center" id="from"><?php echo $order['uname']; ?></td>
          <td class="center"><?php echo $order['biz_type']; ?></td>
          <td class="center"><?php echo $order['company_industry']; ?></td>
          <td class="center"><?php echo $order['website_url'] ;?></td>
          <td class="left"><?php echo $order['sale_mode'];?></td>
          <td class="center"><?php echo $order['apply_time'];?></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
function filter() {
    url = 'index.php?route=interaction/verification&token=<?php echo $token; ?>';
    var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
    if (filter_order_id) {
        url += '&filter_uname=' + encodeURIComponent(filter_order_id);
    }
    location = url;
}
</script> 
<?php echo $footer; ?> 