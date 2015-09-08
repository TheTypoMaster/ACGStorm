<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title>常用工具</title>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/css/common_help.css" type="text/css" rel="stylesheet"/>
<script src="catalog/view/javascript/jquery2/jquery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script charset="UTF-8" type="text/javascript">
function clickFun()
{  
	$('.tools_cont_1').hide();
	$('.tools_cont_2').hide();
	$('.tools_cont_3').hide();
        $('.tools_cont_'+<?php echo $id ?>).fadeIn();
        $('.ts'+<?php echo $id ?>).addClass('on');
}
</script>
</head>
<body>
<?php echo $header_transport ?>
<div class="goods_details_bg goods_details">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $help_left ;?>
      <div class="user_c_r">
        <div class="intro_cn">
          <ul class="all_tools">
              <li><a class="ts1 ts10" href="javascript:void(0);" onfocus="this.blur();">费用估算</a></li>
            <li><a class="ts2 ts12" href="javascript:void(0);" onfocus="this.blur();">包裹查询</a></li>
            <li><a class="ts3 ts9" href="javascript:void(0);" onfocus="this.blur();">尺码换算</a></li>
            <!-- li><a href="javascript:void(0);" onfocus="this.blur();">汇率换算</a></li -->
            <li><a class="ts4" href="javascript:void(0);" onfocus="this.blur();">代购助手</a></li>
          </ul>
          <div class="tools_cont tools_cont_1 tools_cont_10" style="<?php if(isset($now) && $now =='10' ){ echo 'display:block'; } ?>">
            <dl class="cost_estimate">
              <dt>费用估算，相关明细一目了然</dt>
              <dd>不同的运输方式，商品重量涉及到的相关费用实时计算清楚明了</dd>
            </dl>
            <form id="estimate" action="help-populartools.html" method="post"/>
            <ul class="pickup">
              <li class="bc_change"><a href="javascript:void(0)" onfocus="this.blur();">代购</a><i></i></li>
              <li><a href="javascript:void(0)" onfocus="this.blur();">自助购</a><i></i></li>
              <li><a href="javascript:void(0)" onfocus="this.blur();">转运</a><i></i></li>
              <input name="etype" id="etype" value="代购" type="hidden"/>
            </ul>
            <ul class="calculate">
              <li class="addr"><span>送货地区</span>
                <input id="area" name="area" value="<?php echo $area ?>" realvalue="" placeholder="请选择您的目的地国家" readonly/>
                <input name="area_id" id="area_id" value="" type="hidden"/>
                <div class="country_list">
                  <div class="remen">
                    <h2>热门国家和地区</h2>
                    <ul class="countrylist">
                      <li><a href="javascript:void(0)" id="c_us" cid="1">美国</a></li>
                      <li><a href="javascript:void(0)" cid="2">加拿大</a></li>
                      <li><a href="javascript:void(0)" cid="8">澳大利亚</a></li>
                      <li><a href="javascript:void(0)" cid="16">日本</a></li>
                      <li><a href="javascript:void(0)" cid="13">台湾</a></li>
                      <li><a href="javascript:void(0)" cid="9">新西兰</a></li>
                      <li><a href="javascript:void(0)" cid="4">英国</a></li>
                      <li><a href="javascript:void(0)" cid="15">马来西亚</a></li>
                    </ul>
                  </div>
                  <div class="allcountry">
                    <h2>全部国家和地区</h2>
                    <ul class="countryzm">
                      <li class="zmon"><a href="javascript:void(0)">A</a></li>
                      <li><a href="javascript:void(0)">B</a></li>
                      <li><a href="javascript:void(0)">C</a></li>
                      <li><a href="javascript:void(0)">D</a></li>
                      <li><a href="javascript:void(0)">E</a></li>
                      <li><a href="javascript:void(0)">F</a></li>
                      <li><a href="javascript:void(0)">G</a></li>
                      <li><a href="javascript:void(0)">H</a></li>
                      <li><a href="javascript:void(0)">I</a></li>
                      <li><a href="javascript:void(0)">J</a></li>
                      <li><a href="javascript:void(0)">K</a></li>
                      <li><a href="javascript:void(0)">L</a></li>
                      <li><a href="javascript:void(0)">M</a></li>
                      <li><a href="javascript:void(0)">N</a></li>
                      <li><a href="javascript:void(0)">O</a></li>
                      <li><a href="javascript:void(0)">P</a></li>
                      <li><a href="javascript:void(0)">Q</a></li>
                      <li><a href="javascript:void(0)">R</a></li>
                      <li><a href="javascript:void(0)">S</a></li>
                      <li><a href="javascript:void(0)">T</a></li>
                      <li><a href="javascript:void(0)">U</a></li>
                      <li><a href="javascript:void(0)">V</a></li>
                      <li><a href="javascript:void(0)">W</a></li>
                      <li><a href="javascript:void(0)">X</a></li>
                      <li><a href="javascript:void(0)">Y</a></li>
                      <li><a href="javascript:void(0)">Z</a></li>
                    </ul>
                    <div id="countryTab">
                      <ul class="countrylist">
                        <li><a href="javascript:void(0)" cid="8">澳大利亚</a></li>
                        <li><a href="javascript:void(0)" cid="11">奥地利</a></li>
                        <li><a href="javascript:void(0)" cid="13">澳门</a></li>
                        <li><a href="javascript:void(0)" cid="11">爱尔兰</a></li>
                        <li><a href="javascript:void(0)" cid="14">爱沙尼亚</a></li>
                        <li><a href="javascript:void(0)" cid="28">阿联酋</a></li>
                        <li><a href="javascript:void(0)" cid="14">埃及</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿曼</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿根廷</a></li>
                        <li><a href="javascript:void(0)" cid="14">安哥拉</a></li>
                        <li><a href="javascript:void(0)" cid="14">美属萨摩亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">安道尔共和国</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿尔巴尼亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿富汗</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿塞拜疆</a></li>
                        <li><a href="javascript:void(0)" cid="14">亚美尼亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿尔及利亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">阿鲁巴</a></li>
                        <li><a href="javascript:void(0)" cid="14">安圭拉岛</a></li>
                        <li><a href="javascript:void(0)" cid="14">安提瓜和巴布达</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0)" cid="14">巴西</a></li>
                        <li><a href="javascript:void(0)" cid="14">冰岛</a></li>
                        <li><a href="javascript:void(0)" cid="19">比利时</a></li>
                        <li><a href="javascript:void(0)" cid="14">保加利亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">波斯尼亚和黑塞哥维那</a></li>
                        <li><a href="javascript:void(0)" cid="14">孟加拉国</a></li>
                        <li><a href="javascript:void(0)" cid="14">巴基斯坦</a></li>
                        <li><a href="javascript:void(0)" cid="14">巴林</a></li>
                        <li><a href="javascript:void(0)" cid="14">巴拿马</a></li>
                        <li><a href="javascript:void(0)" cid="14">玻利维亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">秘鲁</a></li>
                        <li><a href="javascript:void(0)" cid="14">巴拉圭</a></li>
                        <li><a href="javascript:void(0)" cid="14">文莱</a></li>
                        <li><a href="javascript:void(0)" cid="14">不丹</a></li>
                        <li><a href="javascript:void(0)" cid="14">白俄罗斯</a></li>
                        <li><a href="javascript:void(0)" cid="14">贝宁</a></li>
                        <li><a href="javascript:void(0)" cid="14">博茨瓦纳</a></li>
                        <li><a href="javascript:void(0)" cid="14">布隆迪</a></li>
                        <li><a href="javascript:void(0)" cid="14">布基纳法索</a></li>
                        <li><a href="javascript:void(0)" cid="14">巴巴多斯</a></li>
                        <li><a href="javascript:void(0)" cid="14">巴哈马国</a></li>
                        <li><a href="javascript:void(0)" cid="14">百慕大群岛(英)</a></li>
                        <li><a href="javascript:void(0)" cid="14">伯利兹</a></li>
                        <li><a href="javascript:void(0)" cid="14">伯奈尔</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0)" cid="2">加拿大 </a></li>
                        <li><a href="javascript:void(0)" cid="14">捷克</a></li>
                        <li><a href="javascript:void(0)" cid="14">克罗地亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">智利</a></li>
                        <li><a href="javascript:void(0)" cid="14">哥伦比亚</a></li>
                        <li><a href="javascript:void(0)" cid="14">柬埔寨</a></li>
                        <li><a href="javascript:void(0)" cid="14">哥斯达黎加</a></li>
                        <li><a href="javascript:void(0)" cid="14">库克群岛</a></li>
                        <li><a href="javascript:void(0)" cid="14">塞浦路斯</a></li>
                        <li><a href="javascript:void(0)" cid="14">加那利群岛</a></li>
                        <li><a href="javascript:void(0)" cid="14">刚果民主共和国</a></li>
                        <li><a href="javascript:void(0)" cid="14">科特迪瓦</a></li>
                        <li><a href="javascript:void(0)" cid="14">佛得角</a></li>
                        <li><a href="javascript:void(0)" cid="14">刚果</a></li>
                        <li><a href="javascript:void(0)" cid="14">喀麦隆</a></li>
                        <li><a href="javascript:void(0)" cid="14">科摩罗</a></li>
                        <li><a href="javascript:void(0)" cid="14">乍得</a></li>
                        <li><a href="javascript:void(0)" cid="14">中非共和国</a></li>
                        <li><a href="javascript:void(0)" cid="14">古巴</a></li>
                        <li><a href="javascript:void(0);" cid="14">开曼群岛(英)</a></li>
                        <li><a href="javascript:void(0);" cid="14">库拉索岛</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="27">德国</a></li>
                        <li><a href="javascript:void(0);" cid="11">丹麦</a></li>
                        <li><a href="javascript:void(0);" cid="14">吉布提</a></li>
                        <li><a href="javascript:void(0);" cid="14">多米尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">多米尼亚共和国</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="14">爱沙尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">俄罗斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">埃及</a></li>
                        <li><a href="javascript:void(0);" cid="14">厄瓜多尔</a></li>
                        <li><a href="javascript:void(0);" cid="14">东帝汶</a></li>
                        <li><a href="javascript:void(0);" cid="14">埃塞俄比亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">厄立特里亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">萨尔瓦多</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="25">法国</a></li>
                        <li><a href="javascript:void(0);" cid="12">菲律宾</a></li>
                        <li><a href="javascript:void(0);" cid="11">芬兰</a></li>
                        <li><a href="javascript:void(0);" cid="14">孟加拉国</a></li>
                        <li><a href="javascript:void(0);" cid="11">梵蒂冈</a></li>
                        <li><a href="javascript:void(0);" cid="14">斐济</a></li>
                        <li><a href="javascript:void(0);" cid="14">法罗群岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">福克兰群岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">法属圭亚那</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="27">德国</a></li>
                        <li><a href="javascript:void(0);" cid="14">希腊</a></li>
                        <li><a href="javascript:void(0);" cid="14">哥伦比亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">直布罗陀</a></li>
                        <li><a href="javascript:void(0);" cid="14">哥斯达黎加</a></li>
                        <li><a href="javascript:void(0);" cid="14">危地马拉</a></li>
                        <li><a href="javascript:void(0);" cid="14">关岛(美)</a></li>
                        <li><a href="javascript:void(0);" cid="14">根西岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">格陵兰岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">格鲁吉亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">赤道几内亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">冈比亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">几内亚比绍</a></li>
                        <li><a href="javascript:void(0);" cid="14">加纳</a></li>
                        <li><a href="javascript:void(0);" cid="14">加蓬</a></li>
                        <li><a href="javascript:void(0);" cid="14">几内亚共和国</a></li>
                        <li><a href="javascript:void(0);" cid="14">格林纳达</a></li>
                        <li><a href="javascript:void(0);" cid="14">瓜德罗普岛(法)</a></li>
                        <li><a href="javascript:void(0);" cid="14">圭亚那</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="26">荷兰</a></li>
                        <li><a href="javascript:void(0);" cid="13">香港</a></li>
                        <li><a href="javascript:void(0);" cid="12">韩国</a></li>
                        <li><a href="javascript:void(0);" cid="11">匈牙利</a></li>
                        <li><a href="javascript:void(0);" cid="14">洪都拉斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">哈萨克斯坦</a></li>
                        <li><a href="javascript:void(0);" cid="14">海地</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="20">意大利</a></li>
                        <li><a href="javascript:void(0);" cid="14">冰岛</a></li>
                        <li><a href="javascript:void(0);" cid="11">爱尔兰</a></li>
                        <li><a href="javascript:void(0);" cid="12">印度尼西亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">印度</a></li>
                        <li><a href="javascript:void(0);" cid="14">以色列</a></li>
                        <li><a href="javascript:void(0);" cid="14">伊朗</a></li>
                        <li><a href="javascript:void(0);" cid="14">伊拉克</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="2">加拿大 </a></li>
                        <li><a href="javascript:void(0);" cid="16">日本</a></li>
                        <li><a href="javascript:void(0);" cid="14">捷克</a></li>
                        <li><a href="javascript:void(0);" cid="14">约旦</a></li>
                        <li><a href="javascript:void(0);" cid="12">柬埔寨</a></li>
                        <li><a href="javascript:void(0);" cid="14">泽西岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">牙买加</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="12">韩国</a></li>
                        <li><a href="javascript:void(0);" cid="14">克罗地亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">科威特</a></li>
                        <li><a href="javascript:void(0);" cid="14">卡塔尔</a></li>
                        <li><a href="javascript:void(0);" cid="14">朝鲜</a></li>
                        <li><a href="javascript:void(0);" cid="14">基里巴斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">哈萨克斯坦</a></li>
                        <li><a href="javascript:void(0);" cid="14">吉尔吉斯斯坦</a></li>
                        <li><a href="javascript:void(0);" cid="14">科索沃</a></li>
                        <li><a href="javascript:void(0);" cid="14">肯尼亚</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="11">卢森堡</a></li>
                        <li><a href="javascript:void(0);" cid="11">挪威</a></li>
                        <li><a href="javascript:void(0);" cid="14">立陶宛</a></li>
                        <li><a href="javascript:void(0);" cid="14">拉脱维亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">罗马尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">列支敦士登</a></li>
                        <li><a href="javascript:void(0);" cid="14">老挝</a></li>
                        <li><a href="javascript:void(0);" cid="14">黎巴嫩</a></li>
                        <li><a href="javascript:void(0);" cid="14">利比亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">莱索托</a></li>
                        <li><a href="javascript:void(0);" cid="14">利比里亚</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="1">美国</a></li>
                        <li><a href="javascript:void(0);" cid="13">澳门</a></li>
                        <li><a href="javascript:void(0);" cid="15">马来西亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">墨西哥</a></li>
                        <li><a href="javascript:void(0);" cid="14">摩那哥</a></li>
                        <li><a href="javascript:void(0);" cid="14">马尔代夫</a></li>
                        <li><a href="javascript:void(0);" cid="14">马绍尔群岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">缅甸</a></li>
                        <li><a href="javascript:void(0);" cid="14">马耳他</a></li>
                        <li><a href="javascript:void(0);" cid="14">黑山共和国</a></li>
                        <li><a href="javascript:void(0);" cid="14">马其顿</a></li>
                        <li><a href="javascript:void(0);" cid="14">摩尔多瓦共和国</a></li>
                        <li><a href="javascript:void(0);" cid="14">马达加斯加</a></li>
                        <li><a href="javascript:void(0);" cid="14">马拉维</a></li>
                        <li><a href="javascript:void(0);" cid="14">马约特</a></li>
                        <li><a href="javascript:void(0);" cid="14">毛里求斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">毛里塔尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">莫桑比克</a></li>
                        <li><a href="javascript:void(0);" cid="14">马里</a></li>
                        <li><a href="javascript:void(0);" cid="14">马提尼克</a></li>
                        <li><a href="javascript:void(0);" cid="14">蒙古</a></li>
                        <li><a href="javascript:void(0);" cid="14">蒙特塞拉特岛</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="9">新西兰</a></li>
                        <li><a href="javascript:void(0);" cid="26">荷兰</a></li>
                        <li><a href="javascript:void(0);" cid="11">挪威</a></li>
                        <li><a href="javascript:void(0);" cid="14">南非</a></li>
                        <li><a href="javascript:void(0);" cid="14">尼加拉瓜</a></li>
                        <li><a href="javascript:void(0);" cid="14">纳米比亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">尼日利亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">瑙鲁</a></li>
                        <li><a href="javascript:void(0);" cid="14">尼泊尔</a></li>
                        <li><a href="javascript:void(0);" cid="14">新喀里多尼亚群岛(法)</a></li>
                        <li><a href="javascript:void(0);" cid="14">尼日尔</a></li>
                        <li><a href="javascript:void(0);" cid="14">尼维斯岛</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="14">阿曼</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="12">菲律宾</a></li>
                        <li><a href="javascript:void(0);" cid="11">葡萄牙</a></li>
                        <li><a href="javascript:void(0);" cid="14">波兰</a></li>
                        <li><a href="javascript:void(0);" cid="14">巴基斯坦</a></li>
                        <li><a href="javascript:void(0);" cid="14">巴拿马</a></li>
                        <li><a href="javascript:void(0);" cid="14">秘鲁</a></li>
                        <li><a href="javascript:void(0);" cid="14">巴拉圭</a></li>
                        <li><a href="javascript:void(0);" cid="14">巴布亚新几内亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">波多黎各</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="14">卡塔尔</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="11">瑞典</a></li>
                        <li><a href="javascript:void(0);" cid="16">日本</a></li>
                        <li><a href="javascript:void(0);" cid="11">瑞士</a></li>
                        <li><a href="javascript:void(0);" cid="14">罗马尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">俄罗斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">留尼旺岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">卢旺达</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="11">西班牙</a></li>
                        <li><a href="javascript:void(0);" cid="11">瑞典</a></li>
                        <li><a href="javascript:void(0);" cid="12">新加坡</a></li>
                        <li><a href="javascript:void(0);" cid="11">瑞士</a></li>
                        <li><a href="javascript:void(0);" cid="14">斯洛文尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">斯洛伐克</a></li>
                        <li><a href="javascript:void(0);" cid="14">沙特阿拉伯</a></li>
                        <li><a href="javascript:void(0);" cid="14">南非</a></li>
                        <li><a href="javascript:void(0);" cid="14">叙利亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣马力诺</a></li>
                        <li><a href="javascript:void(0);" cid="14">塞尔维亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">萨摩亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">塞班岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">所罗门群岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">斯里兰卡</a></li>
                        <li><a href="javascript:void(0);" cid="14">苏丹</a></li>
                        <li><a href="javascript:void(0);" cid="14">塞内加尔</a></li>
                        <li><a href="javascript:void(0);" cid="14">塞舌尔</a></li>
                        <li><a href="javascript:void(0);" cid="14">斯威士兰</a></li>
                        <li><a href="javascript:void(0);" cid="14">索马里</a></li>
                        <li><a href="javascript:void(0);" cid="14">索马里兰</a></li>
                        <li><a href="javascript:void(0);" cid="14">塞拉利昂</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣巴特勒米岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣多美和普林西</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣基茨岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣卢西亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣马丁岛</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣文森特</a></li>
                        <li><a href="javascript:void(0);" cid="14">圣尤斯特歇斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">苏里南</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="13">台湾</a></li>
                        <li><a href="javascript:void(0);" cid="14">土耳其</a></li>
                        <li><a href="javascript:void(0);" cid="12">泰国</a></li>
                        <li><a href="javascript:void(0);" cid="14">坦桑尼亚</a></li>
                        <li><a href="javascript:void(0);" cid="14">塔希提</a></li>
                        <li><a href="javascript:void(0);" cid="14">汤加</a></li>
                        <li><a href="javascript:void(0);" cid="14">图瓦卢</a></li>
                        <li><a href="javascript:void(0);" cid="14">塔吉克斯坦</a></li>
                        <li><a href="javascript:void(0);" cid="14">多哥</a></li>
                        <li><a href="javascript:void(0);" cid="14">突尼斯</a></li>
                        <li><a href="javascript:void(0);" cid="14">特立尼达和多巴哥</a></li>
                        <li><a href="javascript:void(0);" cid="14">特克斯和凯科斯群岛</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="1">美国</a></li>
                        <li><a href="javascript:void(0);" cid="4">英国</a></li>
                        <li><a href="javascript:void(0);" cid="14">乌克兰</a></li>
                        <li><a href="javascript:void(0);" cid="14">乌拉圭</a></li>
                        <li><a href="javascript:void(0);" cid="14">乌兹别克斯坦</a></li>
                        <li><a href="javascript:void(0);" cid="14">阿拉伯联合酋长国</a></li>
                        <li><a href="javascript:void(0);" cid="14">乌干达</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="14">越南</a></li>
                        <li><a href="javascript:void(0);" cid="14">委内瑞拉</a></li>
                        <li><a href="javascript:void(0);" cid="14">瓦努阿图</a></li>
                        <li><a href="javascript:void(0);" cid="14">维尔京群岛（美）</a></li>
                        <li><a href="javascript:void(0);" cid="14">维尔京群岛（英属）</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="14">乌克兰</a></li>
                        <li><a href="javascript:void(0);" cid="14">危地马拉</a></li>
                        <li><a href="javascript:void(0);" cid="14">乌拉圭</a></li>
                        <li><a href="javascript:void(0);" cid="14">委内瑞拉</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="9">新西兰</a></li>
                        <li><a href="javascript:void(0);" cid="11">西班牙</a></li>
                        <li><a href="javascript:void(0);" cid="14">希腊</a></li>
                        <li><a href="javascript:void(0);" cid="13">香港</a></li>
                        <li><a href="javascript:void(0);" cid="12">新加坡</a></li>
                        <li><a href="javascript:void(0);" cid="11">匈牙利</a></li>
                        <li><a href="javascript:void(0);" cid="14">叙利亚</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="4">英国</a></li>
                        <li><a href="javascript:void(0);" cid="20">意大利</a></li>
                        <li><a href="javascript:void(0);" cid="12">印度尼西亚</a></li>
                        <li><a href="javascript:void(0);" cid="12">越南</a></li>
                        <li><a href="javascript:void(0);" cid="14">印度</a></li>
                        <li><a href="javascript:void(0);" cid="14">以色列</a></li>
                        <li><a href="javascript:void(0);" cid="14">伊朗</a></li>
                        <li><a href="javascript:void(0);" cid="14">约旦</a></li>
                        <li><a href="javascript:void(0);" cid="14">也门共和国</a></li>
                      </ul>
                      <ul class="countrylist" style="display:none">
                        <li><a href="javascript:void(0);" cid="6">中国</a></li>
                        <li><a href="javascript:void(0);" cid="14">智利</a></li>
                        <li><a href="javascript:void(0);" cid="14">直布罗陀</a></li>
                        <li><a href="javascript:void(0);" cid="14">津巴布韦</a></li>
                        <li><a href="javascript:void(0);" cid="14">赞比亚</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </li>
              <li class="weights"><span>包裹重量（含包装）</span>
                <input name="weight" value="<?php echo $weight ?>"/>
                <small>克</small> </li>
              <!-- li class="price"><span>商品价格</span>
                <input name="cost" value="" placeholder="请输入您购买的商品费用" />
                <small>元</small> </li -->
              <li class="size"><span>包裹尺寸</span>
                <input name="length" class="text_input" type="text" />
                <small>CM</small> <b>长</b>
                <input name="width" class="text_input" type="text" />
                <small>CM</small> <b>宽</b>
                <input name="height" class="text_input" type="text" />
                <small>CM</small> <b>高</b>
                <input class="button_input" value="开始计算" onclick="toEstimate()" type="button" />
					<span class="volumn_notice">(用于计算体积重量，可不填)</span>
					<b class="red" id="noaddress" style="float: right;margin: -44px -83px;">请选择寄送国家</b>
					<b class="red" style="float: right;margin: -44px -83px;" id="noweight">请输入包裹重量</b>
				</li>
            </ul>
            </form>
            <?php if ($carriers) {	?>
            <div class="ssjieguo">
              <div class="jgtop">
                <h2>以下为运送到“<em><?php echo $area ?></em>”的试算结果</h2>
                <p><span>重量：<?php echo $weight ?>g</span></p>
              </div>
              <div class="biao">
                <?php foreach ($carriers as $carrier) { ?>
                <table class="goods_table" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="bg_color">
                      <td width="158">运送方式</td>
                      <td width="109">运费</td>
                      <td width="108">服务费</td>
                      <td width="98">报关费</td>
                      <td width="129">时效(工作日)</td>
                      <td width="138">总计</td>
                      <td width="138">操作</td>
                    </tr>
                    <tr>
                      <td><img src="<?php echo $carrier['carrierLogo'] ?>" alt="运送方式"/><?php echo $carrier['deliveryname'] ?></td>
                      <td>￥<?php echo $carrier['freight']?></td>
                      <td>￥<?php echo $carrier['servefee'] ?></td>
                      <td>￥8.00</td>
                      <td><?php echo $carrier['delivery_time'] ?></td>
                      <td>￥<?php echo $carrier['total'] ?></td>
                      <td><a href="order-make.html">
                        <input class="button_order" value="下单" type="button">
                        </a></td>
                    </tr>
                  </tbody>
                </table>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <div class="estimate_notice">
              <ul class="title_normal">体积重量</ul>
              <ul>
			  体积重量是一种反映包裹密度的计算方式。低密度的包裹，比较其实际重量，占用的空间通常较大。<br/>
			  计算出来的体积重量，会与其实际重量比较，取较重者为计费重量，用以计算运费。<br/>
			  根据市场惯例，体积重量的计算方法为：长度(cm) x 宽度(cm) x 高度(cm) ÷ 5000(计算方法都是按地区及市场惯例决定, 当中可能各有差异)
              </ul>
            </div>
            <div class="estimate_notice">
              <ul class="title_normal">常见物品参考重量</ul>
              <ul class="weight_reference">
                <li>
                  <dl style="padding-left: 7px;">
                    <dt>外套</dt>
                    <dd>1200克</dd>
                  </dl>
                </li>
                <li>
                  <dl style="padding-left: 16px;">
                    <dt>鞋子</dt>
                    <dd>1000克</dd>
                  </dl>
                </li>
                <li>
                  <dl style="padding-left: 32px;">
                    <dt>包包</dt>
                    <dd>1000克</dd>
                  </dl>
                </li>
                <li>
                  <dl style="padding-left: 39px;">
                    <dt>帽子</dt>
                    <dd>300克</dd>
                  </dl>
                </li>
                <li>
                  <dl style="padding-left: 39px;">
                    <dt>内衣</dt>
                    <dd>150克</dd>
                  </dl>
                </li>
                <li>
                  <dl style="padding-left: 49px;">
                    <dt>裙子</dt>
                    <dd>180克</dd>
                  </dl>
                </li>
                <li>
                  <dl style="padding-left: 57px;">
                    <dt>书</dt>
                    <dd>500克</dd>
                  </dl>
                </li>
              </ul>
            </div>
          </div>
          <div class="tools_cont tools_cont_2 tools_cont_12" style="display:none;">
            <dl class="package_online">
              <dt><b>包裹状态</b>网上实时查询</dt>
              <dd>不同的寄送方式在寄送时间期限上会有所不同，包裹运送至国外将由当地邮局派送，物流信息会存在一定的滞后。</dd>
            </dl>
            <dl style="text-align:center;">
              <iframe name="kuaidi100" src="http://baidu.kuaidi100.com/index2.html" width="690" height="480" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>
            </dl>
          </div>
          <div class="tools_cont tools_cont_3 tools_cont_9" style="display:none;">
            <dl class="practical_measure">
              <dt>实用尺码，一目了然</dt>
              <dd>中国与全球各国尺码换算各不相同，CNstorm为你提供标准换算明细 </dd>
            </dl>
            <div class="measure_types">
              <dl>
                <dt>女士</dt>
                <dd><a href="#woman">女装（外衣、裙装、恤衫、上装、套装）</a></dd>
                <dd><a href="#bra">女士文胸</a>&nbsp;&nbsp;<a href="#bra1">女式内衣</a>&nbsp;&nbsp;<a href="#womanshoes">女鞋</a></dd>
              </dl>
              <dl>
                <dt>男士</dt>
                <dd><a href="#man">男装（外衣、恤衫、套装）</a></dd>
                <dd><a href="#manpants">男士裤装</a>&nbsp;&nbsp;<a href="#manshirts">男士衬衫</a>&nbsp;&nbsp;<a href="#manunderwear">男士内裤</a>&nbsp;&nbsp;<a href="#manshoes">男鞋</a></dd>
              </dl>
              <dl>
                <dt>常用度量衡量换算</dt>
                <dd><a href="#uesefulsize">长度  面积   体积/容量   重量</a></dd>
                <dd>&nbsp;</dd>
              </dl>
            </div>
            <div class="cloth_tit">
              <h3><a name="woman">女装<em>（外衣、裙装、恤衫、上装、套装）</em></a></h3>
              <span class="cloth_one"></span>
              <table class="table_one" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国(cm)</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">160-165/84-86</td>
                            <td width="138" class="border_rb">165-170/88-90</td>
                            <td width="138" class="border_rb">167-172/92-96</td>
                            <td width="138" class="border_rb">168-173/98-102</td>
                            <td width="140" class="border_b">168-173/98-102</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">国际</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">XS</td>
                            <td width="138" class="border_rb">S</td>
                            <td width="138" class="border_rb">M</td>
                            <td width="138" class="border_rb">L</td>
                            <td width="140" class="border_b">XL</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">美国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">2</td>
                            <td width="138" class="border_rb">4-6</td>
                            <td width="138" class="border_rb">8-10</td>
                            <td width="138" class="border_rb">12-14</td>
                            <td width="140" class="border_b">16-18</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">欧洲</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_r">34</td>
                            <td width="138" class="border_r">34-36</td>
                            <td width="138" class="border_r">38-40</td>
                            <td width="138" class="border_r">42</td>
                            <td width="140">44</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="bra">女士文胸</a></h3>
              <span class="cloth_two"></span>
              <table class="table_two" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国(cm)</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="46" height="48" class="border_rb">76.2</td>
                            <td width="46" class="border_rb">81.3</td>
                            <td width="46" class="border_rb">86.4</td>
                            <td width="46" class="border_rb">97.5</td>
                            <td width="46" class="border_rb">96.5</td>
                            <td width="58" class="border_rb">101.6</td>
                            <td width="58" class="border_rb">106.7</td>
                            <td width="58" class="border_rb">112</td>
                            <td width="58" class="border_rb">117</td>
                            <td width="58" class="border_rb">122</td>
                            <td width="58" class="border_rb">127</td>
                            <td width="58" class="border_rb">132</td>
                            <td width="58" class="border_rb">137</td>
                            <td width="59" class="border_b">142></td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">美国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="42" height="48" class="border_rb">30</td>
                            <td width="42" class="border_rb">32</td>
                            <td width="43" class="border_rb">34</td>
                            <td width="42" class="border_rb">36</td>
                            <td width="42" class="border_rb">38</td>
                            <td width="54" class="border_rb">40</td>
                            <td width="53" class="border_rb">42</td>
                            <td width="51" class="border_rb">44</td>
                            <td width="51" class="border_rb">46</td>
                            <td width="52" class="border_rb">48</td>
                            <td width="51" class="border_rb">50</td>
                            <td width="51" class="border_rb">52</td>
                            <td width="51" class="border_rb">54</td>
                            <td width="54" class="border_b">56</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">英国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="42" height="48" class="border_rb">30</td>
                            <td width="42" class="border_rb">32</td>
                            <td width="43" class="border_rb">34</td>
                            <td width="42" class="border_rb">36</td>
                            <td width="42" class="border_rb">38</td>
                            <td width="54" class="border_rb">40</td>
                            <td width="53" class="border_rb">42</td>
                            <td width="51" class="border_rb">44</td>
                            <td width="51" class="border_rb">46</td>
                            <td width="52" class="border_rb">48</td>
                            <td width="51" class="border_rb">50</td>
                            <td width="51" class="border_rb">52</td>
                            <td width="51" class="border_rb">54</td>
                            <td width="54" class="border_b">56</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">欧洲</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="42" height="48" class="border_rb">&nbsp;</td>
                            <td width="42" class="border_rb">70</td>
                            <td width="43" class="border_rb">75</td>
                            <td width="42" class="border_rb">80</td>
                            <td width="42" class="border_rb">85</td>
                            <td width="54" class="border_rb">90</td>
                            <td width="53" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="52" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="54" class="border_b">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">法国</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="42" height="48" class="border_rb">&nbsp;</td>
                            <td width="42" class="border_rb">85</td>
                            <td width="43" class="border_rb">90</td>
                            <td width="42" class="border_rb">95</td>
                            <td width="42" class="border_rb">100</td>
                            <td width="54" class="border_rb">105</td>
                            <td width="53" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="52" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="51" class="border_rb">&nbsp;</td>
                            <td width="54" class="border_b">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">意大利</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="42" height="48" class="border_r">&nbsp;</td>
                            <td width="42" class="border_r">1</td>
                            <td width="43" class="border_r">2</td>
                            <td width="42" class="border_r">3</td>
                            <td width="42" class="border_r">4</td>
                            <td width="54" class="border_r">5</td>
                            <td width="53" class="border_r">&nbsp;</td>
                            <td width="51" class="border_r">&nbsp;</td>
                            <td width="51" class="border_r">&nbsp;</td>
                            <td width="52" class="border_r">&nbsp;</td>
                            <td width="51" class="border_r">&nbsp;</td>
                            <td width="51" class="border_r">&nbsp;</td>
                            <td width="51" class="border_r">&nbsp;</td>
                            <td width="54">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="bra1">女士内衣</a></h3>
              <span class="cloth_three"></span>
              <table class="table_three" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国(cm)</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">S</td>
                            <td width="85" class="border_rb">M</td>
                            <td width="85" class="border_rb">L</td>
                            <td width="85" class="border_rb">XL</td>
                            <td width="98" class="border_rb">XXL</td>
                            <td width="123" class="border_rb">XXXL</td>
                            <td width="127" class="border_b">&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">美国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">XS</td>
                            <td width="85" class="border_rb">S</td>
                            <td width="85" class="border_rb">M</td>
                            <td width="85" class="border_rb">L</td>
                            <td width="98" class="border_rb">XL</td>
                            <td width="123" class="border_rb">XXL</td>
                            <td width="127" class="border_b">XXXL</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">英国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">6</td>
                            <td width="85" class="border_rb">8</td>
                            <td width="85" class="border_rb">10</td>
                            <td width="85" class="border_rb">12</td>
                            <td width="98" class="border_rb">14</td>
                            <td width="123" class="border_rb">16</td>
                            <td width="127" class="border_b">18</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">欧洲</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">32</td>
                            <td width="85" class="border_rb">34</td>
                            <td width="85" class="border_rb">36</td>
                            <td width="85" class="border_rb">38</td>
                            <td width="98" class="border_rb">40</td>
                            <td width="123" class="border_rb">42</td>
                            <td width="127" class="border_b">44</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">法国</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">34</td>
                            <td width="85" class="border_rb">36</td>
                            <td width="85" class="border_rb">38</td>
                            <td width="85" class="border_rb">40</td>
                            <td width="98" class="border_rb">42</td>
                            <td width="123" class="border_rb">44</td>
                            <td width="127" class="border_b">46</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">意大利</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_r">38</td>
                            <td width="85" class="border_r">40</td>
                            <td width="85" class="border_r">42</td>
                            <td width="85" class="border_r">44</td>
                            <td width="98" class="border_r">46</td>
                            <td width="123" class="border_r">48</td>
                            <td width="127">50</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="womanshoes">女鞋</a></h3>
              <span class="cloth_four"></span>
              <table class="table_four" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">脚长(cm)</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">22.5</td>
                            <td width="85" class="border_rb">23</td>
                            <td width="87" class="border_rb">23.5</td>
                            <td width="85" class="border_rb">24</td>
                            <td width="87" class="border_rb">24.5</td>
                            <td width="85" class="border_rb">25</td>
                            <td width="86" class="border_rb">25.5</td>
                            <td width="87" class="border_b">26</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">35</td>
                            <td width="85" class="border_rb">36</td>
                            <td width="87" class="border_rb">37</td>
                            <td width="85" class="border_rb">38</td>
                            <td width="87" class="border_rb">39</td>
                            <td width="85" class="border_rb">39</td>
                            <td width="86" class="border_rb">40</td>
                            <td width="87" class="border_b">40</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">美国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">5</td>
                            <td width="85" class="border_rb">5.5</td>
                            <td width="87" class="border_rb">6</td>
                            <td width="85" class="border_rb">6.5</td>
                            <td width="87" class="border_rb">7</td>
                            <td width="85" class="border_rb">7.5</td>
                            <td width="86" class="border_rb">8</td>
                            <td width="87" class="border_b">8.5</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">英国</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_rb">4</td>
                            <td width="85" class="border_rb">4.5</td>
                            <td width="87" class="border_rb">5</td>
                            <td width="85" class="border_rb">5.5</td>
                            <td width="87" class="border_rb">6</td>
                            <td width="85" class="border_rb">6.5</td>
                            <td width="86" class="border_rb">7</td>
                            <td width="87" class="border_b">7.5</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">欧洲</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="85" height="48" class="border_r">35</td>
                            <td width="85" class="border_r">36</td>
                            <td width="87" class="border_r">37</td>
                            <td width="85" class="border_r">38</td>
                            <td width="87" class="border_r">39</td>
                            <td width="85" class="border_r">39</td>
                            <td width="86" class="border_r">40</td>
                            <td width="87">40</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="man">男装<em>（外衣、恤衫、套装）</em></a></h3>
              <span class="cloth_five"></span>
              <table class="table_five" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国(cm)</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">165/88-90</td>
                            <td width="138" class="border_rb">170/96-98</td>
                            <td width="138" class="border_rb">175/108-110</td>
                            <td width="138" class="border_rb">180/118-122</td>
                            <td width="138" class="border_b">185/126-130</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">国际</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_r">S</td>
                            <td width="138" class="border_r">M</td>
                            <td width="138" class="border_r">L</td>
                            <td width="138" class="border_r">XL</td>
                            <td width="138">XXL</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="manpants">男士裤装</a></h3>
              <span class="cloth_six"></span>
              <table class="table_six" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">尺码</td>
                    <td><table align="center" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">42</td>
                            <td width="138" class="border_rb">44</td>
                            <td width="138" class="border_rb">46</td>
                            <td width="138" class="border_rb">48</td>
                            <td width="138" class="border_b">50</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">腰围</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">68-72cm</td>
                            <td width="138" class="border_rb">71-76cm</td>
                            <td width="138" class="border_rb">75-80cm</td>
                            <td width="138" class="border_rb">79-84cm</td>
                            <td width="138" class="border_b">83-88cm</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">裤长</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_r">99cm</td>
                            <td width="138" class="border_r">101.5cm</td>
                            <td width="138" class="border_r">104cm</td>
                            <td width="138" class="border_r">106.5cm</td>
                            <td width="138">109cm</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="manshirts">男士衬衫</a></h3>
              <span class="cloth_seven"></span>
              <table class="table_seven" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国(cm)</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">36-37</td>
                            <td width="138" class="border_rb">38-39</td>
                            <td width="138" class="border_rb">40-42</td>
                            <td width="138" class="border_rb">43-44</td>
                            <td width="138" class="border_b">45-47</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">国际</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_r">S</td>
                            <td width="138" class="border_r">M</td>
                            <td width="138" class="border_r">L</td>
                            <td width="138" class="border_r">XL</td>
                            <td width="138">XXL</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="manunderwear">男士内裤</a></h3>
              <span class="cloth_eight"></span>
              <table class="table_seven" align="center" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="78" height="48" class="border_rb font_18">标准</td>
                    <td width="694" class="border_b font_18">尺码明细</td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">中国(cm)</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">72-76</td>
                            <td width="138" class="border_rb">76-81</td>
                            <td width="138" class="border_rb">81-87</td>
                            <td width="138" class="border_rb">87-93</td>
                            <td width="138" class="border_b">93-98</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_rb">国际</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_rb">S</td>
                            <td width="138" class="border_rb">M</td>
                            <td width="138" class="border_rb">L</td>
                            <td width="138" class="border_rb">XL</td>
                            <td width="138" class="border_b">XXL</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td width="78" height="48" class="border_r">美国(英寸)</td>
                    <td><table cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="138" height="48" class="border_r">28-30</td>
                            <td width="138" class="border_r">30-32</td>
                            <td width="138" class="border_r">32-34</td>
                            <td width="138" class="border_r">36-38</td>
                            <td width="138">38-40</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="manshoes">男鞋</a></h3>
              <span class="cloth_nine"></span>
              <table class="table_nine" border="0" cellspacing="0" cellpadding="0" class="table_four">
              <tbody>
                <tr>
                  <td width="78" height="48" class="border_rb font_18">标准</td>
                  <td width="694" class="border_b font_18">尺码明细</td>
                </tr>
                <tr>
                  <td width="78" height="48" class="border_rb">脚长(cm)</td>
                  <td><table border="0" align="center" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td width="85" height="48" class="border_rb">24.5</td>
                          <td width="85" class="border_rb">25</td>
                          <td width="87" class="border_rb">25.5</td>
                          <td width="85" class="border_rb">26</td>
                          <td width="87" class="border_rb">26.5</td>
                          <td width="85" class="border_rb">27</td>
                          <td width="86" class="border_rb">27.5</td>
                          <td width="87" class="border_b">28</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                <tr>
                  <td width="78" height="48" class="border_rb">中国</td>
                  <td><table border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td width="85" height="48" class="border_rb">39</td>
                          <td width="85" class="border_rb">40</td>
                          <td width="87" class="border_rb">41</td>
                          <td width="85" class="border_rb">42</td>
                          <td width="87" class="border_rb">43</td>
                          <td width="85" class="border_rb">44</td>
                          <td width="86" class="border_rb">45</td>
                          <td width="87" class="border_b">46</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                <tr>
                  <td width="78" height="48" class="border_rb">美国</td>
                  <td><table border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td width="85" height="48" class="border_rb">7</td>
                          <td width="85" class="border_rb">7.5</td>
                          <td width="87" class="border_rb">8</td>
                          <td width="85" class="border_rb">8.5</td>
                          <td width="87" class="border_rb">9</td>
                          <td width="85" class="border_rb">9.5</td>
                          <td width="86" class="border_rb">10</td>
                          <td width="87" class="border_b">10.5</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                <tr>
                  <td width="78" height="48" class="border_rb">英国</td>
                  <td><table border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td width="85" height="48" class="border_rb">6</td>
                          <td width="85" class="border_rb">6.5</td>
                          <td width="87" class="border_rb">7</td>
                          <td width="85" class="border_rb">7.5</td>
                          <td width="87" class="border_rb">8</td>
                          <td width="85" class="border_rb">8.5</td>
                          <td width="86" class="border_rb">9</td>
                          <td width="87" class="border_b">9.5</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                <tr>
                  <td width="78" height="48" class="border_r">欧洲</td>
                  <td><table border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td width="85" height="48" class="border_r">39</td>
                          <td width="85" class="border_r">40</td>
                          <td width="87" class="border_r">41</td>
                          <td width="85" class="border_r">42</td>
                          <td width="87" class="border_r">43</td>
                          <td width="85" class="border_r">44</td>
                          <td width="86" class="border_r">45</td>
                          <td width="87">46</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
              </table>
            </div>
            <div class="cloth_tit">
              <h3><a name="uesefulsize">常用度量衡换算</a></h3>
              <div class="length">
                <h4>长度  Length</h4>
                <table class="len_table" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td width="278" height="48" class="border_rb">Imperial 英制</td>
                      <td width="118" height="48" class="border_b">尺码明细</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 inch [in] 英寸</td>
                              <td width="138" height="48"  class="border_rb">---------- </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">2.54 cm 厘米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 foot [ft] 英尺</td>
                              <td width="138" height="48" class="border_rb">12 in 英寸</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.3048 m 米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 yard [yd] 码 </td>
                              <td width="138" height="48" class="border_rb">3 foot 英尺</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.9144 m 米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 mile 英里</td>
                              <td width="138" height="48" class="border_rb">1760 yd 码</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">1.6093 km 千米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_r">1 int nautical<br/>mile海里</td>
                              <td width="138" height="48" class="border_r">2025.4 yd 码</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48">1.853 km 千米</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="area">
                <h4>面积  Area</h4>
                <table class="area_table" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td width="278" height="48" class="border_rb">Imperial 英制</td>
                      <td width="118" height="48" class="border_b">Metric 公制</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 sq inch [in2]<br/>平方英寸</td>
                              <td width="138" height="48"  class="border_rb">---------- </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">6.4516 cm2 <br/>平方厘米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 sq foot [ft2]<br/>平方英尺</td>
                              <td width="138" height="48" class="border_rb">144 in2 平方英寸</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.0929 m2<br/>平方米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 sq yd [yd2]<br/>平方码</td>
                              <td width="138" height="48" class="border_rb">9 ft2 平方英尺</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.8361 m2 <br/>平方米</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 acre 英亩</td>
                              <td width="138" height="48" class="border_rb">4840 yd2平方码</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">4046.9 m2<br/>平方米 </td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_r">1 sq mile [mile2]<br/>平方英</td>
                              <td width="138" height="48" class="border_r">640 acres 英亩</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48">2.59 km2<br/>平方千米</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="volume">
                <h4>体 积 / 容 量 Volume/Capacity</h4>
                <table class="volume_table" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td width="278" height="48" class="border_rb">Imperial 英制</td>
                      <td width="118" height="48" class="border_b">Metric 公制</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 fluid ounce<br/>液量盎司</td>
                              <td width="138" height="48"  class="border_rb">1.0408 UK fl oz<br/>英制液量盎司</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">29.574 ml 毫升</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 pint (16 fl oz 液量 <br/>品脱 ) 品脱</td>
                              <td width="138" height="48" class="border_rb">0.8327 UK pt<br/>英制品脱</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.4731 l 升</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_r">1 gallon 加仑</td>
                              <td width="138" height="48" class="border_r">0.8327UKgal英加仑</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48">3.7854 l 升</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="weight">
                <h4>重量 Weight</h4>
                <table class="weight_table" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td width="278" height="48" class="border_rb">Imperial 英制</td>
                      <td width="118" height="48" class="border_b">Metric 公制</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 ounce [oz] 盎司</td>
                              <td width="138" height="48"  class="border_rb">437.5 grain 格令</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">28.35 g 克</td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 pound [lb] 磅</td>
                              <td width="138" height="48" class="border_rb">16 oz 盎司</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.4536 kg 千克 </td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 stone 口石</td>
                              <td width="138" height="48" class="border_rb">9 ft2 平方英尺</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">0.8361 m2<br/>
                        平方米 </td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_rb">1 hundredweight<br/>[cwt] 英担</td>
                              <td width="138" height="48" class="border_rb">112 lb. 磅 </td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48" class="border_b">50.802 kg 千克 </td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td width="138" height="48" class="border_r">1 long ton (UK) 长吨</td>
                              <td width="138" height="48" class="border_r">20 cwt 英担</td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="118" height="48">1.016 t 吨 </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!--div class="tools_cont" style="display:none;">
            <dl class="rates_conversion">
              <dt><b>汇率查询换算</b><br/>
                在线世界各国货币转换</dt>
              <dd>人民币汇率每天不同，CNstorm为你提供实时汇率换算、查询 </dd>
            </dl>
          </div-->
          <div class="tools_cont tools_cont_4">
            <dl class="buy_helper">
                <div class="b_h_banner">
					<img src="catalog/view/theme/cnstorm/images/helper/buy_helper_banner.jpg" width="938" height="366" alt=""/>
				</div>
                <!-- <div class="b_h_down"><img src='catalog/view/theme/cnstorm/images/helper/buy_helper_download.png'/></div> -->
                <div class="b_h_bk"><a class="buy_helper_bookmark" href="javascript:(function(w){if(!!w.cnstorm_id_A$loaded){if(!!w.CNstorm_Tool){w.CNstorm_Tool.toggle()}}else{w.cnstorm_id_A$loaded = true;!!w.CNstorm_Tool ?w.CNstorm_Tool.toggle():(function(d){w.cnstorm_id_A$loaded=true;var j=d.createElement('script');j.src='http://www.acgstorm.com/index.php?route=plugin/cnstormassist/quickbuy&c=
'+d.charset+'&amp;u='+encodeURIComponent(window.location.href);j.setAttribute('ime-cft','lt=2');d.getElementsByTagName('head')[0].appendChild(j);})(document)}})(window)"><span style="opacity:0">cnstorm代购助手</span></a></div>
            </dl>
              <div class="b_h_title">特色功能</div> 
              <div class="b_h_content">
                  <div class="b_h_row">
                    <div class="b_h_pro">海量产品任您挑选</div>
                    <div class="b_h_text">支持淘宝网，当当网，阿里巴巴，京东商城，亚马逊等等，国内各大主流商城，各色商品，轻松购买。</div>
                  </div>
                  <div class="b_h_row">
                      <div class="b_h_easy">海外代购更Easy</div>
                      <div class="b_h_text">不需要登录CNstorm，在产品详情页点击插件图标即可抓取商品信息，告别复制、粘贴的代购操作。</div>
                  </div>
                  <div style="clear:both"></div>
              </div>
              <div class="b_h_title">常见问题</div>
              <div class="b_h_content">
                  <div class="b_h_faq">
                      <p><b class="wenGreen">问</b><span>：使用CNstorm代购助手需要登录吗？</span></p>
                      <p><b class="daBlue">答</b><span>：不需要。您只需在提交订单的时候登录确认付款即可。</span></p>
                  </div>
                  <div class="b_h_faq">
                      <p><b class="wenGreen">问</b><span>：使用CNstorm代购助手的时候支付安全能保证吗？</span></p>
                      <p><b class="daBlue">答</b><span>：能保证。代购助手只是帮助您在挑选商品的时候更加方便轻松，支付还是会跳转到CNstrom官网进行支付，所以安全问题不用担心。</span></p>
                  </div>
                  <div class="b_h_faq">
                      <p><b class="wenGreen">问</b><span>：我的浏览器没有书签栏，怎么办？</span></p>
                      <p><b class="daBlue">答</b><span>：Chrome浏览器点击自定义按钮，在书签处选择“显示书签栏”；firefox浏览器在最顶端右键，然后点击“书签工具栏”；IE浏览器在最顶端右键，然后点击“收藏夹栏”。</span></p>
                  </div>
                  <!-- <div class="b_h_faq">
                      <p><b style="color:#18ac54">问</b><span>：我不想使用代购助手了，可以卸载吗？</span></p>
                      <p><b style="color:#1481dd">答</b><span>：CNstorm代购助手是一款完全免费的插件，进入浏览器的“扩展程序”管理页面即可卸载，同时欢迎广大用户来邮件提建议或意见。</span></p>
                  </div> -->
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"> 
clickFun();
</script> 
<?php echo $footer; ?>
</body>
</html>