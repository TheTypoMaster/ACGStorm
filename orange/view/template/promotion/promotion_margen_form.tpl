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
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <input type="hidden" name="uid" value="<?php echo $uid;?>"  id = "uid"/>
          <table class="form">
          
             <tr>
              <td><?php echo $entry_uname; ?></td>
              <td><?php echo $uname; ?></td>
              
            </tr>
			
            <tr>
              <td><?php echo $entry_commission_ratio; ?></td>
              <td>
				<select name="commission_ratio" >
					<option value="4" <?php if($commission_ratio==1){echo "selected='selected'";}?> >普通</option>
					<option value="6" <?php if($commission_ratio==2){echo "selected='selected'";}?> >高级</option>
				</select>
			  </td>
            </tr>
			
            <tr>
              <td><?php echo $entry_grade; ?></td>
              <td>	
				<select name="grade" >
					<option value="1" <?php if($grade==4){echo "selected='selected'";}?> >普通</option>
					<option value="2" <?php if($grade==6){echo "selected='selected'";}?> >高级</option>
				</select></td>
            </tr>
			
			
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>
<?php echo $footer; ?>