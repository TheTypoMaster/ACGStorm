<?php echo $header; ?>

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
	<thead>
	</thead>
	<tbody>
	  <tr class="filter">
	    <td><a href="javascript:location.reload();"><img src="/orange/view/image/refresh.gif" alt="刷新" width="28" height="20"></a></td>
	    <td><select name="filter_order_status_id">
		<option value="*"></option>
		<option value="0" selected="selected">选择运单状态</option>
		<?php foreach ($order_statuses as $order_status) { ?>
		<?php if ($order_status['id'] == $filter_order_status_id) { ?>
		<option value="<?php echo $order_status['id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
		<?php } else { ?>
		<option value="<?php echo $order_status['id']; ?>"><?php echo $order_status['name']; ?></option>
		<?php } ?>
		<?php } ?>
		  <option value="10"> 待取消</option>
	      </select>
	      &nbsp;&nbsp;<a onclick="$('#form').attr('action', '<?php echo $update_order; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button">修改</a><a onclick="filter();" class="button">筛选</a></td>
	    <td align="center">运单ID：
	      <input type="text" name="filter_sid" value="" />
	      发货单号：
	      <input type="text" name="filter_sn" value="" />
	      <a onclick="filter();" class="button">查找</a></td>
	    <td>用户名：
	      <input type="text" name="filter_customer" value="" />
	      <a onclick="filter();" class="button">查找</a></td>
	    <td>新建日期
	      <input type="text" name="filter_date_added" value="" size="12" class="date" /></td>
	    <td>修改日期
	      <input type="text" name="filter_date_modified" value="" size="12" class="date" /></td>
	    <td align="right"></td>
	  </tr>
      </table>
      <table class="list">
	<thead>
	  <tr>
	    <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
	    <td class="right" style='width: 10px;'>ID</td>
	    <td class="left" style='width: 10px;'>用户</td>
	    <td class="right">发货单号</td>
	    <td class="right">下单来源</td>
	    <td class="right">实际重量（克）</td>
	    <td class="right">快递公司</td>
	    <td class="right">国家/城市</td>
	    <td class="right">地址/邮编</td>
	    <td class="right">姓名/电话/邮件</td>
	    <td class="right">运费/体积费</td>
	    <td class="right">服务费</td>
	    <td class="right">报关费</td>
	    <td class="right">材料费</td>
	    <td class="right">总费用</td>
	    <td class="right">打包策略</td>
	    <td class="right">订单处理</td>
	    <td class="right">包装材料</td>
	    <td class="right">增值服务</td>
	    <td class="left">提交/更新</td>
	    <td class="left" >状态</td>
	    <td class="left">修改</td>
	  </tr>
	</thead>
	<?php     
       if ($orders) { 
	?>
	<?php foreach ($orders as $order) {   
      ?>
	<tr>
	  <td style="text-align: center;"><?php if ($order['selected']) { ?>
	    <input type="checkbox" name="selected[]" value="<?php echo $order['sid']; ?>" checked="checked" />
	    <?php } else { ?>
	    <input type="checkbox" name="selected[]" value="<?php echo $order['sid']; ?>" />
	    <?php } ?></td>
	  <td class="right"><?php echo $order['sid']; ?></td>
	  <td class="left" colspan='20'><a href="<?php echo $emali ;?>&sid=<?php echo $order['sid']; ?>" target="_blank" onclick="openwindow(this.href,'','width=530,height=525');return false"><?php echo $order['uname'];?></a>&nbsp;&nbsp;
	  <input type="button" value="备注"  alt="<?php echo $order['remarks']; ?>" auser="<?php echo $order['uname'];?>" oid="<?php echo $order['sid']; ?>" onclick="displaybz(this)"/>
	  </td>
	</tr>
	<tr class="right">
	  <td class="left" colspan='3'><?php echo $order['remark']; ?></td>
	  <td class="center"><input style='width: 100px;' onchange="tracking_number(<?php echo $order['sid']; ?>)" type="text" id="remark_<?php echo $order['sid']; ?>" value="<?php echo $order['sn']; ?>"/>
	    <br>
	    <b>
	    <?php if($order['pak_free']==1){?>
	    需要精简包装
	    <?php }?>
	    </b></td>
	    <?php if (strtotime($order['addtime']) <= strtotime("2014-12-12 17:00:00")){ ?>
		<td>&nbsp;</td>
	    <?php }else{ if (0 == $order['oldtotalfee']){ ?>
		<td>app</td>
	    <?php }else{ ?>
		<td>网站</td>
	    <?php } ?>
	    <?php } ?>
	  <td class="right"><input  size="5" onchange="weight2(<?php echo $order['sid']; ?>)" type="text" id="weight<?php echo $order['sid']; ?>"value="<?php echo $order['countweight']; ?>"></td>
	  <td class="right"><select onchange=change_kuaidi(<?php echo $order['sid']; ?>);name="filter_order_status_id" id="change_kuaidi<?php echo $order['sid']; ?>">
	      <option value="*"></option>
	      <?php foreach ($order['express_all'] as $expres) {   ?>
	      <?php if ($expres['deliveryname'] == $order['deliveryname']) { 
	  ?>
	      <option value="<?php echo $expres['did']; ?>" selected="selected"><?php echo $expres['deliveryname']; ?></option>
	      <?php } else { ?>
	      <option value="<?php echo $expres['did']; ?>"><?php echo $expres['deliveryname']; ?></option>
	      <?php } ?>
	      <?php } ?>
		
	    </select>
	    </br>
	    <?php $order['express'] ?>
	    <?php foreach ($order['express_all'] as $expres) {   ?>
	    <?php if ($expres['deliveryname'] == $order['deliveryname']) { 
	  ?>
	    <?php if($expres['deliveryname']=='AIR' || $expres['deliveryname']=='EMS' || $expres['deliveryname']=='SAL水陆联运'){}else{?>
	    长度
	    <input size="3" id="yundan_long<?php echo $order['sid']; ?>" type="text" value="<?php echo $order['yundan_long']; ?>">
	    cm&nbsp;&nbsp;</br>
	    宽度
	    <input size="3" id="yundan_wide<?php echo $order['sid']; ?>" type="text" value="<?php echo $order['yundan_wide']; ?>">
	    cm&nbsp;&nbsp;</br>
	    高度
	    <input size="3" id="yundan_high<?php echo $order['sid']; ?>" type="text" value="<?php echo $order['yundan_high']; ?>">
	    cm&nbsp;&nbsp;</br>
	    体积重
	    <input size="3" type="text" value="<?php echo $order['yundan_long']*$order['yundan_wide']*$order['yundan_high']/5000 ?>">
	    千克</br>
	    <input size="3" type="button" value="更改体积" onclick="change_v(<?php echo $order['sid']; ?>)">
	    <?php } } } ?></td>
	  <?php if($order['country_cn']){ foreach ($order['country_cn'] as $country) {   ?>
	  <td class="right"><?php echo $country['name_cn']; ?>/<?php echo $order['city']; ?></td>
	  <?php } }else{ ?>
	  <td class="right"><?php echo $order['country']; ?>/<?php echo $order['city']; ?></td>
	  <?php } ?>
	  <td class="right"><?php echo $order['address']; ?><br/>
	    <?php echo $order['zip']; ?></td>
	  <td class="right"><?php echo $order['consignee']; ?><br/>
	    <?php echo $order['tel']; ?><br/>
	    <?php echo $order['email']; ?></td>
	  <td class="right"><?php echo $order['freight']; ?>/<?php echo $order['volume_free']; ?></td>
	  <td class="right"><?php echo $order['serverfee']; ?></td>
	  <td class="right"><?php echo $order['customsfee']; ?></td>
	  <td class="right"><?php if ($order['wrapperfee']>0) echo $order['wrapperfee']; ?></td>
	  <td class="right"><?php echo $order['totalfee']; ?></td>
	  <?php if (strtotime($order['addtime']) <= strtotime("2014-12-12 17:00:00")){ ?>

		  <?php if(0 == $order['dabao']) { ?>
		  <td class="right">经济方案</td>
		  <?php }else if(1 == $order['dabao']) { ?>
		  <td class="right">标准方案</td>
		  <?php }else if(2 == $order['dabao']) { ?>
		  <td class="right">高级方案</td>
		  <?php }else if(3 == $order['dabao']) { ?>
		  <td class="right">免费体验</td>
		  <?php }else{   ?>
		  <td class="right"></td>
		  <?php } ?>

		  <?php if(0 == $order['dingdan']) { ?>
		  <td class="right">经济方案</td>
		  <?php }else if(1 == $order['dingdan']) { ?>
		  <td class="right">标准方案</td>
		  <?php }else if(2 == $order['dingdan']) { ?>
		  <td class="right">高级方案</td>
		  <?php }else if(3 == $order['dingdan']) { ?>
		  <td class="right">免费体验</td>
		  <?php }else{   ?>
		  <td class="right"></td>
		  <?php } ?>

		  <?php if(0 == $order['baozhuang']) {  ?>
		  <td class="right">标准耗材</td>
		  <?php }else if(1 == $order['baozhuang']) { ?>
		  <td class="right">坚固耗材</td>
		  <?php }else{ ?>
		  <td class="right"></td>
		  <?php } ?>

		  <?php  if(0 == $order['zengzhi']) {  ?>
		  <td class="right" style="color:red;font-weight:bold;">免费体验</td>
		  <?php }else if(1 == $order['zengzhi']) { ?>
		  <td class="right" style="color:red;font-weight:bold;">大包裹方案</td>
		  <?php }else if(2 == $order['zengzhi']) { ?>
		  <td class="right" style="color:red;font-weight:bold;">为运单拍照</td>
		  <?php }else{ ?>
		  <td class="right"></td>
		  <?php } ?>

	 <?php }else{ ?>

		  <?php if(0 == $order['dabao']) { ?>
		  <td class="right">免费体验</td>
		  <?php }else if(1 == $order['dabao']) { ?>
		  <td class="right">经济方案</td>
		  <?php }else if(2 == $order['dabao']) { ?>
		  <td class="right">标准方案</td>
		  <?php }else if(3 == $order['dabao']) { ?>
		  <td class="right">高级方案</td>
		  <?php }else{   ?>
		  <td class="right"></td>
		  <?php } ?>

		  <?php if(0 == $order['dingdan']) { ?>
		  <td class="right">免费体验</td>
		  <?php }else if(1 == $order['dingdan']) { ?>
		  <td class="right">经济方案</td>
		  <?php }else if(2 == $order['dingdan']) { ?>
		  <td class="right">标准方案</td>
		  <?php }else if(3 == $order['dingdan']) { ?>
		  <td class="right">高级方案</td>
		  <?php }else{   ?>
		  <td class="right"></td>
		  <?php } ?>

		  <?php if(1 == $order['baozhuang']) {  ?>
		  <td class="right">标准耗材</td>
		  <?php }else if(2 == $order['baozhuang']) { ?>
		  <td class="right">坚固耗材</td>
		  <?php }else{ ?>
		  <td class="right"></td>
		  <?php } ?>

		  <?php  if(is_array($order['zengzhi'])) {  ?>
		  <td class="right" style="color:red;font-weight:bold;">大包裹方案<br/><br/>为运单拍照</td>
		  <?php }else if(1 == $order['zengzhi']) { ?>
		  <td class="right" style="color:red;font-weight:bold;">大包裹方案</td>
		  <?php }else if(2 == $order['zengzhi']) { ?>
		  <td class="right" style="color:red;font-weight:bold;">为运单拍照</td>
		  <?php }else{ ?>
		  <td class="right"></td>
		  <?php } ?>

	  <?php } ?>

	  <td class="right"><?php echo $order['addtime']; ?><br/>
	    <?php echo $order['uptime']; ?></td>
	  <td class="right"><?php echo $order['state']; ?></td>
	  <td class="right" style="width:50px"><input type="button" value="修改" onclick="updata_yundan(<?php echo $order['sid']; ?>)">
	    <input type="button" value="详情"  onclick="yundan_list(<?php echo $order['sid']; ?>)">
		<input type='button' value='时间' onclick="time_list(<?php echo $order['sid']; ?>)"/>
		</td>
	</tr>
	<?php  }} ?>
	  </tbody>
	
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
</div>

