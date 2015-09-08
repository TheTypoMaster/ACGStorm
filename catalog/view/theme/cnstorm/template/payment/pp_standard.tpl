<form  target="_blank" action="<?php echo $action; ?>" method="post">
  <input type="hidden" name="cmd" value="_xclick" />
  <input type="hidden" name="business" value="<?php echo $business; ?>" />
  <input type="hidden" name="currency_code" value="USD" />
  <input type="hidden" name="email" value="<?php echo $email; ?>" />
  <input type="hidden" name="rm" value="2" />
  <input type="hidden" name="charset" value="utf-8" />
  <input type="hidden" name="return" value="<?php echo $return; ?>" />
  <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>" />
  <input type="hidden" id="amount" name="amount" value="<?php echo $amount; ?>" />
  <input type="hidden" id="item_name" name="item_name" value="<?php echo $item_name ; ?>" />
  <input type="hidden" name="custom" value="<?php echo $custom; ?>" />
  <div class="buttons">
    <div class="right">
      <input type="submit" value="立即前往支付" class="button" />
    </div>
  </div>
</form>
