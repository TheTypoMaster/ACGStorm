<title>账户安全-设置您的CNstorm账户安全信息</title>     
<meta name="keywords" content="账户管理, cnstorm账户,个人账户，个人设置，账户安全，安全级别" />      
<meta name="description" content="欢迎到cnstrom个人设置中心，修改和设置账户安全信息" />
<?php echo $header;?>


<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="">
        <div class="dl_head">
          <h3 class="bg5">账户安全</h3>
        </div>
        <div class="all_dingdan">
          <div class="discount_safety">
            <p class="safety_level">安全级别：<b>不安全</b><span>建议您通过以下方式提高账户安全性。</span></p>
            <ul class="verify_list">
              <li class="login_pwd"><b>登录密码</b><span>为了保护您账户和资产的安全，请定期修改您的密码。</span><a href="<?php echo $editpassword; ?>">修改</a></li>
              <li class="email_verify"><b>邮箱验证</b><span>验证后，可用于快速找回密码，接受订单处理提醒。</span><a href="<?php echo $checkemail;  ?>">验证</a></li>
            </ul>
            <ol class="warm_prompt">
              <li><b>温馨提示</b></li>
              <li>1.确认您登录的是CNStorm网址http://www.acgstorm.com，注意防范进入钓鱼网站，不要轻信各种即时通讯工具发送的商品或支付链接，谨防网购诈骗。</li>
              <li>2.建议您安装杀毒软件，并定期更新操作系统等软件补丁，确保账户及交易安全。</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $footer ;?>