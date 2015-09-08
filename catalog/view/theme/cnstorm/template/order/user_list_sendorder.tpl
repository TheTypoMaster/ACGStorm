<title>国际运单-CNstorm国际转运为你提供国际运单管理</title>
<meta name="keywords" content="国际运单服务, 国际运单，运单列表，运单信息，运单编号，合并运单，快递公司，转运公司，国际转运，转运中国，中国转运，中国运输，海外转运" />
<meta name="description" content="欢迎来到你的国际运单页面，对你的运输订单状态进行管理" />
<?php echo $header; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/sns.css" />
<script src="catalog/view/javascript/jquery2/upfile.js"></script>
<script src="catalog/view/javascript/jquery2/sns1.js"></script>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="user_c_r">
        <div class="inter_orders">
          <div class="dl_head">
            <h3 class="bg2">国际运单</h3>
          </div>
         
          <div class="dl_h_input">
            <input id="search_key" type="text" value="请输入关键字进行搜索" class="search_box" value="<?php echo $consignee ;?>" />
            <input type="button" value="" class="search_btn" onclick="aaa()" />
            <a href="javascript:void(0);" class="searchbox_a">按时间范围搜索</a> </div>
          <div class="dl_t_input left" style="display:none;">
            <input type="text" value="起始时间" class="time_search" />
            <em>~</em>
            <input type="text" value="结束时间" class="time_search" />
            <input type="button" value="" class="search_btn" />
            <a href="javascript:void(0);" class="searchbox_a">按关键字搜索</a> </div>
          <div id="dvContent" style="position:relative;">
            <div class="dg_dingdan">
              <ul class="detail_dd">
                <li class="detail_o">订单信息</li>
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
              <form id="waybillbatch_pay_form" action="/index.php?route=checkout/confirm/sendorder" method="post" />
              
              <ul class="detail_dd bg_none">
                <li class="detail_o pay_all">
                  <input type="checkbox" name="SelectAll_front" class="SelectAll_front check" id="SelectAll_front">
                  <label>全选</label>
                </li>
                <li class="detail_t pay_click">
                  <input type="button" onclick="HasWaybill()" value="合并支付"/>
                </li>
                <input type="hidden" name="waybillbatch_pay" id="waybillbatch_pay"  value="" />
              </ul>
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
                  <span class="dd_code"><em>订单编号：</em><?php echo $order['sid'];?></span><span class="dd_time"><em>时间：</em><?php echo date("Y-m-d H:i:s",$order['addtime']);?></span></p>
                <ul class="dingdan_table">
                  <li class="dt_infor bag_name">
                    <dl>
                      <dt>收件人：<?php echo $order['consignee'];?></dt>
                      <!--
                                          <dd class="wait_pay"><em>备注：</em><input type="text" value="请输入您的特殊需求。" id="beizhu_in"><input type="button" value="修改" id="beizhu_correct"></dd>-->
                    </dl>
                  </li>
                  <li class="dt_weight" id="carrier<?php echo $order['sid'];?>"><?php echo $order['express_guoji'];?></li>
                  <li class="dt_weight" id="sn<?php echo $order['sid'];?>"><?php echo $order['kuaiai_on'];?></li>
                  <li class="dt_weight"><?php echo $order['country'];?></li>
                  <?php if($order['kuaiai_on']!='' && $order['state_name']=='已邮寄'){?>
                  <li class="dt_express dt_express_2"> <span class="dt_comp"><?php echo $order['state_name'];?></span>
                    <div class="wl_follow">
                      <?php if($order['express_guoji']=="DHL"){?>
                      <a onClick="window.open('index.php?route=order/order/track_details&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a>
                      <?php }else if($order['express_guoji']=="西马专线" || $order['express_guoji']=="东马专线" || $order['express_guoji']=="澳洲专线"){ ?>
                      <a onClick="window.open('index.php?route=order/order/track_details&carrier=malay&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a>
                      <?php }else if($order['express_guoji']=="AIR" || $order['express_guoji']=="SAL水陆联运" || $order['express_guoji']=="EMS"){ ?>
                      <a onClick="window.open('index.php?route=order/order/track_details&carrier=chinapost&sn=<?php echo $order['kuaiai_on'];?>')" href="javascript:void(0);">物流跟踪</a>
                      <?php }else{ ?>
                      <a onClick="kuaidi(<?php echo $order['sid'];?>)" url="/index.php?route=order/order/track&expreser=<?php echo $order['express_guoji'] ?>&no=<?php echo $order['kuaiai_on'] ?><?php echo $kuaidi_query ?>" id="<?php echo $order['sid'];?>" href="javascript:void(0);">物流跟踪</a>
                      <?php } ?>
                    </div>
                  </li>
                  <?php }else{ ?>
                  <li class="dt_weight"><?php echo $order['state_name'];?></li>
                  <?php }
                   ?>
                  <li class="dt_addg">￥<?php echo $order['totalfee'];?></li>
                  <li class="dt_addg"><?php echo $order['countweight'];?>g</li>
                  <li class="dt_quxiao br_none">
                    <?php if($order['state']==3){?>
                    <a class="pay_page ml10" href="javascript:void(0);" onClick='comment(<?php echo $order['sid'];?>)'>去评价</a>
                    <?php }elseif ($order['state']==0){ ?>
                    <span class="price_total_<?php echo $order['sid'];?>" style="display:none"><?php echo $order['totalfee'];?></span> <a class="pay_page ml10" onClick="singlePay2(<?php echo $order['sid'];?>)" href="javascript:void(0);">去付款</a> <a class="pay_cancle ml10" href="javascript:void(0);" onclick="quxiao(<?php echo $order['sid'];?>)">取消</a>
                    <?php }elseif ($order['state']==2){ ?>
                    <a class="pay_cancle ml10" href="javascript:void(0);" onclick="Confirm(<?php echo $order['sid'];?>)" >确认收货</a>
                    <?php }elseif ($order['state']==6){ ?>
                    <!--a class="pay_page ml10" href="javascript:void(0);" onClick='payback(<?php echo $order['sid'];?>)'>补交差价</a-->
                    <a class="pay_cancle ml10" href="javascript:void(0);" onClick='changedelivery(<?php echo $order['sid'];?>)'>变更快递</a>
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
          <!-- /dvContent --> 
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="changedelivery_box" id="changedelivery_box" style="display:none">
  <div class="changedelivery_content">
  <h3 class="content_head"><span>变更运输方式</span><a href="javascript:void(0);" class="shutup"></a></h3>
  <div class="content_box">
    <section class="carrier" id="de_carrier">
    </section>
  </div>
  </div>
  <div class="changedelivery_shadow"></div>
</div>


<div id="popup_box">
  <div class="popup_content">
    <h3 class="comments_head"><span>运单评价</span><a href="javascript:void(0);" class="shutup"></a></h3>
    <div class="comments_box">
      <textarea name='comment' id='comment' placeholder="给我们和其它用户留些评价意见吧>.<！"></textarea>
      <input type='hidden' id='sid' name='sid' value=''/>
      <div class="submitt">
        <input type="button" value="提交" />
        <div class="comment">
          <div class="m-sns-write-mood-u-image m-sns-write-mood-show-panel" toggle="image-box" style="margin-top:8px;"></div>
          <div class="image-box">
            <div class="m-sns-write-mood-pointer image-pointer"></div>
            <div class="u-close" hide='image-box'></div>
            <div class="image-option">
              <div class='image-title'> <span>本地上传 </span><span id="img_length" style="color: #8c8c8c">还可以上传&nbsp;<em id="number">6</em>&nbsp;张 </span> </div>
              <div id="add_image_file">
                <iframe id="upfile" name="upfile" src="index.php?route=order/upfile" style="border: none"></iframe>
              </div>
            </div>
          </div>
        </div>
        <span id='comment_notice'></span></div>
    </div>
  </div>
</div>

</div>
<div class="popup_shadow"></div>
<script language="javascript" src="catalog/view/javascript/jquery2/waybillbatch.js"></script> 
<script src="catalog/view/javascript/pl/js/classie.js"></script> 
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script>