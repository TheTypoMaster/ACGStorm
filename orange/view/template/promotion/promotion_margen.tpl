<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
     <!-- <div class="buttons"><a href="<?php echo $reset; ?>" class="button"><?php echo $button_reset; ?></a></div>-->
    </div>
    <div class="content">
	
      <table class="list">
        <thead>
          <tr>
            <td class="center"><?php echo $id; ?></td>
            <td class="center"><?php echo $pro_name; ?></td>
            <td class="center"><?php echo $reg_time; ?></td>
            <td class="center"><?php echo $last_login; ?></td>
			<td class="center"><?php echo $login_ip; ?></td>
            <td class="center"><?php echo $url; ?></td>
            <td class="center"><?php echo $grade; ?></td>
            <td class="center"><?php echo $reg_level; ?></td>
			<td class="center"><?php echo $bug_level; ?></td>
            <td class="center"><?php echo $money_level; ?></td>
            <td class="center"><?php echo $yjbili; ?></td>
            <td class="center"><?php echo $rewardyj; ?></td>
			<td class="center"><?php echo $tixian; ?></td>
            <td class="center"><?php echo $start; ?></td>
			<td class="center">操作</td>
          </tr>
        </thead>
        <tbody>
          <?php if ($products){ 
			
		  ?>
          <?php foreach ($products as $product) { ?>
          <tr>
            <td class="center"><?php echo $product['uid']; ?></td>
            <td class="center"><?php echo $product['firstname']; ?></td>
            <td class="center"><?php if($product['regtime']){echo date('Y-m-d H:i:s',$product['regtime']);}else{echo '';} ?></td>
            <td class="center"><?php echo date('Y-m-d H:i:s',$product['logintime']); ?></td>
			<td class="center"><?php echo $product['ip']; ?></td>
            <td class="center"><?php echo $product['url']; ?></td>
            <td class="center"><?php if($product['grade']==1){echo '普通';}else{echo '高级';} ?></td>
            <td class="center"><?php echo $product['level_num']; ?></td>
			<td class="center"><?php echo $product['childBuyNum']; ?></td>
            <td class="center"><?php echo $product['ChildBuyMoney']; ?></td>
            <td class="center"><?php echo $product['commission_ratio'];?>%</td>
            <td class="center"><?php echo $product['yongjin']; ?></td>
			<td class="center"><?php echo $product['money']; ?></td>
            <td class="center"><?php  if($product['status']){echo "启用";}else{ echo '停用';} ?></td>
			<td class="center"><a href="index.php?route=promotion/promotion_margen/update&token=<?php echo $token;?>&uid=<?php echo $product['uid'];?>">编辑</a></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="14"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>