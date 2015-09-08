var width=$(window).width();
var height=$(window).height();
var dwidth=$(document).width();
var dheight=$(document).height();
/*social-right*/
//开始点击播放图片
$('.bask_rec_images_new').on('click',function(event){
  if($(this).data('img_src')){
    var arr=$(this).data('img_src').split("|");
    $('.view-oneImage-div-box').find('img').attr({src:arr[0]});
  }else{
    var arr=$(this).attr('img_src').split("|");
    $('.view-oneImage-div-box').find('img').attr({src:arr[0]});
    if (arr.length == 1){
        $('.view-oneImage-div-box .left').fadeOut();
        $('.view-oneImage-div-box .right').fadeOut();
        $('.view-oneImage-div-bg').fadeIn().css({width:dwidth,height:dheight});
        $('.view-oneImage-div-box-bg').fadeIn().css({left:(width-1000)/2,height:height});
        $('.view-oneImage-div-box').css({left:(1000-$('.view-oneImage-div-box img').width())/2,top:(height-$('.view-oneImage-div-box img').height())/2});
        $(".view-oneImage-div-box .left").css({left:((width-800)/2),top:height/2});
        $(".view-oneImage-div-box .right").css({right:((width-800)/2),top:height/2});
    }
    if (arr.length > 1){
        $('.view-oneImage-div-box .left').fadeIn();
        $('.view-oneImage-div-box .right').fadeIn();
        $('.view-oneImage-div-box .left').attr({img_src:arr[0]});
        $('.view-oneImage-div-box .right').attr({img_src:arr[1]});
    }
  }
//上一张
  $('.view-oneImage-div-box .left').bind('click',function(event){
      $('.view-oneImage-div-box').find('img').attr({src:$(this).attr('img_src')});
      for (var i=0;i<arr.length;i++){
          if ($(this).attr('img_src') == arr[i]){
              $('.view-oneImage-div-box .left').attr({img_src:arr[i-1]});
              if (i == arr.length-1){
                  $('.view-oneImage-div-box .right').attr({img_src:arr[0]});
              }else{
                  $('.view-oneImage-div-box .right').attr({img_src:arr[i+1]});
              }
              break;
          }
      }
  return false;
  });
//鼠标悬挂上下一张图标
  $('.view-oneImage-div-box .left,.view-oneImage-div-box .right').bind('mouseover',function(event){
      $(this).animate(300).css({backgroundColor:'#519CEA'});
  })
//鼠标离开上下一张图标
  $('.view-oneImage-div-box .left,.view-oneImage-div-box .right').bind('mouseleave',function(event){
      $(this).animate(300).css({backgroundColor:''});
  })
//下一张
  $('.view-oneImage-div-box .right').bind('click',function(event){
      $('.view-oneImage-div-box').find('img').attr({src:$(this).attr('img_src')});
      for (var i=0;i<arr.length;i++){
          if ($(this).attr('img_src') == arr[i]){
              $('.view-oneImage-div-box .right').attr({img_src:arr[i+1]});
              if (i == 0){
                  $('.view-oneImage-div-box .left').attr({img_src:arr[arr.length-1]});
              }else{
                  $('.view-oneImage-div-box .left').attr({img_src:arr[i-1]});
              }
              break;
          }
      }
  return false;
  });
//播放插件样式调整
  $(".view-oneImage-div-box img").load(function(){
    if (this.complete||this.readyState=="complete") {
        $('.view-oneImage-div-bg').fadeIn().css({width:dwidth,height:dheight});
        $('.view-oneImage-div-box-bg').fadeIn().css({left:(width-1000)/2,height:height});
        $('.view-oneImage-div-box').css({left:(1000-this.width)/2,top:(height-this.height)/2});
        $(".view-oneImage-div-box .left").css({left:((width-800)/2),top:height/2});
        $(".view-oneImage-div-box .right").css({right:((width-800)/2),top:height/2});
    }
  }) 
});
//关闭播放图片
$('.view-div-close').click(function(){
     $('.view-oneImage-div-bg').fadeOut();
     $('.view-oneImage-div-box-bg').fadeOut();
     $('.view-oneImage-div-box .right').unbind('click');
     $('.view-oneImage-div-box .left').unbind('click');
});
//开始点击播放视频
$(document).on('click','.video_play_right',function(){
  $('.view-video-div-bg').fadeIn().css({width:width,height:height});
  $('.view-video-div-box').fadeIn();
  $('.view-video-div-box').css({left:(width-516)/2+'px'});
  if($(this).data('img_src')){
    $('.view-video-div-box').find('embed').attr({src:$(this).attr('img_src')});
  }else{
    $('.view-video-div-box').find('embed').attr({src:$(this).attr('img_src')});
  }
});
//关闭视频
$('.view-video-div-close').click(function(){
     $('.view-video-div-bg').fadeOut();
     $('.view-video-div-box').fadeOut();
});
/*social-list*/
//开始点击播放图片
$(document).on('click','.viewres',function(event){
  if($(this).data('img_src')){
    var arr=$(this).data('img_src').split("|");
    $('.view-image-div-box').find('img').attr({src:arr[0]});
  }else{
    var arr=$(this).attr('img_src').split("|");
    $('.view-image-div-box').fadeIn().find('img').attr({src:arr[0]});
    if (arr.length == 1){
        $('.view-image-div-box .left').fadeOut();
        $('.view-image-div-box .right').fadeOut();
        $('.view-div-bg').fadeIn().css({width:dwidth,height:dheight});
        $('.view-image-div-box-bg').fadeIn().css({left:(width-1000)/2,height:height});
        $('.view-image-div-box').css({left:(1000-$('.view-image-div-box img').width())/2,top:(height-$('.view-image-div-box img').height())/2});
        $(".view-image-div-box .left").css({left:((width-800)/2),top:height/2});
        $(".view-image-div-box .right").css({right:((width-800)/2),top:height/2});
    }
    if (arr.length > 1){
        $('.view-image-div-box .left').fadeIn();
        $('.view-image-div-box .right').fadeIn();
        $('.view-image-div-box .left').attr({img_src:arr[0]});
        $('.view-image-div-box .right').attr({img_src:arr[1]});
    }
  }
//上一张
  $('.view-image-div-box .left').bind('click',function(event){
      $('.view-image-div-box').find('img').attr({src:$(this).attr('img_src')});
      for (var i=0;i<arr.length;i++){
          if ($(this).attr('img_src') == arr[i]){
              $('.view-image-div-box .left').attr({img_src:arr[i-1]});
              if (i == arr.length-1){
                  $('.view-image-div-box .right').attr({img_src:arr[0]});
              }else{
                  $('.view-image-div-box .right').attr({img_src:arr[i+1]});
              }
              break;
          }
      }
  return false;
  });
//鼠标悬挂上下一张图标
  $('.view-image-div-box .left,.view-image-div-box .right').bind('mouseover',function(event){
      $(this).animate(300).css({backgroundColor:'#519CEA'});
  })
//鼠标离开上下一张图标
  $('.view-image-div-box .left,.view-image-div-box .right').bind('mouseleave',function(event){
      $(this).animate(300).css({backgroundColor:''});
  })
//下一张
  $('.view-image-div-box .right').bind('click',function(event){
      $('.view-image-div-box').find('img').attr({src:$(this).attr('img_src')});
      for (var i=0;i<arr.length;i++){
          if ($(this).attr('img_src') == arr[i]){
              $('.view-image-div-box .right').attr({img_src:arr[i+1]});
              if (i == 0){
                  $('.view-image-div-box .left').attr({img_src:arr[arr.length-1]});
              }else{
                  $('.view-image-div-box .left').attr({img_src:arr[i-1]});
              }
              break;
          }
      }
  return false;
  });
//播放插件样式调整
  $(".view-image-div-box img").load(function(){
    if (this.complete||this.readyState=="complete") {
        $('.view-div-bg').fadeIn().css({width:dwidth,height:dheight});
        $('.view-image-div-box-bg').fadeIn().css({left:(width-1000)/2,height:height});
        $('.view-image-div-box').css({left:(1000-this.width)/2,top:(height-this.height)/2});
        $(".view-image-div-box .left").css({left:((width-800)/2),top:height/2});
        $(".view-image-div-box .right").css({right:((width-800)/2),top:height/2});
    }
  }) 
});
//关闭播放图片
$('.view-image-div-close').click(function(){
     $('.view-div-bg').fadeOut();
     $('.view-image-div-box-bg').fadeOut();
     $('.view-image-div-box .right').unbind('click');
     $('.view-image-div-box .left').unbind('click');
});
//缩略图效果
var iNow = 0;
$(document).on('click','.bask_iamge_sm_ul li img',function(){
    var self = $(this);
	iNow = $(this).parent().attr("index");
	$(this).parent().parent().attr("iNow",iNow);
	$('.bask_iamge_sm_ul').find('img').removeData('cur').next().fadeIn();
	$(this).data('cur','yes');
	if($(this).data('cur')==='yes'){
		$(this).next().fadeOut();
	}
    $(this).parents('.bask_iamge_sm').prev().find('img').hide();
    var img_src = $(this).attr('iname');
    var width = $(this).parents('.bask_iamge_sm').prev().find('img')[0].width/2;
    var height = $(this).parents('.bask_iamge_sm').prev().find('img')[0].height/2;
    $(this).parents('.bask_iamge_sm').prev().find('img').after('<img class="load_big_img" src="catalog/view/theme/cnstorm/images/load_big_img.gif" style="position: relative;right: '+width+'px;top: -'+height+'px;z-index: 9999;">');
   
    $(document).load('http://'+window.location.host+'/'+img_src,"",function(){
       $(this).parents('.bask_iamge_sm').prev().find('img').hide();
       $('.load_big_img').remove();
       self.parents('.bask_iamge_sm').prev().find('img').hide();
       self.parents('.bask_iamge_sm').prev().find('img').attr('src',img_src).fadeIn();
    });
    $(this).parents('.bask_iamge_sm').prev().find('img').show();
});
//图片展开v_image-list
$('.view-image-list').find('img').eq(5).css({marginRight:'0px'});
$(document).on('click','.view-image-list img',function(){
	$(this).parent(".view-image-list").next().find('.bask_iamge_sm_ul span').eq(0).hide();
    $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/bask_up.jpg') no-repeat"});
    $(this).parent('.view-image-list').slideUp();
    $(this).parent('.view-image-list').next().slideDown();
});
$(document).on('hover','.updown',function(){
    $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/bask_down.jpg') no-repeat"});
},function(){
    $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/bask_up.jpg') no-repeat"});
});
$(document).on('click','.updown',function(){
   $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/bask_down.jpg') no-repeat"});
   $(this).parents('.bask_image_box').slideUp();
   $(this).parents('.bask_image_box').prev().slideDown();
});
//小图标遮罩效果
$(document).on('mouseover','.bask_iamge_sm_ul span',function(){
    $(this).hide();
});
$(document).on('mouseleave','.bask_iamge_sm_ul img',function(){
    if($(this).data('cur')==='yes'){
	   $(this).next().fadeOut();
	}else{
       $(this).next().fadeIn();
	}
});

