<title>收货地址-填写CNstorm账户中的收货地址</title>     
<meta name="keywords" content=" 账户管理, 个人设置，个人账户，CNstorm账户，收货地址，收货人" />      
<meta name="description" content="登录CNstrom账户个人设置中心，填写完整的收货地址" />
<?php echo $header_cart; ?>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right">
  <div class="page-title">
    <h2>收货地址簿</h2>
  </div>
  <div class="all_dingdan">
    <p class="add_address">新增收货地址（为了保证包裹能顺利寄送到您手上，请务必准确填写）</p>
    <form id="post_address" action="<?php echo $action; ?>" method="post">
      <div class="address_list"><span><em>*</em>收货人姓名：</span>
        <input class="input_list" placeholder="请输入收货人姓名" name="lastname" value="<?php echo $lastname; ?>" type="text" />
        <?php if ($error_lastname) { ?>
        <span class="error"><?php echo $error_lastname; ?></span>
        <?php } ?>
      </div>
      <div class="address_list"> <span><em>*</em>所在国家：</span>
        <select id="country_id" name="country_id" onchange="show_city()">
          <option value="">请选择国家</option>
          <?php foreach ($countries as $country) { ?>
          <?php if ($country['country_id'] == $country_id) { ?>
          <option value="<?php echo $country['country_id']; ?>" selected="selected"> <?php echo $country['name']; ?>(<?php echo $country['name_cn']; ?>) </option>
          <?php } else { ?>
          <option value="<?php echo $country['country_id']; ?>"> <?php echo $country['name']; ?>(<?php echo $country['name_cn']; ?>) </option>
          <?php } ?>
          <?php } ?>
        </select>
        <?php if ($error_country) { ?>
        <span class="error"><?php echo $error_country; ?></span>
        <?php } ?>
      </div>
      <div class="address_list"> <span><em>*</em>所在省市：</span>
        <select name="zone_id">
        </select>
        <?php if ($error_zone) { ?>
        <span class="error"><?php echo $error_zone; ?></span>
        <?php } ?>
      </div>
      <div class="address_list"><span><em>*</em>详细地址：</span>
        <textarea placeholder="请输入详细的街道，门牌号" name="address_details"><?php echo $address_details; ?></textarea>
        <?php if ($error_address_1) { ?>
        <span class="error"><?php echo $error_address_1; ?></span>
        <?php } ?>
      </div>
      <div class="address_list"><span><em>*</em>邮政编码：</span>
        <input class="input_list" placeholder="请输入邮政编码" name="postcode" value="<?php echo $postcode; ?>"  type="text" />
        <?php if ($error_postcode) { ?>
        <span class="error"><?php echo $error_postcode; ?></span>
        <?php } ?>
      </div>
      <div class="address_list"><span><em>*</em>联系电话：</span>
        <input class="input_list" placeholder="请输入收货人电话" name="telephone" value="<?php echo $telephone; ?>" type="text" />
        <?php if ($error_telephone) { ?>
        <span class="error"><?php echo $error_telephone; ?></span>
        <?php } ?>
      </div>
      <div class="address_list">
        <input class="submit" value="添加" type="submit" />
        <em>温馨提示：您已创建<b><?php echo $total;?></b>个收货地址，最多可创建<b>10</b>个</em></div>
    </form>
    <div class="table_addr">
      <?php foreach ($addresses as $result) { ?>
      <table class="addr_list " border="0" align="center" cellspacing="0" cellpadding="0">
        <tbody>
          <tr class="important_addr">
            <td width="86">常用收货地址</td>
            <td width="42"><a href="<?php echo $result['update']; ?>">编辑</a></td>
            <td width="44"><a href="<?php echo $result['delete']; ?>">删除</a></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="second_addr">
            <td class="firt_td fa_bgcolor" colspan="4"><table border="0" cellspacing="0" cellpadding="0" style="font-size:12px;text-align:center;">
                <tr>
                  <td width="170">收货人:<?php echo $result['address']['lastname']; ?></td>
                  <td width="520">国家:<?php echo $result['address']['country']; ?></td>
                  <td>省市:<?php echo $result['address']['zone']; ?></td>
                </tr>
              </table></td>
          </tr>
          <tr class="second_addr">
            <td class="firt_td" colspan="4"><table border="0" cellspacing="0" cellpadding="0" style="font-size:12px;text-align:center;">
                <tr>
                  <td width="170">邮政编码:<?php echo $result['address']['postcode']; ?></td>
                  <td width="520">联系电话:<?php echo $result['address']['telephone']; ?></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="firt_td fa_bgcolor" colspan="4"><table border="0" cellspacing="0" cellpadding="0" style="font-size:12px;text-align:center;">
                <tr>
                  <td width="32">&nbsp;</td>
                  <td class="firt_td" colspan="4"> 详细地址:<?php echo $result['address']['address_details']; ?></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
    </div>
  </div>
</div>
</div>
</section>
</body>
<?php echo $footer; ?>
<script type="text/javascript">
	//地理秀城市
function show_city() {

    $.ajax({
        url: 'index.php?route=account/address/country&country_id=' + $('#country_id').val(),
        dataType: 'json',
        beforeSend: function() {
            $('select[id=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
        },
        complete: function() {
            $('.wait').remove();
        },
        success: function(json) {


            if (json['postcode_required'] == '1') {
                $('#postcode-required').show();
            } else {
                $('#postcode-required').hide();
            }

            html = '<option value="">---请选择---</option>';

            if (json['zone'] != '') {
                for (i = 0; i < json['zone'].length; i++) {
                    html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                    if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                        html += ' selected="selected"';

                    }
                    if (json['zone'][i]['name_cn']){
						html += '>' + json['zone'][i]['name'] + '(' + json['zone'][i]['name_cn'] + ')' +'</option>';
					}else{
						html += '>' + json['zone'][i]['name'] + '</option>';
					}
                }
            } else {
                html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'zone_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
</script>