<?php echo $header;?>
<title>个人设置-在账户安全里修改您的CNstorm账户密码</title>     
<meta name="keywords" content="账户管理, CNstorm账户,个人账户，个人设置，账户安全，修改密码，验证密码" />      
<meta name="description" content="欢迎到CNstrom账户安全中心，修改和设置账户安全密码信息" />
<div class="goods_details_bg">
  <div class="yhzx wrap">
      <div class="user_center">          
          <?php echo $column_left ;?>
          <div class="user_c_r">
              <div class="daigou_list">
                  <div class="dl_head"><h3 class="bg5">
                     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                     <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                     <?php } ?></h3>                      
                  </div>
                  <div class="all_dingdan">
                     <div class="discount_safety">
                          <form id="safety_pwd" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">                             
                             <div class="login_input">                   
                                <span class="login_txt">当前密码：</span>
                                <input type="password" placeholder="请输入原密码" name="oldpassword" value="<?php echo $oldpassword; ?>" class="input" />
                                <?php if ($error_oldpassword) { ?>
                                <span class="error"><?php echo $error_oldpassword; ?></span>
                                <?php } ?>
                             </div>
                             <div class="login_input">
                                <span class="login_txt">输入密码：</span>
                                <input type="password" placeholder="6-20位字符之间" name="password" value="<?php echo $password; ?>" class="input" />
                                <?php if ($error_password) { ?>
                                <span class="error"><?php echo $error_password; ?></span>
                                <?php } ?>
                             </div>
                             <div class="login_input">
                                <span class="login_txt">确认密码：</span>
                                <input type="password" placeholder="请再次输入密码" name="confirm" value="<?php echo $confirm; ?>" class="input" />
                                <?php if ($error_confirm) { ?>
                                <span class="error"><?php echo $error_confirm; ?></span>
                                <?php } ?>
                             </div>
                             <!--
                             <div class="login_input">
                                <span class="login_txt">验证码：</span>
                                <input type="text" class="code_letter" value="请入验证码" />
                                <img class="code_pic" src="images/letter.jpg" alt="验证码" title="验证码">
                                <span class="change_code"><em>看不清？</em><a href="javascript:void(0);">换一张</a></span>
                             </div>
                             -->
                             <div class="login_input"><input type="submit" class="reg_btn" value="提交"/></div>
                        </form>
                     </div>              
                  </div>              
              </div>
          </div>
      </div>
   </div>
</div>
<?php echo $footer ;?>