<?php echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> 代下单</h1>
      <div class="buttons"><a id="button-send" onClick="order()" class="button">下单</a><a href="<?php echo $breadcrumb['href']; ?>" class="button">刷新</a></div>
    </div>
    <div class="content">
      <table id="mail" class="form">
      <tr id='message' style="display:none;">
        <td colspan="2"><span style="float:left;color:red"></span></td>
      </tr>
        <tr>
          <td><span class="required">*</span> 用户昵称：</td>
          <td><input type="text" name="receiver" id="receiver" value="">
            <input type="hidden" name="receiver_id" id="receiver_id" value="" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> 代下单类型：</td>
          <td><select id="type">
              <option value="1">代购</option>
              <option value="2">自助购</option>
              <option value="3">代寄</option>
            </select></td>
        </tr>
		<tr id="tr1">
			<td colspan="2" style="padding-left:0px;">
				<table class="form">
					<tr>
						<td><span class="required">*</span> 商品来源：</td>
						<td><input type="text" name="model" id="model"></td>
					</tr>
					<tr>
						<td><span class="required">*</span> 店铺名称：</td>
						<td><input type="text" name="storename" id="storename" value=""></td>
					</tr>
					<tr>
						<td><span class="required">*</span> 店铺链接：</td>
						<td><input type="text" name="storeurl" id="storeurl" value=""></td>
					</tr>
					<tr>
						<td><span class="required">*</span> 运费：</td>
						<td><input type="text" name="freight" id="freight" value="0.00"></td>
					</tr>
					<tr name="product">
						<td><span class="required">*</span> 商品详情：</td>
						<td>
							<table class="form">
								<tr>
									<td><span class="required">*</span> 商品名称：</td>
									<td><input type="text" name="productname" value=""></td>
								</tr>
								<tr>
									<td> 商品链接：</td>
									<td><input type="text" name="url" value=""></td>
								</tr>
								<tr>
									<td><span class="required">*</span> 价格：</td>
									<td><input type="text" name="price" value=""></td>
								</tr>
								<tr>
									<td><span class="required">*</span> 数量：</td>
									<td><input type="text" name="quantity" value=""></td>
								</tr>
								<tr>
									<td> 颜色：</td>
									<td><input type="text" name="color" value=""></td>
								</tr>
								<tr>
									<td> 尺码：</td>
									<td><input type="text" name="size" value=""></td>
								</tr>
								<tr>
									<td> 备注：</td>
									<td><input type="text" name="remark" value=""></td>
								</tr>
							</table>
						</td>
						<td><a class="button" id="addProduct">增加商品</a><a class="button" id="delProduct">删除商品</a></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr id="tr3" style="display:none;">
			<td colspan="2" style="padding-left:0px;">
				<table class="form">
					<tr>
						<td><span class="required">*</span> 快递公司：</td>
						<td>
							<select name="expresses" id="expresses">
		                    	<option value="*">请选择快递公司</option>
		                    	<?php 
			        	   		foreach ($expresses as $expresse) { ?>
		                      	<option value="<?php echo $expresse['name_en']; ?>"><?php echo $expresse['name_cn']; ?></option>
		                    	<?php } ?>
		                    </select>
						</td>
					</tr>
					<tr>
						<td><span class="required">*</span> 快递单号：</td>
						<td><input type="text" name="express_number" id="express_number" value=""></td>
					</tr>
					<tr>
						<td><span class="required">*</span> 包裹名称：</td>
						<td><input type="text" name="order_daiji_name" id="order_daiji_name" value=""></td>
					</tr>
					<tr>
						<td><span class="required">*</span> 包裹备注：</td>
						<td><input type="text" name="order_Parcel" id="order_Parcel" value=""></td>
					</tr>
				</table>
			</td>
		</tr>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
$('input[name=\'receiver\']').autocomplete({
  delay: 500,
  source: function(request, response) {   
    $.ajax({
      url: 'index.php?route=sale/usertopup/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        json.unshift({
          'receiver_id':  0,
          'receiver':  ' --- 无 --- '
        });
        
        response($.map(json, function(item) {
          return {
            label: item.receiver,
            value: item.receiver_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('input[name=\'receiver\']').val(ui.item.label);
    $('input[name=\'receiver_id\']').val(ui.item.value);
    
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
</script>
<script>
	$(function(){
		$('#type').live('change',function(){
			if (1 == this.value || 2 == this.value) {
				$('#tr1').show();
				$('#tr3').hide();
			} else if (3 == this.value) {
				$('#tr1').hide();
				$('#tr3').show();
			} else {
				return false;
			}
		});
		$('#addProduct').live('click',function(){
			$(this).parent().parent().clone(true).appendTo($(this).parent().parent().parent());
			$(this).parent().parent().each(function(){
				$(this).find("input[type='text']").val("");
			});
		});
		$('#delProduct').live('click',function(){
			$(this).parent().parent().remove();
		});
	});

	function order() {
		if (!confirm('是否确认下单？')) return false;
		var d;
		var products = '';
		// var products = new Array();
		if (1 == $('#type').val() || 2 == $('#type').val()) {//代购 or 自助购
			var x = 0;
			$('tr[name=product]').each(function(){
				// products[x] = new Array();
				var productname = $(this).find('input[name=productname]').val();
				var url = $(this).find('input[name=url]').val();
				var price = $(this).find('input[name=price]').val();
				var quantity = $(this).find('input[name=quantity]').val();
				var color = $(this).find('input[name=color]').val();
				var size = $(this).find('input[name=size]').val();
				var remark = $(this).find('input[name=remark]').val();
				products += productname + '-|-' + url + '-|-' + price + '-|-' + quantity + '-|-' + color + '-|-' + size + '-|-' + remark + '=|=';
				x++;
			});
			products = products.substring(0, products.length-3);
			var model = $('#model').val();
			var receiver_id = $('#receiver_id').val();
			var receiver = $('#receiver').val();
			var type = $('#type').val();
			var storename = $('#storename').val();
			var storeurl = $('#storeurl').val();
			var freight = $('#freight').val();
			if ('' == receiver_id) {
				alert('请先选择用户！');
				return false;
			}
			if ('-|--|--|--|--|--|-' == products) {
				alert('请填写商品详情！');
				return false;
			}
			d = {model:model, receiver_id:receiver_id, receiver:receiver, type:type, storename:storename, storeurl:storeurl, freight:freight, products:products};
			d.num = x;
		} else if (3 == $('#type').val()) {//代寄
			d = {receiver_id:$('#receiver_id').val(), expresses:$('#expresses').val(), express_number:$('#express_number').val(), order_daiji_name:$('#order_daiji_name').val(), order_Parcel:$('#order_Parcel').val(), type:3};
		} else {
			return false;
		}
		console.log(d);
		$.ajax({
			url: "index.php?route=sale/placeorder/order&token=<?php echo $token; ?>",
			type: "POST",
			dataType:'json',
			data: d,
			success: function(data) {
				if(data.indexOf("，") > 0 ) {
					alert(data);
				} else {
					alert(data);
					location.reload();
				}
			}
		});
	}
</script>