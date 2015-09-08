//Time:2014-05-24
$(function() {

    //大图轮播
    focus();

    function focus() {
        var imgLength = $(".img_tab li").length;
        var imgWidth = $(".img_tab li").width();
        var timer = null;
        var index = 0;
        star();
        function star()
        {
            timer = setInterval(function() {
                index++;
                if (index > imgLength - 1)
                {
                    index = 0;
                }
                move();
            }, 3000);
        }
        $(".go_left").click(function() {
            index--;
            if (index < 0)
            {
                index = imgLength - 1;
            }
            move();
        });
        $(".go_right").click(function() {
            index++;
            if (index > imgLength - 1)
            {
                index = 0;
            }
            move();
        });
        function move() {
            $(".img_tab").animate({left: -imgWidth * index + "px"}, 300);
            $(".img_num li").eq(index).addClass('activeNS').siblings().removeClass("activeNS");
        }
        //鼠标移至小图上的效果
        $('.img_num li').mouseover(function() {
            clearInterval(timer);
            index = $('.img_num li').index($(this));
            $(this).addClass('activeNS').siblings().removeClass("activeNS");
            $(".img_tab").animate({left: -imgWidth * index + "px"}, 300);
        });
        //鼠标移上时暂停
        $(".banner_tit_left").hover(function() {
            clearInterval(timer);
        }, function() {
            star();
        });
    }
    //优惠券
    $('.coupon_list li').hover(function() {
        $(this).addClass('coupon_hover').siblings().removeClass('coupon_hover');

    });


    //用户中心搜索框
     $('.dl_h_input .searchbox_a').click(function() {
        $(this).parent().hide();
        $(this).parent().next().show();
       
    });
     $('.dl_t_input .searchbox_a').click(function() {
        $(this).parent().hide();
        $(this).parent().prev().show();
       
    });




    //国际运费


    $('.city_tab li').hover(function() {
        $(".city_tab li").each(function() {
            if ($(this).is(".cur")) 
                $(this).removeClass("cur");
        });
        $(this).addClass('cur');
        $('.dc_lists').eq($(this).index()).show().siblings('.dc_lists').hide();
    });

    $('.rest_city').hover(function() {

    }, function() {
        $('.country_list').hide();
    }).click(function() {
        $('.country_list').show();
    });


    //首页底部关注我们
    $('.wechat').hover(function(){ 
         $(this).children('span').fadeIn();
    },function(){
        $(this).children('span').fadeOut();
    });
    //选项卡
    $('span.hot_tab a').hover(function() {
        //console.log($(this).index());
        $('.hot_list').eq($(this).index()).show().siblings('.hot_list').hide();
        $(this).attr('class', 'current').siblings('a').attr('class', 'normal');
    });

    //收货地址重要地址
    $('.all_dingdan .table_addr .addr_list:eq(0)').addClass('useful_addr');



    
    //大家最爱页面工具栏点击事件
    $(".shop_tools li").each(function() {
        $(this).hover(function() {
            $(this).addClass('after_click').siblings().removeClass("after_click");
        });
    });

    //帮助中心
    $(".help_commen .hc_header").click(function() {
        $('.hc_list li a').removeClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").show();
        //$(this).css('color','#fb6e52');
    });

    $(".help_commen .hc_list:eq(0) li:eq(1) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#psfs:eq(0)").show();
        $(".help_commen .hc_header").css('color','#444');
    });

    $(".help_commen .hc_list:eq(0) li:eq(2) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#psfs:eq(1)").show();
        $(".help_commen .hc_header").css('color','#444');
    });

    $(".help_commen .hc_list:eq(1) li:eq(1) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#zffs:eq(0)").show();
        $(".help_commen .hc_header").css('color','#444');
    });

    $(".help_commen .hc_list:eq(1) li:eq(2) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#zffs:eq(1)").show();
        $(".help_commen .hc_header").css('color','#444');
    });


    $(".help_commen .hc_list:eq(2) li:eq(1) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#shfw:eq(0)").show();
        $(".help_commen .hc_header").css('color','#444');
    });

    $(".help_commen .hc_list:eq(2) li:eq(2) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#shfw:eq(1)").show();
        $(".help_commen .hc_header").css('color','#444');
    });

    $(".help_commen .hc_list:eq(3) li:eq(1) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#bzxx:eq(0)").show();
        $(".help_commen .hc_header").css('color','#444');
    });

    $(".help_commen .hc_list:eq(3) li:eq(2) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#bzxx:eq(1)").show();
        $(".help_commen .hc_header").css('color','#444');
    });
    $(".help_commen .hc_list:eq(3) li:eq(3) a").click(function() {
        $('.hc_list li a').removeClass('current');
        $(this).addClass('current');
        $(".help_cont div.setting-content").hide();
        $(".help_cont div#zxsy").hide();
        $(".help_cont div#lxkf").show();
        $(".help_commen .hc_header").css('color','#444');
    });


    //首页导航
    $('.nav ul li').click(function() {
        $(".nav ul li").each(function() {
            if ($(this).children('a').is(".current")) 
                $(this).children('a').removeClass("current");
        });
        $(this).children('a').addClass('current');
    });


    //购物车流程选项卡
    $('.zhifu_list li').click(function() {
        $(".zhifu_list li").each(function() {
            if ($(this).children('a').is(".on"))
                $(this).children('a').removeClass("on");
        });
        $('.paylist').eq($(this).index()).show().siblings('.paylist').hide();
        $(this).children('a').addClass('on');
    });

    //新手教学演示选项卡
    $('.newbie_list li').hover(function() {
        $(this).addClass('hoverp').siblings().removeClass('hoverp');
    });

    //商品分类
    $('.shopping_types').find('div.goods').eq(4).addClass('border_none');
    $('.shopping_bg .shopping_types').find('div.goods').eq(4).addClass('classify');
    $('.questions dd.get_more').click(function() {
        $(this).hide();
        $(this).prev().css('max-height', '670px');
    });

    //用户个人中心选项卡
    $('.gw_intro_list li').click(function() {
        $(".gw_intro_list li").each(function() {
            if ($(this).children('a').is(".on"))
                $(this).children('a').removeClass("on");
        });
        $('.cloth_list').eq($(this).index()).show().siblings('.cloth_list').hide();
        $(this).children('a').addClass('on');
    });

     //国际运费选项卡
    $('.dc_tab .all_company li.cl_li').hover(function() {
        $(".dc_tab .all_company li.cl_li").each(function() {
            if ($(this).children('span').is(".on"))
                $(this).children('span').removeClass("on");
        });
        $('.dc_tab .company_details').eq($(this).index()).show().siblings('.dc_tab .company_details').hide();
        $(this).children('span').addClass('on');
    });
    $('.tw_tab .all_company li').hover(function() {
        $(".tw_tab .all_company li").each(function() {
            if ($(this).children('span').is(".on"))
                $(this).children('span').removeClass("on");
        });
        $('.tw_tab .company_details').eq($(this).index()).show().siblings('.tw_tab .company_details').hide();
        $(this).children('span').addClass('on');
    });

    //常用工具选项卡
    $('.all_tools li').click(function() {
        $(".all_tools li").each(function() {
            if ($(this).children('a').is(".on"))
                $(this).children('a').removeClass("on");
        });
        $('.tools_cont').eq($(this).index()).show().siblings('.tools_cont').hide();
        $(this).children('a').addClass('on');
    });

    //购物网站导航选项卡
    $('.websites_tap li').click(function() {
        $(".websites_tap li").each(function() {
            if ($(this).is(".on"))
                $(this).removeClass("on");
        });
        $('.cur_shop').eq($(this).index()).show().siblings('.cur_shop').hide();
        $(this).addClass('on');
    });
    //帮助中心首页
    $(".find_us li").each(function(){
		$(this).hover(function(){
			$(this).addClass('moveon').siblings().removeClass("moveon");
		});
    });
    //帮助中心
    $('.about_us li').click(function() {
        $(".about_us li").each(function() {
            if ($(this).children('a').is(".now"))
                $(this).children('a').removeClass("now");
        });
        $(this).children('a').addClass('now');
    });

    //费用估算
    $(".pickup li").each(function() {
        $(this).click(function() {
            $('#etype').val($(this).text());
            $(this).addClass('bc_change').siblings().removeClass("bc_change");
        });
    });

    //用户个人中心代购订单选项卡
    $('.dingdan_list li').click(function() {
        $(".dingdan_list li").each(function() {
            if ($(this).children('a').is(".on"))
                $(this).children('a').removeClass("on");
        });
        $('.dg_dingdan,.dg_package_list,.save_box,.basic_informs,.wm_tables').eq($(this).index()).show().siblings('.dg_dingdan,.dg_package_list,.save_box,.basic_informs,.wm_tables').hide();
        $(this).children('a').addClass('on');
    });

    $('.login_btn input').hover(function() {
        $(this).css('background-color', '#fb6e52');
    },function() {
		$(this).css('background-color', '#f34d2c');
	});
    $('.cloth_list li').hover(function() {
        $(this).css('border-color', '#fb6e52');
    },function() {
		$(this).css('border-color', '#f0f0f0');
	});

    $('.btn a.add').hover(function() {
        $(this).removeClass('add').addClass('btn_hover');
    },function() {
		$(this).removeClass('btn_hover').addClass("add");
	});

    $('.btn a.save').hover(function() {
        $(this).removeClass('save').addClass('btn_hovert');
    },function() {
		$(this).removeClass('btn_hovert').addClass("save");
	});
    
	$('.shop_tools li').hover(function() {
		$(this).addClass('after_click');
	},function() {
		$(this).removeClass('after_click');
	});
     


    $('#pwd_form .pwd_btn').hover(function() {
        $(this).removeClass('pwd_btn').addClass('pwd_btn_hover');
    },function() {
		$(this).removeClass('pwd_btn_hover').addClass("pwd_btn");
	});
    $('#reg .reg_btn').hover(function() {
        $(this).removeClass('reg_btn').addClass('reg_btn_hover');
    },function() {
		$(this).removeClass('reg_btn_hover').addClass("reg_btn");
	});

    $('.goods_sort_list li').hover(function() {
        $(this).addClass('current');
    },function() {
		$(this).removeClass('current');
	});

    //商品详细页点击选择颜色或尺寸
    $(".color_list li").each(function() {
        $(this).click(function() {
            if ($(this).children().hasClass("cannot_choose")) {
                return false;
            } else {
                $(this).addClass('after_choose').siblings().removeClass("after_choose");
            }
        });
    });
    $(".size_list li").each(function() {
        $(this).click(function() {
            if ($(this).children().hasClass("cannot_choose")) {
                return false;
            } else {
                $(this).addClass('after_choose').siblings().removeClass("after_choose");
            }
        });
    });

    $(".process_list li").each(function() {
        $(this).hover(function() {
            $(this).addClass('border_thick').siblings().removeClass("border_thick");
        });
    });

    //商品详细页小图片Hover选中效果
    $(".item_pic_small a").each(function() {
        $(this).hover(function() {
            $(this).addClass('cur_border').siblings().removeClass("cur_border");
        });
    });

    /* checkbox全选 */
    $("#chkbox,#chkbx").click(function() {
        $("input[name='items']").each(function() {
            if (this.checked) {
                this.checked = false;
            } else {
                this.checked = true;
            }
        });
    });

    //商品详细页选择商品数量new
    $(".num-pallets-input").each(function(i) {
        var t = $(".num-pallets-input");
        $(".click_add").eq(i).click(function() {
            var num = t.eq(i).val();
            if (num < 1000) {
                t.eq(i).val(parseInt(t.eq(i).val()) + 1);
            }
        });
        $(".click_sub").eq(i).click(function() {
            var num = t.eq(i).val();
            if (num > 1) {
                t.eq(i).val(parseInt(t.eq(i).val()) - 1);
            }
        });
        //keyup
        $('.num-pallets-input').eq(i).keyup(function(e) {
            if ($(this).val() == "") {
                $(this).val(1);
            }
            if (e.which < 48 || e.which > 57) {
                $(this).val(function(index, value) {
                    var len = value.length;
                    return value.replace(/[^0-9]/ig, ""); //剔除非数字
                });
            }
            if ($(this).val() > 500) {
                $(this).val(500);
            }
            var value = parseInt($(this).val())
            $(this).val(value);
        });
    });

    //cart总购买数
    function setAmount() {
        var prodTotal = 0;
        $(".num-pallets-input").each(function() {
            var valString = $(this).val() || 0;
            prodTotal += Number(valString);
        });
        $("#product_all").text(parseInt(prodTotal));
    }

    //cart计算总价
    function count() {
        var prodSubTotal = 0;
        $(".count_mon").each(function() {
            var valString = $(this).text() || 0;
            prodSubTotal += Number(valString);
        });
        $("#allPr").text((prodSubTotal).toFixed(2));
        $("#total_amount").attr("value", $("#allPr").text());

    };
    //postAge
    $(".shops_s").each(function(e) {
        var xarry = new Array();
        $(".shops_s").eq(e).find(".postAge").each(function(i) {
            xarry.push(parseInt($(this).text()))
        })
        $(".postAge_s").eq(e).text(parseInt(Math.max.apply(Math, xarry)).toFixed(2));
        //alert(Math.max.apply(Math,xarry));
    });

    var postAge_all = 0;
    $(".postAge_s").each(function() {
        var valString = $(this).text() || 0;
        postAge_all += parseInt(valString);
    });
    $(".postAge_all").text(parseInt(postAge_all).toFixed(2));
    $("#total_freight").attr("value", $(".postAge_all").text());

    //用户评论轮播
    turnOver();
    function turnOver() {
        var imgL = $(".comm_tab_list li").length;
        var imgW = $(".comm_tab_list li").width();
        var timer = null;
        var index = 0;

        action();

        function action() {
            timer = setInterval(function() {
                index++;
                if (index > imgL - 1) {
                    index = 0;
                }
                autoPlay();
            },
                    3000);
        }
        $(".last_user").click(function() {
            index--;
            if (index < 0) {
                index = imgL - 1;
            }
            autoPlay();
        });
        $(".next_user").click(function() {
            index++;
            if (index > imgL - 1) {
                index = 0;
            }
            autoPlay();
        });
        function autoPlay() {
            $(".comm_tab_list").animate({
                left: -imgW * index + "px"
            },
            300);
        }
        $(".hanging-around-wrap .hanging-around-cot").hover(function() {
            clearInterval(timer);
        },function() {
			action();
		});
    }

    /* textarea鼠标获取焦点，且文字颜色改变 */
    $('.beizhu textarea,.feedback textarea,.search_box,#beizhu_in,#login .login_input .input,.rb_textarea').bind({
        focus: function() {
            if (this.value == this.defaultValue) {
                this.value = "";
            }
            $(this).css('color', '#677374');
        },
        blur: function() {
            if (this.value == "") {
                this.value = this.defaultValue;
            }
            $(this).css('color', '#444');
        }
    });

    //注册登录输入框
    $('#reg .login_input .input').bind({
        focus: function() {
            if (this.value == this.defaultValue) {
                this.value = "";
            }
            $(this).next('span').show();
        },
        blur: function() {
            if (this.value == "") {
                this.value = this.defaultValue;
            }
            $(this).next('span').hide();
        }
    });

    //顶部缓冲加载
    $('<div id="progress"><span></span></div>').prependTo('.topbar');
    $({
        property: 0
    }).animate({
        property: 100
    },
    {
        duration: 3000,
        step: function() {
            var percentage = Math.round(this.property);
            $('#progress').css('width', percentage + "%");
            if (percentage == 100) {
                $("#progress").addClass("done").remove();
            }
        }
    });
    var fnHover = function(sl1, sl2, cssname) {
        $(sl1).hover(function() {
            if (cssname) {
                $(this).addClass(cssname);
            }
            ;
            $(this).find(sl2).stop(!0, !0).fadeIn();
        },
                function() {
                    if (cssname) {
                        $(this).removeClass(cssname);
                    }
                    ;
                    $(this).find(sl2).stop(!0, !0).fadeOut();
                });
    };

    //常用工具
    fnHover('.tools', '.sublink', 'toolsOn');
    
    // 订购
    fnHover('.barCart', '.cartBox');
    fnHover('.barCart', '.gwcBox');
    //banner
    var idmac = $('.idmac'),
            adTxt = $('.bannerText'),
            adTxtH2 = adTxt.find('h1'),
            adTxtH3 = adTxt.find('h3'),
            dTxtP = adTxt.find('p'),
            atMore = $('.atMore'),
            timers = null;
    idmac.animate({
        right: '73px',
        opacity: '1'
    },
    "slow");
    timers = function() {
        adTxtH2.animate({
            top: '92px',
            opacity: '1'
        },
        "slow")
    };
    setTimeout(timers, 300);
    timers = function() {
        adTxtH3.animate({
            top: '157px',
            opacity: '1'
        },
        "fast")
    };
    setTimeout(timers, 600);
    timers = function() {
        atMore.animate({
            left: '98px',
            opacity: '1'
        },
        "fast")
    };
    setTimeout(timers, 998);
    timers = function() {
        atMore.animate({
            left: '50px',
            opacity: '1'
        },
        "fast")
    };
    setTimeout(timers, 999);
    timers = function() {
        atMore.animate({
            left: '68px',
            opacity: '1'
        },
        "fast")
    };
    setTimeout(timers, 1000);
    timers = function() {
        dTxtP.each(function(e) {
            $(this).animate({
                top: 215 + (e * 3) + 'px',
                opacity: '1'
            },
            (e + 1) * 200);
        });
    };
    setTimeout(timers, 800);
    clearTimeout(timers);

    $(".shop_tools li").each(function() {
        $(this).click(function() {
            $(this).addClass('after_click').siblings().removeClass("after_click");
        });
    });

    //右侧导航栏hover事件
    $(document).on("mouseover",".btncb-1_on",function(event) {
		$(this).children("div.mouseover1121-box1").css("display","block");  
    });
    $(document).on("mouseover",".btncb-2_on",function(event) {
		$(this).children("div").css("display","block");
		$(this).children("div").animate({ right: "30px" }, 200);  
    });
    $(document).on("mouseover",".btncb-3_on",function(event) {
		$(this).children("div").css("display","block");
		$(this).children("div").animate({ right: "30px" }, 200);  
    });
    $(document).on("mouseover",".btncb-4_on",function(event) {
		$(this).children("div").css("display","block");
		$(this).children("div").animate({ right: "30px" }, 200);  
    });
    $(document).on("mouseover",".btncb-5_on",function(event) {
		$(this).children("div").css("display","block");
		$(this).children("div").animate({ right: "30px" }, 200);  
    });
    $(document).on("mouseover",".btncb-6_on",function(event) {
		$(this).children("div").css("display","block");
		$(this).children("div").animate({ right: "30px" }, 200);  
    });
    
    $(document).on("mouseover",".btncb-7_on",function(event) {
		$(this).children("div").css("display","block");
		$(this).children("div").animate({ right: "30px" }, 200);    
    });
    $(document).on("mouseover",".btncb-8_on",function(event) {
		$(this).children("div").css("display","block");
    });
    
    $(document).on("mouseout",".btncb-1_off",function(event) {
		$(this).children("div.mouseover1121-box1").css("display","none");  
    });
    $(document).on("mouseout",".btncb-2_off",function(event) {
		$(this).children("div").css("display","none");
		$(this).children("div").css("right","60px");
		$(this).children("div").stop();
    });
    $(document).on("mouseout",".btncb-3_off",function(event) {
		$(this).children("div").css("display","none");
		$(this).children("div").css("right","60px");
		$(this).children("div").stop();
    });
    $(document).on("mouseout",".btncb-4_off",function(event) {
		$(this).children("div").css("display","none");
		$(this).children("div").css("right","60px");
		$(this).children("div").stop();
    });
    $(document).on("mouseout",".btncb-5_off",function(event) {
		$(this).children("div").css("display","none");
		$(this).children("div").css("right","60px");
		$(this).children("div").stop();
    });
    $(document).on("mouseout",".btncb-6_off",function(event) {
		$(this).children("div").css("display","none");
		$(this).children("div").css("right","60px");
		$(this).children("div").stop();
    });
    $(document).on("mouseout",".btncb-7_off",function(event) {
		$(this).children("div").css("display","none");
		$(this).children("div").css("right","60px");
		$(this).children("div").stop();
    });
    $(document).on("mouseout",".btncb-8_off",function(event) {
		$(this).children("div").css("display","none");
    });

    /**********************************************************************/
    /*@author:  Kenne Wei<wk@cnstorm.com>                                 */
    /*@date:     2014.5.28                                                */
    /**********************************************************************/
    //收货地址
    $('.table_addr table').click(function() {
        $(".table_addr table").each(function() {
            if ($(this).children('table').is(".useful_addr"))
                $(this).children('table').removeClass("useful_addr");
        });
        $(this).children('table').addClass('useful_addr');
    });

    $('#search').keydown(function(e) {
        if (e.keyCode == 13) {
            $('#button-search').trigger('click');
        }
    });

    //tab
    $('.pab ul li').bind('click',
    	function() {
		$(this).siblings(".on").removeClass("on");
		$(this).addClass("on");
        $(this).children().addClass('white');
    	}
    );
    $('#button-search').bind('click',
            function() {
                //_CWiQ.push(['_trackReg', 1]);
                var search = $('#search').val();
                var href = $('.pab ul .on').attr("data-href");
		if (href){
                        //alert(href);
			url =href; 
	                url += '&search=' + encodeURIComponent(search);
	                location = url;
		}
            });

    $('#getgoodinfo').bind('click',function() {
		var search = $.trim(document.getElementById("search_url_value").value);
		$('#search').attr('value', search);
		$('#button-search').trigger('click');
	});

    $('#procurement').bind('click',function() {
		var search = $.trim(document.getElementById("procurement_url").value);
		$('#search').attr('value', search);
		$('#button-search').trigger('click');
	});
   
    $('#home-button-search').bind('click',function() {
		var search = $.trim(document.getElementById("home-search").value);
		$('#search').attr('value', search);
		$('#button-search').trigger('click');   
	});

    $('#dual11-button-search').bind('click',function() {
		var search = $.trim(document.getElementById("dual11-search").value);
		url = 'index.php?route=product/snatch';
		url += '&search=' + encodeURIComponent(search);
		location = url;
		/*
		 if (search.indexOf("www.") > 0 || search.indexOf("http://") == 0 || search.indexOf(".com") > 0 || search.indexOf("95095.com") > 0) {
			url = 'index.php?route=product/snatch';
		} else {
			url = 'index.php?route=product/search';
		}

		url += '&search=' + encodeURIComponent(search);

		location = url;
		*/
	});


    /**********************************************************************/
    /*@author:  Kenne Wei<wk@cnstorm.com>                                 */
    /*@date:    2014.6.13                                                */
    /**********************************************************************/
    //实现充值功能
    //支付宝
    $('#alipay_recharge').bind('keyup',function() {
		var alipay_value = $("#alipay_recharge").val();
		$('#alipay_reality').text((alipay_value * (1 - 0.01 - 0.001)).toFixed(2));
	});

    //paypal
    $('#paypal_recharge').bind('keyup',function() {
		var paypal_value = $("#paypal_recharge").val();
		var paypal_rate = $("#paypal_rate").text();
		$('#paypal_reality').text(((paypal_value * (1 - 0.039)) / paypal_rate).toFixed(2));
		$('#money').attr("value", ((paypal_value * (1 - 0.039)) / paypal_rate).toFixed(2));
	});

    //支付宝国际信用卡
    $('#credit_recharge').bind('keyup',function() {
		var credit_value = $("#credit_recharge").val();
		$('#credit_reality').text(((credit_value * (1 - 0.035))).toFixed(2));
	});
       
    //国内银行卡        
    $('#bank_recharge').bind('keyup',function() {
		var alipay_value = $("#bank_recharge").val();
		$('#bank_reality').text((alipay_value * (1 - 0.01 - 0.001)).toFixed(2));
   });   

    $("#type_credit_order li").each(function() {
        $(this).click(function() {
            $(this).addClass('after_choose').siblings().removeClass("after_choose");
            $("#typecredit_order").attr("value", $(this).attr("value"));
        });
    });

    $("#type_credit_waybill li").each(function() {
        $(this).click(function() {
            $(this).addClass('after_choose').siblings().removeClass("after_choose");
            $("#typecredit_waybill").attr("value", $(this).attr("value"));
        });
    });

    $("#credit_types_recharge li").each(function() {
        $(this).click(function() {
            $(this).addClass('after_choose').siblings().removeClass("after_choose");
            $("#credittype").attr("value", $(this).attr("value"));
        });
    });

    //品牌故事
    $(".contents .close").each(function() {
        $(this).click(function() {
            $(this).parents('.worker_detail').hide();
        });
    });
    //费用估算 国家层out
    $('.addr').hover(function() {
		
    }, function() {
        $('.country_list').hide();
    }).click(function() {
        $('.country_list').show();
    });
    //费用估算 国家选择go!     
    $('.countrylist a').bind('click', function() {
        var city = $(this).text();
        $('#area').val(city);
        $('#area').attr('realvalue', $(this).attr('cid'));
        $('.country_list').hide();
    });
    $('.countryzm a').each(function(index, item) {
        $(item).click(function() {
            $('.countryzm li.zmon').removeClass('zmon');
            $(this).parent().addClass('zmon');
            $('#countryTab ul').hide();
            $('#countryTab ul').eq(index).show();
            return false;
        });
    });
	$('.app_down').hover(function(){
		$('.QR_app_down').fadeIn();
	},function(){
		$('.QR_app_down').fadeOut();
	})

	$("#order_bank_list input").change(function() { 
	   value = $(this).attr("value");
	   $('#order_defaultbank').attr("value",value);
	});

	$("#recharge_bank_list input").change(function() { 
	   value = $(this).attr("value");
	   $('#recharge_defaultbank').attr("value",value);
	});


	$("#waybill_bank_list input").change(function() { 
	   value = $(this).attr("value");
	   $('#waybill_defaultbank').attr("value",value);
	});

});