//social_list鼠标样式变换
$(document).on("mouseover",".bask_image_big",function(event){
	var event=window.event||event;
	iNow = $(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul").attr("iNow") || 0;
	if (event.clientX >= ($(this).offset().left + 258)){
		$(this).siblings(".right").css("cursor","url(catalog/view/theme/cnstorm/stylesheet/banner/img/unit/arrow-right-light.png),auto");
		$(this).siblings(".right").css("height",$(this).find("img").height());
	}else{
		$(this).siblings(".left").css("cursor","url(catalog/view/theme/cnstorm/stylesheet/banner/img/unit/arrow-left-light.png),auto");
		$(this).siblings(".left").css("height",$(this).find("img").height());
	}
});
//向右切换
$(document).on('click','.bask_image_box .right',function(){
	iNow = $(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul").attr("iNow") || 0;
	if (iNow == $(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul li").length-1){
		iNow = 0;
	}else iNow++;
	$(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul li").each(function(){
		if (iNow == $(this).attr("index")){
			$(this).parent(".bask_iamge_sm_ul").parent(".bask_iamge_sm").siblings(".bask_image_big").find("img").attr("src",$(this).find("img").attr("iname"));
		}
	});
	$(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul").attr("iNow",iNow);
});
//向左切换
$(document).on('click','.bask_image_box .left',function(){
	iNow = $(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul").attr("iNow") || 0;
	if (iNow == 0) {
		iNow = $(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul li").length-1;
	}else iNow--;
	$(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul li").each(function(){
		if (iNow == $(this).attr("index")){
			$(this).parent(".bask_iamge_sm_ul").parent(".bask_iamge_sm").siblings(".bask_image_big").find("img").attr("src",$(this).find("img").attr("iname"));
		}
	});
	$(this).siblings(".bask_iamge_sm").find(".bask_iamge_sm_ul").attr("iNow",iNow);
});