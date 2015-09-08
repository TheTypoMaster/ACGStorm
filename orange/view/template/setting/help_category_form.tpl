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
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
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
              <td><?php echo $entry_parent; ?></td>
              <td><input type="text" name="path" value="<?php echo $path; ?>" size="100" />
                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	delay: 500,
	source: function(request, response) {		
		$.ajax({
			url: 'index.php?route=setting/help_category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'category_id':  0,
					'name':  '<?php echo $text_none; ?>'
				});
				
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'path\']').val(ui.item.label);
		$('input[name=\'parent_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<?php echo $footer; ?>