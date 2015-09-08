var dateselect = {
	begin_date_select : function(){
		$("#txtBeginDate").click(function(){
			var ths = this;
			calendar.show({
				id: this, ok: function () {
					//这里是回调函数
				}
			});
		});
	},
	end_date_select : function(){
		$("#txtEndDate").click(function(){
			var ths = this;
			calendar.show({
				id: this, ok: function () {
					//这里是回调函数
				}
			});
		});
	},
	init : function(){
		dateselect.begin_date_select();
		dateselect.end_date_select();
	}
	
};

$(function(){
	dateselect.init();
});