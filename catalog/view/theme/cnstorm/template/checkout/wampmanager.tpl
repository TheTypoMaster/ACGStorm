<?php echo $header; ?>
<style>
.hide {
	display: none;
}
.bold {
	font-weight: bold;
}
.orderFail {
	color: red;
}
</style>
<div class="goods_details_bg">
    <div class="yhzx wrap">
        <div class="user_center">
      <div class="gwc_steps">
          <div class="gwc_step_one ml10">
              <div class="steps_nav">
                  <ul class="regnav step3">
                      <li class="text1">确认收件信息</li>
                      <li class="text2">核对邮寄商品</li>
                      <li class="text3">成功提交运单</li>
                  </ul>
              </div>
              <div class="gwc_goods ml10">
                  <dl class="gwc_dingdan">
              <dt>
                <h3>国际运单已成功提交，请尽快完成支付！</h3>
              </dt>
              <dd>国际运单号：<em id="single_oid"><?php echo $order_id ; ?></em></dd>
              <input type="hidden" id="order_id" value="<?php echo implode(':',$order_id_array) ;?>"/>
              <input type="hidden" id="isonly" value="<?php echo $single_pay ; ?>"/>
              <dd class="border_bot">应付金额：￥<b><?php echo number_format($total_money,2); ?></b></dd>
            </dl>
            <div class="gwc_payo">
              <div class="radio" id="radio1">
                <input type="radio" name="payoff" id="Accountpay" onClick="Slectpay()" />
                账户余额支付</div>
              <div class="avilable_yue border_bot hide"><span>可用余额：￥<b><?php echo number_format($money,2) ; ?></b></span><a href="javascript:void(0);" onClick="Border('<?php echo number_format($total_money,2); ?>','<?php echo number_format($money,2) ; ?>')">确认支付</a><span class="orderFail hide" id="notpaid">账户余额不足！请使用第三方支付</span></div>
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
                </ul>
                <ul class="paylist paypal">
                  <li>
                    <h3>您当前选择的支付方式是PayPal</h3>
                  </li>
                  <li class="paypal_infor"><span>Paypal全球最大的在线支付平台，可通过国际信用卡和各国银行卡，实现即时付款！所有使用的货币均以美元进行折算。</span></li>
                  <li>外币汇兑损失约为：3%-3.9%</li>
                  <li class="cur_rates">当前汇率：<?php echo round($rate,4); ?> 美元/人民币</li>
                  <!--<li class="costs">您实际应支付金额：<b>$<?php echo number_format(($total_money*$rate)*(1+0.039),2); ?></b> </li>-->
                  <li class="costs">您实际应支付金额：<b>$<?php echo number_format($paypal_total,2); ?></b> </li>
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
                  <li class="zfb_btn"><?php echo $alipay; ?></li>
                </ul>
                <ul class="paylist credit" style="display:none;">
                  <li class="credit_infor"><span>国际信用卡支付，是由支付宝(中国)网络技术有限公司提供的国际贸易业务支付解决方案。可使用国际通用信用卡进行在线资金支付。</span></li>
                  <li>
                    <h3>选择您的信用卡类型</h3>
                  </li>
                  <li class="credit_click ml10">
                    <ul class="credit_types" id="type_credit">
                      <li value="visa" class="visa after_choose"><a href="javascript:void(0);"></a><i></i></li>
                      <li value="master" class="mastercard"><a href="javascript:void(0);"></a><i></i></li>
                      <li value="jcb" class="jcb"><a href="javascript:void(0);"></a><i></i></li>
                      <input type="hidden" id="typecredit" value="visa"/>
                    </ul>
                  </li>
                  <li class="extra_mon">外币汇兑损失约为：3%-3.5%</li>
                  <li class="cur_rates">当前汇率：<?php echo round($rate,4); ?> 美元/人民币</li>
                  <li class="all_mon">您实际应支付金额：<b>￥<?php echo number_format($total_money*(1+0.035),2); ?></b> </li>
                  <li class="credit_btn"><a onclick="alipay_credit()">立即前往支付</a></li>
                </ul>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>