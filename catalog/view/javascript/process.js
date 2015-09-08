$(function(){
	showProcess();
	showAddress();
});

/*流程演示*/
function showProcess(){
	var pdli=$(".processShows li");
	var demoWidth=$(".psdwContents").width();
	var liHeight=pdli.height();
	var m=$(".processShows li:last").index();
	var liIndex;
	/*流程演示*/
	pdli.click(function(){
		liIndex=$(this).index();
		showDemos();
	});
	pdli.eq(0).trigger("click");
	/*再看一次*/
	$(".processAgain").click(function(){
		liIndex=0;
		showDemos();
	});
	/*上翻下翻*/
	var pbtn01=$(".pbtn01");
	var pbtn02=$(".pbtn02");
	pbtn01.click(function(){
		liindex= $(".processShows li.curr").index();
		if(liindex>0){
			liIndex=liIndex-1;
			showDemos();
		}
	});
	pbtn02.click(function(){
		liindex=$(".processShows li.curr").index();
		if(liindex<m){
			liIndex=liIndex+1;
			showDemos();
		}
	});
	function showDemos(){
		pdli.eq(liIndex).addClass("curr").siblings().removeClass("curr");
		$(".processShows").css({"background-position":"0px "+(-liIndex*liHeight)+"px"});
		$(".demosWrap").stop(false,true).animate({"margin-left" : -liIndex * demoWidth},300);
		$(".psdwFlip").stop(false,true).animate({"margin-left" : liIndex * demoWidth},300);
	}
}

/*显示隐藏收货地址*/
function showAddress(){
	$(".checkAddress").click(function(){
		$(".clientAddress").slideDown(300);
	});
	$(".closeAddress").click(function(){
		$(".clientAddress").slideUp(300);
	});
}