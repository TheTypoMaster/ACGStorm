<title>站内消息-及时关注CNstorm账户的账户管理</title>
<meta name="keywords" content=" 账户管理, CNstorm账户,账户中心，账户消息，交易消息，站内消息，系统消息" />
<meta name="description" content="登录您的cnstorm代购账户中心，及时查看交易消息、站内消息和系统消息" />
<?php echo $header_cart; ?>
<script src="catalog/view/javascript/jquery2/product.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/uc_orderlist.css">
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/pl/css/component.css">
<body>
<?php echo $uc_business; ?>
<div class="content-right" style="height:800px">
  <div class="page-title">
    <h2>站内消息</h2>
  </div>
  <div class="all_dingdan">
    <?php if($pm_info) { ?>
    <div class="wm_tables">
      <table class="website_list" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr> 
            <!-- th></th -->
            <th align="left">标题</th>
            <th width="198">时间</th>
            <th width="98"> <select class="markread_select">
                <option>已读</option>
                <option>未读</option>
              </select></th>
            <th width="98">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($pm_info as $pm) {?>
          <?php if(0 == $pm['hasview']) { ?>
          <tr class="bo not_read"> 
            <!-- td width="12"><input type="checkbox" /></td -->
            <td width="514" align="left" class="texts bold"><a href="javascript:void(0);" target="_blank" onClick="webnews(<?php echo $pm['mid'] ; ?>);"><?php echo $pm['subject'] ; ?></a></td>
            <td width="145"><?php echo date("Y-m-d H:i:s",$pm['sendtime']) ; ?></td>
            <td width="116" align="center">未读</td>
            <td width="119" align="center"><a href="javascript:void(0);" target="_blank" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
          </tr>
          <?php }else if(1 == $pm['hasview']) { ?>
          <tr class="bo read"> 
            <!-- td width="12"><input type="checkbox" /></td -->
            <td width="514" align="left" class="texts"><?php echo $pm['subject'] ; ?></td>
            <td width="145"><?php echo date("Y-m-d H:i:s",$pm['sendtime']) ; ?></td>
            <td width="116" align="center">已读</td>
            <td width="119" align="center"><a href="javascript:void(0);" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
          </tr>
          <?php } }?>
        </tbody>
      </table>
    </div>
    <?php }else{ ?>
    <div class="wm_tables">
      <p class="no_msgs">抱歉，您还没有任何消息</p>
    </div>
    <?php }    ?>
  </div>
</div>
</div>
</div>
</body>
<?php echo $footer; ?>