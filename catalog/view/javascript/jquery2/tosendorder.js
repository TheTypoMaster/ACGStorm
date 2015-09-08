$(function() {
    Number.prototype.toFixed = function(d) {
        var s = this + "";
        if (!d)
            d = 0;
        if (s.indexOf(".") == -1)
            s += ".";
        s += new Array(d + 1).join("0");
        if (new RegExp("^(-|\\+)?(\\d+(\\.\\d{0," + (d + 1) + "})?)\\d*$").test(s)) {
            var s = "0" + RegExp.$2, pm = RegExp.$1, a = RegExp.$3.length, b = true;
            if (a == d + 2) {
                a = s.match(/\d/g);
                if (parseInt(a[a.length - 1]) > 4) {
                    for (var i = a.length - 2; i >= 0; i--) {
                        a[i] = parseInt(a[i]) + 1;
                        if (a[i] == 10) {
                            a[i] = 0;
                            b = i != 1;
                        } else
                            break;
                    }
                }
                s = a.join("").replace(new RegExp("(\\d+)(\\d{" + d + "})\\d$"), "$1.$2");

            }
            if (b)
                s = s.substr(1);
            return (pm + s).replace(/\.$/, "");
        }
        return this + "";
    };


    //如果没有展开，那么后面的需要隐藏
    if ($(".open_addr a").hasClass("stri_open")) {
        $(".address .option_box:gt(3)").hide();
        var number = $(".address .option_box:last").index();
        if (number >= 3) {
            $(".add_option_box").hide();
        }

    }

    //选择收货地址显示效果
    $(document).on("click", ".option_box", function(event) {

        $(".option_box").each(function() {
            if ($(this).is(".selected"))
                $(this).removeClass("selected");
        });

        $(this).addClass("selected");

        var address_id = $(this).find(":radio").val();
        var sensitive = $('#sensitive').val();
        var brand = $('#brand').val();
        var weight = $('#weight').val();
        var order_id_combination = $('#order_id_combination').val();


        //根据收货地址显示相应的快递运输方式
        if (address_id) {
            $('.send_layer').slideDown();
            $('#ex_list').html("<div class='loading'><img src='catalog/view/theme/cnstorm/images/loading_data.gif' alt='小C正在卖命的加载，请稍候~~'/></div>");
            var url = 'index.php?route=waybill/transport/getdelivery&address_id=' + address_id + '&sensitive=' + sensitive + '&weight=' + weight + '&brand=' + brand + '&order_id_combination=' + order_id_combination;
            $('#ex_list').load(url);
        }

        event.stopPropagation();

    });


    $(".normal-title .order_number").mouseover(function() {
        $("#order_box_normal").css("display", "block");
    });
    $(".normal-title .order_number").mouseout(function() {
        $("#order_box_normal").css("display", "none");
    });

    $(".sensitive-title .order_number").mouseover(function() {
        $("#order_box").css("display", "block");
    });
    $(".sensitive-title .order_number").mouseout(function() {
        $("#order_box").css("display", "none");
    });

    $(".donation_l input[type='text']").click(function() {
        $(".donation_l input[type='radio']").each(function() {
            this.checked = false;
        });
    });

    $(".donation_l input[type='radio']").click(function() {
        var donation = this.value;
        $(".donation_r span b").text(donation * 0.1);
        $("#estimate_donation").text(donation);
        $(".donamount").val(donation);
        $(".donation_l input[type='text']").val(0);
        getestimate_total();
    });

});

//自填打赏额
function newDonation() {

    var inputdonation = $("#custom_donation").val();
    $(".donation_r span b").text((inputdonation * 0.1).toFixed(2));
    $("#estimate_donation").text(inputdonation);
    $(".donamount").val(inputdonation);

    getestimate_total();

}

