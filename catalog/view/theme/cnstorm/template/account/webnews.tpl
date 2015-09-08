<title>站内消息-及时关注CNstorm账户的账户管理</title>     
<meta name="keywords" content=" 账户管理, CNstorm账户,账户中心，账户消息，交易消息，站内消息，系统消息" />      
<meta name="description" content="登录您的cnstorm代购账户中心，及时查看交易消息、站内消息和系统消息" />
<?php echo $header; ?>


<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="">
        <div class="dl_head">
          <h3 class="bg10">站内消息</h3>
        </div>
        <div class="all_dingdan" style="width:940px;">
          <ul class="dingdan_list">
            <li><a href="javascript:void(0);" onfocus="this.blur()" class="on">全部消息（<b class="bold"><?php echo $pm_info_total; ?></b>）</a></li>
            <li><a href="javascript:void(0);" onfocus="this.blur()">交易消息（<b class="bold"><?php echo $business_info_total; ?></b>）</a></li>
            <li><a href="javascript:void(0);" onfocus="this.blur()">系统消息（<b class="bold"><?php echo $system_info_total; ?></b>）</a></li>
          </ul>
          <?php if($pm_info) { ?>
          <div class="wm_tables">
            <table class="website_msg" border="0" align="center" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><table border="0" align="center" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td height="28"><ul class="savebox_top">
                              <li>
                                <div class="st_checkbox">
                                  <input id="savebox_chkbox" type="checkbox">
                                  <label for="savebox_chkbox">全选</label>
                                </div>
                              </li>
                              <li><a class="mark_read" href="javascript:void(0);">设为已读</a></li>
                              <li><a class="mark_delete" href="javascript:void(0);">删除</a></li>
                              <li> <span class="package_num"> <em>共<b><?php echo $pm_info_total; ?></b>条消息</em> <a class="left_go no_click" href="javascript:void(0);">&lt;</a> <em><b>1</b>/8</em> <a class="right_go" href="javascript:void(0);">&gt;</a> </span> </li>
                            </ul></td>
                        </tr>
                        <tr>
                          <td height="33"><ul class="msg_list">
                              <li class="tit">标题</li>
                              <li class="time">时间</li>
                              <li>
                                <select class="markread_select">
                                  <option>已读</option>
                                  <option>未读</option>
                                </select>
                              </li>
                              <li class="ope">操作</li>
                            </ul></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table>
            <table class="website_list" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <?php foreach($pm_info as $pm) {?>
                <?php if(0 == $pm['hasview']) { ?>
                <tr class="bo not_read">
                  <td width="13">&nbsp;</td>
                  <td width="12"><input type="checkbox" /></td>
                  <td width="11">&nbsp;</td>
                  <td width="514" class="texts bold"><a href="javascript:void(0);" target="_blank" onClick="webnews(<?php echo $pm['mid'] ; ?>);"><?php echo $pm['subject'] ; ?></a></td>
                  <td width="145"><?php echo date("Y-m-d H:i:s",$pm['sendtime']) ; ?></td>
                  <td width="116" align="center">未读</td>
                  <td width="119" align="center"><a href="javascript:void(0);" target="_blank" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
                </tr>
                <?php }else if(1 == $pm['hasview']) { ?>
                <tr class="bo read">
                  <td width="13">&nbsp;</td>
                  <td width="12"><input type="checkbox" /></td>
                  <td width="11">&nbsp;</td>
                  <td width="514" class="texts"><?php echo $pm['subject'] ; ?></td>
                  <td width="145"><?php echo date("Y-m-d H:i:s",$pm['sendtime']) ; ?></td>
                  <td width="116" align="center">已读</td>
                  <td width="119" align="center"><a href="javascript:void(0);" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
                </tr>
                <?php } }?>
              </tbody>
            </table>
            <table class="website_msg margin_bot" border="0" align="center" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td height="28"><ul class="savebox_top">
                      <li>
                        <div class="st_checkbox">
                          <input id="savebox_chkbox" type="checkbox">
                          <label for="savebox_chkbox">全选</label>
                        </div>
                      </li>
                      <li><a class="mark_read" href="javascript:void(0);">设为已读</a></li>
                      <li><a class="mark_delete" href="javascript:void(0);">删除</a></li>
                      <li> <span class="package_num"> <em>共<b><?php echo $pm_info_total; ?></b>条消息</em> <a class="left_go no_click" href="javascript:void(0);">&lt;</a> <em><b>1</b>/8</em> <a class="right_go" href="javascript:void(0);">&gt;</a> </span> </li>
                    </ul></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php }else{ ?>
          <div class="wm_tables">
            <p class="no_msgs">抱歉，您还没有任何消息</p>
          </div>
          <?php }    ?>
          <?php if($business_info) {?>
          <div class="wm_tables" style="display:none;">
            <table class="website_msg" border="0" align="center" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><table border="0" align="center" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td height="28"><ul class="savebox_top">
                              <li>
                                <div class="st_checkbox">
                                  <input id="savebox_chkbox" type="checkbox">
                                  <label for="savebox_chkbox">全选</label>
                                </div>
                              </li>
                              <li><a class="mark_read" href="javascript:void(0);">设为已读</a></li>
                              <li><a class="mark_delete" href="javascript:void(0);">删除</a></li>
                              <li> <span class="package_num"> <em>共<b><?php echo $business_info_total; ?></b>条消息</em> <a class="left_go no_click" href="javascript:void(0);">&lt;</a> <em><b>1</b>/8</em> <a class="right_go" href="javascript:void(0);">&gt;</a> </span> </li>
                            </ul></td>
                        </tr>
                        <tr>
                          <td height="33"><ul class="msg_list">
                              <li class="tit">标题</li>
                              <li class="time">时间</li>
                              <li>
                                <select class="markread_select">
                                  <option>已读</option>
                                  <option>未读</option>
                                </select>
                              </li>
                              <li class="ope">操作</li>
                            </ul></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table>
            <table class="website_list" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <?php foreach($business_info as $business) {?>
                <?php if(0 == $business['hasview']) { ?>
                <tr class="bo not_read">
                  <td width="13">&nbsp;</td>
                  <td width="12"><input type="checkbox" /></td>
                  <td width="11">&nbsp;</td>
                  <td width="514" class="texts bold"><?php echo $business['subject'] ; ?></td>
                  <td width="145"><?php echo date("Y-m-d H:i:s",$business['sendtime']) ; ?></td>
                  <td width="116" align="center">未读</td>
                  <td width="119" align="center"><a href="javascript:void(0);" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
                </tr>
                <?php }else if(1 == $pm['hasview']) { ?>
                <tr class="bo read">
                  <td width="13">&nbsp;</td>
                  <td width="12"><input type="checkbox" /></td>
                  <td width="11">&nbsp;</td>
                  <td width="514" class="texts"><?php echo $business['subject'] ; ?></td>
                  <td width="145"><?php echo date("Y-m-d H:i:s",$business['sendtime']) ; ?></td>
                  <td width="116" align="center">已读</td>
                  <td width="119" align="center"><a href="javascript:void(0);" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
                </tr>
                <?php }  } ?>
              </tbody>
            </table>
            <table class="website_msg margin_bot" border="0" align="center" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td height="28"><ul class="savebox_top">
                      <li>
                        <div class="st_checkbox">
                          <input id="savebox_chkbox" type="checkbox"/>
                          <label for="savebox_chkbox">全选</label>
                        </div>
                      </li>
                      <li><a class="mark_read" href="javascript:void(0);">设为已读</a></li>
                      <li><a class="mark_delete" href="javascript:void(0);">删除</a></li>
                      <li> <span class="package_num"> <em>共<b><?php echo $business_info_total; ?></b>条消息</em> <a class="left_go no_click" href="javascript:void(0);">&lt;</a> <em><b>1</b>/8</em> <a class="right_go" href="javascript:void(0);">&gt;</a> </span> </li>
                    </ul></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php }else{ ?>
          <div class="wm_tables" style="display:none;">
            <p class="no_msgs">抱歉，您还没有任何消息</p>
          </div>
          <?php }  ?>
          <?php if($system_info) {?>
          <div class="wm_tables" style="display:none;">
            <table class="website_msg" border="0" align="center" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td><table border="0" align="center" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td height="28"><ul class="savebox_top">
                              <li>
                                <div class="st_checkbox">
                                  <input id="savebox_chkbox" type="checkbox">
                                  <label for="savebox_chkbox">全选</label>
                                </div>
                              </li>
                              <li><a class="mark_read" href="javascript:void(0);">设为已读</a></li>
                              <li><a class="mark_delete" href="javascript:void(0);">删除</a></li>
                              <li> <span class="package_num"> <em>共<b><?php echo $system_info_total; ?></b>条消息</em> <a class="left_go no_click" href="javascript:void(0);">&lt;</a> <em><b>1</b>/8</em> <a class="right_go" href="javascript:void(0);">&gt;</a> </span> </li>
                            </ul></td>
                        </tr>
                        <tr>
                          <td height="33"><ul class="msg_list">
                              <li class="tit">标题</li>
                              <li class="time">时间</li>
                              <li>
                                <select class="markread_select">
                                  <option>已读</option>
                                  <option>未读</option>
                                </select>
                              </li>
                              <li class="ope">操作</li>
                            </ul></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table>
            <table class="website_list" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <?php foreach($system_info as $system) {?>
                <?php if(0 == $system['hasview']) { ?>
                <tr class="bo not_read">
                  <td width="13">&nbsp;</td>
                  <td width="12"><input type="checkbox" /></td>
                  <td width="11">&nbsp;</td>
                  <td width="514" class="texts bold"><?php echo $system['subject'] ; ?></td>
                  <td width="145"><?php echo date("Y-m-d H:i:s",$system['sendtime']) ; ?></td>
                  <td width="116" align="center">未读</td>
                  <td width="119" align="center"><a href="javascript:void(0);" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
                </tr>
                <?php }else if(1 == $pm['hasview']) { ?>
                <tr class="bo read">
                  <td width="13">&nbsp;</td>
                  <td width="12"><input type="checkbox" /></td>
                  <td width="11">&nbsp;</td>
                  <td width="514" class="texts"><?php echo $system['subject'] ; ?></td>
                  <td width="145"><?php echo date("Y-m-d H:i:s",$system['sendtime']) ; ?></td>
                  <td width="116" align="center">已读</td>
                  <td width="119" align="center"><a href="javascript:void(0);" onClick="webnews(<?php echo $pm['mid'] ; ?>);">查看</a>/<a href="javascript:void(0);" onClick="pm_delete(<?php echo $pm['mid'] ; ?>);">删除</a></td>
                </tr>
                <?php }  }?>
              </tbody>
            </table>
            <table class="website_msg margin_bot" border="0" align="center" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td height="28"><ul class="savebox_top">
                      <li>
                        <div class="st_checkbox">
                          <input id="savebox_chkbox" type="checkbox"/>
                          <label for="savebox_chkbox">全选</label>
                        </div>
                      </li>
                      <li><a class="mark_read" href="javascript:void(0);">设为已读</a></li>
                      <li><a class="mark_delete" href="javascript:void(0);">删除</a></li>
                      <li> <span class="package_num"> <em>共<b><?php echo $system_info_total; ?></b>条消息</em> <a class="left_go no_click" href="javascript:void(0);">&lt;</a> <em><b>1</b>/8</em> <a class="right_go" href="javascript:void(0);">&gt;</a> </span> </li>
                    </ul></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php }else{ ?>
          <div class="wm_tables" style="display:none;">
            <p class="no_msgs">抱歉，您还没有任何消息</p>
          </div>
          <?php }  ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>