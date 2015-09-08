<?php echo $header;?>
<title>找回密码-填写你的邮箱，CNstorm代购为你找回失去的密码</title>
<meta name="keywords" content="海外华人，留学生代购，淘宝用户，找回密码，美国代购，海外华人代购，淘宝代购，留学生代购，国内代购，代购国货，代购中国" />
<meta name="description" content="填写在CNstorm代购注册时的邮箱，然后去邮箱验证你的身份，重置或取回失去的密码服务" />

<div class="login_bg">
   <div class="register wrap">
       <div class="psw_back">
           <h3 class="psw_head"><span>CNstorm安全中心—找回密码</span></h3>
           <div class="psw_conts">
               <span class="pwd_step2"></span>
               <div id="pwd_form" style="display:none;">
                   <form>     
                       <ul class="set_pwd">                  
                           <li class="set_txt">新密码设置成功，</li>
                           <li class="set_txt">请您牢记您新设置的密码。</li>
                           <li>5秒后自动跳转至登录页。<a href="javascript:void(0);">立即登录</a></li>
                       </ul>
                   </form>
               </div> 
               <div id="pwd_form" style="display:none;">
                   <form>                       
                       <p class="login_email">验证邮件已成功发送，请<a href="javascript:void(0);">登录邮箱</a>完成验证</p>
                       <p class="send_email">如果您未收到邮件，请点击<a href="javascript:void(0);">再次发送邮件</a></p>
                       <div class="login_input">
                          <input class="pwd_btn" type="button" value="下一步" />
                       </div> 
                   </form>
               </div> 
               <div id="pwd_form" style="display:block;">
                   <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"> 
                       <p><?php echo $text_email; ?></p>                      
                       <div class="login_input">
                          <span class="login_txt">电子邮箱</span>
                          <?php if ($error_warning) { ?>
                                <div class="warning error_promt"><?php echo $error_warning; ?></div>
                          <?php } ?>
                          <input class="input" type="text" name="email" value="" />
                       </div>
                       <!--
                       <div class="login_input">
                          <span class="login_txt">验证码</span>
                          <input type="text" class="code_letter" value="">
                          <img class="code_pic" src="images/letter.jpg" alt="验证码">
                          <span class="change_code">看不清？<a href="javascript:void(0);">换一张</a></span>
                       </div> 
                       -->
                       <div class="login_input">
                          <input class="pwd_btn" type="submit" value="继续" />
                       </div> 
                   </form>
               </div>            
               <div id="pwd_form" style="display:none;">
                   <form>
                       <p class="new_pwd">您已经验证邮箱，请设置您的新密码！</p>
                       <div class="login_input">
                          <span class="right_promt"></span>
                          <span class="login_txt">新登录密码</span>
                          <input class="input" type="text" value="" />
                       </div> 
                       <p class="pwd_demands">6-32个字符，区分大小写</p>
                       <div class="login_input">
                          <span class="error_promt"><em>二次密码不一致</em></span>
                          <span class="login_txt">确认密码</span>
                          <input class="input" type="text" value="" />
                       </div> 
                       <div class="login_input">
                          <input class="pwd_btn" type="button" value="下一步" />
                       </div> 
                   </form>
               </div>
               <!--
               <dl class="about_pwd">
                 <dt>关于找回密码</dt>
                 <dd>您只要提交您的邮箱地址，然后进入您的邮箱即可找回密码！</dd>
               -->
               </dl>
           </div>
       </div>
   </div>
</div>
<?php echo $footer ;?>