//隐藏收货地址
$(".open_addr").click(function() {
    var _this = $(this), _a = _this.find("a");
    if (_a.hasClass("stri_open")) {
        _a.removeClass("stri_open").addClass("stri_close").html("收起收货地址<span></span>");
        $(".address .option_box:gt(3)").show();
        $(".add_option_box").show();
    } else {
        _a.addClass("stri_open").removeClass("stri_close").html("展开收货地址<span></span>");
        $(".address .option_box:gt(3)").hide();
        var number = $(".address .option_box:last").index();
        if (number >= 3) {
            $(".add_option_box").hide();
        }

    }
});


//选择运输方式显示效果
$(document).on("click", ".ui-body", function(event) {

    $(".ui-body").each(function() {
        if ($(this).is(".selected"))
            $(this).removeClass("selected");
    });

    $(this).addClass("selected");
    $(this).find(":radio").prop("checked", true);

    $("#de_button").slideDown();

});

$(document).on("click", ".ui-sensitive-body", function(event) {
    if ($(this).is(".selected")) {
        $(this).removeClass("selected");
        $(this).find(":radio").prop("checked", false);

    } else {
        $(".ui-sensitive-body").each(function() {
            if ($(this).is(".selected"))
                $(this).removeClass("selected");
        });

        $(this).addClass("selected");
        $(this).find(":radio").prop("checked", true);
    }

});


//获取估算总费用
function getestimate_total() {

    var estimate_freight = $("#estimate_freight").text();
    var estimate_customerfee = 8;
    var estimate_wrapper = $("#estimate_wrapper").text();
    var estimate_unpack = $("#estimate_unpack").text();
    var estimate_checkorder = $("#estimate_checkorder").text();
    var estimate_largepackage = $("#estimate_largepackage").text();
    var estimate_waybillphoto = $("#estimate_waybillphoto").text();
    var estimate_donation = $("#estimate_donation").text();

    if (!estimate_freight) {
        estimate_freight = 0.00;
    }

    if (!estimate_customerfee) {
        estimate_customerfee = 0.00;
    }

    if (!estimate_wrapper) {
        estimate_wrapper = 0.00;
    }

    if (!estimate_unpack) {
        estimate_unpack = 0.00;
    }

    if (!estimate_checkorder) {
        estimate_checkorder = 0.00;
    }

    if (!estimate_largepackage) {
        estimate_largepackage = 0.00;
    }

    if (!estimate_waybillphoto) {
        estimate_waybillphoto = 0.00;
    }

    if (!estimate_donation) {
        estimate_donation = 0.00;
    }

    var estimate_total = (parseFloat(estimate_freight) + parseFloat(estimate_customerfee) + parseFloat(estimate_wrapper) + parseFloat(estimate_unpack) + parseFloat(estimate_checkorder) + parseFloat(estimate_largepackage) + parseFloat(estimate_waybillphoto) + parseFloat(estimate_donation)).toFixed(2);

    $("#estimate_total").text(estimate_total);
}


function getestimate_sensitive_total() {

    var estimate_freight_sensitive = $("#estimate_freight_sensitive").text();
    var estimate_customerfee_sensitive = 8;
    var estimate_wrapper_sensitive = $("#estimate_wrapper_sensitive").text();
    var estimate_unpack_sensitive = $("#estimate_unpack_sensitive").text();
    var estimate_checkorder_sensitive = $("#estimate_checkorder_sensitive").text();
    var estimate_largepackage_sensitive = $("#estimate_largepackage_sensitive").text();
    var estimate_waybillphoto_sensitive = $("#estimate_waybillphoto_sensitive").text();

    if (!estimate_freight_sensitive) {
        estimate_freight_sensitive = 0.00;
    }

    if (!estimate_customerfee_sensitive) {
        estimate_customerfee_sensitive = 0.00;
    }

    if (!estimate_wrapper_sensitive) {
        estimate_wrapper_sensitive = 0.00;
    }

    if (!estimate_unpack_sensitive) {
        estimate_unpack_sensitive = 0.00;
    }

    if (!estimate_checkorder_sensitive) {
        estimate_checkorder_sensitive = 0.00;
    }

    if (!estimate_largepackage_sensitive) {
        estimate_largepackage_sensitive = 0.00;
    }

    if (!estimate_waybillphoto_sensitive) {
        estimate_waybillphoto_sensitive = 0.00;
    }

    var estimate_total_sensitive = (parseFloat(estimate_freight_sensitive) + parseFloat(estimate_customerfee_sensitive) + parseFloat(estimate_wrapper_sensitive) + parseFloat(estimate_unpack_sensitive) + parseFloat(estimate_checkorder_sensitive) + parseFloat(estimate_largepackage_sensitive) + parseFloat(estimate_waybillphoto_sensitive)).toFixed(2);

    $("#estimate_total_sensitive").text(estimate_total_sensitive);
}


