$(function(){
$.extend({getncl:function(){
        $.get('index.php?route=social/social/getTotalUpdate',{},function(data){
            if(data!==0 && data!==''){
                $('.new_c_lgt').html(data);$('.new_c_tip').fadeIn();
            }
        });
}});
var new_c_tip;
if($('.new_c_tip').attr('login')==='1'){
    new_c_tip = setInterval("$.getncl()",3000);
}else{
    clearInterval(new_c_tip);
}
    //搜索框
$('.sch').find('input').val('输入您想搜索的内容。');
$('.sch').find('input').click(function(){
  if($(this).data('text_ck')!==1){
  $(this).html('');
  $(this).val('');
  $(this).data('text_ck',1);
}
});
//搜索框结束
   var self_tab;
   //tab切换
$('.m-sns-write-mood-tab-panel').find('#mood').hide();
   $('.active').find('.m-sns-write-mood-pointer-box').show();
   $('#'+$('.active').attr('toggle')).show();
//bask mood切换  
//默认情况下，晒单可操作
   $('.tab-top').click(function(){
       //当写心情时主题功能才有效
       if($(this).attr('toggle')==='mood'){
           $('.theme_option').fadeIn();
       }else{
           $('.theme_option').fadeOut();
       }
       $('.checked-image').data('ck',$(this).attr('toggle'));
       $('.m-sns-write-mood-pointer-box').hide();
       $('.tab-top').css({color:'#333333',fontWeight:''});
       $(this).css({color:'#fb6e52',fontWeight:'bold'});
       $(this).find('.m-sns-write-mood-pointer-box').show();
       $('.m-sns-write-mood-tab-panel').find('#bask,#mood').hide();
       $('#'+$(this).attr('toggle')).show().find('textarea').focus();
       $('#bask-textarea,#mood-textarea').removeData();
       $('#'+$(this).attr('toggle')).find('textarea').data('ck','on');
       self_tab = $(this);
   });
   //emoji
var emoji = {1:{i:"catalog/view/theme/cnstorm/images/social/emoji/01.jpg",a:'哈哈'},2:{i:"catalog/view/theme/cnstorm/images/social/emoji/02.jpg",a:'高兴'},3:{i:"catalog/view/theme/cnstorm/images/social/emoji/03.jpg",a:'微笑'},4:{i:"catalog/view/theme/cnstorm/images/social/emoji/04.jpg",a:'窃喜'},5:{i:"catalog/view/theme/cnstorm/images/social/emoji/05.jpg",a:'眨眼'},6:{i:"catalog/view/theme/cnstorm/images/social/emoji/06.jpg",a:'爱你'},7:{i:"catalog/view/theme/cnstorm/images/social/emoji/07.jpg",a:'飞吻'},
    8:{i:"catalog/view/theme/cnstorm/images/social/emoji/08.jpg",a:'亲一口'},9:{i:"catalog/view/theme/cnstorm/images/social/emoji/09.jpg",a:'脸红'},10:{i:"catalog/view/theme/cnstorm/images/social/emoji/10.jpg",a:'冥想'},11:{i:"catalog/view/theme/cnstorm/images/social/emoji/11.jpg",a:'微笑'},12:{i:"catalog/view/theme/cnstorm/images/social/emoji/12.jpg",a:'鬼脸'},13:{i:"catalog/view/theme/cnstorm/images/social/emoji/13.jpg",a:'闭眼'},14:{i:"catalog/view/theme/cnstorm/images/social/emoji/14.jpg",a:'不高兴'},
    15:{i:"catalog/view/theme/cnstorm/images/social/emoji/15.jpg",a:'假笑'},16:{i:"catalog/view/theme/cnstorm/images/social/emoji/16.jpg",a:'冷汗'},17:{i:"catalog/view/theme/cnstorm/images/social/emoji/17.jpg",a:'深思'},18:{i:"catalog/view/theme/cnstorm/images/social/emoji/18.jpg",a:'失望'},19:{i:"catalog/view/theme/cnstorm/images/social/emoji/19.jpg",a:'困惑'},20:{i:"catalog/view/theme/cnstorm/images/social/emoji/20.jpg",a:'失望'},
    21:{i:"catalog/view/theme/cnstorm/images/social/emoji/21.jpg",a:'糟糕'},22:{i:"catalog/view/theme/cnstorm/images/social/emoji/22.jpg",a:'害怕'},23:{i:"catalog/view/theme/cnstorm/images/social/emoji/23.jpg",a:'紧张'},24:{i:"catalog/view/theme/cnstorm/images/social/emoji/24.jpg",a:'哭泣'},25:{i:"catalog/view/theme/cnstorm/images/social/emoji/25.jpg",a:'大哭'},26:{i:"catalog/view/theme/cnstorm/images/social/emoji/26.jpg",a:'大笑'},
    27:{i:"catalog/view/theme/cnstorm/images/social/emoji/27.jpg",a:'吃惊'},28:{i:"catalog/view/theme/cnstorm/images/social/emoji/28.jpg",a:'恐怖'},29:{i:"catalog/view/theme/cnstorm/images/social/emoji/29.jpg",a:'闭嘴'},30:{i:"catalog/view/theme/cnstorm/images/social/emoji/30.jpg",a:'撅嘴'},31:{i:"catalog/view/theme/cnstorm/images/social/emoji/31.jpg",a:'困倦'},32:{i:"catalog/view/theme/cnstorm/images/social/emoji/32.jpg",a:'生病'},
    33:{i:"catalog/view/theme/cnstorm/images/social/emoji/33.jpg",a:'恶魔'},34:{i:"catalog/view/theme/cnstorm/images/social/emoji/34.jpg",a:'外星人'},35:{i:"catalog/view/theme/cnstorm/images/social/emoji/35.jpg",a:'黄心'},36:{i:"catalog/view/theme/cnstorm/images/social/emoji/36.jpg",a:'蓝心'},37:{i:"catalog/view/theme/cnstorm/images/social/emoji/37.jpg",a:'紫心'},38:{i:"catalog/view/theme/cnstorm/images/social/emoji/38.jpg",a:'粉心'},
    39:{i:"catalog/view/theme/cnstorm/images/social/emoji/39.jpg",a:'绿心'},40:{i:"catalog/view/theme/cnstorm/images/social/emoji/40.jpg",a:'红心'},41:{i:"catalog/view/theme/cnstorm/images/social/emoji/41.jpg",a:'心碎'},42:{i:"catalog/view/theme/cnstorm/images/social/emoji/42.jpg",a:'喜欢'},43:{i:"catalog/view/theme/cnstorm/images/social/emoji/43.jpg",a:'一见钟情'},44:{i:"catalog/view/theme/cnstorm/images/social/emoji/44.jpg",a:'小星星'},
    45:{i:"catalog/view/theme/cnstorm/images/social/emoji/45.jpg",a:'星星'},46:{i:"catalog/view/theme/cnstorm/images/social/emoji/46.jpg",a:'心情'},47:{i:"catalog/view/theme/cnstorm/images/social/emoji/47.jpg",a:'感叹号'},48:{i:"catalog/view/theme/cnstorm/images/social/emoji/48.jpg",a:'问号'},49:{i:"catalog/view/theme/cnstorm/images/social/emoji/49.jpg",a:'睡觉'},50:{i:"catalog/view/theme/cnstorm/images/social/emoji/50.jpg",a:'快跑'},
    51:{i:"catalog/view/theme/cnstorm/images/social/emoji/51.jpg",a:'汗水'},52:{i:"catalog/view/theme/cnstorm/images/social/emoji/52.jpg",a:'音符'},53:{i:"catalog/view/theme/cnstorm/images/social/emoji/53.jpg",a:'音乐'},54:{i:"catalog/view/theme/cnstorm/images/social/emoji/54.jpg",a:'火焰'},55:{i:"catalog/view/theme/cnstorm/images/social/emoji/55.jpg",a:'大便'},56:{i:"catalog/view/theme/cnstorm/images/social/emoji/56.jpg",a:'手势'},
    57:{i:"catalog/view/theme/cnstorm/images/social/emoji/57.jpg",a:'鄙视'},58:{i:"catalog/view/theme/cnstorm/images/social/emoji/58.jpg",a:'好'},59:{i:"catalog/view/theme/cnstorm/images/social/emoji/59.jpg",a:'拳头'},60:{i:"catalog/view/theme/cnstorm/images/social/emoji/60.jpg",a:'加油'},61:{i:"catalog/view/theme/cnstorm/images/social/emoji/61.jpg",a:'剪刀手'},62:{i:"catalog/view/theme/cnstorm/images/social/emoji/62.jpg",a:'挥手'},
    63:{i:"catalog/view/theme/cnstorm/images/social/emoji/63.jpg",a:'暂停'},64:{i:"catalog/view/theme/cnstorm/images/social/emoji/64.jpg",a:'手影'},65:{i:"catalog/view/theme/cnstorm/images/social/emoji/65.jpg",a:'上面'},66:{i:"catalog/view/theme/cnstorm/images/social/emoji/66.jpg",a:'下面'},67:{i:"catalog/view/theme/cnstorm/images/social/emoji/67.jpg",a:'右边'},68:{i:"catalog/view/theme/cnstorm/images/social/emoji/68.jpg",a:'左边'},
    69:{i:"catalog/view/theme/cnstorm/images/social/emoji/69.jpg",a:'手掌'},70:{i:"catalog/view/theme/cnstorm/images/social/emoji/70.jpg",a:'祈祷'},71:{i:"catalog/view/theme/cnstorm/images/social/emoji/71.jpg",a:'食指'},72:{i:"catalog/view/theme/cnstorm/images/social/emoji/72.jpg",a:'鼓掌'},73:{i:"catalog/view/theme/cnstorm/images/social/emoji/73.jpg",a:'强壮'},74:{i:"catalog/view/theme/cnstorm/images/social/emoji/74.jpg",a:'行人'},
75:{i:"catalog/view/theme/cnstorm/images/social/emoji/75.jpg",a:'散步'},76:{i:"catalog/view/theme/cnstorm/images/social/emoji/76.jpg",a:'跑步'},77:{i:"catalog/view/theme/cnstorm/images/social/emoji/77.jpg",a:'情侣'},78:{i:"catalog/view/theme/cnstorm/images/social/emoji/78.jpg",a:'跳舞'},79:{i:"catalog/view/theme/cnstorm/images/social/emoji/79.jpg",a:'兔女郎'},80:{i:"catalog/view/theme/cnstorm/images/social/emoji/80.jpg",a:'饶命'},
81:{i:"catalog/view/theme/cnstorm/images/social/emoji/81.jpg",a:'防御'},82:{i:"catalog/view/theme/cnstorm/images/social/emoji/82.jpg",a:'服务员'},83:{i:"catalog/view/theme/cnstorm/images/social/emoji/83.jpg",a:'鞠躬'},84:{i:"catalog/view/theme/cnstorm/images/social/emoji/84.jpg",a:'亲密'},85:{i:"catalog/view/theme/cnstorm/images/social/emoji/85.jpg",a:'夫妻'},86:{i:"catalog/view/theme/cnstorm/images/social/emoji/86.jpg",a:'按摩'},
87:{i:"catalog/view/theme/cnstorm/images/social/emoji/87.jpg",a:'理发'},88:{i:"catalog/view/theme/cnstorm/images/social/emoji/88.jpg",a:'指夹油'},89:{i:"catalog/view/theme/cnstorm/images/social/emoji/89.jpg",a:'男孩'},90:{i:"catalog/view/theme/cnstorm/images/social/emoji/90.jpg",a:'女孩'},91:{i:"catalog/view/theme/cnstorm/images/social/emoji/91.jpg",a:'女人'},92:{i:"catalog/view/theme/cnstorm/images/social/emoji/92.jpg",a:'男人'},
93:{i:"catalog/view/theme/cnstorm/images/social/emoji/93.jpg",a:'婴儿'},94:{i:"catalog/view/theme/cnstorm/images/social/emoji/94.jpg",a:'老奶奶'},95:{i:"catalog/view/theme/cnstorm/images/social/emoji/95.jpg",a:'老爷爷'},96:{i:"catalog/view/theme/cnstorm/images/social/emoji/96.jpg",a:'金发碧眼'},97:{i:"catalog/view/theme/cnstorm/images/social/emoji/97.jpg",a:'瓜皮帽'},98:{i:"catalog/view/theme/cnstorm/images/social/emoji/98.jpg",a:'包头巾'},
99:{i:"catalog/view/theme/cnstorm/images/social/emoji/99.jpg",a:'建筑工人'},100:{i:"catalog/view/theme/cnstorm/images/social/emoji/100.jpg",a:'警察'},101:{i:"catalog/view/theme/cnstorm/images/social/emoji/101.jpg",a:'天使'},102:{i:"catalog/view/theme/cnstorm/images/social/emoji/102.jpg",a:'公主'},103:{i:"catalog/view/theme/cnstorm/images/social/emoji/103.jpg",a:'卫兵'},104:{i:"catalog/view/theme/cnstorm/images/social/emoji/104.jpg",a:'头骨'},
105:{i:"catalog/view/theme/cnstorm/images/social/emoji/105.jpg",a:'脚印'},106:{i:"catalog/view/theme/cnstorm/images/social/emoji/106.jpg",a:'红唇'},107:{i:"catalog/view/theme/cnstorm/images/social/emoji/107.jpg",a:'嘴巴'},108:{i:"catalog/view/theme/cnstorm/images/social/emoji/108.jpg",a:'耳朵'},109:{i:"catalog/view/theme/cnstorm/images/social/emoji/109.jpg",a:'眼睛'},110:{i:"catalog/view/theme/cnstorm/images/social/emoji/110.jpg",a:'鼻子'}};
var emoji_strtoimg = {鼻子:'emoji/110.jpg',眼睛:'emoji/109.jpg',耳朵:'emoji/108.jpg',嘴巴:'emoji/107.jpg',红唇:'emoji/106.jpg',脚印:'emoji/105.jpg',头骨:'emoji/104.jpg',卫兵:'emoji/103.jpg',公主:'emoji/102.jpg',天使:'emoji/101.jpg',警察:'emoji/100.jpg',建筑工人:'emoji/99.jpg',包头巾:'emoji/98.jpg',瓜皮帽:'emoji/97.jpg',金发碧眼:'emoji/96.jpg',老爷爷:'emoji/95.jpg',老奶奶:'emoji/94.jpg',婴儿:'emoji/93.jpg',男人:'emoji/92.jpg',女人:'emoji/91.jpg',女孩:'emoji/90.jpg',男孩:'emoji/89.jpg',指夹油:'emoji/88.jpg',理发:'emoji/87.jpg',按摩:'emoji/86.jpg',夫妻:'emoji/85.jpg',亲密:'emoji/84.jpg',鞠躬:'emoji/83.jpg',服务员:'emoji/82.jpg',防御:'emoji/81.jpg',饶命:'emoji/80.jpg',兔女郎:'emoji/79.jpg',跳舞:'emoji/78.jpg',情侣:'emoji/77.jpg',跑步:'emoji/76.jpg',散步:'emoji/75.jpg',行人:'emoji/74.jpg',强壮:'emoji/73.jpg',鼓掌:'emoji/72.jpg',食指:'emoji/71.jpg',祈祷:'emoji/70.jpg',手掌:'emoji/69.jpg',左边:'emoji/68.jpg',右边:'emoji/67.jpg',下面:'emoji/66.jpg',上面:'emoji/65.jpg',手影:'emoji/64.jpg',暂停:'emoji/63.jpg',挥手:'emoji/62.jpg',剪刀手:'emoji/61.jpg',加油:'emoji/60.jpg',拳头:'emoji/59.jpg',好:'emoji/58.jpg',鄙视:'emoji/57.jpg',手势:'emoji/56.jpg',大便:'emoji/55.jpg',火焰:'emoji/54.jpg',音乐:'emoji/53.jpg',音符:'emoji/52.jpg',汗水:'emoji/51.jpg',快跑:'emoji/50.jpg',睡觉:'emoji/49.jpg',问号:'emoji/48.jpg',感叹号:'emoji/47.jpg',心情:'emoji/46.jpg',星星:'emoji/45.jpg',小星星:'emoji/44.jpg',一见钟情:'emoji/43.jpg',喜欢:'emoji/42.jpg',心碎:'emoji/41.jpg',红心:'emoji/40.jpg',绿心:'emoji/39.jpg',粉心:'emoji/38.jpg',紫心:'emoji/37.jpg',蓝心:'emoji/36.jpg',黄心:'emoji/35.jpg',外星人:'emoji/34.jpg',恶魔:'emoji/33.jpg',生病:'emoji/32.jpg',困倦:'emoji/31.jpg',撅嘴:'emoji/30.jpg',闭嘴:'emoji/29.jpg',恐怖:'emoji/28.jpg',吃惊:'emoji/27.jpg',大笑:'emoji/26.jpg',大哭:'emoji/25.jpg',哭泣:'emoji/24.jpg',紧张:'emoji/23.jpg',害怕:'emoji/22.jpg',糟糕:'emoji/21.jpg',失望:'emoji/20.jpg',困惑:'emoji/19.jpg',失望:'emoji/18.jpg',深思:'emoji/17.jpg',冷汗:'emoji/16.jpg',假笑:'emoji/15.jpg',不高兴:'emoji/14.jpg',闭眼:'emoji/13.jpg',鬼脸:'emoji/12.jpg',微笑:'emoji/11.jpg',冥想:'emoji/10.jpg',脸红:'emoji/09.jpg',亲一口:'emoji/08.jpg',飞吻:'emoji/07.jpg',爱你:'emoji/06.jpg',眨眼:'emoji/05.jpg',窃喜:'emoji/04.jpg',微笑:'emoji/03.jpg',高兴:'emoji/02.jpg',哈哈:'emoji/01.jpg'};

//对ubb字符转换为表情图片
for(var i=0;i<($('.comment_content').length);i++){
    var comment_content = $('.comment_content').eq(i).html();
    for(var a=0;a<111;a++){
    $.each(emoji_strtoimg,function(i,n){
        comment_content=comment_content.replace(comment_content.match('\\['+i+'\]'),'<span class="emoji_position" style="background:url(\'catalog/view/theme/cnstorm/images/social/'+n+'\') -6px -6px no-repeat"></span>');
    }); 
}
$('.comment_content').eq(i).html(comment_content);    
}

for(var i=0;i<($('.emoji-ubb').length);i++){
var comment_text = $('.emoji-ubb').eq(i).html();
for(var a=0;a<111;a++){
$.each(emoji_strtoimg,function(i,n){
    comment_text=comment_text.replace(comment_text.match('\\['+i+'\]'),'<span class="emoji_position" style="background:url(\'catalog/view/theme/cnstorm/images/social/'+n+'\') -6px -6px no-repeat"></span>');
});
}
$('.emoji-ubb').eq(i).html(comment_text);
}
//ubb转换结束
var images='<div style="padding-bottom:8px;margin-top: -4px">常用表情</div>';
$.each(emoji,function(i,n){
    images+='<div class="checked-image"><img id='+i+'  alt=['+n.a+'] src="'+n.i+'"/><div class="emoji-hover"></div></div>';
});
$('.emoji-image').html(images+'<div style="width:310px;border:1px #cccccc solid;border-left:none;border-top:none;height:321px;position:absolute;top:32px;right:9px;"></div>');
$.fn.extend({
insertAtCaret: function(myValue){
var $t=$(this)[0];
if (document.selection) {
this.focus();
sel = document.selection.createRange();
sel.text = myValue;
this.focus();
}
else
if ($t.selectionStart || $t.selectionStart === 0) {
var startPos = $t.selectionStart;
var endPos = $t.selectionEnd;
var scrollTop = $t.scrollTop;
$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
this.focus();
$t.selectionStart = startPos + myValue.length;
$t.selectionEnd = startPos + myValue.length;
$t.scrollTop = scrollTop;
}
else {
this.value += myValue;
this.focus();
}
}
});

$('.m-sns-write-mood-show-panel').click(function(){
	if ($(this).attr("login") === '1'){
        if($('.'+$(this).attr('toggle')).is(':visible')){
            $('.'+$(this).attr('toggle')).fadeOut();
        }else{;
            $('.video-box,.image-box,.silder_emoji-box,.theme_box').hide();
            $('.'+$(this).attr('toggle')).fadeIn();
        }
	}else{
		var width=$(window).width();
		var height=$(window).height();
		$('.view-div-bg').fadeIn().css({width:width,height:height});
		$('.view-div-bg').fadeIn();
		$('.login_box').fadeIn();
	}
});
$(document).on('click','.u-close',function(){
	$('.'+$(this).attr('hide')).hide();
});

  //image
$('.add_image').eq(2).css({marginRight:'0px'});
$('.add_image').eq(5).css({marginRight:'0px'});
$('.add_three_img').click(function(){
   if($('.three_img_box').is(':visible')){
              $('.three_img_box').hide();
          }else{
              $('.three_img_box').show();
          }
});
$(document).on('click','.m-sns-u-emoji',function(){
    if($(this).parent('.comment_emoji_sub').find('.emoji-box').is(':hidden')){
    $('.emoji-box').fadeOut();
      $(this).parent('.comment_emoji_sub').find('.emoji-box').fadeIn();
      $(this).parent('.comment_emoji_sub').find('.emoji-image').html(images);
    }else{
    
      $(this).parent('.comment_emoji_sub').find('.emoji-box').fadeOut();
      $(this).parent('.comment_emoji_sub').find('.emoji-image').html('');

    }

});

$('.video_url').click(function(){$(this).css('color','#717171')});
//轮播
var ck=0;
var view_amout = parseInt($('.view_banner').css('width')); //可见区域  
$('.m-sns-banner-ul').css({width:($('.all_banner').find('li').length)*640+"px"});
var all_amout = parseInt($('.all_banner').css('width'));  //所有banner的宽度之和     
var ck_length = (all_amout-view_amout)/640;
var amout_width = all_amout;
var time = setInterval('$.banner()',3500);
$.extend({banner:function(){
    if(amout_width>view_amout && ck<=ck_length){
        amout_width-=ck*640;
        ck++;
        if(ck<ck_length){
            $('.all_banner').animate({left:"-=640px"});
            $('.banner-list-ul').find('li').removeClass('b_l_active');
            $('.banner-list-ul').find('li').eq(ck).addClass('b_l_active');
        }
    }
    if(ck>ck_length){
        $('.all_banner').animate({left:"+="+(640*(ck-1))+"px"});
        amout_width = parseInt($('.all_banner').css('width'));
        $('.banner-list-ul').find('li').removeClass('b_l_active');
        $('.banner-list-ul').find('li').eq(0).addClass('b_l_active');
        ck=0;
    }
}});
$('.banner-list-ul').find('li').click(function(){
    window.clearInterval(time);
    var li_index = $(this).index();
    if(li_index<ck){
        $('.banner-list-ul').find('li').removeClass('b_l_active');
        $(this).addClass('b_l_active');
        $('.all_banner').animate({left:"+="+(640*(ck-li_index))+"px"});
        ck=li_index;
    }else if(li_index>ck){
        $('.banner-list-ul').find('li').removeClass('b_l_active');
        $(this).addClass('b_l_active');
        $('.all_banner').animate({left:"-="+(640*(li_index-ck))+"px"});
        ck=li_index;
    }else{
         time = setInterval('$.banner()',3000);
    }
});
$('.banner-list-ul').find('li').mouseleave(function(){
    window.clearInterval(time);
    time = setInterval('$.banner()',3000);
});
$('.view_banner').mouseover(function(){
   $('.banner_next_prev').fadeIn();
});
   $('.banner_next_prev').mouseleave(function(){
       $(this).fadeOut();
   });
$('.banner_next_prev').find('.prev').click(function(){
     ck+=1;
     if(ck>=ck_length){
         ck=ck_length;
     }
     if(ck<ck_length && ck>0){
     window.clearInterval(time);
     $('.banner-list-ul').find('li').removeClass('b_l_active');
     $('.banner-list-ul').find('li').eq(ck).addClass('b_l_active');
     $('.all_banner').animate({left:"-=640px"});
     time = setInterval('$.banner()',3000);}
});
$('.banner_next_prev').find('.next').click(function(){
     if(ck<ck_length && ck>0){
         ck-=1;
         if(ck<=0){
             ck=0;
         }
     window.clearInterval(time);
     $('.banner-list-ul').find('li').removeClass('b_l_active');
     $('.banner-list-ul').find('li').eq(ck).addClass('b_l_active');
     $('.all_banner').animate({left:"+=640px"});
     time = setInterval('$.banner()',3000);
 }
});
//轮播结束
for(var i=0;i<$('.tarento_top').length;i++){
    $('.tarento_top').eq(i).css({background:"url('catalog/view/theme/cnstorm/images/top_"+(i+1)+".jpg') no-repeat"});
}
//回复
$(".comment_dividing").show();
$(document).on('click','.reply',function(){
if($(".r_text[id='"+$(this).attr('id')+"']").is(':visible')){
    $(".r_text[id='"+$(this).attr('id')+"']").fadeOut();
    $(".comment_dividing[id='"+$(this).attr('id')+"']").fadeIn();
}else{
$(".r_text[id='"+$(this).attr('id')+"']").fadeIn();
$(".comment_dividing[id='"+$(this).attr('id')+"']").fadeOut();
}
});
$('.com_hide').click(function(){
    $(".comment_list[id='"+$(this).attr('id')+"']").slideUp();
    $(".r_text[id='"+$(this).attr('id')+"']").slideUp();
});
$(document).on('click','.share',function(){
    $(".bdsharebuttonbox").toggle();
})
   //字符计算
   $('.video_url').keydown(function(){
   $(this).css('color','black');
   $(this).data('val',$(this).val());
   });
   $('#bask,#mood').find('textarea').keydown(function(){
   $(this).css('color','black');
      $(this).data('val',$(this).val());
      var textLength = $(this).val().length;
      $('.text-length').find('span.tot').html(140-textLength+'字'); 
      if((140-textLength)<=0){
          $(this).disabled=true;
      }
   }).focusin(function(){
      var textLength = $(this).val().length;
      $('.text-length').find('span.tot').html(140-textLength+'字');
   });
   $('.comment_text,.comment_replay_content').find('textarea').on('keydown',function(){
      var textLength = $(this).val().length;
     $('.comment_sub').find("span.tot[id='"+$(this).attr('id')+"']").html(140-textLength+'字'); 
      if((140-textLength)<=0){
          $(this).disabled=true;
      }
   }).focusin(function(){
      var textLength = $(this).val().length;
      $('.comment_sub').find("span.tot[id='"+$(this).attr('id')+"']").html(140-textLength+'字');
   });
//插入表情
$('.checked-image').data('ck','bask');
$(document).on('click','.checked-image',function(){
    if($(this).data('ck')==='mood'){
    $('#mood-textarea').insertAtCaret($(this).find('img').attr('alt'));
}else if($(this).data('ck')==='bask'){

    $('#bask-textarea').insertAtCaret($(this).find('img').attr('alt'));
}else{
   //$('#bask-textarea').insertAtCaret($(this).find('img').attr('alt'));
   $("textarea[id='"+$(this).parent('.emoji-image').attr('id')+"']").insertAtCaret($(this).find('img').attr('alt'));
}
$('.silder_emoji-box,.emoji-box').fadeOut();
});
$(document).on('mouseover','.checked-image',function(){
    $(this).find('.emoji-hover').fadeIn();
});
$(document).on('mouseleave','.checked-image',function(){
    $(this).find('.emoji-hover').fadeOut();
});
$('.page_prev').hover(function(){
    $(this).addClass('page_prev_toggle');
    $(this).removeClass('page_prev');
},function(){
    $(this).addClass('page_prev');
    $(this).removeClass('page_prev_toggle');
});
$('.page_next').hover(function(){
    $(this).addClass('page_next_toggle');
    $(this).removeClass('page_next');
},function(){
    $(this).addClass('page_next');
    $(this).removeClass('page_next_toggle');
});
//
$(document).on('click','.bask_rec_like',function(){
if($(this).attr('login')==='1'){//如没有登陆，跳转到登陆页
var self = $(this);
var mid = $(this).attr('id');
$.post('index.php?route=social/social/addPoints',{message_id:$(this).attr('id')},function(data){
    //alert(data);
    if(data==='1'){
        self.find('.tot').html(parseInt(self.find('.tot').html())+1);
  var b_l = self.html();
  if(self.next().attr('class')!=='ck_like'){
  self.after('<div class="ck_like"></div>');}
  self.next().html('<div class="bask_rec_like" login="1" id="'+mid+'" style="position:absolute;margin-top:-26px">'+b_l+'</div>');
  self.next().find('.bask_rec_like').animate({top:'-=80px',opacity:0},1000);
  }else{
  var b_l = self.html();
  if(self.next().attr('class')!=='ck_like'){
  self.after('<div class="ck_like"></div>');}
  self.next().html('<div class="bask_rec_like" login="1" id="'+mid+'" style="position:absolute;margin-top:-26px;color:#00CE9B;text-align:center;background:#ffffff">赞过了</div>');
  //self.next().find('.bask_rec_like').animate({top:'-=80px',opacity:0},1000);
        self.next().find('.bask_rec_like').animate({opacity:0},3000);

  }
});
}else{
    var width=$(window).width();
    var height=$(window).height();
    $('.view-div-bg').fadeIn().css({width:width,height:height});
    $('.view-div-bg').fadeIn();
    $('.login_box').fadeIn();
    //window.location='/index.php?route=account/login';
}

  
});

//发布晒单和心情
$('.m-sns-write-mood-u-submit').on('click',function(){
	if($(this).attr('login')==='1'){//如没有登陆，跳转到登陆页
		var m_img_len=0;
		var message_id = '';
		var firstname = '';
		var face = '';
		var utype = '';
		var country = '';
		var sm_img = '';
		var sp_img = '';
		var image='';
		var theme='';
		var theme_span = '';
		var theme_box='';
		var bask_img_box ='';
		var sync_sina=1;
		var df_txt = '';
		var bask = $('#bask-textarea').val();
		var mood = $('#mood-textarea').val();
		for(var i=0;i<$('.male').length;i++){
		  image+=$('.male').eq(i).val()+'|';
		  sm_img+='<img class="v_image-list" src="'+$('.male').eq(i).val()+'" style="width:76px;height:76px;margin-right:10px"/>';//没点击时的缩略图
		  m_img_len++;
		}
		if(sm_img){
			bask_img_box = '<div class="bask_rec_images">'+sm_img+'</div>';
		}
		var video = $('.video_url').val();
		for(var a=0;a<($('.theme_item').find('span').length);a++){
		  if(($('.theme_item').find('span').eq(a).data('ck'))==='on'){
			theme+=$('.theme_item').find('span').eq(a).attr('id')+'|';
			theme_span += '<span>'+$('.theme_item').find('span').eq(a).html()+'</span>';
		  }
		}
		if(theme_span!==''){
			theme_box= '<div class="tag_theme_box">'+'<div class="theme_item">'+theme_span+'</div>'+'</div>';
		}
		if($('#sync_sina').is(':checked')){
		  sync_sina = 1;
		}else{
		  sync_sina = 0;
		}
		if($('#bask-textarea').data('ck')==='on'){
			var d = {sync_sina:sync_sina,bask:bask,video:video,image:image};
			df_txt = bask;
		}else if($('#mood-textarea').data('ck')==='on'){
			var d = {sync_sina:sync_sina,mood:mood,video:video,theme:theme,image:image};
			df_txt = mood;
		}else{
			var d = {sync_sina:sync_sina,bask:bask,video:video,theme:theme,image:image};
			df_txt = bask;
		}
		if(d.bask || d.mood){
			$('.sub_success').fadeIn().html('发布中，请稍后...');
			$.ajax({
			  url: 'index.php?route=social/social/deliver',
			  type: 'POST',
			  data: d,
			  async:false,
              		  dataType:'json',
			  error: function(xhr) {
				alert(xhr);
			  },
			  success: function(data) {
				$('.sub_success').html('发布成功！');
				var t=setTimeout("$('.sub_success').fadeOut()",3000);
				//清空
				$(".image-box").slideUp(2000);
				$('#bask-textarea,#mood-textarea').val('');
				$.each(data,function(i,n){
				   if(i==='message_id'){
				   	message_id = n;
				   }else if(i==="face"){
				   	face = n;
				   }else if(i==="firstname"){
				   	firstname = n;
				   }else if(i==="utype"){
				   	utype = n;
				   }else if(i==="country"){
				   	country = n;
				   }
				});
				if(m_img_len<=1){
					sp_img='';
				}	
				//var df_txt=$("#x").text(df_txt).html();                 
				var new_cmt = '<div class="bask_rec_box" style="display:none" id="jmp_'+message_id+'">'
					+'<div class="bask_rec_item"><img src="'+face+'" width="30px"/><span>'+firstname
					+'</span><span class="vip"><img  src="catalog/view/theme/cnstorm/images/social/vip'+utype
					+'.jpg"/></span><span class="country">'+country+'<span class="del_comment" id="'+message_id+'"> 删除 </span></span></div>'
					+'<div class="bask_rec_text">'+df_txt+'</div>'+bask_img_box+'<div class="f-clear"></div>'+theme_box+'<div class="f-clear"></div>'
					+'</div>';
				$('.new_c_tip').after(new_cmt);
				$('.bask_rec_box').slideDown(1000);
				if ($('.male').length >= 2){
					$.ajax({
						  url: 'index.php?route=order/order/shuang11',
						  type: 'POST',
						  data: {uname_id:$('.customer_id').val(),uname:$('.customer_name').val()},
						  dataType:'json',
						  error: function(xhr) {},
						  success: function() {}
					});
				}
			  }
			});
			if(sync_sina == 1){
			  window.open ('https://api.weibo.com/oauth2/authorize?client_id=2144919427&redirect_uri=http://www.acgstorm.com/index.php?route=social/social/sendwb&response_type=code','newwindow','height=440,width=630,top=150,left=300,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
			}
		}else{
			$('.sub_success').show().html('不要忘记输入内容哦');
			var t=setTimeout("$('.sub_success').fadeOut()",3000);
		}
	}else{
		var width=$(window).width();
		var height=$(window).height();
		$('.view-div-bg').fadeIn().css({width:width,height:height});
		$('.view-div-bg').fadeIn();
		$('.login_box').fadeIn();
	}
});

$(document).on('click','.comt',function(){
if($(this).attr('login')==='1'){//如没有登陆，跳转到登陆页
    $(".comment_list,.r_text").fadeOut();
    if($(".comment_list[id='"+$(this).attr('id')+"']").length>0){
    if($(".comment_list[id='"+$(this).attr('id')+"']").is(':visible')&&$(".r_text[id='"+$(this).attr('id')+"']").is(':visible')){
        $(".comment_list[id='"+$(this).attr('id')+"']").slideUp();
        $(".r_text[id='"+$(this).attr('id')+"']").slideUp();
    }else{
        $(".r_text[id='"+$(this).attr('id')+"']").slideDown();
    $(".comment_list[id='"+$(this).attr('id')+"']").slideDown();}
    }else{
    if($(".r_text[id='"+$(this).attr('id')+"']").is(':visible')){
        $(".r_text[id='"+$(this).attr('id')+"']").slideUp();
    }else{
        $(".r_text[id='"+$(this).attr('id')+"']").slideDown();}
    }
    }else{
    var width=$(window).width();
    var height=$(window).height();
    $('.view-div-bg').fadeIn().css({width:width,height:height});
    $('.view-div-bg').fadeIn();
        $('.login_box').fadeIn();
        //window.location='/index.php?route=account/login';
    }
});
$('.theme_choose').click(function(){
if($(this).attr('login')==='1'){
var self = $(this);
if($(this).data('isload') !==1){
    $.ajax({
    url: 'index.php?route=social/social/getTheme',
    type: 'POST',
    dataType: "json",
    error: function(data) {
      alert('Ajax error');
    },
    success: function(data){
    $.each(data,function(i,n){
    self.parent().find('.theme_item').append('<span id="'+n.theme_id+'">'+n.description+'</span>'); 
    });
    self.data('isload',1);
  
//插入主题
$('.theme_item').data('ck',2);
$('.theme_item').find('span').on('click',function(){
if($('.theme_item').data('ck')>0 && $('.theme_item').data('ck')<=2){
if($(this).data('ck')==='on'){
    $(this).animate({opacity:0.6}).animate({opacity:1}).css({background:'#d9d9d9',color:'#333333'});
    $(this).removeData('ck');
    $('.theme_item').data('ck',$('.theme_item').data('ck')+1);
}else{   
    $(this).animate({opacity:0.6}).animate({opacity:1}).css({background:'#fb6e52',color:'#ffffff'});
    $(this).data('ck','on');
    $('.theme_item').data('ck',$('.theme_item').data('ck')-1);
} 
}else if($('.theme_item').data('ck')===0){
    if($(this).data('ck')==='on'){
    $(this).animate({opacity:0.6}).animate({opacity:1}).css({background:'#d9d9d9',color:'#333333'});$(this).removeData('ck');
    $('.theme_item').data('ck',$('.theme_item').data('ck')+1);
    }

}

}); }
});
}
$(this).parent('.theme_option').find('.theme_down_up').removeClass('theme_down_up').addClass('theme_down_up_toggle');
   if($(this).parent('.theme_option').find('.theme_box').is(':visible')){
       $(this).parent('.theme_option').find('.theme_down_up_toggle').addClass('theme_down_up');
       $(this).parent('.theme_option').find('.theme_down_up_toggle').removeClass('theme_down_up_toggle'); 
       $(this).parent('.theme_option').find('.theme_box').fadeOut();
       self.css({color:'#444444'});
   }else{
   $('.video-box,.image-box,.emoji-box,.theme_box').fadeOut();
   $(this).parent('.theme_option').find('.theme_down_up').addClass('theme_down_up_toggle');
   $(this).parent('.theme_option').find('.theme_down_up').removeClass('theme_down_up');
   //$(this).parent('.theme_option').find('.theme_down_up').removeClass('theme_down_up_toggle').addClass('theme_down_up'); 
   $(this).parent('.theme_option').find('.theme_box').fadeIn();self.css({color:'#fb6e52'}); 
   }
}
});
$(document).on('click','.sub',function(){
  //alert($(this).attr('cid'));
  //alert($("textarea[id='"+($(this).attr('id'))+"']").val());
        var self = $(this);
        if($(this).attr('login')==='1'){//如没有登陆，跳转到登陆页
        if($("textarea[id='"+($(this).attr('id'))+"']").val()!==''){
  $.ajax({
    url:'index.php?route=social/social/messagereply',
    data:{message_id:$(this).attr('mid'),comment_text:$("textarea[id='"+($(this).attr('id'))+"']").val(),video:$(".video_url").val()},
    type: 'POST',
    error: function(data) {
      alert('Ajax error');
    },
    success: function(data){
                        var text = $("textarea[id='"+self.attr("id")+"']").val();
                      text=$("#x").text(text).html();
                       var str = '<div class="ajax_rec" style="display:none"><div class="f-clear"></div>'+
                        '<div class="comment_item" style="padding-top:10px"><img src="'+$('#face').attr('face')+'"><span style="color:#0c73c2">'+$('#face').attr('cnstormer_name')+'</span><span class="floor"></span></div>'+
                        '<div class="comment_content reply_text">'+text+'</span>'+
                        '</div>'+

                        '<div class="f-clear"></div>'+

                        '<div class="comment_share">'+

                        '<span class="com reply" id="re_'+data+'">回复</span>'+

                        '</div>'+

                        '<div class="f-clear"></div>'+

                        '<div class="comment_dividing" id="re_'+data+'"></div>'+

                            '<div class="r_text" id="re_'+data+'"><div class="f-clear"></div>'+

                            '<div class="comment_replay_box">'+

                                '<div class="comment_replay_pointer"></div>'+

                                '<div class="comment_replay_content" id="re_'+data+'"><textarea maxlength="140" id="re_'+data+'" placeholder="回复'+$('#face').attr('cnstormer_name')+'"></textarea></div>'+

                                    '<div class="comment_emoji_sub">'+

                                        '<div class="m-sns-u-emoji"> </div>'+

                                        '<div class="emoji-box">'+

                                            '<div class="m-sns-write-mood-pointer emoji-pointer"></div>'+

                                            '<div class="u-close" hide="emoji-box"></div>'+

                                            '<div class="emoji-image" id="re_'+data+'"><div style="padding-bottom:8px;margin-top: -4px">常用表情</div><div class="checked-image"><img id="1" alt="[哈哈]" src="catalog/view/theme/cnstorm/images/social/emoji/01.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="2" alt="[高兴]" src="catalog/view/theme/cnstorm/images/social/emoji/02.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="3" alt="[微笑]" src="catalog/view/theme/cnstorm/images/social/emoji/03.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="4" alt="[窃喜]" src="catalog/view/theme/cnstorm/images/social/emoji/04.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="5" alt="[眨眼]" src="catalog/view/theme/cnstorm/images/social/emoji/05.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="6" alt="[爱你]" src="catalog/view/theme/cnstorm/images/social/emoji/06.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="7" alt="[飞吻]" src="catalog/view/theme/cnstorm/images/social/emoji/07.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="8" alt="[亲一口]" src="catalog/view/theme/cnstorm/images/social/emoji/08.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="9" alt="[脸红]" src="catalog/view/theme/cnstorm/images/social/emoji/09.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="10" alt="[冥想]" src="catalog/view/theme/cnstorm/images/social/emoji/10.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="11" alt="[微笑]" src="catalog/view/theme/cnstorm/images/social/emoji/11.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="12" alt="[鬼脸]" src="catalog/view/theme/cnstorm/images/social/emoji/12.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="13" alt="[闭眼]" src="catalog/view/theme/cnstorm/images/social/emoji/13.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="14" alt="[不高兴]" src="catalog/view/theme/cnstorm/images/social/emoji/14.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="15" alt="[假笑]" src="catalog/view/theme/cnstorm/images/social/emoji/15.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="16" alt="[冷汗]" src="catalog/view/theme/cnstorm/images/social/emoji/16.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="17" alt="[深思]" src="catalog/view/theme/cnstorm/images/social/emoji/17.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="18" alt="[失望]" src="catalog/view/theme/cnstorm/images/social/emoji/18.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="19" alt="[困惑]" src="catalog/view/theme/cnstorm/images/social/emoji/19.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="20" alt="[失望]" src="catalog/view/theme/cnstorm/images/social/emoji/20.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="21" alt="[糟糕]" src="catalog/view/theme/cnstorm/images/social/emoji/21.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="22" alt="[害怕]" src="catalog/view/theme/cnstorm/images/social/emoji/22.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="23" alt="[紧张]" src="catalog/view/theme/cnstorm/images/social/emoji/23.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="24" alt="[哭泣]" src="catalog/view/theme/cnstorm/images/social/emoji/24.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="25" alt="[大哭]" src="catalog/view/theme/cnstorm/images/social/emoji/25.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="26" alt="[大笑]" src="catalog/view/theme/cnstorm/images/social/emoji/26.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="27" alt="[吃惊]" src="catalog/view/theme/cnstorm/images/social/emoji/27.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="28" alt="[恐怖]" src="catalog/view/theme/cnstorm/images/social/emoji/28.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="29" alt="[闭嘴]" src="catalog/view/theme/cnstorm/images/social/emoji/29.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="30" alt="[撅嘴]" src="catalog/view/theme/cnstorm/images/social/emoji/30.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="31" alt="[困倦]" src="catalog/view/theme/cnstorm/images/social/emoji/31.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="32" alt="[生病]" src="catalog/view/theme/cnstorm/images/social/emoji/32.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="33" alt="[恶魔]" src="catalog/view/theme/cnstorm/images/social/emoji/33.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="34" alt="[外星人]" src="catalog/view/theme/cnstorm/images/social/emoji/34.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="35" alt="[黄心]" src="catalog/view/theme/cnstorm/images/social/emoji/35.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="36" alt="[蓝心]" src="catalog/view/theme/cnstorm/images/social/emoji/36.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="37" alt="[紫心]" src="catalog/view/theme/cnstorm/images/social/emoji/37.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="38" alt="[粉心]" src="catalog/view/theme/cnstorm/images/social/emoji/38.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="39" alt="[绿心]" src="catalog/view/theme/cnstorm/images/social/emoji/39.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="40" alt="[红心]" src="catalog/view/theme/cnstorm/images/social/emoji/40.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="41" alt="[心碎]" src="catalog/view/theme/cnstorm/images/social/emoji/41.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="42" alt="[喜欢]" src="catalog/view/theme/cnstorm/images/social/emoji/42.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="43" alt="[一见钟情]" src="catalog/view/theme/cnstorm/images/social/emoji/43.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="44" alt="[小星星]" src="catalog/view/theme/cnstorm/images/social/emoji/44.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="45" alt="[星星]" src="catalog/view/theme/cnstorm/images/social/emoji/45.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="46" alt="[心情]" src="catalog/view/theme/cnstorm/images/social/emoji/46.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="47" alt="[感叹号]" src="catalog/view/theme/cnstorm/images/social/emoji/47.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="48" alt="[问号]" src="catalog/view/theme/cnstorm/images/social/emoji/48.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="49" alt="[睡觉]" src="catalog/view/theme/cnstorm/images/social/emoji/49.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="50" alt="[快跑]" src="catalog/view/theme/cnstorm/images/social/emoji/50.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="51" alt="[汗水]" src="catalog/view/theme/cnstorm/images/social/emoji/51.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="52" alt="[音符]" src="catalog/view/theme/cnstorm/images/social/emoji/52.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="53" alt="[音乐]" src="catalog/view/theme/cnstorm/images/social/emoji/53.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="54" alt="[火焰]" src="catalog/view/theme/cnstorm/images/social/emoji/54.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="55" alt="[大便]" src="catalog/view/theme/cnstorm/images/social/emoji/55.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="56" alt="[手势]" src="catalog/view/theme/cnstorm/images/social/emoji/56.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="57" alt="[鄙视]" src="catalog/view/theme/cnstorm/images/social/emoji/57.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="58" alt="[好]" src="catalog/view/theme/cnstorm/images/social/emoji/58.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="59" alt="[拳头]" src="catalog/view/theme/cnstorm/images/social/emoji/59.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="60" alt="[加油]" src="catalog/view/theme/cnstorm/images/social/emoji/60.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="61" alt="[剪刀手]" src="catalog/view/theme/cnstorm/images/social/emoji/61.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="62" alt="[挥手]" src="catalog/view/theme/cnstorm/images/social/emoji/62.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="63" alt="[暂停]" src="catalog/view/theme/cnstorm/images/social/emoji/63.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="64" alt="[手影]" src="catalog/view/theme/cnstorm/images/social/emoji/64.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="65" alt="[上面]" src="catalog/view/theme/cnstorm/images/social/emoji/65.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="66" alt="[下面]" src="catalog/view/theme/cnstorm/images/social/emoji/66.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="67" alt="[右边]" src="catalog/view/theme/cnstorm/images/social/emoji/67.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="68" alt="[左边]" src="catalog/view/theme/cnstorm/images/social/emoji/68.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="69" alt="[手掌]" src="catalog/view/theme/cnstorm/images/social/emoji/69.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="70" alt="[祈祷]" src="catalog/view/theme/cnstorm/images/social/emoji/70.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="71" alt="[食指]" src="catalog/view/theme/cnstorm/images/social/emoji/71.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="72" alt="[鼓掌]" src="catalog/view/theme/cnstorm/images/social/emoji/72.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="73" alt="[强壮]" src="catalog/view/theme/cnstorm/images/social/emoji/73.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="74" alt="[行人]" src="catalog/view/theme/cnstorm/images/social/emoji/74.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="75" alt="[散步]" src="catalog/view/theme/cnstorm/images/social/emoji/75.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="76" alt="[跑步]" src="catalog/view/theme/cnstorm/images/social/emoji/76.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="77" alt="[情侣]" src="catalog/view/theme/cnstorm/images/social/emoji/77.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="78" alt="[跳舞]" src="catalog/view/theme/cnstorm/images/social/emoji/78.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="79" alt="[兔女郎]" src="catalog/view/theme/cnstorm/images/social/emoji/79.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="80" alt="[饶命]" src="catalog/view/theme/cnstorm/images/social/emoji/80.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="81" alt="[防御]" src="catalog/view/theme/cnstorm/images/social/emoji/81.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="82" alt="[服务员]" src="catalog/view/theme/cnstorm/images/social/emoji/82.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="83" alt="[鞠躬]" src="catalog/view/theme/cnstorm/images/social/emoji/83.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="84" alt="[亲密]" src="catalog/view/theme/cnstorm/images/social/emoji/84.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="85" alt="[夫妻]" src="catalog/view/theme/cnstorm/images/social/emoji/85.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="86" alt="[按摩]" src="catalog/view/theme/cnstorm/images/social/emoji/86.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="87" alt="[理发]" src="catalog/view/theme/cnstorm/images/social/emoji/87.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="88" alt="[指夹油]" src="catalog/view/theme/cnstorm/images/social/emoji/88.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="89" alt="[男孩]" src="catalog/view/theme/cnstorm/images/social/emoji/89.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="90" alt="[女孩]" src="catalog/view/theme/cnstorm/images/social/emoji/90.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="91" alt="[女人]" src="catalog/view/theme/cnstorm/images/social/emoji/91.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="92" alt="[男人]" src="catalog/view/theme/cnstorm/images/social/emoji/92.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="93" alt="[婴儿]" src="catalog/view/theme/cnstorm/images/social/emoji/93.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="94" alt="[老奶奶]" src="catalog/view/theme/cnstorm/images/social/emoji/94.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="95" alt="[老爷爷]" src="catalog/view/theme/cnstorm/images/social/emoji/95.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="96" alt="[金发碧眼]" src="catalog/view/theme/cnstorm/images/social/emoji/96.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="97" alt="[瓜皮帽]" src="catalog/view/theme/cnstorm/images/social/emoji/97.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="98" alt="[包头巾]" src="catalog/view/theme/cnstorm/images/social/emoji/98.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="99" alt="[建筑工人]" src="catalog/view/theme/cnstorm/images/social/emoji/99.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="100" alt="[警察]" src="catalog/view/theme/cnstorm/images/social/emoji/100.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="101" alt="[天使]" src="catalog/view/theme/cnstorm/images/social/emoji/101.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="102" alt="[公主]" src="catalog/view/theme/cnstorm/images/social/emoji/102.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="103" alt="[卫兵]" src="catalog/view/theme/cnstorm/images/social/emoji/103.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="104" alt="[头骨]" src="catalog/view/theme/cnstorm/images/social/emoji/104.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="105" alt="[脚印]" src="catalog/view/theme/cnstorm/images/social/emoji/105.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="106" alt="[红唇]" src="catalog/view/theme/cnstorm/images/social/emoji/106.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="107" alt="[嘴巴]" src="catalog/view/theme/cnstorm/images/social/emoji/107.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="108" alt="[耳朵]" src="catalog/view/theme/cnstorm/images/social/emoji/108.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="109" alt="[眼睛]" src="catalog/view/theme/cnstorm/images/social/emoji/109.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="110" alt="[鼻子]" src="catalog/view/theme/cnstorm/images/social/emoji/110.jpg"><div class="emoji-hover"></div></div><div style="width:310px;border:1px #cccccc solid;border-left:none;border-top:none;height:321px;position:absolute;top:32px;right:9px;"></div></div>'+

                                        '</div>'+

                                    '</div>'+

                                '<div class="comment_sub"><span class="tot" id="re_'+data+'">140字</span><span id="re_'+data+'" reply_name="'+$('#face').attr('cnstormer_name')+'" message_id="313" reply_id="62" class="r_sub">发布</span></div>'+

                            '</div>'+

                            '</div></div>';
                            $("textarea[id='"+(self.attr('id'))+"']").val('');//清空表单；防止重复提交；
                            //$(".comment_list[id='"+self.attr('id')+"']").prepend('<span id="x" style="display:none"></span>');
                            $(".comment_list[id='"+self.attr('id')+"']").prepend(str);
                            $(".ajax_rec").slideDown(1000);
      //window.location.reload();
    }
  })}else{
        
        }
    }else{
var width=$(window).width();
var height=$(window).height();
   $('.view-div-bg').fadeIn().css({width:width,height:height});
   $('.view-div-bg').fadeIn();
   $('.login_box').fadeIn();
}
});
$(document).on('click','.r_sub',function(){
    var self = $(this);
  //alert($(this).attr('rely_id'));
  //alert($("textarea[id='"+($(this).attr('id'))+"']").val());
        if($("textarea[id='"+($(this).attr('id'))+"']").val()!==''){
  $.ajax({
    url:'index.php?route=social/social/commentreply',
    data:{message_id:$(this).attr('message_id'),reply_id:$(this).attr('reply_id'),reply_name:$(this).attr('reply_name'),comment_text:$("textarea[id='"+($(this).attr('id'))+"']").val()},
    type: 'POST',
    error: function(data) {
      //alert('Ajax error');
    },
    success: function(data){
                    if(data){
                        var text = $("textarea[id='"+self.attr("id")+"']").val();
                        text=$("#x").text(text).html();
                        var str = '<div class="ajax_rec" style="display:none"><div class="f-clear"></div>'+
                        '<div class="comment_item" style="padding-top:10px"><img src="'+$('#face').attr('face')+'"><span style="color:#0c73c2">'+$('#face').attr('cnstormer_name')+'</span><span class="floor"></span></div>'+
                        '<div class="comment_content reply_text">回复<span style="color:#0c73c2">'+self.attr('reply_name')+'</span>：'+text+'</span>'+
                        '</div>'+

                        '<div class="f-clear"></div>'+

                        '<div class="comment_share">'+

                        '<span class="com reply" id="re_'+data+'">回复</span>'+

                        '</div>'+

                        '<div class="f-clear"></div>'+

                        '<div class="comment_dividing" id="re_'+data+'"></div>'+

                            '<div class="r_text" id="re_'+data+'"><div class="f-clear"></div>'+

                            '<div class="comment_replay_box">'+

                                '<div class="comment_replay_pointer"></div>'+

                                '<div class="comment_replay_content" id="re_'+data+'"><textarea maxlength="140" id="re_'+data+'" placeholder="回复'+$('#face').attr('cnstormer_name')+'"></textarea></div>'+

                                    '<div class="comment_emoji_sub">'+

                                        '<div class="m-sns-u-emoji"> </div>'+

                                        '<div class="emoji-box">'+

                                            '<div class="m-sns-write-mood-pointer emoji-pointer"></div>'+

                                            '<div class="u-close" hide="emoji-box"></div>'+

                                            '<div class="emoji-image" id="re_'+data+'"><div style="padding-bottom:8px;margin-top: -4px">常用表情</div><div class="checked-image"><img id="1" alt="[哈哈]" src="catalog/view/theme/cnstorm/images/social/emoji/01.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="2" alt="[高兴]" src="catalog/view/theme/cnstorm/images/social/emoji/02.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="3" alt="[微笑]" src="catalog/view/theme/cnstorm/images/social/emoji/03.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="4" alt="[窃喜]" src="catalog/view/theme/cnstorm/images/social/emoji/04.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="5" alt="[眨眼]" src="catalog/view/theme/cnstorm/images/social/emoji/05.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="6" alt="[爱你]" src="catalog/view/theme/cnstorm/images/social/emoji/06.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="7" alt="[飞吻]" src="catalog/view/theme/cnstorm/images/social/emoji/07.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="8" alt="[亲一口]" src="catalog/view/theme/cnstorm/images/social/emoji/08.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="9" alt="[脸红]" src="catalog/view/theme/cnstorm/images/social/emoji/09.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="10" alt="[冥想]" src="catalog/view/theme/cnstorm/images/social/emoji/10.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="11" alt="[微笑]" src="catalog/view/theme/cnstorm/images/social/emoji/11.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="12" alt="[鬼脸]" src="catalog/view/theme/cnstorm/images/social/emoji/12.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="13" alt="[闭眼]" src="catalog/view/theme/cnstorm/images/social/emoji/13.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="14" alt="[不高兴]" src="catalog/view/theme/cnstorm/images/social/emoji/14.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="15" alt="[假笑]" src="catalog/view/theme/cnstorm/images/social/emoji/15.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="16" alt="[冷汗]" src="catalog/view/theme/cnstorm/images/social/emoji/16.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="17" alt="[深思]" src="catalog/view/theme/cnstorm/images/social/emoji/17.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="18" alt="[失望]" src="catalog/view/theme/cnstorm/images/social/emoji/18.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="19" alt="[困惑]" src="catalog/view/theme/cnstorm/images/social/emoji/19.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="20" alt="[失望]" src="catalog/view/theme/cnstorm/images/social/emoji/20.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="21" alt="[糟糕]" src="catalog/view/theme/cnstorm/images/social/emoji/21.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="22" alt="[害怕]" src="catalog/view/theme/cnstorm/images/social/emoji/22.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="23" alt="[紧张]" src="catalog/view/theme/cnstorm/images/social/emoji/23.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="24" alt="[哭泣]" src="catalog/view/theme/cnstorm/images/social/emoji/24.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="25" alt="[大哭]" src="catalog/view/theme/cnstorm/images/social/emoji/25.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="26" alt="[大笑]" src="catalog/view/theme/cnstorm/images/social/emoji/26.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="27" alt="[吃惊]" src="catalog/view/theme/cnstorm/images/social/emoji/27.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="28" alt="[恐怖]" src="catalog/view/theme/cnstorm/images/social/emoji/28.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="29" alt="[闭嘴]" src="catalog/view/theme/cnstorm/images/social/emoji/29.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="30" alt="[撅嘴]" src="catalog/view/theme/cnstorm/images/social/emoji/30.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="31" alt="[困倦]" src="catalog/view/theme/cnstorm/images/social/emoji/31.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="32" alt="[生病]" src="catalog/view/theme/cnstorm/images/social/emoji/32.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="33" alt="[恶魔]" src="catalog/view/theme/cnstorm/images/social/emoji/33.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="34" alt="[外星人]" src="catalog/view/theme/cnstorm/images/social/emoji/34.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="35" alt="[黄心]" src="catalog/view/theme/cnstorm/images/social/emoji/35.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="36" alt="[蓝心]" src="catalog/view/theme/cnstorm/images/social/emoji/36.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="37" alt="[紫心]" src="catalog/view/theme/cnstorm/images/social/emoji/37.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="38" alt="[粉心]" src="catalog/view/theme/cnstorm/images/social/emoji/38.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="39" alt="[绿心]" src="catalog/view/theme/cnstorm/images/social/emoji/39.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="40" alt="[红心]" src="catalog/view/theme/cnstorm/images/social/emoji/40.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="41" alt="[心碎]" src="catalog/view/theme/cnstorm/images/social/emoji/41.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="42" alt="[喜欢]" src="catalog/view/theme/cnstorm/images/social/emoji/42.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="43" alt="[一见钟情]" src="catalog/view/theme/cnstorm/images/social/emoji/43.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="44" alt="[小星星]" src="catalog/view/theme/cnstorm/images/social/emoji/44.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="45" alt="[星星]" src="catalog/view/theme/cnstorm/images/social/emoji/45.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="46" alt="[心情]" src="catalog/view/theme/cnstorm/images/social/emoji/46.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="47" alt="[感叹号]" src="catalog/view/theme/cnstorm/images/social/emoji/47.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="48" alt="[问号]" src="catalog/view/theme/cnstorm/images/social/emoji/48.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="49" alt="[睡觉]" src="catalog/view/theme/cnstorm/images/social/emoji/49.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="50" alt="[快跑]" src="catalog/view/theme/cnstorm/images/social/emoji/50.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="51" alt="[汗水]" src="catalog/view/theme/cnstorm/images/social/emoji/51.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="52" alt="[音符]" src="catalog/view/theme/cnstorm/images/social/emoji/52.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="53" alt="[音乐]" src="catalog/view/theme/cnstorm/images/social/emoji/53.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="54" alt="[火焰]" src="catalog/view/theme/cnstorm/images/social/emoji/54.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="55" alt="[大便]" src="catalog/view/theme/cnstorm/images/social/emoji/55.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="56" alt="[手势]" src="catalog/view/theme/cnstorm/images/social/emoji/56.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="57" alt="[鄙视]" src="catalog/view/theme/cnstorm/images/social/emoji/57.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="58" alt="[好]" src="catalog/view/theme/cnstorm/images/social/emoji/58.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="59" alt="[拳头]" src="catalog/view/theme/cnstorm/images/social/emoji/59.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="60" alt="[加油]" src="catalog/view/theme/cnstorm/images/social/emoji/60.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="61" alt="[剪刀手]" src="catalog/view/theme/cnstorm/images/social/emoji/61.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="62" alt="[挥手]" src="catalog/view/theme/cnstorm/images/social/emoji/62.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="63" alt="[暂停]" src="catalog/view/theme/cnstorm/images/social/emoji/63.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="64" alt="[手影]" src="catalog/view/theme/cnstorm/images/social/emoji/64.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="65" alt="[上面]" src="catalog/view/theme/cnstorm/images/social/emoji/65.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="66" alt="[下面]" src="catalog/view/theme/cnstorm/images/social/emoji/66.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="67" alt="[右边]" src="catalog/view/theme/cnstorm/images/social/emoji/67.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="68" alt="[左边]" src="catalog/view/theme/cnstorm/images/social/emoji/68.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="69" alt="[手掌]" src="catalog/view/theme/cnstorm/images/social/emoji/69.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="70" alt="[祈祷]" src="catalog/view/theme/cnstorm/images/social/emoji/70.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="71" alt="[食指]" src="catalog/view/theme/cnstorm/images/social/emoji/71.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="72" alt="[鼓掌]" src="catalog/view/theme/cnstorm/images/social/emoji/72.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="73" alt="[强壮]" src="catalog/view/theme/cnstorm/images/social/emoji/73.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="74" alt="[行人]" src="catalog/view/theme/cnstorm/images/social/emoji/74.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="75" alt="[散步]" src="catalog/view/theme/cnstorm/images/social/emoji/75.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="76" alt="[跑步]" src="catalog/view/theme/cnstorm/images/social/emoji/76.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="77" alt="[情侣]" src="catalog/view/theme/cnstorm/images/social/emoji/77.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="78" alt="[跳舞]" src="catalog/view/theme/cnstorm/images/social/emoji/78.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="79" alt="[兔女郎]" src="catalog/view/theme/cnstorm/images/social/emoji/79.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="80" alt="[饶命]" src="catalog/view/theme/cnstorm/images/social/emoji/80.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="81" alt="[防御]" src="catalog/view/theme/cnstorm/images/social/emoji/81.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="82" alt="[服务员]" src="catalog/view/theme/cnstorm/images/social/emoji/82.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="83" alt="[鞠躬]" src="catalog/view/theme/cnstorm/images/social/emoji/83.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="84" alt="[亲密]" src="catalog/view/theme/cnstorm/images/social/emoji/84.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="85" alt="[夫妻]" src="catalog/view/theme/cnstorm/images/social/emoji/85.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="86" alt="[按摩]" src="catalog/view/theme/cnstorm/images/social/emoji/86.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="87" alt="[理发]" src="catalog/view/theme/cnstorm/images/social/emoji/87.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="88" alt="[指夹油]" src="catalog/view/theme/cnstorm/images/social/emoji/88.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="89" alt="[男孩]" src="catalog/view/theme/cnstorm/images/social/emoji/89.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="90" alt="[女孩]" src="catalog/view/theme/cnstorm/images/social/emoji/90.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="91" alt="[女人]" src="catalog/view/theme/cnstorm/images/social/emoji/91.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="92" alt="[男人]" src="catalog/view/theme/cnstorm/images/social/emoji/92.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="93" alt="[婴儿]" src="catalog/view/theme/cnstorm/images/social/emoji/93.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="94" alt="[老奶奶]" src="catalog/view/theme/cnstorm/images/social/emoji/94.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="95" alt="[老爷爷]" src="catalog/view/theme/cnstorm/images/social/emoji/95.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="96" alt="[金发碧眼]" src="catalog/view/theme/cnstorm/images/social/emoji/96.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="97" alt="[瓜皮帽]" src="catalog/view/theme/cnstorm/images/social/emoji/97.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="98" alt="[包头巾]" src="catalog/view/theme/cnstorm/images/social/emoji/98.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="99" alt="[建筑工人]" src="catalog/view/theme/cnstorm/images/social/emoji/99.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="100" alt="[警察]" src="catalog/view/theme/cnstorm/images/social/emoji/100.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="101" alt="[天使]" src="catalog/view/theme/cnstorm/images/social/emoji/101.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="102" alt="[公主]" src="catalog/view/theme/cnstorm/images/social/emoji/102.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="103" alt="[卫兵]" src="catalog/view/theme/cnstorm/images/social/emoji/103.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="104" alt="[头骨]" src="catalog/view/theme/cnstorm/images/social/emoji/104.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="105" alt="[脚印]" src="catalog/view/theme/cnstorm/images/social/emoji/105.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="106" alt="[红唇]" src="catalog/view/theme/cnstorm/images/social/emoji/106.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="107" alt="[嘴巴]" src="catalog/view/theme/cnstorm/images/social/emoji/107.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="108" alt="[耳朵]" src="catalog/view/theme/cnstorm/images/social/emoji/108.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="109" alt="[眼睛]" src="catalog/view/theme/cnstorm/images/social/emoji/109.jpg"><div class="emoji-hover"></div></div><div class="checked-image"><img id="110" alt="[鼻子]" src="catalog/view/theme/cnstorm/images/social/emoji/110.jpg"><div class="emoji-hover"></div></div><div style="width:310px;border:1px #cccccc solid;border-left:none;border-top:none;height:321px;position:absolute;top:32px;right:9px;"></div></div>'+

                                        '</div>'+

                                    '</div>'+

                                '<div class="comment_sub"><span class="tot" id="re_'+data+'">140字</span><span id="re_'+data+'" reply_name="'+$('#face').attr('cnstormer_name')+'" message_id="313" reply_id="62" class="r_sub">发布</span></div>'+

                            '</div>'+

                            '</div></div>';
                            $(".comment_list[id='com_"+self.attr('message_id')+"']").prepend(str);
                            $(".ajax_rec").slideDown(1000);
                        //window.location.reload();
                    }
    }
  })}
});
$(document).on('click','.del_comment',function(){
    var self = $(this);
    $.ajax({
        url:'index.php?route=social/social/delMessage',
        data:{message_id:$(this).attr('id')},
        type:'post',
        error:function(xhr){
            alert('del fail');
        },
        success:function(data){
            if(data==='1'){
                $(".bask_rec_box[id='jmp_"+self.attr('id')+"']").animate({opacity:0},200);
                $(".bask_rec_box[id='jmp_"+self.attr('id')+"']").slideUp();
                $(".bask_rec_box[id='jmp_"+self.attr('id')+"']").remove();
            }
        }
    });
});
$(document).on('click','.del_message_comment',function(){
    var self = $(this);
    $.ajax({
        url:'index.php?route=social/social/delComment',
        data:{comment_id:$(this).attr('id'),message_id:$(this).attr('mid')},
        type:'post',
        error:function(xhr){
            alert('del fail');
        },
        success:function(data){
            if(data==='1'){
                $(".comment_item_one[id='comment_item_one_"+self.attr('id')+"']").animate({opacity:0},200);
                $(".comment_item_one[id='comment_item_one_"+self.attr('id')+"']").slideUp();
                $(".comment_item_one[id='comment_item_one_"+self.attr('id')+"']").remove();
            }
        }
    });
});
$(document).load('http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=2&ptype=1&speed=0&skin=1&isTitle=0&noborder=1&isWeibo=1&isFans=0&uid=2347421893&verifier=814feb4e&dpc=1','',function(){
    var sina_iframe = '<iframe width="100%" height="550" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=2&ptype=1&speed=0&skin=1&isTitle=0&noborder=1&isWeibo=1&isFans=0&uid=2347421893&verifier=814feb4e&dpc=1"></iframe>';
    $('.sina_iframe').html(sina_iframe);
});
//snsmanager.tpl中删除评论
$(document).on('click','.del_cmt',function(){
    var self = $(this);
    $.ajax({
        url:'index.php?route=social/social/delComment',
        data:{comment_id:$(this).attr('id')},
        type:'post',
        error:function(xhr){
            alert('del fail');
        },
        success:function(data){
            if(data==='1'){
                $(".comment-list[id='com_"+self.attr('id')+"']").animate({opacity:0},200);
                $(".comment-list[id='com_"+self.attr('id')+"']").slideUp();
            }
        }
    });
});
//登陆窗口
$('.close_login').click(function(){
    $('.view-div-bg').fadeOut();
    $('.login_box').toggle();
})

});
function checkVideoUrl(){
    var p = /(youtube\.com|youku\.com|tudou\.com|ku6\.com|56\.com|letv\.com|(my\.)?tv\.sohu\.com)/;
    if(!(p.test($('.video_url').val()))){
        $('.v_url_error').show();
        $('.video_url').val('');
    }else{
        $('.v_url_error').hide();
    }
}
