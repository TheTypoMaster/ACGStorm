/**************************************/
/*@author:  Ls.Z<cnstorm01@cnstorm.com> */
/*@date:     2014.6.24               */
/*@description: 用户中心订单列表相关 */
/**************************************/

//订单列表单个订单付款
function singlePay(oid) {
    var toid = CharEncode("'" + oid + "'");
    var prices = CharEncode($('.price_total_' + oid).text());
    var freight = CharEncode($('.freight_' + oid).text());
    window.location.href = "/index.php?route=checkout/confirm&total_amount=" + prices + "&total_freight=" + freight + "&order_id=" + toid + "&single_pay=yes";
}
//国际运单列表单个运单付款
function singlePay2(oid) {
    var toid = CharEncode("'" + oid + "'");
    var prices = CharEncode($('.price_total_' + oid).text());
    window.location.href = "/index.php?route=checkout/confirm/sendorder&total_amount=" + prices + "&order_id=" + toid + "&single_pay=yes";
}

//站内信详情
function webnews(mid) {
    var mid = CharEncode("'" + mid + "'");
    window.open("index.php?route=account/webnews/view&source=1&mid=" + mid);
}

//站内信回复
function pm_reply(mid) {

    msg = $('.rb_textarea').val();
    if (msg == "") {
        $('.red').fadeIn();
    } else {
        $.ajax({
            type: "POST",
			async:false,
            url: "index.php?route=account/webnews/reply",
            data: "title=回复咨询ID：&source=2&" + "&msg=" + msg + "&mid=" + mid,
            success: function() {
				$(".rb_btn").unbind('click');
                location.reload();
            }
        });
    }
}

//站内信删除
function pm_delete(mid) {

    if (mid == "") {
        alert("data error!");
    } else {
        $.ajax({
            type: "GET",
			async:false,
            url: "index.php?route=account/webnews",
            data: "mid=" + mid,
            success: function() {
                location.reload();
            }
        });
    }
}
//我要咨询
function toQuery() {

    msg = $('#query').val();
    if (msg == "") {
        $('#wrong_query').fadeIn();
    } else {
        $('#goQuery').submit();
    }
}

//意见反馈
function opinion() {

    msg = $('#opinion').val();
    if (msg == "") {
        $('.red').fadeIn();
    } else {
        $.ajax({
            type: "POST",
            url: "/index.php?route=account/advisory/insert",
            data: "msg=" + msg + "&question=5",
            success: function() {
                window.location.href = "/index.php?route=account/advisory";
            }
        });
    }
}

//加密函数
var CharEncodechars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
function CharEncode(str) {
    var out, i, len;
    var c1, c2, c3;
    len = str.length;
    i = 0;
    out = "";
    while (i < len) {
        c1 = str.charCodeAt(i++) & 0xff;
        if (i == len) {
            out += CharEncodechars.charAt(c1 >> 2);
            out += CharEncodechars.charAt((c1 & 0x3) << 4);
            out += "==";
            break;
        }
        c2 = str.charCodeAt(i++);
        if (i == len) {
            out += CharEncodechars.charAt(c1 >> 2);
            out += CharEncodechars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
            out += CharEncodechars.charAt((c2 & 0xf) << 2);
            out += "=";
            break;
        }
        c3 = str.charCodeAt(i++);
        out += CharEncodechars.charAt(c1 >> 2);
        out += CharEncodechars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xf0) >> 4));
        out += CharEncodechars.charAt(((c2 & 0xf) << 2) | ((c3 & 0xc0) >> 6));
        out += CharEncodechars.charAt(c3 & 0x3f);
    }
    return out;
}

//显示全部商品
function extra(oid) {
    $(".extra_info_" + oid).toggle();
}

