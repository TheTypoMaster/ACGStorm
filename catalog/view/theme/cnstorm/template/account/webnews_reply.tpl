<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>站内消息-及时关注CNstorm账户的账户管理</title>
<meta name="keywords" content="账户管理, CNstorm账户,账户中心，账户消息，交易消息，站内消息，系统消息" />
<meta name="description" content="登录您的cnstorm代购账户中心，及时查看交易消息、站内消息和系统消息" />
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/css/base.css"/>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/default.css"/>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
</head>
<body>
<div class="goods_details_bg">
	<?php echo $uc_business; ?>
	<div class="content-right">
		<div class="daigou_list">
			<div class="dl_head">
			  <h3 class="bg13">站内消息 &nbsp; &gt; &nbsp;消息详情</h3>
			</div>
			<div class="all_dingdan">
			  <div class="trade_tit">
				<h3><?php echo $pm_info['subject'] ; ?></h3>
				<span><?php echo date('Y-m-d H:m:s',$pm_info['sendtime']); ?></span> </div>
			  <dl class="service_call">
				<dt>亲爱的CNstorm会员：</dt>
				<dd><?php echo $pm_info['message'] ; ?></dd>
				<dd class="text_alignr"><?php echo $pm_info['fromuname'] ; ?></dd>
			  </dl>
			  <form class="reply_box ml10">
				<textarea class="rb_textarea" value="" placeholder="若有疑问需要咨询，请在此输入您的回复内容，我们将在48小时之内答复您。问题描述越详细，得到回复的速度越快哦！"></textarea>
				<span class="btn_pack ml10">
				<input class="rb_btn" type="button" value="回复" onClick="pm_reply(<?php echo $pm_info['mid'] ; ?>)"/>
				<span class="red">请输入后再点击回复！</span> </span>
			  </form>
			  <div class="ask_record">
				<div class="ar_top">
				  <h3>咨询记录</h3>
				  <span>温馨提示：若您的问题没有得到解决，请通过邮件或者在线客服联系我们。</span></div>
				<ul class="ar_list">
				  <li class="qustion">
					<?php foreach($rply_lists as $rl) {?>
					<p><span>您：</span><?php echo $rl['message'] ; ?></p>
					<em class="time"><?php echo date('Y-m-d H:m:s',$rl['sendtime']) ; ?></em>
					<?php } ?>
				  </li>
				  <li class="answer">
					<?php foreach($mrply_lists as $mrl) {?>
					<p><b>CNstorm：</b><?php echo $mrl['message'] ; ?></p>
					<em class="time"><?php echo date('Y-m-d H:m:s',$mrl['sendtime']) ; ?></em>
					<?php } ?>
				  </li>
				</ul>
			  </div>
			</div>
		</div>
	</div>
</div>
</div>
<?php echo $footer; ?>
</body>
</html>