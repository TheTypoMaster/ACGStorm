<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/business.css">
<link href="catalog/view/theme/cnstorm/stylesheet/default-footer-page.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<style type="text/css">
.mr6 { margin-right: 6px; }
.nav-pab { background: #FF7F67; height: 138px; display: none; }
.nav-pab .nav-pab-wrap { width: 800px; margin: 0 auto; }
.nav-pab .nav-pab-wrap ul { margin: 29px 0; text-align: center; float: left; }
.nav-pab .nav-pab-wrap ul:first-child { border-right: 1px solid rgb(229, 229, 229); width: 398px; }
.nav-pab .nav-pab-wrap ul:last-child { width: 318px; }
.nav-pab .wrap .unpab { float: right; font-size: 25px; margin: 16px 0; }
.nav-pab .wrap .unpab a { color: rgba(255, 255, 255, 0.38); }
.nav-pab ul li { color: white; font-size: 16px; line-height: 38px; }
</style>
<script type="text/javascript">
    function pab_go() { 
        $(".nav-pab").slideToggle();
    }
</script>
</head>
<body>
<section class="top-wrap">
  <div class="nav wrap"><a href="./"><img src="logo.png" width=168px></a>
    <nav><a href="/"><?php echo $text_home; ?></a><a href="javascript:void(pab_go())"><?php echo $text_serviceAndPrice; ?></a><a href="/social.html">社区签到</a><a href="business-main-press.html"><?php echo $text_mediaReports; ?></a><a href="help-aboutus.html"><?php echo $text_aboutUs; ?></a></nav>
    <div class="login-header">
      <div class="input-wrapper"> 
        <!-- input type="text" title="请输入有效的账户名或密码" placeholder="账户名或密码" class="login-info">
        <!-- div class="input-link"> <a title="忘记电子邮件地址了" class="input-button passwordRecovery" id="passwordRecovery1" href="#">忘记电子邮件地址了</a> </div --> 
        <!-- input type="password" placeholder="密码" title="请输入正确密码" class="login-info" --> 
        <!--  div class="input-link"> <a title="忘记密码了？" class="passwordRecovery" href="#">忘记密码了？</a> </div -->
        <?php if (!$logged) { ?>
        <a href="account-login.html&source=b" class="top-btn login"><?php echo $text_login; ?></a> <a href="account-register.html" class="top-btn reg"><?php echo $text_register; ?></a>
        <?php } else { ?>
        <a href="order.html" class="top-btn login mr6"><?php echo $text_logged; ?></a><?php if (!$business) { ?><!-- a href="/index.php?route=account/merchant" class="top-btn login mr6">申请商户认证</a --><?php } ?><a href="account-logout.html" class="top-btn reg"><?php echo $text_logout; ?></a>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="nav-pab">
    <div class="wrap">
      <div class="nav-pab-wrap">
        <ul>
          <a href="/index.php?route=business/service">
          <li>采购与产品整合供应链服务</li>
          </a> <a href="/index.php?route=business/service/self">
          <li>自助型产品整合供应链服务</li>
          </a>
        </ul>
        <ul>
          <a href="/index.php?route=business/service/fees">
          <li>费用明细</li>
          </a>
        </ul>
      </div>
      <span class="unpab"><a href="javascript:void($('.nav-pab').slideUp())">X</a></span> </div>
  </div>
</section>