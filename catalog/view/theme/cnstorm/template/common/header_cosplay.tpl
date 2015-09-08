<div class="wrapBox">
    <div class="header">
        <div class="websiteNabs">
           
            <ul class="wsnItemsRight">
                <?php if (!$logged) { ?>
                <li>
                    <a href="account-login.html" title="登录">登录</a>
                </li>
                <li>
                    <a href="account-register.html" title="注册">注册</a>
                </li>
                <?php } else { ?>
				<li>您好，<a href="/order.html"><?php echo $uname ?></a> ( <a href="/account-logout.html">退出</a> )</li>
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
                <li><a href="/order-order-order_myhome.html">已入库(<span style="color: #f40;"><?php echo $count2 ?></span>)</a></li>
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
            </ul>
            <ul class="tipsShop" style="left:55px;">
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
            <a href="cosplay-main.html" title="ACGstorm" class="cosLogo"></a>
            <div class="lsSearch pab" style="position:relative;">
                <div class="lssbBorder">
					<input type="hidden" name="route" value="" class="lssText fl" id="search2" x-webkit-speech="">
					<input type="search" name="keyword" placeholder="请输入关键字进行搜索" class="lssText fl" id="search2" x-webkit-speech="">
					<input type="submit" value="搜索" class="lssButton fr" id="button-search2"/>
				</div>
                <ul class="lsSupport">
					<li>热搜：</li>
                    <li><a href="cosplay-category-search.html&keyword=love live" target="_blank">love live</a></li>
                    <li><a href="cosplay-category-search.html&keyword=高达" target="_blank">高达</a></li>
                    <li><a href="cosplay-category-search.html&keyword=刀剑乱舞" target="_blank">刀剑乱舞</a></li>
                    <li><a href="cosplay-category-search.html&keyword=英雄联盟" target="_blank">英雄联盟</a></li>
                    <li><a href="cosplay-category-search.html&keyword=冰雪奇缘" target="_blank">冰雪奇缘</a></li>
                    <li><a href="cosplay-category-search.html&keyword=口袋妖怪" target="_blank">口袋妖怪</a></li>
                    <li><a href="cosplay-category-search.html&keyword=精灵王" target="_blank">精灵王</a></li>
                </ul>
            </div>
			<script>
			$(function(){
				$('#button-search2').click(function(){
					var keyword=$.trim($('input[name=keyword]').val());
					if(keyword==''){
						alert('请输入关键字');
						return false;
					}
					var keyword=$('input[name=keyword]').val();
					var url='/index.php?route=cosplay/category/search&keyword='+keyword;
					window.open(url);	
				})
				$('input[name=keyword]').focus(function(){
					$(this).keyup(function(event) {
					var k = event.keyCode;
						if(k==13){
							if($(this).val() !=""){
									var url='/index.php?route=cosplay/category/search&keyword='+$(this).val();
									window.open(url);	
							}
						}
					})
				})
			})
			</script>
        </div>
    </div>
    <div class="navBox">
        <div class="navWrap">
            <ul class="navigations">
                <li>
                    <a href="cosplay-main.html" title="首页">首页</a>
                </li>
                <li>
                    <a href="3_9-cosplay.html" title="cos假发">cos假发</a>
                </li>
                <li>
                    <a href="3_11-cosplay.html" title="cos服装">cos服装</a>
                </li>
                <li>
                    <a href="3_13-cosplay.html" title="cos道具">cos道具</a>
                </li>
                <li>
                    <a href="3_61-cosplay.html" title="cos鞋子">cos鞋子</a>
                </li>
				<li>
                    <a href="0_6-cosplay.html" title="动漫周边">动漫周边</a>
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