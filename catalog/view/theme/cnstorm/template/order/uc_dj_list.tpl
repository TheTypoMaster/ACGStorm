<?php echo $header; ?>
<title>代寄订单列表 - CNstorm用户中心</title>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class=''>
        <div class="dl_head">
          <h3 class="bg1"><?php echo $order_daiji;?></h3>
          <div class="dl_h_input">
               <div class="searchForOrderDiv">
                   <label><input name="searchForOrder" type="radio" value="1" class="searchForOrder" checked/><font><?php echo $text_by_id; ?></font></label>
                   <label><input name="searchForOrder" type="radio" value="2" class="searchForOrder"/><font><?php echo $text_by_keywords; ?></font></label>
               </div>
               <input type="text" placeholder="<?php echo $text_search_placeholder ;?>" class="search_box" id="searchKeyWord">
               <input type="button" value="" class="search_btn" onclick="searchOrderForKeyWord()">
               <a href="javascript:void(0);" class="searchbox_a"><?php echo $text_search_timerange; ?></a>
          </div>
          <div class="dl_t_input" style="display:none;">
               <input type="text" placeholder="<?php echo $text_startTime_placeholder; ?>" id="startTime" class="time_search" /><em>~</em><input type="text" placeholder="<?php echo $text_endTime_placeholder; ?>" id="endTime" class="time_search" /><input type="button" value="" class="search_btn" onclick="searchOrderForTime()"/>
               <a href="javascript:void(0);" class="searchbox_a"><?php echo $text_search_keywords; ?></a></div>
          </div>
        </div>
        <div class="all_dingdan">
          <ul class="dingdan_list">
            <li><a href="<?php echo $order_my_cangku; ?>"  ><?php echo $text_mailable_order; ?>
            <?php if($num_cangku){ ?>
       (    <span><?php echo $num_cangku; ?></span>   )
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )
       <?php } ?>
       </a></li>
            <li><a href="index.php?route=order/order"><?php echo $order_daigou;?>       
            <?php if($num_daigou){ ?>
       (    <span><?php echo $num_daigou; ?></span>   )
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )
       <?php } ?></a></li>
            <li><a href="index.php?route=order/order/order_two"   ><?php echo $order_zigou;?>
                    <?php if($num_zizhu){ ?>
       (    <span><?php echo $num_zizhu; ?></span>   )
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )
       <?php } ?>
            </a></li>
            <li><a class="on" href="javascript:void(0);" ><?php echo $order_daiji;?>
                    <?php if($num_daiji){ ?>
       (    <span><?php echo $num_daiji; ?></span>   )
       <?php }else{  ?>
       (    <span class="num_zero">0</span>   )
       <?php } ?>
            </a></li>
          </ul>


	  <ul class="dingdan_status">
		<li><a <?php if (!isset($pass_order_status_id)) echo "class='dingdan_active'" ?> href="order-order-order_three.html&order_status_id=0" ><?php echo $text_all_order; ?><font color="#FD522E">( <?php echo $num_daiji; ?> )</font></a></li>
		<?php foreach ($order_statuses as $order_status) { ?>
			<li><a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-order-order_three.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?>
			<font color="#FD522E">( <?php echo $order_status['total']; ?> )</font></a></li>
		<?php } ?>
	    </ul>

          <div id="dvContent" style="position:relative;">
            <div class="dg_dingdan">
              <ul class="detail_dd">
                <li class="detail_o bag_name"><?php echo $order_info;?></li>
                <li class="detail_fo exp_comp"><?php echo $order_company;?></li>
                <li class="detail_fi">
                  <select onchange=order_change("three");name="filter_order_status_id" id="filter_order_status_id">
                    <option value="*"><?php echo $text_all_order; ?></option>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ( isset( $order_status_id ) &&  $order_status['order_status_id'] == $order_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </li>
                <li class="detail_si"><?php echo $order_operating; ?></li>
              </ul>
              <?php 	  
  			 if ($orders) {		  
              foreach ($orders as $order) {		
  			?>
              <div class="dingdan0 daigou_hei">
                <p class="dd_head"><span class="dd_code"><em><?php echo $order_Number;?></em><?php echo $order['order_id'];?></span><span class="dd_time"><em><?php echo $order_time;?></em><?php echo $order['date_added'];?></span></p>
                <?php foreach ($order['product'] as $orde_product) {?>
                <ul class="dingdan_table">
                  <li class="dt_infor bag_name">
                    <dl>
                      <dt class="dd_code"><em><?php echo $order_baoguo_name;?></em><?php echo $orde_product['name'];?></dt>
                      <dd class="wait_pay"><em><?php echo $order_remark;?></em><?php echo $orde_product['note'];?></dd>
                    </dl>
                  </li>
                  <li class="dt_express_add"><?php echo $orde_product['kuaid_gongsi'];?><br><?php echo $orde_product['kuaidi_no'];?> </li>
                  <li class="dt_status"><?php echo $order['status'];?></li>
                  <?php if($order['order_status_id']==3){?><!--待发货-->
                  <li class="dt_cancle" ><a onclick="add_express(<?php echo $order['order_id'];?>);" href="javascript:void(0);"> <?php echo $text_fillin_logistics2; ?></a> / <a onclick="dede(<?php echo $order['order_id'];?>,'daiji');" href="javascript:void(0);"><?php echo $order_quxiao;?></a> </li>
                  <?php }else{ ?>
                  <li class="dt_cancle" >
                  <?php if($order['order_status_id']==6){}else if($order['order_status_id']==8){}else{?><!--6已入库8已经提交运送-->
                    <a onclick="dede(<?php echo $order['order_id'];?>);" href="javascript:void(0);"><?php echo $order_quxiao;?></a>  /  <?php } ?>
                    <a href='javascript:void(0);' class="kuaidi_<?php echo $order['order_id'];?>" onclick="kuaidi(<?php echo $order['order_id'];?>)" url='/index.php?route=order/order/track&expreser=<?php echo $orde_product['express'] ?>&no=<?php echo $orde_product['kuaidi_no'] ?><?php echo $kuaidi_query ?>' ><?php echo $text_check_logistics;?> </a>
                  </li>


		  <li style=" width:76px; border-right: 1px solid #E5E5E5;text-align: center;line-height: 44px;" >
			<?php if($order['order_status_id']==2){?><!--已付款-->
				<p style="cursor:pointer;"><?php if ( $order ['creq'] ) { ?>
					<span class="dd_code" id="c<?php echo $order['order_id']; ?>"><em style="color:green;"><?php echo $text_urged; ?></em></span>
				<?php }else{ ?>
					<span class="dd_code" onclick="modify_c(<?php echo $order['order_id']; ?>);" id="c<?php echo $order['order_id']; ?>"><em><?php echo $text_urged_buy; ?></em></span>
				<?php } ?></p>
			<?php }else if($order['order_status_id']==4){?><!--卖家已发货-->
				<p style="cursor:pointer;"><?php if ( $order ['preq'] ) { ?>
					<span class="dd_code" id="p<?php echo $order['order_id']; ?>"><em  style="color:green;"><?php echo $text_requested_photo; ?></em></span>
				<?php }else{ ?>
					<span class="dd_code" onclick="modify_p(<?php echo $order['order_id']; ?>);" id="p<?php echo $order['order_id']; ?>"><em><?php echo $text_photograph_photo; ?></em></span>
				<?php } ?></p>
			<?php } ?>
		  </li>


                  <?php } ?>
                </ul>
                <ul class="track_<?php echo $order['order_id'];?>" id="track" style="display:none;">
                  <li style="margin: 10px 200px;">
                    <div class="express_info_<?php echo $order['order_id'];?>" style="display:none;text-align:center;">
                      <select name="btexpresses" id="btexpresses_<?php echo $order['order_id'];?>">
                        <option value="*"><?php echo $text_select_express;?></option>
                        <?php 
  	        	   foreach ($expresses as $expresse) { ?>
                        <option value="<?php echo $expresse['name_en']; ?>"><?php echo $expresse['name_cn']; ?></option>
                        <?php } ?>
                      </select>
                      <b class="red noexpress_<?php echo $order['order_id'];?>"><?php echo $text_select_express;?></b> <?php echo $express_number;?>
                      <input name="bt_expressno" id="bt_expressno_<?php echo $order['order_id'];?>" type="text" value="" />
                      <b class="red nonum_<?php echo $order['order_id'];?>"><?php echo $text_fillin_nubmer;?></b>
                      <input class="bt_btn" type="button" value="<?php echo $text_submit;?>" onclick="bt_express(<?php echo $order['order_id'];?>);"/>
                    </div>
                    <div class="deliver_info_close_<?php echo $order['order_id'];?>" style="display:none;text-align:center;"><img src='http://www.uuch.com/images/share/032.gif'/></br><?php echo $text_loading;?></div>
                    <div class="deliver_info_<?php echo $order['order_id'];?>" ></div>
                  </li>
                </ul>
                <?php } ?>
              </div>
              <?php 				
  					}
  					}
  					?>
            <div class="pages_change"><?php echo $pagination; ?></div>
          </div>  
                    <!--
            <div class="pages_change">
              <ul class="list_num">
                <li class="pages_left"><a href="javascript:void(0);">&lt;</a></li>
                <li> </li>
                <li class="number on"><a href="javascript:void(0);">1</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">2</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">3</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">4</a></li>
                <li> </li>
                <li class="number"><a href="javascript:void(0);">5</a></li>
                <li> </li>
                <li class="dot">...</li>
                <li class="pages_right"><a href="javascript:void(0);">&gt;</a></li>
                <li> </li>
                <li class="infor">共 50 页，到第</li>
                <li class="go_direct">
                  <input class="gd_input" type="text" value="" />
                </li>
                <li class="infor">页</li>
                <li class="btn"><a href="javascript:void(0);">确定</a></li>
              </ul>
            </div>
            -->
            <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
              <svg xmlns="http://www.w3.org/2000/svg" width="940px" height="840px" viewBox="0 0 80 60" preserveAspectRatio="none" >
                <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
              </svg>
            </div>
          </div><!-- /dvContent -->
        </div>
      </div>
    </div>
  </div>
</div>
/*
</div>
</div>
</div>*/
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
<script type="text/javascript">
function searchOrderForTime(){
    var startTime = $('#startTime').val(); 
    var endTime = $('#endTime').val();
    var re = /^(\d{4})-(0\d{1}|1[0-2])-(0\d{1}|[12]\d{1}|3[01])$/;
    if (!re.test(startTime) || !re.test(endTime)){
        alert('<?php echo $text_time_format; ?>');
    }else if (startTime.trim('') != '' && endTime.trim('') != ''){
        window.location="order-order-order_three.html&st="+startTime+"&et="+endTime;
    }else{
        alert('<?php echo $text_time_notnull; ?>');
    }
}

function searchOrderForKeyWord(){
    var searchKeyWord= $('#searchKeyWord').val();
    var si = $("input[name='searchForOrder']:checked").val();
    if (searchKeyWord.trim('') != ''){
        if (si == 1){
            window.location="order-order-order_three.html&order_id="+searchKeyWord;
        }else if(si == 2){
            window.location="order-order-order_three.html&sk="+searchKeyWord;
        }
    }else{
        alert('<?php echo $text_keyword_format; ?>');
    }
}
function modify_p(id){
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