<div id="displaydiv" style="display:none;position:fixed; top:200px;left:500px;border:3px solid #ccc; width:370px;height:205px;background:#fff;padding:5px"> 
<div style="text-align:center;font-weight:bold;font-szie:16px">  运单备注 
<div style="width:40px;float:right;text-align:right" ><a href="javascript:;" onclick="hidediv()">关闭</a></div></div>

	<div style="clear:both"></div>
		<ul>
			<li style="width:150px;float:left;height:20px">运单ID:<span style="font-weight:bold " id="soid"></span></li>
			<li style="width:150px;float:left;height:20px">用户名:<span style="font-weight:bold " id="sname"></span></li>
		</ul>
		<div style="clear:both;height:12px"></div>
	<textarea name="bz" rows="6" cols="46" style="height:95px;overflow:auto;width:368px"></textarea>
	<input type="hidden" name="oid" value="">
	<div style="text-align:center;"><input type="button" value="保存" onclick="savebz()"></div>
</div>
<script type="text/javascript">
 function displaybz(obj){
	var str=$(obj).attr('alt');
	var oid=$(obj).attr('oid');
	var username=$(obj).attr('auser');
	$('input[name=oid]').val(oid);
	$('#soid').html(oid);
	$('#sname').html(username);
	$('#displaydiv').show();
	$('textarea[name=bz]').val(str);
 }
 function savebz(){
 var content=$.trim($('textarea[name=bz]').val());
 var oid=$('input[name=oid]').val();
 
 if(content ==""){
	alert('备注内容不能为空');
	return false;
 }
  url = "index.php?route=yundan/yundan/updatabz&token=<?php echo $token;?>&oid=" + oid+"&content="+content;
 $.get(url,function(data){
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
 
</script>
<script type="text/javascript"><!--

function updata_yundan(yundan_id) {

    url = "index.php?route=yundan/yundan/yundan_updata&token=<?php echo $token;?>&yundan_id=" + yundan_id;
    openwindow(url, '', 490, 525);
}

function yundan_list(yundan_id) {


    url = "index.php?route=yundan/yundan/yundan_list&token=<?php echo $token;?>&yundan_id=" + yundan_id;

    openwindow(url, '', 1389, 625);

}
function time_list(yundan_id) {


    url = "index.php?route=yundan/yundan/time_list&token=<?php echo $token;?>&yundan_id=" + yundan_id;

    openwindow(url, '', 1389, 625);

}
function change_v(id) {

    var yundan_long = document.getElementById("yundan_long" + id).value;
    var yundan_wide = document.getElementById("yundan_wide" + id).value;
    var yundan_high = document.getElementById("yundan_high" + id).value;
    var change_kuaidi = document.getElementById("change_kuaidi" + id).value;

    if (yundan_long == "") {
	alert(长度不能为空);
	return false;
    }
    if (yundan_wide == "") {
	alert(宽度不能为空);
	return false;
    }
    if (yundan_high == "") {
	alert(高度不能为空);
	return false;
    }

if(confirm("请确认长宽高为："+yundan_long+"X"+yundan_wide+"X"+yundan_high)){

    $.ajax({
	type: "GET",
	url: "index.php?route=yundan/yundan/change_v&token=<?php echo $token;?>",
	data: "yundan_long=" + yundan_long + "&yundan_wide=" + yundan_wide + "&yundan_high=" + yundan_high + "&change_kuaidi=" + change_kuaidi + "&id=" + id,
	success: function(msg) {
	    if (msg == 1) {
		alert("修改成功");
	    } else {
		alert("修改失败");
	    }
	}
    });
}
}


function update_order(order_product_id) {
    url = "index.php?route=sale/order/update&token=<?php echo $token;?>&order_product_id=" + order_product_id;

    openwindow(url, '', 490, 525);

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

function weight2(order_id) {

    var weight = document.getElementById("weight" + order_id).value;
    var did = document.getElementById('change_kuaidi' + order_id).value;

if(confirm("请确认重量为："+weight)){
    $.ajax({
	type: "GET",
	url: "index.php?route=yundan/yundan/weight&token=<?php echo $token;?>",
	data: "order_id=" + order_id + "&weight=" + weight + "&did=" + did,
	success: function(msg) {
	    if (msg == 1) {
		alert("修改成功");
	    } else {
		alert("修改失败");
	    }
	}
    });
}
}

function tracking_number(oid) {

    var remark = $("#remark_"+oid).val();

    $.ajax({
	type: "GET",
	url: "index.php?route=yundan/yundan/remark&token=<?php echo $token;?>",
	data: "order_id=" + oid + "&remark=" + remark,
	success: function(msg) {

	    if (msg == 1) {
		alert("修改成功");

	    } else {
		alert("修改失败");
	    }

	}
    });

}

function change_kuaidi(order_id) {

    var change_kuaidi = document.getElementById('change_kuaidi' + order_id).value;

    $.ajax({
	type: "GET",
	url: "index.php?route=yundan/yundan/change_kuaidi&token=<?php echo $token;?>",
	data: "order_id=" + order_id + "&change_kuaidi=" + change_kuaidi,
	success: function(msg) {

	    if (msg == 1) {
		alert("修改成功");

	    } else {
		alert("修改失败");
	    }

	}
    });
}

function autocomplete(order_product_id) {

    var ordername = 'order_notSensitive' + order_product_id;

    var ordernamecolor = document.getElementById(ordername).color;

    if (ordernamecolor == "red") {
	var colorid = 1;
    } else {
	var colorid = 2;
    }

    $.ajax({
	type: "GET",
	url: "index.php?route=sale/order/autocomplete&token=<?php echo $token;?>",
	data: "order_product_id=" + order_product_id + "&colorid=" + colorid,
	success: function(msg) {
	    if (msg) {
		var ordernamecolor = document.getElementById(ordername).color;
		if (ordernamecolor == "red") {
		    document.getElementById(ordername).innerHTML = "<?php if(isset($order_notSensitive)) echo $order_notSensitive;?>";
		    document.getElementById(ordername).color = "#0092d2";
		} else {
		    document.getElementById(ordername).innerHTML = "<?php if(isset($order_Sensitive)) echo $order_Sensitive;?>";
		    document.getElementById(ordername).color = "red";

		}
	    }
	}
    });

}

function nonameplate(order_product_id) {

    var ordername = 'nonameplate' + order_product_id;

    var ordernamecolor = document.getElementById(ordername).color;


    if (ordernamecolor == "red") {
	var colorid = 1;
    } else {
	var colorid = 2;
    }

    $.ajax({
	type: "GET",
	url: "index.php?route=sale/order/nonameplate&token=<?php echo $token;?>",
	data: "order_product_id=" + order_product_id + "&colorid=" + colorid,
	success: function(msg) {


	    if (msg) {
		var ordernamecolor = document.getElementById(ordername).color;
		if (ordernamecolor == "red") {
		    document.getElementById(ordername).innerHTML = "<?php if(isset($order_nonameplate)) echo $order_nonameplate;?>";
		    document.getElementById(ordername).color = "#0092d2";
		} else {
		    document.getElementById(ordername).innerHTML = "<?php if(isset($order_nameplate)) echo $order_nameplate;?>";
		    document.getElementById(ordername).color = "red";
		}
	    }
	}
    });

}

function rethrowing(order_product_id) {

    var ordername = 'rethrowing' + order_product_id;

    var ordernamecolor = document.getElementById(ordername).color;

    if (ordernamecolor == "red") {
	var colorid = 1;
    } else {
	var colorid = 2;
    }
    $.ajax({
	type: "GET",
	url: "index.php?route=sale/order/rethrowing&token=<?php echo $token;?>",
	data: "order_product_id=" + order_product_id + "&colorid=" + colorid,
	success: function(msg) {
	    if (msg) {
		var ordernamecolor = document.getElementById(ordername).color;
		if (ordernamecolor == "red") {
		    document.getElementById(ordername).innerHTML = "<?php if(isset($order_rethrowing)) echo $order_rethrowing;?>";
		    document.getElementById(ordername).color = "#0092d2";
		} else {
		    document.getElementById(ordername).innerHTML = "<?php if(isset($order_notrethrowing)) echo $order_notrethrowing;?>";
		    document.getElementById(ordername).color = "red";

		}
	    }
	}
    });
}

function filter() {
url = 'index.php?route=yundan/yundan&token=<?php echo $token; ?>';
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	if (filter_order_status_id) {
url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
}
	var filter_customer = $('input[name=\'filter_customer\']').attr('value');
	if (filter_customer) {
url += '&filter_customer=' + encodeURIComponent(filter_customer);
}

var filter_sn = $('input[name=\'filter_sn\']').attr('value');
	if (filter_sn) {
url += '&filter_sn=' + encodeURIComponent(filter_sn);
}

var filter_sid = $('input[name=\'filter_sid\']').attr('value');
	if (filter_sid) {
url += '&filter_sid=' + encodeURIComponent(filter_sid);
}

var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	if (filter_date_added) {
url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
}

var filter_date_modified = $('input[name=\'filter_date_modified\']').attr('value');
	if (filter_date_modified) {
url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
}

location = url;
	}
//--></script> 
<script type = "text/javascript" > <!--
	$(document).ready(function() {
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	});
//--></script> 
<script type = "text/javascript" > <!--
	$('#form input').keydown(function(e) {
if (e.keyCode == 13) {
filter();
}
});
//--></script> 
<script type = "text/javascript" > <!--
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

//-->
</script> 
<?php echo $footer; ?>
