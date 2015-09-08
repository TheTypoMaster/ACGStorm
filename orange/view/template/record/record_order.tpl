<!DOCTYPE html>
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<style type="text/css">
.content{width: 1000px;margin: 0 auto;}
.altrowstable { border-collapse:collapse; width: 100%; border:1px solid #A9C6C9;}
.altrowstable .title-info td { line-height: 40px; background: #eaf8ff; padding-left: 20px; }
.product-info td{ padding:10px 5px; border: 1px solid #A9C6C9;  text-align:center}
.baobei .pic { float: left; margin: 5px 12px 0 0; }
.baobei img { max-height: 80px; max-width: 80px; border: 1px solid #e9e9e9; }
.baobei .desc { float: left; width: 289px; }
.baobei .desc .spec{color:green}
.baobei .desc .spec i{color:red}
</style>

<div class="content">
  <div align="center"><img src="/image/data/logo.png" width="198" height="auto"/></div>
  <div align="center" style="line-height: 58px;font-size: 16px;font-weight: bold;">消费日志:<?php echo $rid ;?>消费详情</div>
  <?php if ($results) {  foreach ($results as $result) {  ?>
  <table class="altrowstable">
    <tr class="title-info">
      <td width="48%">订单编号：<?php echo $result['order_id'];?>   下单时间：<?php echo $result['date_added'];?></td>
      <td width="52%" colspan="4">店铺名称：<a target="_blank" href="<?php echo $result['store_url'];?>" ><?php echo $result['store_name'];?></a></td>
    </tr>
    <?php $i=0;?>
    <?php foreach ($result['order_product'] as $orde_product) {?>
    <tr class="product-info">
      <td class="baobei"><a href="<?php echo urldecode($orde_product['producturl']); ?>" target="_blank" class="pic"><img src="<?php echo $orde_product['img']; ?>" alt="产品图片"></a>
        <div class="desc">
          <p class="baobei-name"> <a target="_blank" href="http://item.taobao.com/item.htm?id=41490114031&amp;_u=71o2nmf79806" class="J_MakePoint" data-point-url="http://gm.mmstat.com/listbought.2.6"><?php echo $orde_product['name']; ?></a> </p>
          <div class="spec" title=""> <span>颜色分类: <i><?php echo $orde_product['option_color'];?></i></span><span>尺码: <i><?php echo $orde_product['option_size'];?></i></span> </div>
        </div></td>
      <td>￥<?php echo $orde_product['price'];?></td>
      <td width="38px"><?php echo $orde_product['quantity'];?></td>
      <?php if(0 == $i){ ?>
      <td rowspan="<?php echo $result['count']; ?>">
      运费总计：<span>￥<?php echo $result['order_shipping'];?></span></td>
      <td rowspan="<?php echo $result['count']; ?>">订单金额总计：<span>￥<?php echo $result['total'];?></span></td>
      <?php } ?>
    </tr>
    <?php $i++;?>
    <?php } ?>
    <?php  } }  ?>
    <tr >
      <td colspan="8" align="right">感谢阁下选择CNstorm，我们竭诚为您提供极致国际购物及运输体验!<br/>
        TeL:(0086)75581466633</br>
        Mailbox：support@cnstorm.com</br>
        CNstorm(ShenZhen) Co.,Ltd. All rights reserved.</td>
    </tr>
  </table>
</div>
