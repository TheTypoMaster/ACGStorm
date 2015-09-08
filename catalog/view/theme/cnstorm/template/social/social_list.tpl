<?php echo $header_sns;?>
<title>CNstorm代购社区 - 海外华人、留学生代购中国商品乐园</title>
<meta name="keywords" content="CNstorm,代购社区,华人社区,留学生社区,代购中国,代购分享,留学生代购,华人代购,海外生活,留学生活,海外同城" />  
<meta name="description" content="CNstorm代购社区是服务于全球华人、留学生的代购中国商品服务社区，在此分享心情,分享代购的心得,购物的体验，记录海外生活的点滴,并能帮助你结识志同道合的人" />
<!--查看对话
        <div class="view-div-box">
            <div class="view-div-close"></div>
            <div class="view-div-box-title">查看对话</div>
            <div style="width:551px;height:262px; margin:37px 2px 2px 2px;background:#ffffff;overflow:hidden">
                <div class="bask_rec_box" style="margin-top: 5px;padding: 10px;border:none;overflow-y:auto;height:236px">
                    <div class="bask_rec_item"><img src="catalog/view/theme/cnstorm/images/social/bask_head.jpg"/><span style="color:#0c73c2">布鲁先生</span><span class="country">2014-09-02 11:19:47</span></div>
                    <div style="padding-left:40px">非常感谢，东西都很满意，客服态度也很专业， 以后还会用的。</div>
                    <div class="bask_rec_dividing" style="border-bottom:1px #d9d9d9 dashed"></div>
                    <div class="f-clear"></div>
                    <div class="bask_rec_item" style="padding-top:12px;"><img src="catalog/view/theme/cnstorm/images/social/bask_head.jpg"/><span style="color:#0c73c2">布鲁先生</span><span class="country">2014-09-02 11:19:47</span></div>
                    <div style="padding-left:40px">非常感谢，东西都很满意，客服态度也很专业， 以后还会用的。</div>
                    <div class="bask_rec_dividing" style="border-bottom:1px #d9d9d9 dashed"></div>
                    <div class="f-clear"></div>
                    <div class="bask_rec_item"><img src="catalog/view/theme/cnstorm/images/social/bask_head.jpg"/><span style="color:#0c73c2">布鲁先生</span><span class="country">2014-09-02 11:19:47</span></div>
                    <div style="padding-left:40px">非常感谢，东西都很满意，客服态度也很专业， 以后还会用的。</div>
                    <div class="bask_rec_dividing" style="border-bottom:1px #d9d9d9 dashed"></div>
                    <div class="f-clear"></div>
                    <div class="bask_rec_item" style="padding-top:12px;"><img src="catalog/view/theme/cnstorm/images/social/bask_head.jpg"/><span style="color:#0c73c2">布鲁先生</span><span class="country">2014-09-02 11:19:47</span></div>
                    <div style="padding-left:40px">非常感谢，东西都很满意，客服态度也很专业， 以后还会用的。</div>
                    <div class="bask_rec_dividing" style="border-bottom:1px #d9d9d9 dashed"></div>
                    <div class="f-clear"></div>
                </div>
            </div>
        </div>
<!--------->

<!----查看原图-->
      <div class="view-image-div-box-bg">
          <div class="view-image-div-box">
            <a class="left"></a>
            <div class="view-image-div-close">X</div><img src=""/>
            <a class="right"></a>
          </div>
        </div>

        <div class="view-oneImage-div-box-bg">
            <div class="view-oneImage-div-box">
              <a class="left"></a>
              <div class="view-div-close">X</div><img src=""/>
              <a class="right"></a>
            </div>
        </div>

        <div class="view-video-div-box">
            <div class="view-video-div-close">X</div>
            <embed src="" quality="high" width="480" height="400" align="middle" allowNetworking="all" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
        </div>
<!---查看原图结束---->

