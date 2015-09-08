<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8"/>
<title><?php echo $text_title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>"/>
<meta name="description" content="<?php echo $description; ?>"/>
<meta name="robots" content="nofollow"/>
<link href="favicon.ico" type="image/x-icon" rel="shortcut icon"/>
<link href="catalog/view/theme/cnstorm/css/base.css" type="text/css" rel="stylesheet"/>
<link href="catalog/view/theme/cnstorm/stylesheet/business.css" rel="stylesheet" type="text/css"/>
<script src="orange/view/javascript/jquery/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery2/main.js" type="text/javascript"></script>
<script src="orange/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<link href="orange/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $header_transport;?>

<div class="f-banner">
  <div class="wrap">
    <div class="text">
      <h1><?php echo $text_internationalFreight; ?></h1>
      <h3><?php echo $text_internationalFreight; ?><i><?php echo $text_lowestPrice; ?></i></h3>
      <h2><?php echo $text_oversea; ?></h2>
    </div>
  </div>
</div>
<div class="postage">
  <div class="wrap p-center">
    <div class="ex-left">
      <div class="fnav"> <?php echo $text_fast; ?> </div>
      <ul class="select">
        <li><span>·</span><a class="on" href="index.php?route=international/freight/freight2"><?php echo $text_freightPrice; ?></a></li>
        <li><span>·</span><a href="help-populartools.html&id=10"><?php echo $text_freightEstimate; ?></a></li>
      </ul>
    </div>
    <div class="ex-mid">
      <div class="area-pab">
        <input type="text" class="destination" placeholder="<?php echo $text_chooseCountry; ?>" name="keyword" list="searchAreas"/>
		   <input type="hidden" name="area_id" id="area_id" value="" />
        <input type="button" class="input-submit"/>
		<ul class="countrylist" id="searchAreas">
			<li>
				<a href="javascript:void(0);" value="8">澳大利亚</a>
				<a href="javascript:void(0);" value="8">Australia</a>
			</li>
			<li>
				<a href="javascript:void(0);" value="11">奥地利</a>
				<a href="javascript:void(0);" value="11">Austria</a>
			</li>
			<li>
				<a href="javascript:void(0);" value="14">阿根廷</a>
				<a href="javascript:void(0);" value="14">Argentina</a>
			</li>
		</ul>
		<ul class="countrylist" id="hotAreas">
			<li>热门地区：</li>
			<li><a href="javascript:void(0);" id="c_us" value="1">美国</a></li>
			<li><a href="javascript:void(0)" value="2">加拿大</a></li>
			<li><a href="javascript:void(0)" value="8">澳大利亚</a></li>
			<li><a href="javascript:void(0)" value="16">日本</a></li>
			<li><a href="javascript:void(0)" value="13">台湾</a></li>
			<li><a href="javascript:void(0)" value="9">新西兰</a></li>
			<li><a href="javascript:void(0)" value="4">英国</a></li>
			<li><a href="javascript:void(0)" value="15">马来西亚</a></li>
		</ul>
			
        <div class="country_list">
			<b class="clForkclose"></b>
          <!--<div class="remen">
            <h2><?php echo $text_hotCountry; ?></h2>
            <ul class="countrylist">
              <li><a href="javascript:void(0)" id="c_us" value="1"><?php echo $text_USA; ?></a></li>
              <li><a href="javascript:void(0)" value="2"><?php echo $text_Canada; ?></a></li>
              <li><a href="javascript:void(0)" value="8"><?php echo $text_Australia; ?></a></li>
              <li><a href="javascript:void(0)" value="16"><?php echo $text_Japan; ?></a></li>
              <li><a href="javascript:void(0)" value="13"><?php echo $text_Taiwan; ?></a></li>
              <li><a href="javascript:void(0)" value="9"><?php echo $text_NewZealand; ?></a></li>
              <li><a href="javascript:void(0)" value="4"><?php echo $text_UnitedKingdom; ?></a></li>
              <li><a href="javascript:void(0)" value="15"><?php echo $text_Malaysia; ?></a></li>
            </ul>
          </div>-->
          <div class="allcountry">
            <!--<h2><?php echo $text_allCountry; ?></h2>-->
			<p class="supportLanguage">支持中/英文输入</p>
            <ul class="countryzm">
              <li class="zmon"><a href="javascript:void(0)"><?php echo $text_a_f; ?></a></li>
              <li class=""><a href="javascript:void(0)"><?php echo $text_g_j; ?></a></li>
              <li class=""><a href="javascript:void(0)"><?php echo $text_k_n; ?></a></li>
              <li class=""><a href="javascript:void(0)"><?php echo $text_p_s; ?></a></li>
              <li class=""><a href="javascript:void(0)"><?php echo $text_t_z; ?></a></li>
            </ul>
            <div id="countryTab">
              <ul class="countrylist">
                <div class="cities">
					<a href="#nogo" value="8"><?php echo $text_Australia; ?></a>
					<a href="#nogo" value="11"><?php echo $text_Austria; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Argentina; ?></a>
					<a href="#nogo" value="6"><?php echo $text_Anhui; ?></a>
					<a href="#nogo" value="11"><?php echo $text_Belgium; ?></a>
					<a href="#nogo" value="76"><?php echo $text_Belarus; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Brazil; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Bahrain; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Bulgaria; ?></a>
					<a href="#nogo" value="13"><?php echo $text_Cambodia; ?></a>
					<a href="#nogo" value="2"><?php echo $text_Canada; ?></a>
					<a href="#nogo" value="14"><?php echo $text_CostaRica; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Czechia; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Croatia; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Colombia; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Cuba; ?></a>
					<a href="#nogo" value="6"><?php echo $text_Chongqing; ?></a>
					<a href="#nogo" value="11"><?php echo $text_Denmark; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Estonia; ?></a>
					<a href="#nogo" value="25"><?php echo $text_France; ?></a>
					<a href="#nogo" value="11"><?php echo $text_Finland; ?></a>
					<a href="#nogo" value="14"><?php echo $text_Fiji; ?></a>
					<a href="#nogo" value="6"><?php echo $text_Fujian; ?></a>
				</div>
              </ul>
              <ul class="countrylist" style="display:none">
                <div class="cities"> <a href="#nogo" value="27"><?php echo $text_Germany; ?></a> <a href="#nogo" value="11"><?php echo $text_Greece; ?></a> <a href="#nogo" value="6"><?php echo $text_Guangdong; ?></a> <a href="#nogo" value="6"><?php echo $text_Neimenggu; ?></a> <a href="#nogo" value="6"><?php echo $text_Guangxi; ?></a> <a href="#nogo" value="6"><?php echo $text_Guizhou; ?></a> <a href="#nogo" value="13"><?php echo $text_HongKong; ?></a> <a href="#nogo" value="11"><?php echo $text_Hungary; ?></a> <a href="#nogo" value="85"><?php echo $text_Heilongjiang; ?></a> <a href="#nogo" value="6"><?php echo $text_Hunan; ?></a> <a href="#nogo" value="6"><?php echo $text_Hubei; ?></a> <a href="#nogo" value="6"><?php echo $text_Henan; ?></a> <a href="#nogo" value="20"><?php echo $text_Italy; ?></a> <a href="#nogo" value="11"><?php echo $text_Ireland; ?></a> <a href="#nogo" value="12"><?php echo $text_Indonesia; ?></a> <a href="#nogo" value="14"><?php echo $text_India; ?></a> <a href="#nogo" value="16"><?php echo $text_Japan; ?></a> <a href="#nogo" value="14"><?php echo $text_Jordan; ?></a> <a href="#nogo" value="6"><?php echo $text_JZH; ?></a> <a href="#nogo" value="6"><?php echo $text_Jingjinji; ?></a> <a href="#nogo" value="6"><?php echo $text_Jiangxi; ?></a> </div>
              </ul>
              <ul class="countrylist" style="display:none">
                <div class="cities"> <a href="#nogo" value="14"><?php echo $text_Kazakhstan; ?></a> <a href="#nogo" value="11"><?php echo $text_Luxembourg; ?></a> <a href="#nogo" value="14"><?php echo $text_Latvia; ?></a> <a href="#nogo" value="14"><?php echo $text_Lithuania; ?></a> <a href="#nogo" value="15"><?php echo $text_MalaysiaE; ?></a> <a href="#nogo" value="15"><?php echo $text_MalaysiaW; ?></a> <a href="#nogo" value="13"><?php echo $text_Macau; ?></a> <a href="#nogo" value="14"><?php echo $text_Maldives; ?></a> <a href="#nogo" value="14"><?php echo $text_Mexico; ?></a> <a href="#nogo" value="14"><?php echo $text_Malta; ?></a> <a href="#nogo" value="9"><?php echo $text_NewZealand; ?></a> <a href="#nogo" value="26"><?php echo $text_Netherlands; ?></a> <a href="#nogo" value="11"><?php echo $text_Norway; ?></a> </div>
              </ul>
              <ul class="countrylist" style="display:none">
                <div class="cities"> <a href="#nogo" value="6"><?php echo $text_Other; ?></a> <a href="#nogo" value="12"><?php echo $text_Philippines; ?></a> <a href="#nogo" value="11"><?php echo $text_Portugal; ?></a> <a href="#nogo" value="14"><?php echo $text_Peru; ?></a> <a href="#nogo" value="14"><?php echo $text_PuertoRico; ?></a> <a href="#nogo" value="14"><?php echo $text_Poland; ?></a> <a href="#nogo" value="14"><?php echo $text_Panama; ?></a> <a href="#nogo" value="14"><?php echo $text_Russia; ?></a> <a href="#nogo" value="14"><?php echo $text_Romania; ?></a> <a href="#nogo" value="15"><?php echo $text_SouthKorea; ?></a> <a href="#nogo" value="25"><?php echo $text_Spain; ?></a> <a href="#nogo" value="11"><?php echo $text_Sweden; ?></a> <a href="#nogo" value="11"><?php echo $text_Switzerland; ?></a> <a href="#nogo" value="17"><?php echo $text_Singapore; ?></a> <a href="#nogo" value="14"><?php echo $text_Slovakia; ?></a> <a href="#nogo" value="14"><?php echo $text_SaudiArabia; ?></a> <a href="#nogo" value="14"><?php echo $text_SouthAfrica; ?></a> <a href="#nogo" value="6"><?php echo $text_SH; ?></a> <a href="#nogo" value="6"><?php echo $text_Sichuan; ?></a> <a href="#nogo" value="6"><?php echo $text_SX; ?></a> <a href="#nogo" value="6"><?php echo $text_Shenzhen; ?></a> </div>
              </ul>
              <ul class="countrylist" style="display:none">
                <div class="cities"> <a href="#nogo" value="12"><?php echo $text_Thailand; ?></a> <a href="#nogo" value="13"><?php echo $text_Taiwan; ?></a> <a href="#nogo" value="14"><?php echo $text_Emirates; ?></a> <a href="#nogo" value="14"><?php echo $text_Turkey; ?></a> <a href="#nogo" value="1"><?php echo $text_USA; ?></a> <a href="#nogo" value="4"><?php echo $text_UnitedKingdom; ?></a> <a href="#nogo" value="14"><?php echo $text_Ukraine; ?></a> <a href="#nogo" value="12"><?php echo $text_Vietnam; ?></a> <a href="#nogo" value="6"><?php echo $text_Xinjiang; ?></a> <a href="#nogo" value="6"><?php echo $text_Xizang; ?></a> <a href="#nogo" value="6"><?php echo $text_Yunnan; ?></a> </div>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="ex-center-body">
        <div class="ex_content">
          <div class="ex-title">
            <div class="ah"><?php echo $text_transportWay; ?></div>
            <div class="s-line" style="width:1px">|</div>
            <div class="ah"><?php echo $text_firsrPrice; ?><?php echo $text_dollar; ?></div>
            <div class="s-line" style="width:1px">|</div>
            <div class="ah"><?php echo $text_secondPrice; ?><?php echo $text_dollar; ?></div>
            <div class="s-line" style="width:1px">|</div>
            <div class="ah"><?php echo $text_limitWeight; ?>(g)</div>
            <div class="s-line" style="width:1px">|</div>
            <div class="ah2"><?php echo $text_expectedAging; ?></div>
          </div>
          <div class="ex-list" id="ex_list">
	  	<div class="loading">
	  		<p class="area-notice"><i class="lanIcon"></i><?php echo $text_noChoose; ?></p>
	  	</div>
          </div>
        </div>
      </div>
    </div>
    <div class="ex-right">
      <h2 class="title"><span class="more"><a href="help.html" target="_blank"><?php echo $text_more; ?></a></span><?php echo $text_FAQ; ?></h2>
      <div class="list">
        <h4><?php echo $text_Q1; ?></h4>
        <p><span class="f14"><b><?php echo $text_A; ?></b></span><?php echo $text_A1; ?></p>
      </div>
      <div class="list">
        <h4><?php echo $text_Q2; ?></h4>
        <p><span class="f14"><b><?php echo $text_A; ?></b></span><?php echo $text_A2; ?></p>
      </div>
      <div class="list">
        <h4><?php echo $text_Q3; ?></h4>
        <p><span class="f14"><b><?php echo $text_A; ?></b></span><?php echo $text_A3; ?></p>
      </div>
	  <div class="postCustomer">
		<p class="pcKefu">
			<a href="help.html" target="_blank" title="在线客服" class="pcZhidao"><b>在线客服</b>贴心的指导，解决您的疑惑！</a>
		</p>
	  </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
