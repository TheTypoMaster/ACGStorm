function calendarclick(uname_id,uname){
	$(".singer_r_img").addClass("current");
	/* 日历模块 */
	$('#calendar').eCalendar({uname_id:uname_id,uname:uname});
        setTimeout(function() {
		$('.calendar').show();
	    }, 500);
            $('.weiduduan').hover(function() {
		setTimeout(function() {
			$('.calendar').show();
		}, 500);
	     }, function() {
		setTimeout(function() {
			$('.calendar').fadeOut(500);
		}, 500);
	    });
}