//快递查询
function kuaidi(oid) {

    var myurl = $('.kuaidi_' + oid).attr('url');
    
    //var button = $(this);
    var info_pos = $('.track_' + oid);
    var deliver_info = $('.deliver_info_' + oid);
    //var deliver_info_close = $('#'+oid);
    var deliver_info_close = $('.deliver_info_close_' + oid);
    $('.kuaidi_' + oid).html('关闭信息')

    //已经获取过快递信息 直接显示
    if (deliver_info.data('has_get')) {
        info_pos.slideToggle();
        deliver_info.slideToggle();
        $('.kuaidi_' + oid).html('查看物流/关闭');
    } else {
	deliver_info_close.show();
	info_pos.slideToggle();
	
        $.ajax({
            type: "GET",
            url: myurl,
            dataType: "json",
            success: function(json) {
                           
                deliver_info_close.hide();
                deliver_info.html('');
                deliver_info.html(json);
                deliver_info.data('has_get', true);
                deliver_info.fadeIn();
            },
            error: function() {

                deliver_info.html('');
                alert('网络忙，请稍候重试！');
            }
        });
    }
}
//补填快递信息_dj
function add_express(oid) {
    $('.track_' + oid).slideToggle();
    $(".express_info_" + oid).slideToggle();
}
function bt_express(oid) {
    var express_no = document.getElementById('bt_expressno_' + oid).value;
	express_no=express_no.replace(/\s+/g,"");
	
    var express = document.getElementById('btexpresses_' + oid).value;
    if (express == "*") {
        $(".nonum_" + oid).fadeOut();
        $(".noexpress_" + oid).fadeIn();
    } else if (!express_no) {
        $(".noexpress_" + oid).fadeOut();
        $(".nonum_" + oid).fadeIn();
        //alert("温馨提示：您未提供快递号，请补填，否则将影响订单入库");
    } else {
        if (isNaN(express_no) && express != "ems" && express != "youzhengguonei" && express != "yuantong") {
            $(".noexpress").fadeOut();
            $(".nonum_" + oid).fadeIn();
        } else {
            $.ajax({
                type: "POST",
                url: "index.php?route=order/order/express_rewrite",
                data: "expresses=" + express + "&express_number=" + express_no + "&oid=" + oid,
                success: function() {
                    location.reload();
                }
            });
        }
    }
}
//添加快递信息_zz
function dt_express_add(oid) {
    $('#wl_box_' + oid).fadeIn();
}
function cancelit(oid) {
    $('#wl_box_' + oid).fadeOut();
}
//关键字搜索
function keyworld(type) {
    var keyworld = document.getElementById('keyworld').value;
    window.location.href = "index.php?route=order/order/order_" + type + "&token=<?php echo $token;?>&keyworld=" + keyworld;
}
//筛选显示
function order_change(type) {
    var order_status_id = document.getElementById('filter_order_status_id').value;
    if (type == 'daigou') {
        window.location.href = "index.php?route=order/order&order_status_id=" + order_status_id;
    } else if (type == 'sendorder') {
        window.location.href = "index.php?route=order/sendorder&order_status_id=" + order_status_id;
    } else {
        window.location.href = "index.php?route=order/order/order_" + type + "&order_status_id=" + order_status_id;
    }
}

function search_change(type) {
    window.location.href = "index.php?route=order/order&order_status_id=" + type;
}
function search_change_mall(type) {
    window.location.href = "index.php?route=order/order/mall&order_status_id=" + type;
}

