/**************************************/
/*@author:  Kenne Wei<wk@cnstorm.com> */
/*@date:     2014.6.21               */
/**************************************/
//用户中心部分的js代码

//账户管理->客户咨询
//实现按咨询问题分类显示
$(function() {
	
	$('select[name=\'question_type\']').bind('change', function() {
		var type = $(this).val();
		$.ajax({
				type: "POST",
				url: 'index.php?route=account/advisory/filter_type',
				dataType: "json",
				data: "type=" + type,
				timeout: 25000,
				success: function(json){
					window.location = json;
				},
				error: function(json){
					alert(json);
				}
		 })
	});


});
