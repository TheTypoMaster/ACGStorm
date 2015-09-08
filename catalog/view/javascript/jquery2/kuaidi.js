$('.kuaidi').click(function() {

    var myurl = $(this).attr('url');
    //var button = $(this);
    var index = $('.kuaidi').index($(this));
    var info_pos = $($('.track').get(index));
    var deliver_info = $($('.deliver_info').get(index));
    var deliver_info_close = $($('.deliver_info_close').get(index));

    //关闭其它信息
    $('.track').hide();
    $('.deliver_info_close').hide();
    $('.deliver_info').hide();

    //已经获取过快递信息 直接显示
    if (deliver_info.data('has_get')) {
        info_pos.show();
        deliver_info.slideToggle();
        deliver_info_close.show();
    } else {
        info_pos.slideToggle();
        deliver_info_close.show();

        $.ajax({
            type: "GET",
            url: myurl,
            dataType: "json",
            success: function(json) {

                deliver_info.html('');
                deliver_info.html(json.message);
                deliver_info.data('has_get', true);
                deliver_info_close.html('关闭信息');
                deliver_info.fadeIn();
                deliver_info_close.click(function() {
                    deliver_info.hide();
                    deliver_info_close.hide();
                    $('.track').hide();
                });

                /*if (json.message || json.confirm) {

                    if (json.confirm == 1) {

                        if (json.no) $msg = '单号为' + json.no + '，';
                        else $msg = '';
                        button.siblings('span').html($msg + '<a href=' + json.url + ' target=_blank><font color=red>点击查询</font></a>');
                    } else {

                        //success code
                    }
                } else {

                    deliver_info.html('');
                    alert('网络忙，请稍候重试！');
                }*/
            },
            error: function() {

                deliver_info.html('');
                alert('网络忙，请稍候重试！');
            }
        });
    }
});