/**************************************/
/*@author:  Boss<cnstorm01@cnstorm.com> */
/*@date:     2015.5.2               */
/*@purpose:  company site - CNstorm   */
/**************************************/

$(function(){
	/* header */
	$(".nav li").each(function(i){
	  $(this).click(function() {
		$(this).siblings().children().removeClass("on");
		$(this).children().toggleClass("on");
		$(".sub-nav").slideDown();
	  });
	});
	/* media */
	$(".nav-li").each(function(i){
	  $(this).click(function() {
		$(this).addClass("on").siblings().removeClass("on");
		$(this).siblings().children().removeClass("on");
		$(this).children().addClass("on");
		$(".mod-li").eq(i).show().siblings().hide();
	  });
	});
	
	/*历史及里程碑*/
	historys();
	
	/*头部商城下拉*/
	$(".showShops").click(function(){
		$(".tipsShop").toggle();
		//$(this).toggleClass("curr");
	});
});
/* header */
function navUp() {
	$('.sub-nav').slideUp();
	$(".nav li a").removeClass("on");
}

/*2015-05-25 历史及里程碑*/
function historys(){
	var liindex;
	var liWidth = $('.htcYears li').width();
	var htwMilepost=$('.htwMilepost').width();
	var m = $(".htcYears li:last").index();
	
	$('.htcYears li').click(function(){
		liindex = $('.htcYears li').index(this);
		$(this).addClass('curr').siblings().removeClass('curr');
		$('.hisTabsWrap').stop(false,true).animate({'margin-left' : -liindex * htwMilepost},300);
		$('.hisTabsContent .htcYears span').stop(false,true).animate({'left' : (liindex * liWidth+400) + 'px'},300);
	});
	
	$(".pageUp").click(function(){
		liindex=$(".htcYears li.curr").index();
		if(liindex>0){
			$(".htcYears li").eq(liindex-1).addClass('curr').siblings().removeClass('curr');
			$('.hisTabsWrap').stop(false,true).animate({'margin-left' : -(liindex-1) * htwMilepost},300);
			$('.hisTabsContent .htcYears span').stop(false,true).animate({'left' : ((liindex-1) * liWidth+400) + 'px'},300);
			liindex=liindex-1;
		}
	});
	$(".pageNext").click(function(){
		liindex= $(".htcYears li.curr").index();
		if(liindex<m) {
			$(".htcYears li").eq(liindex+1).addClass('curr').siblings().removeClass('curr');
			$('.hisTabsWrap').stop(false,true).animate({'margin-left' : -(liindex+1) * htwMilepost},300);
			$('.hisTabsContent .htcYears span').stop(false,true).animate({'left' : ((liindex+1) * liWidth+400) + 'px'},300);
			liindex=liindex+1;
		}
	});
}