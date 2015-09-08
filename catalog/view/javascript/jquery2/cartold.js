//Writer:Boss Of CNstorm; 
//Email:cnstorm01@cnstorm.com ;  
//Time:2014-07-21
//Description: Cart related.
var getElementsByClassName = function (searchClass, node,tag) {
  if(document.getElementsByClassName){
    var nodes =  (node || document).getElementsByClassName(searchClass),result = [];
      for(var i=0 ;node = nodes[i++];){
        if(tag !== "*" && node.tagName === tag.toUpperCase()){
          result.push(node)
        }
      }
      return result
    }else{
      node = node || document;
      tag = tag || "*";
      var classes = searchClass.split(" "),
      elements = (tag === "*" && node.all)? node.all : node.getElementsByTagName(tag),
      patterns = [],
      current,
      match;
      var i = classes.length;
      while(--i >= 0){
        patterns.push(new RegExp("(^|\\s)" + classes[i] + "(\\s|$)"));
      }
      var j = elements.length;
      while(--j >= 0){
        current = elements[j];
        match = false;
        for(var k=0, kl=patterns.length; k<kl; k++){
          match = patterns[k].test(current.className);
          if (!match)  break;
        }
        if (match)  result.push(current);
      }
      return result;
    }
  }
window.onload = function() {

    var tr = $('.contents'); //行
    var tr2 = $('.shop_name'); //标题行
    var tr3 = $('.bundles'); //内容行
    var selectInputs = $('.check'); // 所有勾选框
    var checkInputs = $('.on2'); // 所有勾选label
    var checkAllInputs = $('.check-all'); // 全选框
    var selectedTotal = $('.product_all'); //已选商品数目容器
    var deleteAll = $('.gs_del'); // 删除全部按钮
    var priceTotal = $('.allPr'); //总计
    var freightTotal = $('.postAge_all'); //总运费

    // 更新总数和总价格，已选浮层
    function getTotal() {
        var selected = 0, price = 0, freight = 0, html = '', buyid = '';

        for (var i = 0; i < tr.length; i++) {

            var isonly = tr.eq(i).find('.bundles').length; //是否唯一
            var freight0 = parseFloat(tr.eq(i).find('em')[0].innerHTML);
            var isselected = tr.eq(i).find('.on2').length; //是否选中

            if (isonly > 1) {
                if (isselected) {
                    for (var k = 0; k < isselected; k++) {

                        var bundles = tr.eq(i).find('.on2')[k]; //内容行

                        var j = 0;
                        if (k + 1 < isselected) {
                            j = k + 1;
                        }

                        var bundles2 = tr.eq(i).find('.on2')[j]; //内容行2

                        if (bundles.getElementsByTagName('em')[0].innerHTML >= bundles2.getElementsByTagName('em')[0].innerHTML) {
                            tr2[i].getElementsByTagName('span')[1].innerHTML = parseFloat(bundles.getElementsByTagName('em')[0].innerHTML);
                        } else {
                            tr2[i].getElementsByTagName('span')[1].innerHTML = parseFloat(bundles2.getElementsByTagName('em')[0].innerHTML);
                        }

                        price += parseFloat(bundles.getElementsByTagName('b')[1].innerHTML); //计算总计价格
                        buyid += bundles.getElementsByTagName('input')[0].value + "#";
                    }
                } else {
                    tr2[i].getElementsByTagName('span')[1].innerHTML = 0;
                }

            } else {

                if (isselected) {

                    tr2[i].getElementsByTagName('span')[1].innerHTML = freight0;
                    buyid += tr[i].getElementsByTagName('input')[0].value + "#";
                    price += parseFloat(tr[i].getElementsByTagName('b')[1].innerHTML); //计算总计价格
                } else {
                    tr2[i].getElementsByTagName('span')[1].innerHTML = 0;
                }
            }

            freight += parseFloat(tr2[i].getElementsByTagName('span')[1].innerHTML); //计算总运费
            //html += '<div><img src="'+tr[i].getElementsByTagName('img')[0].src+'"><span class="del" index="'+i+'">取消选择</span></div>';// 添加图片到弹出层已选商品列表容器
        }

        selectedTotal.innerHTML = checkInputs.length; // 已选数目
        priceTotal.innerHTML = Number(price.toFixed(2)) + Number(freight.toFixed(2)); // 总价含运费
        //freightTotal.innerHTML = freight.toFixed(2); //总运费
        $("#total_amount").attr("value", price.toFixed(2));
        $("#total_freight").attr("value", freight.toFixed(2));
        $("#wanna_buy").attr("value", buyid);
        /*selectedViewList.innerHTML = html;
         if (selected==0) {
         foot.className = 'foot';
         }*/
    }

    // 点击选择框
    for (var i = 0; i < selectInputs.length; i++) {
        selectInputs[i].onclick = function() {

            if (this.className.indexOf('check-all') >= 0) { //如果是全选，则吧所有的选择框选中

                if (this.checked) {
                    for (var j = 0; j < selectInputs.length; j++) {
                        selectInputs[j].checked = this.checked;
                        selectInputs[j].parentNode.getElementsByTagName('label')[0].className = 'check_label on';
                    }
                    for (var k = 0; k < tr3.length; k++) {
                        tr3[k].className = 'bundles on2';
                    }
                } else {
                    for (var j = 0; j < selectInputs.length; j++) {
                        selectInputs[j].checked = this.checked;
                        selectInputs[j].parentNode.getElementsByTagName('label')[0].className = 'check_label';
                    }

                    for (var k = 0; k < tr3.length; k++) {
                        tr3[k].className = 'bundles';
                    }
                }
            }

            else if (this.className.indexOf('shop_check') >= 0) { //如果是店铺全选，则吧店铺下所有的选择框选中

                var shopCheckBoxes = $(this).parent().parent().parent().find('.gwc_choos');
                var bundles = $(this).parent().parent().parent().find('.bundles');
                
                //var shopCheckBoxes = this.parentNode.parentNode.parentNode.getElementsByClassName('gwc_choos');
               // var bundles = this.parentNode.parentNode.parentNode.getElementsByClassName('bundles');
                if (this.checked) {
                    $(this).parent().find('label')[0].className = 'check_label on';
                   // this.parentNode.getElementsByTagName('label')[0].className = 'check_label on';
                    for (var k = 0; k < shopCheckBoxes.length; k++) {
                        bundles[k].className = 'bundles on2';
                        shopCheckBoxes[k].checked = this.checked;
                        shopCheckBoxes[k].parentNode.getElementsByTagName('label')[0].className = 'check_label on';
                    }
                } else {
                    this.parentNode.getElementsByTagName('label')[0].className = 'check_label';
                    for (var k = 0; k < shopCheckBoxes.length; k++) {
                        bundles[k].className = 'bundles';
                        shopCheckBoxes[k].checked = this.checked;
                        shopCheckBoxes[k].parentNode.getElementsByTagName('label')[0].className = 'check_label';
                    }
                }
            }

            else {
                this.parentNode.getElementsByTagName('label')[0].className = "check_label on";
                this.parentNode.parentNode.parentNode.parentNode.className = "bundles on2";
            }

            if (!this.checked) { //只要有一个未勾选，则取消全选框的选中状态

                var shop_All = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                var shop_All= $(this).parent().parent().parent().parent().parent().parent();
                shop_All.find('.shop_check').checked = false;
                shop_All.find('label')[0].className = 'check_label';
                if (this.className == "gwc_choos check") {
                    var bundles = this.parentNode.parentNode.parentNode.parentNode;
                    bundles.getElementsByTagName('label')[0].className = 'check_label';
                    bundles.className = 'bundles';
                }

                for (var i = 0; i < checkAllInputs.length; i++) {
                    checkAllInputs[i].checked = false;
                    checkAllInputs[i].parentNode.getElementsByTagName('label')[0].className = 'check_label';
                }
            }

            getTotal();//选完更新总计
        }
    }


    //为每行元素添加事件
    for (var i = 0; i < tr3.length; i++) {

        //将点击事件绑定到tr元素
        tr3[i].onclick = function(e) {
            var e = e || window.event;
            var el = e.target || e.srcElement; //通过事件对象的target属性获取触发元素
            var cls = el.className; //触发元素的class
            var countInout = this.getElementsByTagName('input')[3]; // 数目input
            var value = parseInt(countInout.value); //数目

            //通过判断触发元素的class确定用户点击了哪个元素
            switch (cls) {
                case 'add': //点击了加号
                    countInout.value = value + 1;
                    getSubtotal(this);
                    break;
                case 'reduce': //点击了减号
                    if (value > 1) {
                        countInout.value = value - 1;
                        getSubtotal(this);
                    }
                    break;
                case 'delete': //点击了删除
                    var conf = confirm('确定删除此商品吗？');
                    if (conf) {
                        this.parentNode.removeChild(this);
                    }
                    break;
            }
            getTotal();
        }
        // 给数目输入框绑定keyup事件
        tr3[i].getElementsByTagName('input')[3].onkeyup = function() {
            var val = parseInt(this.value);
            if (isNaN(val) || val <= 0) {
                val = 1;
            }
            if (this.value != val) {
                this.value = val;
            }
            getSubtotal(this.parentNode.parentNode.parentNode.parentNode); //更新小计
            getTotal(); //更新总数
        }
    }

    // 计算单行价格
    function getSubtotal(tr) {
    	var self = $(tr);
	var productId = self.find(".purchase-quantity").attr("id");
	var customerId = self.find(".purchase-customer-id").val();
	var content = self.find("#beizhu_in").val();
	var url = 'index.php?route=checkout/cart/cart_update';
        var price = tr.getElementsByTagName('b')[0]; //单价
        var subtotal = tr.getElementsByTagName('b')[1]; //小计td
        var countInput = tr.getElementsByTagName('input')[3]; //数目input
        var span = tr.getElementsByTagName('a')[2]; //-号
	var number = countInput.value;
	/*alert(productId);
	alert(number);
	alert(customerId);
	alert(content);*/
        //更新系统数量
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
	            productId: productId,
		    number:number,
		    customerId:customerId,
	            content:content
            },
            timeout: 25000,
            success: function(json) {

            },
            error: function(json) {
            }
        })
        //写入HTML
        subtotal.innerHTML = (parseInt(countInput.value) * parseFloat(price.innerHTML)).toFixed(2);
        //如果数目只有一个，把-号去掉
        if (countInput.value == 1) {
            span.innerHTML = '';
        } else {
            span.innerHTML = '-';
        }
    }

    // 点击全部删除
    deleteAll.onclick = function() {
        if (selectedTotal.innerHTML != 0) {
            swal({
                title: "删除宝贝?",
                text: "确定要删除选中宝贝吗!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: "关闭",
                closeOnConfirm: false
            },
            function() {
                for (var i = 0; i < tr.length; i++) {
                    // 如果被选中，就删除相应的行
                    if (tr[i].getElementsByTagName('input')[0].checked) {
                        tr[i].parentNode.removeChild(tr[i]); // 删除相应节点
                        i--; //回退下标位置
                    }
                }
                $.ajax({
                    type: "POST",
                    url: 'index.php?route=checkout/cart/delcart',
                    dataType: "json",
                    data: $('input[name=\'wanna_buy\']'),
                    timeout: 25000,
                    success: function(json) {
                        window.location.reload();
                    },
                    error: function(json) {

                    }
                });

            });
        } else {
            alert('请选择商品！');
        }
        getTotal(); //更新总数
    }

    // 默认全选
    checkAllInputs[0].checked = true;
    checkAllInputs[0].onclick();

        // 购物车清单超过可视区域则浮动到页面
            if($('#makeorder .bundles').length>0){

            var ele = $('.delete_it'),//固定栏DOM
                boxH = ele.offset().top; 
                
            var scroll = function() {
                ( boxH - $(document).scrollTop() - $(window).height() + ele.height() > 0 ) ? ele.addClass("cart-detail-fixed") : ele.removeClass("cart-detail-fixed");
            };
            $(window).on("scroll", scroll);
            scroll();
        }

}

