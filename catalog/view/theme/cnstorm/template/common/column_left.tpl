<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<style>
.newCur { border-left: 3px solid #FB6E52; color: #FB6E52; background: url('catalog/view/theme/cnstorm/images/ico.png') no-repeat scroll -309px -1100px #FFF0ED; text-indent: 43px; }
.alert { background-color: #4DB1CA; margin: 3px 0; }
.more-nav-list { width: 990px; margin: 0 auto; line-height: 30px; color: #fff; font-size: 14px; font-weight: bold; text-align: center; }
.more-nav-list a { color: white; }
</style>
<!-- div class="alert">
  <div class="more-nav-list first" >< ?php echo $text_perfectExperience; ? > 新年好！&nbsp;&nbsp;Happy New Year！&nbsp;&nbsp;新年の楽しみ！&nbsp;&nbsp;Glückliches Neujahr！&nbsp;&nbsp;Selamat Tahun Baru！&nbsp;&nbsp;Buon anno！&nbsp;&nbsp;Bonne année！</br>CNstorm已全面恢复工作！  &nbsp;&nbsp;&nbsp;&nbsp;实用链接：<a href="/help.html" target="_blank">帮助中心</a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="/business-main-press.html" target="_blank">媒体报道</a></div>
</div -->
<div class="user_c_l">
  <h3 class="yhzx_header"><a href="<?php echo $order_one; ?>"><?php echo $text_userCenter; ?></a></h3>
  <div class="user_c_cont">
    <ul class="userc0 user_hover">
      <li class="userc_head0">
        <h4><?php echo $text_orderManagement; ?></h4>
      </li>
      <li><a href="<?php echo $order_one; ?>" <?php if ($order_one == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_myOrder; ?></a></li>
      <li><a href="<?php echo $make; ?>" <?php if ($make == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_placeOrder; ?></a></li>
      <li><a href="<?php echo $order_guoji; ?>" <?php if ($order_guoji == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_internationalAirWaybill; ?>
        <?php if($num_guoji){ ?>
        ( <span><?php echo $num_guoji; ?></span> )</a></li>
      <?php }else{  ?>
      ( <span class="num_zero">0</span> )</a>
      </li>
      <?php } ?>
      <li><a href="<?php echo $order_my_cangku; ?>" <?php if ($order_my_cangku == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_myWarehouse; ?>
        <?php if($num_cangku){ ?>
        ( <span><?php echo $num_cangku; ?></span> )</a></li>
      <?php }else{  ?>
      ( <span class="num_zero">0</span> )</a>
      </li>
      <?php } ?>
      <li><a href="<?php echo $wishlist; ?>" <?php if ($wishlist == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_myCollection; ?>
        <?php if($num_wishlist){ ?>
        ( <span><?php echo $num_wishlist; ?></span> )</a></li>
      <?php }else{  ?>
      ( <span class="num_zero">0</span> )</a>
      </li>
      <?php } ?>
    </ul>
    <ul class="userc1 user_hover">
      <li class="userc_head1">
        <h4><?php echo $text_accountManagement; ?></h4>
      </li>
      <li><a href="/index.php?route=account/rmbaccount/onlinecharge">充值</a></li>
      <li><a href="<?php echo $rmbaccount ;?>" <?php if ($rmbaccount == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_RMBaccount; ?></a></li>
      <li><a href="<?php echo $expense    ;?>" <?php if ($expense == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_recordsConsumption; ?></a></li>
      <li><a href="<?php echo $coupons    ;?>" <?php if ($coupons == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_myCoupons; ?></a></li>
      <li><a href="<?php echo $scorerecord ;?>" <?php if ($scorerecord == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_myIntegral; ?></a></li>
      <li><a href="<?php echo $webnews    ;?>" <?php if ($webnews == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_newsStation; ?>
        <?php if($num_webnews){ ?>
        ( <span><?php echo $num_webnews; ?></span> )</a></li>
      <?php }else{     ?>
      ( <span class="num_zero">0</span> )</a>
      </li>
      <?php }  ?>
      <li><a href="<?php echo $advisory   ;?>" <?php if ($advisory == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_customerServiceConsulting; ?></a></li>
      <li><a href="<?php echo $snsmanager; ?>"><?php echo $text_communityNews; ?></a></li>
      <!--<li><a href="<?php echo $invite     ;?>"><?php echo $text_myInvitation; ?>（<span class="num_zero">0</span>）</a></li>-->
    </ul>
    <ul class="userc2 user_hover">
      <li class="userc_head2">
        <h4><?php echo $text_personalSettings; ?></h4>
      </li>
      <li><a href="<?php echo $edit; ?>" <?php if ($edit == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_personalData; ?></a></li>
      <li><a href="<?php echo $safety; ?>" <?php if ($safety == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_accountSecurity; ?></a></li>
      <li><a href="<?php echo $address;?>" <?php if ($address == $currentUrl) echo "class='newCur'"; ?>><?php echo $text_deliveryAddress; ?></a></li>
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
  <div class="images"><a href='account-edit.html&id=2'>
    <?php if($face){ ?>
    <img src="<?php echo $face;?>" alt="<?php echo $text_photo; ?>">
    <?php }else{ ?>
    <img src="image/head1.jpg" alt="">
    <?php } ?>
    <span class="change_photos"></span><em><?php echo $text_modifyPhoto; ?></em></a></div>
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
        <li class="pi_jifen"><span><?php echo $text_memberIntegral;?></span><em><b>
          <?php if (isset($score)) echo $score; ?>
          </b></em></li>
      </ul>
    </dt>
    <dd class="pi_yue"><?php echo $text_accountBalance;?></dd>
    <dd class="pi_mon">
      <ul>
        <li><b>
          <?php if (isset($money)) echo $money; ?>
          </b><?php echo $text_yuan;?></li>
        <li class="pi_lock"><?php echo $text_lockTheBalance;?><em>0.00</em><?php echo $text_yuan;?></li>
        <li class="pi_chongzhi"><a href="index.php?route=account/rmbaccount/onlinecharge"><?php echo $text_immediatelyRecharge;?></a></li>
        <li class="pi_recomment"><a href="javascript:;"><?php echo $text_recToFriends ; ?></a></li>
      </ul>
    </dd>
  </dl>
  <dl class="impo_infor">
    <dt><a class="infor_more" href="account-edit.html"><?php echo $text_detailedPersonalInformation;?></a><a class="box_addr" href="order-order-order_myhome.html&id=2"><?php echo $text_myWarehouseDddress;?></a></dt>
    <dd class="prompts"><?php echo $text_prompt;?></dd>
    <dd class="impo_btns" ><a class="dati" href="social.html"><?php echo $text_answer;?></a><a class="qiandao" href="social.html"><?php echo $text_sign;?></a></dd>
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