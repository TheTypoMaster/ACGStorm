/**************************************/
/*@author:  Boss <cnstorm01@cnstorm.com> */
/*@date:     2014.12.19               */
/**************************************/
/**************************************Tab切换****************************************/
$(function() {
    $('.ui-tab-item').on('click', function() {
        $('a').removeClass('ui-tipbox-selected');
        $(this).find('a').addClass("ui-tipbox-selected");
        $('.gateways').eq($(this).index()).show().siblings('.gateways').hide();
    });
    $('.payment-title li').on('click', function() {
        k = $(this).prop("className");
        $(this).addClass('selected').siblings().removeClass('selected');
        if (k) {
            $('.paylist').eq($(this).index()).show().siblings('.paylist').hide();
        } else {
            $('.paylist_f').eq($(this).index()).show().siblings('.paylist_f').hide();
        }
    });
/**************************************充值模块****************************************/
    $("#recharge_bank_list input").change(function() {
        value = $(this).attr("value");
        $('#recharge_defaultbank').attr("value", value);
    });

//实现充值功能
//支付宝
    $('#alipay_recharge').bind('keyup',
            function() {
                var alipay_value = $("#alipay_recharge").val();
                $('#alipay_reality').text((alipay_value * (1 - 0.01 - 0.001)).toFixed(2));
            })

//paypal
    $('#paypal_recharge').bind('keyup',
            function() {
                var paypal_value = $("#paypal_recharge").val();
                var paypal_rate = $("#paypal_rate").text();
                $('#paypal_reality').text(((paypal_value * (1 - 0.039)) / paypal_rate).toFixed(2));
                $('#money').attr("value", ((paypal_value * (1 - 0.039)) / paypal_rate).toFixed(2));
            })

//支付宝国际信用卡
    $('#credit_recharge').bind('keyup',
            function() {
                var credit_value = $("#credit_recharge").val();
                $('#credit_reality').text(((credit_value * (1 - 0.035))).toFixed(2));
            })

//国内银行卡        
    $('#bank_recharge').bind('keyup',
            function() {
                var alipay_value = $("#bank_recharge").val();
                $('#bank_reality').text((alipay_value * (1 - 0.01 - 0.001)).toFixed(2));
            })

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
});

function paypal_recharge_check() {

    var paypalrecharge = $("#paypal_recharge").val();
    var paypal = $("#paypal_reality").text();

    if (paypal != 0) {
        return true;
    } else {
        alert("请输入充值金额!^_^ 小调皮");
        return false;
    }
}

//支付宝充值
function payment_alipay() {
    var alipayrecharge = $("#alipay_recharge").val();
    var alipay = $("#alipay_reality").text();

    if (alipay == 0) {

        alert("请输入充值金额!^_^ 小调皮");

    } else {
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
        })
    }
}

//支付宝国际信用卡充值
function payment_credit_alipay() {

    var creditrecharge = $("#credit_recharge").val();
    var credit = $("#credit_reality").text();
    var credit_type = $("#credittype").val();

    if (credit == 0) {

        alert("请输入充值金额！^_^ 小调皮");

    } else {
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
        })
    }
}

//国内银行卡充值
function payment_bank() {

    var bankrecharge = $("#bank_recharge").val();
    var bank = $("#bank_reality").text();

    var recharge_defaultbank = $('#recharge_defaultbank').val();

    if (bank == 0 || !recharge_defaultbank) {

        alert("请输入充值金额和选择付款银行！^_^ 小调皮");

    } else {
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
        })
    }
}
/**************************************提交运单****************************************/
function aaa() {
    var nums = 0;
    var chestr = "";
    var chk = document.getElementsByName('selected[]');
    for (var i = 0; i < chk.length; i++) {
        if (chk[i].checked) {
            nums++;
            chestr += chk[i].value + ",";
        }
    }
    document.getElementById('hj').innerHTML = nums;
    //$('#soids').val(chestr);
    $.ajax({
        type: "GET",
        url: "index.php?route=order/order/ajax_weight",
        data: "chestr=" + chestr,
        success: function(msg) {
            document.getElementById('weight').innerHTML = msg;
        }
    });
}

function judgeweight() {
  if($('#weight').html() > 0)  
    $('#form').submit();
  else  
    alert("请选择有重量的商品提交运单");
}
/**************************************合并支付****************************************/
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