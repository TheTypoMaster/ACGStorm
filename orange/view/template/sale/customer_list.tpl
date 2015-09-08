<?php echo $header; ?>
<script src="view/javascript/artdialog/dialog-min.js"></script>
<link rel="stylesheet" href="view/javascript/artdialog/ui-dialog.css" />
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
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('form').attr('action', '<?php echo $approve; ?>'); $('form').submit();" class="button"><?php echo $button_approve; ?></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="ledt"><?php if ($sort == 'c.customer_id') { ?>
                <a href="<?php echo $sort_cid; ?>" class="<?php echo strtolower($order); ?>">
                <?php } else { ?>
                <a href="<?php echo $sort_cid; ?>">
                <?php } ?>
                ID</a></td>
              <td class="left"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.email') { ?>
                <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'customer_group') { ?>
                <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                <?php } ?></td>
              <td class="left">会员余额</td>
              <td class="left">账户积分</td>
              <td class="left"><?php if ($sort == 'c.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.approved') { ?>
                <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.ip') { ?>
                <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
              <td class="left">注册方式</td>
			  <td class='left'>最后登录时间</td>
			   <td class='left'>订单总数</td>
              <td class="left">审核验证</td>
	      <td class="left">商户认证</td>
              <td class="left"><?php echo $column_login; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
              <td><select name="filter_customer_group_id">
                  <option value="*"></option>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td></td>
              <td></td>
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td><select name="filter_approved">
                  <option value="*"></option>
                  <?php if ($filter_approved) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_approved) && !$filter_approved) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
              <td><input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" /></td>
              <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
              <td></td>
              <td></td>
              <td></td>
			     <td></td>
              <td></td>
	      <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($customer['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $customer['customer_id']; ?></td>
              <td class="left" id='n_<?php echo $customer['customer_id']; ?>'><?php echo $customer['name']; ?></td>
              <td class="left" id='e_<?php echo $customer['customer_id']; ?>'><?php echo $customer['email']; ?></td>
              <td class="left"><?php echo $customer['customer_group']; ?></td>
              <td class="left" id='m_<?php echo $customer['customer_id']; ?>'><?php echo $customer['money']; ?></td>
              <td class="left" id='s_<?php echo $customer['customer_id']; ?>'><?php echo $customer['score']; ?></td>
              <td class="left"><?php echo $customer['status']; ?></td>
              <td class="left"><?php echo $customer['approved']; ?></td>
              <td class="left"><?php echo $customer['ip']; ?><?php echo $customer['country']; ?></td>
              <td class="left"><?php echo $customer['date_added']; ?></td>
              <td class="left"><?php echo $customer['from']; ?></td>
			   <td class="left"><?php echo $customer['logintime']; ?></td>
			    <td class="left"><?php echo $customer['orderNum']; ?></td>
              <td class="left"><?php if (!$customer['verification']) { ?>
                <a href="javascript:;" style="text-decoration:none;" id="<?php echo $customer['customer_id']; ?>" class="verification" onclick="verification(<?php echo $customer['customer_id']; ?>);"><font color="red">未验证</font></a>
                <?php }else{ ?>
                <a href="javascript:;" style="text-decoration:none;" id="<?php echo $customer['customer_id']; ?>" class="verification" onclick="verification(<?php echo $customer['customer_id']; ?>);"><font color="green">已验证</font></a>
                <?php } ?></td>


		<td class="left"><?php if (!$customer['business']) { ?>
                <a href="javascript:;" style="text-decoration:none;" id="bussiness<?php echo $customer['customer_id']; ?>" onclick="bussiness(<?php echo $customer['customer_id']; ?>);"><font color="red">未验证</font></a>
                <?php }else{ ?>
                <a href="javascript:;" style="text-decoration:none;" id="bussiness<?php echo $customer['customer_id']; ?>" onclick="bussiness(<?php echo $customer['customer_id']; ?>);"><font color="green">已验证</font></a>
                <?php } ?></td>


              <td class="left"><select onchange="((this.value !== '') ? window.open('index.php?route=sale/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $customer['customer_id']; ?>&store_id=' + this.value) : null); this.value = '';">
                  <option value=""><?php echo $text_select; ?></option>
                  <option value="0"><?php echo $text_default; ?></option>
                  <?php foreach ($stores as $store) { ?>
                  <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                  <?php } ?>
                </select></td>
              <!--td class="right"><input type="button" onClick="modify_order(<?php echo $customer['customer_id']; ?>)" value='修改' >
                <?php foreach ($customer['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>" target='_blank'><?php echo $action['text']; ?></a> ]
                <?php } ?></td-->
                <td class="right"></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function modify_order(uid) {
	
	var uname = $("#n_" + uid).text();
    var umail = $("#e_" + uid).text();
    var umoney = $("#m_" + uid).text();
    var uscore = $("#s_" + uid).text();
    var body = "<table class='list'><tr><td>用户名</td><td><input readonly='readonly' type='text' id='uname2' size='38' value='" + uname + "' /></td></tr><tr><td>邮箱</td><td><input type='text' id='umail2' size='38' value='" + umail + "' /></td></tr><tr><td>账户余额</td><td><input type='text' id='umoney2' value='" + umoney + "' /></td></tr><tr><td>账户积分</td><td><input type='text' id='uscore2' value='" + uscore + "' /></td></tr><tr><td>密码</td><td><input type='text' id='psw' value='' /></td></tr><tr><td>会员等级</td><td><input type='text' id='utype' value='' /></td></tr></table>";
    var d = dialog({
        title: '修改用户',
        content: body,
        width: 460,
        okValue: '提交',
        cancelValue: '取消',
        quickClose: true,
        ok: function() {
            this.title('正在提交..');

            var umail2 = $("#umail2").val();
            var umoney2 = $("#umoney2").val();
            var uscore2 = $("#uscore2").val();
            var psw = $("#psw").val();
            
                $.ajax({
                    type: "POST",
                    url: "index.php?route=sale/customer/editUser&token=<?php echo $token;?>",
                    data: "firstname=" + uname + "&customer_id=" + uid + "&email=" + umail2 + "&money=" + umoney2 + "&scores=" + uscore2 + "&password=" + psw,
                    success: function(msg) {
				location.reload();
                        }
                });
        },
        cancel: function() {

        }
    });
    d.width(460).show();

}

function filter() {
	url = 'index.php?route=sale/customer&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').attr('value');
	
	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}	
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	
	var filter_approved = $('select[name=\'filter_approved\']').attr('value');
	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}	
	
	var filter_ip = $('input[name=\'filter_ip\']').attr('value');
	
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
//--></script> 
<script type="text/javascript"><!--
function verification(id){
    $.ajax({
      url:'index.php?route=sale/customer&token=<?php echo $token; ?>',
      dataType:"json",
      data:{customer_id:id},
      type:"POST",
      success:function(req){
        if(req.msg == 0){
          $("#"+id).html(' ');
          $("#"+id).html('<font color="green">已验证</font>');
        }else{
           $("#"+id).html(' ');
          $("#"+id).html('<font color="red">未验证</font>');
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}
function bussiness(id){
    $.ajax({
      url:'index.php?route=sale/customer/bussiness&token=<?php echo $token; ?>',
      dataType:"json",
      data:{customer_id:id},
      type:"POST",
      success:function(req){
        if(req.msg == 0){
          $("#bussiness"+id).html(' ');
          $("#bussiness"+id).html('<font color="green">已验证</font>');
        }else{
           $("#bussiness"+id).html(' ');
          $("#bussiness"+id).html('<font color="red">未验证</font>');
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?> 