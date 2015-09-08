<div class="item_cont_r" id="item_info">
  <div class="item_bott">
    <div class="pictures"> <a class="item_pic" href="javascript:void(0);"> <img src="catalog/view/theme/cnstorm/images/brand_story_logo.jpg" alt="brand_story_logo"/> </a> </div>
    <div class="inform">
      <ul class="taobao_shop">
        <li class="price"><span id="price">商品名称：</span>
          <input type="text" id='product_name' name='product_name' placeholder="请输入宝贝名称" value=""/>
        </li>
        <li class="price"><span id="price">商品网站：</span>
          <input type="text" id='product_from' name='product_from' placeholder="请输入宝贝网站" value='' />
        </li>
        <li class="price"><span id="price">商品价格：</span>
          <input type="text" id='searchprice' name='searchprice' placeholder="请输入宝贝价格" value=""/>
          &nbsp;元</li>
        <li class="express"><span>国内运费：</span>
          <input type="text" id='searchfreight' name='searchfreight' value='10'/>
          &nbsp;元 </li>
      </ul>
      <dl class="num ml10">
        <dt>购买数量：</dt>
        <dd>
          <input type="text" id='quantity' name='quantity' value='1' />
          &nbsp;件</dd>
      </dl>
      <dl class="color ml10">
        <dt>颜色：</dt>
        <dd>
          <input type="text" name='searchcolor' value="" />
        </dd>
      </dl>
      <dl class="size ml10">
        <dt>尺码：</dt>
        <dd>
          <input type="text" name='searchsize' value="" />
        </dd>
      </dl>
      <dl class="beizhu ml10">
        <dt>商品备注：</dt>
        <dd>
          <textarea name='note' placeholder="填写商品备注(可以写下您的特殊要求)"></textarea>
        </dd>
      </dl>
      <ul class="gwc_btns">
        <li class="add_gwc"><a id='button-cart-snatch' href="javascript:void(0);">加入购物车</a></li>
        <li class="go_gwc"><a href="javascript:void(0);">去购物车结算</a></li>
      </ul>
      <div id="flyItem" class="fly_item"><img src="catalog/view/theme/cnstorm/images/brand_story_logo.jpg" width="50" height="50" alt="brand_story_logo" /></div>
    </div>
    <div class="CLR"></div>
  </div>
</div>
<script src="catalog/view/javascript/jquery2/parabola.js"></script> 
<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>
<script>
// 加入购物车动态效果;元素以及其他一些变量
var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document.querySelector("#shopCart");

// 抛物线运动
var myParabola = funParabola(eleFlyElement, eleShopCart, {
    speed: 400,
    curvature: 0.002,    
    complete: function() {
		var numberCart = $('#cartCount').text();
		var numberItem = $('.num-pallets-input').val();
		var newtotal = parseInt(numberCart)+parseInt(numberItem);
        eleFlyElement.style.visibility = "hidden";
        eleShopCart.querySelector("em").innerHTML = newtotal;
    }
});
// 绑定点击事件
    $('#button-cart-snatch').bind('click',
    function(e) {
		if(!$('#product_name').val()){
             swal({
                      title: "^_^请输入宝贝名称!",
                      timer: 2000
                  });	
		}else if (!$('#searchprice').val()){
		    swal({
                      title: "^_^请输入宝贝价格!",
                      timer: 2000
                  });    
		}else if (!$('#searchfreight').val()){
		    swal({
                      title: "^_^请输入宝贝运费!",
                      timer: 2000
                  });    
		}else{
		
		if (eleFlyElement && eleShopCart) {
	            // 滚动大小
			e=e||event;
            var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
                scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;

            eleFlyElement.style.left = e.clientX + scrollLeft + 'px';
            eleFlyElement.style.top = e.clientY + scrollTop + 'px';
            eleFlyElement.style.visibility = 'visible';
            
            // 需要重定位
            myParabola.position().move();  
			
        $.ajax({
            url: 'index.php?route=checkout/cart/addsearch',
            type: 'post',
            data: $('.goods_details_bg input[type=\'text\'], .goods_details_bg input[type=\'hidden\'], .goods_details_bg input[type=\'radio\']:checked, .goods_details_bg input[type=\'checkbox\']:checked, .goods_details_bg select, .goods_details_bg textarea'),
            dataType: 'json',
            success: function(json) {
               if (json) {
                     swal({
                      title: "添加宝贝成功!",
                      type: "success",
                      timer: 2000
                    });
                }
            },
            error: function(json) {
              swal({
                      title: "添加宝贝失败!",
                      type: "error",
                      timer: 2000
                    });
            }
        }); 
		}
		}
    });
</script> 
