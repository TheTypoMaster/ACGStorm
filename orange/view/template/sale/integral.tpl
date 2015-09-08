<?php echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> 积分管理</h1>
      <div class="buttons"><a id="button-send" onClick="pay()" class="button">发送</a><a href="#" class="button">取消</a></div>
    </div>
    <div class="content">
      <table id="mail" class="form">
        <?php if (isset($result_message)) { ?>
          <tr>
            <td colspan="2"><span style="float:left;color:red"><?php echo $result_message; ?></span></td>
          </tr>
        <?php } ?>
        <tr>
          <td><span class="required">*</span> 用户昵称：</td>
          <td><input type="text" name="receiver" id="receiver" value="">
            <input type="hidden" name="receiver_id" id="receiver_id" value="" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> 增加积分：</td>
          <td><input type="text" id="integral" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;若扣积分，在数字前面加“-”号即可。</td> 
        </tr>
        <tr>
          <td><span class="required">*</span> 备注：</td>
          <td><textarea id="message" cols='30' style="height:70px;"></textarea></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
$('input[name=\'receiver\']').autocomplete({
  delay: 500,
  source: function(request, response) {   
    $.ajax({
      url: 'index.php?route=sale/integral/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        json.unshift({
          'receiver_id':  0,
          'receiver':  ' --- 无 --- '
        });
        
        response($.map(json, function(item) {
          return {
            label: item.receiver,
            value: item.receiver_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('input[name=\'receiver\']').val(ui.item.label);
    $('input[name=\'receiver_id\']').val(ui.item.value);
    
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
</script>
<script>
function pay() {
    var url = "index.php?route=sale/integral&token=<?php echo $token; ?>&pay=yes";
    var receiver = $("#receiver").val();
    var receiver_id = $("#receiver_id").val();
    var integral = $("#integral").val();
    var message = $("#message").val();
    if (!receiver) {
        alert("用户是谁？");
    } else if (!receiver_id) {
        alert("请选择用户！");
    } else if (!integral) {
        alert("增加多少积分没告诉我！");
    } else if (!message) {
        alert("为什么增加积分?写写内容！");
    } else {
        alert("ok!");
        url += "&receiver=" + encodeURIComponent(receiver) + "&receiver_id=" + encodeURIComponent(receiver_id) + "&integral=" + encodeURIComponent(integral) + "&message=" + encodeURIComponent(message); 
        location = url;
    }

}
</script>
<?php echo $footer; ?> 
