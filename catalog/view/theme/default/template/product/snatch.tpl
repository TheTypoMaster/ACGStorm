<style type="text/css">
.liselected{ 
				border:2px solid #ff6600 !important; 
                color:#ff6600;
				padding:8px;
                display:inline;
                white-space:nowrap;
                margin-right:3px;
			}
</style>
<?php echo $header; ?>
<div id="content"><?php echo $content_top; ?>
 
  <h1><?php echo $heading_title; ?></h1>
  
  <div class="product-info" >
   
    <div class="left" >
      <?php if ($item_imgs) { ?>
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img height="250px"; width="230px" src="<?php if($item_imgs) echo $item_imgs[0];else echo  $thumb?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
      <?php } ?>
   
    
    
     
      <ul id="spec-list" style="list-style-type:none; padding:0px; width:260px; height:58px; padding-top:2px; overflow:hidden;">
           <?php if($item_imgs){
                  foreach($item_imgs as $item_img)
                  {
           ?>
           <li style="float:left; margin-right:5px; margin-bottom:3px;border:1px solid #ccc;"><img height="50px" width="50px" src="<?php echo $item_img; ?>"/></li>
           <?php
                  }
           }?>  
     </ul>
    </div>

    <div class="right">
     
      <?php if ($price) { ?>
      <div class="cart"><?php echo $text_price; ?>
        <?php if (!$special) { ?>
        <input type="hidden" name="searchprice" size="2" value="<?php echo $price; ?>" />
        <em>¥</em><span id="price" class="price">
        <?php echo $price; ?>
        </span>
        <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><span class="price"><?php echo $special; ?></span></span>
        <?php } ?>
        <br />
        </div>
        <div class="cart"><?php echo  $text_domestic_freight; ?><em>¥</em><span class="price"><?php echo $isbn ?></span><br />
         <input type="hidden" name="searchfreight" size="2" value="<?php echo $isbn; ?>" /> 
        </div>
        <div class="cart"><?php echo  $text_origin_of_goods; ?> <?php echo $model."——————" .$upc?><br />
        </div>
        <div class="cart" style=""><?php echo  $text_colors; ?> 
        <ul id="choose_color" style="list-style-type:none;" >
        <input type="hidden" id="searchcolor" name="searchcolor" size="2" value="<?php echo $searchcolor; ?>" />            
        <?php if($ean) {
        foreach($ean as $signal_ean) {?>
               <a onclick="click_color('<?php  echo str_replace(':','_',(array_keys($color_number,$signal_ean)[0]))?>')" style="color:#000;text-decoration:none;" id="<?php  echo str_replace(':','_',(array_keys($color_number,$signal_ean)[0]))?>"><li  style="border: 1px solid #CCCCCC; margin-right:3px; padding:8px; display:inline; white-space: nowrap;"><?php echo $signal_ean; ?></li></a> 
        <?php } } ?>
        
        <br />
        </ul>
        </div>
        <div class="cart"><?php echo  $text_sizes; ?>
        <ul id="choose_size">
         <input type="hidden" id="searchsize" name="searchsize" size="2" value="<?php echo $searchsize; ?>" /> 
        <?php if($jan){
              foreach($jan as $signal_jan) {?>
               <a onclick="click_size('<?php echo str_replace(':','_',(array_keys($size_number,$signal_jan)[0]))?>')" style="color:#000;text-decoration:none;" id="<?php echo str_replace(':','_',(array_keys($size_number,$signal_jan)[0]))?>"><li  style="border: 1px solid #CCCCCC; display:inline; white-space: nowrap; margin-right:3px;padding:8px; "><?php echo $signal_jan; ?></li></a> 
        <?php } } ?>
        </ul>
        <br />        
        </div>
        <div class="cart"><?php echo  $text_goods_note; ?> <textarea></textarea><br />
        
        
    
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
        <?php } ?>
        <?php if ($discounts) { ?>
        <br />
        <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if ($profiles): ?>
      <div class="option">
          <h2><span class="required">*</span><?php echo $text_payment_profile ?></h2>
          <br />
          <select name="profile_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($profiles as $profile): ?>
              <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
              <?php endforeach; ?>
          </select>
          <br />
          <br />
          <span id="profile-description"></span>
          <br />
          <br />
      </div>
      <?php endif; ?>
      <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
        <br />
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
      
     
      <div class="cart">
        <div><?php echo $text_qty; ?>
          <input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
          <input type="hidden" name="num_iid" size="2" value="<?php echo $num_iid; ?>" />
          <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" />
         
          
        </div>
        <?php if ($minimum > 1) { ?>
        <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
      </div>
     
        </div>
        
      </div>
     
    
    </div>

 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script> 
<script type="text/javascript"><!--
/*
$('select[name="profile_id"], input[name="quantity"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('#profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('#profile-description').html(json['success']);
			}	
		}
	});
});
*/  
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/addsearch',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
                
                if (json['error']['profile']) {
                    $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                }
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>






<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
var color_value = '';
var size_value = '';

function clear_color()
{
   
   $("#choose_color li").each(function(){
        if ($(this).is(".liselected")) 
        $(this).removeClass("liselected");
   });
}

function clear_size()
{
   $("#choose_size li").each(function(){
       if ($(this).hasClass("liselected")) 
          $(this).removeClass("liselected");
        
   });
}

$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});

$(function(){
    $("#spec-list img").bind("mouseover",function(){
			var src=$(this).attr("src");
			$("#image").attr("src", src);
			$(this).css({
				"border":"2px solid #ff6600",
				"padding":"0px"
			});
		}).bind("mouseout",function(){
			$(this).css({
				"border":"1px solid #ccc",
				"padding":"1px"
			});
		});
        
   
    $("#choose_color li").bind("click",function(){
		    clear_color();
            $(this).addClass("liselected");
		})
        
    $("#choose_size li").bind("click",function(){
            clear_size();
            $(this).addClass("liselected");
		})
})

function click_color(select_color)
{
    
     color_value = select_color;
     $('#searchcolor').attr("value",color_value);
     $('#choose_size a').show();
     $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getsizeinfo',
                dataType: "json",
				data: "color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(size in data)
                                             { 
                                                $('#'+ data[size]).hide();
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    alert("系统繁忙，请稍后再试！");			 
				}
         })
    $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getimg',
                dataType: "json",
				data: "color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             
                                             $("#image").attr("src", data);
                                          }
                                          
			                          },

         })
    if(size_value && color_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getcolorsizeinfo',
                dataType: "json",
				data: "size=" +  size_value + "&color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             $('#price').text(data['price']);
                                          }
                                          
			                          },

				error: function(data){				    
                    alert("系统繁忙，请稍后再试！");			 
				}
         })
    }
    
   
   
}

function click_size(select_size)
{
    size_value = select_size;
    $('#searchsize').attr("value",size_value);
    $('#choose_color a').show();
    $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getcolorinfo',
                dataType: "json",
				data: "size=" + size_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(color in data)
                                             { 
                                                
                                                $('#'+ data[color]).hide();
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    alert("系统繁忙，请稍后再试！");			 
				}
         })
    if(size_value && color_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getcolorsizeinfo',
                dataType: "json",
				data: "size=" + size_value  + "&color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                              $('#price').text(data['price']);  
                                          }
                                          
			                          },

				error: function(data){				    
                    alert("系统繁忙，请稍后再试！");			 
				}
        })
    }
}

//--></script> 
<?php echo $footer; ?>