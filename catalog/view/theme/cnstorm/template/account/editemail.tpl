<?php echo $header;?>
<title>个人设置-修改登录cnstorm账户邮箱</title>     
<meta name="keywords" content=" 账户管理, cnstorm账户,个人账户，账户邮箱，修改邮箱，账户安全" />      
<meta name="description" content="在cnstrom账户安全中心，可以修改您登录cnstorm账户邮箱 " />

<div class="goods_details_bg">
  <div class="yhzx wrap">
      <div class="user_center">          
          <?php echo $column_left ;?>
          <div class="user_c_r">
              <div class="daigou_list">
                  <div class="dl_head">
                      <h3 class="bg5"><?php foreach ($breadcrumbs as $breadcrumb) { ?>
                     <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                     <?php } ?></h3>                      
                  </div>
                  <div class="all_dingdan">
                     <div class="discount_safety">
                          <div class="change_email">
                              <span class="verity_two"></span>
                              <ul class="curent_action">
                                 <li>验证身份</li>
                                 <li class="color_on">修改邮箱</li>
                                 <li>完成修改</li>
                              </ul>
                              <div class="user_email_new">
                              <form action="<?php echo $action; ?>" method="post">
                                  <span class="set_email">您的新邮箱：</span>
                                  <input placeholder="请输入您的邮箱地址" name="email" value='' type="text" />
                                  <?php if ($error_email) { ?>
                                  <span class="error"><em><?php echo $error_email; ?></em><i></i></span>
                                  <?php } ?>
                                  
                                  <span class="send_email"><input type="submit" value="发送验证邮件"/></span>
                              </form>
                              </div>
                          </div>
                         
                     </div>              
                  </div>              
              </div>
          </div>
      </div>
   </div>
</div>
<?php echo $footer ;?>