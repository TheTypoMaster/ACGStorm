<div class="contents">
<?php if (isset($comments)) foreach($comments as $comment){ ?>
<div class="uc_content reply">
   <?php if($comment['face']){ ?>
	<img class="img" src="<?php echo $comment['face'];?>" alt="">
   <?php }else{ ?>
	<img class="img" src="uploads/big/0b4a96400b2372d25da769647bfe4059.jpg" alt="头像" >
   <?php } ?>
   
   <ul class="listone">
      <li class="left">CNstorm会员：<?php echo $comment['uname'] ?></li>
      <li class="right">来自：<?php echo $comment['from'] ?></li>
   </ul>
   <ul class="listtwo">
      <li class="corner"></li>
      
      
      <li class="dashed">
	<div><?php echo $comment['message'] ?></div>
	   <!----查看原图-->
	   <div class="view-image-div-box">
		<div class="view-image-div-close"></div>
		<img src="<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])) echo $comment['multyimg']; else if (isset($curImg)) echo $curImg;?>">
	   </div>
	   <!---查看原图结束---->
	   <!---初始点击图-->
	   <div class="bask_rec_images view-image-list">
		   <?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg']) && file_exists($comment['multyimg'])){ ?>
			<img style="float:none" width="150" height="150" src="<?php  echo $comment['multyimg'];?>">
		   <?php }else if(!empty($comment['multyimg']) && is_array($comment['multyimg'])){ ?>
			<img style="float:none" width="150" height="150" src="<?php  echo $curImg;?>">
		   <?php } ?>
	   </div>
	   <div class="bask_image_box">
		   <div class="bask_image_box_op">
			<span class="up_down"></span>
			<span class="updown">收起</span>
			<span class="res"></span>
			<span img_src="<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])) echo $comment['multyimg']; else if (isset($curImg)) echo $curImg;?>" class="viewres">查看原图</span>
		  </div>
		  <div class="bask_image_big">
			<img src="<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])) echo $comment['multyimg']; else if (isset($curImg)) echo $curImg;?>">
		  </div>
		  <div class="bask_iamge_sm">
			<ul class="bask_iamge_sm_ul">
				<?php if(!empty($comment['multyimg']) && !is_array($comment['multyimg'])){ ?>
					<li><img width="76" height="76" src="<?php echo $comment['multyimg']; ?>"><span></span></li>
				<?php }else if(is_array($comment['multyimg'])){ 
					foreach($comment['multyimg'] as $v){ ?>
						<li><img width="76" height="76" src="<?php echo $v; ?>"><span></span></li>
					<?php }
				} ?>
			</ul>
		  </div>
	    </div>
      </li>
      
      
      <li class="reply_txt"><dl><dt></dt><dd><?php if ($comment['reply']){ echo $comment['reply'];}else{ ?>满意的话下次要继续使用CNstorm哦！O(∩_∩)O~<?php } ?></dd></dl></li>
   </ul>
   <div class="clr"></div>
</div>
<?php } ?>
</div>
<div class="pages_change "><?php echo $pagination; ?></div>
<div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
<svg xmlns="http://www.w3.org/2000/svg" width="880" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" >
  <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
</svg>
</div>