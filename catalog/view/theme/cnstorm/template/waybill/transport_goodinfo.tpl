<input type="hidden" name="order_id_combination" id="order_id_combination" value="<?php echo $order_id_combination; ?>">
<input type="hidden" name="sensitive" id="sensitive" value="<?php echo $sensitive;?>">
<input type="hidden" name="brand" id="brand" value="<?php echo $brand;?>">
<table class="infor_tab" border="0" align="center" cellspacing="0" cellpadding="0">
  <thead class="infor_title">
    <tr>
      <th width="698" class="align_l">商品信息</th>
      <th width="240">商品属性</th>
      <th width="138">操作</th>
      <th width="98">物品重量(g)</th>
    </tr>
  </thead>
  <?php if($order_info){ foreach ($order_info as $info) { ?>
  <?php if($info['good_info']){  for($i=0;$i<count($info['good_info']);$i++){?>
  <tr>
    <td>
      <?php if($info['good_info'][$i]['img']){ ?>
      <a class="good_img" target="_blank" href="<?php echo $info['good_info'][$i]['producturl'];?>"><img src="<?php echo $info['good_info'][$i]['img'];?>"></a>
      <?php }else{ ?>
      <a class="good_img" href="#"><img src="images/post/cnstorm.jpg"></a>
      <?php } ?>
      <dl class="good_info">
        <dd class="good_name"><a target="_blank" href="<?php echo $info['good_info'][$i]['producturl'];?>"><?php echo $info['good_info'][$i]['name'];?></a></dd>
        <dd>
          <span class="good_color">颜色:<strong><?php echo $info['good_info'][$i]['option_color'];?></strong></span>
          <span class="good_size">尺码:<strong><?php echo $info['good_info'][$i]['option_size'];?></strong></span>
        </dd>
      </dl>
    </td>

    <td>
    <?php if(2 == $info['good_info'][$i]['order_sensitive']){ ?>
    <dd class="sensitive">敏感品</dd>
    <?php }else{ ?>
    <dd class="sensitive"></dd>
    <?php } ?>
    <?php if(2 == $info['good_info'][$i]['order_branding']){ ?>
    <dd class="sensitive">品牌</dd>
    <?php }else{ ?>
    <dd class="sensitive"></dd>
    <?php } ?>
    <?php if(2 == $info['good_info'][$i]['order_huge']){ ?>
    <dd class="sensitive">重抛</dd>
    <?php }else{ ?>
    <dd class="sensitive"></dd>
    <?php } ?>
    </td>

    <?php if($i === 0){ ?>
    <td class="layback" rowspan="<?php echo count($info['good_info']);?>"><a onclick="layback(<?php echo $info['order_id'];?>)">放回仓库</a></td>
    <td class="weight" rowspan="<?php echo count($info['good_info']);?>"><?php echo $info['weight'];?></td>
    <?php }else{ ?>
    <?php } ?>
  </tr>
  <?php }} ?>
  <?php }} ?>
  
</table>
<div class="total_weights">重量合计：<b> <?php echo $total_weight; ?> </b> g</div>