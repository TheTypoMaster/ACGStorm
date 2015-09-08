<link href="catalog/view/theme/cnstorm/css/login_register.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/checkCode_bj.js" type="text/javascript" async="async"></script>
<div class="wrapBox" style="overflow:visible;">

    <div class="header">
        <div class="websiteNabs">
            <ul class="wsnItemsLeft">
                <li>
                    <a href="company-main.html" title="首页" class="wsnia"><i class="wsnil01"></i>首页</a>
                </li>
                <li>
                    <a href="/" title="转运" class="wsnia curr"><i class="wsnil02"></i>转运</a>
                </li>
                <li>
                    <a href="javascript:void(0);" title="商城" class="wsnia showShops"><i class="wsnil03"></i>商城</a>
                </li>
            </ul>
            <ul class="wsnItemsRight">
                <?php if (!$logged) { ?>
                <li>
                    <a href="account-login.html" title="登录">登录</a>
					<div class="login_register_boxs">
						
							<div class="lfTops">
								<h3>登录CNstorm</h3>
								<p>还没有账号？&nbsp;&nbsp;<a href="account-register.html">立即注册</a></p>
							</div>
							<input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI'];?>">
							<p class="error_msg" style="display:none"></p>
							<p class="lfcSplits">
								<input class="input" type="text" name="login_email" value="" placeholder="邮箱地址/用户名" autocomplete="OFF"><span id="message_email"></span>
							</p>
							<p class="lfcSplits">
								<input class="input" type="password" name="login_password" value="" placeholder="密码" autocomplete="OFF"><span id="message_pw"></span>
							</p>
							<p class="lfcSplits">
								<input type="button" value="登录" id="login_btn" class="reg_btn">
							</p>
							<div class="lfcSplits">
								<div>使用合作网站账号登录							
									<p class="lfcsForget">
										<a class="forgot_psw" href="/account-register-newForget.html">忘记密码?</a>
									</p>
								</div>
								<p class="lfcsCooperate">
									<a class="sina" href="https://api.weibo.com/oauth2/authorize?client_id=2144919427&amp;response_type=code&amp;redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_weibo&amp;scope=follow_app_official_microblog,email"></a>
									<a class="qq" href="https://graph.qq.com/oauth2.0/authorize?response_type=code&amp;client_id=100360874&amp;state=9175e816623b111ddb36e19d2b07783d&amp;redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq"></a>
									<a class="wechat" href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc77f5c41a5df661b&amp;redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_wx&amp;response_type=code&amp;scope=snsapi_login&amp;state=STATE#wechat_redirect"></a>
								</p>
							</div>
					
					</div>
                </li>
                <li>
                    <a href="account-register.html" title="注册">注册</a>
					<div class="login_register_boxs">
						<form id="bj_reg_from" action="/index.php?route=account/register&ReturnUrl=<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
							<div class="lfTops">
							  <h3>注册CNstorm</h3>
							  <p>已有账号？&nbsp;&nbsp;<a href="account-login.html">立即登录</a></p>
							</div>
							
							<p class="lfcSplits">
								<input class="input" type="text" name="email" id="email" value="" placeholder="邮箱地址">
								<span id="errorMessage_email" ></span>
							</p>
							<div class="lfcSplits">
								<input class="input" type="text" name="firstname" id="firstname" value="" placeholder="昵称">
								<span id="errorMessage_name"></span>
							</div>
							<p class="lfcSplits">
								<input class="input" type="password" name="password" id="password" value="" placeholder="密码">
								<span id="errorMessage_pwd"></span>
							</p>
							<p class="lfcSplits">
								<input class="input" type="password" name="confirm" id="confirm" value="" placeholder="确认密码">
								<span id="errorMessage_pwded"></span>
							</p>
							<div class="lfcSplits">
								<p class="lfcsp">
									<input class="code_letter input" type="text" value="" id="input" placeholder="验证码">
									<a href="javascript:;">
										<span id="checkCode" class="code_pic" style="background-image: url(http://www.acgstorm.com/image/codeImg/4.jpg);">
											<font color="#1F72D8">m</font>
											<font color="#243F5F">u</font>
											<font color="#16BDB5">g</font>
											<font color="#BF0C43">q</font>
										</span>
									</a>
									<span class="change_code">看不清？ <br>
										<a href="javascript:void(0);" onclick="createCode()">换一张</a>
									</span>
								</p>
								<span id="errorMessage_code"></span>
							</div>
							<div class="lfcSplits">
								<div class="reg_check">
									<input id="chkbox" class="li_checkbox" type="checkbox" name="agree" value="1" checked="checked">
									<label for="chkbox">我已阅读并同意
										<a href="help-agreement.html" target="_blank"><b>《CNstorm会员服务协议》</b></a>
									</label>
								</div>
							</div>
							<div class="lfcSplits">
								<input type="submit" value="注册" class="reg_btn">
							</div>
						</form>
					</div>
                </li>
                <?php } else { ?>
				<li>您好，<a href="order.html"><?php echo $uname ?></a>( <a href="/account-logout.html">退出</a> )</li>
				<?php } ?>
                <li>
                    <a href="order.html" title="用户中心">用户中心</a>
                </li>
                <li>
                    <a href="help.html" title="帮助中心">帮助中心</a>
                </li>
                <li>
                    <div class="wsniIntools tools">
                        <span class="intool pre dik">常用工具<b class="itTips"></b></span>
                        <span class="sublink pab none">
                            <a href="/index.php?route=international/freight/freight2" title="物流运费">物流运费</a>
                            <a href="/help-populartools.html&id=12" title="包裹查询">包裹查询</a>
							<a href="/help-populartools.html&id=10" title="费用估算">费用估算</a>
                            <a href="/help-populartools.html&id=9" title="尺码换算">尺码换算</a>
                            <a href="/help-populartools.html&id=4" title="代购助手">代购助手</a>
                        </span>
                    </div>
                </li>
                <li><a href="/checkout-cart.html">购物车(<span style="color: #f40;"><?php echo $count ?></span>)</a></li>
                <li><a href="/order-order-order_myhome.html">已入库(<span style="color: #f40;"><?php if($logged){echo $count2;}else{echo 0;} ?></span>)</a></li>
                <li>
                    <a class="intool pre dik" href="javascript:translatePage();" id="translateLink">繁體中文</a>
                    <!--div class="wsniIntools tools">
                        <span class="intool pre dik">
                            <a class="intool pre dik" href="javascript:translatePage();" id="translateLink">繁體中文</a>
                            <b class="itTips"></b>
                        </span>
                        <span class="sublink pab none">
                            <a href="/&l=1">English</a>
                        </span>
                    </div -->
                </li>
				<li class="site_map">
					<a href="javascript:void(0);" class="map_menu_title">网站导航
						<span class="sss"></span>
					</a>
					<div class="website_navigation">
						<span class="webnav_close_icon">&times;</span>
						<div class="webnav_boxs menu_boxs1">
							<h4 class="webnav_title">综合电商</h4>
							<ul class="webnav_lists">
								<li>
									<a href="www.acgstorm.com" target="_blank">CNstorm商城<span class="hot_icon"></span></a>
								</li>
								<li>
									<a href="http://www.taobao.com" target="_blank" rel="nofollow">淘宝网</a>
								</li>
								<li>
									<a href="http://www.jd.com" target="_blank" rel="nofollow">京东商城</a>
								</li>
								<li>
									<a href="http://www.tmall.com" target="_blank" rel="nofollow">天猫</a>
								</li>
								<li>
									<a href="http://www.suning.com/" target="_blank" rel="nofollow">苏宁易购</a>
								</li>
								<li>
									<a href="http://www.1688.com" target="_blank" rel="nofollow">阿里巴巴</a>
								</li>
								<li>
									<a href="http://www.z.cn" target="_blank" rel="nofollow">亚马逊</a>
								</li>
								<li>
									<a href="http://www.yhd.com" target="_blank" rel="nofollow">1号店</a>
								</li>
								<li>
									<a href="http://www.dangdang.com" target="_blank" rel="nofollow">当当网</a>
								</li>
							</ul>
						</div>
						<div class="webnav_boxs menu_boxs2">
							<h4 class="webnav_title">服装服饰</h4>
							<ul class="webnav_lists">
								<li>
									<a href="http://www.vip.com" target="_blank" rel="nofollow">唯品会</a>
								</li>
								<li>
									<a href="http://www.moonbasa.com" target="_blank" rel="nofollow">梦芭莎</a>
								</li>
								<li>
									<a href="http://www.fclub.cn" target="_blank" rel="nofollow">聚尚网</a>
								</li>
								<li>
									<a href="http://www.shishangqiyi.com" target="_blank" rel="nofollow">时尚起义</a>
								</li>
								<li>
									<a href="http://www.xiu.com" target="_blank" rel="nofollow">走秀网</a>
								</li>
								<li>
									<a href="http://www.lamiu.com" target="_blank" rel="nofollow">兰缪</a>
								</li>
								<li>
									<a href="http://www.mogujie.com" target="_blank" rel="nofollow">蘑菇街</a>
								</li>
								<li>
									<a href="http://www.meilishuo.com" target="_blank" rel="nofollow">美丽说</a>
								</li>
							</ul>
						</div>
						<div class="webnav_boxs menu_boxs3">
							<h4 class="webnav_title">特色美食</h4>
							<ul class="webnav_lists">
								<li>
									<a href="index.php?route=product/sort&parent_id=201" target="_blank" rel="nofollow">家乡风味</a>
								</li>
								<li>
									<a href="http://www.tangtangwu.cn" target="_blank" rel="nofollow">糖糖屋</a>
								</li>
								<li>
									<a href="http://www.morefood.com" target="_blank" rel="nofollow">猫诚食品</a>
								</li>
								<li>
									<a href="http://gz.womai.com" target="_blank" rel="nofollow">我买网</a>
								</li>
								<li>
									<a href="http://www.lingshikong.com" target="_blank" rel="nofollow">零食控</a>
								</li>
							</ul>
						</div>
						<div class="webnav_boxs menu_boxs4">
							<h4 class="webnav_title">礼品馈赠</h4>
							<ul class="webnav_lists">
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=229" target="_blank">办公文具</a>
								</li>
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=223" target="_blank">国粹文化</a>
								</li>
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=225" target="_blank">游戏动漫<span class="new_icon"></span></a>
								</li>
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=227" target="_blank">潮流装扮</a>
								</li>
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=224" target="_blank">装饰摆设</a>
								</li>
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=228" target="_blank">美容健康</a>
								</li>
								<li>
									<a href="index.php?route=product/sort&parent_id=222&category_id=226" target="_blank">电子数码</a>
								</li>
							</ul>
						</div>
						
					</div>
				</li>
            </ul>
            <ul class="tipsShop">
                <li>
                    <a href="cosplay-main.html">Cosplay商城</a>
                </li>
                <li>
                    <a href="www.acgstorm.com">CNstorm商城</a>
                </li>
                <b class="tsJiantou"><em></em></b>
            </ul>
        </div>
        <div class="logo-search">
            <a href="/" title="CNstorm" class="lsLogo"></a>
            <div class="lsSearch pab" style="position:relative;">
                <ul class="lssItems" id="searchUl">
                    <li class="on" data-href="/index.php?route=product/snatch">代购</li>
                    <li data-href="/index.php?route=product/zzg_snatch">自助购</li> 
                    <li data-href="/index.php?route=order/make/order_daiji">代寄</li>
                </ul>
                <div class="lssbBorder">
					<input type="search" placeholder="粘贴您想购买的中国购物网站的商品地址（URL)" class="lssText fl" id="search" x-webkit-speech="">
					<input type="button" value="我要代购" class="lssButton fr" id="button-search"/>
				</div>
                <ul class="lsSupport">
                    <li>支持商家:</li>
                    <li><a target="_blank" rel="nofollow" href="http://www.taobao.com">淘宝</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.tmall.com">天猫</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.yhd.com">1号店</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.vip.com">唯品会</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.z.cn">亚马逊中国</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.jd.com">京东</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.dangdang.com">当当</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.meilishuo.com">美丽说</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.mogujie.com">蘑菇街</a></li>
                    <li><a target="_blank" rel="nofollow" href="http://www.1688.com">阿里巴巴</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="navBox">
        <div class="navWrap">
            <ul class="navigations">
				<?php if('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']=='http://'.$_SERVER['HTTP_HOST']."/"){ ?>
				<li><a href="www.acgstorm.com" title="商城">商城</a></li>
				<?php } ?>
                <li>
                    <a href="procurement.html" title="代购">代购</a>
                </li>
                <li>
                    <a href="selfshopping.html" title="自助购">自助购</a>
                </li>
                <li>
                    <a href="international-express.html" title="国际转运">国际转运</a>
                </li>
                <li>
                    <a href="information-comments.html" title="用户评价">用户评价</a>
                </li>
				<li>
					<a href="/help-populartools.html&id=10" title="费用估算">费用估算</a>
				</li>
                <!--li>
                    <a href="" title="优惠活动">优惠活动</a>
                </li>
                <li>
                    <a href="" title="网购攻略">网购攻略</a>
                </li -->
                <li>
                    <a href="business-main.html" title="商户版">商户版</a>
                </li>
				<li>
                    <a href="social.html" title="晒尔社区">晒尔社区</a>
                </li>
				<li class="navLast">
					<p class="otherDevices">
						<a href="app-appload.html" class="odIcons01" title="IOS版下载"></a>
						<a href="app-appload.html" class="odIcons02" title="Android版下载"></a>
						<a href="help-populartools.html&id=4" class="odIcons03" title="代购助手"></a>
					</p>
				</li>
            </ul>
        </div>
    </div>
</div>

<script>
$(function(){
	$(".wsnItemsRight li").hover(function(){
		$(this).find(".login_register_boxs").toggle();
	});
})
</script>