<?php echo $header;?>
<title>个人设置-用邮箱认证您的CNstorm账户</title>     
<meta name="keywords" content="账户管理, CNstorm账户,个人账户，邮箱认证，账户安全，认证邮箱" />      
<meta name="description" content="欢迎到cnstrom账户中心，填写邮箱地址，提交并认证账户" />
<div class="goods_details_bg">
  <div class="yhzx wrap">
      <div class="user_center ">          
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
                              <span class="verity_three"></span>
                              <ul class="curent_action">
                                 <li>验证身份</li>
                                 <li>修改邮箱</li>
                                 <li class="color_on">完成修改</li>
                              </ul>
                              <p class="verify_yes verify_success">恭喜您，邮箱修改成功！</p>
                              <span class="new_email">新邮箱：<b><?php echo $finish_email;?></b><em>（邮箱可用于登录）</em></span>
                              <p class="go_shopping"><a href="<?php echo $favorite;?>">去购物吧</a></p>
                          </div>                         
                     </div>              
                  </div>              
              </div>
          </div>
      </div>
   </div>
</div>
<?php echo $footer ;?>