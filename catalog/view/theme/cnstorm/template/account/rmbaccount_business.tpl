<title>账户资金-CNstorm淘国货平台</title>
<meta name="keywords" content="账户管理, 人民币账户，账户余额，账户充值，消费记录，优惠券" />
<meta name="description" content="欢迎充值您的cnstorm代购平台人民币账户，查询和管理账户余额" />
<?php echo $header_cart; ?>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<script src="catalog/view/javascript/jquery2/uc_business.js"></script>
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<script src="catalog/view/javascript/pl/js/snap.svg-min.js"></script> 
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>账户资金</h2>
  </div>
  <div id="dvContent">
  <div class="all_dingdan">
    <div class="rmb_accout">
      <div class="rmb_recharge">
        <div class="rmb_title">
        <h3><?php echo $rechargerecord; ?></h3>
        <select class="allstatus">
          <option value=""><?php echo $allrecord; ?></option>
          <option value=""><?php echo $onemonth; ?></option>
          <option value=""><?php echo $threemonths; ?></option>
          <option value=""><?php echo $halfyear; ?></option>
          <option value=""><?php echo $oneyear; ?></option>
        </select>
        <a href="/index.php?route=account/rmbaccount/onlinecharge" class="tu_btn">立即充值</a>
        </div>

        <div class="record">
          <table class="record_table" border="0" align="left" cellspacing="0" cellpadding="0">
            <tbody>
              <tr class="record_head">
                <td width="108"><?php echo $number; ?></td>
                <td width="220"><?php echo $addtime; ?></td>
                <td width="168"><?php echo $type; ?></td>
                <td width="168"><?php echo $rechargemoney; ?></td>
                <td width="198"><?php echo $money; ?></td>
                <td width="98"><?php echo $status; ?></td>
              </tr>
              <?php  foreach ($recharge_info as $info) {  ?>
              <tr class="rt_one">
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

  <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <svg xmlns="http://www.w3.org/2000/svg" width="1600px" height="920px" viewBox="0 0 80 60" preserveAspectRatio="none" >
      <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
      </svg> 
  </div>

  </div>
</div>
</div>
</div>
</div>
</div><div style="clear:both"></div>
<script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script>
<script type="text/javascript">
$(function(){
    $(document).on('click','.pages_change ul li a',function(){
      var loader = new SVGLoader(document.getElementById('loader'),{ speedIn : 400, easingIn : mina.easeinout});
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