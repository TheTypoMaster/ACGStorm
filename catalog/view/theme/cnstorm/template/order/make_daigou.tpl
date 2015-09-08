<?php echo $header; ?>
<title>代购订单-CNstorm代购为你提供代购订单管理</title>     
<meta name="keywords" content="代购服务，代购订单，代购列表，订单信息，订单编号，合并订单，快递公司" />      
<meta name="description" content="欢迎来到你的代购订单页面，对你的代购订单进行删除、合并等管理" />

<style>
.kuaidi {color: #36c}
.circuit{background: url(catalog/view/theme/cnstorm/images/circuit.gif) no-repeat bottom;height: 109px;}
.dg_dingdan img{margin: 18px 0 0 118px;}
</style>
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="daigou_list" style="border:none;">
        <div class="dl_head">
          <h3 class="bg1">代购订单</h3>

        </div>
        <div class="all_dingdan">
          <ul class="dingdan_list">
            <li><a class="on" href="javascript:void(0);">我要代购</a></li>
            <li><a href="index.php?route=order/snatch">我要自助购</a></li>
            <li><a href="index.php?route=order/make/order_daiji">我要代寄</a></li>
          </ul>
          
          <div class="dg_dingdan">
            <div class="circuit">
            <img src="/catalog/view/theme/cnstorm/images/donghua.gif" alt="步骤">
            </div>
            <div class="need_daigou heights">
              <p>
                <input type="text" placeholder="请输入代购商品链接地址" id="procurement_url" value="" class="input_text"/>
                <input type="button" id="procurement" value="获取商品信息" class="input_button"/>
              </p>
            </div>
          </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?> 