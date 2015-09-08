<?php echo $header_business;?>
<title>国际邮包追踪 - CNstorm</title>
<style type="text/css">
.main { width: 1200px; margin: auto; }
.sod_banner { z-index: 101; position: relative; margin-top: 0px; }
.n_left { float: left; width: 198px; height: 329px; border: 1px solid #cccccc; margin-right: 10px; }
.n_left_title { height: 2px; font-size: 0px; background: #0078D4; }
.title_l { font-size: 15px; color: gray; margin-left: 18px; height: 25px; border-bottom: 1px solid #EAEAEA; }
.content_l { color: gray; margin-left: 8px; margin-right: 8px; margin-top: 10px; }
</style>
<div class="main">
  <div class="sod_banner"><img src="/catalog/view/theme/cnstorm/images/sod_banner1.jpg" /></div>
  <div class="n_left">
    <div class="n_left_title"> </div>
    <div class="title_l"> 温馨提示 </div>
    <?php if(isset($carrier)){ if ($carrier == 'malay'){?>
    <div class="content_l"> 1. “追踪细节”下显示您的包裹编号及寄达国家信息 <br>
      <br>
      2. “追踪进度”下可查看详细包裹运输轨迹<br>
      <br>
      感谢您选择并使用CNstorm为您服务，如有疑问请<a href="/help.html" target="blank">联系客服</a>。别忘了在收到您的包裹后确认并给我们留下评价哦！在晒尔社区或微博晒单并@CNstorm信恩世通，有机会返利10元，赶快参与吧O∩_∩O~ </div>
  </div>
  <div style="text-align: center;height:auto;">
    <iframe style="margin-top:-153px;position:relative;z-index:100;min-height:629px;" src="<?php echo $link ?>" width="980" frameborder="0" scrolling="no"></iframe>
  </div>
  <?php }else{ ?>
  <div class="content_l"> 1. 右侧中文记录为中国邮政官方跟踪记录, 英文记录为您收件国家邮局跟踪记录（正常您国家邮局会比中国邮政更新更快） <br>
    <br>
    2. 网络跟踪记录可能存在一定延迟，仅记录发出国和目的国操作日志，不记录货物国际中转过程<br>
    <br>
    感谢您选择并使用CNstorm为您服务，如有疑问请<a href="/help.html" target="blank">联系客服</a>。别忘了在收到您的包裹后确认并给我们留下评价哦！在晒尔社区或微博晒单并@CNstorm信恩世通，有机会返利10元，赶快参与吧O∩_∩O~ </div>
</div>
<div style="text-align: center;height:auto;">
  <iframe style="margin-top:-51px;position:relative;z-index:100;min-height:688px;" src="<?php echo $link ?>" width="980" frameborder="0" scrolling="no"></iframe>
</div>
<?php }}else{ ?>
<div class="content_l"> 1. 点击“明细”或“查看”可查看详细包裹运输轨迹 <br>
  <br>
  2. “客户运单号”为您在CNstorm的内部单号，您可凭借“服务商号”前往DHL快递公司官网查询<br>
  <br>
  感谢您选择并使用CNstorm为您服务，如有疑问请<a href="/help.html" target="blank">联系客服</a>。别忘了在收到您的包裹后确认并给我们留下评价哦！在晒尔社区或微博晒单并@CNstorm信恩世通，有机会返利10元，赶快参与吧O∩_∩O~ </div>
</div>
<div style="text-align: center;height:auto;">
  <iframe style="margin-top:-232px;position:relative;z-index:100;min-height:788px;" src="<?php echo $link ?>" width="989" frameborder="0" scrolling="yes"></iframe>
</div>
<?php } ?>
</div>
<?php echo $footer_business; ?> 