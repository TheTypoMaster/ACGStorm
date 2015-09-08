<?php echo $header_sns;?>

        <div class="view-div-box">
            <div class="view-div-close"></div>
            <div class="view-div-box-title">查看对话</div>
            <div style="width:551px;height:262px; margin:37px 2px 2px 2px;background:#ffffff;overflow:hidden">
                <div class="bask_rec_box" style="margin-top: 5px;padding: 10px;">
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
<!----查看原图-->
      <div class="view-image-div-box">
            <div class="view-image-div-close"></div>
            <img src=""/>
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
<!--------->
<div class="sns">
<div class="g-sns_main">
        <div class="g-sns">
            <div class="left">             
                <div class="bask_rec_box" id="<?php echo $message['message_id']; ?>" style="margin-top: 0px">
                    <div class="bask_rec_item"><img class="face" src="<?php echo $message['face'];?>"/><span><?php echo $message['firstname'];?></span>
                    <?php if(isset($message['utype'])) { ?>
                    <?php if(0 ==  $message['utype'])  { ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip0.jpg"></span>
                    <?php  }else if(1 == $message['utype']) { ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip1.jpg"></span>
                    <?php  }else if(2 == $message['utype']) { ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip2.jpg"></span>
                    <?php  }else if(3 == $message['utype']) { ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip3.jpg"></span>
                    <?php  }else if(4 == $message['utype']) { ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip4.jpg"></span>
                    <?php  }else if(5 == $message['utype']) { ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip5.jpg"></span>
                    <?php  }else{ ?>
                    <span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip6.jpg"></span>
                    <?php } }?>  
                    <span class="country"><?php echo $message['country'];?>
                    <?php if($customer_id == $message['customer_id']) { ?>
                    <span class="del_comment" id="<?php echo $message['message_id']; ?>"> 删除 </span>
                    <?php } ?>
                    </span></div>
                    <div class="bask_rec_text emoji-ubb"><?php echo $message['message_text'];?></div>
                    
                    
                    <div class="bask_rec_images view-image-list" style="display:none">
                     <?php $imgs = explode("|" , $message['imgurl']);
                          foreach($imgs as $img) {  
                            if($img) {?>
                           <img src="<?php echo $img;?>"/>
                    <?php } }?>
                    </div>
                    
                    <?php if($message['imgurl']) {  ?>
                    <div class="bask_image_box" id="<?php echo "com_".$message['message_id']; ?>" style="display:block">
                        <div class="bask_image_box_op"><span class="up_down"></span><span class="updown">收起</span><span class="res"></span>
                        

                        <?php $imgs = explode("|" , $message['imgurl']);
                              if(count($imgs) > 0 && $imgs[0]) {
$posDot = strrpos ( $imgs[0], '.' );
                                            $strExt = substr ( $imgs[0], $posDot );
                                            $posXie = strrpos ( $imgs[0], '/' );
                                            $strFile = substr ( $imgs[0], $posXie );
                                            $strFile = explode ( '-', $strFile );
                                            $strFile = $strFile[0];
                                            $strFile = "uploads/big" . $strFile . $strExt; 
?>
                        <span class="viewres" img_src="<?php echo $strFile;?>">
                        <?php } ?>查看原图</span></div>
                        <div class="bask_image_big">
                        <?php $imgs = explode("|" , $message['imgurl']);
                              if(count($imgs) > 0 && $imgs[0]) { ?>
                        <img src="<?php echo $strFile;?>"/>
                        <?php } ?>


                        </div>
                        <?php $imgs = explode("|" , $message['imgurl']);
                              $imgs = array_filter($imgs);
                        if(count($imgs)>1) {  ?>     
                        <div class="bask_iamge_sm">
                            <ul class="bask_iamge_sm_ul">
                                <?php $imgs = explode("|" , $message['imgurl']);
                                      foreach($imgs as $img) {  
                                      if($img) {
                                        $posDot = strrpos ( $img, '.' );
                                            $strExt = substr ( $img, $posDot );
                                            $posXie = strrpos ( $img, '/' );
                                            $strFile = substr ( $img, $posXie );
                                            $strFile = explode ( '-', $strFile );
                                            $strFile = $strFile[0];
                                            $strFile = "uploads/big" . $strFile . $strExt; 
                                        ?>
                                       <li><img iname="<?php echo $strFile;?>" src="<?php echo $img;?>"/><span></span></li>
                                <?php } }?>
                            </ul>
                        </div>
                        <?php } ?>
                    </div>
                    <?php }  ?>
                    
                    <div class="f-clear"></div>
                    <div class="bask_rec_like" id="<?php echo $message['message_id']?>" login="<?php echo $logged; ?>"><span class="image"></span><span class="tot"><?php echo $message['points'];?></span></div>
                    <div class="bask_rec_com_share">
                        <span class="com comt" id="<?php echo "com_".$message['message_id'];?>" login="<?php echo $logged; ?>">评论(<?php echo $message['comments'];?>)</span><span class="share" id="<?php echo "com_".$message['message_id']; ?>">分享</span>
                        <div class="comment_share_box" id="<?php echo "com_".$message['message_id']; ?>"></div>
                        <div class="bdsharebuttonbox" style="display:none;position: absolute; z-index: 1000; width: 200px;"><a href="#" class="bds_twi" data-cmd="twi" title="分享到Twitter"></a><a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
                        </div>
                    <div class="f-clear"></div>
                    <div class="r_text" id="<?php echo "com_".$message['message_id']; ?>">
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
                                                <div class="comment_sub"><span class="tot" id="<?php echo "com_".$message['message_id']; ?>">140字</span><span login="<?php echo $logged; ?>" class="sub" id="<?php echo "com_".$message['message_id']; ?>" mid="<?php echo $message['message_id']; ?>">发布</span></div>
                                            </div>

                                        </div>
                                    </div>
                   </div>
              		     <?php if(count($comment_info_all)==0) { ?>              
                    <div class="comment_list" id="<?php echo "com_".$message['message_id']; ?>" style="line-height:125px;font-size:20px;font-weight:bold;color:#cccccc;text-align:center;display:block">
                         暂时没有任何评论，欢迎发表你的观点。
                    </div>
<?php }else{ ?>
                    <div class="comment_list" id="<?php echo "com_".$message['message_id']; ?>" style="display:block">
                        <?php $floor = ($page-1)*$limit; ?>
                        <?php foreach($comment_info_all as $comment_info) { ?>
                        <div class="f-clear"></div>
                        <div class="comment_item"><img src="<?php echo $comment_info['face']?>"/><span style="color:#0c73c2"><?php echo $comment_info['firstname']?></span><span class="floor"><?php echo ++$floor ;?>L</span></div>
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
                            <?php }  ?>
                            
                        <div class="f-clear"></div>
                        <div class="comment_dividing" style="border-bottom:1px #d9d9d9 dashed"></div>
                                       <div style="padding-top:11px;height:40px">
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
                        <div class="pages_change"><?php echo $pagination; ?></div> 
                </div>
                    

                    </div><?php }  ?>
        


                <div class="f-clear"></div>
            </div></div>
