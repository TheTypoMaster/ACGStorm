<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title> CNstorm代购-全球最大海外留学生及华人代购中国商品及配送上门的代购服务网站</title>
<meta name="description" content="CNstorm代购是全球知名专业的海外留学生、海外华人代购网站，为海外华人及海外留学生提供淘宝、当当、卓越亚马逊、Ebay等国内购物网站商品代购服务，而且提供可多币种支付的中国商品购买及送货上门服务" />
<meta name="keywords" content="CNstorm代购，代购网站，代购公司，留学生代购，海外华人代购，海外华侨代购，海外代购，淘宝代购，TaoBao代购，卓越代购，京东代购，英国代购，daigou ">
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/common_help.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
</head>
<body>
<?php echo $header_transport ?>

<div class="goods_details_bg goods_details">
  <div class="yhzx wrap">
      <div class="user_center">
          <?php if(!array_key_exists('social', $_REQUEST)) echo $help_left ;?>
          <div class="user_c_r" <?php if(array_key_exists('social', $_REQUEST)) { echo("style='width:1200px;'"); } ?>>
              <div class="intro_cn">
                   <?php if(!array_key_exists('bid', $_REQUEST)) { ?>
                     <div class="bulletins">
                        <ul>
                          <?php if($bulletins != null) { ?>
                            <?php foreach($bulletins as $bulletin) { ?>
                              <li class="bulletins"><a href="<?php echo('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] . '?route=help/announcement&id=2' . '&bid=' . $bulletin['bulletin_id']); ?>" onfocus="this.blur();"><em></em><?php echo($bulletin['name']); ?></a></li>
                            <?php } ?>
                          <?php } else { ?>
                            <p style="font-size:22px; padding-left:30px; padding-top:30px;">暂无公告！</p>
                          <?php } ?>
                          </ul>
                       </div>
                      <?php } else { if($bulletin) { ?>
                        <div class="bulletin" <?php if(array_key_exists('social', $_REQUEST)) { echo("style='width:1200px;'"); } ?>>
                          <h3><?php echo($bulletin['name']); ?></h3>
                          <div class="articleText">
                            <?php echo(htmlspecialchars_decode($bulletin['content'])); ?>
                          </div>
                        </div>
                    <?php } else {header("Location: index.php?route=help/announcement&id=2");exit;}} ?>
               </div>        
          </div>
     </div>
 </div>
</div>
<?php echo $footer; ?>
</body>
</html>