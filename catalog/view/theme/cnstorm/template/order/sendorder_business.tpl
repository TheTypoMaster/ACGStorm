<title>国际运单-CNstorm国际转运为你提供国际运单管理</title>
<meta name="keywords" content="国际运单服务, 国际运单，运单列表，运单信息，运单编号，合并运单，快递公司，转运公司，国际转运，转运中国，中国转运，中国运输，海外转运" />
<meta name="description" content="欢迎来到你的国际运单页面，对你的运输订单状态进行管理" />
<?php echo $header_cart; ?>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/sns.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<script language="javascript" src="catalog/view/javascript/jquery2/waybillbatch.js"></script>
<script src="catalog/view/javascript/pl/js/snap.svg-min.js"></script> 
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>所有运单</h2>
    <span class="faqs"> <a href="help.html" class="link-faq" title="使用帮助">FAQ</a> </span></div>
  <div class="ui-box">
    <h3> 主要运单状态 </h3>
    <div class="ui-box-body">
      <div class="ui-form-item">
        <div class="ui-form-control">
          <label>特别关注 :</label>
          <a <?php if (!isset($pass_order_status_id)) echo "class='dingdan_active'" ?> href="order-sendorder.html&order_status_id=-1" >
          全部运单<?php if (isset($text_all_order)) echo $text_all_order; ?>
          <font color="#FD522E">(
          <?php if (isset($num_daigou)) echo $num_daigou; ?>
          )</font></a>
          <?php foreach ($order_statuses as $order_status) { if ($order_status['name'] == '已付款' || $order_status['name'] =='已确认收货') {?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-sendorder.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?> <font color="#FD522E">(
          <?php if (isset($order_status['total'])) echo $order_status['total']; ?>
          )</font></a>
          <?php }} ?>
        </div>
      </div>
      <div class="ui-form-item">
        <div class="ui-form-control">
          <label>等待您的处理 :</label>
          <?php foreach ($order_statuses as $order_status) { if ($order_status['name'] == '无效运单' || $order_status['name'] == '待付款' || $order_status['name'] =='待补交运费' || $order_status['name'] =='已评价') {?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-sendorder.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?> <font color="#FD522E">(
          <?php if (isset($order_status['total'])) echo $order_status['total']; ?>
          )</font></a>
          <?php }} ?>
        </div>
      </div>
      <div class="ui-form-item">
        <div class="ui-form-control">
          <label>等待商家处理 :</label>
          <?php foreach ($order_statuses as $order_status) { if ($order_status['name'] == '准备邮寄' || $order_status['name'] == '已邮寄') {?>
          <a <?php if (isset($pass_order_status_id) &&  $pass_order_status_id == $order_status['order_status_id'])echo "class='dingdan_active'" ?> href="order-sendorder.html&order_status_id=<?php echo $order_status['order_status_id']; ?>" ><?php echo $order_status['name']; ?> <font color="#FD522E">(
          <?php if (isset($order_status['total'])) echo $order_status['total']; ?>
          )</font></a>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <div class="order_list">
    <ul class="detail_dd">
      <li class="detail_s">运单信息</li>
      <li class="detail_weigt">运送方式</li>
      <li class="detail_tiji">包裹号</li>
      <li class="detail_tras">寄送区域</li>
      <li class="detail_fi">
        <select onchange=order_change('sendorder'); name="filter_order_status_id" id="filter_order_status_id">
          <option value="*">全部运单</option>
          <?php foreach ($status_yundan as $order_status) { ?>
          <?php if ($order_status['id'] == $order_status_id) { ?>
          <option value="<?php echo $order_status['id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $order_status['id']; ?>"><?php echo $order_status['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </li>
      <li class="detail_addo">预付费</li>
      <li class="detail_addo">重量</li>
      <li class="detail_addt">操作</li>
    </ul>

    <div id="dvContent" style="position:relative;">
    <form id="waybillbatch_pay_form" action="index.php?route=checkout/confirm/sendorder" method="post" />
    
    <ul class="detail_dd2">
      <li class="detail_o pay_all">
        <input type="checkbox" name="SelectAll_front" class="SelectAll_front check" id="SelectAll_front">
        <label>全选</label>
      </li>
      <li class="detail_t pay_click">
        <input type="button" onclick="HasWaybill()" value="合并支付"/>
      </li>
    </ul>
    <input type="hidden" name="waybillbatch_pay" id="waybillbatch_pay"  value="" />
    <?php     
   if ($orders) {     
              foreach ($orders as $order) {   
        ?>
    <div class="daigou_hei">
      <p class="dd_head">
        <?php if(0 == $order['state']) { ?>
        <span class="checkbox_box">
        <input type="checkbox" class="check" value="<?php echo $order['sid'];?>"/>
        </span>
        <?php }else{ ?>
        <span class="checkbox_box">
        <input type="checkbox" class="check" disabled="disabled" value="<?php echo $order['sid'];?>"/>
        </span>
        <?php } ?>
        <span class="dd_code"><em>运单编号：</em><?php echo $order['sid'];?></span><span class="dd_time"><em>时间：</em><?php echo date("Y-m-d H:i:s",$order['addtime']);?></span></p>
      <ul class="dingdan_table">
        <li class="dt_infor bag_name">
          <dl>
            <dt>收件人：<?php echo $order['consignee'];?></dt>
          </dl>
        </li>
        <li class="dt_weight" id="carrier<?php echo $order['sid'];?>">
          <dl>
            <?php echo $order['express_guoji'];?>
          </dl>
        </li>
        <li class="dt_weight" id="sn<?php echo $order['sid'];?>">
          <dl>
            <?php echo $order['kuaiai_on'];?>
          </dl>
        </li>
        <li class="dt_weight">
          <dl>
            <?php echo $order['country'];?>
          </dl>
        </li>
        <?php if($order['kuaiai_on']!='' && $order['state_name']=='已邮寄'){?>
        <li class="dt_express">
          <dl>
            <span class="dt_comp"><?php echo $order['state_name'];?></span>
            <div class="wl_follow">
              <?php if($order['country']=="China"){?>
              <a onClick="kuaidi(<?php echo $order['sid'];?>)" url="index.php?route=order/sendorder/track&expreser=<?php echo $order['express_guoji'] ?>&no=<?php echo $order['kuaiai_on'] ?><?php echo $kuaidi_query ?>" id="<?php echo $order['sid'];?>" href="javascript:void(0);">物流跟踪</a>
              <?php }else if($order['express_guoji']=="西马专线" || $order['express_guoji']=="东马专线" || $order['express_guoji']=="新马专线"){ ?>
              <a onClick="window.open('index.php?route=order/sendorder/track_details&carrier=malay&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a>
              <?php }else if($order['express_guoji']=="澳洲精选线" || $order['express_guoji']=="澳洲专线"){ ?>
              <a onClick="window.open('index.php?route=order/sendorder/track_details&carrier=au&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a>
              <?php }else if($order['express_guoji']=="AIR" || $order['express_guoji']=="SAL水陆联运" || $order['express_guoji']=="EMS"){ ?>
              <a onClick="window.open('index.php?route=order/sendorder/track_details&carrier=chinapost&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a>
              <?php }else{ ?>
              <a onClick="window.open('index.php?route=order/sendorder/track_details&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a> 
              <?php } ?>
            </div>
          </dl>
        </li>
        <?php }else{ ?>
        <li class="dt_weight">
          <dl>
            <?php echo $order['state_name'];?>
          </dl>
        </li>
        <?php }
                   ?>
        <li class="dt_addg">
          <dl>
            ￥<?php echo $order['totalfee'];?>
          </dl>
        </li>
        <li class="dt_addg">
          <dl>
            <?php echo $order['countweight'];?>g
          </dl>
        </li>
        <li class="dt_quxiao br_none">
          <?php if($order['state']==3){?>
          <a class="pay_page ml10" href="javascript:void(0);" onClick='comment(<?php echo $order['sid'];?>)'>去评价</a>
          <?php }elseif ($order['state']==0){ ?>
          <span class="price_total_<?php echo $order['sid'];?>" style="display:none"><?php echo $order['totalfee'];?></span> <a class="pay_page ml10" onClick="singlePay2(<?php echo $order['sid'];?>)" href="javascript:void(0);">去付款</a> <a class="pay_cancle ml10" href="javascript:void(0);" onclick="quxiao(<?php echo $order['sid'];?>)">取消</a>
          <?php }elseif ($order['state']==2){ ?>
          <a class="pay_cancle ml10" href="javascript:void(0);" onclick="Confirm(<?php echo $order['sid'];?>)" >确认收货</a>
          <?php }elseif ($order['state']==6){ ?>
          <a class="pay_page ml10" href="javascript:void(0);" onClick='payback(<?php echo $order['sid'];?>)'>补交差价</a>
          <?php } ?>
          <a class="pay_cancle ml10" href="/index.php?route=order/sendorder/details&sid=<?php echo $order['sid'];?>" target="_blank">运单详情</a> </li>
      </ul>
      <ul class="track_<?php echo $order['sid'];?>" id="track" style="display:none;">
        <li style="margin: 10px 200px;">
          <div class="deliver_info_close_<?php echo $order['sid'];?>" style="display:none;text-align:center;">加载中...</div>
          <div class="deliver_info_<?php echo $order['sid'];?>" ></div>
        </li>
      </ul>
    </div>
    </form>
    <?php }}?>
    <div class="pages_change"><?php echo $pagination; ?></div>
  </div>
  <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <svg xmlns="http://www.w3.org/2000/svg" width="940px" height="940px" viewBox="0 0 80 60" preserveAspectRatio="none" >
    <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
    </svg> </div>
  </div>
</div>
</div>
</section>
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
</script>
</div><div style="clear:both"></div>
<?php echo $footer; ?>
<style>
.rating{
width: 120px;
height: 23px;
position: relative;
z-index: 1000;
}
.rating li{display: inline;}
.redcolor{color:red}
</style>
<div id="popup_box">
  <div class="popup_content">
    <h3 class="comments_head"><span>运单评价</span><a href="javascript:void(0);" class="shutup"></a></h3>
    	<div class="comments_box">	
		
	    <div class="shop-rating">
		
		<span class='title'><label class="redcolor">*</label>对本次服务评价：</span>
			<ul class='rating'>
				<li style="margin-right:6px"><input name="evaluate" type="radio" value="3" ><img src="/images/site/tools/h.png"></li>
				<li style="margin-right:6px"><input name="evaluate" type="radio" value="2" ><img src="/images/site/tools/z.png"></li>
				<li><input name="evaluate" type="radio" value="1" ><img src="/images/site/tools/c.png"></li>
			</ul>
		</div>
<div class="shop-rating">

	<span class="title"><label class="redcolor">*</label>宝贝与描述相符：</span>
	<ul class="rating-level" id="semblance">
		<li><a class="one-star" star:value="1" href="#">1</a></li>
		<li><a class="two-stars" star:value="2" href="#">2</a></li>
		<li><a class="three-stars" star:value="3" href="#">3</a></li>
		<li><a class="four-stars" star:value="4" href="#">4</a></li>
		<li><a class="five-stars" star:value="5" href="#">5</a></li>
	</ul>
	<span class="result" id="semblance-tips"></span>
	<input type="hidden" id="semblance-input" name="semblance" value="" size="2" />
</div>

<!--
	# 星级评分
	# star:value = 分数
-->
<div class="shop-rating">

	<span class="title"><label class="redcolor">*</label>CNstorm服务态度：</span>
	<ul class="rating-level" id="manner">
		<li><a class="one-star" star:value="1" href="#">1</a></li>
		<li><a class="two-stars" star:value="2" href="#">2</a></li>
		<li><a class="three-stars" star:value="3" href="#">3</a></li>
		<li><a class="four-stars" star:value="4" href="#">4</a></li>
		<li><a class="five-stars" star:value="5" href="#">5</a></li>
	</ul>
	<span class="result" id="manner-tips"></span>
	<input type="hidden" id="manner-input" name="manner" value="" size="2" />
</div>

<div class="shop-rating">
	<span class="title"><label class="redcolor">*</label>CNstorm发货速度：</span>
	<ul class="rating-level" id="delivery">
		<li><a class="one-star" star:value="1" href="#">1</a></li>
		<li><a class="two-stars" star:value="2" href="#">2</a></li>
		<li><a class="three-stars" star:value="3" href="#">3</a></li>
		<li><a class="four-stars" star:value="4" href="#">4</a></li>
		<li><a class="five-stars" star:value="5" href="#">5</a></li>
	</ul>
	<span class="result" id="delivery-tips"></span>
	<input type="hidden" id="delivery-input" name="delivery" value="" size="2" />
</div>

<div class="shop-rating">
	<span class="title"><label class="redcolor">*</label>国际运输的时效：</span>
	<ul class="rating-level" id="efficient">
		<li><a class="one-star" star:value="1" href="#">1</a></li>
		<li><a class="two-stars" star:value="2" href="#">2</a></li>
		<li><a class="three-stars" star:value="3" href="#">3</a></li>
		<li><a class="four-stars" star:value="4" href="#">4</a></li>
		<li><a class="five-stars" star:value="5" href="#">5</a></li>
	</ul>
	<span class="result" id="efficient-tips"></span>
	<input type="hidden" id="efficient-input" name="efficient" value="" size="2" />
</div>

<!-- END 星级评分 -->


      <textarea name='comment' id='comment' placeholder="给我们和其它用户留些评价意见吧>.<！"></textarea>
      <input type='hidden' id='sid' name='sid' value=''/>
      <div class="submitt">
        <input type="button" value="提交" />
        <div class="comment">
          <div class="m-sns-write-mood-u-image m-sns-write-mood-show-panel" toggle="image-box"></div>
          <div class="image-box">
            <div class="m-sns-write-mood-pointer image-pointer"></div>
            <div class="u-close" hide='image-box'></div>
            <div class="image-option">
              <div class='image-title'><span>本地上传</span><span id="img_length" style="color: #8c8c8c">还可以上传&nbsp;<em id="number">6</em>&nbsp;张</span></div>
              <div id="add_image_file">
                <iframe id="upfile" name="upfile" src="index.php?route=order/upfile" style="border: none"></iframe>
              </div>
            </div>
          </div>
        </div>
        <span id="comment_notice">优秀长评可额外获赠100积分！</span></div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript" src='catalog/view/javascript/jquery2/grade.js'></script>

<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<script src="catalog/view/javascript/jquery2/upfile.js"></script>
<script src="catalog/view/javascript/jquery2/sns1.js"></script>
<script src="catalog/view/javascript/jquery2/uc_business.js"></script>