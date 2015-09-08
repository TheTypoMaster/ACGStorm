<!--特色商品框
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">

      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
-->
<!--分类名字展示框-->

<div class="box">
  <div class="box-heading"></div>
  <div class="box-content">
    <div class="box-product">
    <?php foreach ($categoryids as $categoryid) {  ?>
      <div><p style="font-family: Arial,Helvetica,sans-serif;color: #333333; font-weight: bold;font-size: 14px;"><?php echo $categoryid['name']; ?></p><br>
           <?php foreach ($s_categoryids as $s_categoryid) {  ?>
           <?php if($s_categoryid['s_parent_category_id'] == $categoryid['category_id']) {  ?> 
           <table>   
              <tr><td><a href="<?php echo $s_categoryid['href']; ?>"><?php echo $s_categoryid['name']; ?></a></td></tr>
           </table>
           <?php } ?>
           <?php } ?>
      </div>      
    <?php } ?>   
    </div>
  </div>
  
  </div>








<!--分类商品展示框-->
<?php foreach ($categoryids as $categoryid) {  ?>
<div class="box">
  <div class="box-heading"><?php echo $categoryid['name']; ?></div>
  <div class="box-content">
    <div class="box-product">
       <?php foreach ($products_categoryid_info as $product_categoryid_info) {   
             if($categoryid['category_id'] == $product_categoryid_info['category_product_id']) { ?>   
      <div>
        <?php if ($product_categoryid_info['thumb']) { ?>
        <div class="image"><a href="<?php echo $product_categoryid_info['href']; ?>"><img src="<?php echo $product_categoryid_info['thumb']; ?>" alt="<?php echo $product_categoryid_info['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product_categoryid_info['href']; ?>"><?php echo $product_categoryid_info['name']; ?></a></div>
        <?php if ($product_categoryid_info['price']) { ?>
        <div class="price">
          <?php if (!$product_categoryid_info['special']) { ?>
          <?php echo $product_categoryid_info['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product_categoryid_info['price']; ?></span> <span class="price-new"><?php echo $product_categoryid_info['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product_categoryid_info['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product_categoryid_info['rating']; ?>.png" alt="<?php echo $product_categoryid_info['reviews']; ?>" /></div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product_categoryid_info['product_id']; ?>');" class="button" /></div>
      </div>
      <?php } } ?>
    </div>
  </div>
</div>
<?php } ?>




