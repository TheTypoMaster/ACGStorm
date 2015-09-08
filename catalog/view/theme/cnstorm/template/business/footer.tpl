        <!---footer-->
        <div class="f-clear"></div>
        <div class="footer_new">
            <div class="f-row">
                <div class="f-g-1">
                    <div class="focus_us">
                     <h2 style="text-align:left">关注我们</h2>
                     <div class="line"></div>
                     <ul class="focus_list">
                        <li class="facebook">          
                           <dl><dt><a href="https://www.facebook.com/cn.storm" target="_blank"></a></dt></dl>
                        </li>
                        <li class="twitter">
                           <dl><dt><a href="https://twitter.com/cnstorm2014" target="_blank"></a></dt></dl>
                        </li>
                        <li class="weibo">
                           <dl><dt><a href="http://weibo.com/cnstorm" target="_blank"></a></dt></dl>
                        </li>
                        <li class="wechat">
                           <dl><dt><a href="javascript:void(0);"></a></dt></dl>
                           <span class="wechat_hover"></span>
                        </li>
                        <li class="douban">       
                           <dl><dt><a href="http://site.douban.com/237923/" target="_blank"></a></dt></dl>
                        </li>
                        <li class="renren">   
                           <dl><dt><a href="http://www.renren.com/601875401#!/page/" target="_blank"></a></dt></dl>
                        </li>

                     </ul>
                 </div>
                </div>
                <div class="f-g-2">
                    <div class="notice">
                        <h2>公告动态</h2>
                        <div class="line"></div>
                        <ul class="bottominfo-notice">
                        <?php if ($bulletins) { ?>
                          <?php if (count($bulletins) >= 4) $max = 4; else $max = count($bulletins); for($i = 0; $i < $max; $i++) {?>
                            <li><a href="index.php?route=help/announcement&id=2&bid=<?php echo($bulletins[$i]['bulletin_id']); ?>" target="_blank"><?php $str=$bulletins[$i]['name']; $str=mb_strlen($str)>16 ? mb_substr($str,0,16,'utf-8').'...' : $str; echo($str); ?></a></li>
                          <?php } ?>
                        <?php } else { ?>
                          <li><a href="javascript:void(0);">&gt;CNsrom全面升级改版上线</a></li>
                          <li><a href="index.php?route=help/help&qid=7">&gt;十一放假公告</a></li>
                          <li><a href="javascript:void(0);">&gt;新用户注册立即送10元运费抵扣券</a></li>
                          <li><a href="javascript:void(0);">&gt;完成下单体验过程,学生会员免服务费</a></li>
                        <?php } ?>
                      </ul>
                        </div>
                </div>
                
                <div class="f-g-3">
                    <div class="faq">
                        <h2>常见问题</h2>
                        <div class="line"></div>
                        <ul class="bottominfo-notice">
          <li><a href="index.php?route=help/help&qid=10" target="_blank">&gt;代购、自助购、国际转运的区别？</a></li>
          <li><a href="index.php?route=help/help&qid=12" target="_blank">&gt;代购服务如何收费？</a></li>
          <li><a href="index.php?route=help/help&qid=13" target="_blank">&gt;代购订单状态？</a></li>
          <li><a href="index.php?route=help/help&qid=17" target="_blank">&gt;配送范围及时间</a></li>
        </ul>
                        </div>
                </div>
                <div class="f-g-4">
                    <div class="contact">
                        <h2>联系我们</h2>
                        <div class="line"></div>
                        <p class="calls">+86-755-81466633</p>
                        <ul class="bottominfo-body">
          <li>客服邮箱：livechat@cnstorm.com</li>
          <li>工作时间：(周一到周六9:00-18:00)</li>
          <li class="online_staff"><a href="https://chatserver5.comm100.com/chatwindow.aspx?planId=2633&amp;siteId=121670" target="_blank">联系在线客服</a></li>
        </ul>
                        </div>
                </div>
            </div>
        </div>
        <div style="min-width:1200px;height:1px;background:#1b1e25"></div>
        <div style="min-width:1200px;height: 1px;background:#272b35"></div>
        <div class="btm_wrap">
            <div class="foot_symbiosis">
                <div class="f_s_cover">
                    <div class="f_s symbiosis"></div>
                    <div class="f_s ems"></div>
                    <div class="f_s ems1"></div>
                    <div class="f_s dhl"></div>
                    <div class="f_s fedex"></div>
                    <div class="f_s visa_f"></div>
                    <div class="f_s paypal_f"></div>
                    <div class="f_s alipay"></div>
                    <div class="f_s upay"></div>
                    <div class="f_s mst"></div>
                    <div class="f_s jcb"></div>
                </div>
            </div>