//选择打包方案选择显示效果
$('.unpack .service-info').click(function(event) {
    $(".unpack .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
    });

    $(this).addClass("checked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_unpack").text($(this).find("i").text().substr(1));
    getestimate_total();

});

$('.unpack-sensitive .service-info').click(function(event) {
    $(".unpack-sensitive .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_unpack_sensitive").text($(this).find("i").text().substr(1));
    getestimate_sensitive_total();

});

$('.unpack-sensitive .service-info-wide').click(function(event) {
    $(".unpack-sensitive .service-info-wide").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);

    if ($(this).find("i").text()) {
        $("#estimate_unpack_sensitive").text($(this).find("i").text().substr(1));
    } else {
        $("#estimate_unpack_sensitive").text("0");
    }
    getestimate_sensitive_total();

});


$('.unpack-normal .service-info').click(function(event) {
    $(".unpack-normal .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_unpack").text($(this).find("i").text().substr(1));
    getestimate_total();

});

$('.unpack-normal .service-info-wide').click(function(event) {
    $(".unpack-normal .service-info-wide").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    if ($(this).find("i").text()) {
        $("#estimate_unpack").text($(this).find("i").text().substr(1));
    } else {
        $("#estimate_unpack").text("0");
    }

    getestimate_total();

});

//选择订单处理方案显示效果
$('.checkorder .service-info').click(function(event) {

    $(".checkorder .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
    });

    $(this).addClass("checked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_checkorder").text($(this).find("i").text().substr(1));
    getestimate_total();

});

$('.checkorder-sensitive .service-info').click(function(event) {

    $(".checkorder-sensitive .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_checkorder_sensitive").text($(this).find("i").text().substr(1));
    getestimate_sensitive_total();

});

$('.checkorder-sensitive .service-info-wide').click(function(event) {

    $(".checkorder-sensitive .service-info-wide").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    if ($(this).find("i").text()) {
        $("#estimate_checkorder_sensitive").text($(this).find("i").text().substr(1));
    } else {
        $("#estimate_checkorder_sensitive").text("0");
    }

    getestimate_sensitive_total();

});

$('.checkorder-normal .service-info').click(function(event) {
    $(".checkorder-normal .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_checkorder").text($(this).find("i").text().substr(1));
    getestimate_total();

});

$('.checkorder-normal .service-info-wide').click(function(event) {
    $(".checkorder-normal .service-info-wide").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    if ($(this).find("i").text()) {
        $("#estimate_checkorder").text($(this).find("i").text().substr(1));
    } else {
        $("#estimate_checkorder").text("0");
    }

    getestimate_total();

});

//选择增值服务显示效果
$('.valueadded .service-info').click(function(event) {
    if ($(this).is(".selected")) {
        $(this).removeClass("selected");
        $(this).find(":checkbox").prop("checked", false);

        if ('1.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_largepackage").text(0);
        } else if ('3.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_waybillphoto").text(0);
        }

        getestimate_total();


    } else {
        $(this).addClass("selected");
        $(this).find(":checkbox").prop("checked", true);

        if ('1.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_largepackage").text(1.5);
        } else if ('3.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_waybillphoto").text(3.5);
        }

        getestimate_total();
    }
});


