<?php echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a id="button-send" onClick="send('index.php?route=sale/contact/send&token=<?php echo $token; ?>');" class="button"><?php echo $button_send; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <table id="mail" class="form">
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
<script type="text/javascript"><!--
$('select[name=\'to\']').bind('change', function() {
$('#mail .to').hide();

$('#mail #to-' + $(this).attr('value').replace('_', '-')).show();
});

$('select[name=\'to\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
_renderMenu: function(ul, items) {
var self = this, currentCategory = '';

$.each(items, function(index, item) {
if (item.category != currentCategory) {
ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');

currentCategory = item.category;
}

self._renderItem(ul, item);
});
}
});

$('input[name=\'customers\']').catcomplete({
delay: 500,
source: function(request, response) {
$.ajax({
url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
dataType: 'json',
success: function(json) {
response($.map(json, function(item) {
return {
category: item.customer_group,
label: item.name,
value: item.customer_id
}
}));
}
});

},
select: function(event, ui) {
$('#customer' + ui.item.value).remove();

$('#customer').append('<div id="customer' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="customer[]" value="' + ui.item.value + '" /></div>');

$('#customer div:odd').attr('class', 'odd');
$('#customer div:even').attr('class', 'even');

return false;
},
focus: function(event, ui) {
return false;
}
});

$('#customer div img').live('click', function() {
$(this).parent().remove();

$('#customer div:odd').attr('class', 'odd');
$('#customer div:even').attr('class', 'even');
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'affiliates\']').autocomplete({
delay: 500,
source: function(request, response) {
$.ajax({
url: 'index.php?route=sale/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
dataType: 'json',
success: function(json) {
response($.map(json, function(item) {
return {
label: item.name,
value: item.affiliate_id
}
}));
}
});

},
select: function(event, ui) {
$('#affiliate' + ui.item.value).remove();

$('#affiliate').append('<div id="affiliate' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="affiliate[]" value="' + ui.item.value + '" /></div>');

$('#affiliate div:odd').attr('class', 'odd');
$('#affiliate div:even').attr('class', 'even');

return false;
},
focus: function(event, ui) {
return false;
}
});

$('#affiliate div img').live('click', function() {
$(this).parent().remove();

$('#affiliate div:odd').attr('class', 'odd');
$('#affiliate div:even').attr('class', 'even');
});

$('input[name=\'products\']').autocomplete({
delay: 500,
source: function(request, response) {
$.ajax({
url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
dataType: 'json',
success: function(json) {
response($.map(json, function(item) {
return {
label: item.name,
value: item.product_id
}
}));
}
});
},
select: function(event, ui) {
$('#product' + ui.item.value).remove();

$('#product').append('<div id="product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="product[]" value="' + ui.item.value + '" /></div>');

$('#product div:odd').attr('class', 'odd');
$('#product div:even').attr('class', 'even');

return false;
},
focus: function(event, ui) {
return false;
}
});

$('#product div img').live('click', function() {
$(this).parent().remove();

$('#product div:odd').attr('class', 'odd');
$('#product div:even').attr('class', 'even');
});

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