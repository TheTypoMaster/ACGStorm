<?php echo $header;?>

<title>我的收藏-收藏您喜欢的CNstorm代购平台商品</title>     

<meta name="keywords" content="我的收藏, 收藏商品，购物车，取消收藏，商品信息" />      

<meta name="description" content="欢迎收藏CNstorm代购平台商品，加入您的购物车" />

<div class="goods_details_bg">

  <div class="yhzx wrap">

    <div class="user_center"> <?php echo $column_left;?>

      <div class="">

        <div class="dl_head">

          <h3 class="bg3">我的收藏</h3>

        </div>

        <div class="all_dingdan">

          <div class="save_box"> 

            <!--

                          <ul class="savebox_top">

                             <li><div class="st_checkbox"><input id="savebox_chkbox" type="checkbox" ><label for="savebox_chkbox">全选</label></div></li>

                             <li><a class="gwc" href="javascript:void(0);">查看详情</a></li>

                             <li><a class="cancle_save" href="javascript:void(0);">取消收藏</a></li>  

                             <li>  

                                 <span class="package_num"> 

                                     <em>共<b>22</b>个包裹</em>                         

                                     <a class="left_go no_click" href="javascript:void(0);">&lt;</a>

                                     <em><b>1</b>/8</em>

                                     <a class="right_go"href="javascript:void(0);">&gt;</a>

                                 </span>

                             </li>

                          </ul>

                          -->

            <ul class="savebox_nav">

              <li><em class="stuff_infor"><?php echo $column_name; ?></em></li>

              <li><em class="stuff_price"><?php echo $column_price; ?></em></li>

              <li><em class="studd_ope"><?php echo $column_action; ?></em></li>

            </ul>

            <?php foreach ($products as $product) { ?>

            <ul class="savebox_cont">

              <li class="box_one">

                <ul>

                  <!--<li><input name='items' class="choose" type="checkbox" ></li>-->

                  <li>

                    <?php if ($product['thumb']) { ?>

                    <a href="<?php echo $product['href']; ?>"  target="_blank"><img class="photo" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a></li>

                  <?php } ?>

                  <li>

                    <dl class="detail">

                      <dt><a href="<?php echo $product['href']; ?>"  target="_blank"><?php echo $product['name']; ?></a></dt>

                      <!--<dd>收藏时间：2014-5-5</dd>-->

                    </dl>

                  </li>

                </ul>

              </li>

              <li class="single">

                <?php if (!$product['special']) { ?>

                <b>￥<?php echo $product['price']; ?></b></li>

              <?php } else { ?>

              <b>￥<?php echo $product['special']; ?></b>

              </li>

              <?php } ?>

              <li class="operation"><a class="look_more" href="<?php echo $product['addCart']; ?>" target="_blank">添加购物车</a><a href="<?php echo $product['remove']; ?>">取消收藏</a></li>

            </ul>

            <?php } ?>

            

            <!--

                          <div class="savebox_bott">

                             <ul class="savebox_top">

                               

                               <li><div class="st_checkbox"><input type="checkbox" id="savebox_chkbox1"><label for="savebox_chkbox1">全选</label></div></li>

                               <li><a href="javascript:void(0);" class="gwc">加入购物车</a></li>

                               <li><a href="javascript:void(0);" class="cancle_save">取消收藏</a></li>  

                               <li>

                                   <span class="package_num"> 

                                       <em>共<b>22</b>个包裹</em>                         

                                       <a href="javascript:void(0);" class="left_go no_click">&lt;</a>

                                       <em><b>1</b>/8</em>

                                       <a href="javascript:void(0);" class="right_go">&gt;</a>

                                   </span>

                               </li>

                            </ul>

                          </div>

                          --> 

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

</div>

<?php echo $footer;?> 
