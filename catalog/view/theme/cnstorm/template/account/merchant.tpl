<title>商户认证申请-CNstorm淘国货平台</title>
<meta content="CNstorm代购是全球知名专业的海外留学生、海外华人代购网站，为海外华人及海外留学生提供淘宝、当当、卓越亚马逊、Ebay等国内购物网站商品代购服务，而且提供可多币种支付的中国商品购买及送货上门服务" name="Description">
<meta content="CNstorm代购，代购网站，代购公司，留学生代购，海外华人代购，海外华侨代购，海外代购，淘宝代购，TaoBao代购，卓越代购，京东代购，英国代购，daigou " name="Keywords">
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<?php echo $header_business; ?>
<style type="text/css">
.error { display: none; }
.all_dingdan .address_list strong { font-size: 16px; line-height: 20px; }
.all_dingdan .address_list .sale_mode { float: left; }
.all_dingdan .address_list .sale_mode input { float: left; margin-top: 5px; }
.all_dingdan .address_list .sale_mode .small { float: none !important; padding: 6px; }
</style>
<script type="text/javascript">
	function chkForm(){

	}
</script>
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>商户认证申请</h2>
  </div>
  <div class="all_dingdan">
    <p class="add_address">新增商户（为了保证申请能快速通过，请务必准确填写）</p>
    <form id="post_address" action="/index.php?route=account/merchant/apply" method="post" onsubmit="chkForm(this)">
      <div class="address_list"><span><em>*</em>用户名：</span> <strong><?php echo $customer_name; ?></strong> <span class="error">error</span> </div>
      <div class="address_list"> <span><em>*</em>商家类型：</span>
        <select name="biz_type">
          <option value="">— 请从下列选择一项 —</option>
          <option value="1">个人——非企业</option>
          <option value="2">个体经营</option>
          <option value="3">合伙经营</option>
          <option value="4">公司</option>
          <option value="5">LLC</option>
          <option value="6">非盈利组织</option>
        </select>
        <span class="error">error</span> </div>
      <div class="address_list"> <span><em>*</em>行业：</span>
        <select id="company_industry" name="company_industry" class="" onchange="">
          <option value="0">－ 选择分类 －</option>
          <option value="1003">书籍和杂志</option>
          <option value="1004">企业对企业</option>
          <option value="1021">体育和户外活动</option>
          <option value="1014">保健和个人护理</option>
          <option value="1001">儿童用品</option>
          <option value="1009">娱乐和媒体</option>
          <option value="1018">宗教和教会（盈利性）</option>
          <option value="1017">宠物和动物</option>
          <option value="1015">家居和庭院用品</option>
          <option value="1013">政府</option>
          <option value="1007">教育</option>
          <option value="1023">旅游</option>
          <option value="1020">服务——其他</option>
          <option value="1005">服装、饰品和鞋子</option>
          <option value="1022">玩具和业余爱好</option>
          <option value="1008">电器和电信</option>
          <option value="1012">礼品和鲜花</option>
          <option value="1002">美容用品和香薰</option>
          <option value="1000">艺术品、工艺品和收藏品</option>
          <option value="1006">计算机、配件和服务</option>
          <option value="1025">车辆服务和零配件</option>
          <option value="1024">车辆销售</option>
          <option value="1010">金融服务和产品</option>
          <option value="1019">零售（未归类）</option>
          <option value="1016">非营利组织</option>
          <option value="1011">食品零售和服务</option>
        </select>
        <span class="error">error</span> </div>
      <div class="address_list"><span>网站 URL：（如果适用）</span>
        <textarea placeholder="请输入详细的网站 URL（如果适用）" name="website_url"></textarea>
        <span class="error">error</span> </div>
      <div class="address_list" style="overflow: hidden;"><span><em>*</em>出售地点：</span>
        <ul class="sale_mode">
          <li>
            <input type="checkbox" name="loc[]" value="1">
            <span class="small">在线竞拍网站</span></li>
          <li>
            <input type="checkbox" name="loc[]" value="2">
            <span class="small">商业网站</span></li>
          <li>
            <input type="checkbox" name="loc[]" value="3">
            <span class="small">实体店铺</span></li>
          <li>
            <input type="checkbox" name="loc[]" value="4">
            <span class="small">住宅/办公室</span></li>
        </ul>
        <span class="error">error</span> </div>
      <div class="address_list">
        <input class="submit" value="提交" type="submit" />
        <em>温馨提示：满足<a href="/index.php?route=business/service/fees" target="_blank"><b>商户条件</b></a>用户将被审核通过</em></div>
    </form>
  </div>
</div>
</div>
</section>
</body>
<?php echo $footer_business; ?>