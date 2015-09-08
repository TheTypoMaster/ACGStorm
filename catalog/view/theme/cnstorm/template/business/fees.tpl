<?php echo $header_business; ?>
<title>CNstorm费用—购物、国际转运和商家费用-CNstorm淘国货平台</title>
<style type="text/css">
.f_bn { background: url(https://www.paypalobjects.com/webstatic/en_AU/mktg/wright/sell_instores/sell_instores_hero_bg_1x.jpg) center no-repeat; }
.bd { border-top: 2px solid #f2f2f2; border-bottom: 2px solid #f2f2f2; }
.f_intro { padding: 58px 0; }
.f_intro h1 { text-align: center; font-size: 38px; }
.f_intro .content { padding-top: 38px; display: inline-block; }
.f_intro .content .il { float: left; width: 418px; padding-right: 68px; }
.f_intro .content .ir { max-width:700px;_width:700px;float: left; border-left: 1px solid lightgray; }
.f_intro .content .text { font-size: 15px; color: gray; }
.f_intro .content .ir tr { border-bottom: 1px solid lightgray; display: block; padding: 10px 18px; }
.f_intro .content .ir tr:last-child { border-bottom: 0; }
.f_intro .content .ir th { padding-right: 38px; text-align: left; width: 258px; font-weight: 300; }
.f_intro .content .ir td { vertical-align: top; }
.f_intro .content .ir .fee-intro td { width: 118px; text-align: center; }
.f_intro .content .ir .fee-intro .accpter { border-bottom: 0; font-weight: bold; }
</style>
<body>
<section class="s_banner f_bn mw">
  <div class="wrap">
    <div class="s_intro">
      <h1>费用简单透明</h1>
      <p>永久免收服务费，支付通常无需支付手续费。币种兑换服务只需少许费用。无需支付月费或账户注销费，邮寄一件包裹时才需支付相应费用。</p>
      <p><a href="" target="_blank">了解如何使用</a><a href="javascript:void(pab_go())">了解服务详情</a></p>
	<?php if(!$logged){ ?><a class="reg_btn" href="/index.php?route=account/register" target="_blank">立即注册</a> <?php }else{ ?><a class="reg_btn" href="/order.html">我的CNstorm</a><?php } ?>

       </div>
  </div>
</section>
<section class="f_intro">
  <div class="wrap">
    <h1>购物或付款通常无需手续费</h1>
    <div class="content">
      <div class="il text">
        <p>无论您以何种方式付款，若无需币种兑换，使用CNstorm支付购物款一律免费。将币种兑换费添加到您的购物款之前，我们将始终为您显示已涵盖这笔费用的汇率。</p>
      </div>
      <div class="ir text">
        <table>
          <tbody>
            <tr>
              <th scope="row">购物或付款</th>
              <td>通常无需手续费，币种兑换服务只需少许费用。</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<section class="f_intro bd">
  <div class="wrap">
    <h1>终生服务费全免</h1>
    <div class="content">
      <div class="il text">
        <p>无论代购，国际转运还是国际快递服务，CNstorm都永久免收服务费。我们的费率简单透明，绝无任何隐性费用。您可以使用全球所有主流银行卡付款。当包裹要被发出时，您才需支付费用。</p>
      </div>
      <div class="ir text">
		<table>
          <tbody>
            <tr>
              <th scope="row">代购，国际转运和国际速递</th>
              <td>零服务费的代购采购及转运服务，免费仓储、验货及打包。每个包裹报关费为8元。</td>
            </tr>
          </tbody>
        </table>
		<!--<table class="fee-intro">
          <tbody>
            <tr class="accpter">
              <th scope="row"> </th>
              <td>个人消费者</td>
              <td>商户认证</td>
              <td>学生认证</td>
            </tr>
            <tr>
              <th scope="row">月邮寄金额1500元或以下</th>
              <td>4.3% + 8元</td>
              <td>3.8% + 8元</td>
              <td>免费 + 8元</td>
            </tr>
            <tr>
              <th scope="row">月邮寄金额1,500.01元-5,000元</th>
              <td>3.8% + 8元</td>
              <td>3.3% + 8元</td>
              <td>免费 + 8元</td>
            </tr>
            <tr>
              <th scope="row">月邮寄金额5,000.01元-50,000元</th>
              <td>3.6% + 6元</td>
              <td>3.1% + 6元</td>
              <td>免费 + 8元</td>
            </tr>
            <tr>
              <th scope="row">月邮寄金额50,000.01元及以上</th>
              <td>3.3% + 4元</td>
              <td>2.8% + 4元</td>
              <td>免费 + 8元</td>
            </tr>
          </tbody>
        </table>-->
      </div>
    </div>
  </div>
</section>
<section class="f_intro">
  <div class="wrap">
    <h1>提现</h1>
    <div class="content">
      <div class="il text">
        <p>当您从CNstorm账户提现时，我们可能会从您提现的金额中扣除一笔费用。您可以提现到中国或英国的银行账户或选择其他提现选项。</p>
      </div>
      <div class="ir text">
        <table>
          <tbody>
            <tr>
              <th scope="row">提现至支付源</th>
              <td>免费(充值日起30天内) / 15元(充值日起30天后)</td>
            </tr>
            <tr>
              <th scope="row">电汇至银行账户</th>
              <td>5% * 提现金额</td>
            </tr>
            <tr>
              <th scope="row">提现至支付平台</th>
              <td>5% * 提现金额</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?php echo $footer_business; ?>