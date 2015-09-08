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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_name; ?></td>
              <td><input type="text" name="name" value="<?php echo $name; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_type; ?></td>
              <td>
                <input type="radio" name="type" value="0" <?php if (!$type || 0==$type) echo("checked='checked'"); ?> />
                <?php echo $text_default; ?>
                <input type="radio" name="type" value="1" <?php if ($type && 1==$type) echo("checked='checked'"); ?> />
                <?php echo $text_social; ?>
                <input type="radio" name="type" value="2" <?php if ($type && 2==$type) echo("checked='checked'"); ?> />
                <?php echo $text_down; ?>
                <input type="radio" name="type" value="3" <?php if ($type && 3==$type) echo("checked='checked'"); ?> />
                <?php echo $text_both; ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_description; ?></td>
              <td width="86%"><textarea name="content" id="description"><?php echo isset($content) ? $content : ''; ?></textarea></td>
              <!-- <td>
                <script id="container" name="content" type="text/plain">
                  这里写你的初始化内容
                </script>
              </td> -->
			  
            </tr>
			<tr>
				<td>是否显示</td>
				<td><select name="display">
					<option value="1" <?php if($display==1){ ?> selected="selected" <?php } ?>> 显示</option>
					<option value="0" <?php if($display==0){ ?> selected="selected" <?php } ?>> 隐藏 </option>
					</select></td>
			</tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="../system/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="../system/ueditor/ueditor.all.min.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('description', {
      initialFrameHeight: 520, 
      toolbars: [
        ['fullscreen', 'source', '|', 'undo', 'redo', '|',
          'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
          'rowspacingtop', 'rowspacingbottom', 'lineheight'],
        ['customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
          'directionalityltr', 'directionalityrtl', 'indent', '|',
          'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
          'link', 'unlink'],
        ['imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
          'simpleupload', 'insertimage', 'emotion', 'scrawl', 'map', 'gmap', 'insertcode', 'pagebreak', 'template', 'background', '|',
          'horizontal', 'date', 'time', 'spechars'],
        ['inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
          'print', 'preview', 'searchreplace', 'help', 'drafts']
      ],
      iframeUrlMap: {
        'link':'~/php/controller.php?action=link',
        'insertimage':'~/php/controller.php?action=image',
        'emotion':'~/php/controller.php?action=emotion',
        'scrawl':'~/php/controller.php?action=scrawl',
        'map':'~/php/controller.php?action=map',
        'gmap':'~/php/controller.php?action=gmap',
        'template':'~/php/controller.php?action=template',
        'background':'~/php/controller.php?action=background',
        'spechars':'~/php/controller.php?action=spechars',
        'snapscreen':'~/php/controller.php?action=snapscreen',
        'searchreplace':'~/php/controller.php?action=searchreplace',
        'help':'~/php/controller.php?action=help'
      }
    });
</script>
<!-- <script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('description', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
</script> -->
<?php echo $footer; ?>