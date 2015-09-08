<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>淘优惠-CNstorm.com</title>
<meta name="keywords" content="代购用户免费注册,服务费全免,用户登录，新加坡代购，美国代购，海外华人代购,淘宝代购,留学生代购,国内代购,团购,拼单购" />
<meta name="description" content="华人代购中国商品免费注册，华人代购淘宝免费注册" />
<style type="text/css">
.cp_bg { background: #fafafa; }
.cpon { text-align: center; font-size: 38px; color: #f44242; padding: 25px 0; }
.cpon span { font-size: 32px; position: relative; vertical-align: text-top; margin-left: 18px; }
.cp_left { }
.cp_box { display: inline-block; border: 1px solid #F0F0F0; -moz-box-shadow: 0 0 8px #D8D8D8; /* 老的 Firefox */ box-shadow: 0 0 8px #D8D8D8; margin-bottom: 25px; }
.cp_box img { float: left; }
.cbox_r { float: right; display: block; }
.cbox_r .source { width: 325px; padding: 8px; border-bottom: 1px solid #E8E8E8; }
.cbox_r .title { font-size: 18px; padding: 10px 18px; font-weight: bold; }
.cbox_r .desc { margin: 0 25px; height: 38px; width: 325px; }
.cbox_r .btn { margin-top: 22px; text-align: center; }
.cbox_r .btn a { border: 1px solid #EB0000; border-radius: 2px; padding: 8px 25px; background: #FD6D6D; color: white; }
.cbox_r .btn a:hover { background: #F84848; }
</style>
</head>
<body>
<?php echo $header ?>
<div class="cp_bg">
  <div class="wrap">
    <div class="cpon">SALE & HOT<span>全网超值折扣大搜罗</span></div>
    <div class="cp_left">
      <?php foreach($favourables as $favourable){ ?>
      <div class="cp_box"><img src="<?php echo $favourable['image'] ?>">
        <div class="cbox_r">
          <div class="source">来自：<?php echo $favourable['source'] ?> <span class="fr"><?php echo $favourable['add_time'] ?></span></div>
          <div class="title"> <a href=<?php echo $favourable['url'] ?> target="_blank"><?php echo $favourable['name'] ?></a></div>
          <div class="desc"><?php echo $favourable['des'] ?></div>
          <div class="btn"><a href=<?php echo $favourable['url'] ?> target="_blank">立即查看</a></div>
        </div>
      </div>
      <?php } ?>
    </div>
    <div class="cp_right"></div>
  </div>
</div>
<?php echo $footer ?>;
</body>