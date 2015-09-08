<?php echo $header; ?>
<style>
	.hiden{display:none}
	.center{text-align:center}
	.top150{margin-top:150px}
</style>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
	<input type="hidden" name="token" value="<?php echo $token;?>">
  </div>

  
  <div class="box hiden1" >
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> 催款邮件通知</h1>
      <div class="buttons"><a id="button-send" onClick="send('index.php?route=sale/reminder_email/sendEmail&token=<?php echo $token; ?>');" class="button"><?php echo $button_send; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <table id="mail" class="form">
	  <tr>
		<td>请输入用户名：</td>
		<td><input type="text" name="user" value="">&nbsp;&nbsp;<input type="button" value="确定" onclick="checkUser()"></td>
	  </tr>
        <tr>
          <td><?php echo $entry_store; ?></td>
          <td><select name="store_id">
              <!-- option value="0"><?php echo $text_default; ?></option -->
              <option value="notice">发送提示</option>
              <?php foreach ($stores as $store) { ?>
              <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_to; ?></td>
          <td><input type="text" name="order_email" value="<?php if(isset($email)){echo $email;} ?>"></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_subject; ?></td>
          <td><input type="text" name="subject" value="<?php if(isset($title)){echo $title;}?>" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_message; ?></td>
          <td><textarea name="message"></textarea></td>
		  
        </tr>
		<tr>
			<td colspan="2" id="test"></td>
		</tr>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('message', {
filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 

<script>
	function checkUser(){
		var user=$.trim($('input[name=user]').val());
		var token=$('input[name=token]').val();
		if(user==""){
			alert('请输入用户名');
			return false;
		}
		$.ajax({
			url:'/orange/index.php?route=sale/reminder_email&token='+token,
			data:'token='+token+'&user='+user,
			dataType:'json',
			type:'POST',
			success:function(data){
				if(data!=0){
						CKEDITOR.instances.message.setData(data.content);
						$('input[name=order_email]').val(data.email);
						$('input[name=subject]').val(data.subject);
					//$('#test').html(data);
				}else{
					alert('没有该用户或没有待付款订单');
				}
			}
		})
	}

		function send(url) {
			$('textarea[name="message"]').val(CKEDITOR.instances.message.getData());
				$.ajax({
					url: url,
					type: 'post',
					data: $('select, input, textarea'),
					dataType: 'json',
					beforeSend: function() {
					$('#button-send').attr('disabled', true);
					$('#button-send').before('<span class="wait"><img src="view/image/loading.gif" alt="" />&nbsp;</span>');
					},
					complete: function() {
					$('#button-send').attr('disabled', false);
					$('.wait').remove();
					},
					success: function(json) {
						$('.success, .warning, .error').remove();

						if (json['error']) {
							if (json['error']['warning']) {
							$('.box').before('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');

							$('.warning').fadeIn('slow');
							}

							if (json['error']['subject']) {
							$('input[name=\'subject\']').after('<span class="error">' + json['error']['subject'] + '</span>');
							}

							if (json['error']['message']) {
							$('textarea[name=\'message\']').parent().append('<span class="error">' + json['error']['message'] + '</span>');
							}
						}

					if (json['next']) {
							if (json['success']) {
									$('.box').before('<div class="success">' + json['success'] + '</div>');

									send(json['next']);
							}
						} else {
							if (json['success']) {
								$('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');

								$('.success').fadeIn('slow');
							}
						}
					}
	});
}
//--></script> 
<?php echo $footer; ?> 