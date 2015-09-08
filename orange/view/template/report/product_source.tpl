<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="list">
        <thead>
          <tr>
            <td class="center">下单类型</td>
            <td class="center"><?php echo $text_buy_type_web; ?></td>
            <td class="center"><?php echo $text_buy_type_app; ?></td>
          </tr>
        </thead>
        
        <tbody>
          <tr> 
            <td class="center">代购</td>
            <td class="center"><?php echo $total1; ?> 单</td>
            <td class="center"><?php echo $total4; ?> 单</td>
          </tr>
	  <tr> 
            <td class="center">自助购</td>
            <td class="center"><?php echo $total2; ?> 单</td>
            <td class="center"><?php echo $total5; ?> 单</td>
          </tr>
	  <tr> 
            <td class="center">代寄</td>
            <td class="center"><?php echo $total3; ?> 单</td>
            <td class="center"><?php echo $total6; ?> 单</td>
          </tr>
	  <tr> 
            <td class="right">总计</td>
            <td class="right"><?php echo $total1+$total2+$total3; ?> 单</td>
            <td class="right"><?php echo $total4+$total5+$total6; ?> 单</td>
          </tr>
        </tbody>
        
      </table>
    </div>
  </div>
</div>
<?php echo $footer; ?>