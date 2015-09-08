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
              <td>国家名称</td>
              <td><input type="text" name="name_cn" value="<?php echo $name_cn; ?>" size="100" /></td>
            </tr>
            <tr>
              <td>英文名称</td>
              <td><input type="text" name="name_en" value="<?php echo $name_en; ?>" size="100" /></td>
            </tr>
            <tr>
              <td>服务费</td>
              <td><input type="text" name="serverfee" value="<?php echo $serverfee; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>服务百分比</td>
              <td><input type="text" name="serverfeepct" value="<?php echo $serverfeepct; ?>" size="10" /></td>
            </tr>
            <tr>
              <td>排序</td>
              <td><input type="text" name="listorder" value="<?php echo $listorder; ?>" size="1" /></td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>