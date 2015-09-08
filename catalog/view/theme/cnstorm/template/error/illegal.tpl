<?php echo $header;?>
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
                                  <span class="illegal_email">验证非法，请重试！</span>                                  
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