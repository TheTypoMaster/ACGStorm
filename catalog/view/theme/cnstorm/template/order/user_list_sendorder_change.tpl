<div class="de_title">
  <span>运输方式</span>
  <span>待补差价(￥)</span>
</div> 
<input type="hidden" name="sid" id="sid" value="<?php echo $sid;?>">
<?php if($delivery_info) { 
      foreach ($delivery_info as $delivery) { ?>

<?php if($sendorder_did == $delivery['did']){ ?>
<div class="de_content de_content_selected">
<?php }else{ ?>
<div class="de_content">
<?php } ?>
  <div class="de_name">
  <?php if($sendorder_did == $delivery['did']){ ?>
  <input type="radio" name="did" id="did" checked="checked"   value="<?php echo $delivery['did'];?>">
  <?php }else{ ?>
  <input type="radio" name="did" id="did" value="<?php echo $delivery['did'];?>">
  <?php } ?>
  <input type="hidden" id="<?php echo "de_difference_".$delivery['did'];?>" value="<?php echo $delivery['difference'];?>">
  <label>
    <img src="<?php echo $delivery['deliveryimg'];?>">
    <span><?php echo mb_substr($delivery['deliveryname'],0,6);?></span>
  </label>
  </div>
  <div class="de_difference">
    <span><?php echo $delivery['difference'];?></span>
  </div>
</div> 
<?php }} ?>
<input class="de_submit" type="button" name="de_submit" value="提交">
<input class="de_cancel" type="button" name="de_cancel" value="取消">
