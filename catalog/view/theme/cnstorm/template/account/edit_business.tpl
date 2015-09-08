<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>账户资料-设置您的CNstorm账户的个人资料</title>
<meta name="keywords" content="账户管理, CNstorm账户,个人账户，个人设置，个人资料"/>
<meta name="description" content="欢迎到CNstrom个人设置中心，修改个人资料"/>
<link href="catalog/view/theme/cnstorm/stylesheet/jquery.Jcrop.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<link href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/javascript/pl/css/component.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/checkCode.js"></script>
</head> 
<body>

<?php echo $header_cart; ?>
<style>
	.gree {background: url("/images/cosplay/regok.png") no-repeat;display: inline-block;line-height: 25px;height: 25px;width: 130px;color: green;}
	.redcolor { color: red;}
</style>

<?php echo $uc_business; ?>
<script type="text/javascript">
$(function() {
	$("#gg").sjSelect();
	var api = {};
	function isIE() {
		//判断是否是IE浏览器
		if (!+ [1, ]) {
			//是IE浏览器
			createJCrop(1);
			return true;
		} else {
			//单独判断IE10
			if (document.documentMode == 10) {
				createJCrop(1);
				return true;
			} else {
				//非IE浏览器
				createJCrop(0);
				return false;
			}
		}
	}
	//分两种情况创建Jcrop实例，即下面的createJCrop()方法
	function createJCrop(flag) {
		if (flag == 0) {
			//非IE下创建
			$('#big').Jcrop({
				onSelect:updateCoords,
				onChange:updateCoords,
				aspectRatio:1
			});
		} else {
			//IE下创建
			api = $.Jcrop('#big', {
				onSelect:updateCoords,
				onChange:updateCoords,
				aspectRatio:1
			});
		}
	}
	function updateCoords(obj) {
		$("#x").val(obj.x);
		$("#y").val(obj.y);
		$("#w").val(obj.w);
		$("#h").val(obj.h);
		$('#imgsrc').val($('#big').attr('src'));
		if (parseInt(obj.w) > 0) {
			var rx = $("#preview_box").width() / obj.w;
			var ry = $("#preview_box").height() / obj.h;
			var width = Math.round(rx * $("#big").width()) + "px";
			var height = Math.round(rx * $("#big").height()) + "px";
			var marginLeft = "-" + Math.round(rx * obj.x) + "px";
			var marginTop = "-" + Math.round(ry * obj.y) + "px";
			$("#crop_preview").css({
				width:width,
				height:height,
				marginLeft:marginLeft,
				marginTop:marginTop
			});
		}
	}
	$("#crop_submit").click(function() {
		if (parseInt($("#x").val()) >= 0) {
			$("#loading").show();
			$.ajax({
				url:"index.php?route=account/save",
				dataType:"json",
				data:{
					x:$('#x').val(),
					y:$('#y').val(),
					w:$('#w').val(),
					h:$('#h').val(),
					src:$('#imgsrc').val()
				},
				type:"POST",
				success:function(req) {
					$("#loading").hide();
					$("#callinfo").html(' ');
					setTimeout(function() {
						$("#callinfo").html(req.msg);
						$(".images img").attr('src', req.img_r);
					},
					300);
					var bigimg = '<img alt="上传图片" id="big1" src="' + $('#imgsrc').val() + '"/>';
					var smallimg = '<span id="preview_box" class="crop_preview">';
					smallimg += '<img alt="上传图片" id="crop_preview" src="' + req.img_r + '" width="100" height="100"/>';
					smallimg += '</span><p>100*100像素</p>';
					$("#div_upload_big").html('');
					$("#div_upload_big").html(bigimg);
					$("#bigger").html('');
					$("#bigger").html(smallimg);
					$("#crop_form").html(" ");
					var hidimg = '<input type="button" value="已保存" id="crop_submit1"><span id="callinfo"></span>';
					$("#crop_form").html(hidimg);
				},
				error:function() {
					alert("请求失败！");
				}
			});
		} else {
			alert("请先上传图片！");
		}
	});
	$('body').delegate('#fileToUpload', 'change',
	function() {
		$("#loading").show();
		$.ajaxFileUpload({
			url:'index.php?route=account/upload&time=' + new Date(),
			//处理图片脚本
			secureuri:false,
			fileElementId:'fileToUpload',
			//file控件id
			dataType:'json',
			success:function(data, status) {
				if (typeof(data.error) != 'undefined') {
					if (data.error != '') {
						alert(data.error);
					} else {
						$("#loading").hide();
						var bigimg = '<img alt="上传图片" id="big" src="' + data.msg + '"/>';
						$("#div_upload_big").html('');
						$("#div_upload_big").html(bigimg);
						$("#bigger").find("img").attr({
							src:data.msg
						});
						$("#callinfo").html(' ');
						isIE();
					}
				}
			},
			error:function(data, status, e) {
				alert('fail');
			}
		});
		return false;
	});
});
</script>

