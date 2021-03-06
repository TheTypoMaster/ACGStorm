<?php echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> 晒尔推荐</h1>
    </div>
    <div class="content">
      <table class="list">
      <tbody>
        <tr class="filter">
          <td><a href="javascript:location.reload();"><img src="/orange/view/image/refresh.gif" alt="刷新" width="28" height="20"></a></td>
          <td>用户名：<input id="filter_uname" value="" /><a onclick="filter();" class="button">筛选</a></td>
          <td><a href="index.php?route=community/saiercomment&token=<?php echo $token; ?>&appr=1" class="button">查看已推荐消息</a></td>
        </tr>
    </table>
    <table class="list">
      <thead>
        <tr>
          <td class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="center">ID</td>
          <td class="center">消息发送人</td>   
          <td class="center">类型</td>  
          <td class="center" style='width:9%'>国家</td>  
          <td class="center" style='width:22%'>消息</td>
          <td class="center" style='width:20%'>图片</td>
          <td class="center" style='width:18%'>视频</td>
          <td class="center" style='width:5%'>显示/屏蔽</td>
          <td class="center" style='width:4%'>状态</td>
          <td class="center">发送时间</td>
          <td class="center" style='width:8%'>操作</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($orders) {  
       foreach ($orders as $order) {    
      ?>
        <tr>
          <td style="text-align: center;"><?php if ($order['selected']) { ?>
            <input type="checkbox" name="selected[]" value="<?php echo $order['message_id']; ?>" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="selected[]" value="<?php if ( isset($order['message_id']) )  echo $order['message_id']; ?>" />
            <?php } ?></td>
          <td class="center"><?php echo $order['message_id']; ?></td>
          <td class="center" id="from"><?php echo $order['fromuname']; ?></td>    
          <td class="center"><?php echo $order['if_show']; ?></td>

          <td class="center"><input id="countryValue<?php echo $order['message_id']; ?>" type="text" size="6" value="<?php echo $order['country']; ?>" />
              <a onclick="modifyCountry(<?php echo $order['message_id']; ?>)" style="text-decoration:none;border:1px solid green;padding:2px;margin-left:5px;">
                  <font color="green">修改</font>
              </a>
          </td>

          <td class="left"><?php echo $order['message'];?></td>


          <td class="center"><?php if (is_array($order['imgurl'])){ 
          foreach ( $order['imgurl'] as $v  ){ ?>
          <img width="80" height="80" src="<?php echo $v; ?>" />
          <?php } } ?>
          </td>
          <td class="center"><?php if ($order['videourl'] && $order['videoMassage']){?><img width="160" height="100" src="<?php echo $order['videoMassage'];?>" /><?php } ?></td>

           <td class="center">
           <?php if ($order['approved']==1){ ?>
           <a href="javascript:;" style="text-decoration:none;" id="m<?php echo $order['message_id']; ?>" onclick='showMessage(<?php echo $order['message_id']; ?>)'><font color="green">显示</font></a>
           <?php }else{ ?>
           <a href="javascript:;" style="text-decoration:none;" id="m<?php echo $order['message_id']; ?>" onclick='showMessage(<?php echo $order['message_id']; ?>)'><font color="red">隐藏</font></a>
           <?php }?>
	   <?php if ($order['recomment']==0){ ?>
           <a href="javascript:;" style="text-decoration:none;" id="rec<?php echo $order['message_id']; ?>" onclick='showRecomment(<?php echo $order['message_id']; ?>)'><font color="red">&nbsp;荐</font></a>
           <?php }else{ ?>
           <a href="javascript:;" style="text-decoration:none;" id="rec<?php echo $order['message_id']; ?>" onclick='showRecomment(<?php echo $order['message_id']; ?>)'><font color="green">&nbsp;已荐</font></a>
           <?php }?>
           </td>

          <td class="center">
          <?php if ($order['if_show']==1){ ?>
          <a href="javascript:;" style="text-decoration:none;" id=<?php echo $order['message_id']; ?> onclick='showComment(<?php echo $order['message_id']; ?>)'><font color="green">已推荐</font></a>        
          <?php }else{ ?>
          <a href="javascript:;" style="text-decoration:none;" id=<?php echo $order['message_id']; ?> onclick='showComment(<?php echo $order['message_id']; ?>)'><font color="red">未推荐</font></a>
          <?php }?></td>


          <td class="center"><?php echo $order['sendtime'];?></td>
          <td class="center"><a href="javascript:;" onclick="del(<?php echo $order['message_id']; ?>)" style="color:red;text-decoration:none;">删除</a>&nbsp;
          <?php if ($order['zhiding']==0){ ?>
          <a href="javascript:;" id="zhiding<?php echo $order['message_id']; ?>" onclick="zhiding(<?php echo $order['message_id']; ?>)" style="color:red;text-decoration:none;">置顶</a>
          <?php }else if ($order['zhiding']==1){ ?>
	  <a href="javascript:;" id="zhiding<?php echo $order['message_id']; ?>" onclick="cancelZhiding(<?php echo $order['message_id']; ?>)" style="color:green;text-decoration:none;">取消置顶</a>
	  <?php } ?>
	  </td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">

function modifyCountry(id){
     var country = $('#countryValue'+id).val();
     $.ajax({
      url:'index.php?route=community/saiercomment/modifyCountry&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id,country:country},
      type:"POST",
      success:function(req){
        alert('修改成功');
        window.location.reload();
      },
      error:function(){
        alert('fail request!');
      }
    });
}

function showComment(id){
      $.ajax({
      url:'index.php?route=community/saiercomment/showComments&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id},
      type:"POST",
      success:function(req){
        if(req == 1){
          $("#"+id).html(' ');
          $("#"+id).html('<font color="red">未推荐</font>');
        }else if (req == 0){
           $("#"+id).html(' ');
           $("#"+id).html('<font color="green">已推荐</font>');     
        }else if (req == 2){
           alert('只能推荐5条');
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}

function showMessage(id){
      $.ajax({
      url:'index.php?route=community/saiercomment/showMessage&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id},
      type:"POST",
      success:function(req){
        if(req == 1){
          $("#m"+id).html(' ');
          $("#m"+id).html('<font color="red">隐藏</font>');
        }else if (req == 0){
           $("#m"+id).html(' ');
           $("#m"+id).html('<font color="green">显示</font>');     
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}

function showRecomment(id){
      $.ajax({
      url:'index.php?route=community/saiercomment/showRecomment&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id},
      type:"POST",
      success:function(req){
        if(req == 1){
          $("#rec"+id).html(' ');
          $("#rec"+id).html('<font color="red">荐</font>');
        }else if (req == 0){
           $("#rec"+id).html(' ');
           $("#rec"+id).html('<font color="green">已荐</font>');     
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}

function del(id){
if (confirm("是否删除消息！")){
    $.ajax({
      url:'index.php?route=community/saiercomment/delMessage&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id},
      type:"POST",
      success:function(req){
        if(req == 1){
             window.location.reload();
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}
}

function zhiding(id){
    $.ajax({
      url:'index.php?route=community/saiercomment/zhidingMessage&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id},
      type:"POST",
      success:function(req){
        if(req == 1){
            $("#zhiding"+id).html(' ');
            $("#zhiding"+id).html('<font color="green">取消置顶</font>');
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}

function cancelZhiding(id){
    $.ajax({
      url:'index.php?route=community/saiercomment/cancelZhidingMessage&token=<?php echo $token; ?>',
      dataType:"json",
      data:{message_id:id},
      type:"POST",
      success:function(req){
        if(req == 1){
            $("#zhiding"+id).html(' ');
            $("#zhiding"+id).html('<font color="red">置顶</font>');
        }
      },
      error:function(){
        alert('fail request!');
      }
    });
}
</script> 
<script type="text/javascript">
function filter(){
url = 'index.php?route=community/saiercomment&token=<?php echo $token; ?>';
var filter_uname = $("#filter_uname").val();
if(filter_uname){
url += '&filter_uname=' + encodeURIComponent(filter_uname);
}
location = url;
}
</script> 
<?php echo $footer; ?> 