$('.valueadded-sensitive .service-info-wide').click(function(event) {
    if ($(this).is(".checked")) {
        $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
        $(this).find(":checkbox").prop("checked", false);

        if ('1.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_largepackage_sensitive").text(0);
        } else if ('3.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_waybillphoto_sensitive").text(0);
        }

        getestimate_sensitive_total();

    } else {
        $(this).addClass("checked");
        $(this).children(".service-info-title").addClass("titlechecked");
        $(this).find(":checkbox").prop("checked", true);

        if ('1.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_largepackage_sensitive").text(1.5);
        } else if ('3.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_waybillphoto_sensitive").text(3.5);
        }

        getestimate_sensitive_total();
    }
});

$('.valueadded-normal .service-info-wide').click(function(event) {
    if ($(this).is(".checked")) {
        $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
        $(this).find(":checkbox").prop("checked", false);

        if ('1.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_largepackage").text(0);
        } else if ('3.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_waybillphoto").text(0);
        }

        getestimate_total();

    } else {
        $(this).addClass("checked");
        $(this).children(".service-info-title").addClass("titlechecked");
        $(this).find(":checkbox").prop("checked", true);

        if ('1.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_largepackage").text(1.5);
        } else if ('3.5' === $(this).find("i").text().substr(1)) {
            $("#estimate_waybillphoto").text(3.5);
        }

        getestimate_total();
    }
});


//选择包装耗材显示效果
$('.wrapper .service-info').click(function(event) {
    $(".wrapper .service-info").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
    });

    $(this).addClass("checked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_wrapper").text($(this).find("i").text().substr(1));
    getestimate_total();
});

$('.wrapper-sensitive .service-info-wide').click(function(event) {
    $(".wrapper-sensitive .service-info-wide").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_wrapper_sensitive").text($(this).find("i").text().substr(1));
    getestimate_sensitive_total();
});

$('.wrapper-normal .service-info-wide').click(function(event) {
    $(".wrapper-normal .service-info-wide").each(function() {
        if ($(this).is(".checked"))
            $(this).removeClass("checked");
        $(this).children(".service-info-title").removeClass("titlechecked");
    });

    $(this).addClass("checked");
    $(this).children(".service-info-title").addClass("titlechecked");
    $(this).find(":radio").prop("checked", true);
    $("#estimate_wrapper").text($(this).find("i").text().substr(1));
    getestimate_total();
});


//打开增加新地址对话弹出层
function addnewaddr()
{
    var address_count = $("#address_count").val();

    if (address_count >= 10) {
        alert("亲，最多只能添加10个收货地址哦！");
        return false;
    }

    $("#address_info").fadeIn();
    $("#dlg_bg").fadeIn();
}

//关闭新增地址对话弹出层
function newaddress_close()
{
    $("#address_info").fadeOut();
    $("#dlg_bg").fadeOut();

    $("#newaddress_id").val('');
    $("#lastname").val('');
    $("#country_id").val('');
    $("#zone_id").val('');
    $("#addressdetails").val('');
    $("#postcode").val('');
    $("#tel").val('');
    $("#country_en").val('');
    $("#city_en").val('');

}


