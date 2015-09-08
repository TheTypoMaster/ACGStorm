<title>代购分享- CNstorm用户分享代购商品</title>

<meta name="keywords" content="韩国代购，代购商品，新加坡代购，美国代购，海外华人代购,淘宝代购,留学生代购,国内代购,服装代购，化妆品代购，食品代购，礼物代购，首饰代购" />

<meta name="description" content="CNstorm代购用户分享频道每日更新，新鲜趣味不停歇！由代购商品用户为您推荐，保证个个都是"代购精选"" />
<?php echo $header; ?>

<div class="banner_tit wrap">
   <div class="banner_tit_left">
      <ul class="img_tab">
      <?php if (!empty($lunbopics)){ 
      		foreach($lunbopics as $lunbopic){
      ?>
         <li><a href="<?php echo $lunbopic['url'] ?>" target="_blank"><img src="image/<?php echo $lunbopic['image'] ?>" alt="<?php echo $lunbopic['name'] ?>"></a></li>
      <?php } } ?>
      </ul>
      <a href="javascript:;" class="go_left"></a>
      <a href="javascript:;" class="go_right"></a>
      <ol class="img_num">
      <?php if (!empty($lunbopics)){ 
      		foreach($lunbopics as $k => $lunbopic){
      ?>
         <li <?php if ($k == 0) echo 'class="activeNS"'; ?>></li>
       <?php } } ?>
      </ol>
   </div>


   <div class="banner_tit_right">
      <div class="hot">
        <span class="hot_tab"><a href="javascript:void(0);" class="current">小C推荐</a><a href="javascript:void(0);" class="normal">大家最爱</a></span>
        <ul class="hot_list">
	<?php foreach ($xiaoc as $vx){ ?>
            <li><a href="<?php echo $vx['url'] ?>" target="_blank"><img src="image/<?php echo $vx['image'] ?>" alt="<?php echo $vx['name'] ?>" ><strong><?php echo $vx['name'] ?></strong><p>￥<b><?php echo $vx['price'] ?></b></p></a></li>
	<?php } ?>
	</ul>
        <ul class="hot_list" style="display:none;">
	<?php foreach ($zuiai as $vz){ ?>
            <li><a href="<?php echo $vz['url'] ?>" target="_blank"><img src="image/<?php echo $vz['image'] ?>" alt="<?php echo $vz['name'] ?>" ><strong><?php echo $vz['name'] ?></strong><p>￥<b><?php echo $vz['price'] ?></b></p></a></li>
        <?php } ?>
	</ul>
      </div>
      <div class="comments" onclick='seeComment()'>
        <h3 class="comment_tit">最新评论</h3>
        <div class="user">
            <span class="user_photo"><img src="catalog/view/theme/cnstorm/images/avtor.jpg" alt="avtor" ></span>
            <div class="user_infor">
              <span class="user_name">白金会员:jy210632</span>
              <span class="user_city">来自：新西兰</span>
              <p class="user_comment">Received item within 3 days.</p>
            </div>
        </div>
      </div>
      <ul class="shop_tools">
        <li class="inquire"><a href="/index.php?route=help/populartools&id=2" target="_blank">包裹查询</a></li>
        <li class="cost"><a href="/index.php?route=help/populartools" target="_blank">费用估算</a></li>
        <li class="size"><a href="/index.php?route=help/populartools&id=3" target="_blank">尺码换算</a></li>
        <li class="rate"><a href="/index.php?route=help/aboutus" target="_blank">帮助中心</a></li>
      </ul>
  </div>
  <div class="CLR"></div>
</div>

<div class="shopping_types wrap">
       <?php for($i=0;$i<count($categoryids);$i++) {  ?>
       <div class="goods">
       <h3 class="<?php echo 'goods'.$i;?>"><em class="item_bg"><?php echo $categoryids[$i]['name']; ?></em></h3>
       <ul class="choose">
       <?php foreach ($s_categoryids as $s_categoryid) {  ?>
       <?php if($s_categoryid['s_parent_category_id'] == $categoryids[$i]['category_id']) {  ?> 
           <li><a href="<?php echo $s_categoryid['href'];?>"><?php echo $s_categoryid['name']; ?></a></li>
       <?php } ?>
       <?php } ?>
       </ul>
        </div>
     <?php }  ?>

</div>

<?php for ($j=0;$j<count($categoryids);$j++){  ?>
<div class="<?php echo 'topic_cloth'.$j.' wrap';?>">   
    <h3 class="<?php echo 'topic'.$j ;?>"><em class="item_bg"><?php echo $categoryids[$j]['name']; ?></em>
    <ul class="mini_nav">
     <?php foreach ($s_categoryids as $s_categoryid) {  ?>
       <?php if($s_categoryid['s_parent_category_id'] == $categoryids[$j]['category_id']) {  ?> 
        <li><a href="<?php echo $s_categoryid['href'];?>"><?php echo $s_categoryid['name']; ?></a></li>
       <?php } ?>
     <?php } ?>
    </ul></h3>
    
    
    
    <ul class="cloth_list">
         <?php foreach ($products_categoryid_info as $product_categoryid_info) {   
             if($categoryids[$j]['category_id'] == $product_categoryid_info['category_product_id']) { ?>   
         <li>
            <a target="_blank" href="<?php echo $product_categoryid_info['href'];?>"><img src="<?php echo 'image/'.$product_categoryid_info['thumb']; ?>" alt="<?php echo $product_categoryid_info['name']; ?>" /></a>
            <a target="_blank" class="introduce" href="<?php echo $product_categoryid_info['href'];?>"><?php echo $product_categoryid_info['name']; ?></a>
            <strong class="current_price">￥<b><?php echo $product_categoryid_info['price']; ?></b></strong>
            <span class="btn"><a target="_blank" class="add" href="<?php echo $product_categoryid_info['href'];?>">查看详情</a><a class="save" onclick="addToWishList('<?php echo $product_categoryid_info['product_id']; ?>');">收藏</a></span>
        </li>
       <?php } } ?> 
    </ul>
</div>

<?php } ?>

<?php echo $footer; ?>
