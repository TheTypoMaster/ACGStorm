<title>代采购下单-CNstorm国际供应链为你提供高效国际采购体验</title>
<meta name="keywords" content="国际运单服务, 国际运单，运单列表，运单信息，运单编号，合并运单，快递公司，转运公司，国际转运，转运中国，中国转运，中国运输，海外转运" />
<meta name="description" content="欢迎来到你的代采购下单页面，立即开始体验国际供应链服务" />
<?php echo $header_cart; ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <ul>
      <a href="order-make.html">
      <li class="on">
        <h2>代采购供应链下单</h2>
      </li>
      </a><a href="order-snatch.html">
      <li>
        <h2>自采购供应链下单</h2>
      </li>
      </a><a href="order-make-order_daiji.html">
      <li>
        <h2>代邮寄供应链下单</h2>
      </li>
      </a>
    </ul>
  </div>
  <div class="br-steps">
    <hr class="step-line">
    <ul class="step-list">
      <li class="step1 reach"> <s class="icon-step"></s>
        <p class="step-intro">提交采购请求</p>
      </li>
      <li class="step2 unreach"> <s class="icon-step"></s>
        <p class="step-intro">供应商采购</p>
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
  <div class="make">
    <input type="text" placeholder="请输入代购商品链接地址" id="procurement_url" value="" class="input_text">
    <input type="button" id="procurement" value="获取商品信息" class="input_button">
  </div>
  <div class="faq">
    <h3><!-- span class="more"><a href="help.html" target="_blank">More</a></span -->常见问题</h3>
    <div class="list">
      <h4>问：什么是采购与产品整合供应链服务？</h4>
      <p><span class="f14"><b>答：</b></span>从电商网站、实体商家等供应链环节采购，并对货品进行验货整合及打包发送，为客户提供高度定制的中国商品供应链服务。</p>
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
</div>
</body>
<script type="text/javascript">    
$('#procurement').bind('click',
            function() {
                var search = $.trim(document.getElementById("procurement_url").value);
                //_CWiQ.push(['_trackReg', 1]);
                url = 'index.php?route=product/snatch';
                url += '&search=' + encodeURIComponent(search);
                location = url;
            });
</script>
<?php echo $footer; ?>