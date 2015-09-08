<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<meta name="description" content="欢迎体验华人或留学生国货代购平台CNstorm，一站式代购淘宝，专业精心挑选优质daigou商品，为您提供优质的帮助服务" />
<meta name="keywords" content="代购服务，自助购服务，代购指南，服务指南，帮助中心，售后服务，购物帮助，海外华人代购，淘宝代购，留学生代购，国内代购" />
<title>帮助中心-CNstorm代购为你提供优质的帮助服务</title>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/common_help.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    //北京时间模块
  var btime = new Date(parseInt($('#Beijing_Time').val()));
  var year = btime.getFullYear(); //年-4位表示 如：2012 
  var month = btime.getMonth() + 1; //月 0~11 所以要加 1才正确 
  var day = btime.getDate(); //日 1~31 
  var hour = btime.getHours(); //小时0~23 
  setInterval(function() {
    btime.setSeconds(btime.getSeconds() + 1);
    var datetime = year + "年" + month + "月" + day + "日" + " " + hour + ":" + (btime.getMinutes() < 10 ? '0': '') + btime.getMinutes() + ":" + (btime.getSeconds() < 10 ? '0': '') + btime.getSeconds(); //拼接一起,当然可以直接在这里修改显示格式 
    clock2.innerHTML = "<font>北京时间 : " + datetime + "</font>"; //以html文本形式显示在页面上 
  },
  1000);
  });
