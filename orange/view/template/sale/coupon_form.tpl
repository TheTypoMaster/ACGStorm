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
              <td><input type="text" name="uname" value="<?php echo $uname; ?>" size="12" id="uname" /></td>
              
            </tr>
            <tr>
              <td><?php echo $entry_money; ?></td>
              <td><input type="text" name="money" value="<?php echo $money; ?>" size="12" id="money" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_start; ?></td>
              <td><input type="text" name="date_start" value="<?php echo $date_start; ?>" size="12" id="date-start" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_end; ?></td>
              <td><input type="text" name="date_end" value="<?php echo $date_end; ?>" size="12" id="date-end" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if (1 == $status || 2 == $status) { ?>
                  <option value="1" selected="selected">未使用</option>
                  <option value="3">已使用</option>
                  <option value="4">已过期</option>
                  <?php } else if(3 == $status) { ?>
                  <option value="1">未使用</option>
                  <option value="3" selected="selected">已使用</option>
                  <option value="4">已过期</option>
                  <?php } else if(4 == $status) { ?>
                  <option value="1">未使用</option>
                  <option value="3">已使用</option>
                  <option value="4" selected="selected">已过期</option>
                  <?php } else { ?>
                  <option value="1" selected="selected">未使用</option>
                  <option value="3">已使用</option>
                  <option value="4">已过期</option>
                  <?php } ?>
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