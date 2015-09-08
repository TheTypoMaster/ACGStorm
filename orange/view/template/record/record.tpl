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
    <table class="list">
      <tbody>
        <tr class="filter">
          <td><a href="javascript:location.reload();"><img src="/orange/view/image/refresh.gif" alt="刷新" width="28" height="20"></a></td>
          <td>用户名：
            <input id="filter_uname" value="" />
            <a onclick="filter();" class="button">筛选</a></td>
        </tr>
    </table>
    <table class="list">
      <thead>
        <tr>
          <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="center">ID</td>
          <td class="center">用户名</td>
          <td class="center">消费方式</td>
	  	  <td class="center">来源</td>
          <td class="center">金额</td>
          <td class="center">账户余额</td>
          <td class="center" style="width:600px;">备注</td>
          <td class="center">备注详情</td>
          <td class="center">发生时间</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($orders) {	
			 foreach ($orders as $order) {		
			?>
        <tr>
          <td style="text-align: center;"><?php if ($order['selected']) { ?>
            <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="selected[]" value="<?php if ( isset( $order['order_id'] ) ) echo $order['order_id']; ?>" />
            <?php } ?></td>
          <td class="center"><?php echo $order['rid']; ?></td>
          <td class="center"><?php echo $order['uname']; ?></td>
          <?php if($order['payname']) { ?>
          <td class="center" style="color:green"><?php echo $order['payname'] ;?></td>
          <?php  }else{   ?>
          <td class="center"></td>
          <?php } ?>
	  <?php if (strtotime($order['addtime']) > 1420785667){ if ((1 == $order['source']) || (null == $order['source'] && empty($order['payname']) )){ ?>
	  	<td class="center">网站</td>
	  <?php }else if (null == $order['source']){ ?>
	  	<td class="center">app</td>
	  <?php } ?>
	  <?php }else{ ?>
	  	<td class="center">&nbsp;</td>
	  <?php } ?>
	  <?php if(strtotime($order['addtime']) > 1421656399){ ?>
          <td class="center" style="color:red"><?php echo $order['symbol'].$order['money'] ;?></td>
	  <?php }else{ ?>
	  <td class="center" style="color:red"><?php echo $order['money'] ;?></td>
	  <?php } ?>
          <td class="center" style="color:red"><?php echo $order['accountmoney'];?></td>
          <td class="center"><div style="width:600px;overflow:auto"><?php echo $order['remark'];?></div></td>
          <?php if($order['remarktype']) { ?>
          <td class="center"><a onclick="record_list(<?php echo $order['rid'];?>)">备注详情</a></td>
          <?php }else if ($order['record']){ ?>
          <td class="center"><a target="_blank" href="index.php?route=record/record/delete_order_list&token=<?php echo $token;?>&rid=<?php echo $order['record'];?>">备注详情</a></td>
          <?php }else{ ?>
          <td class="center"></td>
          <?php } ?>
          <td class="center"><?php echo $order['addtime'];?></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
</div>
<script type="text/javascript">
function filter(){
url = 'index.php?route=record/record&token=<?php echo $token; ?>';
var filter_uname = $("#filter_uname").val();
if(filter_uname){
url += '&filter_uname=' + encodeURIComponent(filter_uname);
}
location = url;
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

function record_list(rid) {

    url = "index.php?route=record/record/record_list&token=<?php echo $token;?>&rid=" + rid;

    openwindow(url, '', 490, 525);
}
</script> 
<?php echo $footer; ?>
