<?php echo $header; ?>
<script src="view/javascript/artdialog/dialog-min.js"></script>
<link rel="stylesheet" href="view/javascript/artdialog/ui-dialog.css" />
<link rel="stylesheet" href="view/stylesheet/nt/dialog.css" />

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <tbody>
          <tr class="filter">
            <td><a href="javascript:location.reload();"><img src="view/image/refresh.gif" alt="刷新" width="28" height="20"/></a></td>
            <td align="center" style="width: auto;"><?php echo $column_order_id; ?>:<input type="text" name="filter_order_id" value="" size="15" style="text-align: right;" />
              <a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            <td align="center" style="width: auto;"><?php echo $column_customer; ?>:<input type="text" name="filter_customer" value="" size="15"/>
              <a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            <td align="center">
              <?php echo $order_express_id; ?>:
              <input type="text" name="filter_sn" id="addtracking" value="" size="15"/>
              <a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            <td align="center">按时间筛选：<input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" class="date" />
              <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" size="12" class="date" />
			  <a onclick="filter();" class="button" _hover-ignore="1" _orighref="" _tkworked="true">筛选</a>
			  </td>
            <td align="center"><?php echo $order_product; ?>:
            <input type="text" name="filter_product_name" value="<?php echo $filter_product_name; ?>" size="12" />
            <a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
                        <td align="center" style="width: auto;"><select name="filter_order_status_id">
                <option value="">订单状态</option>
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
				
                <?php } ?>
				<option value="10">待取消</option>
              </select>
            <select name="auction_id">
                <option value="">请选择拍货员ID</option>
                <option value="cnstorm2011">cnstorm2011</option>
                <option value="cnstorm2013">cnstorm2013</option>
                <option value="cnstorm2016">cnstorm2016</option>
              </select>
              &nbsp;&nbsp;<a onclick="$('#form').attr('action', '<?php echo $update_order; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><?php echo $order_update2; ?></a></td>
          </tr>
      </table>
      <!--详细内容-->
      <table class="list">
        <thead>
          <tr>
            <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="center"><?php if ($sort == 'o.order_id') { ?>
              <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
              <?php } ?></td>
            <td class="center"><?php if ($sort == 'customer') { ?>
              <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
              <?php } ?></td>
            <td class="center" style='width:16%;'><?php echo $order_product; ?></td>
	    <td class="center">订单来源</td>
            <td class="center">单价</td>
            <td class="center">数量</td>
            <td class="center" title="商品总价=商品单价X商品数量">总价/修改</td>
            <td class="center">重量</td>
            <td class="center"><?php echo $order_express_id; ?></td>
            <td class="center"><?php echo $order_company; ?></td>
            <td class="center"><?php echo $order_auction; ?></td>
            <td class="center" style='width:5%'>状态</td>
            <td class="center"><?php echo $column_action; ?></td>
            <td class="center" title="取所属商品运费最大值">总运费/修改</td>
            <td class="center"><?php if ($sort == 'o.total') { ?>
              <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>" title="订单总价=商品总价+订单运费">总价/修改</a>
              <?php } else { ?>
              <a href="<?php echo $sort_total; ?>" title="订单总价=商品总价+订单运费">总价/修改</a>
              <?php } ?></td>
            <td class="center"><?php if ($sort == 'o.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
           
            <td class="center"><?php if ($sort == 'o.date_modified') { ?>
              <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
              <?php } ?></td>
            <td class="center"><?php if ($sort == 'status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>">订单状态</a>
              <?php } else { ?>
              <a href="<?php echo $sort_status; ?>">订单状态</a>
              <?php } ?></td>
           
          </tr>
        </thead>
        <?php if ($orders) {  
       foreach ($orders as $order) {    
      ?>
        <tr>
          <td style="text-align: center;"><?php if ($order['selected']) { ?>
            <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
            <?php } ?></td>
          <td class="center"><?php echo $order['order_id']; ?></td>
          <input type="hidden" name="orderid" value="<?php echo $order['order_id']; ?>" id="orderid"/>


            <td class="left" colspan=17><?php echo $order_user;?>
              <a href="<?php echo $emali ;?>&order_id=<?php echo $order['order_id']; ?>&user=<?php echo $order['firstname'];?>" 
	      target="_blank" onclick="openwindow(this.href,'','width=530,height=525');return false"><?php echo $order['firstname'];?>
              </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order_Business ?>:&nbsp;
              <a href="<?php echo $order['store_url'] ;?>" target="_blank"><?php echo $order['store_name'] ?></a> 
              <?php if ($order['preq'] == 1 ) { ?>
                <span onclick="modify_p(<?php echo $order['order_id']; ?>)" id="p<?php echo $order['order_id']; ?>">
		<span style="color:red;cursor:pointer;">用户已发送拍照请求</span></span>
              <?php }elseif ($order['preq'] == 3 ) { ?>
                <span><span style="color:green;">订单拍照请求已处理</span></span>
              <?php } ?>
              <?php if ($order['creq'] == 2 ) { ?>
                <span onclick="modify_c(<?php echo $order['order_id']; ?>)" id="c<?php echo $order['order_id']; ?>">
		<span style="color:red;cursor:pointer;">用户已发送采购请求</span></span>
              <?php }elseif ($order['creq'] == 3 ) { ?>
               <span><span style="color:green;">采购催促请求已处理</span></span>
              <?php } ?>
              <?php if(1 == $order['order_status_buy']) {  ?>
              <input type="button" onClick="modify_order('<?php echo $order['customer_id'];?>',<?php echo $order['order_id']; ?>)" 
	      value="<?php echo $order_modification;?>" style="cursor:pointer;background:none repeat scroll 0% 0% #FFDB3D;"/>
              <?php } ?>
	      
	     <?php if ($order['totalProduct']>1){ ?>
	      <input type="button" onClick="modify_weight(<?php echo $order['totalProduct']; ?>,<?php echo $order['order_id']; ?>,'weight')" 
	      value="批量修改 重量" style="cursor:pointer;background:none repeat scroll 0% 0% #FFDB3D;"/>
	      <input type="button" onClick="modify_weight(1,<?php echo $order['order_id']; ?>,'kuaidi_no')" 
	      value="批量修改 快递号" style="cursor:pointer;background:none repeat scroll 0% 0% #FFDB3D;"/>
	      <input type="button" onClick="modify_weight(1,<?php echo $order['order_id']; ?>,'order_sensitive')" 
	      value="批量修改 敏感性" style="cursor:pointer;background:none repeat scroll 0% 0% #FFDB3D;"/>
	      <?php } ?>
	      
	      <span>订单商品数:<strong><?php echo $order['totalProduct']; ?></strong></span>
		  <input type="button" value="备注" seller="<?php echo $order['store_name'] ?>" snum="<?php echo $order['totalProduct']; ?>" alt="<?php echo $order['remarks']; ?>" auser="<?php echo $order['firstname'];?>" oid="<?php echo $order['order_id']; ?>" <?php if($order['remarks']){ ?> style="background-color:#FFDB3D;" <?php } ?>onclick="displaybz(this)"/>
            </td>
            

        </tr>
        <?php $i=0;?>
        <?php foreach ($order['product'] as $orde_product) {  ?>
        <tr>
          <td ></td>
          <td ></td>
          <td class="right"></td>
          <td class="left" style="width: 398px;">
          <?php if(3 == $order['order_status_buy']) { ?>
          <a id="purl<?php echo $orde_product['order_product_id']; ?>">
          <?php }else{ ?>
          <a id="purl<?php echo $orde_product['order_product_id']; ?>" href="<?php echo $orde_product['producturl'] ;?>" target="_blank">
          <?php }  ?>
          <?php echo $orde_product['name']?></a> 
	  <span style="float:right;">
		<a data-type="0" biz-itemid="<?php echo $orde_product['product_id'] ;?>" data-tmpl="60x25" data-tmplid="623" data-rd="2" data-style="2" data-border="0"></a>
	  </span> <br/>
          
            
            <?php if(isset($orde_product['color'])){
         echo $order_color."<span id='pcolor".$orde_product['order_product_id']."'>".$orde_product['color']."&nbsp;&nbsp;";
        }?> 
        </span>
        <?php if(isset($orde_product['size'])){
             echo $order_size."<span id='psize".$orde_product['order_product_id']."'>".$orde_product['size']."<br/>";
        } ?>
        </span>
        <?php if(isset($orde_product['text'])){
            echo $order_remark."<span id='pnote".$orde_product['order_product_id']."'>".$orde_product['text'];
        } ?>
        </span>
        </td>
	<?php if (1 == $order['store_id']){ ?>
		<td >app</td>
	<?php }else{ ?>
		<td >网站</td>
	<?php } ?>
          <td class="center" id="pcost<?php echo $orde_product['order_product_id']; ?>"><?php echo $orde_product['price'] ;?></td>
          <td class="center" id="pqty<?php echo $orde_product['order_product_id']; ?>"><?php echo $orde_product['quantity'];?></td>
          <td class="center"><?php echo $orde_product['total'];?>/<i style="color:red"><?php if((float)$orde_product['difference']) {echo $orde_product['difference'];}?></i></td>
         
          <td class="center"><input type="text" size="4" class="weight<?php echo $order['order_id']; ?>" id='weight<?php echo $orde_product['order_product_id']; ?>' value="<?php echo $orde_product['weight'];?>" onchange="weight('<?php echo $orde_product['order_product_id'];?>')"></td>
          <td class="right"><input type="text" class="kuaidi_no<?php echo $order['order_id']; ?>"  onchange="tracking_number('<?php echo $orde_product['order_product_id']; ?>')" id="tracking<?php echo $orde_product['order_product_id']; ?>" value="<?php echo $orde_product['tracking_number']; ?>"></td>
          <td class="right"><select name="express_change" id="express_change<?php echo $orde_product['order_product_id']; ?>">
              <option value="0"><?php echo $order_express_Select; ?></option>
              <?php foreach ($order['express'] as $express) { ?>
              <?php if ($express['name_en'] == $orde_product['express']) { ?>
              <option value="<?php echo $express['name_en']; ?>" selected="selected"><?php echo $express['name_cn']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $express['name_en']; ?>"><?php echo $express['name_cn']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            </br>
            <input type="button" value="<?php echo $order_express_change;?>" onclick="express(<?php echo $orde_product['order_product_id']; ?>)"></td>
          <td class="center"><?php echo $orde_product['payid']; if ($order['order_status_buy'] == 2){ ?>
            <span style="color:red;font-weight: bold;">自助购订单</span>
            <?php }else if ($order['order_status_buy'] == 3){ ?>
            <span style="color:red;font-weight: bold;">代寄订单</span>
            <?php } ?></td>


          <td class="center">
	  <a style="text-decoration:none;" href="javascript:;">
	  <font color='<?php if($orde_product['order_sensitive']==2){echo "red";}else{echo "#0092d2";}?>' 
	  id='order_sensitive<?php echo $orde_product['order_product_id']; ?>' 
	  onClick="addState('<?php echo $orde_product['order_product_id']; ?>','order_sensitive')">
          <?php if($orde_product['order_sensitive']==2){        
		echo $order_Sensitive;        
          }else{        
		echo $order_notSensitive;         
          }?>
          </font>
	  <input type="hidden" class="order_sensitive<?php echo $order['order_id']; ?>"  value="<?php echo $orde_product['order_sensitive']; ?>">
	  </a></br>
          <a style="text-decoration:none;" href="javascript:;">
	  <font color='<?php if($orde_product['order_branding']==2){echo "red";}else{echo "#0092d2";} ?>' 
	  id='order_branding<?php echo $orde_product['order_product_id']; ?>'  
	  onClick="addState('<?php echo $orde_product['order_product_id']; ?>','order_branding')">
	  <?php if($orde_product['order_branding']==2){         
	     echo $order_nameplate;        
	  }else{
	     echo $order_nonameplate;      
	  }?>
	  </font></a></br>
	  <a style="text-decoration:none;" href="javascript:;"> 
	  <font color='<?php if($orde_product['order_huge']==2){echo "red";}else{echo "#0092d2";} ?>' 
	  id='order_huge<?php echo $orde_product['order_product_id']; ?>'  
	  onClick="addState('<?php echo $orde_product['order_product_id']; ?>','order_huge')">
	  <?php if($orde_product['order_huge']==2){     
	     echo $order_notrethrowing;      
	  }else{         
	     echo $order_rethrowing;
	  }?>
	  </font></a></br>
	  </td>  


          <td class="center">
          <?php if(1 == $order['order_status_buy']) {  ?>
          <input type="button" onClick="modify_order_product(<?php echo $orde_product['order_product_id']; ?>,<?php echo $order['customer_id'];?>,'<?php echo $order['firstname'];?>',<?php echo $order['order_id']; ?>)" value="<?php echo $order_modification;?>" style="cursor:pointer">
          <?php }  ?>
	  <input type="button" onClick="delete_order(<?php echo $orde_product['order_product_id']; ?>,<?php echo $order['customer_id'];?>,'<?php echo $order['firstname'];?>',<?php echo $order['order_id']; ?>,<?php echo $order['totalProduct']; ?>,<?php echo $orde_product['price'] ;?>,<?php if ($orde_product['quantity']) echo $orde_product['quantity']; else echo 0;?>)" value="退货" style="cursor:pointer">
          </td>
           <?php if(0 == $i) { ?>
           <td class="center" rowspan="<?php echo $order['count']; ?>"><i id="pfreight<?php echo $order['order_id']; ?>"><?php if (isset($order['order_shipping'])) {
           echo $order['order_shipping'];
                  } ?></i>/<i style="color:red"><?php if((float)$order['difference']) echo $order['difference']; ?></i></td>
          <td class="center" rowspan="<?php echo $order['count']; ?>"><?php echo $order['ordertotal'];?>/<i style="color:red"><?php if($order['differencetotal'] != $order['ordertotal']) echo  number_format($order['differencetotal'],2); ?></i></td>
          <td class="center" rowspan="<?php echo $order['count']; ?>"><?php echo $order['date_added']; ?></td>
          <td class="center" rowspan="<?php echo $order['count']; ?>"><?php if($order['date_modified'] > 0 ){echo $order['date_modified'];} ?></td>         
          <td class="center" rowspan="<?php echo $order['count']; ?>"><?php  echo $order['status'];?> </td>
           <?php } ?>
           <?php $i++;?>
           <?php } ?>
           
       
        </tr>
        <?php 
       }
               }
      ?>
          </tbody>
        
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
</div>
<div id="displaydiv" style="display:none;position:fixed; top:200px;left:500px;border:3px solid #ccc; width:370px;height:205px;background:#fff;padding:5px"> 
<div style="text-align:center;font-weight:bold;font-szie:16px">  订单备注 
<div style="width:40px;float:right;text-align:right" ><a href="javascript:;" onclick="hidediv()">关闭</a></div></div>

	<div style="clear:both"></div>
		<ul>
			<li style="width:180px;float:left;height:20px">订单ID:<span style="font-weight:bold " id="soid"></span></li>
			<li style="width:180px;float:left;height:20px">用户名:<span style="font-weight:bold " id="sname"></span></li>
			<li style="width:180px;float:left;height:20px">来源商家:<span style="font-weight:bold " id="seller"></span></li>
			<li style="width:180px;float:left;height:20px">订单商品数:<span style="font-weight:bold " id="snum"></span></li>
		</ul>
		<div style="clear:both;height:12px"></div>
	<textarea name="bz" rows="6" cols="46" style="height:95px;overflow:auto;width:368px"></textarea>
	<input type="hidden" name="oid" value="">
	<div style="text-align:center;"><input type="button" value="保存" onclick="savebz()"></div>
</div>
<script type="text/javascript"> (function(win,doc){ var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0]; if (!win.alimamatk_show) { s.charset = "gbk"; s.async = true; s.src = "http://a.alimama.cn/tkapi.js"; h.insertBefore(s, h.firstChild); }; var o = { pid: "mm_30152379_3454790_11226648",/*推广单元ID，用于区分不同的推广渠道*/ appkey: "",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/ unid: ""/*自定义统计字段*/ }; win.alimamatk_onload = win.alimamatk_onload || []; win.alimamatk_onload.push(o); })(window,document);</script> 

<script type="text/javascript">
 function displaybz(obj){
	var str=$(obj).attr('alt');
	var oid=$(obj).attr('oid');
	var username=$(obj).attr('auser');
	var seller=$(obj).attr('seller');
	var snum=$(obj).attr('snum');
	$('input[name=oid]').val(oid);
	$('#soid').html(oid);
	$('#sname').html(username);
	$('#seller').html(seller);
	$('#snum').html(snum);
	$('#displaydiv').show();
	$('textarea[name=bz]').val(str);
 }
 function savebz(){
 var content=$.trim($('textarea[name=bz]').val());
 /*
 if(content ==""){
	alert('备注内容不能为空');
	return false;
 }
 */
 var data={
	content:content,
	oid:$('input[name=oid]').val()
 }
 
 $.post('index.php?route=sale/order/updatabz&token=<?php echo $token;?>',data,function(data){
	if(data){
		hidediv();
		alert('保存成功');
		 location.reload();
	}
 },'json');
 }
 function hidediv(){
	$('#displaydiv').hide();
 }
function modify_p(id){
    $.ajax({
      url:'index.php?route=sale/order/pcReq&token=<?php echo $token;?>',
      dataType:"json",
      data:{order_id:id,sign:1},
      type:"POST",
      success:function(req){
        $("#p"+id).html(' ');
        setTimeout(function(){
                              $("#p"+id).css("color","green");
                              $("#p"+id).html("订单拍照请求已处理");
                              $("#p"+id).attr("id","pp");
                          },300);
      },
      error:function(){
        alert('服务器繁忙，请稍后再试!');
      }
    });
}
function modify_c(id){
    $.ajax({
      url:'index.php?route=sale/order/pcReq&token=<?php echo $token;?>',
      dataType:"json",
      data:{order_id:id,sign:2},
      type:"POST",
      success:function(req){
        $("#c"+id).html(' ');
        setTimeout(function(){
                              $("#c"+id).css("color","green");
                              $("#c"+id).html("采购催促请求已处理");
                              $("#c"+id).attr("id","cc");
                          },300);
      },
      error:function(){
        alert('服务器繁忙，请稍后再试!');
      }
    });
}

function modify_order(customer_id,order_id) {
    var freight = $.trim($("#pfreight" + order_id).text());
    var body = "<table class='list'><tr><td>总运费</td><td><input type='text' id='pfreight' size='38' value='" + freight + "' /></td></tr>";
    var d = dialog ({
        title: '修改订单：' + order_id,
        content: body,
        width: 760,
        okValue: '提交',
        cancelValue: '取消',
        quickClose: true,
        ok: function() {
            var that = this;
            this.title('正在提交..'); 
        var pfreight = $("#pfreight").val();
        $.ajax({
                    type: "POST",
                    url: "index.php?route=sale/order/updatefreight&token=<?php echo $token;?>",
                    data: "order_id=" + order_id + "&freight=" + pfreight + "&cid=" + customer_id,
                    success: function(msg) {
                        if (eval(msg) == "1") {
                            setTimeout(function() {
                                that.title("提交成功");
                                setTimeout(function() {
                                    that.close().remove();
                                    location.reload();
                                }, 800);
                            }, 800);
                        } else {
                            setTimeout(function() {
                                that.title("提交失败");
                            }, 1800);
                        }
                    }
                });
            return false;
        },
        cancel: function() {
        }
    });
    d.width(760).show(1000);
}

function modify_weight(totalProduct,order_id,variable) {
    if (variable=='weight'){
    	var weight = $.trim($(".weight" + order_id).val());
    	var body = "<table class='list'><tr><td>单件商品重量</td><td><input type='text' id='pweight' size='38' value='" + weight + "' /></td></tr>";
    }else if (variable=='kuaidi_no'){
    	var kuaidi_no = $.trim($(".kuaidi_no" + order_id).val());
    	var body = "<table class='list'><tr><td>单件商品快递号</td><td><input type='text' id='pweight' size='38' value='" + kuaidi_no + "' /></td></tr>";
    }else if(variable=='order_sensitive'){
    	var order_sensitive = $.trim($(".order_sensitive" + order_id).val());
	if (order_sensitive==0||order_sensitive==1){
    		var body = "<table class='list'><tr><td>单件商品敏感性</td><td><label><input type='radio' id='pweight' value='2' checked/>敏感</label></td></tr>";
	}else if(order_sensitive==2){
		var body = "<table class='list'><tr><td>单件商品敏感性</td><td><label><input type='radio' id='pweight' value='1' checked/>不敏感</label></td></tr>";
	}
    }
    var d = dialog ({
        title: '修改订单：' + order_id,
        content: body,
        width: 760,
        okValue: '提交',
        cancelValue: '取消',
        quickClose: true,
        ok: function() {
            var that = this;
            this.title('正在提交..'); 
        var pweight = $("#pweight").val();
        $.ajax({
                    type: "POST",
                    url: "index.php?route=sale/order/updateweight&token=<?php echo $token;?>",
                    data: "order_id=" + order_id + "&pweight=" + pweight + "&totalProduct=" + totalProduct + '&variable=' + variable,
                    success: function(msg) {
                        if (eval(msg) == "1") {
                            setTimeout(function() {
                                that.title("提交成功");
                                setTimeout(function() {
                                    that.close().remove();
                                    location.reload();
                                }, 800);
                            }, 800);
                        } else {
                            setTimeout(function() {
                                that.title("提交失败");
                            }, 1800);
                        }
                    }
                });
            return false;
        },
        cancel: function() {
        }
    });
    d.width(760).show(1000);
}

function modify_order_product(oid,uid,uname,oid2) {
    var purl = $.trim($("#purl" + oid).attr("href"));
    var pname = $.trim($("#purl" + oid).text());
    var pcost = $.trim($("#pcost" + oid).text());
    var pqty = $.trim($("#pqty" + oid).text());
    var pcolor = $.trim($("#pcolor" + oid).text());
    var psize = $.trim($("#psize" + oid).text());
    var pnote = $.trim($("#pnote" + oid).text());
    

    var body = "<table class='list'><tr><td>商品地址</td><td><input type='text' id='purl2' size='38' value='" + purl + "' /></td></tr><tr><td><?php echo $order_product; ?></td><td><input type='text' id='pname2' size='38' value='" + pname + "' /></td></tr><tr><td>商品单价</td><td><input type='text' id='pcost2' value='" + pcost + "' /></td></tr><tr><td>商品数量</td><td><input type='text' id='pqty2' value='" + pqty + "' /></td></tr><tr><td><?php echo $order_color; ?></td><td><input type='text' id='pcolor2' value='" + pcolor + "' /></td></tr><tr><td><?php echo $order_size; ?></td><td><input type='text' id='psize2' value='" + psize + "' /></td></tr><tr><td><?php echo $order_remark; ?></td><td><textarea id='pnote2'>"+pnote+"</textarea></td></tr></table>";


    var d = dialog({
        title: '修改订单商品：' + oid,
        content: body,
        width: 760,
        okValue: '提交',
        cancelValue: '取消',
        quickClose: true,
        ok: function() {
            var that = this;
            this.title('正在提交..');

            var purl2 = $("#purl2").val();
            var pname2 = $("#pname2").val();
            var pcost2 = $("#pcost2").val();
            var pqty2 = $("#pqty2").val();
            var pcolor2 = $("#pcolor2").val();
            var psize2 = $("#psize2").val();
            var pnote2 = $("#pnote2").val();
           

            if (pname2 == "") {
                alert("名字都没有提交个屁啊！");
            } else {

                $.ajax({
                    type: "POST",
                    url: "index.php?route=sale/order/update&token=<?php echo $token;?>",
                    data: "uname=" + uname + "&oid=" + oid + "&oid2=" + oid2 + "&uid=" + uid + "&purl=" + purl2 + "&pname=" + pname2 + "&pcost=" + pcost2 + "&pqty=" + pqty2 + "&pcolor=" + pcolor2 + "&psize=" + psize2 + "&pnote=" + pnote2,
                    success: function(msg) {

                        if (eval(msg) == "1") {
                            setTimeout(function() {
                                that.title("提交成功");
                                setTimeout(function() {
                                    that.close().remove();
                                    location.reload();
                                }, 1000);
                            }, 800);
                        } else {
                            setTimeout(function() {
                                that.title("提交失败");
                            }, 1800);
                        }
                    }
                });
            }

            return false;
        },
        cancel: function() {

        }
    });
    //$('body').prepend("<div id='dialog_bg' style='width:auto;height:auto;background:#000000;position:fixed;width:100%;height:100%;opacity:0.5;z-index:100'></div>");
    d.width(760).show(1000);
    
}

function openwindow(url, name, iWidth, iHeight)
{
    var url; //转向网页的地址;
    var name; //网页名称，可为空;
    var iWidth; //弹出窗口的宽度;
    var iHeight; //弹出窗口的高度;
    var iTop = (window.screen.availHeight - 30 - iHeight) / 2; //获得窗口的垂直位置;
    var iLeft = (window.screen.availWidth - 10 - iWidth) / 2; //获得窗口的水平位置;
    window.open(url, name, 'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',toolbar=no,menubar=no,scrollbars=yes,resizeable=no,location=no,status=no');
}

function express(order_product_id) {
    var AdultObj = document.getElementById("express_change" + order_product_id);
    Adult_Value = AdultObj.options[AdultObj.selectedIndex].value;

    $.ajax({
        type: "GET",
        url: "index.php?route=sale/order/express&token=<?php echo $token;?>",
        data: "order_product_id=" + order_product_id + "&Adult_Value=" + Adult_Value,
        success: function(msg) {
            if (msg == 1) {
                alert("修改成功");
            } else {
                alert("修改失败");
            }
        }
    });
}

function weight(order_product_id) {

    var AdultObj = document.getElementById("weight" + order_product_id).value;
    if (AdultObj == ''){
    	alert('请填写重量!');
	return false;
    }
    $.ajax({
        type: "GET",
        url: "index.php?route=sale/order/weight&token=<?php echo $token;?>",
        data: "order_product_id=" + order_product_id + "&AdultObj=" + AdultObj,
        success: function(msg) {
            if (msg == 1) {
                alert("修改成功");
            } else {
                alert("修改失败");
            }
        }
    });
}

function tracking_number(order_product_id) {
    var tracking = document.getElementById('tracking' + order_product_id).value;

    $.ajax({
        type: "GET",
        url: "index.php?route=sale/order/tracking&token=<?php echo $token;?>",
        data: "order_product_id=" + order_product_id + "&tracking=" + tracking,
        success: function(msg) {

            if (msg == 1) {
                alert("修改成功");

            } else {
                alert("修改失败");
            }
        }
    });
}

function addState(order_product_id, state) {

    var ordername = state + order_product_id;
    var ordernamecolor = document.getElementById(ordername).color;

    if (ordernamecolor == 'red') {
        var stateid = 1;
    } else {
        var stateid = 2;
    }

    $.ajax({
        type: "GET",
        url: "index.php?route=sale/order/addState&token=<?php echo $token;?>",
        data: 'order_product_id=' + order_product_id + '&colorid=' + stateid + '&state=' + state,
        success: function(msg) {
	
            if (msg) {
	  
                var ordernamecolor = document.getElementById(ordername).color;
                if (ordernamecolor == 'red') {
		    if (state == 'order_sensitive'){
			document.getElementById(ordername).innerHTML = "不敏感";
		    }else if (state == 'order_branding'){
			document.getElementById(ordername).innerHTML = "非名牌";
		    }else if (state == 'order_huge'){
			document.getElementById(ordername).innerHTML = "重抛";
		    }
                    document.getElementById(ordername).color = "#0092d2";
                } else {
                    if (state == 'order_sensitive'){
			document.getElementById(ordername).innerHTML = "敏感 ";
		    }else if (state == 'order_branding'){
			document.getElementById(ordername).innerHTML = "名牌";
		    }else if (state == 'order_huge'){
			document.getElementById(ordername).innerHTML = "取消重抛";
		    }
                    document.getElementById(ordername).color = "red";

                }
            }
        }
    });
}

function delete_order(productId,customerId,uname,orderId,totalProduct,price,number){
	if (confirm("是否为 "+uname+" 订单号 "+orderId+" 中的此商品退款")){
		$.ajax({
		        type: "POST",
		        url: "index.php?route=sale/order/deleteOrder&token=<?php echo $token;?>",
		        data: 'productId=' + productId + '&customerId=' + customerId + '&uname=' + uname + '&orderId=' + orderId + '&totalProduct=' + totalProduct + '&price=' + price + '&number=' + number,
		        success: function(msg) {
					if (msg){
						location.reload();
					}
		        },
				error:function(){
					alert("请求失败");
				}
		    });
	}
}

function filter() {
    url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
    var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
    if (filter_order_id) {
        url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
    }

    var filter_sn = $('input[name=\'filter_sn\']').attr('value');
    if (filter_sn) {
        url += '&filter_sn=' + encodeURIComponent(filter_sn);
    }

    var filter_customer = $('input[name=\'filter_customer\']').attr('value');
    if (filter_customer) {
        url += '&filter_customer=' + encodeURIComponent(filter_customer);
    }

    var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
    if (filter_order_status_id) {
        url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
    }

    var filter_total = $('input[name=\'filter_total\']').attr('value');
    if (filter_total) {
        url += '&filter_total=' + encodeURIComponent(filter_total);
    }

    var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
    if (filter_date_added) {
        url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
    }

    var filter_date_modified = $('input[name=\'filter_date_modified\']').attr('value');
    if (filter_date_modified) {
        url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
    }
    
    var filter_product_name = $('input[name=\'filter_product_name\']').attr('value');
    if (filter_product_name) {
        url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
    }

    location = url;
}

$(document).ready(function() {
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
});

$('#form input').keydown(function(e) {
    if (e.keyCode == 13) {
        filter();
    }
});

$.widget('custom.catcomplete', $.ui.autocomplete, {
    _renderMenu: function(ul, items) {
        var self = this, currentCategory = '';
        $.each(items, function(index, item) {
            if (item.category != currentCategory) {
                ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
                currentCategory = item.category;
            }

            self._renderItem(ul, item);
        });
    }
});
$('input[name=\'filter_customer\']').catcomplete({
    delay: 500,
    source: function(request, response) {
        $.ajax({
            url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        category: item.customer_group,
                        label: item.firstname,
                        value: item.customer_id
                    }
                }));
            }
        });
    },
    select: function(event, ui) {
        $('input[name=\'filter_customer\']').val(ui.item.label);
        return false;
    },
    focus: function(event, ui) {
        return false;
    }
});

</script> 
<?php echo $footer; ?>