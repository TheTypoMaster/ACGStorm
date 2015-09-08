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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-data">
          <table class="form">
            <tr>
              <td>快递名称</td>
              <td><input type="text" name="deliveryname" value="<?php echo $deliveryname; ?>" size="100" /></td>
            </tr>
            <tr>
              <td>关联地区</td>
              <td>
                <select name="area">
                  <?php foreach($areas as $area) { ?>
                    <option value="<?php echo $area['aid'];?>,<?php echo $area['name_cn'];?>"><?php echo $area['name_cn'];?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>快递时间</td>
              <td><input type="text" name="delivery_time" value="<?php echo $delivery_time; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>首重</td>
              <td><input type="text" name="first_weight" value="<?php echo $first_weight; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>首重费</td>
              <td><input type="text" name="first_fee" value="<?php echo $first_fee; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>续重</td>
              <td><input type="text" name="continue_weight" value="<?php echo $continue_weight; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>续重费</td>
              <td><input type="text" name="continue_fee" value="<?php echo $continue_fee; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>燃油</td>
              <td><input type="text" name="fuel_fee" value="<?php echo $fuel_fee; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>报关费</td>
              <td><input type="text" name="customs_fee" value="<?php echo $customs_fee; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>服务费</td>
              <td><input type="text" name="serverfee" value="<?php echo $serverfee; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>查询地址</td>
              <td><input type="text" name="queryurl" value="<?php echo $queryurl; ?>" size="100" /></td>
            </tr>
            <tr>
              <td>快递Logo</td>
              <td><input type="text" name="carrierLogo" value="<?php echo $carrierLogo; ?>" size="50" />&nbsp;&nbsp;<img src="<?php echo $carrierLogo; ?>" style="vertical-align:top;position:relative;"><label style="color:blue;">&nbsp;&nbsp;&nbsp;&nbsp;若【快递Logo】跟【快递图片】是同一张图片，则可只填写其中一个。</label></td>
            </tr>
            <tr>
              <td><span class="required"></span> 描述</td>
              <td><textarea name="carrierDesc" cols='50' style="height:90px;"><?php echo $carrierDesc; ?></textarea></td>
            </tr>
            <tr>
              <td>快递图片</td>
              <td><input type="text" name="deliveryimg" value="<?php echo $deliveryimg; ?>" size="50" />&nbsp;&nbsp;<img src="<?php echo $deliveryimg; ?>" style="vertical-align:top;position:relative;"></td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
$(function(){
  $("option[value='<?php echo $selectedValue; ?>']").attr('selected','selected');

  $('input[name=carrierLogo]').change(function(){
    $(this).parent().find('img').attr('src',$(this).val());
  });

  $('input[name=deliveryimg]').change(function(){
    $(this).parent().find('img').attr('src',$(this).val());
  });
});
</script>
<?php echo $footer; ?>