<!--登陆窗口----->
<div class="login_box" style=";">
    <div class="login_panel">
        <div class="close_login">X</div>
       <div class="login_left" style="float:left;width:300px;padding:10px;line-height:300px;">
          <img src="catalog/view/theme/cnstorm/images/login_bg.jpg" alt="登陆背景图片" height="280px">
       </div>
       <div class="login_right" style="float:right;width:360px;">
          <div class="login_top">
              <h3>立即登录CNstorm网站</h3>
              <form id="login" action="<?php if (isset($action)) echo $action; ?>" method="post">
                 <div class="login_input">
                    <span class="login_txt">登录</span>
                    <input class="input" type="text" name="email" value="<?php if (isset($email)) echo $email;?>" placeholder="邮箱地址/用户名" AUTOCOMPLETE="OFF"/>
                 </div>
                 <div class="login_input">
                    <span class="login_txt">密码</span>
                    <input class="input" type="password" name="password" value="<?php if (isset($password)) echo $password;?>" placeholder="密码" AUTOCOMPLETE="OFF"/>
                    <a class="forgot_psw" href="<?php if (isset($forgotten)) echo $forgotten;?>">忘记密码？</a>
                 </div>
                  <input name="login_social" value="social" hidden="hidden"/>
                 <!--
                 <div class="login_input">
                    <span class="login_txt">验证码</span>
                    <input class="code_letter" type="text" value="" />
                    <img class="code_pic" src="catalog/view/themet/cnstorm/images/letter.jpg" alt="验证码" >
                    <span class="change_code">看不清？<a href="javascript:void(0);">换一张</a></span>
                 </div>
                 -->
          <div class="login_btn">
            <input type="submit"  value="登录" />
          </div>
        </form>
        <dl class="coperation">
          <dt>使用合作网站账号登录:</dt>
          <dd><a class="xinlang" href="<?php if (isset($code_url)) echo $code_url ?>"></a></dd>
          <dd><a class="qq" href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=100360874&state=9175e816623b111ddb36e19d2b07783d&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_qq"></a></dd>
        </dl>
        <?php if (isset($error_login)) { ?>
        <span style="float:left;color:red"><?php echo $error_login; ?></span>
        <?php } ?>
      </div>
           <div class="f-clear"></div>
      <span class="login_bott">没有CNstorm账号?<a href="<?php if (isset($register)) echo $register;?>">立即注册</a></span> </div>
    </div>
</div>