/*输入框输入文字，提示出现*/

$("#searchAreas").click(function(){
	$(this).hide();
});
/*点击叉关闭*/
$(".clForkclose").click(function(){
	$('.country_list').hide();
});

//显示城市列表
$('.area-pab').hover(function() {
    $('.country_list').hide();
	$("#searchAreas").hide();
});
$('.destination').click(function() {
    $('.country_list').show();
});
$('.input-submit').click(function() {
    $('.country_list').show();
});
// 显示隐藏评论
$(document).on('click', '.ui-body', function() {
    var obj = $(this);
    obj.toggleClass('on');
    obj.find('.s-body').slideToggle();
});

// 赋值、隐藏列表
$('.countrylist a').bind('click', function() {
    var city = $(this).text();
    $('.destination').val(city);
    $('.destination').attr('realvalue', $(this).attr('value'));
    $('.country_list').hide();
    //$('.area-notice').hide();
    $('#ex_list').html("<div class='loading'><img src='catalog/view/theme/cnstorm/images/loading_data.gif' alt='<?php echo $text_loading; ?>'/></div>");

    //添加ajax事件
    var realvalue = $(".destination").attr("realvalue");
    var url = 'index.php?route=international/freight/freight2&realvalue=' + realvalue;
    $('#ex_list').load(url);
});

    $('.countryzm a').each(function(index, item) {
        $(item).click(function() {
            $('.countryzm li.zmon').removeClass('zmon');
            $(this).parent().addClass('zmon');
            $('#countryTab ul').hide();
            $('#countryTab ul').eq(index).show();
            return false;
        });
        });
	$('.input-submit').click(function(){
		var keyword=$('input[name=keyword]').val();
		if(keyword != '请选择您的收货地区或国家，CNstorm智能为您推荐合适的运输方式。'){
			var area_id=$('#area_id').val();
			if(area_id){
				 var url = 'index.php?route=international/freight/freight2&realvalue=' + area_id;
				$('#ex_list').load(url);
			}
		}
	})
});
</script>

<script type="text/javascript">
$('input[name=keyword]').autocomplete({
  delay: 500,
  source: function(request, response) {   
    $.ajax({
      url: 'index.php?route=international/freight/getCity&keyword=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        json.unshift({
          'area_id':  0,
          'keyword':  ' --- 无 --- '
        });
        response($.map(json, function(item){
          return {
           label: item.keyword+'('+item.name_cn+')',
           value: item.area_id
          }
        }));
      }
    });
  },
    select: function(event, ui) {
    $('input[name=keyword]').val(ui.item.label);
    $('input[name=area_id]').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
</script>

<?php echo $footer; ?>
</body>
</html>