<?php echo $header ;?>

  <div class="shopping_types wrap">
     <?php for($i=0;$i<count($categoryids);$i++) {  ?>
     <div class="goods">
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

<div class="search_no_results wrap">
  <div class="connot_find">
    <dl>
        <dt>抱歉，没有找到与<em><?php echo $name;?></em>相关的商品</dt>
        <dd>您可以尝试更换关键词搜索，或<a href="/index.php?route=cosplay/main">到处转转</a></dd>
    </dl>
  </div>
</div>


<br/>
<br/>
<?php echo $footer ;?>
