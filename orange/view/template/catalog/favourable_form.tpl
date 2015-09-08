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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><input type="text" name="name" value="<?php echo $name; ?>" size="90" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><textarea cols="87" rows="8" name="describe"><?php echo $describe; ?></textarea></td>
            </tr>
	    <tr>
              <td><?php echo $entry_link; ?></td>
              <td><input type="text" name="url" value="<?php echo $url; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_source; ?></td>
              <td><input type="text" name="source" value="<?php echo $source; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td valign="top"><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" />
                <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                <br /><a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
			
			<tr>
				<td>折扣类型:</td>
				<td><input type="radio" name="discount_type" value="1" <?php if($discount_type==1){ ?> checked="checked" <?php } ?> />打折&nbsp;&nbsp;&nbsp;<input type="radio" name="discount_type" value="2" <?php if($discount_type==2){ ?> checked="checked" <?php } ?> >满多少减多少</td>
			</tr>
			
			<?php if($discount_type==1){ ?>
			<tr>
				<td>折扣数</td>
				<td id="tag"><input type="text" name="discount" size="1" value="<?php echo $discount; ?>" />&nbsp;&nbsp;折</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td>折扣数</td>
				<td id="tag">满&nbsp;&nbsp;<input type="text" name="max" size="1" value="<?php echo $max;?>" />&nbsp;&nbsp;减&nbsp;&nbsp;<input type="text" value="<?php echo $min;?>"  size="1" name="min"/></td>
			</tr>
		<?php }?>
			<tr>
				<td>开始时间</td>
				<td><input class="Wdate input-text valid" validate=" required:true" name="starttime" type="text" id="starttime" size="25" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'
		})" value="<?php if($starttime){ echo $starttime;  }else{ echo date('Y-m-d H:i:s',time()); } ?>"></td>
			</tr>
				<tr>
				<td>结束时间</td>
				<td><input class="Wdate input-text valid" validate=" required:true" name="endtime" type="text" id="endtime" size="25" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'
		})" value="<?php if($starttime){ echo $endtime;  }else{ echo date('Y-m-d H:i:s',time()); } ?>"></td>
			</tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort" value="<?php echo $sort; ?>" size="1" /></td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
	$('input[name=discount_type]').click(function(){
		var type=$(this).val();
		if(type==1){
			$('#tag').html('<input type="text" name="discount" size="1" />&nbsp;&nbsp;折');
		}else{
			$('#tag').html('满&nbsp;&nbsp;<input type="text" name="max" size="1" />&nbsp;&nbsp;减&nbsp;&nbsp;<input type="text"  size="1" name="min"/>');
		}
	})
</script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 
<?php echo $footer; ?>