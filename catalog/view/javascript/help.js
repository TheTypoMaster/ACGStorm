var help_common = {
	menu_click : function(){//左侧菜单点击效果
		$(".hcl_menulists").find("li").click(function() {
			$(this).addClass("curr");
			$(".hcl_menulists").find("li").not(this).removeClass("curr");
		});
	},
	boxTitle_click : function(){//点击问题的分类标题，显示下面对应的问题
		$(".boxTitle").click(function() {
			var self = this,
				$txt = $(this).next(".faqAnswer"),
				isVisible = $txt.is(":visible");
			$(this).find("label").toggleClass("bt_tips");
			$(this).closest(".faqAnswerBox").siblings(".faqAnswerBox").find(".boxTitle label").addClass("bt_tips");
			$(this).closest(".faqAnswerBox").siblings(".faqAnswerBox").find(".faqAnswer:visible").each(function() {
				$(this).slideUp("fast");
			});
			$txt.slideToggle("fast");
			$(".p-answer").hide();
       });
	},
	question_click : function(){//点击问题，显示答案
		$(".p-question").find("a").click(function() {
			var self = this,
				$txt = $(this).closest(".p-question").next(".p-answer"),
				isVisible = $txt.is(":visible");
			$(this).closest(".p-question").siblings(".p-question").next(".p-answer:visible").each(function() {
				$(this).slideUp("fast");
			});
			$txt.slideToggle("fast");
		});
	},
	problem_questions_click : function(){//点击上面的问题，下面的答案内容显示
		$(".problem_questions").find("p").click(function() {
			var index1 = $(this).closest(".problem_contents").index();
			var index2 = $(this).closest(".problem_questions").find("p").index($(this));
			var $faqAnswerBox = $(".faqAnswerBox").eq(index1),
				$item = $faqAnswerBox.find(".p-question").eq(index2);
			$faqAnswerBox.find(".faqAnswer:hidden").prev(".boxTitle").click();
			$item.find("a").click();
			$.when($(".p-answer,.faqAnswer").promise()).done(function() {
				$(window).scrollTop($item.offset().top - 200);
			});
		});
	},
	backtotop_click : function(){//点击答案里的回顶部
		$(".backtotop").click(function () {
			$(this).closest(".p-answer").prev(".p-question").click();
			$(this).closest(".faqAnswer").prev(".boxTitle").click();
		   $('html,body').animate({ scrollTop: 0 }, 400);
		});
	},
	quick_arrow_click : function(){
		$(".quick-arrow").click(function() {
			var self = this,
				$txt = $(this).parent().next(),
				isVisible = $txt.is(":visible");
			$(this).find("label").toggleClass("bt_tips");
			$(this).closest(".txtTitle").siblings(".txtTitle").find(".quick-arrow label").addClass("bt_tips");
			$(this).closest(".quickgudie-txt").find(".txtContent:visible").each(function() {
				$(this).prev().find("a").removeClass("active");
				$(this).slideUp("fast");
			});
			if (!isVisible) {
				$txt.slideToggle("fast", function() {
					$(self).toggleClass("active");
				});
			}
		});
		$(".quick-arrow").eq(0).trigger("click");
	},
	init :function(){//初始化
		help_common.menu_click();
		help_common.boxTitle_click();
		help_common.question_click();
		help_common.problem_questions_click();
		help_common.backtotop_click();
		help_common.quick_arrow_click();
	}
};

$(function(){
	help_common.init();
});