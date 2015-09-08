$(function() {
	//北京时间模块
	var btime = new Date(parseInt($('#Beijing_Time').val()));
	var year = btime.getFullYear(); //年-4位表示 如：2012 
	var month = btime.getMonth() + 1; //月 0~11 所以要加 1才正确 
	var day = btime.getDate(); //日 1~31 
	var hour = btime.getHours(); //小时0~23 
	setInterval(function() {
		btime.setSeconds(btime.getSeconds() + 1);
		var datetime = year + "年" + month + "月" + day + "日" + " " + hour + ":" + (btime.getMinutes() < 10 ? '0': '') + btime.getMinutes() + ":" + (btime.getSeconds() < 10 ? '0': '') + btime.getSeconds(); //拼接一起,当然可以直接在这里修改显示格式 
		//clock.innerHTML = "<font>北京时间 : " + datetime + "</font>"; //以html文本形式显示在页面上 
	},
	1000);
	//微信二维码
	$('.wechat-share').hover(function() {
		$(this).children('span').fadeIn();
	},
	function() {
		$(this).children('span').fadeOut();
	});

        //绑定回到顶部按钮的点击事件
        $('.g_h_top').click(function(){
            //动画效果，平滑滚动回到顶部
            $('html,body').animate({scrollTop:'0px'},1000);
            //不需要动画则直接
            //$(document).scrollTop();
        });
});