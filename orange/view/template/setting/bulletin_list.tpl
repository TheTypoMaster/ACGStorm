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
              <td class="left"><?php echo $column_name; ?></td>
              <td class="center"><?php echo $column_color; ?></td>
              <td class="right"><?php echo $column_sort_order; ?></td>
			  <td class="center">是否显示</td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($bulletins) { ?>
            <?php foreach ($bulletins as $bulletin) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($bulletin['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $bulletin['bulletin_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $bulletin['bulletin_id']; ?>" />
                <?php } ?></td>
              <td class="left font" <?php if ($bulletin['color']) echo "style='color:red'"; ?>><?php echo $bulletin['name']; ?></td>
              <?php if (0 == $bulletin['color']){ ?>
              <td class="center"><span data-color="1" onclick="color(this,<?php echo $bulletin['bulletin_id']; ?>)" style="cursor:pointer;padding:3px;">黑字</span></td>
              <?php }else{ ?>
              <td class="center"><span data-color="0" onclick="color(this,<?php echo $bulletin['bulletin_id']; ?>)" style="color:red;cursor:pointer;padding:3px;">红字</span></td>
              <?php } ?>
              <td class="right"><?php echo $bulletin['sort_order']; ?></td>
			  <td class="center"><?php if($bulletin['display']==1){ ?> 显示 <?php }else{ ?> 隐藏 <?php } ?></td>
              <td class="right"><?php foreach ($bulletin['action'] as $action) { ?>
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
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script>
function color(self,id){
	var self = $(self);
	var newColor = 1;
	var fontColor = 'black';
	var html = '黑字';
	var color = self.attr("data-color");
	if (1 == color) {
		newColor = 0;
		fontColor = 'red';
		html = '红字';
	}
	$.ajax({
      url:'index.php?route=setting/bulletin/updateColor&token=<?php echo $token; ?>',
      dataType:"json",
      data:{id:id,color:color},
      type:"POST",
      success:function(data){
      	self.attr("data-color",newColor).css("color",fontColor).html(html);
      	self.parents().siblings(".font").css("color",fontColor);
      },
      error:function(){
        alert('fail request!');
      }
    });
}
</script>
<?php echo $footer; ?>