<?php echo $social_right?>
        </div>
        <div class="f-clear"></div>
        </div>
       </div>
</div>
        <script>
	var add_file_box='';
	var i=0;
	var iframe = '<div id="add" style="float: left;width: 93px;height:93px;padding:0px;margin:0px;"><iframe id="upfile" name="upfile" src="index.php?route=social/upfile" style="border:none"></iframe></div>';
	function get_file_path(){
	    if(i<6){
	    var filename = upfile.window.document.getElementById("filename").innerHTML;
	    add_file_box += '<div id=image_'+i+' class="add_image image_1">'+
	                                    '<div class="u-image-del"  onclick="del_img('+i+')"></div>'+
	                                    '<div class="up-file"><img src="'+filename+'"/></div>'+
	                                    '<input name="massage_image_'+i+'"  hidden="hidden" type="text" class="male" value="'+filename+'" style="display: none"/>'+
	                                '</div>';
	      
	     i++;
	     document.getElementById('img_length').innerHTML = '还可以上传'+(6-i)+'张';
	     if(i===6){
	         document.getElementById("add_image_file").innerHTML = add_file_box;
	    
	     }else{
	         document.getElementById("add_image_file").innerHTML = add_file_box+iframe;
	     }
	     
	}
	}
	function del_img(a){
	    add_file_box='';
	   var div = document.getElementById('image_'+a);
	   div.parentNode.removeChild(div);
	   i-=1;
	   for(var b=0;b<=6;b++){
	       var div1 = document.getElementById('image_'+b);
	       div2+=div1.parentNode.innerHTML;
	   }
	   document.getElementById('img_length').innerHTML = '还可以上传'+(6-i)+'张';
	   if(i<6){
	       
	       document.getElementById("add_image_file").innerHTML = iframe;
	   }
	}
//get_file_path();
</script>
        
<?php echo $footer ;?>