//delete
function dede(l) {
		swal({
		  title: "您确定要取消该订单麽?",
		  text: "取消订单即永久删除,无法找回!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "确定",
		  cancelButtonText: "关闭",
		  closeOnConfirm: false
		},
		function(){
		  $.ajax({
				type: "GET",
				url: "index.php?route=order/order/remove",
				data: "order_dede_id=" + l,
				success: function() {
					location.reload();
					swal("取消!", "该订单已经成功取消", "success");
				}
			});
		});
}
//快递选择
function express_select() {
    var obj = document.getElementById("expresses");
    var index = obj.selectedIndex;
    var value = obj.options[index].value;
    alert(value);
}
//submit前检测
function check() {

	  var express_no = document.getElementById('express_number').value;
  	  express_no=express_no.replace(/\s+/g,"");
	  document.getElementById('express_number').value=express_no;
    var express = document.getElementById('expresses').value;
    var order_daiji_name = document.getElementById('order_daiji_name').value;
    var order_Parcel = document.getElementById('order_Parcel').value;
    if (order_daiji_name == "") {
        $(".nosource").fadeIn();
        return false;
    } else if (order_Parcel == "") {
        $(".nonote").fadeIn();
        $(".nosource").fadeOut();
        return false;
    } else if (isNaN(express_no) && express != "ems" && express != "youzhengguonei" && express != "yuantong") {
        $(".nonum").fadeIn();
    } else {
        if (!express_no) {
            alert("温馨提示：您未提供快递号，请在订单签收前在订单列表补填，否则将影响订单入库");
        }
        alert("温馨提示：您的订单提交成功！可前往代寄订单列表确认。");
        $('#form').submit();
    }
}
//签到
function qiandao(uid, uname) {

    $.ajax({
        type: "GET",
        url: "index.php?route=order/order/qiandao",
        data: "username_id=" + uid + "&uname=" + uname,
        success: function(msg) {
            if (msg == 1) {
                alert('>。<小顽皮，签到太多喽，明天再来吧！');
            } else {
                alert('>。< 签到成功奖励10分！');
            }
        }
    });
}
//答题
function question(l, uname) {

    $.ajax({
        type: "GET",
        url: "index.php?route=order/order/question",
        data: "username_id=" + l,
        success: function(msg) {
            if (msg != 'today') {
                var data = eval(msg);
                document.getElementById('dlg_box').style.display = "block";
                document.getElementById('dlg_bg').style.display = "block";
                var i = Math.floor(Math.random() * 16 + 1);
                newdata = data[i];
                var answer = "";
                $.each(newdata.a,
                        function(k, v) {
                            answer += "<p style='margin-bottom: 8px;'><input type=radio name=a value='" + k + "'>" + v + "</p>"
                        });
                $('#dlg_box_contents').html('<h1 style="margin: 18px -8px 18px;">' + newdata.q + '</h1><form><div style="margin-top:8px;">' + answer + '</div></form><button class="button white small" style="float:right">确定</button>');
                var left = 0 - $('#dlg_box').width() / 2;
                $('#dlg_box').css({
                    marginLeft: '-' + left + 'px'
                });
                $('#dlg_box').find('button').click(function() {
                    var r = $('#dlg_box').find('input[name=a]:checked').val();
					$(this).attr('disabled','true');
                    $.post('/index.php?route=order/order/question2',{answer:r,question_id:i},
                            function(result) {

                                if (result == 'today') {

                                    document.getElementById('dlg_box').style.display = "none";
                                    
                                    swal({
                                          title: "答过了!",
                                          text: "^_^地主家也没有余粮啊,明儿再来吧!", 
                                          timer: 2000
                                        });
                                    
                                    $('#dlg_box').hide('slow',
                                            function() {
                                                $('#dlg_bg').hide()
                                            });
                                } else if (result == 'ok') {
                                    swal({
                                          title: "棒极了!",
                                          text: "^_^高手你答对了,奖励积分10分",
                                          imageUrl: "image/thumbs-up.jpg"
                                        });
                                    
                                    $(self).data('today', true);
                                    $('#dlg_box').hide('slow',
                                            function() {
                                                $('#dlg_bg').hide()
                                            });
                                    answered = "yes";
                                } else {
                                    swal({
										  title: "答错了!",
                                          text: "^_^继续猜，猜对有奖！", 
                                          timer: 2000
                                        });
                                    
                                    $('#dlg_box').hide('slow',
                                            function() {
                                                $('#dlg_bg').hide()
                                            });
                                }
                            },"text");
                });
            } else {
                document.getElementById('dlg_box').style.display = "none";
                swal({
                      title: "答过了!",
                      text: "^_^地主家也没有余粮啊,明儿再来吧!", 
                      timer: 2000
                    })
                
                
            }
        }
    });
}
//答题盒子
$('#dlg_bg').bind('click', function() {
    $('#dlg_box').hide('slow');
    $('#dlg_bg').fadeOut()
})
$('.ui-icon-closethick').bind('click',
        function() {
            $('#dlg_box').hide('slow');
            $('#dlg_bg').fadeOut()
        })
