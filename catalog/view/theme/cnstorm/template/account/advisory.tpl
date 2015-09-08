<title>客服咨询-请及时客服咨询遇到的问题</title>     
<meta name="keywords" content="账户管理, CNstorm账户,账户中心，客服咨询，客服，CNstorm客服，咨询问题" />      
<meta name="description" content="对cnstorm账户问题、包裹问题、订单问题或充值问题，请及时咨询我们的客服" />
<?php echo $header; ?>


<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="daigou_list">
        <div class="dl_head">
          <h3 class="bg11">客服留言咨询</h3>
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
              <input value="提交问题"  onclick="toQuery()" /><span class="red" id="wrong_query" style="display: none;">请输入后再点击回复！</span>
            </div>
          </form>
          <div class="consult_record">
            <h3>留言咨询记录</h3>
            <p class="cr_head"> <span>咨询/回复</span>
              <select class="question_type" name="question_type">
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
                      <!--
                      <div class="pages_change">
                          <ul class="list_num">
                              <li class="pages_left"><a href="javascript:void(0);">&lt;</a></li><li>
                              </li><li class="number on"><a href="javascript:void(0);">1</a></li><li>
                              </li><li class="number"><a href="javascript:void(0);">2</a></li><li>
                              </li><li class="number"><a href="javascript:void(0);">3</a></li><li>
                              </li><li class="number"><a href="javascript:void(0);">4</a></li><li>
                              </li><li class="number"><a href="javascript:void(0);">5</a></li><li>
                              </li><li class="dot">...</li>
                              <li class="pages_right"><a href="javascript:void(0);">&gt;</a></li><li>
                              </li><li class="infor">共 50 页，到第</li>
                              <li class="go_direct"><input type="text" value="" class="gd_input"/></li>
                              <li class="infor">页</li>
                              <li class="btn"><a href="javascript:void(0);">确定</a></li>
                          </ul>
                      </div>
                      -->
                  </div>                  
              </div>              
          </div>
     </div>
  </div>
</div>
<?php echo $footer; ?>