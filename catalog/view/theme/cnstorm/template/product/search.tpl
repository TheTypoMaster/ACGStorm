<?php echo $header ;?>

<div class="child_nav">

    <ul class="child_list_l wrap">

       <li><a href="<?php echo $home;?>">首页</a>&gt;</li>

       <li><a>潮流服饰</a>&gt;</li>

       <li><a>连衣裙</a></li>

    </ul>

</div>





<div class="shopping_bg wrap ml10">

  <div class="shopping_types">

     <?php for($i=0;$i<count($categoryids);$i++) {  ?>

     <div class="goods classify">

         <h3 class="<?php echo 'goods'.$i ;?>"><em class="item_bg"><?php echo $categoryids[$i]['name']; ?></em></h3>

         <ul class="choose">

         <?php foreach ($s_categoryids as $s_categoryid) {  ?>

         <?php if($s_categoryid['s_parent_category_id'] == $categoryids[$i]['category_id']) {  ?> 

            

             <li><a href="<?php echo $s_categoryid['href'];?>"><?php echo $s_categoryid['name']; ?></a></li>

         <?php } }?> 

         </ul>

     </div>

     <?php } ?>

   

  </div>

</div>



<div class="look_through wrap">



  <div class="goods_sort ml10">

     <ul class="goods_sort_list">

        <li><a href="javascript:void(0);">人气<i class="go_top"></i></a></li>

        <li><a href="javascript:void(0);">最新<i class="go_down"></i></a></li>

        <li><a href="javascript:void(0);">价格<i class="go_top"></i></a></li>

     </ul>

     <p class="goods_sort_info ml10"><span class="total">共<em><?php echo $product_total ;?></em>件商品</span><span class="pages"><em>5</em>/10</span><a class="click_left now" href="javascript:void(0);">&lt;</a><a class="click_right" href="javascript:void(0);">&gt;</a></p>

  </div>



<?php if ($products) { ?>

  <ul class="cloth_list">

        <?php foreach($products as $product)  { ?>

        <li>

            <a href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name'];?>" ></a>

            <a class="introduce" href="<?php echo $product['href'];?>"><?php echo $product['name'];?></a>

            <strong class="current_price"><?php echo $product['price']; ?></strong>

            <span class="btn"><a class="add" href="javascript:void(0);">加入购物车</a><a class="save" href="javascript:void(0);">收藏</a></span>

        </li>

        <?php } ?> 

  </ul>

<?php } ?>    

    

    <div class="pages_change">

      <ul class="list_num">

         <li class="pages_left"><a href="<?php if($page>1) echo str_replace("{page}",$page-1,$url);?>">&lt;</a><li>

        <!--

        <li class="number on"><a href="<?php echo $url;?>">1</a><li>

        <li class="dot">...</li>

        -->

        <?php for($i=1;$i<=$pagenum;$i++)   {  ?>

        <li class="number" id=$i><a onclick="click_num('<?php echo $i ?>')"  href="<?php echo str_replace("{page}",$i,$url);?>"><?php echo $i;?></a><li>

        <?php } ?>

        <li class="pages_right"><a href="<?php if($page<$pagenum) echo str_replace("{page}",$page+1,$url);?>">&gt;</a><li>

        

        <li class="infor">共<?php echo $pagenum;?>页，到第</li>

        <li class="go_direct"><input class="gd_input" type="text" value="<?php echo $page;?>" /></li>

        <li class="infor">页</li>

        <li class="btn"><a href="<?php echo str_replace("{page}",$page,$url);?>">确定</a></li>

      </ul>

  </div>

    <div class="CLR"></div>

</div>



<?php echo $footer ;?>