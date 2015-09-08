<div class="alert" style="
    background-color: #4DB1CA;
    margin: 3px 0;
">
            <div class="more-nav-list first" style="
    width: 990px;  
    margin: 0 auto;
    line-height: 30px;
    color: #fff;  font-size: 14px;  font-weight: bold;
"><?php echo $text_perfectExperience; ?></div>
            
            
          </div>

<div class="user_c_l">
  <h3 class="yhzx_header"><a href="<?php echo $order_one; ?>"><?php echo $text_userCenter; ?></a></h3>
  <div class="user_c_cont">
    <ul class="userc0 user_hover">
      <li class="userc_head0">
        <h4><?php echo $text_orderManagement; ?></h4>
      </li>
      <li><a href="<?php echo $order_one; ?>"><?php echo $text_myOrder; ?></a></li>
      
      <li><a href="<?php echo $make; ?>"><?php echo $text_placeOrder; ?></a></li>
       
      <li><a href="<?php echo $order_guoji; ?>"><?php echo $text_internationalAirWaybill; ?>
        <?php if($num_guoji){ ?>
       (    <span><?php echo $num_guoji; ?></span>   )</a></li>
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )</a></li>
       <?php } ?>
      
      
      <li><a href="<?php echo $order_my_cangku; ?>"><?php echo $text_myWarehouse; ?>
        <?php if($num_cangku){ ?>
       (    <span><?php echo $num_cangku; ?></span>   )</a></li>
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )</a></li>
       <?php } ?>
        
      
      <li><a href="<?php echo $wishlist; ?>"><?php echo $text_myCollection; ?>
        <?php if($num_wishlist){ ?>
       (    <span><?php echo $num_wishlist; ?></span>   )</a></li>
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )</a></li>
       <?php } ?>
       
    </ul>
    <ul class="userc1 user_hover">
      <li class="userc_head1">
        <h4><?php echo $text_accountManagement; ?></h4>
      </li>
      <li><a href="<?php echo $rmbaccount ;?>"><?php echo $text_RMBaccount; ?></a></li>
      <li><a href="<?php echo $expense    ;?>"><?php echo $text_recordsConsumption; ?></a></li>
      <li><a href="<?php echo $coupons    ;?>"><?php echo $text_myCoupons; ?></a></li>
      <li><a href="<?php echo $scorerecord ;?>"><?php echo $text_myIntegral; ?></a></li>
      <li><a href="<?php echo $webnews    ;?>"><?php echo $text_newsStation; ?>
        <?php if($num_webnews){ ?>
        (   <span><?php echo $num_webnews; ?></span>    )</a></li>
        <?php }else{     ?>
        (   <span class="num_zero">0</span>   )</a></li>
        <?php }  ?>
      
      <li><a href="<?php echo $advisory   ;?>"><?php echo $text_customerServiceConsulting; ?></a></li>
      <li><a href="<?php echo $snsmanager; ?>" class='cur'><?php echo $text_communityNews; ?></a></li>
      <!--<li><a href="<?php echo $invite     ;?>"><?php echo $text_myInvitation; ?><span class="num_zero">0</span>）</a></li>-->
    </ul>
    <ul class="userc2 user_hover">
      <li class="userc_head2">
        <h4><?php echo $text_personalSettings; ?></h4>
      </li>
      <li><a href="<?php echo $edit; ?>"><?php echo $text_personalData; ?></a></li>
      <li><a href="<?php echo $safety; ?>"><?php echo $text_accountSecurity; ?></a></li>
      <li><a href="<?php echo $address;?>"><?php echo $text_deliveryAddress; ?></a></li>
    </ul>
    <dl class="useful_tools">
      <dt><?php echo $text_commonlyUsedWidgets; ?></dt>
      <dd class="pack"><a href="<?php echo $populartools; ?>"><?php echo $text_checkParcel; ?></a></dd>
      <dd class="expend"><a href="<?php echo $populartools; ?>"><?php echo $text_costEstimating; ?></a></dd>
      <dd class="size"><a href="<?php echo $populartools; ?>"><?php echo $text_sizeConversion; ?></a></dd>
      <dd class="rate"><a href="<?php echo $populartools; ?>"><?php echo $text_exchangeRateConversion; ?></a></dd>
    </dl>
    <div class="feedback">
      <h4><?php echo $text_feedback; ?></h4>
      <textarea id="opinion" placeholder="<?php echo $text_yourSuggestion; ?>"></textarea>
    </div>
    <div class="tijiao_btn"><a onClick="opinion();" href="javascript:void(0);"><?php echo $text_submit; ?></a><span class="red"><?php echo $text_clickReply; ?></span></div>
  </div>
