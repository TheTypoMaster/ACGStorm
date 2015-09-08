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
      <h1><img src="view/image/mail.png" alt="" /> 业务信息</h1>
      <div class="buttons"><a id="button-send" onClick="send();" class="button">发送</a><a onClick="$('#mail').slideUp();" class="button">取消</a></div>
    </div>
    <div class="content">
    <form action="">
      <table id="mail" class="form" style="display:none;">
        <tr>
          <td>来自于：</td>
          <td><input id="manager" disabled="disabled" value="<?php echo $manager; ?>" /></td>
        </tr>
        <tr>
          <td>发往</td>
          <td><input type="text" name="sendto" id="sendto" value=""><input type="hidden" id="touid" value="" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> 回复主题</td>
          <td><input type="text" name="subject" id="subject" value="" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> 回复内容</td>
          <td><textarea name="message" id="message"></textarea></td>
        </tr>
      </table>
      </form>
      <table class="list">
      <tbody>
        <tr class="filter">
          <td><a href="javascript:location.reload();"><img src="/orange/view/image/refresh.gif" alt="刷新" width="28" height="20"></a></td>
          <td>用户名：<input autocomplete="off" id="filter_uname" value="" name="filter_order_id"/><a onclick="filter();" class="button">筛选</a></td>
        </tr>
    </table>
    //详细内容
    <table class="list">
      <thead>
        <tr>
          <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="center">ID</td>
          <td class="center">发信人</td>
          <td class="center">收信人</td>
          <td class="center">类型</td>
          <td class="center">标题</td>
          <td class="center" width="500">信息</td>
          <td class="center">状态</td>
          <td class="center">发送时间</td>
          <td class="center">操作</td>
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
          <td class="center"><?php echo $order['mid']; ?></td>
          <td class="center" id="from"><?php echo $order['fromuname']; ?></td>
          <td class="center"><?php echo $order['touname']; ?></td>
          <td class="center"><?php echo $order['type']; ?></td>
          <td class="center"><?php echo $order['subject'] ;?></td>
          <td class="left"><?php echo $order['message'];?></td>
          <td class="center"><?php if($order['hasview']==1){;?>已读<?php }else{ ?>未读<?php } ?></td>
          <td class="center"><?php echo $order['sendtime'];?></td>
          <td class="center"><a onClick="reply(<?php echo $order['mid']; ?>,'<?php echo $order['fromuname']; ?>',<?php echo $order['fromuid']; ?>);">回复</a></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">

function reply(mid, from, uid) {
    $("#touid").val(uid);
    $("#sendto").val(from);
    $("#subject").val("回复站内信ID：" + mid);
    $("#mail").slideDown();
}
function send() {
    var manager = $("#manager").val();
    var receiver = $("#sendto").val();
    var title = $("#subject").val();
    var message = $("#message").val();
    var uid = $("#touid").val();

    if (!receiver) {
        alert("收件人为空!");
    } else if (!title) {
        alert("标题为空!");
    } else if (!message) {
        alert("没有写内容!");
    } else {
       alert("发了！");
    	url = 'index.php?route=interaction/interaction&token=<?php echo $token; ?>&reply=yes';
    	url += '&fromuname=' + encodeURIComponent(manager) + '&touid=' + encodeURIComponent(uid) + '&touname=' + encodeURIComponent(receiver) + '&subject=' + encodeURIComponent(title) + '&message=' + encodeURIComponent(message);
        location = url;
        
    }

}
function filter() {
    url = 'index.php?route=interaction/interaction&token=<?php echo $token; ?>';
    var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
    if (filter_order_id) {
        url += '&filter_uname=' + encodeURIComponent(filter_order_id);
    }
    location = url;
}
$(function() {
$("#filter_uname").autocomplete("index.php?route=interaction/interaction/autocomplete&token=<?php echo $token; ?>", {
	minChars: 1,
	max: 25,
	autoFill: false,
	mustMatch: true,
	matchContains: false,
	scrollHeight: 550,
	cacheLength: 25,
	formatItem: function(data, i, total) {
		return data[0];
	}
});
});
</script> 
<?php echo $footer; ?> 