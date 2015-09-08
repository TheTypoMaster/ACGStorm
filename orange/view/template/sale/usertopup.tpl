<?php echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> 转账充值</h1>
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
          <td><span class="required">*</span> 充值类别：</td>
          <td><select id="type">
              <option value="2">充值</option>
              <option value="1">扣款</option>
            </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> 收款人：</td>
          <td><input type="text" name="receiver" id="receiver" value="">
            <input type="hidden" name="receiver_id" id="receiver_id" value="" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> 充值金额：</td>
          <td><input type="text" id="money" value=""></td> 
        </tr>
        <tr>
          <td><span class="required">*</span> 充值备注：</td>
          <td><textarea id="message"></textarea></td>
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
      url: 'index.php?route=sale/usertopup/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
    var url = "index.php?route=sale/usertopup&token=<?php echo $token; ?>&pay=yes";
    var type = $("#type").val();
    var receiver = $("#receiver").val();
    var receiver_id = $("#receiver_id").val();
    var money = $("#money").val();
    var message = $("#message").val();
    if (!receiver) {
        alert("收款人是谁？");
    } else if (!receiver_id) {
        alert("请选择收款人！");
    } else if (!money) {
        alert("充多少钱没告诉我！");
    } else if (!message) {
        alert("充的是什么?写写内容！");
    } else {
        alert("ok!");
        url += "&type=" + encodeURIComponent(type) + "&receiver=" + encodeURIComponent(receiver) + "&receiver_id=" + encodeURIComponent(receiver_id) + "&money=" + encodeURIComponent(money) + "&message=" + encodeURIComponent(message); 
        location = url;
    }

}
</script>
<?php echo $footer; ?> 
