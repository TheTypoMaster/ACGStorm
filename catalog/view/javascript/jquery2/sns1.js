$(function(){
$(document).on('click','.pages_change ul li a',function(){
      var loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 400, easingIn : mina.easeinout } );
      var url = $(this).attr('href');
      loader.show();
      window.scrollTo(0,475);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
          loader.hide();
          setTimeout(function(){$('#dvContent').html(data);}, 500);
        }
      });
      return false;
    });



//footre
$('.wechat_hover').hide();
$('.douban').hover(function(){
    $('.wechat_hover').fadeIn();
},function(){
$('.wechat_hover').fadeOut();
});

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
//清空输入框，再次fouce时，不清空；
$('#bask-textarea,#mood-textarea,.video_url').click(function(){
  if($(this).data('text_ck')!==1){
  $(this).val('');
  $(this).data('text_ck',1);
}
});
   $('.active').find('.m-sns-write-mood-pointer-box').show();
   $('#'+$('.active').attr('toggle')).show();
   $('.tab-top').click(function(){
       $('.checked-image').data('ck',$(this).attr('toggle'));
       $('.m-sns-write-mood-pointer-box').hide();
       $('.tab-top').css({color:'#333333',fontWeight:''});
       $(this).css({color:'#fb6e52',fontWeight:'bold'});
       $(this).find('.m-sns-write-mood-pointer-box').show();
       $('.m-sns-write-mood-tab-panel').find('#bask,#mood').hide();
       $('#'+$(this).attr('toggle')).show().find('textarea').focus();
       self_tab = $(this);
   }).hover(function(){$('.m-sns-write-mood-pointer-box').hide();$(this).find('.m-sns-write-mood-pointer-box').show();$('.tab-top').css('color','#333333');$(this).css('color','#fb6e52');}
           ,function(){$('.m-sns-write-mood-pointer-box').hide();$('.tab-top').css('color','#333333'); if(self_tab){self_tab.css('color','#fb6e52'); self_tab.find('.m-sns-write-mood-pointer-box').show();}});
   //字符计算
   $('#bask,#mood').find('textarea').keydown(function(){
      var textLength = $(this).val().length;
      $('.text-length').find('span').html(140-textLength); 
      if((140-textLength)<=0){
          $(this).disabled=true;
      }
   }).focusin(function(){
      var textLength = $(this).val().length;
      $('.text-length').find('span').html(140-textLength);
   });
   //emoji
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
/*var emoji = {1:"01",2:"02",3:"03",4:"04",5:"05",6:"06",7:"07",8:"08",9:"09",10:"10",11:"11",12:"12",
13:"13",14:"14",15:"15",16:"16",17:"17",18:"18",19:"19",20:"20",21:"21",22:"22",23:"23",24:"24",
25:"25",26:"26",27:"27",28:"28",29:"29",30:"30",31:"31",32:"32",33:"33",34:"34",35:"35",36:"36",
37:"37",38:"38",39:"39",40:"40",41:"41",42:"42",43:"43",44:"44",45:"45",46:"46",47:"47",48:"48",
49:"49",50:"50",51:"51",52:"52",53:"53",54:"54",55:"55",56:"56",57:"57",58:"58",59:"59",60:"60",
61:"61",62:"62",63:"63",64:"64",65:"65",66:"66",67:"67",68:"68",69:"69",70:"70",71:"71",72:"72",73:"73",74:"74",
75:"75",76:"76",77:"77",78:"78",79:"79",80:"80",81:"81",82:"82",83:"83",84:"84",85:"85",86:"86",87:"87",
88:"88",89:"89",90:"90",91:"91",92:"92",93:"93",94:"94",95:"95",96:"96",97:"97",98:"98",99:"99",100:"100",
101:"101",102:"102",103:"103",104:"104",105:"105",106:"106",107:"107",108:"108",109:"109",110:"110"}*/
$('#bask-textarea').val('每个商品前10位成功晒单者且图片数在3张及以上的客户可获得10积分奖励！');
$('#mood-textarea').val('有什么稀奇，好玩，新新的事分享给大家？');
$('.video_url').val('支持各大主流视频网站');
//对ubb字符转换为表情图片
/*var comment_text = $('.emoji-ubb').html();
$.each(emoji_strtoimg,function(i,n){
    comment_text=comment_text.replace(comment_text.match('\\['+i+'\]'),'<img src="images/'+n+'"/>');
});

$('.emoji-ubb').html(comment_text);*/
//ubb转换结束
//$('.emojitest').html($('.emojitest').html().match('\\[微笑\]'));
var images='<div style="height:24px;">常用表情</div>';
$.each(emoji,function(i,n){
    images+='<div class="checked-image" style="width:31px;height:30px;float:left;over-flower:none"><img id='+i+'  alt=['+n.a+'] src="'+n.i+'"/></div>';
});
$('.emoji-image').html(images);
$('.checked-image').click(function(){
    if($(this).data('ck')==='mood'){
    $('#mood-textarea').insertAtCaret($(this).find('img').attr('alt'));
}else{
    $('#bask-textarea').insertAtCaret($(this).find('img').attr('alt'));
}
});
//
 
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
        //$('.video-box,.image-box,.emoji-box').hide();
        if($('.'+$(this).attr('toggle')).is(':visible')){
            $('.'+$(this).attr('toggle')).hide();
        }else{;
            $('.video-box,.image-box,.emoji-box').hide();
            $('.'+$(this).attr('toggle')).show();
        }
        //if(ck ===1){$(this).find('.'+$(this).attr('toggle')).show();ck-=1;}else{$(this).find('.'+$(this).attr('toggle')).hide();ck+=1;}
    });
    $('.u-close').click(function(){
        $('.'+$(this).attr('hide')).hide();
    });
  //image
