<div id="content">
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list" align="center">
        <thead>
        <input type="hidden" name="updata" value="updata" id="updata">
        <tr>
          <td colspan="2">修改订单所属用户ID:<?php echo $uid ;?>所属用户名:<?php echo $uname;?> 运单ID:<?php echo $sid;?></td>
        </tr>
        <tr>
          <td>快递编号</td>
          <td><input type="text" name="kuaiai_on" value="<?php echo $kuaiai_on; ?>" /></td>
        </tr>
        <input type="hidden" name="yundan_id" value="<?php echo $sid; ?>" id="yundan_id">
        <tr>
          <td>email：</td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>运费</td>
          <td><input type="text" name="freight" value="<?php echo $freight; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>服务费</td>
          <td><input type="text" name="serverfee" value="<?php echo $serverfee; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>报关费</td>
          <td><input type="text" name="customsfee" value="<?php echo $customsfee; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>总费用</td>
          <td><input type="text" name="totalfee" value="<?php echo $totalfee; ?>"></td>
        </tr>
        <tr>
          <td>收件人</td>
          <td><input type="text" name="consignee" value="<?php 		
				if (isset($consignee)) {			
			echo $consignee; }
			?>" size="20" /></td>
        </tr>
        <tr>
          <td>国家</td>
          <td><input type="text" name="country" value="<?php echo $country; ?>"></td>
        </tr>
        <tr>
          <td>城市</td>
          <td><input type="text" name="city" value="<?php 
			if(isset($city)){
			echo $city; 
			}
			?>" size="20" /></td>
        </tr>
        <tr>
          <td>邮编</td>
          <td><input type="text" name="zip" value="<?php echo $zip; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>详细地址</td>
          <td><input type="text" name="address" value="<?php
			if (isset($address)) {
  echo $address;
}		
			?>" size="20" /></td>
        </tr>
        <tr>
          <td>用户评价</td>
          <td><input type="text" name="comment" value="<?php echo $comment; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>回复评价</td>
          <td><input type="text" name="reply" value="<?php echo $reply; ?>" size="20" /></td>
        </tr>
        <tr>
          <td>是否显示</td>
          <td ><select name='showcomment' >
              <?php 
if($showcomment==1){
?>
              <option value='1' selected=selected>是</option>
              <option value='0' >否</option>
              <?php 
}else{
?>
              <option value='1' >是</option>
              <option value='0' selected=selected>否</option>
              <?php
}
?>
            </select></td>
        </tr>
        <tr>
          <td>状态</td>
          <td ><input type="text" name="state" value="<?php

 if($state==1){
 echo "已付款";
 }else if($state==2){
  echo "已邮寄";
 }else if($state==3){
  echo "已确认收货";
 }else if($state==4){
 echo "无效运单";
 }else if($state==5){
  echo "准备邮寄";
 }else if($state==6){
   echo "待补交运费";
 }

			?>" size="20" /></td>
        </tr>
        </tr>
        
        <tr>
          <td  colspan=2 style="text-align: center;">&nbsp;&nbsp;
            <input type="submit" name="button_save" value="保存" size="20" />
            &nbsp;&nbsp;&nbsp&nbsp;&nbsp;<a style="text-decoration:none" href="<?php echo $quxiao;?>" >
            <input type="button" name="button_save" value="取消" size="20" />
            <a/></td>
        </tr>
      </table>
    </form>
  </div>
</div>
</div>
