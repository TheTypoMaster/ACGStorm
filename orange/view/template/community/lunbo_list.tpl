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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">晒尔轮播图名称</td>
              <td class="left">晒尔轮播图链接</td>
              <td class="left">排序</td>
              <td class="left">操作</td>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($lunbos)) { ?>
            <?php foreach ($lunbos as $lunbo) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($lunbo['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $lunbo['lunbo_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $lunbo['lunbo_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $lunbo['name']; ?></td>
              <td class="left"><?php echo $lunbo['url']; ?></td>
              <td class="left"><?php echo $lunbo['sort_order']; ?></td>
              <td class="left"><?php foreach ($lunbo['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
    </div>
    
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title1; ?></h1>
      <div class="buttons"><a href="<?php echo $insert1; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form1').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete1; ?>" method="post" enctype="multipart/form-data" id="form1">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">推荐购轮播图名称</td>
              <td class="left">推荐购轮播图链接</td>
              <td class="left">排序</td>
              <td class="left">操作</td>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($lunbos1)) { ?>
            <?php foreach ($lunbos1 as $lunbo) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($lunbo['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $lunbo['lunbo_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $lunbo['lunbo_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $lunbo['name']; ?></td>
              <td class="left"><?php echo $lunbo['url']; ?></td>
              <td class="left"><?php echo $lunbo['sort_order']; ?></td>
              <td class="left"><?php foreach ($lunbo['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
    </div>
    
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title2; ?></h1>
      <div class="buttons"><?php if($flag){ ?><a href="<?php echo $insert2; ?>" class="button"><?php echo $button_insert; ?></a><?php } ?><a onclick="$('#form2').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete2; ?>" method="post" enctype="multipart/form-data" id="form2">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">推荐购轮播右侧图名称</td>
              <td class="left">推荐购轮播右侧图链接</td>
	      <td class="left">商品价格</td>
              <td class="left">排序</td>
              <td class="left">操作</td>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($lunbos2)) { ?>
            <?php foreach ($lunbos2 as $lunbo) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($lunbo['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $lunbo['lunbo_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $lunbo['lunbo_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $lunbo['name']; ?></td>
              <td class="left"><?php echo $lunbo['url']; ?></td>
	      <td class="left"><?php echo $lunbo['price']; ?></td>
              <td class="left"><?php echo $lunbo['sort_order']; ?></td>
              <td class="left"><?php foreach ($lunbo['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>&type=2"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
    </div>
    
  </div>
</div>
<?php echo $footer; ?>