$('.add_image').eq(2).css({marginRight:'0px'});
$('.add_image').eq(5).css({marginRight:'0px'});
$(".male").change(function(){
var strSrc = $(this).val();  
img = new Image();  
img.src = getFullPath(strSrc);  
//验证上传文件格式是否正确  
var pos = strSrc.lastIndexOf(".");  
var lastname = strSrc.substring(pos, strSrc.length)  
/*if (lastname.toLowerCase() != ".jpg"||lastname.toLowerCase() != ".png") {  
    alert("您上传的文件类型为" + lastname + "，图片必须为 JPG 类型");  
    return false;  
} */ 
//验证上传文件宽高比例  

if (img.height / img.width > 1.5 || img.height / img.width < 1.25) {  
    alert("您上传的图片比例超出范围，宽高比应介于1.25-1.5");  
    return;  
}  
//验证上传文件是否超出了大小  
if (img.fileSize / 1024 > 150) {  
    alert("您上传的文件大小超出了150K限制！");  
    return false;  
} 
$(this).prev().find('img').attr("src",getFullPath(this));
$('.add_image').eq(($(".male").index(this)+1)).show();
/*
$('.add_image').eq($('.add_image').length-1).after('\
<div class="add_image image_'+($(".add_image").length+1)+'">\n\
<div class="u-image-del" id="image_'+($(".add_image").length+1)+'"></div>\n\
<label class="up-file" for="male_'+($(".add_image").length+1)+'">\n\
<img src="images/add_image.png"/></label><input class="male"  hidden="hidden" type="file"  id="male_'+($(".add_image").length+1)+'" style="display: none"/>\n\
</div>');*/
});
$('.u-image-del').click(function(){
  $(this).next().find('img').attr("src","images/add_image.png");
  $(this).nextAll('input').val(''); 
  //$('.'+$(this).attr('id')).hide(); 
});
$('.add_three_img').click(function(){
   if($('.three_img_box').is(':visible')){
              $('.three_img_box').hide();
          }else{
              $('.three_img_box').show();
          }
});
$('.video_url').click(function(){$(this).css('color','#717171')});
//轮播
var ck=0;
var view_amout = parseInt($('.view_banner').css('width')); //可见区域  
var all_amout = parseInt($('.all_banner').css('width'));  //所有banner的宽度之和     
var ck_length = (all_amout-view_amout)/640;
var amout_width = all_amout;
var time = setInterval('$.banner()',3000);
$.extend({banner:function(){
    if(amout_width>view_amout && ck<=ck_length){
        amout_width-=ck*640;
        ck++;
        if(ck<ck_length){
            $('.all_banner').animate({left:"-=640px"});
        }
    }
    if(ck>ck_length){
        $('.all_banner').animate({left:"+="+(640*(ck-1))+"px"});
        amout_width = parseInt($('.all_banner').css('width'));
        ck=0;
    }  
}});
//轮播结束
//查看对话
$('.view-comment').click(function(){
var width=$(window).width();
var height=$(window).height();

   $('.view-div-bg').fadeIn().css({width:width,height:height});
   $('.view-div-box').fadeIn();
   $('.view-div-box').css({left:(width-555)/2+'px',top:'320px'});
});
$('.view-div-close').click(function(){
   $('.view-div-bg').fadeOut();
   $('.view-div-box').fadeOut();
});
//查看原图
$('.viewres').click(function(){
var width=$(window).width();
var height=$(window).height();
   $('.view-div-bg').fadeIn().css({width:width,height:height});
   $('.view-div-bg').fadeIn();
   $('.view-image-div-box').fadeIn();
   $('.view-image-div-box').css({left:(width-516)/2+'px',top:'160px'});
if($(this).data('img_src')){
   $('.view-image-div-box').find('img').attr({src:$(this).data('img_src')}); 
}else{
    $('.view-image-div-box').find('img').attr({src:$(this).attr('img_src')});
}
});
$('.view-image-div-close').click(function(){
   $('.view-div-bg').fadeOut();
   $('.view-image-div-box').fadeOut();
});
//查看对话结束
for(var i=0;i<$('.tarento_top').length;i++){
    $('.tarento_top').eq(i).css({background:"url('catalog/view/theme/cnstorm/images/social/top_"+(i+1)+".jpg') no-repeat"});
}
//回复
$('.reply').click(function(){
    var text = '<div class="r_text" style="display:none"><div class="f-clear"></div>'+
                        '<div class="comment_replay_box">'+
                            '<div class="comment_replay_pointer"></div>'+
                            '<div class="comment_replay_content" contentEditable=true></div>'+
                                  '<div class="comment_emoji_sub">'+
                                    '<div class="m-sns-write-mood-u-emoji m-sns-write-mood-show-panel" toggle="emoji-box"> </div>'+
                                    '<div class="emoji-box">'+
                                        '<div class="m-sns-write-mood-pointer emoji-pointer"></div>'+
                                        '<div class="u-close" hide="emoji-box"></div>'+
                                        '<div class="emoji-image"></div>'+
                                    '</div>'+
                                '</div>'+
                            '<div class="comment_sub"><span class="tot">140字</span><span class="sub">发布</span></div>'+
                        '</div></div>';
    if($('.r_text').length<1){
    $(this).parent('.bask_rec_com_share').after(text);
    $('.r_text').fadeIn(1000);
    }else{
        $('.r_text').remove();
    }
});
$('.comt').click(function(){
    var text = '<div class="r_text" style="display:none"><div class="f-clear"></div>'+
                        '<div class="f-clear"></div>'+
                    '<div class="comment_child">'+
                        '<div class="comment_pointer"></div>'+
                        '<div class="comment_head"><img src="catalog/view/theme/cnstorm/images/social/bask_imags_heade.jpg"/></div>'+
                        '<div class="comment_content">'+
                            '<div class="comment_pointer_h"></div>'+
                            '<div style="float:left;height: 110px;">'+
                                '<div class="comment_text" contentEditable=true></div>'+
                                '<div class="comment_emoji_sub">'+
                                    '<div class="m-sns-write-mood-u-emoji m-sns-write-mood-show-panel" toggle="emoji-box"> </div>'+
                                    '<div class="emoji-box">'+
                                        '<div class="m-sns-write-mood-pointer emoji-pointer"></div>'+
                                        '<div class="u-close" hide="emoji-box"></div>'+
                                        '<div class="emoji-image"></div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="comment_sub"><span class="tot">140字</span><span class="sub">发布</span></div>'+
                            '</div>'+

                        '</div>'+
                    '</div></div>';
    if($('.r_text').length<1){
    $(this).parent('.bask_rec_com_share').after(text);
    $('.r_text').fadeIn(1000);
    }else{
        $('.r_text').remove();
    }
});

