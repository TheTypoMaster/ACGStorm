<?php echo $header; ?>

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
          <td>回复：</td>
          <td><input type="text" name="sendto" id="sendto" value="">运单ID：<input type="text" id="tosid" value="" /></td>
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
          <td>用户名：<input id="filter_uname" value="" /><a onclick="filter();" class="button">筛选</a></td>
        </tr>
    </table>
    //详细内容
    <table class="list">
      <thead>
        <tr>
          <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="center">ID</td>
          <td class="center">发信人</td>   
          <td class="center">类型</td>  
          <td class="center" style='width:50%'>信息</td>
          <td class="center">回复</td>
          <td class="center">状态</td>
          <td class="center">审核</td>
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
            <input type="checkbox" name="selected[]" value="<?php if ( isset($order['order_id']) )  echo $order['order_id']; ?>" />
            <?php } ?></td>
          <td class="center"><?php echo $order['sid']; ?></td>
          <td class="center" id="from"><?php echo $order['fromuname']; ?></td>    
          <td class="center"><?php echo $order['type']; ?></td>
          <td class="left"><?php echo $order['message'];?></td>
          <td class="center"><?php if ($order['reply']){ echo $order['reply'];}?></td>
          <td class="center"><?php if($order['hasview']==1){;?>已读<?php }else{ ?>未读<?php } ?></td>
          <td class="center"><a href="javascript:;" style="text-decoration:none;" id=<?php echo $order['sid']; ?> onclick='showComment(<?php echo $order['sid']; ?>)'><?php if ($order['showcomment']==1){; ?><font color="green">展示</font><?php }else{?><font color="red">隐藏</font><?php }?></a></td>
          <td class="center"><?php echo $order['sendtime'];?></td>
          <td class="center"><a onClick="reply(<?php echo $order['sid'];?>,'<?php echo $order['fromuname']; ?>');">回复</a></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
function showComment(id){
	    $.ajax({
      url:'index.php?route=community/commentshow/showComments&token=<?php echo $token; ?>',
      dataType:"json",
      data:'sid='+id,
      type:"POST",
      success:function(req){
        if(req == 1){
          $("#"+id).html(' ');
          $("#"+id).html('<font color="red">隐藏</font>');
        }else{
           $("#"+id).html(' ');
           $("#"+id).html('<font color="green">展示</font>');      
        }
      },
      error:function(){
        alert('fail request!');
      }
    });

}
function reply(sid,uname) {
    $('#tosid').val(sid);
    $('#sendto').val(uname);
    $('#mail').slideDown();
}
function send() {
    var message = $("#message").val();
    var sid = $("#tosid").val();
    if (!sid) {
        alert("回复哪个运单ID啊!");
    } else if (!message) {
        alert("没有写内容!");
    } else {
       alert("发了！");
    	url = 'index.php?route=community/commentshow&token=<?php echo $token; ?>&reply=yes';
    	url += '&tosid=' + encodeURIComponent(sid) + '&message=' + encodeURIComponent(message);
        location = url;
        
    }

}
</script> 
<?php echo $footer; ?> 
