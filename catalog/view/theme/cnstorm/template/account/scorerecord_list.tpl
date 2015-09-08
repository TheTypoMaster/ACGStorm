<div class="all_dingdan" style="margin-top:0;position:relative;">
  <div class="rmb_accout">                          
      <div class="rmb_recharge" style="margin-top:0;"> 
          <div class="record">                                  
              <table class="record_table" border="0" align="center" cellspacing="0" cellpadding="0">
                  <tbody>
                      <tr class="record_head">
                         <td width="120">总积分</td>
                         <td width="300">变更详情</td>
                         <td width="120">积分详情</td>
                         <td width="120">获取方式</td>
                         <td width="120">获取时间</td>
                      </tr>
                      <?php if($scorerecord_info) { ?>
                      <?php foreach($scorerecord_info as $scorerecord) { ?>
                      <tr class="rt_one">
                         <td><?php echo $scorerecord['totalscore'] ;?></td>
                         <td><?php echo $scorerecord['remark'] ;?></td>
                         <td><?php echo $scorerecord['score'] ;?></td>
                         <?php if(1 == $scorerecord['type']) { ?>
                         <td>活动获取</td>
                         <?php }else if(2 == $scorerecord['type']) {?>
                         <td>消费支出</td>
                         <?php }else{?>
                         <td>不知道</td>
                         <?php } ?>
                         <td><?php echo date("Y-m-d",$scorerecord['addtime']) ;?></td>
                      </tr> 
                      <?php }  } ?>
                  </tbody>
              </table>
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
                    <li class="go_direct"><input type="text" class="gd_input" value=""></li>
                    <li class="infor">页</li>
                    <li class="btn"><a href="javascript:void(0);">确定</a></li>
                </ul>
            </div>
            -->
          </div>
      </div>
  </div>
  <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
    <svg xmlns="http://www.w3.org/2000/svg" width="960px" height="960px" viewBox="0 0 80 60" preserveAspectRatio="none" >
      <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
    </svg>
  </div>
</div>                  