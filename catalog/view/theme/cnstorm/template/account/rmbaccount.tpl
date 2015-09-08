<title><?php echo $heading_title; ?></title>     
<meta name="keywords" content="<?php echo $keywords; ?>" />      
<meta name="description" content="<?php echo $description; ?>" />
<?php echo $header; ?>
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> 
    <?php echo $column_left; ?>
                  <div class="dl_head">
                      <h3 class="bg7"><?php echo $rmbaccount; ?></h3>                      
                  </div>
                  <div id="dvContent">
                    <div class="all_dingdan" style="position:relative;">
                        <div class="rmb_accout">
                            <div class="rmb_recharge"> 
                                <h3><?php echo $rechargerecord; ?>
                                  <select class="allstatus">
                                      <option value=""><?php echo $allrecord; ?></option>
                                      <option value=""><?php echo $onemonth; ?></option>
                                      <option value=""><?php echo $threemonths; ?></option>
                                      <option value=""><?php echo $halfyear; ?></option>
                                      <option value=""><?php echo $oneyear; ?></option>
                                   </select></h3>
                                
                                <div class="record">                                  
                                    <table class="record_table" border="0" align="left" cellspacing="0" cellpadding="0" style="margin-top:15px;">
                                        <tbody>
                                            <tr class="record_head">
                                               <td width="156"><?php echo $number; ?></td>
                                               <td width="220"><?php echo $addtime; ?></td>
                                               <td width="155"><?php echo $type; ?></td>
                                               <td width="220"><?php echo $rechargemoney; ?></td>
                                               <td><?php echo $money; ?></td>       
                                               <td><?php echo $status; ?></td>                                     
                                            </tr>
                                            <?php  foreach ($recharge_info as $info) {  ?>
                                            <tr class="rt_two">
                                               <td><?php echo $info['rid']; ?></td>
                                               <td><?php echo date('Y-m-d H:i:s', $info['addtime']); ?></td>
                                               <td><?php echo $info['payname']; ?></td>
                                               <td>￥<b><?php echo $info['money']; ?></b></td>
                                               <td>￥<b><b><?php echo $info['accountmoney']; ?></b></b></td>
                                               <?php if (1 == $info['state']) { ?>
                                               <td><?php echo $success; ?></td>
                                               <?php }else{ ?>
                                               <td><?php echo $failed; ?></td>
                                               <?php } ?>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="pages_change"><?php echo $pagination; ?></div>
                                </div>
                            </div>
                        </div>
                      <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
                        <svg xmlns="http://www.w3.org/2000/svg" width="960px" height="920px" viewBox="0 0 80 60" preserveAspectRatio="none" >
                          <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
                        </svg>
                      </div>
                    </div>
                </div><!-- /dvContent -->
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
<?php

echo $footer;

?>