<!---->
<div class="sns">
<div class="g-sns_main">
  <div class="g-sns">
     <div class="left" <?php if(isset($face)) { ?>id="face" face="<?php echo $face;?>" cnstormer_name="<?php echo $firstname; } ?>">
         <div style="width:638px;height:336px;">                
             <div class="flicker-example" data-block-text="false" style="width:638px;height:336px;">
             <ul>
              <?php if ($lunbopics) { ?>
                <?php foreach($lunbopics as $lunbopic) {?>
                  <li data-background="<?php echo 'image/' . $lunbopic['image']; ?>">
                    <a  href="<?php echo $lunbopic['url']; ?>" target="_blank" style="display:block;height:316px;width:618px"></a>
                  </li>
                <?php } ?>
              <?php } else { ?>
                <li data-background="catalog/view/theme/cnstorm/images/social/sns_banner1.jpg">
                    <a href="index.php?route=help/help&qid=8" target="_blank" style="display:block;height:316px;width:618px"></a>
                </li>
                <li data-background="catalog/view/theme/cnstorm/images/social/sns_banner2.jpg">
                    <a href="/product-favorite.html" target="_blank" style="display:block;height:316px;width:618px"></a>
                </li>
            	<li data-background="catalog/view/theme/cnstorm/images/social/sns_banner3.jpg">
            	    <a href="index.php?route=help/announcement&id=2&bid=32" target="_blank" style="display:block;height:316px;width:618px"></a>
                </li>
            	<li data-background="catalog/view/theme/cnstorm/images/social/sns_banner5.jpg">
            	    
                </li>
                <li data-background="catalog/view/theme/cnstorm/images/social/sns_banner4.jpg">
            	    <a href="index.php?route=help/announcement&id=2&bid=27" target="_blank" style="display:block;height:316px;width:618px"></a>
                </li>
              <?php } ?>
            </ul>
            </div>
        </div> 
                <div id="dvContent" style="position:relative;">



<!-- dvMenu start -->
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
              <div style="position:absolute;top:0px;left:0px;" id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="800px" viewBox="0 0 80 60" preserveAspectRatio="none" >
                  <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
                </svg>
              </div>
            </div><!-- /dvContent -->
<!-- dvMenu end -->



</div>
<?php echo $social_right;?>
        </div>
        <div class="f-clear"></div>
        </div>
       </div>
</div>
<script src="catalog/view/javascript/pl/js/classie.js"></script>
<script src="catalog/view/javascript/pl/js/svgLoader.js"></script>

</script> 
<script>
var add_file_box='';
var im=0;
var iframe = '<div id="add" style="float: left;width: 93px;height:102px;"><iframe id="upfile" name="upfile" src="index.php?route=social/upfile" style="border:none;padding:0px;margin-bottom:-53px;"></iframe></div>';
function get_file_path(){
	if(im<6){
		var filename = upfile.window.document.getElementById("filename").innerHTML;
		if(im===2 || im===5){
			add_file_box += '<div class="add_image" style="margin-right:0px">'+'<div class="u-image-del"></div>'+'<div class="up-file"><img src="'+filename+'"/></div>'+
			                '<input name="massage_image_'+im+'"  hidden="hidden" type="text" class="male" value="'+filename+'" style="display: none"/>'+'</div>';   
		}else{
		       add_file_box += '<div class="add_image">'+'<div class="u-image-del"></div>'+'<div class="up-file"><img src="'+filename+'"/></div>'+
		                '<input name="massage_image_'+im+'"  hidden="hidden" type="text" class="male" value="'+filename+'" style="display: none"/>'+'</div>';   
		}     
		im++;
		document.getElementById('img_length').innerHTML = '还可以上传'+(6-im)+'张';
		if(im===6){
			document.getElementById("add_image_file").innerHTML = add_file_box;
		}else{
			document.getElementById("add_image_file").innerHTML = add_file_box+iframe;
		}
	}
}
$(function(){
$(document).on('click','#dvMenu li a',function(){
        var loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 250, easingIn : mina.easeinout } );
        var url = $(this).attr('href');
        loader.show();
        window.scrollTo(0,475);
        $.ajax({
		type: 'GET',
		url: url,
		success: function(data) {
			setTimeout(function(){loader.hide(); $('#dvContent').html(data);}, 500);
		}
        });
        return false; 
});
$(document).on('click','.list_num li a',function(){
	var loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 250, easingIn : mina.easeinout } );
	var url = $(this).attr('href');
	loader.show();
	window.scrollTo(0,475);
	$.ajax({
		type: 'GET',
		url: url,
		success: function(data) {
			setTimeout(function(){loader.hide(); $('#dvContent').html(data);}, 500);
		}
	});
	return false;
});
$(document).on('click','.u-image-del',function(){
	add_file_box='';
	$(this).parent().remove();
	im = $('#add_image_file').find('.add_image').length;
	for(var i = 0;i<im;i++ ){
		if(i===2 || i===5){
			add_file_box+='<div class="add_image" style="margin-right:0px">'+ $('#add_image_file').find('.add_image').eq(i).html()+'</div>';
		}else{
			add_file_box+='<div class="add_image">'+ $('#add_image_file').find('.add_image').eq(i).html()+'</div>';
		}
	}
	$('#add_image_file').html(add_file_box+iframe);
	$("#img_length").html('还可以上传'+(6-im)+'张');
});
});
$(document).on('click',".open_vedio", function(){
	$(".open_vedio[id='"+$(this).attr('id')+"']").fadeOut();
	$(this).prev('img').fadeOut();
	$(this).next('.vedio').slideDown();
});
$(document).on('click','.close_vedio', function(){
	$(".vedio[id='"+$(this).attr('id')+"']").hide();
	$(".open_vedio[id='"+$(this).attr('id')+"']").fadeIn();
});
$('.flicker-example').flicker();
</script>        
<span id="x" style="display:none"></span>
<?php echo $footer ;?>