</script>
</head>
<body>
<?php echo $header_transport ?>
<div class="goods_details_bg goods_details">
	<div class="user_center">
		<div class="help_common_left">
			<ul class="hcl_menulists">
				<li class="hcl_mlitem1 curr">
					<a href="help.html" class="hcl_mlia1" title="帮助中心">
						<span class="hcl_icon"></span>
						<span class="hcl_title">帮助中心</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=44" class="hcl_mlia2" title="客服中心">
						<span class="hcl_icon"></span>
						<span class="hcl_title">客服中心</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=38" class="hcl_mlia3" title="常见问题">
						<span class="hcl_icon"></span>
						<span class="hcl_title">常见问题</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=39" class="hcl_mlia4" title="代购指南">
						<span class="hcl_icon"></span>
						<span class="hcl_title">代购指南</span>
					</a>
				</li>
				<li>
					<a href="procurement.html" class="hcl_mlia5" title="代购演示">
						<span class="hcl_icon"></span>
						<span class="hcl_title">代购演示</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=40" class="hcl_mlia6" title="支付说明">
						<span class="hcl_icon"></span>
						<span class="hcl_title">支付说明</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=41" class="hcl_mlia7" title="会员优惠">
						<span class="hcl_icon"></span>
						<span class="hcl_title">会员优惠</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=42" class="hcl_mlia8" title="物流配送">
						<span class="hcl_icon"></span>
						<span class="hcl_title">物流配送</span>
					</a>
				</li>
				<li>
					<a href="help-help.html&cid=44" class="hcl_mlia9" title="售后服务">
						<span class="hcl_icon"></span>
						<span class="hcl_title">售后服务</span>
					</a>
				</li>
			</ul>
		</div>
	
		<!--<div class="help_commen">
			<h3 class="hc_header"><a href="<?php echo('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] . '?route=help/help'); ?>" style="color:white;">帮助中心</a></h3>
			<?php foreach($categories as $category) { ?>
			<ul class="hc_list">
				<li>
					<h4>
						<a style="margin-left:0px;background:none;display:inline;font-size:20px;padding-left:0px;" href="<?php echo('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] . '?route=help/help' . '&cid=' . $category['id']); ?>">
							<strong><?php echo $category['name'] ?></strong>
						</a>
					</h4>
				</li>
				<?php foreach($category['sub'] as $subCategory) { ?>
				<li>
					<a style="background:none;" href="<?php echo('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] . '?route=help/help' . '&cid=' . $subCategory['id']); ?>"><?php echo $subCategory['name'] ?></a>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>-->

		<?php if(array_key_exists('cid', $_REQUEST) && $_REQUEST['cid'] != '') { if($qc) { ?>
		<div class="problem_boxs" <?php if($_GET['cid']!=38){ ?>style="display:none;" <?php }?> >
		
			<div class="problem_contents">
				<div class="pbc_title">
					<span>1.代购/自助购/转运相关</span>
				</div>
				<div class="problem_questions" style="height:217px;">
				<?php foreach($daigou as $key=>$v){
						$key++;
					?>
					<p>
						<span>1.<?php echo $key;?></span>
						<a target="_blank" href="/index.php?route=help/help&qid=<?php echo $v['help_question_id'];?>" onfocus="this.blur();"><?php echo $v['name'];?></a>
					</p>
					<?php } ?>
				</div>
			</div>
			
			<div class="problem_contents">
				<div class="pbc_title">
					<span>2.客服管理相关</span>
				</div>
				<div class="problem_questions" style="height:217px;">
				<?php foreach($kefu as $key=>$v){
						$key++;
					?>
					<p>
						<span>2.<?php echo $key;?></span>
						<a target="_blank" href="/index.php?route=help/help&qid=<?php echo $v['help_question_id'];?>" onfocus="this.blur();"><?php echo $v['name'];?></a>
					</p>
					<?php } ?>
					
				</div>
			</div>
		
			<div class="problem_contents">
				<div class="pbc_title">
					<span>3.物流配送相关</span>
				</div>
				<div class="problem_questions" style="height:217px;">
				<?php foreach($peisong as $key=>$v ){ 
					$key++;
				?>
					<p>
						<span>3.<?php echo $key;?></span>
						<a target="_blank" href="/index.php?route=help/help&qid=<?php echo $v['help_question_id'];?>" onfocus="this.blur();"><?php echo $v['name'];?></a>
					</p>
				<?php } ?>
				</div>
			</div>
			
			<div class="problem_contents">
				<div class="pbc_title">
					<span>4.会员/积分/优惠券相关</span>
				</div>
				<div class="problem_questions" style="height:217px;">
					<?php foreach($jifen as $key=>$v ){
					$key++;
					?>
					<p>
						<span>4.<?php echo $key;?></span>
						<a target="_blank" href="/index.php?route=help/help&qid=<?php echo $v['help_question_id'];?>" onfocus="this.blur();"><?php echo $v['name'];?></a>
					</p>
				<?php } ?>
				
				</div>
			</div>
	
			<div class="clear"></div>
			<div class="faqAnswerBox">
				<a class="boxTitle" id="faq-Payment">
					<span>1.&nbsp;&nbsp;支付相关</span>
					<label class="bt_tips">+</label>
				</a>
				<div class="faqAnswer">
				<?php foreach($zhifu as $key=>$v){
						$key++;
				?>
					<p class="p-question">
						<span>1.<?php echo $key;?></span>
						<a target="_blank" href="/index.php?route=help/help&qid=<?php echo $v['help_question_id'];?>" onfocus="this.blur();"><?php echo $v['name'];?></a>
					</p>
				<?php } ?>	
				</div>
			</div>
			
			<div class="faqAnswerBox">
				<a class="boxTitle" id="faq-Payment">
					<span>2.&nbsp;&nbsp;账户管理相关</span>
					<label class="bt_tips">+</label>
				</a>
				<div class="faqAnswer">
				
				<?php foreach($mima as $key=>$v){
						$key++;
				?>
					<p class="p-question">
						<span>1.<?php echo $key;?></span>
						<a target="_blank" href="/index.php?route=help/help&qid=<?php echo $v['help_question_id'];?>" onfocus="this.blur();"><?php echo $v['name'];?></a>
					</p>
				<?php } ?>	
					
				</div>
			</div>
		</div>

		
		<div class="help_cont"<?php if($_GET['cid']==38){ ?> style="display:none" <?php } ?> >
			<h3 class="helphome_bottom"><?php echo $qc['name']; ?></h3>
			<ul class="normal_ques">
				<?php foreach ($questions as $question) { ?>
				<li>
					<a href="<?php echo('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] . '?route=help/help' . '&qid=' . $question['help_question_id']); ?>" onfocus="this.blur();">
						<em></em><?php echo($question['name']);?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
		
		<?php } else {header("Location: index.php?route=help/help");exit;}} elseif (array_key_exists('qid', $_REQUEST) && $_REQUEST['qid'] != '') { if($question) { ?>
		<div class="help_cont">
			<h3 class="helphome_head"><?php echo($question['name']); ?></h3>
			<div id="help_ans"> <?php echo(htmlspecialchars_decode($question['content'])); ?> </div>
		</div>
		<?php } else {header("Location: index.php?route=help/help");exit;}} else { ?>
		<script src="catalog/view/javascript/jquery2/common.js"></script>
		<div class="help_cont">
			<ul class="find_us">
				<li class="moveon">
					<dl class="fu_one">
						<dt></dt>
						<dd>您有问题随时点我哦，为您实时解决各种代购疑问 ！</dd>
						<dd><a href="#" onclick="Comm100API.open_chat_window(event, 2633);">在线客服</a></dd>
					</dl>
				</li>
				<li>
					<dl class="fu_two">
						<dt></dt>
						<dd>为您解答售前，售中，售后的各种问题。</dd>
						<dd><a href="account-advisory.html">留言咨询</a></dd>
					</dl>
				</li>
				<li>
					<dl class="fu_three">
						<dt></dt>
						<dd>更贴心的CNstorm客户服务热线<br/>联系电话：+86-0755-81466633</dd>
						<dd><a href="mailto:support@cnstorm.com?subject=帮助中心客服咨询">邮件咨询</a></dd>
					</dl>
				</li>
				<li>
					<dl class="fu_four">
						<dt></dt>
						<dd>关注CNstorm官方微信联系客户服务小组，获取最新优惠资讯。</dd>
						<dd><a href="help.html&qid=79">了解更多</a></dd>
					</dl>
				</li>
			</ul>
			<ul class="public_wechat">
				<li class="pw_one"><span>微信公众号：</span><em>MyCNstorm</em></li>
				<li class="pw_two">客服邮箱：<em>support@cnstorm.com</em></li>
				<li class="pw_three">服务时间（周一至周六）：9:00—18:00</li>
			</ul>
			<ul class="public_wechat">
				<li class="pw_one">
					<span>QQ客服：</span><em>网站使用问题：</em>
					<span class="marRight20">
						<a href="http://wpa.qq.com/msgrd?v=3&uin=2230895627&site=qq&menu=yes" target="_blank">
							<img src="http://wpa.qq.com/pa?p=2:2230895627:51" width="79" height="25" alt="点击咨询" title="QQ客服01"/>
						</a>
					</span>
					<em>订单/运单问题：</em>
					<span>
						<a href="http://wpa.qq.com/msgrd?v=3&uin=364762833&site=qq&menu=yes" target="_blank">
							<img src="http://wpa.qq.com/pa?p=2:364762833:51" width="79" height="25" alt="点击咨询" title="QQ客服02">
						</a>
					</span>
				</li>
				<li class="pw_two" id="clock2"></li>
				<input id="Beijing_Time" type="hidden" value=<?php date_default_timezone_set('Asia/Shanghai'); echo time()*1000; ?>/>
			</ul>
			<div class="attention_wechat">
				<p>关注CNstorm微信：</p>
				<p>关注CNstorm官方微信号，可以与我们客户服务小组取得联系，获取最新优惠活动等资讯。</p>
				<p class="aw_how"><br/>如何关注？</p>
				<p>
					<img src="images/site/common/helpcenter_01.jpg" width="108" height="108" alt="CNstorm微信"/>
					<label class="aw_scanning">扫描二维码或输入MyCNstorm关注官方微信号</label><br/><br/>
					<img src="images/site/common/helpcenter_02.jpg" width="623" height="553" alt="CNstorm微信"/>
				</p>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<script src="catalog/view/javascript/help.js" type="text/javascript"></script>
<?php echo $footer; ?>
</body>
</html>