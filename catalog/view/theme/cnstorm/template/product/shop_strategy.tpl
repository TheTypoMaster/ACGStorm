<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title></title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/strategy.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/orderlist.js"></script> 
<style>
.f-clear{clear:both;}
</style>
</head>
<body>
<?php echo $header_transport ?>

<div class="wrapBox">
	<div class="wrap">
		<h1 class="strategyTitle">SALE&nbsp;&&nbsp;HOT&nbsp;&nbsp;&nbsp;&nbsp;全网超值折扣大搜罗</h1>
		<!--主体内容[[-->
		<div class="strategyWrap">
			<!--左侧的网购攻略[[-->
			<div class="strategyLeft">
			
			<?php if($rows){ 
				foreach($rows as $v){
			?>
				<a href="<?php echo $v['url'];?>" target="_blank" title="" rel="nofollow" class="strategySplits">
				<div class="strategyBoxs">
					<img src="/image/<?php echo $v['image']; ?>" width="520" height="230" alt="" class="sbcImg"/>
					<div class="strategyContents">
						<p class="sbcSource">
							<label class="fl">来自：<?php echo $v['source'];?></label>
							<label class="fr"><?php echo date('Y-m-d H:i:s',$v['add_time'])?></label>
						</p>
						<p class="sbcTitle"><?php echo $v['name'];?></p>
						<?php if( $v['discount_type']==1){ ?>
							<p class="sbcDiscount"><strong><?php echo $v['discount'];?></strong>折起</p>
						<?php }else{ ?>
							<p class="sbcDiscount">满<strong><?php echo $v['max'];?></strong>减<strong><?php echo $v['min'];?></strong></p>
						<?php }?>
				<p class="sbcSurplustime"><div style="text-align:center" id="no<?php echo $v['favourable_id'];?>"></div> </p>
					</div>
				</div>
				</a>
				
				<?php } ?>
				<!--分页[[-->
				<div class="pages_change">
					<ul class="list_num">
						<li class="number on"><a>1</a></li>
						<li class="number"><a href="">2</a></li>
						<li class="pages_right"><a href="">下一页&gt;</a></li>
						<li class="pages_last"><a href="">尾页&gt;|</a></li>
					</ul>
				</div>
				<!--分页]]-->
				<?php }else{ ?>
				 暂无活动
				<?php }?>
				
<script>
	var addTimer = function () {  
        var list = [],  
            interval;  
  
        return function (id, time) {  
            if (!interval)  
                interval = setInterval(go, 1000);  
            list.push({ ele: document.getElementById(id), time: time });  
        }  

        function go() {  
            for (var i = 0; i < list.length; i++) {  
                list[i].ele.innerHTML = getTimerString(list[i].time ? list[i].time -= 1 : 0);  
                if (!list[i].time)  
                    list.splice(i--, 1);  
            }  
        }  
        function getTimerString(time){  
            var not0 = !!time,  
                d = Math.floor(time / 86400),  
                h = Math.floor((time %= 86400) / 3600),  
                m = Math.floor((time %= 3600) / 60),  
                s = time % 60;  
            if (not0)  
                return "还有" + d + "天" + h + "小时" + m + "分" + s + "秒";  
            else return "时间到";  
        }  
    } ();  
	<?php 
	if($rows){
			foreach($rows as $v){
				?>
				addTimer('no<?php echo $v['favourable_id'];?>',<?php echo $v['timeca'];?>);
				<?php
			}
		}
	?>
</script>
				
			
			</div>
			<!--左侧的网购攻略]]-->
			
			<!--右侧的内容[[-->
			<div class="strategyRight">
				<!--右侧的签到[[-->
				<div class="srSplitsBox">
					<div class="srsbTitle">
						<h2>签到答题赢积分</h2>
					</div>
					<div class="srsbContents srsbBorderbot">
					
						          <?php if (!empty($customer_name)){ if($signFlag != 1){ ?>
                    <a class="qiandao" href="javascript:void(0);" onclick="calendarclick(<?php if (isset($customer_id)) echo $customer_id?>,'<?php if (isset($customer_name)) echo $customer_name;?>')">
                    <div class="m-sns-sign-in">
                        <div style="position:absolute;top:28px;left:35px;font-size:16px;color:#3cbc90"><?php echo date('d',time()); ?></div>
                        <div style="position:absolute;top:8px;left:180px;font-size:22px;color:#3cbc90"><?php echo $count; ?></div>
                    </div>
                    </a>
                    <?php }else{ ?>
                    <a class="qiandao" href="javascript:void(0);" onmouseover="calendarclick(<?php if (isset($customer_id)) echo $customer_id?>,'<?php if (isset($customer_name)) echo $customer_name;?>')">
                    <div class="m-sns-sign-in">
                        <div style="position:absolute;top:28px;left:35px;font-size:16px;color:#3cbc90"><?php echo date('d',time()); ?></div>
                        <div style="position:absolute;top:8px;left:180px;font-size:22px;color:#3cbc90"><?php echo $count; ?></div>
                    </div>
                    </a>
                    <?php } ?>
                    <div id="calendar"></div>
                    <a class="dati" href="javascript:void(0);" onclick="question(<?php echo $customer_id?>,'<?php echo $customer_name;?>')"><div class="m-sns-answer"></div></a>
                    <div class="f-clear"></div>
                    <div class="m-sns-sa-tip">提示：每日签到答题，可获赠双倍积分！</div>
                    <?php }else{ ?>
                    <a class="qiandao" href="account-login.html">
                    <div class="m-sns-sign-in">
                        <div style="position:absolute;top:28px;left:35px;font-size:16px;color:#3cbc90"><?php echo date('d',time()); ?></div>
                        <div style="position:absolute;top:8px;left:180px;font-size:22px;color:#3cbc90">0</div>
                    </div>
                    </a>
                    <a class="dati" href="account-login.html"><div class="m-sns-answer"></div></a>
                    <div class="f-clear"></div>
                    <div class="m-sns-sa-tip">提示：每日签到答题，可获赠双倍积分！</div>
                    <?php } ?>     
						
						
						
					</div>
					 <?php if($signFlag != 1){ ?>
						<div class="srsbContents">
							<a href="account-login.html" target="_blank" title="立即登录" class="mainBg srsbLogin">立即登录</a>
							<a href="/index.php?route=app/appload" target="_blank" title="下载手机客户端" class="srsbApp"></a>
						</div>
					<?php }?>
				</div>
				<!--右侧的签到]]-->
				<!--右侧的购物流程[[-->
				<div class="srSplitsBox">
					<div class="srsbTitle">
						<h2>购物流程</h2>
					</div>
					<div class="srsbContents">
						<p class="srsbShopprocess1">
							<i class="srsbspIcon01"></i>
							<i class="srsbspIcon02"></i>
							<i class="srsbspIcon03"></i>
							<i class="srsbspIcon04"></i>
						</p>
						<p class="srsbShopprocess2">
							<label class="srsbspChars01">本站<br/>下单</label>
							<label class="srsbspFuhao">&gt;</label>
							<label>采购<br/>入库</label>
							<label class="srsbspFuhao">&gt;</label>
							<label>直邮<br/>海外</label>
							<label class="srsbspFuhao">&gt;</label>
							<label class="srsbspChars07">配送<br/>签收</label>
						</p>
					</div>
				</div>
				<!--右侧的购物流程]]-->
				<!--右侧的热门电商网站[[-->
				<div class="srSplitsBox">
					<div class="srsbTitle">
						<h2>热门电商网站</h2>
					</div>
					<div class="srsbContents paddbottom">
						<a href="http://www.taobao.com" target="_blank" rel="nofollow" title="淘宝网" class="srsbHotwebsite hotweb01"></a>
						<a href="http://www.1688.com" target="_blank" rel="nofollow" title="阿里巴巴" class="srsbHotwebsite hotweb02"></a>
						<a href="http://www.tmall.com" target="_blank" rel="nofollow" title="天猫" class="srsbHotwebsite hotweb03"></a>
						<a href="http://www.dangdang.com" target="_blank" rel="nofollow" title="当当" class="srsbHotwebsite hotweb04"></a>
						<a href="http://www.jd.com" target="_blank" rel="nofollow" title="京东" class="srsbHotwebsite hotweb05"></a>
						<a href="http://www.z.cn" target="_blank" rel="nofollow" title="亚马逊" class="srsbHotwebsite hotweb06"></a>
						<a href="http://www.vip.com" target="_blank" rel="nofollow" title="唯品会" class="srsbHotwebsite hotweb07"></a>
						<a href="http://www.meilishuo.com" target="_blank" rel="nofollow" title="美丽说" class="srsbHotwebsite hotweb08"></a>
						<a href="http://www.mogujie.com" target="_blank" rel="nofollow" title="蘑菇街" class="srsbHotwebsite hotweb09"></a>
						<a href="http://gz.jumei.com" target="_blank" rel="nofollow" title="聚美优品" class="srsbHotwebsite hotweb10"></a>
					</div>
				</div>
				<!--右侧的热门电商网站]]-->
			</div>
			<!--右侧的内容]]-->

		</div>
		<!--主体内容]]-->

		<!--分页[[-->
		<div class="pages_change">
		<?php echo $pagination;?>
		</div>
		<!--分页]]-->

	</div>
	<!--新手教学[[-->
	<div class="mTrys">
		<div class="wrap">
			<h2 class="tryNotice">欢迎来到CNstorm，身在海外，轻松代购全中国。</h2>
			<a class="tryBtn" target="_blank" href="/newbie.html">立即体验</a>
		</div>
	</div>
	<!--新手教学]]-->
</div>

<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.e-calendar.js"></script>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/jquery-calendar.css" />
<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>

<div class="dlg_box" id="dlg_box" >
  <div class="ui-dialog-titlebar" id="dlg_box_title"><span id="ui-dialog-title-tasks" class="ui-dialog-title"><?php echo $text_answer ; ?></span><a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="#"><span class="ui-icon ui-icon-closethick">X</span></a></div>
  <div id="dlg_box_contents"></div>
</div>
<div class="dlg_bg" id="dlg_bg" > </div>


<script>
var isHover = false;
function calendarclick(uname_id,uname){
	$('#calendar').eCalendar({uname_id:uname_id,uname:uname});
	$('.calendar').fadeIn(300);
	$(".qiandao").hover(function() {
		isHover = true;
		$(".calendar").show();
	}, function() {
		isHover = false;
		setTimeout(function() {
			if (!isHover) {
				$(".calendar").fadeOut();
			}
		}, 100);
	});
	$(".calendar").hover(function() {
		isHover = true;
	}, function() {
		isHover = false;
		$(".calendar").fadeOut();
	});
}
</script>

<?php echo $footer ?>
</body>
</html>