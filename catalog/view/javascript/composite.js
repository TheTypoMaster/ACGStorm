$(function(){	
	changeColor();
	getMallFloors();/*CNstorm商城首页楼层*/
	changeBanner.alterBanner();/*CNstorm商城首页banner切换*/
});

/*
 * 改变类名为mrTops的div的下边框颜色
 * 改变类名为mrTops的div下的h3的字体颜色
 * 把类名为mrLists的ul的第6个li的宽度设为238
*/
function changeColor(){
	var mrListsli=$(".mrLists");
	var borColor=["#ffc994","#ffef94","#ff6969","#d094ff","#ceff94"];
	var fontColor=["#bc480f","#bc8d0d","#ff6969","#630fb1","#4eb708"];
	for(var i=0;i<mrListsli.size();i++){
		$(".mrTops").eq(i).css({"border-color":borColor[i]});
		$(".mrTops").find("h3").eq(i).css({"color":fontColor[i]});
		mrListsli.find("li").eq(""+i+""+5).css({"width":"238px"});
	}	
}

/*淡入淡出Banner切换*/
var changeBanner = {
	alterBanner : function(){
		//参数所有初始化（封装后将删除）
		var values = {
			topBanner:$(".topBanner"),
			container:$('.bannerBox'),
			cols:$('.bannerBox li'),
			bannerDots:$(".bannerDots"),
			btns:$('.bannerDots a'),
			act:'curr',
			now:0
		};
		var color=["#ff6b4f","#fed555","#f6dbb0","#fff","#fff","#fff","#fff"];

		/*
		 * 淡化效果，设置所有单个对象的 zindex，以及显示和隐藏
		 * col：所有内容对象
		 * pre：上一个对象
		 * now：当前显示的对象
		 */
		var weaken = function( pre,now ){
			var col = values.cols;
			//$(".topBanner").css({backgroundColor:color[now]});
			col.css({ zIndex:1 }).eq( pre ).css({ zIndex:2 });
			col.eq( now ).css({ zIndex:3,opacity:0,backgroundColor:color[now]}).stop(true).animate({ opacity:1 },700);
		}

		/*
		 * 递增计算，返回 前一个显示内容 和 当前 要显示的内容
		 * now：当前已经选择的索引
		 */
		var increase = function( now ){
			var pre = now ,now = pre + 1;
			if( now >= values.cols.length ) now = 0;
			return { pre:pre ,now:now };
		}

		/*递减计算*/
		var degression = function( now ){
			var pre = now ,now = pre - 1;
			if( now < 0 ) now = values.cols.length-1;
			return { pre:pre ,now:now };
		}

		/*修改小按钮样式*/
		var btnStyle = function( now ){
			if( values.btns && values.act )
				values.btns.removeClass( values.act ).eq( now ).addClass( values.act );
		}

		/*小按钮事件挂接，初始化里如果有 小按钮 则执行，否则不执行*/
		var button = function(){
			values.btns.hover(function(){
				var now = $(this).index();
				if( values.now != now ){
					weaken( values.now ,now );
					btnStyle( now );
					values.now = now;
				}
			});
		}

		/*
		 *内容切换
		 *aspect：方向，0 或 无值 是后翻，1 是前翻
		 */
		var change = function( aspect ){
			var val =  aspect ? degression( values.now ) : increase( values.now );
			weaken( val.pre ,val.now );
			btnStyle( val.now );
			values.now = val.now;
		}

		/*框架尺寸*/
		$(window).resize(function(){
			values.container.height( values.cols.find('img').height() );
		}).resize();

		/*
		 * 自动播放，degrees 方法获取对应参数，并且修改小按钮样式（如果有小按钮的话），然后刷新全局变量 values.now
		 * time: 延时时间
		 */
		var loop,play = function( time ){
			clearTimeout( loop );
			loop = setTimeout(function(){ 
				change();
				play( 3000 );
			}, time );
		}
		
		/*暂停 和 触发自动播放*/
		var control = function(){
			values.container.hover(function(){
				clearTimeout( loop );
			},function(){
				play( 2000 );
			});
			values.bannerDots.hover(function(){
				clearTimeout( loop );
			},function(){
				play( 2000 );
			});
		}
		
		/*初始化效果，调用各个函数*/
		var initialize = function(){
			var now = values.now;
			weaken( values.cols.length-1 ,now );
			if(values.btns ){button();}
			//if( values.pre && values.next ) shortcut();
			btnStyle( now );
			play( 4000 );
			control();
		}
		
		initialize();/*初始化调用*/
	}
}

/*楼层实现方法*/
function getMallFloors(min_height){ 
	var f1 = $('.mallRecommendation[data-slide="1"]').offset().top;
	var f5 = $('.mallRecommendation[data-slide="5"]').offset().top;
	var fs = $('.mallFloors').children().size();
	var fss = new Array();
	for (i = 0; i < fs; i++) {
		j = i + 1;
		fss[i] = $(".mallRecommendation[data-slide='"+j+"']").offset().top-200;
	}
	//获取页面的最小高度，无传入值则默认为600像素 
	min_height ? min_height = min_height : min_height = 600; 
	//为窗口的scroll事件绑定处理函数 
	$(window).scroll(function(){
		var currentTOP = $(window).scrollTop();//获取窗口的滚动条的垂直位置 
		//当窗口的滚动条的垂直位置大于页面的最小高度时，让返回顶部元素渐现，否则渐隐 
		if(currentTOP>min_height){
			if(currentTOP>f5+200){
				$("#mfLists").fadeOut(200);
			}else{
				$("#mfLists").fadeIn(100);
			}
		}
		else{
			$("#mfLists").fadeOut(200);
		}
		if (currentTOP<=f1) {
			$(".mallFloors a").removeClass("on");
			$(".mallFloors a[data-slide='1']").addClass("on");
			return;
		}else{
			changefl(getFloor(currentTOP));
		}
		
	});
	//获取楼层层数
	function getFloor(fh){
		if(fs==0||fh<=f1){
			return 1;
		}
		if(fh>=fss[fs-1]){
			return fs;
		}
		for(var k=0;k<fs;k++){
			if(fh>fss[k]&&fh<fss[k+1]){
				return k+1;
			}
		}
	}
	//改变楼层
	function changefl(fno){
		$('.mallFloors a').removeClass('on');
		$('.mallFloors a[data-slide="'+fno+'"]').addClass('on');
	}
	//点击定位楼层
	$("#mfLists a").on("click",function(){
		$(this).addClass("on").siblings().removeClass("on");
		var dataslide = $(this).attr("data-slide");
		var pos = $(".mallRecommendation[data-slide='"+dataslide+"']").offset().top;//获取该点到头部的距离
		$("html,body").animate({scrollTop:pos},500);
	});
};