/**************************************充值模块****************************************/
function paypal_recharge_check() {
    var paypalrecharge = $("#paypal_recharge").val();
    var paypal = $("#paypal_reality").text();
    
    if(paypal) {
        return true;
    }else{
        alert("请输入充值金额!^_^ 小调皮");
        return false;
    }
}

//支付宝充值
function payment_alipay() {
    var alipayrecharge = $("#alipay_recharge").val();
    var alipay = $("#alipay_reality").text();
    if(!alipay) {
        alert("请输入充值金额!^_^ 小调皮");
    }else {
        var newwindow = window.open('about:blank');
        $.ajax({
            type: "POST",
            url: 'index.php?route=payment/alipay',
            dataType: "json",
            data: "action=recharge" + "&amount=" + alipayrecharge + "&money=" + alipay,   
            timeout: 25000,
            success: function(json) {
                newwindow.location.href = json;   
            },
            error: function(json) {
            }
        });
   }
}

//支付宝国际信用卡充值
function payment_credit_alipay() {
    var creditrecharge = $("#credit_recharge").val();
    var credit = $("#credit_reality").text();
    var credit_type = $("#credittype").val();
    if(!credit) {
        alert("请输入充值金额！^_^ 小调皮");
    }else{
        var newwindow = window.open('about:blank');
        $.ajax({
            type: "POST",
            url: 'index.php?route=payment/alipay',
            dataType: "json",
            data: "action=recharge&amount=" + creditrecharge + "&money=" + credit + "&type=" + credit_type + "&js_return=js_return^" + window["alipay-merchant-result"],   
            timeout: 25000,
            success: function(json) {
                newwindow.location.href = json;
            },
            error: function(json) {
            }
        });
    }
}