//图片展开
$('.view-image-list').find('img').click(function(){
    $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/social/bask_up.jpg') no-repeat"});
    $(this).parent('.view-image-list').slideUp();
    $(this).parent('.view-image-list').next().slideDown();
})
$('.updown').hover(function(){
    $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/social/bask_down.jpg') no-repeat"});
},function(){
    $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/social/bask_up.jpg') no-repeat"});
});
$('.updown').click(function(){
   $('.up_down').css({background:"url('catalog/view/theme/cnstorm/images/social/bask_down.jpg') no-repeat"});
   $(this).parents('.bask_image_box').slideUp();
   $(this).parents('.bask_image_box').prev().slideDown();
});
var self;
$('.bask_iamge_sm_ul').find('span').mouseover(function(){
    $(this).hide();
    self = $(this);
$('.bask_iamge_sm_ul').find('img').mouseleave(function(){
       //self.hide();
       $(this).next().fadeIn();
   })
});
$('.bask_iamge_sm_ul').find('img').click(function(){
   // for(var i=0;i<$(this).parents('.bask_iamge_sm_ul').find('img').length;i++){
        //$(this).parents('.bask_iamge_sm_ul').find('img').eq(i).next().remove();
   // }
    //$('.bask_iamge_sm_ul').find('li').append('<span></span>');
    //$(this).next().remove();
    $(this).parents('.bask_iamge_sm').prev().find('img').attr('src',$(this).attr('src'));//bask_image_box_op
    $(this).parents('.bask_iamge_sm').prevAll('.bask_image_box_op').find('.viewres').data('img_src',$(this).attr('src'));
});
//图片展开结束
});
function getFullPath(obj) {    //得到图片的完整路径 
        if (obj) {  
            //ie  
            if (window.navigator.userAgent.indexOf("MSIE") >= 1) { 
             if(document.selection){
                return obj.value;
             }
            }  
            //firefox  
            else if (window.navigator.userAgent.indexOf("Firefox") >= 1) {  
                if (obj.files) {  
                    return window.URL.createObjectURL(obj.files[0]);  
                }  
            }
            if (obj.files) {  
                    return window.URL.createObjectURL(obj.files[0]);  
            }
        }
        
}

function deliver() {

	alert("kenne");
	$("#message_deliver").submit();
	//var message_text = $("#bask-textarea").val();
	
	//alert(message_text);


}

