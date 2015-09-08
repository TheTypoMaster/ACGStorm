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
			
		
        <td><?php echo $entry_group; ?>
            <select name="type_group">
			<option value='0'>请选择</option>
			<?php for($i=1;$i<4;$i++){ ?>
			   <option value="<?php echo $i; ?>" <?php if($type==$i){ ?> selected="selected" <?php } ?>><?php echo $type_group[$i]; ?></option>
			<?php } ?>
            </select></td>
			
				
          <td><?php echo $entry_group; ?>
            <select name="filter_group">
			<option value= "0" >请选择</option>
			<?php for($i=1;$i<4;$i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($filter==$i){ ?> selected="selected"<?php } ?>><?php echo $filter_group[$i]; ?></option>
			<?php } ?>
            </select></td>
			
			
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>

      <table class="list">
        <thead>
          <tr>
           
			<?php if($filter == 1){ ?>
			 <td class="center">按天计算</td>
		 	<?php } else if($filter == 2){ ?>
			 <td class="center">按周计算</td>
			<?php }else if($filter == 3){ ?>
			 <td class="center">按月计算</td>
			<?php }else{ ?>
			 <td class="center">开始时间</td>
			  <td class="center">结束时间</td>
			<?php } ?>
		
            <td class="center">总数</td>
         
          </tr>
        </thead>
        <tbody>
         <?php if ($rows){ ?>
		 <?php foreach($rows as $row){ ?>
          <tr>
		  <?php if($filter == 1){ ?>
		  
            <td class="center"><?php echo $row['days']; ?></td>

			<?php } else if($filter == 2){ ?>
			
			  <td class="center"><?php echo $row['weeks']; ?></td>
           
			<?php }else if($filter == 3){ ?>
			
			  <td class="center"><?php echo  $row['months']; ?></td>

			<?php }else{ ?>
			
				<td class="center"><?php echo  $date_start; ?></td>
				
			    <td class="center"><?php echo  $date_end; ?></td>
				
			<?php } ?>
			
            <td class="center"><?php echo $row['total']; ?></td>
			
         </tr>
		 
          <?php }
					} else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=report/order_detail&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var filter_group = $('select[name=\'filter_group\']').attr('value');
	
	if (filter_group) {
		url += '&filter_group=' + encodeURIComponent(filter_group);
	}
	
	var type_group = $('select[name=\'type_group\']').attr('value');
	
	if (type_group != 0) {
		url += '&type_group=' + encodeURIComponent(type_group);
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