//国内银行卡充值
function payment_bank() {
    var bankrecharge = $("#bank_recharge").val();
    var bank = $("#bank_reality").text();
    var recharge_defaultbank = $('#recharge_defaultbank').val();
    if(!bank || !recharge_defaultbank) {
        alert("请输入充值金额和选择付款银行！^_^ 小调皮");
    }else{
        var newwindow = window.open('about:blank');
        $.ajax({
            type: "POST",
            url: 'index.php?route=payment/alipay',
            dataType: "json",
            data: "action=recharge" + "&amount=" + bankrecharge + "&money=" + bank + "&recharge_defaultbank=" + recharge_defaultbank,
            //contentType: "application/json;utf-8",   
            timeout: 25000,
            success: function(json) {
                newwindow.location.href = json;
            },
            error: function(json) {
    
            }
        });
    }
}

/*******************************************************************************************/

/*************************************代购订单**********************************************/

//支付宝提交代购订单
function order_alipay() {
    var newwindow = window.open('about:blank');
    $.ajax({
        type: "POST",
        url: 'index.php?route=payment/alipay',
        dataType: "json",
        data: "action=order",   
        timeout: 25000,
        success: function(json) {
            newwindow.location = json;
        },
        error: function(json) {
        }
    });
}

//支付宝国际信用卡提交代购订单
function order_alipay_credit() {
    var credit_type = $("#typecredit_order").val();
    var newwindow = window.open('about:blank');
    $.ajax({
        type: "POST",
        url: 'index.php?route=payment/alipay',
        dataType: "json",
        data: "action=order&type=" + credit_type + "&js_return=js_return^" + window["alipay-merchant-result"],   
        timeout: 25000,
        success: function(json) {
            newwindow.location = json;
        },
        error: function(json) {
        }
    });
}

