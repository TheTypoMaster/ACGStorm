$(function(){
    //banner中大图右移出，并渐变
    $('.banner_phone').css({left:'-500px',opacity:0});
    $('.banner_phone').animate({left:'+=500px',opacity:1},2000);
    //QR code下滑效果
    $('.QR_code_down').css({top:'-185px'});
    $('.QR_code_down').delay(2000).animate({top:'+=191px'},2000);
    //$('.app_img_1_cover').find('img').animate({width:"200px",height:'200px'},2000);
    var img_1_offset =$('#ranks').offset();
    var img_2_offset = $('.app_img_2').offset();
    var img_3_offset = $('.app_img_3_cover').offset();
    var img_4_offset = $('.app_img_4_cover').offset();
    //alert(img_3_offset.top);
    
    //alert($('.main').offset().top );
    $(window).scroll(function(){
        var img_2_o_t = img_2_offset.top;
        var img_3_o_t = img_3_offset.top;
        var img_4_o_t = img_4_offset.top;
        var w_t = $(window).scrollTop();
        var w_h = $(window).height();
        if((img_1_offset.top-$(window).scrollTop()-$(window).height())<=((img_1_offset.top-$(window).height())-100)){
            $('#ranks').addClass('animation');
        }else{
            $('#ranks').removeClass('animation');
        }
        if((img_3_o_t-w_t-w_h)<-600){
            $('.app_img_3_up').animate({top:'0px'},3000);
        }else{
            $('.app_img_3_up').animate({top:'200px'},3000);
            $('.app_img_3_up').stop();
            //$('.app_img_3_up').css({top:'200px'});
        }
        if((img_2_o_t-w_t-w_h)<-700){
            $('.app_img_2_cover').fadeIn(1500);
        }else{
            $('.app_img_2_cover').fadeOut(1500);
        }
    });
var i_c_g=1;
 setInterval('$.img_c_tggl()',3000);;
$.extend({img_c_tggl:function(){
        //alert(i_c_g);
        if(i_c_g<4){
            $('.app_img_4_cover_'+i_c_g).fadeIn(2000);
        }else{
            i_c_g=0;
            for(var i=1;i<4;i++){
                $('.app_img_4_cover_'+i).fadeOut();
            }
            
        }
        i_c_g++;
        
}});
});


