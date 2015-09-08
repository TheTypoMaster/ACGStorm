<title>消费记录-您的CNstorm代购账户管理</title>
<meta name="keywords" content="账户管理, CNstorm账户,账户充值账户消费，消费记录，消费金额" />
<meta name="description" content="欢迎查询和管理您的CNstorm代购公司账户消费记录" />
<?php echo $header_cart; ?>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<script src="catalog/view/javascript/jquery2/uc_business.js"></script>
<script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script> 
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>消费记录</h2>
  </div>
       <div id="dvContent">
          <div class="all_dingdan">
          <div class="rmb_accout">
            <div class="rmb_recharge">
              <div class="record">
                <table class="record_table" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="record_head">
                      <td width="230">最近交易</td>
                      <td width="280">消费详情</td>
                      <td width="100">消费金额(￥)</td>
                      <td width="110">账户余额(￥)</td>
                      <td><select class="order_type" name="order_type">
                          <option value="6" <?php if($consume_type==6){ ?> selected="selected" <?php } ?> >全部类型</option>
                          <option value="1" <?php if($consume_type==1){ ?> selected="selected" <?php } ?>>代购订单</option>
                          <option value="3" <?php if($consume_type==3){ ?> selected="selected" <?php } ?>>国际运单</option>
                          <option value="5" <?php if($consume_type==5){ ?> selected="selected" <?php } ?>>价格调整</option>
                        </select></td>
                      <td width="100">备注</td>
                    </tr>
                    <?php if($record_info) { ?>
                    <?php foreach($record_info as $record) { ?>
                    <tr class="rt_two">
                      <td>流水号：<?php echo $record['rid'] ; ?><br>
                        交易时间：<?php echo date("Y-m-d H:i:s",$record['addtime']) ; ?></td>
                      <td><?php echo $record['remark'] ; ?></td>
                      <td><b><?php echo $record['money'] ; ?></b></td>
                      <td><b><?php echo $record['accountmoney'] ; ?></b></td>
                      <?php if(1 == $record['action'] || 2 == $record['action']) { ?>
                      <td>代购订单</td>
                      <?php }else if(3 == $record['action']) { ?>
                      <td>国际运单</td>
                      <?php }else if(5 == $record['action']) { ?>
                      <td>价格调整</td>
                      <?php }else{ ?>
                      <td></td>
                      <?php } ?>
                      <?php if($record['remarktype']) { ?>
                      <td><a onclick="record_list(<?php echo $record['rid'];?>)">备注详情</a></td>
                      <?php }else{ ?>
                      <td></td>
                      <?php } ?>
                    </tr>
                    <?php } } ?>
                  </tbody>
                </table>
                <div class="pages_change "><?php echo $pagination; ?></div>
              </div>
            </div>
          </div>
<script>
$(function(){
	$('.order_type').change(function(){
		var type=$(this).val();
			if(type > 0){
				$.post("/index.php?route=account/expense/getSelected",{type:type},function(data){
					var url="/account-expense.html";
					window.location.href=url;
				});
			}
		
		})
})
	function record_list(id){
		if(id){
				window.open('/index.php?route=account/expense/record_list&rid='+id,'asdsad','width:1200px,height:400px');
		}
	}
</script>
          <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <svg xmlns="http://www.w3.org/2000/svg" width="960px" height="960px" viewBox="0 0 80 60" preserveAspectRatio="none" >
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
            </svg> </div>
        </div>
      </div>
      </div>
    </body>

<script src="catalog/view/javascript/pl/js/snap.svg-min.js"></script> 
<script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script> 

<script type="text/javascript">
  $(function(){
    $(document).on('click','.pages_change ul li a',function(){
     
      var loader = new SVGLoader( document.getElementById( 'loader' ), {speedIn : 400, easingIn : mina.easeinout});
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
</div>
<div style="clear:both"></div>
<?php echo $footer; ?>