<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/plugin.css"/>
    <style type="text/css">
        body{background:#fff;font-size:12px;padding:25px 0 0 0}
        table{font-size:12px;}
        .quickbuy_table #quickbuy_div_one{margin-top:120px}
        .quickbuy_table .send_style #buy_ok{margin-top:120px}
        #quickbuy_div_one .input_border{height:30px;}
        #quickbuy_float .input_border{height:28px;}
    </style>
    <script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.min.js"></script>
<style type="text/css">
    .minus,.plus{margin:0 4px;display:inline-block;width:12px;height:12px;line-height:12px;text-align:center;border:1px solid #dbdbdb;font-family:Arial;font-size:9px;cursor:pointer;background:#FFF;}
    .minus_link a{color:#555;text-decoration:none;}
    .table_edit td{padding-bottom:15px;vertical-align:top;}
    .table_edit th{text-align:right;width:150px;vertical-align:top;line-height:44px}
    .grey_font{color:#bbb}
    .input_button{width:128px; font-family: "微软雅黑"; font-size: 16px; border:1px solid #e04d2f; color:#fff; line-height:38px; background: #fb6e52; border-radius: 3px; cursor: pointer;}
    .input_text{width: 496px; border: 2px solid #fb6e52; border-radius: 3px; line-height: 36px; color: #333; font-size: 14px; font-family: "微软雅黑"; display: inline-block; margin: 2px 4px 0 3px; text-indent: 9px;}
    .input_quickborder{border:2px solid #50a6bd;}
    .input_quicksend{border:0px;height:30px;line-height:30px}
    .property_list ul{width:390px;clear:both;content:'';height:0;display:block;}
    .property_list li{padding:1px;float:left;margin:0 4px 4px 0;position:relative;margin-bottom:5px}
    .property_list li a{cursor:pointer;border:1px solid #BDBDBD;white-space:nowrap;color:#000;display:inline-block;text-align:center}
    .property_list li a:hover{border:2px solid #ff6701;margin:-1px; text-decoration:none}
    .property_list .select a{border:2px solid #ff6701;margin:-1px;background:url(catalog/view/theme/cnstorm/images/icon_select.png) no-repeat right bottom}
    .property_list .property_small li a{padding:0 6px;line-height:20px;min-width:10px}
    .property_list .property_big li a{padding:0 6px;line-height:20px;min-width:32px}
    .property_minicart{border:1px solid #EAEAEA;width:410px;text-align:center;border-top:0px}
    .property_minicart ul{clear:both;border-bottom:1px solid #EAEAEA;padding-left:5px}
    .property_minicart .cartinput_border{border:1px solid #BDBDBD;color:#4B4B4B;height:16px;line-height:16px;padding-left:3px}
    .property_minicart li{float:left;padding:5px 0;overflow:hidden;}
    .property_minicart .mimicart_title{width:235px;overflow:hidden;text-align:left;}
    .property_minicart .mimicart_price{width:60px}
    .property_minicart .mimicart_freight{width:40px}
    .property_minicart .mimicart_number{width:40px}
    .property_minicart .mimicart_edit{float:right;width:70px;}
    #property_minicart_list{min-height:78px;}
    #property_minicart_total{text-align:right;padding-right:10px;padding:5px 5px 5px 0}
    #quickbuy_float{margin-top:10px}
    #quickbuy_float p{margin-top:2px}
   .property_list .property_small li.out-of-stock a,.property_list .property_big li.out-of-stock  a{background-color:#f8f8f8;border:1px dashed #c8c9cd;color:#BDBDBD;cursor:not-allowed;margin:0;}
   .quickbuy_table .green_font{padding:2px 0 2px 20px;background:url(catalog/view/theme/cnstorm/images/icon_reg.gif) no-repeat 0 -62px}
   /*按钮样式*/
   .quickbuy_minus_link .minus {color:#000;width:22px;line-height:26px;height:26px;border: 1px solid #bdbdbd;font-size:20px;margin:0;float: left;}
   .quickbuy_minus_link a.minus:hover{color:#f60;text-decoration:none;}
   .quickbuy_minus_link .input_border{border-radius:0;float:left;text-align:center; border-left:0px;border-right:0px;}
</style>
<div class="quickbuy_table">
    <table class="table_edit" width="100%" id="quickbuy_div_one">
        <tr>
            <th style="width:70px">商品网址：</th>
            <td width="330"><input type="text" name="url" id="url_one" class="input_text" value="<?php echo($url ? $url : ''); ?>" style="width:330px;"/>
                <p id="tips_one" class="grey_font"></p>
            </td>
            <td align="left"><input type="submit" onclick="getinfo($(this).parent().prev().children('input').val())" name="button" id="button" value="获取商品信息" class="input_button"/></td>
        </tr>
        <tr><th style="width:70px"></th><td class="grey_font" colspan="2">
                <b>温馨提示：</b>
                <p>将商品网址粘贴到输入框中点击“获取商品信息”，系统会自动抓取商品的相关信息<br/>
</p>
            </td></tr>
    </table>
    <p id="p_imitation" style="display:none;margin:10px 0px 20px 0px" class="msg_tips"><img align="absmiddle" style="margin-top:-2px"/>&nbsp;温馨提示：您代购的商品中可能含有仿牌和违禁品信息，我们将在审核后为您代购 &nbsp;<a target="_blank">了解详细</a></p>
    <form id="form1" name="form1" >
        <table class="table_edit"  width="100%" id="quickbuy_float" style="display: none">
            <tr>
                <th>商品网址：</th>
                <td >
                    <input type="text" name="url" id="url"  class="input_border" value="" size="60"/>
                    <p id="tips"></p>
                </td>
            </tr>
            <tr>
                <th>商品名称：</th>
                <td>
                    <input type="text" name="title" id="buytitle"  class="input_border"  size="60"/>
                </td>
            </tr>
              <tr id="property_list_1" class="property_list">
                </tr>
                <tr id="property_list_2" class="property_list">
                </tr>
                <tr id="property_list_3" class="property_list">
                </tr>
                <tr id="property_list_4" class="property_list">
                </tr>
                <tr id="property_list_5" class="property_list">
                </tr>
                <tr id="property_list_6" class="property_list">
               </tr>
            <tr>
                <th>商品价格：</th>
                <td>
                    <input type="text" name="price" id="buyprice"  class="input_border" size="30" maxlength="13"/>
                    <p id="buyprice_text" class="dgrey_font">如系统获取的价格有误，可以手动修改</p>

                    <p id="buyprice_text_err" style="display: none;" class="red_font">此商品有促销优惠，请手动填写优惠价格！</p>
                    <a href="#nogo" id="check_item" style="display:none" target="_blank">去淘宝查看价格</a>
                </td>
            </tr>
            <tr>
                <th>国内运费：</th>
                <td>
                    <input type="text" name="freight" id="buyfreight"  class="input_border" size="8" maxlength="7" />
                    <p class="dgrey_font">到 <b>广东(深圳)</b> 的运费，如系统读取的邮费有误，您需要手动修改</p>
                </td>
            </tr>
            <tr id="property_list_1" class="property_list">
            </tr>
            <tr id="property_list_2" class="property_list">
            </tr>
            <tr id="property_list_3" class="property_list">
            </tr>
            <tr id="property_list_4" class="property_list">
            </tr>
            <tr id="property_list_5" class="property_list">
            </tr>
            <tr id="property_list_6" class="property_list">
            </tr>
            <tr id="property_list_count">
                <th>购买数量：</th>
                <td class="quickbuy_minus_link">
                    <a href="#nogo" id="buy_numMis" class="minus">-</a>
                    <input type="text" name="number" id="buy_number"  class="input_border" size="4" maxlength="4" value='1' />
                    <a href="#nogo" id="buy_numAdd" class="minus">+</a>
                </td>
            </tr>
            <tr id="property_list_add" style="display:none;">
                <th></th>
                <td><a  href="#nogo" onclick="add_remark()" class="input_send" style="padding:0 10px;height:24px;line-height:24px;text-decoration:none;">添加到商品清单</a> <span id="buyremark_err_msg" style="color:red"></span></td>
            </tr>
            <tr id="property_list_final" style="display:none;">
                <th>商品清单：</th>
                <td >
                    <div id="property_minicart" class="property_minicart">
                        <ul>
                            <li class="mimicart_title">商品类型</li>
                            <li class="mimicart_price">价格</li>
                            <li class="mimicart_number">数量</li>
                            <li class="mimicart_edit">操作</li>
                        </ul>
                        <div id="property_minicart_list">
                        </div>
                        <ul id="property_minicart_total" style="border-bottom:0">共计：<span class="or_font">0</span> 件</ul>
                    </div>
                </td>
            </tr>
            <tr id="remark_tr">
                <th>商品备注：</th>
                <td>
                    <textarea name="desc" id="desc" cols="61" rows="5" onfocus="this.style.color='#000'" onblur="this.style.color='#999'" style="color:#999;"></textarea>
                    <p style="position:absolute;margin:0px 0 0 348px;font:14px/20px Georgia,Tahoma,Arial" class="grey_font"><span id="desc_count">0/200</span></p>
                    <p class="dgrey_font">商品的颜色、尺寸等要求，请在备注栏填写&nbsp;</p></td>
            </tr>
            <tr id="checkbox_tr" style="display: none;">
                <th></th>
            </tr>
            <tr>
                <th></th>
                <td style="text-align:left">
                    <input type="hidden" name="nick_name" id="nick_name" />
                    <input type="hidden" name="info_url" id="info_url" />
                    <input type="hidden" name="shop_url" id="shop_url" />
                    <input type="hidden" name="pic_url" id="pic_url" />
                    <input type="hidden" name="prifex" id="prifex" />
                    <input type="hidden" name="goods_id" id="goods_id" />
                    <input type="hidden" name="storename" id="storename" />
                    <input type="hidden" name="property" id="property" value="2" />
                    <input type="button" name="btn_batch_send" id="buybtn_batch_send" value="提交" class="input_send" onclick="batch_send_cart();"/>
                    <input type="button" name="btn_send" id="buybtn_send" value="提交" class="input_send" onclick="send_cart();"/>
                    &nbsp;&nbsp;<input type="button" name="btn_cancel" id="btn_cancel" value="返回" class="input_send input_back"/>
                    <span id="error_msg" style="color:red;padding-left:10px"></span>
                </td>
            </tr>
        </table>
    </form>

    <div class="send_style" style="margin-top:15px">
        <table id="quickbuy_ok" style="display:none;" align="center">
            <tr>
                <th><h1 class="icon_ok"></h1></th>
            <td><h2 class="msg_ok">商品已成功添加至购物车！</h2>
                <p>您的购物车里共有&nbsp;<b class="or_font"></b>&nbsp;件商品<!--   合计&nbsp;<b class="or_font"></b>&nbsp;元 -->
                    <br /><a target="_cnstorm" href="index.php?route=checkout/cart">查看购物车并结算</a>&nbsp;&nbsp;<a class="buy_continue" href="#nogo">继续代购</a></p></td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".buy_continue,#btn_cancel").click(function(){
            $("#quickbuy_float").hide();
            $("#p_imitation").hide();
            $("#quickbuy_ok").hide();
            $("#quickbuy_div_one").show();
            $("#url_one").val('');
            $("#tips_one").html('');
            $("#recommend").hide();
        })
        
        var url_one = $("#url_one");
        url_one.focus(function(){
            var tipText="<?php echo($url ? $url : ''); ?>";
            if($(this).val()==tipText){
                $(this).val('');
            }
        });
        
        
        $("#buyprice,#buyfreight").keyup(function(){
            var new_val = $(this).val().replace(/[^\d\.]/g,'');
            if(new_val!=$(this).val()){
                $(this).val(new_val);
            }
        })
        
        $("#buy_number").keyup(function(){
            var new_val = $(this).val().replace(/[^\d]/g,'');
            if(new_val!=$(this).val()){
                $(this).val(new_val);
            }
        })
        
        $("#buy_numAdd").click(function(){
            $("#buy_number").val(parseInt($("#buy_number").val())+1)
        })
        
        $("#buy_numMis").click(function(){
            var val = parseInt($("#buy_number").val());
            if(val>1){
                $("#buy_number").val(parseInt($("#buy_number").val())-1);
            }
        })
        
        $("#desc").click(function(){
            if(jQuery.isEmptyObject(property_str)){
                if($(this).val()=='如您购买的商品含有多种款式、尺寸、颜色，请您根据商品页面上的分类描述，在此备注说明相关款式。'){
                    $(this).val('')
                } 
            }    
        })
    
        $("#desc").blur(function(){
            if(jQuery.isEmptyObject(property_str)){
                if($(this).val()==''){
                    $(this).val('如您购买的商品含有多种款式、尺寸、颜色，请您根据商品页面上的分类描述，在此备注说明相关款式。')
                }
            }
        })
        
        
        
    });
    function getinfo(info_url) {
        var tmp_url = info_url;
        if(info_url == 'undefined' || info_url == '') {
            var inputObj = $("#url_one");
            inputObj.val(tipText2)
            return false;
        //     info_url = encodeURIComponent($('#url').val());
        // } else {
        //     info_url = encodeURIComponent(info_url);
        }
        
        $("#tips_one").html('<img src="catalog/view/theme/cnstorm/images/loading.gif" align="absmiddle">&nbsp;数据抓取中')
        
        $.ajax({
            url : 'index.php?route=product/snatch/iteminfo',
            type : 'post',
            data : {
                url : info_url
            },
            dataType : 'json',
            //timeout : 1000,
            error : function() {
                $("#tips_one").html("<span class='red_font'>系统未能抓取商品相关信息，您需要手动在输入框中填写</span>");
            },
            success : function(result) {
                not_quantity = {};
                skus_list = {};
                promotion_in_item = {};
                property_str = {};
                prop_imgs = {};
                desc_max_length = 200;
                property_desc = '';
                property_total = 0;
                $('#property_minicart_list').html('');
                $('#property_list_1').html('');
                $('#property_list_2').html('');
                $('#property_list_3').html('');
                $('#property_list_4').html('');
                $('#property_list_5').html('');
                $('#property_list_6').html('');
                $('#property_minicart_total .or_font').html('0');
                $('#buybtn_batch_send').hide();
                $('#buybtn_send').show();
                $("#property").val(2);
                $('#buyprice_text_err').hide();
                $('#buyprice_text').show();
                $('#buyprice_text').text('如系统获取的价格有误，可以手动修改');
                $('#buyremark_err_msg').text('');
                $('#property_list_add').hide();
                $('#check_item').hide();
                if(result.prifex!='TB'){
                    $('#remark_tr').hide();
                }else{
                    // $('#remark_tr').show();
                }                
                /*if(result.code != 'sucess'){
                    if(result.err_msg == 'virtual'){
                        $("#tips_one").html('<span class="red_font">暂不支持代购虚拟产品</span>&nbsp;<a target="_blank">查看详细</a>')
                        return false;
                    }else if(result.err_msg == 'blocklist'){
                        $("#tips_one").html('<span class="red_font">根据相关法律法规，我们无法为您代购此商品！</span>&nbsp;<a target="_blank">查看详细</a>')
                        return false;
                    }else if(result.err_msg == 'unsupport'){
                        $("#tips_one").html('<span class="red_font">根据相关法律法规，我们无法为您代购此商品！</span>&nbsp;<a target="_blank">查看详细</a>')
                        return false;
                    }else if(result.err_msg == 'notsupport'){
                        $("#tips_one").html('<span class="red_font">为保证服务质量及售后，暂停此平台订单，建议您挑选其它商家。</span>')
                        return false;
                    }else if(result.err_msg == 'valuable'){
                        $("#tips_one").html('<span class="red_font">根据相关法律法规，我们无法为您代购此商品！</span>&nbsp;<a target="_blank">查看详细</a>')
                        return false;
                    }else if(result.err_msg == 'lowrate'){
                        $("#tips_one").html('<span class="red_font">该店铺信用等级过低！</span>')
                        return false;
                    }
                    else if(result.err_msg == 'notmchaoshi'){
                        $("#tips_one").html('<span class="red_font">受限于海关的政策，暂不支持天猫超市物品！</span>')
                        return false;
                    }
                    else if(result.err_msg == 'stockout'){
                        $("#tips_one").html('<span class="red_font">该商品已下架或被删除！</span>')
                        return false;
                    }
                    else if(result.err_msg == 'is_trade_tb'){
                        $("#tips_one").html('<span class="red_font">您提交的链接地址格式有误！</span>')
                        return false;
                    }
                    else if(result.err_msg == 'dangdangthird'){
                        $("#tips_one").html('<span class="red_font">为保证服务质量及售后，暂停该平台第三方卖家订单，建议您挑选平台自营商品或其他购物平台！</span>')
                        return false;
                    }
                    else{
                        //switch_button_status();                   
                        //alert('系统未能抓取商品相关信息');
                        $('tr[id^="property_list"]').not('#property_list_count').hide();
                        $("#quickbuy_div_one").hide()
                        $("#quickbuy_float").show();
                        $("#tips_one").html('')
                        $("#tips").html("<span class='red_font'>系统未能抓取商品相关信息，您需要手动在输入框中填写</span>");
                        $('#desc').val('如您购买的商品含有多种款式、尺寸、颜色，请您根据商品页面上的分类描述，在此备注说明相关款式。');
                    
                        $("#url,#buytitle,#buyprice,#buyfreight").removeAttr('disabled');
                        $("#url,#buytitle,#buyprice,#buyfreight").val('');
                        if(result.nick){
                            nick = result.nick;
                        }else{
                            var durl= /\.(.*?)\.(.*?)\//g;
                            var parse = tmp_url.match(/^(([a-z]+):\/\/)?([^\/\?#]+)\/*([^\?#]*)\??([^#]*)#?(\w*)$/i);
                            domain = tmp_url.match(durl);
                            if(domain){
                                nick = "www"+domain[0].slice(0,-1);
                            }else{
                                nick = parse[3];
                            }
                        }
                        $('#nick_name').val(nick);
                        $('#info_url,#url').val(tmp_url);
                        $('#shop_url').val(tmp_url);
                        $('#pic_url').val('');
                        $("#prifex").val('OT');
                        $("#goods_id").val(0);
                        return false;
                    }
                }else{
                    if(result.third_shop){
                        if(result.third_shop == 1){
                            $("#tips_one").html('<span class="red_font">为保证服务质量，暂不支持第三方订单！</span>')
                            return false;
                        }
                    }
                    if( result.need_agree ) 
                    {
                        $("#checkbox_tr").show();
                        $("#a_clause").html(result.explain);
                    }*/
                    
                    // if( result.imitation ) 
                    // {
                    //     $("#p_imitation").show();
                    // }
                    
                    $("#quickbuy_div_one").hide()
                    $("#quickbuy_float").show();
                    $("#tips").html("<span class='green_font'>恭喜您，商品信息抓取成功！</span>");
                    $("#buybtn_send").removeAttr('disabled');
                      
                    $('#buytitle').val(result.heading_title);
                    if(result.promotion){
                        $('#buyprice').focus();
                        $('#buyprice').val();//result.price
                        $('#buyprice_text_err').show();
                        $('#buyprice_text_err').text('此商品有促销优惠，请手动填写优惠价格');
                        setTimeout(function(){$('#check_item').attr('href',$("#url").val())},300);
                        $('#check_item').show();
                        $('#buyprice_text').hide();
                    }else{
                        $('#price').val(result.price);
                        $('#buyprice').val(result.price);
                    }
                    if(result.prop_imgs){
                        for(x in result.prop_imgs){
                            prop_imgs[x] = result.prop_imgs[x];
                        }
                    }
                    var property = '';
                    if(result.property && result.property != ''){
                        var i = 0;
                        $('tr[id^="property_list"]').not('#property_list_count').show();
                        $('#remark_tr').hide();
                        $('#desc').val('');
                        for(x in result.property){
                            property = '';
                            i++;
                            property += '<th>'+x+'：</th><td style="padding-bottom:5px">';
                            property_str[x] = '';
                            if(i==1){
                                property += '<ul class="property_small" data-property="'+x+'">';
                            }else{
                                property += '<ul class="property_big" data-property="'+x+'">';
                            }
                            one_options = result.property[x].length == 1;
                            for(y in result.property[x]){
                                property += '<li data-property="'+result.property[x][y]+'" onclick="select_property(this,\''+x+'\');change_m_money(this)"><a><span>'+result.property[x][y]+'</span></a></li>';
                                if( one_options ) {
                                    default_select[result.property[x][y]] = x;
                                }
                            }
                            property += '</ul></td>';
                            $('#property_list_'+i).html(property);
                            $('#property').val(1);
                        }
                        $('#buybtn_batch_send').show();
                        $('#buybtn_send').hide();
                    }else{
                        if(result.prifex!='TB'){
                            $('#remark_tr').hide();
                        }else{
                            $('#remark_tr').show();
                        }
                        
                        $('tr[id^="property_list"]').not('#property_list_count').hide();
                        $('#desc').val('如您购买的商品含有多种款式、尺寸、颜色，请您根据商品页面上的分类描述，在此备注说明相关款式。');
                    }
                    if(result.promotion_in_item){
                        for(x in result.promotion_in_item){
                            promotion_in_item[x] = result.promotion_in_item[x];
                        }
                    }
                    if(result.skus_list){
                        for(x in result.skus_list){
                            skus_list[result.skus_list[x]] = x;
                        }
                    }
                    if(result.not_quantity){
                        for(x in result.not_quantity){
                            not_quantity[result.not_quantity[x]] = 1;
                        }
                    }
                    
                    for(select in default_select) {
                        default_obj = $("li[data-property='"+select+"']");
                        select_property(default_obj, default_select[select]);
                        change_m_money(default_obj);
                    }
                    
                    $('#buyfreight').val(result.isbn);
                    $('#nick_name').val(result.nick);
                    $('#info_url,#url').val(result.search);
                    $('#shop_url').val(result.storeurl);
                    $('#pic_url').val(result.goodsimg);
                    $('#buy_number').val(1);
                    $("#prifex").val(result.prifex);
                    $("#goods_id").val(result.num_iid);
                    $("#storename").val(result.storename);
                    $("#url,#buytitle").attr('disabled','disabled')
                // }
            }
        });
    }
    
    //切换提交按钮的状态
    function switch_button_status(){
        $("#buybtn_send").attr('disabled','disabled');
        $("#form1 input[type='text']").each(function(){
            $(this).keyup(function(){
                var is_all_unempty=true;
                $("#form1 input[type='text']").each(function(){
                    if($.trim($(this).val())==''){
                        is_all_unempty=false;
                    }
                })
                if(is_all_unempty){
                    $("#buybtn_send").removeAttr('disabled');
                }else{
                    $("#buybtn_send").attr('disabled','disabled');
                }
            })
        })
    }
    
    var default_select = {};
    var not_quantity = {};
    var skus_list = {};
    var promotion_in_item = {};
    var prop_imgs = {};
    var property_str = {};
    var desc_max_length = 200;
    var property_desc = '';
    var property_total = 0;
    var size = '';
    var color = '';
    
    function select_property(obj,type){
    
        if('out-of-stock' == $(obj).attr("class")) {
            return false;
        }
        
        $("li[class='out-of-stock']").each(function(i){ $(this).toggleClass('out-of-stock'); });
        
        $('#buyremark_err_msg').text('');
        var tmp_property_str = {};
        for(x in property_str){
            tmp_property_str[x]=property_str[x];
        }
        
        if(!$(obj).is('.select')){
            tmp_property_str[type] = $(obj).text();
        }else{
            tmp_property_str[type] = '';
        }

        size = tmp_property_str['尺码'] ? tmp_property_str['尺码'] : '';
        color = tmp_property_str['颜色分类'] ? tmp_property_str['颜色分类'] : '';
        
        var sku_arr = [];
        for(x in tmp_property_str){
            sku_arr.push(tmp_property_str[x]);
        }
        var tmpsku = '';
        var tmpsku1 = '';
        for(sx in sku_arr){
            tmpsku += sku_arr[sx];
        }
        sku_arr.reverse();
        for(sy in sku_arr){
            tmpsku1 += sku_arr[sy];
        }

        /*if(not_quantity[tmpsku] || not_quantity[tmpsku1]){
            $('#buyremark_err_msg').text('淘宝没货了');
            property_str[type] = '';
            $(obj).siblings().removeClass('select');
            return false;
        }*/
        
        $(obj).siblings().removeClass('select');
        $(obj).toggleClass("select");
        if($(obj).is('.select')){
            property_str[type] = $(obj).text();
        }else{
            property_str[type] = '';
        }
        var property = '';
        for(x in property_str){
            property += x+":"+property_str[x]+' ';
        }
        
        var cut_select_arr = new Array();
        $("li[class='select']").each(function(i){ 
            cut_select_arr[i] = $(this).text();
        });
        for( no_goods in not_quantity ){
            tmp_selector = no_goods;
            for(k in cut_select_arr) {
                tmp_selector = tmp_selector.replace(cut_select_arr[k], '');
            }
            $("li[data-property='"+tmp_selector+"']").toggleClass('out-of-stock');
        }
    }
    
    function change_m_money(obj){
        if('out-of-stock' == $(obj).attr("class")) {
            return false;
        }
        var sku_arr = [];
        for(x in property_str){
            sku_arr.push(property_str[x]);
        }
        
        var tmpsku = '';
        var tmpsku1 = '';
        for(cx in sku_arr){
            tmpsku += '_' + sku_arr[cx];
        }
        if (tmpsku.length>0) {
            tmpsku = tmpsku.substr(1, tmpsku.length);
        }
        sku_arr.reverse();
        for(cy in sku_arr){
            tmpsku1 += '_' + sku_arr[cy];
        }
        if (tmpsku1.length>0) {
            tmpsku1 = tmpsku1.substr(1, tmpsku1.length);
        }
        // alert(promotion_in_item[tmpsku]);
        var tmp_price = $('#buyprice').val();
        if(promotion_in_item[tmpsku]){
            mm_price = parseFloat(promotion_in_item[tmpsku]);
            if(mm_price>0){
                $('#buyprice').val(mm_price);
                return true;
            }else{
                if(mm_price != 0){
                    $('#buyprice').val('');
                }
            }
        }else if(promotion_in_item[tmpsku1]){
            mm_price = parseFloat(promotion_in_item[tmpsku1]);
            if(mm_price>0){
                $('#buyprice').val(mm_price);
                return true;
            }else{
                if(mm_price != 0){
                    $('#buyprice').val('');
                }
            }
        }
        return false;
    }
    
    function add_remark(){
        var property = '';
        var flag = true;
        $('#buyprice_text_err').show();
        $('#buyremark_err_msg').text('');
        var tmp_price = $("#buyprice").val();
        if(tmp_price<=0){
            $("#buyprice").focus();
            $('#buyprice_text_err').text('请输入商品价格');
            $('#buyprice_text').hide();
            return false;
        }else{
            $('#buyprice_text_err').text('');
            $('#buyprice_text_err').hide();
            $('#buyprice_text').text('如系统获取的价格有误，可以手动修改');
            $('#buyprice_text').show();
        }
        var tmp_freight = $("#freight").val();
        if(tmp_freight == ''){
            $("#buyfreight").focus();
            $('#buyremark_err_msg').text('请输入国内运费');
            return false;
        }
        var prop_img = '';
        var sku_arr = [];
        for(x in property_str){
            if(property_str[x] == ''){
                flag = false;
                break;
            }
            property += x+":"+property_str[x]+' ';
            sku_arr.push(property_str[x]);
            if(prop_imgs[property_str[x]]){
                prop_img = prop_imgs[property_str[x]];
            }
        }
        
        var atmpsku = '';
        var atmpsku1 = '';
        for(ax in sku_arr){
            atmpsku += sku_arr[ax];
        }
        sku_arr.reverse();
        for(ay in sku_arr){
            atmpsku1 += sku_arr[ay];
        }
        
        var sku=0;
        if(skus_list[atmpsku]){
            sku = skus_list[atmpsku];
        }else if(skus_list[atmpsku1]){
            sku = skus_list[atmpsku1];
        }else{
            sku = 0;
        }
        
        $('#buyremark_err_msg').text('');
        if(flag == false){
            $('#buyremark_err_msg').text('请选择'+x);
            return false;
        }
        var tmp_number = $("#buy_number").val();
        if(tmp_number<=0){
            $("#buy_number").focus();
            $('#buyremark_err_msg').text('请输入数量');
            return false;
        }
        tmp_price = parseFloat(tmp_price);
        tmp_freight = parseFloat(tmp_freight);
        var remark='';
        if($("#prifex").val()=='AL'){
            remark=property;
        }
        
        $('#property_minicart_list').append('<ul>\n\
<li class="mimicart_title" name="mimicart_title" style="height:16px;overflow:hidden" remark="'+remark+'" title="'+property+'">'+property+'</li>\n\
<li class="mimicart_title mimicart_title_edit" name="mimicart_title_edit" style="display:none" >\n\
<span>'+property+'</span>\n\
<textarea class="mimicart_title_edit" name="ta_title_edit" style="border:1px solid #ccc;padding:2px;width:225px;font-size:12px;height:15px;" title="可以告诉我们您对商品的特殊要求，如：颜色、尺码等"></textarea>&nbsp;\n\
<a href="#nogo" name="confirmed" onclick="confirmed_edit(this)">确定</a>&nbsp;\n\
<a href="#nogo" name="cancel" onclick="cancel_edit(this)">取消</a></li>\n\
<li class="mimicart_pic" name="mimicart_pic" style="display:none;"><span name="pic">'+prop_img+'</span></li>\n\
<li class="mimicart_price" name="mimicart_price"><span name="price">'+tmp_price.toFixed(2)+'</span></li>\n\
<li class="mimicart_freight" name="mimicart_freight" style="display:none"><span name="freight">'+tmp_freight.toFixed(2)+'</span></li>\n\
<li class="mimicart_number" name="mimicart_number"><span name="number">'+tmp_number+'</span></li>\n\
<li class="mimicart_skus" name="mimicart_skus" style="display:none"><span name="skus">'+sku+'</span></li>\n\
<li class="mimicart_edit" name="mimicart_edit"><a href="#nogo" onclick="property_desc_delete(this)">删除</a></li></ul>');
        $("#buy_number").val(1);
        /*
        $("tr[id^='property_list'] li").removeClass('select');
        for(x in property_str){
            property_str[x]='';
        }
         */
        property_desc_length();
    }
    
    function property_desc_length(){
        property_desc = '';
        property_total = 0;
        $('#property_minicart_list ul').each(
        function(){
            property_total += parseInt($(this).find('span[name="number"]').text());
            property_desc += $(this).find('li[name=mimicart_title]').text()+"\n";
        }
    );
        $('#property_minicart_total .or_font').html(property_total);
        return property_desc.length;
    }
    
    function property_desc_delete(obj){
        $(obj).parent().parent().remove();
        desc_max_length = 200-property_desc_length();
        $('#desc').keyup();
    }
    
    function check_form(){
        var is_all_unempty=true;
        $("#form1 input[type='text']").not(":disabled").each(function(){
            if($.trim($(this).val())==''){
                is_all_unempty=false;
                return false;
            }
        })
        return is_all_unempty;
    }

    function send_cart() {
        
        $("#error_msg").text('');
        
        if( $("#checkbox_tr").is(":visible") && !document.getElementById("agree_chk").checked ) {
            $("#error_msg").text("您还未接受购买协议");
            return false;
        }
        
        if(!check_form()){
            $("#error_msg").text("请填写完整的商品信息");
            return false;
        }
        //var freight=$("#quickbuy_float input[name='freight']").val();
        var price=$("#quickbuy_float input[name='price']").val();
        if(jQuery.isEmptyObject(property_str)){
            var number=$("#quickbuy_float input[name='number']").val();
        }else{
            var number=property_total;
        }
        //alert(price+' '+number);
        if(price==0){
            $("#error_msg").text("商品单价不能为0");
            return false;
        }
        
        if(number==0){
            $("#error_msg").text("购买数量不能为0");
            return false;
        }
        
        $.ajax({
            url : 'index.php?route=plugin/cnstormassist/add',
            type : 'post',
            data : {
                title : $('#buytitle').val(),
                price : $('#buyprice').val(),
                freight : $('#buyfreight').val(),
                nick_name : $('#nick_name').val(),
                info_url : $('#info_url').val(),
                number : number,
                desc : property_desc+$('#desc').val().replace(/如您购买的商品含有多种款式、尺寸、颜色，请您根据商品页面上的分类描述，在此备注说明相关款式。/,''),
                shop_url : $('#shop_url').val(),
                pic_url : $('#pic_url').val(),
                prifex:$("#prifex").val(),
                goods_id:$("#goods_id").val(),
                property:$("#property").val(),
                storename : $("#storename").val()
            },
            dataType : 'json',
            //timeout : 1000,
            error : function() {
                $("#error_msg").text("网络繁忙，请稍候重试。");
            },
            success : function(result) {
                if(result.msg == 'err'){
                    $("#error_msg").text("添加失败,请重试");
                    return false;
                }
                //$("#dialog table").hide();
                
                $("#quickbuy_div_one").hide();
                $("#quickbuy_float").hide();
                $("#p_imitation").hide();
                $("#quickbuy_ok").show();
                //alert(result.info.count);
                $("#quickbuy_ok .or_font").eq(0).text(result.info.count);
                $("#recommend").show();
            }
        });
    }
    
    function batch_send_cart() {
        
        $("#error_msg").text('');
        if( $("#checkbox_tr").is(":visible") && !document.getElementById("agree_chk").checked ) {
            $("#error_msg").text("您还未接受购买协议");
            return false;
        }
        
        if(property_total<=0){
            $('#buyremark_err_msg').text('请选择你要购买的商品');
            return false;
        }
        
        var batch_data = {
            title : $('#buytitle').val(),
            nick_name : $('#nick_name').val(),
            info_url : $('#info_url').val(),
            shop_url : $('#shop_url').val(),
            pic_url : $('#pic_url').val(),
            prifex:$("#prifex").val(),
            goods_id:$("#goods_id").val(),
            property:$("#property").val(),
            t_freight:$("#buyfreight").val(),
            storename : $("#storename").val(),
            item:{}
        };
        $('#property_minicart_list ul').each(
        function(i){
            price = parseFloat($(this).find('span[name="price"]').text());
            sac = $(this).find('li[name=mimicart_title]').attr('title');
            freight = parseFloat($(this).find('span[name="freight"]').text());
            number = parseFloat($(this).find('span[name="number"]').text());
            desc = $(this).find('li[name=mimicart_title]').attr('remark');
            pic = $(this).find('li[name=mimicart_pic]').text();
            skus = $(this).find('li[name=mimicart_skus]').text();
            if(price==0){
                alert('商品单价不能为0');
                return false;
            }
        
            if(number==0){
                alert('购买数量不能为0');
                return false;
            }

            // sac = '尺码:39 颜色分类:黄色';
            var size = '';
            var color = '';
            if (sac.indexOf('尺码:') != -1 && sac.indexOf('颜色分类:') != -1) {
                size = sac.substring(sac.indexOf('尺码:')+3, sac.indexOf('颜色分类:'));
                color = sac.substring(sac.indexOf('颜色分类:')+5, sac.length);
            } else if (sac.indexOf('尺码:') != -1 && sac.indexOf('颜色分类:') == -1) {
                size = sac.substring(sac.indexOf('尺码:')+3, sac.length);
            } else if (sac.indexOf('尺码:') == -1 && sac.indexOf('颜色分类:') != -1) {
                color = sac.substring(sac.indexOf('颜色分类:')+5, sac.length);
            }
            
            batch_data['item'][i] = {
                pic : pic,
                price : price,
                freight : freight,
                number : number,
                skus : skus,
                size : size,
                color : color,
                desc : desc+$('#desc').val().replace(/如您购买的商品含有多种款式、尺寸、颜色，请您根据商品页面上的分类描述，在此备注说明相关款式。/,'')
            };
        }
    );
        $.ajax({
            url : 'index.php?route=plugin/cnstormassist/batchadd',
            type : 'post',
            data : batch_data,
            dataType : 'json',
            //timeout : 1000,
            error : function() {
                $("#error_msg").text("网络繁忙，请稍候重试。");
            },
            success : function(result) {
                if(result.msg == 'err'){
                    var info=result.info?result.info:'添加失败,请重试';
                    alert(info);
                    return false;
                }
                //$("#dialog table").hide();
                $("#quickbuy_div_one").hide();
                $("#quickbuy_float").hide();
                $("#p_imitation").hide();
                $("#quickbuy_ok").show();
                //alert(result.info.count);
                $("#quickbuy_ok .or_font").eq(0).text(result.info.count);
                $(window.parent.document).find("#shopCart").html("("+result.info.count+")");
                $(window.parent.document).find("#shopCart2 em").html(result.info.count);
                $("#recommend").show();
            }
        });
    }
    
    $("#desc").keyup(function(){
        $("#desc_count").html(""+$("#desc").val().length+"/"+(desc_max_length-$("#desc").val().length));
        if ($("#desc").val().length>=desc_max_length){
            $("#desc").val($("#desc").val().substr(0,desc_max_length));
            $("#desc_count").html(""+$("#desc").val().length+"/0");
        }
    })
    function cancel_edit(obj){
        $(obj).parent().hide();
        var title_obj = $(obj).parent().siblings('li[name=mimicart_title]');
        title_obj.show();
        title_obj.attr('toggle','false');
        var t = $(obj).siblings('textarea[name=ta_title_edit]');
        t.val(title_obj.html());
    }
    function confirmed_edit(obj){
        $(obj).parent().hide();
        var t = $(obj).siblings('textarea[name=ta_title_edit]');
        var title_obj = $(obj).parent().siblings('li[name=mimicart_title]'); 
        var sku_text = $(obj).parent().find('span').text()
        //alert(sku_text);
        title_obj.html(sku_text+t.val());
        title_obj.show();
        title_obj.attr('toggle','false');
        title_obj.attr('title',sku_text+t.val());
        title_obj.attr('remark',t.val());
    }
    $('div').click(function(){
        $('textarea[name=ta_title_edit]').attr('style','border:1px solid #ccc;padding:2px;width:225px;font-size:12px;height:15px;overflow:hidden');
    });
    // $('textarea[name=ta_title_edit]').live('click',function(){
    //     $(this).attr('style','border:1px solid #ccc;padding:2px;width:225px;font-size:12px;height:60px');
    // });
    
</script>