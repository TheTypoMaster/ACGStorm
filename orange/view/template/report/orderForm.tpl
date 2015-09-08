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
          <td><?php echo $entry_group; ?>
            <select name="filter_group">
              <?php foreach ($groups as $groups) { ?>
                <?php if ($groups['value'] == $filter_group) { ?>
                  <option value="<?php echo $groups['value']; ?>" selected="selected"><?php echo $groups['year']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $groups['value']; ?>"><?php echo $groups['year']; ?></option>
                <?php } ?>
              <?php } ?>
            </select></td>
          <td style="text-align: left;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left">月份</td>
            <td class="left">当月订单收入</td>
            <td class="left">当月运单收入</td>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalPrice) { ?>
            <?php for($i = 0;$i <= 11;$i ++){ ?>
              <tr>
                <td class="left"><?php echo ($i+1); ?>月份</td>
                <td class="left"><?php if($orderFormsByMonth[$i]['totalPrice']) echo '￥'.number_format($orderFormsByMonth[$i]['totalPrice'],2,".",","); ?></td>
                <td class="left"><?php if($wayBillsByMonth[$i]['totalPrice']) echo '￥'.number_format($wayBillsByMonth[$i]['totalPrice'],2,".",","); ?></td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=report/orderForm&token=<?php echo $token; ?>';
  var filter_group = $('select[name=\'filter_group\']').attr('value');
  if (filter_group) {
    url += '&filter_group=' + encodeURIComponent(filter_group);
  }
  location = url;
}
//--></script> 
<?php echo $footer; ?>