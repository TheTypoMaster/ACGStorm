<?php echo $header; ?>
<title>代购运单 - 用户在CNstorm代购网上查询代购商品运单情况</title> 
<meta name="keywords" content="代购,cnstorm代购,代购运单,代购网,代购商品" /> 
<meta name="description" content="会员直接登录CNstorm代购网代购运单查询页面,及时核查代购代购商品情况" /> 
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center">
      <div class="gwc_steps">
        <div class="gwc_step_one ml10">
          <div class="steps_nav">
            <ul class="nationa_nav step5">
              <li class="text4">确定运单信息</li>
              <li class="text5">提交运单</li>
            </ul>
          </div>
          <div class="national_addr ml10">
            <div class="shipping_addr">
              <h3>Step1：选择收货地址</h3>
              <ul class="address">
                <?php if ($address) { foreach ($address as $addres) { ?>
                <li id="<?php echo  $addres['address_id']?>">
                  <dl onclick="address(<?php echo  $addres['address_id']?>)">
                    <dt><span class="nam<?php echo  $addres['address_id']?>"><?php echo  $addres['lastname']?></span><span class="num<?php echo  $addres['address_id']?>"><?php echo $addres['telephone'];?></span></dt>
                    <dd class="city<?php echo  $addres['address_id']?>"><?php echo  $addres['name']." ".$addres['city'];?></dd>
                    <dd class="road<?php echo  $addres['address_id']?>"><?php echo  $addres['address_1']." ".$addres['address_2']?></dd>
                  </dl>
                  <span class="edit"><a href="javascript:void(0);" onClick="edit_address(<?php echo  $addres['address_id']?>)">编辑</a></span> </li>
                <?php  }}  ?>
                <li class="use_newadd" id="00" onClick="add_form()"> <a class="add" href="javascript:void(0);">使用新地址</a> </li>
              </ul>
              <div class="write_addr" id="address_info" style="display:none;">
                <form>
                  <div class="addr"> <span class="addr_l">姓名：</span>
                    <input type="text" id="consignee" placeholder="收货人姓名" value="" class="addr_input">
                    <span class="error" id="no_name"><em>请输入收件人姓名</em><i></i></span> </div>
                  <div class="addr"> <span class="addr_l">详细地址：</span>
                    <select class="addr_select" id="country_id" onchange="show_city(this)">
                      <option value="">请选择国家</option>
                      <?php foreach ($countries as $country) { ?>
                      <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                      <?php } ?>
                    </select>
                    <select name="zone_id" id="zone_id" class="addr_select" onchange="this_city()">
                      <option value="">选择洲/省/郡</option>
                    </select>
                    <input id="country_en" type="hidden" value=""/>
                    <input id="city_en" type="hidden" value=""/>
                    <textarea id="add_details" value="" placeholder="城市以及路名或街道地址，门牌号"></textarea>
                    <span id="no_add" class="error top_57"><em>详细地址长度太短，至少 为10个字符。</em><i></i></span> </div>
                  <div class="addr"> <span class="addr_l">邮政编码：</span>
                    <input type="text" id="postcode" value="" placeholder="邮政编码" class="addr_input">
                    <span id="no_code" class="error"><em>请输入邮政编码</em><i></i></span> </div>
                  <div class="addr"> <span class="addr_l">联系电话：</span>
                    <input type="text" id="tel" value="" placeholder="收件人联系号码" class="addr_input">
                    <span id="no_tel" class="error"><em>请输入联系电话</em><i></i></span> </div>
                  <div class="addr"> <a href="javascript:void(0);" class="btn" onclick="save_address()">保存</a> </div>
                </form>
              </div>
            </div>
            <div class="package_infor">
              <h3>Step2：确认包裹信息</h3>

            <form id="tosendorder" action="index.php?route=checkout/confirm/sendorder2" method="post">
                <div style="height:20px;line-height:20px;padding-top:5px;"><span class="info_cut_pic"><span class="cut_tip"></span></span>是否精简包装:&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="pak" value="1"/>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="pak" value="0" checked />否</div>
	    <input type="hidden" name="all_order_id" value="<?php echo $all_order_id; ?>">

              <table class="infor_tab" border="0" align="center" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td class="infor_title" colspan="5"><table border="0" align="center" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr class="infor_title">
                            <td width="12">&nbsp;</td>
                            <td width="800" class="align_l">商品信息</td>
                            <td width="110">物品重量</td>
                            <td width="138">特殊</td>
                            <td width="100">操作</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                
                
                <?php    
      if(isset($orders)) { foreach ($orders as $o) {  ?>
                <tr class="infor_contents">
                  <td width="12">&nbsp;</td>
                  <td width="800" class="align_l"><a href="<?php echo $o['link'];?>" target="_blank"><?php echo $o['name'];?></a></td>
                  <td width="110"><?php echo $o['weight'];?>g</td>
                  <td width="138"><?php echo $o['sensitive'];?></td>
                  <td width="100"><a href="javascript:void(0);" onclick="del(<?php echo $o['order_id'];?>)">放回仓库</a></td>
                </tr>
                <?php }} ?>
                  </tbody>
                
              </table>
              <div class="total_weights ml10">重量总计：<b>
                <?php if(isset($o['all_weight'])){ echo $o['all_weight']; }?>
                </b> g</div>
            
            <div class="transfer_way">
              <h3>Step3：选择运输方式<a id="modify2" onclick="show_selection('2')" style="display:none;" href="javascript:void(0);">[修改物流]</a></h3>
              <div class="comp_choose"> <span>超多专业物流路线供您选择，以最优质的服务回报您！</span>
                <ul>
                  <li><a href="javascript:void(0);">&lt;</a></li>
                  <li><a class="click" href="javascript:void(0);">&gt;</a></li>
                </ul>
              </div>
              <ul class="intro_courier" id="options2">
              </ul>

              <dl class="you_choose"  id="yunfei_jisuan">
                <dt>已选择</dt>
                <dd id="exp-box" style="display:none">
                <div class="custom_service">
                                  <ul class="service_box_address clr">
                                    <li class="">
                                      <dl class="tit" id="exp-tit">
                                        <dt>快</dt>
                                        <dd>递</dd>
                                        <dd>公</dd>
                                        <dd>司</dd>
                                      </dl>
                                      <div class="topic">
                                        <dl>
                                          <dd><span style="padding: 20px 0px 0px 27px;font-size: 25px;height: 60px;display: inline-block;text-indent: 70px;line-height: 60px;background:no-repeat scroll 0% 0% transparent" id="exp-name">快递公司</span></dd>
                                        </dl>
                                        <em>+<b id="dbf_address">0</b>￥</em> </div>
                                    </li>
                </ul>
                </div>
                </dd>
                <dd id="expresser"></dd>
                <dd><a class="save" id="save2" onclick="save_selection('2')" href="javascript:void(0);">保存</a></dd>
              </dl>
            </div>
            <div class="custom_service">
              <h3>Step4:自选增值服务<a id="modify1" style="display:none;" onclick="show_selection('1');" href="javascript:void(0);">[修改服务]</a></h3>
              <div class="service_box ml10">
                <div id="options1">
                  <ul class="cs_list">
                    <li><a class="on" id="sl0" href="javascript:void(0);" onclick="service('0');">打包策略</a></li>
                    <li><a id="sl1" href="javascript:void(0);" onclick="service('1');">订单处理</a></li>
                    <li><a id="sl2" href="javascript:void(0);" onclick="service(2);">包装材料</a></li>
                    <li><a id="sl3" href="javascript:void(0);" onclick="service(3);">增值服务</a></li>
                  </ul>
                  <ul class="cs_box" id="s0">
                    <?php if ($student==1){ ?>
                    <li onclick="dbs('3')" id="dbs3" class="border_c">
                      <dl class="top">
                        <dt>Free</dt>
                        <dd>免费体验</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>新用户及学生会员专享，默认免费保障方案。</dt>
                        <dd>免费体验+<b>0 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li onclick="dbs('0')" id="dbs0">
                      <dl class="top">
                        <dt>Starter</dt>
                        <dd>经济方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>打包员将快速及合理的为您打包，费用经济实惠。</dt>
                        <dd>仅需+<b>2.21 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <?php }else{ ?>
                    <li onclick="dbs('0')" id="dbs0" class="border_c">
                      <dl class="top">
                        <dt>Starter</dt>
                        <dd>经济方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>打包员将快速及合理的为您打包，费用经济实惠。</dt>
                        <dd>仅需+<b>2.21 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <?php } ?>
                    <li onclick="dbs('1')" id="dbs1">
                      <dl class="top">
                        <dt>Medium</dt>
                        <dd>标准方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>专属打包员为您打包并优化商品排列，可为您降低大量包裹体积。</dt>
                        <dd>仅需+<b>3.69 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li class="mr_none" onclick="dbs('2')" id="dbs2">
                      <dl class="top">
                        <dt>Pro</dt>
                        <dd>高级方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>只需少量费用，专属打包团队将为您设计最完美的打包方案极力降低您的包裹体积。</dt>
                        <dd>仅需+<b>6.15 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                  </ul>
                  <ul class="cs_box" id="s1" style="display:none;">
                    <?php if ($student==1){ ?>
                    <li onclick="dds('3')" id="dds3" class="border_c">
                      <dl class="top">
                        <dt>Free</dt>
                        <dd>免费体验</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>新用户及学生会员专享，默认免费保障方案。</dt>
                        <dd>免费体验+<b>0 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li onclick="dds('0')" id="dds0">
                      <dl class="top">
                        <dt>Starter</dt>
                        <dd>经济方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>为您检查商品并安全寄出海外，享受最高<em>600元赔付</em>，费用经济实惠。</dt>
                        <dd>仅需+<b>4.80 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <?php }else{ ?>
                    <li onclick="dds('0')" id="dds0" class="border_c">
                      <dl class="top">
                        <dt>Starter</dt>
                        <dd>经济方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>为您检查商品并安全寄出海外，享受最高<em>600元赔付</em>，费用经济实惠。</dt>
                        <dd>仅需+<b>4.80 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <?php } ?>
                    <li onclick="dds('1')" id="dds1">
                      <dl class="top">
                        <dt>Medium</dt>
                        <dd>标准方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>质检专员为您提供细致商品检查，享受问题商品免费处理及最高<em>1800元赔付</em>。</dt>
                        <dd>仅需+<b>7.26 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li class="mr_none" onclick="dds('2')" id="dds2">
                      <dl class="top">
                        <dt>Pro</dt>
                        <dd>高级方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>只需少量费用，即可获得专业质检并尊享最高<em>2500元赔付</em>。</dt>
                        <dd>仅需+<b>8.49 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                  </ul>
                  <ul class="cs_box" id="s2" style="display:none;">
                    <li onclick="bzs('0')" id="bzs0" class="border_c">
                      <dl class="top">
                        <dt>Standard</dt>
                        <dd>标准耗材</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>标准化包装方案，采用国际邮递标准耗材封装您的商品。</dt>
                        <dd>仅需+<b>1.84 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li class="mr_none" onclick="bzs('1')" id="bzs1">
                      <dl class="top">
                        <dt>Pro</dt>
                        <dd>坚固耗材</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>A+级坚固纸箱+超轻气泡膜封装全力保障货品安全 。</dt>
                        <dd>仅需+<b>3.69 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                  </ul>
                  <ul class="cs_box" id="s3" style="display:none;">
                    <li onclick="zzs('0')" id="zzs0" class="border_c">
                      <dl class="top">
                        <dt>Free</dt>
                        <dd>免费体验</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>包裹寄出后免费为我提供客服支持， 跟踪号及在线跟踪功能。</dt>
                        <dd>免费体验+<b>0 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li onclick="zzs('1')" id="zzs1">
                      <dl class="top">
                        <dt>Plan</dt>
                        <dd>提供大包裹方案</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>如果打包后包裹体积重量大于实际,邮件及站内信为我提供最具性价比的寄方案。</dt>
                        <dd>仅需+<b>1.50 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                    <li class="mr_none" onclick="zzs('2')" id="zzs2">
                      <dl class="top">
                        <dt>Photo</dt>
                        <dd>为运单拍照</dd>
                      </dl>
                      <dl class="bottom">
                        <dt>CNstorm完成包裹打后为您安排工作人员对该情况进行拍照并邮件发送给您。</dt>
                        <dd>仅需+<b>3.50 </b>RMB</dd>
                      </dl>
                      <i></i> </li>
                  </ul>
                </div>
                <div class="you_choose ml10">
                <span class="pickon" style="display:none;">已选择</span> 
                  <ul class="service_box_t clr" style="display:none;">
                    <li class="db_fee">
                      <dl class="tit">
                        <dt>打</dt>
                        <dd>包</dd>
                        <dd>策</dd>
                        <dd>略</dd>
                      </dl>
                      <div class="topic" id="db_topic">
                        <dl>
                          <dt>Free</dt>
                          <dd>免费体验</dd>
                        </dl>
                        <em>+<b id="dbf">0</b>￥</em> </div>
                    </li>
                    <li class="dd_fee" style="display:block;">
                      <dl class="tit">
                        <dt>订</dt>
                        <dd>单</dd>
                        <dd>处</dd>
                        <dd>理</dd>
                      </dl>
                      <div class="topic" id="dd_topic">
                        <dl>
                          <dt>free</dt>
                          <dd>免费体验</dd>
                        </dl>
                        <em>+<b id="ddf">0</b>￥</em> </div>
                    </li>
                    <li class="bz_fee" style="display:block;">
                      <dl class="tit">
                        <dt>包</dt>
                        <dd>装</dd>
                        <dd>材</dd>
                        <dd>料</dd>
                      </dl>
                      <div class="topic" id="bz_topic">
                        <dl>
                          <dt>Medium</dt>
                          <dd>标准耗材</dd>
                        </dl>
                        <em>+<b id="bzf">0</b>￥</em> </div>
                    </li>
                    <li class="zz_fee mr_none" style="display:block;">
                      <dl class="tit">
                        <dt>增</dt>
                        <dd>值</dd>
                        <dd>服</dd>
                        <dd>务</dd>
                      </dl>
                      <div class="topic"  id="zz_topic">
                        <dl>
                          <dt>Free</dt>
                          <dd>免费体验</dd>
                        </dl>
                        <em>+<b id="zzf">0</b>￥</em> </div>
                    </li>
                  </ul>
                </div>
                <dl class="you_choose"  id="yunfei_jisuan">
                <dt class="zzs_c_result">已选择</dt>
                <dd id="zzs_c_result"></dd>
              </dl>
                <div class="save"><a href="javascript:void(0);" onclick="save_selection(1)" id="save1">保存</a></div>
              </div>
            </div>
            <div class="billing_info">
              <h3>结算信息</h3>
              <table border="0" class="bi_table ml10" align="center" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td class="bg_head"><table border="0" align="center" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td width="229" height="29">运费（元）</td>
                            <td width="229">报关费（元）</td>
                            <td width="229">服务费（元）</td>
                            <td width="229">优惠（元）</td>
                            <td width="229">应付总额（元）</td>
                            <td width="229">会员应付总额(元)</td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                  <tr>
                    <td class="bg_cont"><table border="0" align="center" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td width="229" height="48"><b>
                              <div id="fist_yunfei"></div>
                              </b></td>
                            <td width="229"><b>
                              <div id="baoguan_yunfei"></div>
                              </b></td>
                            <td width="229"><b>
                              <div id="service_yunfei"></div>
                              </b></td>
                            <td width="229" class="dicount"><b>
                              <div id="youhui_yunfei"></div>
                              </b></td>
                            <td width="229"><b>
                              <div id="all_yunfei"></div>
                              </b></td>
                            <td width="229"><b>
                              <div id="utype_all_yunfei"></div>
                              </b></td>
                          </tr>
                        </tbody>
                      </table></td>
                  </tr>
                </tbody>
              </table>
              <input type="hidden" name="utype"  value="<?php echo $utype;?>" id="utype"/>
              <input type="hidden" name="usecoupon"  value="" id="usecoupon"/>
              <input type="hidden" name="address_id" value="" id="address_id"/>
              <input type="hidden" name="freight" value="" id="freight"/>
              <input type="hidden" name="total_amount" value="" id="total_amount"/>
              <!--input type="hidden" name="all_weight" value="<?php echo $all_weight; ?>" id="all_weight" -->
              <input type="hidden" name="serverfee" value="" id="serverfee" />
              <input type="hidden" name="all_weight" value="1001" id="all_weight" />
              <input type="hidden" name="deliveryname" value="" id="deliveryname" />
              <input type="hidden" name="did" value="" id="did" />
              <input type="hidden" name="order_all_mingan" value="<?php if(isset($order_all_mingan))echo $order_all_mingan; ?>" id="order_all_mingan"/>
              <input type="hidden" name="dabao" value="" id="dabao"/>
              <input type="hidden" name="dingdan" value="" id="dingdan"/>
              <input type="hidden" name="cailiao" value="" id="cailiao"/>
              <input type="hidden" name="zengzhi" value="" id="zengzhi"/>
              <div class="order_btn"><a onclick="Acheck();" href="javascript:void(0);">立即下单</a></div>


              <div class="coupons">
                <div class="use_coupons"> <a class="coupon" href="javascript:void(0);" onclick="usescore('coupon')">使用优惠券</a> 
                  <div class="coupons_cont" id="coupon" style="display:none;">
                    <div class="your_coupon"> <span>当前可用优惠券：<b><?php echo $coupon_total;?></b> 张</span>
                      <ul>
                        <li class="yc_l"><a>&lt;</a></li>
                        <li><em>1</em>/<?php echo $coupon_total;?></li>
                        <li class="yc_r"><a>&gt;</a></li>
                      </ul>
                    </div>
                      <div class="view_amout" style="width:570px;height:80px;overflow:hidden;margin-left:14px">
                      <div class="all_amout" style="width:<?php echo count($coupon_info)*190; ?>px;overflow:hidden;height:80px;position:relative">
                    <ul class="coupon_list">
                      <?php foreach($coupon_info as $coupon) { ?>
                      <li id=<?php echo $coupon['cid'];?>  >
                        <dl class="left">
                          <dt class="deadline"><?php echo date("Y-m-d",$coupon['addtime']). "-" . date("Y-m-d",$coupon['endtime']); ?></dt>
                          <dd class="money"><em class="price_symbol">￥</em><b class="amout"><?php echo $coupon['money']; ?></b>优惠券</dd>
                        </dl>
                        <dl class="right">
                          <dt>立</dt>
                          <dd>即</dd>
                          <dd>使</dd>
                          <dd>用</dd>
                        </dl>
                      </li>
                      <?php } ?>
                     
                    </ul>
                      </div>
                      </div>

                    <i></i> </div>
                </div>
              </div >
              <div class="note">
                <div class="add_note"> <a class='note' href='javascript:void(0);' onclick="usescore('note')">添加备注</a>
                  <ul class="coupons_cont" id='note' style="display: none;">
                    <li><i></i></li>
                    <li style='margin: 10px;'><span>请输入备注内容：</span></li>
                    <li><span class="li2">
                      <textarea id="addnote" name="addnote" style=""></textarea>
                      </span></li>
                    <li class="red">请输入备注内容!</li>
                  </ul>
                </div>
              </div>
              <div class="integral">
                <div class="use_integral"> <a class='score' onclick="usescore('score')" href="javascript:void(0);">使用积分抵消部分总额</a>
                  <ul class="integral_cont" id='score'>
                    <li><i></i></li>
                    <li><span>当前可用积分：<b><?php echo $score*0.89 ?></b>（100分=1元）</span></li>
                    <li><span>本次使用
                      <input id="scoreuse" name="scoreuse" onkeyup="newEqual(<?php echo $score*0.89 ?>);"/>
                      分,可抵扣运费 <em id="subAmount">-0.00</em> 元</span></li>
                    <li class="red">请选择邮寄方式!</li>
                    </form>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
<script src="catalog/view/javascript/jquery2/tosendorder.js"></script> 
