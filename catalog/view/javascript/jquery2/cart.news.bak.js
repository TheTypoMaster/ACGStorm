cnstorm.cart = {
    init: function () {
        $(document).delegate(".check-all", "click", function () {
            if (this.checked) {
                $(".check").each(function (i) {
                    this.checked = true;//所有复选框选中
                });
                $('.check').parent().find("label").attr("class", "check_label on");//所有复选框同级的图片选中
                $(".bundles").attr("class", "bundles on2");//更改背景灰色
            } else {
                $(".check").each(function (i) {
                    this.checked = false;//所有复选框
                });
                $('.check').parent().find("label").attr("class", "check_label");
                $(".bundles").attr("class", "bundles");
            }

            cnstorm.cart.setTotal();//计算总价
        });

        $(document).delegate(".shop_check", "click", function () {
            if (this.checked) {
                $(this).parent().parent().parent().find("input[type=checkbox]").each(function (i) {
                    this.checked = true;
                });

                $(this).parent().parent().parent().find("label").attr("class", "check_label on");//店铺下所有的复选框图片选中
                $(this).parent().parent().parent().find('.bundles').attr("class", "bundles on2");//更改背景灰色
            } else {
                $(this).parent().parent().parent().find("input[type=checkbox]").each(function (i) {
                    this.checked = false;
                });
                $(this).parent().parent().parent().find("label").attr("class", "check_label");//店铺下所有的复选框图片选中
                $(this).parent().parent().parent().find('.bundles').attr("class", "bundles");//更改背景灰色
            }


            //初始化全选复选框
            cnstorm.cart.initSelectAllBox();

            cnstorm.cart.setTotal();//计算总价
        });

        $(document).delegate(".gwc_choos", "click", function () {
            if (this.checked) {
                $(this).parent().find("label").attr("class", "check_label on");//店铺下所有的复选框图片选中
                $(this).parent().parent().parent().parent().find('.bundles').attr("class", "bundles on2");//更改背景灰色
            } else {
                $(this).parent().find("label").attr("class", "check_label");//店铺下所有的复选框图片选中
                $(this).parent().parent().parent().parent().find('.bundles').attr("class", "bundles");//更改背景灰色
            }

            //初始化当前店铺复选框
            var current_no_shop_checked_count = 0;
            $(this).parent().parent().parent().parent().parent().parent().find(".contents .check").each(function (i) {
                if (!this.checked) {
                    current_no_shop_checked_count += 1;
                }
            });
            if (current_no_shop_checked_count == 0) {
                $(this).parent().parent().parent().parent().parent().parent().find(".shop_name label").attr("class", "check_label on");//店铺下所有的复选框图片选中
                $(this).parent().parent().parent().parent().parent().parent().find(".shop_name .check").attr("checked", true);//店铺的复选框
            } else {
                $(this).parent().parent().parent().parent().parent().parent().find(".shop_name label").attr("class", "check_label");//店铺下所有的复选框图片选中
                $(this).parent().parent().parent().parent().parent().parent().find(".shop_name .check").attr("checked", false);//店铺的复选框
            }

            //初始化全选复选框
            cnstorm.cart.initSelectAllBox();

            cnstorm.cart.setTotal();//计算总价

        });

        $(document).delegate(".add", "click", function () {
            $(this).parent().find(".purchase-quantity").val(cnstorm.toInt($(this).parent().find(".purchase-quantity").val()) + 1);
            cnstorm.cart.setSubtotal(this);
            cnstorm.cart.setTotal();//计算总价
        });

        $(document).delegate(".reduce", "click", function () {
            var purchase_quantity = cnstorm.toInt($(this).parent().find(".purchase-quantity").val());
            if (purchase_quantity > 1) {
                $(this).parent().find(".purchase-quantity").val(purchase_quantity - 1);
                cnstorm.cart.setSubtotal(this);
                cnstorm.cart.setTotal();//计算总价
            } else {
                $(this).parent().find(".reduce").text('');
            }
        });

        $(document).delegate(".purchase-quantity", "keyup", function () {
            var purchase_quantity = cnstorm.toInt((this.value));
            if (purchase_quantity <= 0) {
                purchase_quantity = 1;
            }
            $(this).val(purchase_quantity);
            cnstorm.cart.setSubtotal(this);//更新小计
            cnstorm.cart.setTotal();//更新总价
        });



    },
    // 计算单行价格
    setSubtotal: function (tr) {
        var self = $(tr);
        var number = self.parent().parent().parent().find('.purchase-quantity').val(); //数目input
        var price = self.parent().parent().parent().find('.single_price').text(); //单价

        //更新系统数量
        $.ajax({
            type: "POST",
            url: 'index.php?route=checkout/cart/cart_update',
            dataType: "json",
            data: {
                productId: self.parent().find(".purchase-quantity").attr("id"),
                number: number,
                customerId: self.parent().find(".purchase-customer-id").val(),
                content: self.parent().find("#beizhu_in").val()
            },
            timeout: 25000,
            success: function (json) {
            },
            error: function (json) {
            }
        });
        //写入HTML
        self.parent().parent().parent().find('.count_mon').text((parseInt(number) * parseFloat(price)).toFixed(2));//小计

        //如果数目只有一个，把-号去掉

        if (number <= 1) {
            self.parent().find(".reduce").text('');
        } else {
            self.parent().find(".reduce").text('-');
        }
    },
    initSelectAllBox: function () {
        var no_checked_count = 0;

       // alert($("input[type='checkbox'][class='gwc_choos']:checked").length);
        $('.gwc_choos').each(function (i) {
            if (!this.checked) {
                no_checked_count += 1;
            }
        });
        //alert(no_checked_count);
        if (no_checked_count == 0) {
            //全选选中
            $('.check-all').attr("checked", true);
            $('.check-all').parent().find("label").attr("class", "check_label on");
        } else {
            //全选不选中
            $('.check-all').attr("checked", false);
            $('.check-all').parent().find("label").attr("class", "check_label");
        }
    },
    initData: function () {
        $('.check').attr("checked", true);//所有复选框选中
        $('.check').parent().find("label").attr("class", "check_label on");//所有复选框同级的图片选中
        $(".bundles").attr("class", "bundles on2");//更改背景灰色
        cnstorm.cart.setTotal();
    },
    setTotal: function () {
        var price_total = 0;
        var price = 0;
        var freight = 0, freight_ = 0;
        var product_count = 0;
        var buyid = '';
        var shop = "", shopid = "";
        $('.gwc_choos').each(function (i) {
            if (this.checked) {
                product_count += 1;
                price += parseFloat($(this).parent().parent().parent().find(".the_nums .count_mon").text());
                var freight_ = parseFloat($(this).parent().parent().parent().parent().parent().parent().find(".shop_name .shop_admin .postAge_s").text());
                buyid += this.value + "#";
                var shopid = $(this).parent().parent().parent().parent().parent().parent().attr("id");

                if (shop != shopid) {
                    freight += freight_;
                    shop = shopid;
                }

                //alert("shopid:" + id);
                // alert(freight + "===price:" + price);
            }
        });



        price_total = Number(price.toFixed(2)) + Number(freight.toFixed(2)); // 总价含运费
        $("#allPr").text(price_total);
        $("#product_all").text(product_count);//已选商品数目

        $("#total_amount").attr("value", price.toFixed(2));
        $("#total_freight").attr("value", freight.toFixed(2));
        $("#wanna_buy").val(buyid);



    },
    modify: function (self, productId, number, customerId) {
        var self = $(self);
        var productId = productId;
        var number = number;
        var customerId = customerId;
        var content = self.siblings("#beizhu_in").val();
        var url = 'index.php?route=checkout/cart/cart_update';
        var str = productId.split(":");
        var newProductId = str[0] + ":" + str[1] + ":" + str[2] + ":" + content;
        $.ajax({
            url: url,
            dataType: "json",
            data: {
                productId: productId,
                number: number,
                customerId: customerId,
                content: content
            },
            type: "POST",
            success: function (data) {
                if (1 == data) {
                    self.parents(".bundles_list").find(".delete-product-cart").attr('data-key', newProductId);
                    swal({
                        title: "修改成功",
                        type: "success",
                        timer: "1000"
                    });
                } else {
                    alert("修改失败", "", "error")
                    //sweetAlert("修改失败", "", "error");
                }
            },
            error: function () {
                alert("请求失败", "", "error")
                //  sweetAlert("请求失败", "", "error");
            }
        });
    },
    addToWishList1: function (product_id) {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {
                if (json['success']) {
                    swal({
                        title: "收藏宝贝成功",
                        type: "success",
                        timer: "2000"
                    });
                }
            }
        });
    },
    deleteAll: function () {
        // 点击全部删除
        if (cnstorm.toInt($("#product_all").text()) != 0) {
            swal({
                title: "删除宝贝?",
                text: "确定要删除选中宝贝吗!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "关闭",
                closeOnConfirm: false
            }, function () {
//                for (var i = 0; i < tr.length; i++) {
//                    // 如果被选中，就删除相应的行
//                    if (tr[i].getElementsByTagName('input')[0].checked) {
//                        tr[i].parentNode.removeChild(tr[i]); // 删除相应节点
//                        i--; //回退下标位置
//                    }
//                }
                $.ajax({
                    type: "POST",
                    url: 'index.php?route=checkout/cart/delcart',
                    dataType: "json",
                    data: $('input[name=\'wanna_buy\']'),
                    timeout: 25000,
                    success: function (json) {
                        window.location.reload();
                    },
                    error: function (json) {

                    }
                });

            });
        } else {
            alert('请选择商品！');
        }
        // getTotal(); //更新总数
    },
    deleteproduct: function (self, customerId) {
        var self = $(self);
        var productId = $(self).attr("data-key");
        swal({
            title: "删除宝贝?",
            text: "确定要删除该宝贝吗!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
            cancelButtonText: "关闭",
            closeOnConfirm: false
        },
        function () {
            $.ajax({
                url: 'index.php?route=checkout/cart/cart_delete',
                type: 'post',
                data: {
                    productId: productId,
                    customerId: customerId
                },
                dataType: 'json',
                success: function (data) {
                    if (1 == data) {
                        swal({
                            title: "删除!",
                            text: "已经删除该宝贝了!",
                            type: "success"
                        });
                        location.reload();
                    }
                }
            });

        });

    }



};
$(function () {
    cnstorm.cart.init();
    cnstorm.cart.initData();
});
