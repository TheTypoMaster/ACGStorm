<div id="dvMenu" class="comment">
                    <ul>
                        <li  class="<?php if('points' != $sort && 'comments' != $sort) echo 'active'; ?>"><a href="<?php echo $moreall; ?>">全部</a></li>
                        <li  class="<?php if('points' == $sort) echo 'active'; ?>"><a href="<?php echo $morepoints;?>">最赞</a></li>
                        <li  class="<?php if('comments' == $sort) echo 'active'; ?>"><a href="<?php echo $morecomments;?>">热评</a></li>
                    </ul>
                    <form id="message_deliver" action="index.php?route=social/social" method='post'>
                    <ul class="sch">
                        <li><input type="text" name="search" value=""/></li>
                        <li><button class="search_sub"><span></span></button></li>
                    </ul>
                    </form>
                </div>



                <div login="<?php if (isset($logged)) echo $logged; ?>" class="bask_rec_box new_c_tip" style='background:#fffadc;height:24px;padding:0px;line-height:24px;text-align:center;color:#e27b00;display:none'>有<span class='new_c_lgt'>3</span>篇新贴子， <span><a href="javascript:window.location.reload()" style="color:#e27b00">点击查看</a></span></div>
                <?php foreach($message_info as $message) { ?>

                <div class="bask_rec_box" id="jmp_<?php echo $message['message_id']; ?>">
		    <?php if(1 == $message['zhiding']) { ?>
                    <span class="country"> <img src="catalog/view/theme/cnstorm/images/social/zhiding.jpg"></span>
                    <?php } ?>
		    <?php if(1 == $message['recomment']) { ?>
                    <span class="country"> <img src="catalog/view/theme/cnstorm/images/social/recomment.png"></span>
                    <?php } ?>
                    <div class="bask_rec_item" id="jmp_<?php echo $message['message_id']; ?>"><img class="face" src="<?php echo $message['face'];?>"/><span><?php echo $message['firstname'];?></span>
                    <span class="vip"><img src="<?php echo 'catalog/view/theme/cnstorm/images/social/vip'.$message['utype'].'.jpg'; ?>"></span>
                    <span class="country"><?php echo $message['country'];?>
                    <?php if($customer_id == $message['customer_id']) { ?>
                    <span class="del_comment" id="<?php echo $message['message_id']; ?>"> 删除 </span>
                    <?php } ?>
                    </span></div>
                    <div class="bask_rec_text emoji-ubb" id="<?php echo "com_".$message['message_id']; ?>">
                    <?php if(isset($post_key_word)){$message['message_text'] = str_replace($post_key_word,"<font color='red'>$post_key_word</font>",$message['message_text']);} echo $message['message_text'];?>
                    </div>


                    <?php if($message['imgurl']){
                     $imgs = explode("|" , $message['imgurl']); ?>
                     <div class="bask_rec_images view-image-list">
                          <?php foreach($imgs as $v) {
                            if($v) {
                                $posDot = strrpos ( $v, '.' );
                                $strExt = substr ( $v, $posDot );
                                if ($strExt == '.gif'){
                                  $posXie = strrpos ( $v, '/' );
                                  $strFile = substr ( $v, $posXie );
                                  $strFile = explode ( '-', $strFile );
                                  $strFile = $strFile[0];
                                  $v = "uploads/big" . $strFile . $strExt;
                                } ?>
                                <img width="76" height="76" src="<?php echo $v;?>"/>
                            <?php } 
                          }?>
                     </div>
                    <?php }?>
                    <div class="bask_image_box" id="<?php echo "com_".$message['message_id']; ?>">
                        <div class="bask_image_box_op"><span class="up_down"></span><span class="updown">收起</span><span class="res"></span>
                        <span class="viewres" img_src="<?php if (isset($message['imgurls'])) echo $message['imgurls'];?>">查看原图</span></div>
			<div class="left">$nbsp;</div>
			<div class="right">$nbsp;</div>
                        <div class="bask_image_big" style="WHITE-SPACE:nowrap;">
                        <img src="<?php if (isset($message['strFile'])) echo $message['strFile'];?>"/>
                        </div>
                        <?php $imgs = explode("|" , $message['imgurl']);
                              $imgs = array_filter($imgs);
                        if(count($imgs)>1) {  ?>     
                        <div class="bask_iamge_sm">
                            <ul class="bask_iamge_sm_ul">
                                <?php $imgs = explode("|" , $message['imgurl']);
                                      foreach($imgs as $k => $img) {  
                                      if($img) {
                                        $posDot = strrpos ( $img, '.' );
                                        $strExt = substr ( $img, $posDot );
                                        $posXie = strrpos ( $img, '/' );
                                        $strFile = substr ( $img, $posXie );
                                        $strFile = explode ( '-', $strFile );
                                        $strFile = $strFile[0];
                                        $strFile = "uploads/big" . $strFile . $strExt; 
                                } ?>
                                       <li index="<?php echo $k; ?>"><img iname="<?php echo $strFile;?>" src="<?php echo $img;?>"/><span></span></li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                            <div class="f-clear"></div>
             <?php if ($message['videourl'] && $message['videoMassage']){ ?>
                <div class="video_play" style="padding-top:3px; float:left;position:relative">
            <img id="com_<?php echo $message['message_id']?>" class="open_vedio" src="<?php echo $message['videoMassage']['img'];?>" height="95" width="200">
            <div id="com_<?php echo $message['message_id']?>" class="open_vedio" style="position:absolute;width: 200px;height:95px;top:0px;left:0px;cursor:pointer;border-radius:4px;"><img src="catalog/view/theme/cnstorm/images/video_hover.png"/></div>
            <div id="com_<?php echo $message['message_id']?>" class="vedio" style="display:none;">
                <div class="f-clear"></div>
             <div>
                    <a style="float:right" target="_new" href="<?php echo $message['videoMassage']['url'];?>"><?php echo $message['videoMassage']['title'];?></a>
                    <a class="close_vedio" id="com_<?php echo $message['message_id']?>" href="javascript:;">关闭</a>

                </div><embed src="<?php echo $message['videoMassage']['swf'];?>" quality="high" width="480" height="400" align="middle" allowNetworking="all" allowScriptAccess="always" type="application/x-shockwave-flash"></embed></div>

            </div>
<?php } ?>
                    <div class="tag_theme_box">
                                <div class="theme_item"> 
                                <?php $theme_info = explode("|" , $message['theme_id']);
                                      $theme_info = array_filter($theme_info);
                                      foreach($theme_info as $info) { ?>
                                <span><?php echo $theme_array[$info]; ?></span>          
                                <?php     }    ?>
                                </div>
                    </div>
                    <div class="f-clear"></div>
                    <div class="bask_rec_like" id="<?php echo $message['message_id']?>" login="<?php if (isset($logged)) echo $logged; ?>" ><span class="image"></span><span class="tot"><?php echo $message['points'];?></span></div>
                    <div class="bask_rec_com_share">
                        <span class="com comt" id="<?php echo "com_".$message['message_id']; ?>" login="<?php if (isset($logged)) echo $logged; ?>">评论(<?php echo $message['comments'];?>)</span><!--span class="share" id="<?php echo "com_".$message['message_id']; ?>">分享</span-->
                        <div class="comment_share_box" id="<?php echo "com_".$message['message_id']; ?>"></div>
                    </div>
                    <div class="f-clear"></div>
                    <div class="r_text" id="<?php echo "com_".$message['message_id']; ?>" style="display: none">
                                    <div class="f-clear"></div>
                                    <div class="comment_child">
                                        <div class="comment_pointer"></div>
                                        <div class="comment_head"><img src="<?php echo $face;?>"/><div class="comment_head_border"></div></div>
                                        <div class="comment_content emoji-ubb">
                                            <div class="comment_pointer_h"></div>
                                            <div style="float:left;height: 110px;">
                                                <div class="comment_text"><textarea id="<?php echo "com_".$message['message_id']; ?>" style="width:535px;border:none; resize: none;" maxlength="140" placeholder="请输入评论..."></textarea></div>
                                                <div class="comment_emoji_sub">
                                                    <div class="m-sns-u-emoji" toggle="emoji-box"> </div>
                                                    <div class="emoji-box">
                                                        <div class="m-sns-write-mood-pointer emoji-pointer"></div>
                                                        <div class="u-close" hide="emoji-box"></div>
                                                        <div class="emoji-image" id="<?php echo "com_".$message['message_id']; ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="comment_sub"><span class="tot" id="<?php echo "com_".$message['message_id']; ?>">140字</span><span login="<?php if (isset($logged)) echo $logged; ?>" class="sub" id="<?php echo "com_".$message['message_id']; ?>" mid="<?php echo $message['message_id']; ?>">发布</span></div>
                                            </div>
                                        </div>
                                    </div>
                   </div>
                    <?php if(0 == $message['comment_total']) { ?>
                    <div class="comment_list" id="<?php echo "com_".$message['message_id']; ?>" style="line-height:125px;font-size:20px;font-weight:bold;color:#cccccc;text-align:center">
                         暂时没有任何评论，欢迎发表你的观点。
                    </div>
                    <?php } else if($message['comment_total'] > 0 ) {  ?>
                        <div class="comment_list" id="<?php echo "com_".$message['message_id']; ?>">
                        <?php $floor = 0; ?>
                        <?php foreach($message['comment_info'] as $comment_info) { ?>
                        <div class="comment_item_one" id="comment_item_one_<?php echo $comment_info['comment_id']; ?>">
                        <div class="f-clear"></div>
                        <div class="comment_item" style="padding-top:10px"><img src="<?php echo $comment_info['face']?>"/><span style="color:#0c73c2"><?php echo $comment_info['firstname']?></span><span class="floor"><?php echo ++$floor ;?>L</span></div>
                        <div class="comment_content reply_text" >
                        <?php  if($comment_info['type']) { ?>
                        回复<span style="color:#0c73c2"><?php echo $comment_info['reply_name'];?></span>： <?php echo $comment_info['comment_text'];?>
                        <?php  }else{   
                                    echo $comment_info['comment_text'];
                               }
                        ?>
                        </div>
                        <div class="f-clear"></div>
                        <div class="comment_share">
                        <?php if($customer_id == $message['customer_id']) { ?>
                            <span class="del_message_comment" style="cursor:pointer;" id="<?php echo $comment_info['comment_id']; ?>" mid="<?php echo $message['message_id']; ?>"> 删除 </span>
                        <?php } ?>
                        <span class="com reply" id="<?php echo "re_".$comment_info['comment_id']; ?>">回复</span>
                        </div>
                        <div class="f-clear"></div>
                        <div class="comment_dividing" id="<?php echo "re_".$comment_info['comment_id']; ?>" style="border-bottom:1px #d9d9d9 dashed;display:none"></div>
                            <div class="r_text" id="<?php echo "re_".$comment_info['comment_id']; ?>" style="display:none"><div class="f-clear"></div>
                            <div class="comment_replay_box">
                                <div class="comment_replay_pointer"></div>
                                <div class="comment_replay_content" id="<?php echo "re_".$comment_info['comment_id']; ?>"><textarea maxlength="140" id="<?php echo "re_".$comment_info['comment_id']; ?>" placeholder="回复<?php echo $comment_info['firstname']?>"></textarea></div>
                                    <div class="comment_emoji_sub">
                                        <div class="m-sns-u-emoji"> </div>
                                        <div class="emoji-box">
                                            <div class="m-sns-write-mood-pointer emoji-pointer"></div>
                                            <div class="u-close" hide="emoji-box"></div>
                                            <div class="emoji-image" id="<?php echo "re_".$comment_info['comment_id']; ?>"></div>
                                        </div>
                                    </div>
                                <div class="comment_sub"><span class="tot" id="<?php echo "re_".$comment_info['comment_id']; ?>">140字</span><span id="<?php echo "re_".$comment_info['comment_id'];?>" reply_name="<?php echo $comment_info['firstname']?>" message_id="<?php echo $message['message_id']; ?>" reply_id="<?php echo $comment_info['comment_id']?>" class="r_sub">发布</span></div>
                            </div>
                            </div>
                            </div>
                            <?php }  ?>
                            <?php if($message['comment_total'] > 10) {  ?>
                            <div class="f-clear"></div>
                            <div class="comment_dividing" style="border-bottom:1px #d9d9d9 dashed"></div>
                            <div class="f-clear"></div>
                            <div style="margin-top: 20px;"><span>后面还有<?php echo ($message['comment_total'] - 10); ?>条评论，<span><a href="<?php echo '/index.php?route=social/comment&message_id='.$message['message_id']?>" style='color: #0C73C2'>查看更多</a></span></span><span style="float:right;cursor:pointer" class="com_hide" id="<?php echo "com_".$message['message_id']; ?>">收起评论</span></div> 
                            <?php } ?>
                    </div>
                    <?php } ?>
                    </div>
                <?php }  ?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{},"image":{"viewList":["twi","fbook","tsina","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["twi","fbook","tsina","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                <div style="float:right">
                <div class="pages_change">
                        <!--
                        <ul class="comment_page">
                            <li class="page_prev"><span></span></li>
                            <li class="page_first"><a href="#">1</a>
                            <li><a href="#">2</a>
                            <li><a href="#" class="active">3</a>
                            <li><a href="#">4</a>
                            <li class="page_last"><a href="#">5</a>
                            <li class="page_next"><span></span></li>
                        </ul>
                        -->
                 <?php echo $pagination; ?>

                 </div>
                <div class="f-clear"></div>
            </div>
            </div>
            <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
              <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="800px" viewBox="0 0 80 60" preserveAspectRatio="none" >
                <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
              </svg>
            </div>