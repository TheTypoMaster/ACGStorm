<title><?php echo $text_head; ?></title>
<meta name="keywords" content="<?php echo $text_meta_keywords; ?>" />
<meta name="description" content="<?php echo $text_meta_description; ?>"  />
<meta name="robots” content="nofollow” />
<?php echo $header_cart; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<script language="javascript" src="catalog/view/javascript/jquery2/batch.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script src="catalog/view/javascript/pl/js/snap.svg-min.js"></script>
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>代采购订单</h2>
    <span class="faqs"> <a href="/help.html" class="link-faq" title="使用帮助">FAQ</a> </span></div>
  <div class="ui-box">
    <h3> 主要订单状态 </h3>
    <div class="ui-box-body">
      <div class="ui-form-item">
        <div class="ui-form-control">
          <label>特别关注 :</label>
          <a <?php if (!isset($pass_order_status_id)) echo "class='dingdan_active'" ?> href="order-order.html&order_status_id=0" ><?php echo $text_all_order; ?><font color="#FD522E">( <?php echo $num_daigou; ?> )</font></a>
          <?php foreach ($order_statuses as $order_status) { if ($order_status['order_status_id'] == 2 || $order_status['order_status_id'] ==4 ||  $order_status['order_status_id'] ==8) {?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-order.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?> <font color="#FD522E">(
          <?php if ( isset($order_status['total']) ) echo $order_status['total']; ?>
          )</font></a>

          <?php }else if($order_status['order_status_id'] == 6 ){ ?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-order-order_myhome.html" ><?php echo $order_status['name']; ?> <font color="#FD522E">(
          <?php if ( isset($order_status['total']) ) echo $order_status['total']; ?>
          )</font></a>    
<?php } } ?>


        </div>
      </div>
      <div class="ui-form-item">
        <div class="ui-form-control">
          <label>等待您的处理 :</label>
          <?php foreach ($order_statuses as $order_status) { if ($order_status['order_status_id'] == 1 || $order_status['order_status_id'] ==9 || $order_status['order_status_id'] ==7) {?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-order.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?> <font color="#FD522E">(
          <?php if ( isset($order_status['total']) ) echo $order_status['total']; ?>
          )</font></a>
          <?php }} ?>
        </div>
      </div>
      <div class="ui-form-item">
        <div class="ui-form-control">
          <label>等待商家处理 :</label>
          <?php foreach ($order_statuses as $order_status) { if ($order_status['order_status_id'] == 3) {?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-order.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?> <font color="#FD522E">( <?php echo $order_status['total']; ?> )</font></a>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <div class="order_list">
    <ul class="detail_dd">
      <li class="detail_o"><?php echo $order_info;?></li>
      <li class="detail_t"><?php echo $order_price;?></li>
      <li class="detail_th"><?php echo $order_qty;?></li>
      <li class="detail_fo"><?php echo $order_Payment;?></li>
      <li class="detail_fi">
        <select onchange='search_change(this.options[this.options.selectedIndex].value)' style="margin-top:5px;" name="filter_order_status_id" id="filter_order_status_id">
          <option value="0"><?php echo $text_all_order; ?></option>
          <?php foreach ($order_statuses as $order_status) { ?>
          <?php if ($order_status['order_status_id'] == $order_status_id) { ?>
          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </li>
      <li class="detail_si"><?php echo $order_operating;?></li>
    </ul>
    <div id="dvContent" style="position:relative;">
      <form  id="batch_pay_form"  action="http://www.acgstorm.com/index.php?route=checkout/confirm" method="post" />
      <?php    if ($orders) { ?>
   <ul class="detail_dd2">
        <li class="detail_o pay_all">
          <input id="SelectAll_front" class="SelectAll_front check" name="SelectAll_front" type="checkbox" />
          <label><?php echo $text_check_all; ?></label>
        </li>
        <li class="detail_t pay_click">
          <input type="button" onclick="HasOrder()" value="<?php echo $text_merge_pay; ?>"/>
        </li>
      </ul>  
	  <?php } ?>
      <?php     
                  if ($orders) {  
				  foreach ($orders as $order) {   
                ?>
      <div class="dingdan0">
        <p class="dd_head">
          <?php if(1 == $order['order_status_id']) { ?>
          <input class="dd_check check" id="<?php echo $order['order_id'];?>" type="checkbox" value="<?php echo $order['order_id'];?>" />
          <?php }else{  ?>
          <input class="dd_check check" id="<?php echo $order['order_id'];?>" type="checkbox" disabled="disabled" value="<?php echo $order['order_id'];?>" />
          <?php } ?>
          <span class="dd_code"><em><?php echo $order_Number;?></em><?php echo $order['order_id'];?></span> <span class="dd_time"><em><?php echo $order_time;?></em><?php echo $order['date_added'];?></span> <span class="dd_code"><em><?php echo $text_store_title; ?></em><a target="_blank" href="<?php echo $order['storeurl'];?>" ><?php echo $order['storename'];?></a></span> </p>
        <table class="zizhu_table" border="0" align="center" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td width="613" height="98"><table border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <?php foreach ($order['product'] as $orde_product) {?>
                    <tr>
                      <td width="379" height="98" class="border_r noborder_r"><div class="dt_cloth"> <a href="javascript:void(0);" class="" ><img src="<?php if(isset($orde_product['img'])) echo $orde_product['img']; else echo '/uploads/big/0b4a96400b2372d25da769647bfe4059.jpg'; ?>" alt="<?php echo $text_product_img; ?>"></a>
                          <dl>
                            <dt><a target="_blank" href="<?php echo urldecode($orde_product['producturl']); ?>" ><?php echo $orde_product['name'];?></a><?php echo $orde_product['name'];?></a></dt>
                            <dd><em><?php echo $order_color;?></em><?php echo $orde_product['color'];?> <em class="produ"><?php echo $order_size;?></em><?php echo $orde_product['size'];?></dd>
                            <dd class="wait_pay"><em><?php echo $order_remark;?></em>
                              <?php if($order['order_status_id']==1){?>
                              <input type="text" id="beizhu_in" value="<?php echo $orde_product['note'];?>" class="beizhu_in<?php echo $orde_product['order_product_id']; ?>">
                              <input id="beizhu_correct" value="<?php echo $text_modify; ?>" type="button" class="<?php echo $orde_product['order_product_id']; ?>" style="<?php if($_SESSION['language'] == 'en') echo 'background: url(../images/ico_en.png) no-repeat -559px -1355px;' ?>" onclick="modify(<?php echo $orde_product['order_product_id']; ?>);" />
                              <span id="mod<?php echo $orde_product['order_product_id']; ?>" style="color:green;"></span>
                              <?php }else{ ?>
                              <?php echo $orde_product['note'];?>
                              <?php } ?>
                            </dd>
                          </dl>
                        </div></td>
                      <td width="140" height="98" class="border_r noborder_r" align="center">￥<?php echo $orde_product['price'];?></td>
                      <td width="90" height="98" class="border_r" align="center"><?php echo $orde_product['quantity'];?></td>
                    </tr>
                    <?php
                          }
                          
                          ?>
                  </tbody>
                </table></td>
              <td width="100" class="border_r"><table border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td align="center" class="fs4"><span class="price_total_<?php echo $order['order_id'];?>"><?php echo $order['product_total'];?></span><br>
                        <?php echo $order_shipping;?>+<span class="freight_<?php echo $order['order_id'];?>"><?php echo $order['order_shipping'];?></span></td>
                    </tr>
                  </tbody>
                </table></td>
              <td width="119" class="border_r" align="center"><?php echo $order['status'];?></td>
              <td width="103" class="dt_quxiao" align="center"><?php if($order['order_status_id']==1){?>
                <a class="pay_page ml10" onClick="singlePay(<?php echo $order['order_id'];?>)" href="javascript:void(0);"><?php echo $Payment ;?></a> <span class="dd_code pay_cancle" onClick="dede(<?php echo $order['order_id'];?>)"><em><?php echo $order_quxiao;?></em></span>
                <?php }else if($order['order_status_id']==2){?>
                
                <!--已付款-->
                
                <?php if ( $order ['creq'] ) { ?>
                <span class="dd_code" id="c<?php echo $order['order_id']; ?>"><em style="color:green;"><?php echo $text_urged; ?></span>
                <?php }else{ ?>
                <span class="dd_code" onclick="modify_c(<?php echo $order['order_id']; ?>);" id="c<?php echo $order['order_id']; ?>"><em><?php echo $text_urged_buy; ?></span>
                <!--span class="dd_code" onClick="dede(<?php echo $order['order_id'];?>,'daigou')"><em><?php echo $order_quxiao;?></em></span -->
                <?php } ?>
                <?php }else if($order['order_status_id']==4){?>
                
                <!--卖家已发货-->
                
                <p><a href='javascript:void(0);' class="kuaidi_<?php echo $order['order_id'];?>" onClick="kuaidi(<?php echo $order['order_id'];?>)" url='/index.php?route=order/order/track&expreser=<?php echo $orde_product['express'] ?>&no=<?php echo $orde_product['kuaidi_no'] ?>' ><?php echo $text_check_logistics; ?> </a></p>
                <p>
                  <?php if ( $order ['preq'] ) { ?>
                  <span class="dd_code" id="p<?php echo $order['order_id']; ?>"><em  style="color:green;"><?php echo $text_requested_photo; ?></span>
                  <?php }else{ ?>
                  <span class="dd_code" onclick="modify_p(<?php echo $order['order_id']; ?>);" id="p<?php echo $order['order_id']; ?>"><em><?php echo $text_photograph_photo; ?></span>
                  <?php } ?>
                </p>
                <?php }else if($order['order_status_id']==7){ ?>
                
                <!--缺货--> 
                <span class="dd_code" onClick="dede(<?php echo $order['order_id'];?>,'daigou')"><em><?php echo $order_quxiao;?></em></span>
                <?php }else if($order['order_status_id']==9){ ?>
                
                <!--待补交费用--> 
                <span class="dd_code pay_cancle" onclick="query_difference('<?php echo $order['order_id'];?>')"><em><?php echo $text_check_agio; ?></em></span> <a class="pay_page" onClick="payback(<?php echo $order['order_id'];?>)" href="javascript:void(0);"><?php echo $text_pay_agio; ?></a> <span class="dd_code pay_cancle" onClick="dede(<?php echo $order['order_id'];?>,'daigou')"><em><?php echo $order_quxiao;?></em></span>
                <?php }?></td>
            </tr>
            <tr class="track_<?php echo $order['order_id'];?>" id="track" style="display:none;">
              <td colspan="9" align="center"><div class="deliver_info_close_<?php echo $order['order_id'];?>" style="display:none;cursor:pointer;"><img src='/catalog/view/theme/cnstorm/images/loading_data.gif'/></br>
                  <?php echo $text_loading; ?></div>
                <div class="deliver_info_<?php echo $order['order_id'];?>" ></div>
                <br/></td>
            </tr>
          </tbody>
        </table>
      </div>
   
	   

	  
	  <?php } }else{ ?>
	   <ul >
       
        <li class="detail_t pay_click">
				<div style="border:1px solid #ccc;height:30px;font-szie:14px;text-align:center;line-height:30px">  暂无订单信息</div>
        </li>
      </ul>
	  
	  <?php }?>
	       <?php    if ($orders) { ?>
        <ul class="detail_dd2" style="border-left:none; border-right:none;">
        <li class="detail_o pay_all">
          <input type="checkbox" name="SelectAll_front" class="SelectAll_front check" id="SelectAll_front">
          <label><?php echo $text_check_all; ?></label>
        </li>
        <li class="detail_t pay_click">
          <input type="hidden" name="batch_pay" id="batch_pay"/>
          <input type="button" onclick="HasOrder()" value="<?php echo $text_merge_pay; ?>">
        </li>
      </ul>
	  <?php } ?>
      </form>
      <div class="pages_change "><?php echo $pagination; ?></div>
      <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <svg xmlns="http://www.w3.org/2000/svg" width="940px" height="840px" viewBox="0 0 80 60" preserveAspectRatio="none" >
        <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
        </svg> </div>
    </div>
  </div>
</div>
</div>
</div>
</body>
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

function searchOrderForTime(){
    var startTime = $('#startTime').val(); 
    var endTime = $('#endTime').val();
    var re = /^(\d{4})-(0\d{1}|1[0-2])-(0\d{1}|[12]\d{1}|3[01])$/;
    if (!re.test(startTime) || !re.test(endTime)){
        alert('<?php echo $text_time_format; ?>');
    }else if (startTime.trim('') != '' && endTime.trim('') != ''){
        window.location="order-order.html&st="+startTime+"&et="+endTime;
    }else{
        alert('<?php echo $text_time_notnull; ?>');
    }
}

function searchOrderForKeyWord(){
    var searchKeyWord= $('#searchKeyWord').val();
    var si = $("input[name='searchForOrder']:checked").val();
    if (searchKeyWord.trim('') != ''){
        if (si == 1){
            window.location="order-order.html&order_id="+searchKeyWord;
        }else if(si == 2){
            window.location="order-order.html&sk="+searchKeyWord;
        }
    }else{
        alert('<?php echo $text_keyword_format; ?>');
    }
}

function payback(order_id) {
    
    $.ajax({
      url:'index.php?route=order/order/payback',
      dataType:"json",
      data:{order_id:order_id},
      type:"POST",
      success:function(json){
        if(1 == json) {
            swal({
                  title: "补交成功!",
                  text: "<?php echo $text_payagio_success; ?>",
                  type: "success",
                  timer: 2000
              });
            location.reload(); 
        }else if(2 == json){
            swal({
                  title: "补交失败!",
                  text: "<?php echo $text_payagio_failed1; ?>",
                  type: "error",
                  timer: 2000
            });
        }
      },
      error:function(){
        swal({
                  title: "补交失败!",
                  text: "<?php echo $text_payagio_failed2; ?>",
                  type: "error",
                  timer: 2000
            });
      }
    });
    
}

//查询差价金额
function query_difference(order_id) {
     alert(order_id);
     $.ajax({
      url:'index.php?route=order/order/query_difference',
      dataType:"json",
      data:{order_id:order_id},
      type:"POST",
      success:function(json){
          swal({
                  title: "查询成功!",
                  text: "<?php echo $text_payagio_money; ?>" + json + "元",
                  type: "success",
                  timer: 3000
              });
         
      },
      error:function(){
         swal({
                  title: "查询失败!",
                  text: "<?php echo $text_payagio_failed3; ?>",
                  type: "error",
                  timer: 2000
              });
        
      }
    });
}

function modify(id){
    $.ajax({
      url:'index.php?route=order/order',
      dataType:"json",
      data:{order_product_id:id,content:$(".beizhu_in"+id).val()},
      type:"POST",
      success:function(req){
        $("#mod"+id).html(' ');
        setTimeout(function(){$("#mod"+id).html(req.msg);},300);
      },
      error:function(){
        alert('<?php echo $text_failed; ?>');
      }
    });
}
function modify_p(order_id){
   swal({
      title: "确认拍照?",
      text: "订单拍照单张1元,确认后将为您提交申请!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "确认",
      cancelButtonText: "关闭",
      closeOnConfirm: false
    },
    function(){
      $.ajax({
          url:'index.php?route=order/order/reqphoto',
          dataType:"json",
          data:"order_id="+order_id+"&sign=1",
          type:"POST",
          success:function(json){
            if(1 == json) {
                swal({
                  title:"提交成功!",
                  text: "提交订单拍照申请成功!",
                  type: "success",
                  timer: 2000
                });
                window.location.reload();
            }else if(2 == json){
                swal({
                  title:"提交失败!",
                  text: "余额扣除失败，请重试!",
                  type: "error",
                  timer: 2000
                });
            }else if(3 == json){
                swal({
                  title:"提交失败!",
                  text: "余额不足,请充值后再申请!",
                  type: "error",
                  timer: 2000  
                });
            }
          },
          error:function(){
            swal("提交失败!", "提交订单拍照申请失败,请重试!", "error");
          }
        });
    });

}
function modify_c(id){
    $.ajax({
      url:'index.php?route=order/order/pcReq',
      dataType:"json",
      data:{order_id:id,sign:2},
      type:"POST",
      success:function(req){
        $("#c"+id).html(' ');
        setTimeout(function(){
                              $("#c"+id).css("color","green");
                              $("#c"+id).html("<?php echo $text_urged; ?>");
                          },300);
      },
      error:function(){
        alert('<?php echo $text_failed; ?>');
      }
    });
}
</script>
<?php echo $footer; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<script src="catalog/view/javascript/jquery2/uc_business.js"></script>
