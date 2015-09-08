<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>信恩世通（CNstorm)新闻 - 发布优惠活动、公告、晒尔社区热帖的窗口</title>
<meta name="Description" content="信恩世通（CNstorm)新闻主要介绍公司的优惠信息、重大通知和晒尔社区的热帖分享，没事也要过来晒一晒。"/>
<meta name="Keywords" content="信恩世通新闻，CNstorm新闻"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/css/company-default.css?v=20150418"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/company/company-default.js?v=20150502"></script>
</head>
<body>
<?php echo $header_company ?>
<div class="press_main ma1200 mt18">
  <div class="indicator">
    <h2>Press</h2>
    <h3>新闻发布</h3>
    <span class="location fr">当前位置：首页>新闻及媒体资源><em>新闻发布</em></span> </div>
  <?php foreach($bulletins as $bulletin) { ?>
  <div class="press-li"> <span class="p-date"> <em>
    <?php $addtime = $bulletin["date_added"]; if (strpos($addtime,"2014") !== false ) { echo str_replace("-","月", substr( str_replace("2014-","",$addtime), 0 , 5 ))."日";?>
    </em> <?php echo 2014;?> <em>
    <?php }elseif (strpos($addtime, "2015") !== false ) { echo str_replace("-","月", substr( str_replace("2015-","",$addtime), 0 , 5 ))."日";?>
    </em> <?php echo 2015; }?></span> <span class="bulletins"><a href="<?php echo('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] . '?route=help/announcement&id=2' . '&bid=' . $bulletin['bulletin_id']); ?>" onfocus="this.blur();"><em><?php echo($bulletin['name']); ?></em>
    <p><?php echo mb_substr(strip_tags(htmlspecialchars_decode($bulletin['content'])), 0 , 198); ?></p>
    </a></span> </div>
  <?php } ?>
</div>
<?php echo $footer_company ?>
</body>
</html>