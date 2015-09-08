<?php echo $header;?>
<title>账户管理-cnstorm代购的在线充值</title>
<meta name="keywords" content="账户管理, 人民币账户，充值方式，账户充值，支付宝充值，paypal充值，国际信用卡" />
<meta name="description" content="欢迎充值您用支付宝、PAYPAL或国际信用卡充值CNstorm代购平台账户" />
<script type="text/javascript" src="https://irds.alipay.com/merchant/merchant.js"></script>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="user_c_r">
        <div class="daigou_list">
          <div class="dl_head">
            <h3 class="bg12">
              <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
              <?php } ?>
            </h3>
          </div>
          <div class="all_dingdan">
            <div class="online_recharge">
              <div class="gwc_payt"> <span class="zhufu_head">请选择支付平台</span>
                <ul class="zhifu_list">
                  <li><a class="on" href="javascript:void(0);">Paypal</a></li>
                  <li><a href="javascript:void(0);">支付宝</a></li>
                  <li><a href="javascript:void(0);">支付宝国际信用卡</a></li>
                  <li><a href="javascript:void(0);">网银转账</a></li>
                </ul>
                <ul class="paylist paypal">
                  <form target="_blank" action="<?php echo $action;?>" method="post" onsubmit="return paypal_recharge_check()">
                    <li>
                      <h3>您当前选择的支付方式是PayPal</h3>
                    </li>
                    <li class="paypal_infor"><span>Paypal全球最大的在线支付平台，可通过国际信用卡和各国银行卡，实现即时付款！所有使用的货币均以美元进行折算。</span></li>
                    <li class="recharge_sum"><span>充值金额
                      <input type="text" name="amount" id="paypal_recharge" value=""  />
                      美元</span><em>外币充值汇兑损失约为：3%-3.9% </em> </li>
                    <li class="recharge_rmb"><span>实际到账：约￥<b id="paypal_reality"></b>人民币</span><span>当前汇率：￥<b id="paypal_rate"><?php echo round($rate,4); ?></b>美元/人民币</span>
                      <input type="hidden" name="money" id="money" value=""/>
                    </li>
                    <li class="zhifu_btn">
                      <input class="button" type="submit" value="即刻前往支付"/>
                    </li>
                  </form>
                </ul>
                <ul class="paylist zhifubao" style="display:none;">
                  <li>
                    <h3>
                    您当前选择的支付方式是支付宝
                    <h3>
                  </li>
                  <li class="zfb_infor"><span>支付宝(中国)网络技术有限公司是中国领先的独立第三方支付平台，是阿里巴巴集团的关联公司。无论您使用的是何种货币账户，支付宝均以人民币进行折算。</span></li>
                  <li>支付宝无需手续费，推荐使用</li>
                  <li class="recharge_sum"><span>充值金额
                    <input type="text" id="alipay_recharge"  value="" />
                    人民币</span><em> 网关转账损失约为：1% </em></li>
                  <li class="recharge_rmb"><span>实际到账：约￥<b id="alipay_reality"></b>人民币</span></li>
                  <li class="zfb_btn"> <a onclick="payment_alipay()">立即前往支付</a> </li>
                </ul>
                <ul class="paylist credit" style="display:none;">
                  <li class="credit_infor"><span>国际信用卡支付，是由支付宝(中国)网络技术有限公司提供的国际贸易业务支付解决方案。可使用国际通用信用卡进行在线资金支付。</span></li>
                  <li class="credit_click ml10">
                    <ul class="credit_types" id = "credit_types_recharge" >
                      <li value="visa" class="visa after_choose"><a href="javascript:void(0);"></a><i></i></li>
                      <li value="master" class="mastercard"><a href="javascript:void(0);"></a><i></i></li>
                      <li value="jcb" class="jcb"><a href="javascript:void(0);"></a><i></i></li>
                      <input type="hidden" id="credittype" value="visa"/>
                    </ul>
                  </li>
                  <li class="recharge_sum"><span>充值金额
                    <input type="text" id="credit_recharge" value=""  />
                    人民币</span><em>外币充值汇兑损失约为：3%-3.5% </em></li>
                  <li class="recharge_rmb"><span>实际到账：约￥<b id="credit_reality"></b>人民币</span></li>
                  <li class="credit_btn"><a onclick="payment_credit_alipay()">立即前往支付</a></li>
                </ul>
                <ul class="paylist zhifubao" style="display:none;">
                  <li>
                    <h3>
                    您当前选择的支付方式是网银支付
                    <h3>
                  </li>
                  <table class="bank_list" id="recharge_bank_list" style="margin-bottom:20px;margin-left:13px;margin-top:20px;">
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
                  <input type="hidden" id="recharge_defaultbank" name="recharge_defaultbank" value="" />
                  <li>网关转账损失约为：1% </li>
                  <li class="recharge_sum"><span>充值金额
                    <input type="text" id="bank_recharge"  value="" />
                    人民币</span><em> 网关转账损失约为：1% </em></li>
                  <li class="recharge_rmb"><span>实际到账：约￥<b id="bank_reality"></b>人民币</span></li>
                  <li class="zfb_btn"><a onclick = "payment_bank()">立即前往支付</a></li>
                </ul>
                <div class="recharge_question">
                  <h3>充值常见问题</h3>
                  <dl>
                    <dt>1.完成充值需要多久？如何查看状态？ </dt>
                    <dd>答：充值是即时到帐的,当您在支付宝或Paypal完成金额支付后,您的个人帐户上马上就会增加您充值的金额，在您的个人帐户历史中也能看到所有的充值记录。如果您没有看到金额增加，您可以找客服进行反馈。</dd>
                  </dl>
                  <dl>
                    <dt>2.我只有国际信用卡,能不能进行充值？ </dt>
                    <dd>答：能的，您可以使用Paypal进行国际信用卡充值。</dd>
                  </dl>
                  <dl>
                    <dt>3.支付不成功常见原因。</dt>
                    <dd>答：（一）如果支付时您填写的相关信息有误，可能导致银行扣款不成功。</dd>
                    <dd>（二）因为浏览器问题导致支付不成功，您可以尝试先清除浏览器的Cookies，然后再重新支付，如果还是不行，再换另一个浏览器重新登录支付。</dd>
                  </dl>
                </div>
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