//国内银行卡提交代购订单
function order_bank() {
    defaultbank = $('#order_defaultbank').val();
    var newwindow = window.open('about:blank');
    $.ajax({
        type: "POST",
        url: 'index.php?route=payment/alipay',
        dataType: "json",
        data: "action=order&order_defaultbank=" + defaultbank,   
        timeout: 25000,
        success: function(json) {
            newwindow.location = json;
        },
        error: function(json) {
         
        }
    });
}

/*******************************************国际运单*****************************************************************/

//支付宝提交国际运单
function waybill_alipay() {
    var waybill = $("#waybill_alipay").text();
    $.ajax({
        type: "POST",
        url: 'index.php?route=payment/alipay',
        dataType: "json",
        data: "action=waybill" + "&amount=" + waybill,
        timeout: 25000,
        success: function(json) {
            window.location = json;
        },
        error: function(json) {
        }
    });
}


//支付宝国际信用卡提交国际运单
function waybill_alipay_credit() {
    var credit_type = $("#typecredit_waybill").val();
    var waybill = $("#waybill_alipay_credit").text();
    $.ajax({
        type: "POST",
        url: 'index.php?route=payment/alipay',
        dataType: "json",
        data: "action=waybill&type=" + credit_type + "&amount=" + waybill + "&js_return=js_return^" + window["alipay-merchant-result"],   
        timeout: 25000,
        success: function(json) {
            window.location = json;
        },
        error: function(json) {
        }
    });
}