function deleteproduct(self,customerId) {
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
    function() {
        $.ajax({
            url: 'index.php?route=checkout/cart/cart_delete',
            type: 'post',
            data: {
	    	productId:productId,
		customerId:customerId
	    },
            dataType: 'json',
            success: function(data) {
	        if (1 == data){
	                swal({
                           title: "删除!",
                           text:  "已经删除该宝贝了!",
                           type:  "success"
	                }); 
	                location.reload();
		}
            }
        });

    });

}

function addToWishList1(product_id) {
    $.ajax({
        url: 'index.php?route=account/wishlist/add',
        type: 'post',
        data: 'product_id=' + product_id,
        dataType: 'json',
        success: function(json) {
            if (json['success']) {
                swal({
                          title: "收藏宝贝成功",
                          type:  "success",
                          timer: "2000"
                    }); 
            }
        }
    });
}
function modify(self,productId, number,customerId) {
    var self = $(self);
    var productId = productId;
    var number = number;
    var customerId = customerId;
    var content = self.siblings("#beizhu_in").val();
    var url = 'index.php?route=checkout/cart/cart_update';
    var str = productId.split(":");
    var newProductId = str[0]+":"+str[1]+":"+str[2]+":"+content;
    $.ajax({
        url: url,
        dataType: "json",
        data: {
            productId: productId,
	    number:number,
	    customerId:customerId,
            content:content
        },
        type: "POST",
        success: function(data) {
		if (1 == data){
		   self.parents(".bundles_list").find(".delete-product-cart").attr('data-key',newProductId);
	           swal({
	            	title: "修改成功",
	            	type:  "success",
	            	timer: "1000"
	            }); 
		}else{
		    sweetAlert("修改失败", "", "error");
		}
        },
        error: function() {
            sweetAlert("请求失败", "", "error");
        }
    });
}
