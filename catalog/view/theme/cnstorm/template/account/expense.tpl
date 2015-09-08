<title><?php echo $heading_title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<?php echo $header; ?>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="dl_head">
        <h3 class="bg8">消费记录</h3>
      </div>
      <div id="dvContent">
        <div class="all_dingdan" style="position:relative;">
          <div class="rmb_accout">
            <div class="rmb_recharge">
              <div class="record">
                <table class="record_table" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="record_head">
                      <td width="230">最近交易</td>
                      <td width="280">消费详情</td>
                      <td width="100">消费金额(￥)</td>
                      <td width="110">账户余额(￥)</td>
                      <td><select>
                          <option value="0">全部类型</option>
                          <option value="1">代购订单</option>
                          <option value="2">国际运单</option>
                          <option value="3">价格调整</option>
                        </select></td>
                      <td width="100">备注</td>
                    </tr>
                    <?php if($record_info) { ?>
                    <?php foreach($record_info as $record) { ?>
                    <tr class="rt_one">
                      <td>流水号：<?php echo $record['rid'] ; ?><br>
                        交易时间：<?php echo date("Y-m-d H:i:s",$record['addtime']) ; ?></td>
                      <td><?php echo $record['remark'] ; ?></td>
                      <td><b><?php echo $record['money'] ; ?></b></td>
                      <td><b><?php echo $record['accountmoney'] ; ?></b></td>
                      <?php if(1 == $record['action'] || 2 == $record['action']) { ?>
                      <td>代购订单</td>
                      <?php }else if(3 == $record['action']) { ?>
                      <td>国际运单</td>
                      <?php }else if(5 == $record['action']) { ?>
                      <td>价格调整</td>
                      <?php }else{ ?>
                      <td></td>
                      <?php } ?>
                      <?php if($record['remarktype']) { ?>
                      <td><a onclick="record_list(<?php echo $record['rid'];?>)">备注详情</a></td>
                      <?php }else{ ?>
                      <td></td>
                      <?php } ?>
                    </tr>
                    <?php } } ?>
                  </tbody>
                </table>
                <div class="pages_change "><?php echo $pagination; ?></div>
              </div>
            </div>
          </div>
          <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
            <svg xmlns="http://www.w3.org/2000/svg" width="960px" height="960px" viewBox="0 0 80 60" preserveAspectRatio="none" >
              <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
            </svg>
          </div>
        </div>
      </div><!-- /dvContent -->
    </div>
  </div>
</div>
</div>
</div>
<script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script> 
<script type="text/javascript">
  $(function(){
    $(document).on('click','.pages_change ul li a',function(){
      var loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 400, easingIn : mina.easeinout } );
      var url = $(this).attr('href');
      loader.show();
      window.scrollTo(0,475);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
          loader.hide();
          setTimeout(function(){$('#dvContent').html(data);}, 500);
        }
      });
      return false;
    });
});

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

    url = "index.php?route=account/expense/record_list&rid=" + rid;

    openwindow(url, '', 490, 525);
}
</script> 
<?php echo $footer; ?>