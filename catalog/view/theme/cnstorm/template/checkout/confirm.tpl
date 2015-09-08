<?php echo $header_cart; ?>
<title>代购订单-CNstorm代购为你提供代购订单管理</title>
<meta name="keywords" content="代购服务，代购订单，代购列表，订单信息，订单编号，合并订单，快递公司" />
<meta name="description" content="欢迎来到你的代购订单页面，对你的代购订单进行删除、合并等管理" />
<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<script type="text/javascript" src="https://irds.alipay.com/merchant/merchant.js"></script>
<style>
.hide { display: none; }
.bold { font-weight: bold; }
.orderFail { color: red; }
</style>
<script type="text/javascript">
var _mvq = _mvq || [];
_mvq.push(['$setAccount', 'm-92402-0']);
_mvq.push(['$setGeneral', 'checkout', '', /*用户名*/ '', /*用户id*/ Math.random()]);
_mvq.push(['$logConversion']);
_mvq.push(['$addCartGoods',/*商品id*/ '',/*商品名称*/ '', /*商品价格*/ '', /*商品数量*/ '']);
_mvq.push(['$logData']);
</script>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center">
      <div class="gwc_steps">
        <div class="gwc_step_one ml10">
          <div class="steps_nav">
            <ul class="regnav step3">
              <li class="text1">获取商品信息</li>
              <li class="text2">核对购物车商品</li>
              <li class="text3">成功提交订单</li>
            </ul>
          </div>
          <div class="gwc_goods ml10">
            <dl class="gwc_dingdan">
              <dt>
                <h3>代购订单已成功提交，请尽快完成支付！</h3>
              </dt>
              <dd>代购订单号：<em id="single_oid">
                <?php if(isset($order_id))  echo $order_id ; ?>
                </em></dd>
              <input type="hidden" id="order_id" value="<?php echo implode(':',$order_id_array) ;?>"/>
              <?php if(isset($sigle_pay)) { ?>
              <input type="hidden" id="isonly" value="<?php echo $single_pay ; ?>"/>
              <?php } ?>
              <dd class="border_bot">应付金额：￥<b><?php echo round($total_money,2); ?></b></dd>
            </dl>
            <div class="gwc_payo">
              <div class="radio" id="radio1">
                <input type="radio" name="payoff" id="Accountpay" onClick="Slectpay()" />
                账户余额支付</div>
              <div class="avilable_yue border_bot hide"><span>可用余额：￥<b><?php echo number_format($money,2) ; ?></b></span><a href="javascript:void(0);" onClick="Border('<?php echo $total_money; ?>','<?php echo $money;?>','<?php echo $type; ?>')">确认支付</a><span class="orderFail hide" id="notpaid">账户余额不足！请使用第三方支付</span>
			  <span class="orderFail hide" id="notanswer">服务器繁忙 请稍后再试</span></div>
            </div>
            <div class="gwc_payt">
              <div class="bold radio" id="radio2">
                <input type="radio" name="payoff" id="Thirdpay" onClick="Slectpay()" checked="checked"/>
                第三方支付</div>
              <div class="Thirdpay"> <span class="zhufu_head">请选择支付平台</span>
                <ul class="zhifu_list">
                  <li><a class="on" href="javascript:void(0);">Paypal</a></li>
                  <li><a href="javascript:void(0);">支付宝</a></li>
                  <li><a href="javascript:void(0);">支付宝国际信用卡</a></li>
                  <li><a href="javascript:void(0);">网银转账</a></li>
                </ul>
                <ul class="paylist paypal">
                  <li>
                    <h3>您当前选择的支付方式是PayPal</h3>
                  </li>
                  <li class="paypal_infor"><span>Paypal全球最大的在线支付平台，可通过国际信用卡和各国银行卡，实现即时付款！所有使用的货币均以美元进行折算。</span></li>
                  <li>外币汇兑损失约为：3%-3.9%</li>
                  <li class="cur_rates">当前汇率：<?php echo round($rate,4); ?> 美元/人民币</li>
                  <li class="costs">您实际应支付金额：<b>$<?php echo round($total_money*$rate*1.039,2); ?></b> </li>
                  <li class="zhifu_btn"><?php echo $paypal;?></li>
                </ul>
                <ul class="paylist zhifubao" style="display:none;">
                  <li>
                    <h3>
                    您当前选择的支付方式是支付宝
                    <h3>
                  </li>
                  <li class="zfb_infor"><span>支付宝(中国)网络技术有限公司是中国领先的独立第三方支付平台，是阿里巴巴集团的关联公司。无论您使用的是何种货币账户，支付宝均以人民币进行折算。</span></li>
                  <li>网关转账损失约为：1% </li>
                  <li class="costs">您实际应支付金额：<b>￥<?php echo number_format($total_money*(1+0.01+0.000001),2); ?></b></li>
                  <li class="zfb_btn"><a onclick = "order_alipay()">立即前往支付</a></li>
                </ul>
                <ul class="paylist credit" style="display:none;">
                  <li class="credit_infor"><span>国际信用卡支付，是由支付宝(中国)网络技术有限公司提供的国际贸易业务支付解决方案。可使用国际通用信用卡进行在线资金支付。</span></li>
                  <li>
                    <h3>选择您的信用卡类型</h3>
                  </li>
                  <li class="credit_click ml10">
                    <ul class="credit_types" id="type_credit_order" value="visa">
                      <li value="visa" class="visa after_choose"><a href="javascript:void(0);"></a><i></i></li>
                      <li value="master" class="mastercard"><a href="javascript:void(0);"></a><i></i></li>
                      <li value="jcb" class="jcb"><a href="javascript:void(0);"></a><i></i></li>
                      <input type="hidden" id="typecredit_order" value="visa"/>
                    </ul>
                  </li>
                  <li class="extra_mon">外币汇兑损失约为：3%-3.5%</li>
                  <li class="cur_rates">当前汇率：<?php echo round($rate,4); ?> 美元/人民币</li>
                  <li class="all_mon">您实际应支付金额：<b>￥<?php echo round($total_money*(1+0.035),2); ?></b> </li>
                  <li class="credit_btn"><a onclick="order_alipay_credit()">立即前往支付</a></li>
                </ul>

                  <ul class="paylist zhifubao" style="display:none;">
                  <li>
                    <h3>
                    您当前选择的支付方式是网银支付
                    <h3>
                  </li>

   
                  <table class="bank_list" id="order_bank_list" style="margin-bottom:20px;margin-left:13px;margin-top:20px;">
                    <tbody>
                      <tr>
                        <td><input id="icbcb2c" type="radio" value="icbcb2c" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-1px -1px" for="icbcb2c"></label></td>
                        <td><input id="cmb" type="radio" value="cmb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -1px" for="cmb"></label></td>
                        <td><input id="ccb" type="radio" value="ccb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-321px -1px" for="ccb"></label></td>
                        <td><input id="bocb2c" type="radio" value="bocb2c" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-481px -1px" for="bocb2c"></label></td>
                      </tr>
                      <tr>
                        <td><input id="abc" type="radio" value="abc" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-1px -52px" for="abc"></label></td>
                        <td><input id="comm" type="radio" value="comm" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -52px" for="comm"></label></td>
                        <td><input id="psbc-debit" type="radio" value="psbc-debit" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-321px -52px" for="psbc-debit"></label></td>
                        <td><input id="ceb-debit" type="radio" value="ceb-debit" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-481px -52px" for="ceb-debit"></label></td>
                      </tr>
                      <tr>
                        <td><input id="spdb" type="radio" value="spdb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-1px -103px" for="spdb"></label></td>
                        <td><input id="gdb" type="radio" value="ceb-debit" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -103px" for="gdb"></label></td>
                        <td><input id="citic" type="radio" value="citic" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-321px -103px" for="citic"></label></td>
                        <td><input id="cib" type="radio" value="cib" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-481px -103px" for="cib"></label></td>
                      </tr>
                      <tr>
                        <td><input id="cmbc" type="radio" value="cmbc" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -154px" for="cmbc"></label></td>
                        <td><input id="bjbank" type="radio" value="bjbank" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-321px -154px" for="bjbank"></label></td>
                        <td><input id="hzcbb2c" type="radio" value="hzcbb2c" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-481px -154px" for="hzcbb2c"></label></td>
                        <td><input id="shbank" type="radio" value="shbank" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-1px -205px" for="shbank"></label></td>
                      </tr>
                      <tr>
                        <td><input id="bjrcb" type="radio" value="bjrcb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -205px" for="bjrcb"></label></td>
                        <td><input id="spabank" type="radio" value="spabank" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-321px -205px" for="spabank"></label></td>
                        <td><input id="fdb" type="radio" value="fdb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-481px -205px" for="fdb"></label></td>
                        <td><input id="wzcbb2c-debit" type="radio" value="wzcbb2c-debit" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-1px -256px" for="wzcbb2c-debit"></label></td>
                      </tr>
                      <tr>
                        <td><input id="nbbank" type="radio" value="nbbank" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -256px" for="nbbank"></label></td>
                        <td><input id="ccbbtb" type="radio" value="ccbbtb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-481px -256px" for="ccbbtb"></label></td>
                        <td><input id="spdbb2b" type="radio" value="spdbb2b" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-1px -307px" for="spdbb2b"></label></td>
                        <td><input id="abcbtb" type="radio" value="abcbtb" name="bank" style="float:left;"/>
                          </input>
                          <label style="background-position:-161px -307px" for="abcbtb"></label></td>
                      </tr>
                    </tbody>
                  </table>
                  <input type="hidden" id="order_defaultbank" name="order_defaultbank" value="" />
                  <li>网关转账损失约为：1% </li>
                  <li class="costs">您实际应支付金额：<b>￥<?php echo round($total_money*(1+0.01+0.000001),2); ?></b></li>
                  <li class="zfb_btn"><a onclick = "order_bank()">立即前往支付</a></li>
                </ul>   
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="pdllg_box" style="display:none">
  <div class="dlg_box_one">
    <div class="ui-dialog-titlebar" > <span  class="ui-dialog-title">温馨提示</span> </div>
    <div  style="margin: 46px;font-size:25px;"  id="dlg_box_contents">正在支付中，请稍候</div>
  </div>
  <div class="popup_shadow"></div>
</div>

<?php echo $footer; ?> 