//获取收货地址中选择国家后联动显示相应的城市
function show_city() {

    $.ajax({
        url: 'index.php?route=account/address/country&country_id=' + $('#country_id').val(),
        dataType: 'json',
        beforeSend: function() {
            $('select[id=\'zone_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
        },
        complete: function() {
            $('.wait').remove();
        },
        success: function(json) {

            html = '<option value="">---请选择---</option>';

            if (json['zone'] != '') {
                for (i = 0; i < json['zone'].length; i++) {


                    html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                    if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                        html += ' selected="selected"';

                    }
                    if (json['zone'][i]['name_cn']) {
                        html += '>' + json['zone'][i]['name'] + '(' + json['zone'][i]['name_cn'] + ')' + '</option>';
                    } else {
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


//获取收货地址选择中区域的名称
function this_city() {
    var selectInput = document.getElementById("zone_id");
    $("#city_en").val(selectInput.options[selectInput.selectedIndex].text);
}



//保存新地址
function save_address() {

    var lastname = $.trim($("#lastname").val());
    var country_id = $("#country_id").val();
    var zone_id = $("#zone_id").val();
    var address_details = $.trim($("#addressdetails").val());
    var postcode = $.trim($("#postcode").val());
    var telephone = $.trim($("#tel").val());
    var country_en = $.trim($("#country_en").val());
    var city_en = $.trim($("#city_en").val());
    var newaddress_id = $("#newaddress_id").val();

    var flag = 1;
    //检测收货真实姓名
    if (!lastname) {
        $("#no_name").fadeIn();
        flag = 0;
    } else {
        $("#no_name").fadeOut();
    }

    //检测收货地址国家
    if (!country_id) {
        $("#no_add").fadeIn();
        flag = 0;
    } else {
        $("#no_add").fadeOut();
    }

    //检测收货地址详细地址
    if (!address_details) {
        $("#no_details").fadeIn();
        flag = 0;
    } else {
        $("#no_details").fadeOut();
    }

    //检测收货地址的邮编
    var pe = /[a-zA-Z0-9]$/;
    if (!postcode || !pe.test(postcode)) {
        $("#no_postcode").fadeIn();
        flag = 0;
    } else {
        $("#no_postcode").fadeOut();
    }

    //检测收货人的电话号码
    var re = /[-+0-9]$/;
    if (!telephone || !re.test(telephone)) {
        $("#no_tel").fadeIn();
        flag = 0;
    } else {
        $("#no_tel").fadeOut();
    }

    //地址信息输入完全且格式正确
    if (flag > 0) {
        $.ajax({
            type: "POST",
            url: "index.php?route=waybill/transport/newaddress",
            data: "lastname=" + lastname + "&country_id=" + country_id + "&zone_id=" + zone_id + "&address_details=" + address_details + "&postcode=" + postcode + "&telephone=" + telephone + "&newaddress_id=" + newaddress_id,
            success: function(data) {

                var data = JSON.parse(data);

                var address_id = data['address_id'];
                var lastname = data['lastname'];
                var country = data['country'];
                var city = data['city'];
                var address_details = data['address_details'];
                var telephone = data['telephone'];

                if (!newaddress_id) {
                    var new_addr = ' <div class="option_box" id="old_address_' + address_id + '">' +
                            '<input id=address_id class="rdoAddress" type="radio" name="address_id" value=' + address_id + '>' +
                            '<label class="address_lbl" data_address=' + address_id + ' for=' + address_id + '>' +
                            '<span class="btnEditAddress_new" addressid=' + address_id + ' title="修改地址" onclick="edit_address(' + address_id + ')">修改</span>' +
                            '<span class="btnEditAddress_del" addressid=' + address_id + ' title="删除地址"  onclick="del_address(' + address_id + ')">删除</span>' +
                            '<p> <span class="addr_name">' + lastname + '</span> ' +
                            '<span class="addr_con">' + country + "-" + city + "-" + address_details + '</span>' +
                            '<span class="addr_num">' + telephone + '</span>' +
                            '</p></label><div class="clear"></div></div>';

                    $('.add_option_box').before(new_addr);
                    $("#address_info").fadeOut();
                    $("#dlg_bg").fadeOut();

                    var address_count = $("#address_count").val();
                    var new_address_count = parseInt(address_count) + parseInt("1");
                    $("#address_count").val(new_address_count);
                } else {
                    window.location.reload();
                }

            }
        });
    }
}

//删除收货地址
function del_address(aid) {

    var address_id = aid;

    $.ajax({
        type: "POST",
        url: "index.php?route=waybill/transport/deladdress",
        data: "address_id=" + aid,
        success: function(flag) {
            $("#old_address_" + address_id).animate({opacity: 0}, 200);
            $("#old_address_" + address_id).slideUp();
            $("#old_address_" + address_id).remove();

            var address_count = $("#address_count").val();
            var new_address_count = parseInt(address_count) - parseInt("1");
            $("#address_count").val(new_address_count);

            return false;
        }
    });

}
//修改收货地址
function get_city(zone_id) {

    $.ajax({
        url: 'index.php?route=account/address/country&country_id=' + $('#country_id').val(),
        dataType: 'json',
        beforeSend: function() {
            $('select[id=\'zone_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
        },
        complete: function() {
            $('.wait').remove();
        },
        success: function(json) {

            html = '<option value="">---请选择---</option>';

            if (json['zone'] != '') {
                for (i = 0; i < json['zone'].length; i++) {


                    html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                    if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                        html += ' selected="selected"';

                    }
                    if (json['zone'][i]['name_cn']) {
                        html += '>' + json['zone'][i]['name'] + '(' + json['zone'][i]['name_cn'] + ')' + '</option>';
                    } else {
                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                }
            } else {
                html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'zone_id\']').html(html);

            $("#zone_id").val(zone_id);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

}

function edit_address(aid) {

    $("#address_info").fadeIn();

    $("#dlg_bg").fadeIn();

    $.ajax({
        type: "POST",
        url: "index.php?route=waybill/transport/editaddress",
        data: "address_id=" + aid,
        success: function(data) {

            var data = JSON.parse(data);

            $("#newaddress_id").val(data['address_id']);
            $("#lastname").val(data['lastname']);
            $("#addressdetails").val(data['address_details']);
            $("#postcode").val(data['postcode']);
            $("#tel").val(data['telephone']);
            $("#country_id").val(data['country_id']);
            get_city(data['zone_id']);
        }
    });

}

//将商品放回仓库
function layback(order_id) {

    //根据收货地址显示相应的快递运输方式
    $('#shipping_good_info').html("<div class='loading'><img src='catalog/view/theme/cnstorm/images/loading_data.gif' alt='小C正在卖命的加载，请稍候~~'/></div>");
    var url = 'index.php?route=waybill/transport/layback&order_id=' + order_id;
    $('#shipping_good_info').load(url);

    $('#ex_list').html("<div class='loading'><img src='catalog/view/theme/cnstorm/images/loading_data.gif' alt='小C正在卖命的加载，请稍候~~'/></div>");
    var url = 'index.php?route=waybill/transport/getdelivery';
    $('#ex_list').load(url);

    $(".option_box").each(function() {
        if ($(this).is(".selected"))
            $(this).removeClass("selected");
    });

}

//核对运单总价 展开备注 优惠卷 积分抵消部分总额
function launch(state) {
    $('#' + state).slideToggle();
    $('.' + state).toggleClass("plus");
}

//使用优惠卷抵扣部分运费
$('.coupon_list').find('li').click(function() {
    $('#usecoupon').val($(this).attr('id'));
    $('#coupon_discount').html($(this).find('b').text());

    var htotalfee = $("#htotalfee").val();
    var coupon_discount = $("#coupon_discount").text();
    var score_discount = $("#score_discount").text();

    $("#totalfee").text((htotalfee - score_discount - coupon_discount)).toFixed(2);
});


//使用积分抵扣部分运费
function newEqual(totalscore) {

    var inputscore = $("#scoreuse").val();

    if (inputscore > totalscore) {
        $("#scoreuse").val(totalscore);
        inputscore = totalscore;
    }

    var score_discount = (inputscore / 100).toFixed(2);

    $("#score_discount").text(score_discount);
    $("#subAmount").text(score_discount);

    var htotalfee = $("#htotalfee").val();
    var coupon_discount = $("#coupon_discount").text();

    var totalfee = (htotalfee - score_discount - coupon_discount).toFixed(2);

    $("#totalfee").text(totalfee);

}


//上一步返回
function laststep(sid) {
    $.ajax({
        type: "POST",
        url: "index.php?route=waybill/checkout/laststep",
        data: "sid=" + sid,
        success: function(json) {
            if (json) {
                var url = "index.php?route=waybill/transport";
                window.location = url;
            }
        }
    });

}