//银行卡提交国际运单
function waybill_bank() {
    var waybill = $('#waybill_bank').text();
    var defaultbank = $('#waybill_defaultbank').val();
    var newwindow = window.open('about:blank');
    $.ajax({
        type: "POST",
        url: 'index.php?route=payment/alipay',
        dataType: "json",
        data: "action=waybill" + "&amount=" + waybill + "&waybill_defaultbank=" + defaultbank,
        timeout: 25000,
        success: function(json) {
            newwindow.location = json;
        },
        error: function(json) {
        }
    });
}


/*******************************************************************************************************************************/

//付款方式选择
function Slectpay() {
    if (document.getElementById("Accountpay").checked) {
        $("#radio1").addClass("bold");
        $("#radio2").removeClass("bold");
        $(".Thirdpay").slideToggle();
        $(".avilable_yue").slideToggle();
    } else {
        $("#radio1").removeClass("bold");
        $("#radio2").addClass("bold");
        $(".avilable_yue").slideToggle();
        $(".Thirdpay").slideToggle();
    }
}

//费用估算
function toEstimate() {
    var area = document.getElementsByName('area')[0].getAttribute('realvalue');
    var weight = document.getElementsByName('weight')[0].value;
    var area_cn = document.getElementsByName('area')[0].value;
    if (area == ""){
        $('#noweight').hide();
        $('#noaddress').fadeIn();
    } else if (weight == "" || weight == 0) {
        $('#noaddress').hide();
        $('#noweight').fadeIn();
    } else {
        $('#area_id').val(area);
        $('#estimate').submit();
    }
}

