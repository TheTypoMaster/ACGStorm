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
    <div class="heading">
      <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">快递名称</td>
              <td class="left">关联地区</td>
              <td class="left">快递时间</td>
              <td class="left">首重</td>
              <td class="left">首重费</td>
              <td class="left">续重</td>
              <td class="left">续重费</td>
              <td class="left">燃油</td>
              <td class="left">报关费</td>
              <td class="left">服务费</td>
              <td class="left">发布时间</td>
              <td class="left">快递图片</td>
              <td class="right">操作</td>
            </tr>
          </thead>
          <tbody>
            <?php if ($deliveries) { ?>
            <?php foreach ($deliveries as $delivery) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($delivery['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $delivery['did']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $delivery['did']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $delivery['deliveryname']; ?></td>
              <td class="left"><?php echo $delivery['areaname']; ?></td>
              <td class="left"><?php echo $delivery['delivery_time']; ?></td>
              <td class="left"><?php echo $delivery['first_weight']; ?></td>
              <td class="left"><?php echo $delivery['first_fee']; ?></td>
              <td class="left"><?php echo $delivery['continue_weight']; ?></td>
              <td class="left"><?php echo $delivery['continue_fee']; ?></td>
              <td class="left"><?php echo $delivery['fuel_fee']; ?></td>
              <td class="left"><?php echo $delivery['customs_fee']; ?></td>
              <td class="left"><?php echo $delivery['serverfee']; ?></td>
              <td class="left"><?php echo $delivery['senddate']; ?></td>
              <td class="left"><img src="<?php if (strpos($delivery['deliveryimg'],'ttp://')) echo $delivery['deliveryimg']; else echo '/'.$delivery['deliveryimg'] ?>"></td>
              <td class="right"><?php foreach ($delivery['action'] as $action) { ?>
                <?php if($delivery['shield']) { ?>
                [  <a id="shield_<?php echo $delivery['did'];?>" onclick="updateshield('<?php echo $delivery['did']; ?>');" style='color:green;'>屏蔽</a> ]
                <?php }else{ ?>
                [  <a id="shield_<?php echo $delivery['did'];?>" onclick="updateshield('<?php echo $delivery['did']; ?>');" style='color:red;'>显示</a>   ]
                <?php } ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="13"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
function updateshield(did) {
    var content = $("#shield_" + did).html();
    $.ajax({
        url: 'index.php?route=setting/maintain_delivery/shield&token=<?php echo $token;?>',
        type: 'post',
        data: 'did=' + did,
        dataType: 'json',
        success: function(json) {
            if (json) {
               if('屏蔽' == content) {
                  $("#shield_" + did).html('显示');
                  $("#shield_" + did).css('color','red');
               } else if('显示' == content) {
                  $("#shield_" + did).html('屏蔽');
                  $("#shield_" + did).css('color','green');
               } else {
                  window.location.href = reload();
               }
            }
        }
    });
}
</script>