<div id="content">

    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
            <td><?php echo $order_commodity_address; ?></td>
            <td><input type="text" name="order_commodity_address" value="<?php echo $order_info['store_url']; ?>" /></td>
          </tr>	
           <input type="hidden" name="order_id" value="<?php echo $order_info['order_id']; ?>" id="hid">   
          <tr>
            <td><?php echo $order_commodity_name; ?></td>
        <td><input type="text" name="order_commodity_name" value="<?php echo $order_info['name']; ?>" size="20" /></td>
          </tr>
          <tr>
            <td><?php echo $order_commodity_price; ?></td>
        <td><input type="text" name="order_commodity_price" value="<?php echo $order_info['price']; ?>" size="20" /></td>
          </tr>
          <tr>
            <td><?php echo $order_express_price; ?></td>
            <td><input type="text" name="order_express_price" value="<?php echo $order_info['order_shipping']; ?>" size="20" /></td>
           </tr>
          <tr>
            <td><?php echo $order_update_qty; ?></td>
            <td><input type="text" name="order_update_qty" value="<?php echo $order_info['quantity']; ?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $order_update_size; ?></td>
            <td><input type="text" name="order_update_size" value="<?php 
			
			if (isset($order_info['option_size'])) {			
			echo $order_info['option_size'];}
			?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $order_update_color; ?></td>
            <td><input type="text" name="order_update_color" value="<?php 		
				if (isset($order_info['option_color'])) {			
			echo $order_info['option_color']; }
			?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $order_update_seller; ?></td>
            <td><input type="text" name="order_update_seller" value="<?php echo $order_info['store_name']; ?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $seller_address; ?></td>
            <td><input type="text" name="order_cul_home" value="<?php 
			if(isset($order_info['order_cul_home'])){
			echo $order_info['order_cul_home']; 
			}
			?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $express_company; ?></td>
           
		       <td>  <select name="express_change">
               <option value="0"><?php echo $order_express_Select; ?></option>
               <?php foreach ($order_info['order_express'] as $express) { ?>
                  <?php if ($express['id'] == $order_info['express']) { ?>
                  <option value="<?php echo $express['id']; ?>" selected="selected"><?php echo $express['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $express['id']; ?>"><?php echo $express['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
          </tr>
		     <tr>
            <td><?php echo $express_number; ?></td>
            <td><input type="text" name=" " value="<?php
			if (isset($order_info['kuaidi_no'])) {
  echo $order_info['kuaidi_no'];
}		
			?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $order_update_weight; ?></td>
            <td><input type="text" name="weight" value="<?php echo $order_info['weight']; ?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $payment_ID; ?></td>
            <td><input type="text" name="payment_ID" value="<?php echo $payment_ID; ?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $order_update_status; 
	
			?></td>          
		       <td >     
           <select name="order_change" id="express_change">
               <option value="0"><?php echo $order_express_Select; ?></option>		   
               <?php foreach ($order_status_info2 as $order_status_info) {
			   if ($order_status_info['language_id'] ==2){
			   ?>		   
                  <?php if ($order_status_info['order_status_id'] == $order_info['order_status_id']) { ?>
                  <option value="<?php echo $order_status_info['order_status_id']; ?>" selected="selected"><?php echo $order_status_info['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status_info['order_status_id']; ?>"><?php echo $order_status_info['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
				  <?php } ?>
            
              </select></td>		   
          </tr>
		     <tr>
             <td><?php echo $order_update; ?></td>
            <td><input type="text" name="tracking_remark" value="<?php 
			if (isset($order_info['tracking_number'])) {
           echo $order_info['tracking_number'];
                  }
			
		 ?>" size="20" /></td>
          </tr>
		     <tr>
            <td><?php echo $order_update_remark; ?></td>
            <td>
			
			<textarea rows="2" cols="30" name="order_remark">
<?php 

if (isset($order_info['Textarea'])) {
  echo $order_info['Textarea'];
}
?>
</textarea></td>
          </tr>		  
		   </tr>
		     <tr>
          
            <td  colspan=2 style="text-align: center;">&nbsp;&nbsp;<input type="submit" name="button_save" value="<?php echo $button_save; ?>" size="20" />&nbsp;&nbsp;&nbsp&nbsp;&nbsp;<a style="text-decoration:none" href="<?php echo $quxiao;?>" ><input type="button" name="button_save" value="取消" size="20" /><a/></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