//更新购物车商品数量
function updateQty(id, state) {
    if (state == "plus") {
        quantity = Number(document.getElementById(id).value) + 1;
    } else {
        quantity = Number(document.getElementById(id).value) - 1;
    }
    $.ajax({
        type: "POST",
        url: 'index.php?route=checkout/cart/updateQty',
        dataType: "json",
        data: "id=" + id + "&quantity=" + quantity,
        timeout: 25000,
        success: function(json) {

        },
        error: function(json) {
        }
    });
}

//地理秀城市
function show_city() {
    $.ajax({
        url: 'index.php?route=account/address/country&country_id=' + $('#country_id').val(),
        dataType: 'json',
        beforeSend: function() {
            $('select[id=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
        },
        complete: function() {
            $('.wait').remove();
        },
        success: function(json) {
            if (json['postcode_required'] == '1') {
                $('#postcode-required').show();
            } else {
                $('#postcode-required').hide();
            }
            html = '<option value="">---请选择---</option>';
            if (json['zone'] != '') {
                for (i = 0; i < json['zone'].length; i++) {
                    html += '<option value="' + json['zone'][i]['zone_id'] + '"';
                    if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                        html += ' selected="selected"';
                    }
                    if (json['zone'][i]['name_cn']){
						html += '>' + json['zone'][i]['name'] + '(' + json['zone'][i]['name_cn'] + ')' +'</option>';
					}else{
						html += '>' + json['zone'][i]['name'] + '</option>';
					}
                }
            } else {
                html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
            }
            $('select[name=\'zone_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//判断选择商品才可提交订单
function makeorder() {
    var flag = $('#wanna_buy').val();
    if (flag)
        $('#makeorder').submit();
    else
        alert("请选择商品提交订单");
}

//判断选择订单才能进行提交
function HasOrder() {
    var flag = $('#batch_pay').val();
    if (flag)
        $('#batch_pay_form').submit();
    else
        alert("请选择订单提交");
}

//判断选择运单才能提交
function HasWaybill() {
    var flag = $('#waybillbatch_pay').val();
    if (flag)
        $('#waybillbatch_pay_form').submit();
    else
        alert("请选择运单提交");
}

//前往用户评论
function seeComment() {
    window.location.href = '/index.php?route=information/comments';
}

$(function(){
	homeEvents.init();
});
var homeEvents = {
	checking : function(){/*头部导航*/
		var hrefUrl=window.location.href;
		if(hrefUrl.indexOf("procurement")>=0){
			$(".navigations li:eq(0) a").addClass("mainColor").parent().siblings().find("a").removeClass("mainColor");
		}else if(hrefUrl.indexOf("selfshopping")>=0){
			$(".navigations li:eq(1) a").addClass("mainColor").parent().siblings().find("a").removeClass("mainColor");
		}else if(hrefUrl.indexOf("international")>=0&&hrefUrl.indexOf("express")>=0){
			$(".navigations li:eq(2) a").addClass("mainColor").parent().siblings().find("a").removeClass("mainColor");
		}else if(hrefUrl.indexOf("information")>=0&&hrefUrl.indexOf("comments")>=0){
			$(".navigations li:eq(3) a").addClass("mainColor").parent().siblings().find("a").removeClass("mainColor");
		}else if(hrefUrl.indexOf("help")>=0&&hrefUrl.indexOf("populartools")>=0&&hrefUrl.indexOf("id=10")>=0){
			$(".navigations li:eq(4) a").addClass("mainColor").parent().siblings().find("a").removeClass("mainColor");
		}else{
			$(".navigations li a").removeClass("mainColor");
		}
	},
	showShop : function(){/*头部商城下拉*/
		$(".showShops").click(function(){
			$(".tipsShop").toggle();
		});
	},
	website_map : function(){/*网站导航*/
		$(".site_map").hover(function(){
			$(this).toggleClass("menu_hover");
		});
	},
	usercenter_website_map : function(){/*网站导航*/
		$(".map_menu_title").hover(function(){
			$(".website_navigation").hover(function(){
				$(".map_menu_title").addClass("active");
				$(".website_navigation").show();
			},function(){
				$(".map_menu_title").removeClass("active");
				$(".website_navigation").hide();
			});
			$(".map_menu_title").addClass("active");
			$(".website_navigation").show();
		},function(){
			$(".map_menu_title").removeClass("active");
			$(".website_navigation").hide();
		});
	},
	init : function(){
		homeEvents.showShop();
		homeEvents.checking();
		homeEvents.website_map();
		homeEvents.usercenter_website_map();
	}
};