<div class="footer">
    <div class="wrap" style="width: 1000px;">
      <ul class="fl">
        Copyright ©   2014信恩世通(CNstorm) All Rights Reserved. <a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备14046771号-1</a>
      </ul>
      <ul class="fr">
          <li><a href="<?php echo $aboutus; ?>" target="_blank">关于CNstorm</a></li>
        |
        <li><a href="<?php echo $contactus; ?>" target="_blank">联系我们</a></li>
        |
        <li><a href="<?php echo $joinus; ?>" target="_blank">加入我们</a></li>
        |
        <li><a href="/help-agreement.html" target="_blank">服务协议</a></li>
        |
        <li><a href="<?php echo $privacy; ?>" target="_blank">隐私声明</a></li>
        |
        <li><a href="<?php echo $normalquestion; ?>" target="_blank">帮助中心</a></li>
        |
        <li><a href="<?php echo $website_map; ?>" target="_blank">网站地图</a></li>
        |
        <li><a href="<?php echo $friends; ?>" target="_blank" rel="nofollow">友情链接</a></li>
      </ul>
    </div>
  </div>
        </div>
        
        <div id="up"  class="gotop up" style=" ">
            <div class="gotop_hover g_h_top"></div>
            <div class="gotop_hover g_h_server" onclick="Comm100API.open_chat_window(event, 2633);"></div>
            <div class="gotop_hover g_h_download"><a href="index.php?route=app/appload" class="g_h_d_hover"></a></div>
            <div class="gotop_hover g_h_feedback" onclick="javascript:window.location = 'http://'+location.host+'/index.php?route=account/login';"></div>
        </div>
        <!----footer end---->

<script type="text/javascript" src="catalog/view/javascript/jquery2/tw_big5.js" mce_src="catalog/view/javascript/jquery2/tw_big5.js"></script> 
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<!--Begin Comm100 Live Chat Code-->
<script type="text/javascript">
    var Comm100API=Comm100API||{chat_buttons:[]};
    Comm100API.chat_buttons.push({code_plan:2633,div_id:'comm100-button-2633'});
  Comm100API.site_id=121670;Comm100API.main_code_plan=2633;
    (function(){
        var lc=document.createElement('script'); 
        lc.type='text/javascript';lc.async=true;
        lc.src='https://chatserver.comm100.com/livechat.ashx?siteId='+Comm100API.site_id;
        var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(lc,s);
    })();
</script>
<!--End Comm100 Live Chat Code-->
<script type="text/javascript">
  var defaultEncoding = 0; 
  var translateDelay = 0; 
  var cookieDomain = "http://www.acgstorm.com"; 
  var msgToTraditionalChinese = "繁體"; 
  var msgToSimplifiedChinese = "简体"; 
  var translateButtonId = "translateLink";
  translateInitilization();

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49083828-1', 'auto');
  ga('send', 'pageview');
$(function(){
        //绑定页面滚动事件
        $(window).bind('scroll',function(){
            var len=$(this).scrollTop();
            if(len>=100){
                //显示回到顶部按钮
                $('#up').show();
            }else{
                //影藏回到顶部按钮
                $('#up').hide();
            }
        });
        //绑定回到顶部按钮的点击事件
        $('.g_h_top').click(function(){
            //动画效果，平滑滚动回到顶部
            $('html,body').animate({scrollTop:'0px'},1000);
            //不需要动画则直接
            //$(document).scrollTop();
        });
        $('.g_h_download').hover(function(){
            $('.g_h_d_hover').fadeIn();
        },function(){
            $('.g_h_d_hover').fadeOut();
        });
});
//ana1
var _mvq = _mvq || [];
_mvq.push(['$setAccount', 'm-92402-0']);

_mvq.push(['$setGeneral', '', '', /*用户名*/ '', /*用户id*/ '']);//如果不传用户名、用户id，此句可以删掉
_mvq.push(['$logConversion']);
(function() {
  var mvl = document.createElement('script');
  mvl.type = 'text/javascript'; mvl.async = true;
  mvl.src = ('https:' == document.location.protocol ? 'https://static-ssl.mediav.com/mvl.js' : 'http://static.mediav.com/mvl.js');
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(mvl, s); 
})(); 
//ana2
window._CWiQ = window._CWiQ || [];
window.BX_CLIENT_ID = 35448; // 帐号ID
(function() {
var c = document.createElement('script')
,p = 'https:'==document.location.protocol;
c.type = 'text/javascript';
c.async = true;
c.src = (p?'https://':'http://')+'whisky.ana.biddingx.com/boot/0';
var h = document.getElementsByTagName('script')[0];
h.parentNode.insertBefore(c, h);
})();
_CWiQ.push(['_trackPdmp', '加入购物车', 1]);
</script> 

//再营销
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 959311665;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/959311665/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>