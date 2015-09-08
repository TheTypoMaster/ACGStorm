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
      <h1><a href="<?php echo $reload; ?>"><img src="view/image/customer.png" alt="优惠卷" /> <?php echo $heading_title; ?></a></h1>
      <div class="buttons">
      <span>用户名：<input id="filter_uname" value="<?php echo $filter_uname; ?>" /><a onclick="filter()" class="button">筛选</a></span>
      <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
      <a onclick="document.getElementById('form').submit();" class="button"><?php echo $button_delete; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">        
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'cd.coupon_id') { ?>
                <a href="<?php echo $sort_coupon_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_coupon_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_coupon_id; ?>"><?php echo $column_coupon_id; ?></a>
                <?php } ?></td>   
              <td class="left"><?php if ($sort == 'cd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>  
              <td class="left"><?php if ($sort == 'c.discount') { ?>
                <a href="<?php echo $sort_discount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_discount; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_discount; ?>"><?php echo $column_discount; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.date_start') { ?>
                <a href="<?php echo $sort_date_start; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_start; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_start; ?>"><?php echo $column_date_start; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.date_end') { ?>
                <a href="<?php echo $sort_date_end; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_end; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_end; ?>"><?php echo $column_date_end; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($coupons) { ?>
            <?php foreach ($coupons as $coupon) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($coupon['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $coupon['coupon_id']; ?></td> 
              <td class="left"><?php echo $coupon['name']; ?></td> 
              <td class="left"><?php echo $coupon['discount']; ?></td>
              <td class="left"><?php echo $coupon['date_start']; ?></td>
              <td class="left"><?php echo $coupon['date_end']; ?></td>
              <td class="left">
              <?php if(1 == $coupon['status'] || 2 == $coupon['status']) { ?>
              未使用
              <?php }else if(3 == $coupon['status']){ ?>
              已使用
              <?php }else if(4 == $coupon['status']){?>
              已过期
              <?php } ?>
              </td>
              <td class="right"><?php foreach ($coupon['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
function filter(){
       
        url = 'index.php?route=sale/coupon&token=<?php echo $token; ?>';
        var filter_uname = $("#filter_uname").val();
        if(filter_uname){
           url += '&filter_uname=' + encodeURIComponent(filter_uname);
        }
    location = url;
}
</script>
<?php echo $footer; ?>