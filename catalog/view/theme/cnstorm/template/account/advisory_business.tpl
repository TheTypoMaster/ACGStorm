<title>客服咨询-请及时客服咨询遇到的问题</title>
<meta name="keywords" content="账户管理, CNstorm账户,账户中心，客服咨询，客服，CNstorm客服，咨询问题" />
<meta name="description" content="对cnstorm账户问题、包裹问题、订单问题或充值问题，请及时咨询我们的客服" />
<?php echo $header_cart; ?>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right" style="height:900px">
  <div class="page-title">
    <h2>客服咨询</h2>
  </div>
  <div class="all_dingdan">
    <form id="goQuery" action="<?php echo $action; ?>" method="post">
      <ul class="consult">
        <li>
          <h3>我要留言咨询</h3>
        </li>
        <li>
          <div>
            <input id="radio1" type="radio" name="question" value="1" checked="checked" />
            <label for="radio1">订单问题</label>
          </div>
        </li>
        <li>
          <div>
            <input id="radio2" type="radio" name="question" value="2"/>
            <label for="radio2">包裹问题</label>
          </div>
        </li>
        <li>
          <div>
            <input id="radio3" type="radio" name="question" value="3"/>
            <label for="radio3">充值问题</label>
          </div>
        </li>
        <li>
          <div>
            <input id="radio4" type="radio" name="question" value="4"/>
            <label for="radio4">账户问题</label>
          </div>
        </li>
        <li>
          <div>
            <input id="radio5" type="radio" name="question" value="5"/>
            <label for="radio5">其他问题</label>
          </div>
        </li>
      </ul>
      <textarea class="input_advice" name="msg" id="query" placeholder="为了避免不愉快的购物体验，请尽量详细填写您要咨询的内容，以便我们尽快为您解决疑问。"></textarea>
      <div class="consult_submit">
        <input value="提交问题"  onclick="toQuery()" />
        <span class="red" id="wrong_query">请输入后再点击回复！</span> </div>
    </form>
    <div class="consult_record">
      <h3>留言咨询记录</h3>
      <p class="cr_head"> <span>咨询/回复</span>
        <select class="question_type" name="question_type" >
          <?php if(6 == $advisory_type) { ?>
          <option value="6" selected="selected">全部类型</option>
          <?php }else{  ?>
          <option value="6">全部类型</option>
          <?php }   ?>
          <?php if(1 == $advisory_type) { ?>
          <option value="1" selected="selected">订单问题</option>
          <?php }else{  ?>
          <option value="1">订单问题</option>
          <?php }   ?>
          <?php if(2 == $advisory_type) { ?>
          <option value="2" selected="selected">包裹问题</option>
          <?php }else{  ?>
          <option value="2">包裹问题</option>
          <?php }   ?>
          <?php if(3 == $advisory_type) { ?>
          <option value="3" selected="selected">充值问题</option>
          <?php }else{  ?>
          <option value="3">充值问题</option>
          <?php }   ?>
          <?php if(4 == $advisory_type) { ?>
          <option value="4" selected="selected">账户问题</option>
          <?php }else{  ?>
          <option value="4">账户问题</option>
          <?php }   ?>
          <?php if(5 == $advisory_type) { ?>
          <option value="5" selected="selected">其他问题</option>
          <?php }else{  ?>
          <option value="5">其他问题</option>
          <?php }   ?>
        </select>
      </p>
      <table class="question_list" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <?php if($guestbook_info) { ?>
          <?php foreach($guestbook_info as $guestbook) { ?>
          <tr>
            <td class="underline" width="793" height="76"><table border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td height="38" valign="middle">我的咨询：<?php echo $guestbook['msg']; ?> 求回复</td>
                  </tr>
                  <tr>
                    <td height="38" valign="middle"><b>CNStorm：</b>
                      <?php if($guestbook['reply']) echo $guestbook['reply']; else  echo "暂无回复！"?></td>
                  </tr>
                </tbody>
              </table></td>
            <?php if(1 == $guestbook['type']) { ?>
            <td class="underline">订单问题</td>
            <?php }else if(2 == $guestbook['type']) { ?>
            <td class="underline">包裹问题</td>
            <?php }else if(3 == $guestbook['type']) { ?>
            <td class="underline">充值问题</td>
            <?php }else if(4 == $guestbook['type']) { ?>
            <td class="underline">账户问题</td>
            <?php }else if(5 == $guestbook['type']) { ?>
            <td class="underline">其他问题</td>
            <?php }else{ ?>
            <td class="underline">UFO问题</td>
            <?php } ?>
          </tr>
          <?php } } ?>
        </tbody>
      </table>
    </div>
    <div class="pages_change"><?php echo $pagination; ?></div>
  </div>
</div>
<script>
	$(".question_type").change(function(){
		var type=$(this).val();
		if(type > 0){
			$.post("/index.php?route=account/advisory/filter_type",{type:type},function(data){
			
				var url="/account-advisory.html";
				
				window.location.href=url;
			});
		}
	})
</script>
</div>
</div>
</body>
<?php echo $footer; ?>