function modify(id){
    $.ajax({
      url:'index.php?route=order/order',
      dataType:"json",
      data:{order_product_id:id,content:$(".beizhu_in"+id).val()},
      type:"POST",
      success:function(req){
        $("#mod"+id).html(' ');
        setTimeout(function(){$("#mod"+id).html(req.msg);},300);
      },
      error:function(){
        alert('<?php echo $text_failed; ?>');
      }
    });
}
//订单拍照
function modify_p(order_id){
   swal({
      title: "确认拍照?",
      text: "订单拍照单张1元,确认后将为您提交申请!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "确认",
      cancelButtonText: "关闭",
      closeOnConfirm: false
    },
    function(){
      $.ajax({
          url:'index.php?route=order/order/reqphoto',
          dataType:"json",
          data:"order_id="+order_id+"&sign=1",
          type:"POST",
          success:function(json){
            if(1 == json) {
                swal({
                  title:"提交成功!",
                  text: "提交订单拍照申请成功!",
                  type: "success",
                  timer: 2000
                });
                window.location.reload();
            }else if(2 == json){
                swal({
                  title:"提交失败!",
                  text: "余额扣除失败，请重试!",
                  type: "error",
                  timer: 2000
                });
            }else if(3 == json){
                swal({
                  title:"提交失败!",
                  text: "余额不足,请充值后再申请!",
                  type: "error",
                  timer: 2000  
                });
            }
          },
          error:function(){
            swal("提交失败!", "提交订单拍照申请失败,请重试!", "error");
          }
        });
    });

}
//订单催促
function modify_c(id){
    $.ajax({
      url:'index.php?route=order/order/pcReq',
      dataType:"json",
      data:{order_id:id,sign:2},
      type:"POST",
      success:function(req){
        $("#c"+id).html(' ');
        setTimeout(function(){
                              $("#c"+id).css("color","green");
                              $("#c"+id).html("<?php echo $text_urged; ?>");
                          },300);
      },
      error:function(){
        alert('<?php echo $text_failed; ?>');
      }
    });
}
/*运单列表相关*/
//评论弹窗
function comment(sid) {
    $('#popup_box').fadeIn();
    $('#sid').val(sid);
    $('#comment_notice').text('优秀长评可额外获赠100积分！');
}

$(function() {
$('.shutup').bind('click',function() {
    $('#popup_box').fadeOut();
    $('#changedelivery_box').fadeOut();
});
//评论提交
$('.submitt input').bind('click',function() {

	var content=$('.popup_content textarea').val();
	var evaluate=$('input[type=radio]:checked').val();
	var manner=$('input[name=manner]').val();
	var delivery=$('input[name=delivery]').val();
	var efficient=$('input[name=efficient]').val();
	var semblance=$('input[name=semblance]').val();

	if(!evaluate){
			alert('请对本次服务评价打分');
			return false;
	}

	if(manner==''||delivery==''||efficient==''||semblance==''){
		alert('满意度有一项没打分');
		return false;
	}
	 if (content == ''){
        $('#comment_notice').text('请输入评价内容！');
		alert('请输入评价内容！');
			return false;
    } 

        $.ajax({
            url: 'index.php?route=order/sendorder/comment',
            type: 'post',
			data: $('.popup_content input[type=\'hidden\'],.popup_content input[type=\'radio\']:checked, .popup_content textarea, .popup_content .comment .male'),
            dataType: 'text',
            success: function(json) {
                $('#comment_notice').text('提交成功！感谢您的参与！');
                setTimeout("$('#popup_box').fadeOut()", 1600);
                window.location.reload();
            },
            error: function(json) {
                $('#comment_notice').text('提交失败，請重试！');
            }
        });
});
});
//补交差价
function payback(sid) {
      $.ajax({
      url:'index.php?route=order/sendorder/payback',
      dataType:"text",
      data:{sid:sid},
      type:"POST",
      success:function(json){
        if(1 == json) {
            swal({
                  title: "补交成功!",
                  type: "success",
                  timer: 2000
                });
            location.reload(); 
        }else if(2 == json){
            swal({
                  title: "补交失败!",
                  text:  "补交差价失败,请联系我们的在线客服补交差价吧!",
                  type: "error",
                  timer: 2000
                });
        }
      },
      error:function(){
        swal({
                  title: "补交失败!",
                  text:  "补交差价失败,请充值后再补交差价吧!",
                  type: "error",
                  timer: 2000
            });
       }
    });  
}