</div>
<div class="user_c_r">
<div class="daigou_list">
<div class="user_infor">
  <div class="images"><a href='http://www.acgstorm.com/index.php?route=account/edit&id=2'><?php if($face){ ?><img src="<?php echo $face;?>" alt="<?php echo $text_photo; ?>"><?php }else{ ?><img src="image/head1.jpg" alt=""><?php } ?><span class="change_photos"></span><em><?php echo $text_modifyPhoto; ?></em></a></div>
  <dl class="pers_infor">
    <dt>
      <ul>
        <li class="pi_hi">

          <?php if ($verification) { ?>
            <img src="image/verification.png" alt="<?php echo $text_studentCertificationIcon;?>" width="20" height="20"/>
          <?php } ?>

        <span class="pi_nam"><?php echo $customer_name;?></span>，<?php echo $time_name;?>~</li>
        <?php if(isset($utype)) { ?>
        <?php if(0 ==  $utype) { ?>
        <li class="pi_huiyuan"><span><?php echo $text_gradeMembership;?></span><em class="level_0"></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b><?php echo $growth;?></b>/1000</em></li>
        <?php  }else if(1 == $utype) { ?>
        <li class="pi_huiyuan"><span><?php echo $text_gradeMembership;?></span><em class="level_1"></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b><?php echo $growth;?></b>/3000</em></li>
        <?php  }else if(2 == $utype) { ?>
        <li class="pi_huiyuan"><span><?php echo $text_gradeMembership;?></span><em class="level_2"></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b><?php echo $growth;?></b>/6000</em></li>
        <?php  }else if(3 == $utype) { ?>
        <li class="pi_huiyuan"><span><?php echo $text_gradeMembership;?></span><em class="level_3"></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b><?php echo $growth;?></b>/18000</em></li>
        <?php  }else if(4 == $utype) { ?>
        <li class="pi_huiyuan"><span><?php echo $text_gradeMembership;?></span><em class="level_4"></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b><?php echo $growth;?></b>/36000</em></li>
        <?php  }else if(5 == $utype) { ?>
        <li class="pi_huiyuan"><span><?php echo $text_gradeMembership;?></span><em class="level_5"></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b><?php echo $growth;?></b>/∞</em></li>
        <?php }}else{ ?>
        <li class="pi_huiyuan"><?php echo $text_gradeMembership;?></em></li>
        <li class="pi_growup"><span><?php echo $text_growthValue;?></span><em><b></b></em></li>
        <?php } ?> 
        <li class="pi_jifen"><span><?php echo $text_memberIntegral;?></span><em><b><?php if (isset($score)) echo $score; ?></b></em></li>
      </ul>
    </dt>
    <dd class="pi_yue"><?php echo $text_accountBalance;?></dd>
    <dd class="pi_mon">
      <ul>
        <li><b><?php if (isset($money)) echo $money; ?></b><?php echo $text_yuan;?></li>
        <li class="pi_lock"><?php echo $text_lockTheBalance;?><em>0.00</em><?php echo $text_yuan;?></li>
        <li class="pi_chongzhi"><a href="index.php?route=account/rmbaccount/onlinecharge"><?php echo $text_immediatelyRecharge;?></a></li>
	<li class="pi_recomment"><a href="javascript:;"><?php echo $text_recToFriends ; ?></a></li>
      </ul>
    </dd>
  </dl>
  <dl class="impo_infor">
    <dt><a class="infor_more" href="index.php?route=account/edit"><?php echo $text_detailedPersonalInformation;?></a><a class="box_addr" href="index.php?route=order/order/order_myhome"><?php echo $text_myWarehouseDddress;?></a></dt>
  </dl>
   <dl class="cutBoardValDiv">
	<input id="cutBoardVal" type="text" class="cutBoardVal" value="http://www.acgstorm.com/account-register.html&u=<?php if (isset($customer_id)) echo $customer_id+9999; ?>"/>
	<button class="cutBoardValButton" onclick="copy()">复制</button>
  </dl>
</div>
<script src="catalog/view/javascript/jquery2/orderlist.js"></script> 
<script> 
function copy(){
	if (window.clipboardData) {
		window.clipboardData.clearData();
		window.clipboardData.setData("Text", document.getElementById('cutBoardVal').value);
		alert('复制成功');
		$('.cutBoardValDiv').slideUp(500);
	}else{
		$('#cutBoardVal').select();
		alert('您使用的浏览器不支持复制功能，请使用ctrl+c或右键。');
		//$('.cutBoardValDiv').slideUp(500);
	}
}
$(document).on('click','.pi_recomment',function(){
	$('.cutBoardValDiv').slideDown(500);
});
</script> 