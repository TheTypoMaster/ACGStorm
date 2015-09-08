<div class="wrapBox">
    <div class="header">
        <div class="websiteNabs">
            <ul class="wsnItemsLeft">
                <li>
                    <a href="company-main.html" title="首页" class="wsnia"><i class="wsnil01"></i>首页</a>
                </li>
                <li>
                    <a href="/" title="转运" class="wsnia"><i class="wsnil02"></i>转运</a>
                </li>
                <li>
                    <a href="javascript:void(0);" title="商城" class="wsnia showShops curr"><i class="wsnil03"></i>商城</a>
                </li>
            </ul>
            <ul class="wsnItemsRight">
                <?php if (!$logged) { ?>
                <li>
                    <a href="account-login.html" title="登录">登录</a>
                </li>
                <li>
                    <a href="account-register.html" title="注册">注册</a>
                </li>
                <?php } else { ?>
				<li>您好，<a href="order.html"><?php echo $uname ?></a> ( <a href="/account-logout.html">退出</a> )</li>
				<?php } ?>
                <li>
                    <a href="order.html" title="用户中心">用户中心</a>
                </li>
                <li>
                    <a href="help.html" title="帮助中心">帮助中心</a>
                </li>
                <li>
					<a href="app-appload.html" title="手机APP" class="appdown pre">手机APP<label class="appDownload"></label></a>
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
                <!--
                <li><a href="/checkout-cart.html">购物车(<span style="color: #f40;"><?php echo $count ?></span>)</a></li>
                <li><a href="/order-order-order_myhome.html">已入库(<span style="color: #f40;"><?php //if($logged){ echo $count2;}else{ cho 0;} ?></span>)</a></li>-->
                <li>
                    <a class="intool pre dik" href="javascript:translatePage();" id="translateLink">繁體中文</a>
                    <!--div class="wsniIntools tools">
                        <span class="intool pre dik">
                            <a class="intool pre dik" href="javascript:translatePage();" id="translateLink">繁體中文</a>
                            <b class="itTips"></b>
                        </span>
                        <span class="sublink pab none">
                            <a href="http://www.acgstorm.com/&l=1">English</a>
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
                    <a href="product-mall.html">CNstorm商城</a>
                </li>
                <b class="tsJiantou"><em></em></b>
            </ul>
        </div>
        <div class="logo-search">
            <a href="/" title="CNstorm" class="lsLogo"></a>
            <div class="lsSearch pab" style="position:relative;">
                <!--
                <ul class="lssItems" id="searchUl">
                    <li class="on" data-href="/index.php?route=product/snatch">代购</li>
                    <li data-href="/index.php?route=product/zzg_snatch">自助购</li> 
                    <li data-href="/index.php?route=order/make/order_daiji">代寄</li>
                </ul>-->
                <div class="lssbBorder">
				<form action="/index.php" method="get" target="_blank">
					<input type="hidden" name="route" value="product/sort" class="lssText fl" id="search2" x-webkit-speech="">
					<input type="search" name="keyword" placeholder="请输入关键字进行搜索" class="lssText fl" id="search2" x-webkit-speech="">
					<input type="submit" value="搜索" class="lssButton fr" id="button-search2"/>
				</form>
				</div>
                <ul class="lsSupport">
					<li><a href="index.php?route=product%2Fsort&keyword=风水摆件">风水摆件</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=广式腊肠">广式腊肠</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=窗花剪纸">窗花剪纸</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=皮影">皮影</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=京剧脸谱">京剧脸谱</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=中国结">中国结</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=刺绣">刺绣</a></li>
					<li><a href="index.php?route=product%2Fsort&keyword=青花瓷">青花瓷</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="navBox">
        <div class="navWrap">
            <ul class="navigations">
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