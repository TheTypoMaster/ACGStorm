<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $text_buy_type; ?>
            <select name="text_buy_type">
              <?php if(0 == $filter_order_come) { ?>
              <option value="0" selected="selected"><?php echo $text_buy_type_web; ?></option>
              <option value="1"><?php echo $text_buy_type_app; ?></option>
              <?php }else if(1 == $filter_order_come){ ?>
              <option value="0" ><?php echo $text_buy_type_web; ?></option>
              <option value="1" selected="selected"><?php echo $text_buy_type_app; ?></option>
              <?php } ?>
            </select></td>
            <td><?php echo $text_buy_from; ?>
            <select name="text_buy_from">
              <?php if(0 == $filter_source) {  ?>
              <option value="0" selected="selected"><?php echo $text_buy_from_snatch; ?></option>
              <option value="1"><?php echo $text_buy_from_favorite; ?></option>
              <?php }else if(1 == $filter_source){   ?>
              <option value="0"><?php echo $text_buy_from_snatch; ?></option>
              <option value="1" selected="selected"><?php echo $text_buy_from_favorite; ?></option>
              <?php } ?>
            </select></td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_producturl; ?></td>
            <td class="center"><?php echo $column_quantity; ?></td>
            <td class="center"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        
        <tbody>
          <?php if ($products) { ?>
          <?php foreach ($products as $product) { ?>
          <tr> 
            <td class="left"><?php echo $product['name']; ?></td>
            <td class="left"><?php echo $product['producturl']; ?></td>
            <td class="center"><?php echo $product['quantity']; ?></td>
            <td class="center"><?php echo $product['total']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
        
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
    
	url = 'index.php?route=report/product_purchased&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_source = $('select[name=\'text_buy_from\']').attr('value');
	
	if (filter_source != 0) {
		url += '&filter_source=' + encodeURIComponent(filter_source);
	}
    
    var filter_order_come = $('select[name=\'text_buy_type\']').attr('value');
	
	if (filter_order_come != 0) {
		url += '&filter_order_come=' + encodeURIComponent(filter_order_come);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>