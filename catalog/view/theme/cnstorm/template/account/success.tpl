<?php echo $header;?>
<div class="login_bg">
   <div class="register wrap">
      <div class="reg_cont">  
         <div class="reg_success">
             <p class="congrats">恭喜！您已注册成功</p>
             <span class="email_check">您已成功获得<em>200</em>积分！</span>             
             <a class="check_btn" href="<?php if(isset($favorite))  echo $favorite;?>">立即购物</a>
             <span class="email_check">您可以：<a href="<?php if(isset($edit)) echo $edit;?>">前往个人资料</a>，继续完善个人资料，获得更多积分。</span>
         </div>          
         <span class="reg_bott_bg"></span>
      </div>

   </div>
</div>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 946735443;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "QT7uCPyflVwQ05K4wwM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/946735443/?label=QT7uCPyflVwQ05K4wwM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php echo $footer ;?>
<script type="text/javascript">
var _mvq = window._mvq || [];window._mvq = _mvq;
_mvq.push(['$setAccount', 'm-92402-0']);

_mvq.push(['$setGeneral', 'registered', '', /*用户名*/ '<?php echo $customer_name;?>', /*用户id*/ '<?php echo $customer_id;?>']);
_mvq.push(['$logConversion']);
</script>