<div class="content-right">
	<div class="page-title">
		<h2>账户资料</h2>
	</div>
	<div class="persontabChanges">
		<ul class="personDataTabs">
			<li class="curr"><p>账户明细</p></li>
			<li><p>头像照片</p></li>
			<li><p>修改密码</p></li>
			<span class="pdtTips"></span>
		</ul>
	</div>
	
	<div class="personWrap">
		<div class="basic_informs">
			<ul class="account_data">
				<li class="ad_bgcolor1">
					<p class="account_data_infor">推广员级别：<em><?php if($grade==2){echo '高级';}else{echo "普通";} ?></em></p>
					<span class="account_data_icon adicon1"></span>
				</li>
				<li class="ad_bgcolor2">
					<p class="account_data_infor">充值余额：<em>￥<?php if($money){echo $money;}else{echo 0;} ?></em></p>
					<span class="account_data_icon adicon2"></span>
				</li>
				<li class="ad_bgcolor3">
					<p class="account_data_infor">可提款金额：<em>￥<?php if( $CanQuxian){echo $CanQuxian;}else{echo 0;} ?></em></p>
					<span class="account_data_icon adicon3"></span>
				</li>
				<li class="ad_bgcolor4">
					<p class="account_data_infor">冻结余额：<em>￥<?php if( $totalmoney){echo $totalmoney;}else{echo 0;} ?></em><a href="javascript:;" onclick="mingxi()">明细</a></p>
					<span class="account_data_icon adicon4"></span>
				</li>
				<li class="ad_bgcolor5">
					<p class="account_data_infor">当前积分：<em><?php if($allscore){echo $allscore;}else{echo 0;} ?></em></p>
					<span class="account_data_icon adicon5"></span>
				</li>
			</ul>
			<p class="theme_title">热门商城主题</p>
			<ul class="theme_recommend">
				<li>
					<a href="/index.php?route=product/sort&parent_id=201" target="_blank" title="家乡风味">
						<img src="images/site/common/theme_01.jpg" width="240" height="130" alt="家乡风味"/>
					</a>
				</li>
				<li>
					<a href="/index.php?route=product/sort&parent_id=233" target="_blank" title="活动达人">
						<img src="images/site/common/theme_02.jpg" width="240" height="130" alt="活动达人"/>
					</a>
				</li>
				<li>
					<a href="/index.php?route=product/sort&parent_id=212" target="_blank" title="开运风水">
						<img src="images/site/common/theme_03.jpg" width="240" height="130" alt="开运风水"/>
					</a>
				</li>
				<li class="theme_last">
					<a href="/index.php?route=product/sort&parent_id=222" target="_blank" title="礼品馈赠">
						<img src="images/site/common/theme_04.jpg" width="240" height="130" alt="礼品馈赠"/>
					</a>
				</li>
			</ul>
			<!--<div class="account_contents">
				<p>推广员级别：<?php if($grade==1){echo "普通";}else{echo "高级";}?></p>
				<p>充值余额：￥<?php echo $money;?></p>
				<p>可提款奖金金额：￥<?php echo $CanQuxian;?></p>
				<p>冻结金额：￥<?php echo $totalmoney;?> <a href="javascript:void(0);" style="color:#fb6e52;font-size:12px"  onclick="mingxi()">明细</a></p>
				<p>当前积分：<?php echo $allscore;?></p>
			</div>-->
		</div>
		<script>
			
			function mingxi(){
					window.open('/index.php?route=account/edit/getFreeze&uid='+<?php echo $this->customer->getId();?>,'',1389,625);
			}
		</script>
		
		<div class="basic_informs" id="person_center_2">
			<div class="image_left">
				<div class="big_size" id="div_upload_big">
					<?php if($face) { ?>
					<img id="big" alt="头像" src="<?php echo $face; ?>" height="248" width="398">
					<?php }else{ ?>
					<img id="big" alt="头像" src="image/head1.jpg" height="248" width="398">
					<?php } ?>
				</div>
				<p class="about_image">仅支持JPG、GIF、PNG、JPEG、BMP格式，文件小于4M</p>
				<div class="ul_btn">
					<input type="button" id="btn" class="btn" value="选择您要上传的头像"/>
					<input name="fileToUpload" type="file" class="fileToUpload" id="fileToUpload"/>
					<img alt="loading" id="loading" src="image/loading.gif" style="display:none;" class="hid_img"/>
				</div>
			</div>
			<div class="image_right">
				<h3>效果预览</h3>
				<p class="about_upload mb10">您上传的图片会自动生成小尺寸，请注意小尺寸的头像是否清晰</p>
				<ul class="upload_list">
					<li class="bigger" id="bigger">
						<span id="preview_box" class="crop_preview">
							<?php if($face) { ?>
							<img alt="预览头像" id="crop_preview" src="<?php echo $face; ?>" height="100" width="100"/>
							<?php }else{ ?>
							<img alt="预览头像" id="crop_preview" src="image/head1.jpg" width="100" height="100"/>
							<?php } ?>
						</span>
						<p>100*100像素</p>
					</li>
				</ul>
				<div id="crop_form">
					<input type="hidden" id="x" name="x"/>
					<input type="hidden" id="y" name="y"/>
					<input type="hidden" id="w" name="w"/>
					<input type="hidden" id="h" name="h"/>
					<input type="hidden" id="imgsrc" name="imgsrc"/>
					<input type="button" value="保存" id="crop_submit"/>
					<span id="callinfo"></span>
				</div>
			</div>
		</div>
		
		<div class="basic_informs">
			<div class="personForms">
			<form action="/index.php?route=account/password" method="post" id="regPwdForm">
				<div class="pfSplits">
					<label>当前密码：</label>
					<input type="password" name="oldpassword" placeholder="请输入原密码" class="pfsInput1"/><span id="errorMessage_oldpwd"></span>
				</div>
				<div class="pfSplits">
					<label>输入密码：</label>
					<input type="password" name="password" placeholder="6-16位数字、字母和符号，区分大小写" class="pfsInput1"/><span id="errorMessage_newpwd"></span>
				</div>
				<div class="pfSplits">
					<label>确认密码：</label>
					<input type="password" name="confirm" placeholder="请再次输入密码" class="pfsInput1"/><span id="errorMessage_newpwded"></span>
				</div>
				<div class="pfSplits">
					<label>验证码：</label>
					<input type="text" placeholder="请输入验证码" class="pfsInput2"/><span id="errorMessage_code"></span>
					<span id="checkCode" class="pfCaptchas" ></span>
					<span class="pfcChange">看不清？<br/><a href="javascript:void(0);" onclick="createCode()">换一张</a></span>
				</div>
				<div class="pfSplits">
					<label></label>
					<input type="submit" value="提交" class="pfsInput3"/>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

</div>
</div>
<div style="clear:both"></div>
<script type="text/javascript">
$(function(){
	$(".personDataTabs li").click(function(){
		var thisIndex=$(this).index();
		var liWidth=$(this).width();
		$(".basic_informs").eq(thisIndex).show().siblings().hide();
		/*var personWidth=$(".basic_informs").width();
		$(this).addClass("curr").siblings().removeClass("curr");
		$(".personWrap").stop(false,true).animate({"margin-left" : -thisIndex * personWidth},300);*/
		if(thisIndex==0){
			$('.personDataTabs .pdtTips').stop(false,true).animate({'left' : 0 + 'px'},300);
		}else{
			$('.personDataTabs .pdtTips').stop(false,true).animate({'left' : (thisIndex * (liWidth+35)) + 'px'},300);
		}
	});
	$(".personDataTabs li:eq(0)").trigger("click");
});
</script>
<?php echo $footer; ?>
<script type="text/javascript" src="catalog/view/javascript/jquery2/ajaxfileupload.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.Jcrop.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery2/jdate.js"></script>
</body>
</html>