//更改运输方式
function changedelivery(sendorder_id) {
    $("#changedelivery_box").fadeIn();
    $(".changedelivery_shadow").fadeIn();
    $('#de_carrier').html("<div class='loading'><img src='catalog/view/theme/cnstorm/images/loading_data.gif' alt='小C正在卖命的加载，请稍候~~'/></div>");
    var url = 'index.php?route=order/sendorder/change_delivery&sid=' + sendorder_id;
    $('#de_carrier').load(url);
    
}

$(document).on("click",".de_content",function(event) {
    
    $(".de_content").each(function() {
            if ($(this).is(".de_content_selected"))
                $(this).removeClass("de_content_selected");
    });
    $(this).addClass("de_content_selected");
    $(this).find(":radio").prop("checked",true);
});


$(document).on("click",".de_cancel",function(event) {
    
    $("#changedelivery_box").fadeOut();
    $(".changedelivery_shadow").fadeOut();
    
});


$(document).on("click",".de_submit",function(event) {
    
    var did = 0;
    var de_difference = 0.00;
    var sid = $("#sid").val();
    $(".de_content").each(function() {
        if ($(this).is(".de_content_selected"))
            did =  $(this).find("input:radio").val();
            de_difference = $("#de_difference_" + did).val();
    });
   
    
    $.ajax({
      url:'index.php?route=order/sendorder/pay_difference',
      dataType:"text",
      data:{sid:sid,did:did,de_difference:de_difference},
      type:"POST",
      success:function(json){
        if(1 == json) {
            swal({
                  title: "更改成功!",
                  type: "success",
                  timer: 2000
                });
            location.reload(); 
        }else if(2 == json){
            swal({
                  title: "更改失败!",
                  text:  "余额不足，请充值后再更改吧!",
                  type: "error",
                  timer: 2000
                });
                
        }
      },
      
      error:function(){
        swal({
              title: "更改失败!",
              text:  "更改运输方式失败,请联系我们的在线客服帮您更改吧!",
              type: "error",
              timer: 2000
            });
       }
    });  
        
});

//end


function aaa() {

    var search_key = document.getElementById('search_key').value;
    window.location.href = "index.php?route=order/sendorder&consignee=" + search_key;
}

function Confirm(id) {    
    swal({
      title: "确认收货?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "确定",
      cancelButtonText: "关闭",
      closeOnConfirm: false
    },
  
  function() {
    $.ajax({
        url: 'index.php?route=order/sendorder/confirm',
        type: 'get',
        data: 'Confirm_id=' + id,
        dataType: 'text',
        success: function(json) {
            swal({
                  title: "确认成功!",
                  text: "留下评价将获赠运单相应积分噢!",
                  type: "success",
                  timer: 2000
                });
            
            $('#popup_box').fadeIn();
            $('#sid').val(id);
            $('#comment_notice').text('优秀长评可额外获赠100积分！');

        },
        error: function(json) {
            swal({
                  title: "确认失败!",
                  text: "亲~~确认失败,請重试！",
                  type: "error",
                  timer: 2000
                });
            
        }
     });
   });
}


function quxiao(id) {
	swal({
	  title: "您确定要取消该运单麽?",
	  text: "取消运单即永久删除,无法找回!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "确定",
	  cancelButtonText: "关闭",
	  closeOnConfirm: false
	},
	function(){
	  $.ajax({
			type: "GET",
			url: "index.php?route=order/sendorder",
			data: "order_quxiao_id=" + id,
			success: function() {
				location.reload();
				
				swal("取消!", "该运单已经成功取消", "success");
				
			}
		});
	}); 
}