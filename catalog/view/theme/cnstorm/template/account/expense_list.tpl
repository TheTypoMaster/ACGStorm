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
      </div>