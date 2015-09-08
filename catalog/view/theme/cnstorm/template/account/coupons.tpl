<title>我的优惠券-欢迎领取CNstorm代购账户管理</title>     
<meta name="keywords" content="账户管理, CNstorm账户,账户中心，账户消费，优惠券，优惠券面额" />      
<meta name="description" content="在您的CNstorm代购账户中心，可以对领取的CNstorm优惠券进行查询和管理" />
<?php echo $header; ?>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
              <div class="">
                  <div class="dl_head">
                      <h3 class="bg9">我的优惠劵</h3>                      
                  </div>
                  <div id="dvContent">
                    <div class="all_dingdan" style="position:relative;">
                        <div class="rmb_accout">                          
                            <div class="rmb_recharge"> 
                                <div class="record">                                  
                                    <table class="record_table" border="0" align="center" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr class="record_head">
                                               <td width="100">流水号</td>
                                               <td width="116">面值</td> 
                                               <td width="280">有效期</td>
                                              
  		                            <td width="100">
  		                            <select class="allstatus">
                                                    <option value="">全部状态</option>
                                                    <option value="">已使用</option>
                                                    <option value="">未使用</option>
                                                    <option value="">已过期</option>
                                             </select></td>
                                            <td width="100">使用来源</td>
                                            </tr>
                                            <?php if($coupon_info) { ?>
                                            <?php foreach($coupon_info as $coupon) { ?>
                                            <tr class="rt_one">
                                               <td><?php echo $coupon['sn'] ;?></td>
                                               <td><b>￥<?php echo round($coupon['money'],2) ;?></b></td>
                                                <td><?php echo date("Y-m-d",$coupon['addtime']) ;?> 至 <?php echo date("Y-m-d",$coupon['endtime']) ;?></td> 
                                               <?php if(1 == $coupon['state'] || 2 == $coupon['state']) { ?>
                                               <td>未使用</td>
                                               <?php }else if(3 == $coupon['state']) {?>
                                               <td>已使用</td>
                                               <?php }else if(4 == $coupon['state']) {?>
                                               <td>已过期</td>
                                               <?php } ?>
                                               <td></td>
                                            </tr> 
                                            <?php }  } ?>
                                        </tbody>
                                    </table>
                                    <div class="pages_change"><?php echo $pagination; ?></div>
                                </div>
                            </div>
                        </div>
                      <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
                        <svg xmlns="http://www.w3.org/2000/svg" width="960px" height="960px" viewBox="0 0 80 60" preserveAspectRatio="none" >
                          <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
                        </svg>
                      </div>
                    </div>
                  </div><!-- /dvContent -->
              </div>              
          </div>
     </div>
  </div>
</div>
<script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script> 
<script type="text/javascript">
  $(function(){
    $(document).on('click','.pages_change ul li a',function(){
      var loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 400, easingIn : mina.easeinout } );
      var url = $(this).attr('href');
      loader.show();
      window.scrollTo(0,475);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
          loader.hide();
          setTimeout(function(){$('#dvContent').html(data);}, 500);
        }
      });
      return false;
    });
});
</script>
<?php echo $footer; ?>