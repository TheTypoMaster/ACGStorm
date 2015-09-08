<title>代邮寄下单-CNstorm国际供应链为你提供高效国际采购体验</title>
<meta name="keywords" content="代寄服务，代寄订单，代寄列表，订单信息，订单编号，合并订单，快递公司，代寄商品" />
<meta name="description" content="欢迎来到你的代邮寄下单页面，立即开始体验国际供应链服务" />
<?php echo $header_cart; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <ul>
      <a href="order-make.html">
      <li>
        <h2>代采购供应链下单</h2>
      </li>
      </a><a href="order-snatch.html">
      <li>
        <h2>自采购供应链下单</h2>
      </li>
      </a><a href="order-make-order_daiji.html">
      <li class="on">
        <h2>代邮寄供应链下单</h2>
      </li>
      </a>
    </ul>
  </div>
  <div class="br-steps">
    <hr class="step-line">
    <ul class="step-list">
      <li class="step1 reach"> <s class="icon-step"></s>
        <p class="step-intro">提交商品信息</p>
      </li>
      <li class="step2 unreach"> <s class="icon-step"></s>
        <p class="step-intro">等待CNstorm收件</p>
      </li>
      <li class="step3 unreach"> <s class="icon-step"></s>
        <p class="step-intro">质检称重入库</p>
      </li>
      <li class="step3 unreach"> <s class="icon-step"></s>
        <p class="step-intro">提交运输请求</p>
      </li>
      <li class="step4 unreach"> <s class="icon-step"></s>
        <p class="step-intro">海外收货</p>
      </li>
    </ul>
  </div>
  <div id="service-address-daiji" class="box selfpurchase-address-box">
    <div class="address-memo">
      <h4>收件人：<?php echo $customer_name;?></h4>
      <p>收货地址：广东省深圳市宝安区西乡三围航空路30号同安物流园D栋302(信恩世通代寄部)</p>
      <p>邮编：518101&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电话：0755-81466633&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/order-order-order_myhome.html&amp;id=2" target="_blank">使用地址复制工具</a></p>
      <p class="address-tips">代寄时，不要忘记将您的收货地址修改为上面的收货地址哦！</p>
    </div>
  </div>
  <div class="make dj_o">
    <form action="/index.php?route=order/make/daiji_submit" method="post" enctype="multipart/form-data" id="form">
      <div class="dj_list dj_exp"> <span>快递公司:</span>
        <select name="expresses" id="expresses">
          <option value="*">请选择快递公司</option>
          <option value="shunfeng">顺丰快递</option>
          <option value="shentong">申通快递</option>
          <option value="yuantong">圆通快递</option>
          <option value="tiantian">天天快递</option>
          <option value="huitongkuaidi">百世汇通</option>
          <option value="ems">EMS</option>
          <option value="fedex">联邦快递</option>
          <option value="ganzhongnengda">港中能达</option>
          <option value="guotongkuaidi">国通快递</option>
          <option value="quanfengkuaidi">全峰快递</option>
          <option value="yunda">韵达快运</option>
          <option value="zhongtong">中通速递</option>
          <option value="zhaijisong">宅急送</option>
          <option value="youzhengguonei">邮政平邮</option>
          <option value="youshuwuliu">优速物流</option>
        </select>
      </div>
      <div class="dj_list dj_num"> <span>快递单号:</span>
        <input name="express_number" id="express_number" type="text" value="">
        <b class="red nonum">请输入数字！</b> </div>
      <div class="dj_list dj_nam"> <span>包裹名称*: </span>
        <input name="order_daiji_name" id="order_daiji_name" type="text" value="" placeholder="如“家人寄来，朋友寄来”">
        <b class="red nosource">请输入包裹来源！</b></div>
      <div class="dj_list dj_msg"> <span>包裹备注*:</span>
        <textarea name="order_Parcel" id="order_Parcel" placeholder="填写物品清单，如“鞋子38码两双，衬衫L码两件”"></textarea>
        <b class="red nonote">请输入包裹备注！</b> </div>
      <input type="hidden" name="insert_order" value="submit" id="hid">
      <div class="dj_btn">
        <input class="sure_btn" type="button" value="提交订单" onclick="check();">
      </div>
    </form>
  </div>
  <div class="faq">
    <h3><!-- span class="more"><a href="/help.html" target="_blank">More</a></span -->常见问题</h3>
    <div class="list">
      <h4>问：什么是代邮寄产品整合供应链服务？</h4>
      <p><span class="f14"><b>答：</b></span>由客户自行完成供应链环节采购并发货到CNstorm(深圳)仓库，通过CNstorm进行货品验收、整合，实现流向国际的物流运送服务。</p>
    </div>
    <div class="list">
      <h4>问：我只有外币，如何付款？</h4>
      <p><span class="f14"><b>答：</b></span>我们支持Paypal、国外信用卡等多种充值方式(统一以美元结算)，充值成功后，您只需要提交代购的商品网址，由CNstorm为您代购。</p>
    </div>
    <div class="list">
      <h4>问：我代采购的货品，CNstorm会帮我验货吗？</h4>
      <p><span class="f14"><b>答：</b></span>当然会的，这就是我们的工作，瑕疵、店家发错货或者您临时改变主意想退货等等，我们在国内就会帮您处理。</p>
    </div>
  </div>
</div>
</div>
</body>
<?php echo $footer; ?>