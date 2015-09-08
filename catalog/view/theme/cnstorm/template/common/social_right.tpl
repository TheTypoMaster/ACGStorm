<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.e-calendar.js"></script>
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/jquery-calendar.css" />
<script  src="catalog/view/javascript/jquery2/sweet-alert.min.js"></script>
<script  src="catalog/view/javascript/jquery2/sweet-alert.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/cnstorm/stylesheet/sweet-alert.css"/>

<div class="sns_right">
    <div class="socail_notice_box"><img src="catalog/view/theme/cnstorm/images/social/socail_notice.jpg" />
        <div class="socail_notice_box_more"><a href="index.php?route=help/announcement&id=2" target="_blank"><?php echo $text_Seemore; ?></a></div>
        <ul class="socail_notice_box_ul">
            <?php if ($bulletins) { ?>
                <?php if (count($bulletins) >= 5) $max = 5; else $max = count($bulletins); for($i = 0; $i < $max; $i++) {?>
                    <li><a <?php if($bulletins[$i]['color']) echo 'style="color:red;"'; ?> href="index.php?route=help/announcement&social=1&id=2&bid=<?php echo($bulletins[$i]['bulletin_id']); ?>" target="_blank"><?php $str=$bulletins[$i]['name']; $str=mb_strlen($str)>18 ? mb_substr($str,0,18,'utf-8').'...' : $str; echo($str); ?></a></li>
                <?php } ?>
                <!-- <li>晒尔社区上线了！！</li>
                <li class="notice_rec">社区高达100积分等你拿！</li>
                <li>晒尔社区发布内容使用指南</li>
                <li>社区总版规（试行）</li> -->
            <?php } else { ?>
                <li><?php echo $text_Bulletin ; ?></li>
            <?php } ?>
        </ul>
    </div>
                <div class="m-sns-dynamic">
                    
                    
                    <?php if (!empty($customer_name)){ if($signFlag != 1){ ?>
                    <a class="qiandao" href="javascript:void(0);" onclick="calendarclick(<?php if (isset($customer_id)) echo $customer_id?>,'<?php if (isset($customer_name)) echo $customer_name;?>')">
                    <div class="m-sns-sign-in">
                        <div style="position:absolute;top:28px;left:35px;font-size:16px;color:#3cbc90"><?php echo date('d',time()); ?></div>
                        <div style="position:absolute;top:8px;left:180px;font-size:22px;color:#3cbc90"><?php echo $count; ?></div>
                    </div>
                    </a>
                    <?php }else{ ?>
                    <a class="qiandao" href="javascript:void(0);" onmouseover="calendarclick(<?php if (isset($customer_id)) echo $customer_id?>,'<?php if (isset($customer_name)) echo $customer_name;?>')">
                    <div class="m-sns-sign-in">
                        <div style="position:absolute;top:28px;left:35px;font-size:16px;color:#3cbc90"><?php echo date('d',time()); ?></div>
                        <div style="position:absolute;top:8px;left:180px;font-size:22px;color:#3cbc90"><?php echo $count; ?></div>
                    </div>
                    </a>
                    <?php } ?>
                    <div id="calendar"></div>
                    <a class="dati" href="javascript:void(0);" onclick="question(<?php echo $customer_id?>,'<?php echo $customer_name;?>')"><div class="m-sns-answer"></div></a>
                    <div class="f-clear"></div>
                    <div class="m-sns-sa-tip"><?php echo $text_Suggestedanswer ; ?></div>
                    <?php }else{ ?>
                    <a class="qiandao" href="account-login.html">
                    <div class="m-sns-sign-in">
                        <div style="position:absolute;top:28px;left:35px;font-size:16px;color:#3cbc90"><?php echo date('d',time()); ?></div>
                        <div style="position:absolute;top:8px;left:180px;font-size:22px;color:#3cbc90">0</div>
                    </div>
                    </a>
                    <a class="dati" href="account-login.html"><div class="m-sns-answer"></div></a>
                    <div class="f-clear"></div>
                    <div class="m-sns-sa-tip"><?php echo $text_Suggestedanswer ; ?></div>
                    <?php } ?>     

                    
                    <div class="m-sns-write-mood">
                        <div class="m-sns-write-mood-tab-top">
                            <div class="bask active tab-top" toggle="bask"><?php echo $text_showOrder ; ?>
                                <div class="m-sns-write-mood-pointer-box"><div class="m-sns-baskmood-pointer"></div></div></div>
                            <div class="mood tab-top" toggle="mood"><?php echo $text_Writemood ; ?>
                            <div class="m-sns-write-mood-pointer-box"><div class="m-sns-baskmood-pointer"></div></div></div>
                            <div class="sync-sns"><input id="sync_sina" type="checkbox" checked="checked" value="1"/> <?php echo $text_SynchronizationSina ; ?></div>
                        </div>
                        <!--切换textarea-->
                        <div class="m-sns-write-mood-tab-panel">
                            <div id="bask">
                                <textarea id="bask-textarea"  name="bask-textarea" style="" maxlength="140" placeholder="<?php echo $text_opportunity ; ?>"></textarea>
                            </div>
                            <div id="mood" style="display:none">

                                <textarea id="mood-textarea"  name="mood-textarea" style="" maxlength="140" placeholder="<?php echo $text_curious ; ?>"></textarea>

                            </div>
                            <div class="text-length"><span class="tot"><?php echo $text_word ; ?></span></div>
                            <div class="sub_success"><?php echo $text_successful ; ?></div>
                        </div>
                        <!--end-->
                    </div>
                    <div class="m-sns-write-mood-u">
                        <div class="m-sns-write-mood-u-emoji m-sns-write-mood-show-panel" toggle="silder_emoji-box" login="<?php echo $logged; ?>">
                        </div>
                        <div class="silder_emoji-box">
                            <div class="m-sns-write-mood-pointer emoji-pointer"></div>
                            <div class="u-close" hide="silder_emoji-box"></div>
                            <div class="emoji-image"></div>
                        </div>
                        <div class="m-sns-write-mood-u-image m-sns-write-mood-show-panel"  toggle="image-box" login="<?php echo $logged; ?>"></div>
                        <div class="image-box">
                            <div class="m-sns-write-mood-pointer image-pointer"></div>
                            <div class="u-close" hide='image-box'></div>
			    <div class="image-option">
                                <div class='image-title'><span><?php echo $text_Localupload ; ?> </span><span id="img_length" style="color:#8c8c8c"><?php echo $text_photos ; ?></span></div>
                                <div id="add_image_file">
                                    <iframe id="upfile" name="upfile" src="<?php echo $filesrc; ?>" style="border:none;padding:0px;margin-bottom:-53px;"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="m-sns-write-mood-u-video m-sns-write-mood-show-panel" toggle="video-box" login="<?php echo $logged; ?>"></div>
                            <div class="video-box">
                                <div class="m-sns-write-mood-pointer video-pointer"></div>
                                <div class="u-close" hide="video-box"></div>
                                <div class="vidoe-option">
                                    <div class='video-title'><?php echo $text_videoaddress ; ?></div>

                                    <input onblur="checkVideoUrl()" class="video_url" placeholder="<?php echo $text_videowebsite ; ?>" style="float:left"><div class="v_url_error"><?php echo $text_notvalid ; ?></div>

                                    <!-- <div class="video_submit">确定</div> -->
                                    <div class='f-clear'></div>
                                    <div class="sps_url" style="margin-top:12px;color:#A3A3A3"><?php echo $text_playback ; ?></div>
                                </div>
                            </div>
                        <div class="theme_option" style="float:left;left:77px;position:relative">
                            <span class='theme_choose' toggle="theme_box"  login="<?php echo $logged; ?>"><?php echo $text_Choosetheme ; ?></span>
                            <span class="theme_down_up"></span>
                            <div class="theme_box">
                                <div class="u-close" hide="theme_box"></div>
                                <div class="theme_pointer"></div>
                                <div class="theme_title"><?php echo $text_powered ; ?></div>
                                <div class="theme_item"></div>
                            </div>
                        </div>
			<input type="hidden" class="customer_id" value="<?php if (isset($customer_id)) echo $customer_id; ?>" />
			<input type="hidden" class="customer_name" value="<?php echo $customer_name; ?>" />
                        <div class="m-sns-write-mood-u-submit" login="<?php echo $logged; ?>"><?php echo $text_Release ; ?></div>
                        </form>
                        <div class="f-clear"></div>
                    </div>
                    <!--晒尔推荐-->
                    <div class="bask_rec"><?php echo $text_rec ; ?></div>

<?php if ($saiercomment){ ?>
                    <div class="bask_rec_box" style="border:none">
<?php foreach ($saiercomment as $saier){ ?>
                        <div class="bask_rec_item"><img width="30" height="30" src="<?php echo $saier['face']; ?>"/><span><?php echo $saier['firstname']; ?></span><span class="vip"><img src="catalog/view/theme/cnstorm/images/social/vip<?php echo $saier['utype']; ?>.jpg"/></span><span class="country"><?php echo $saier['country']; ?></span></div>
                        <div class="bask_rec_text emoji-ubb"><?php echo $saier['message_text']; ?></div>


<?php if (!empty($saier['videourl']['img'])){ ?>
<div class="video_play_right" img_src="<?php echo $saier['videourl']['swf'];?>" style="padding-top:3px; float:left;position:relative">
            <img src="<?php echo $saier['videourl']['img'];?>" height="95" width="200">
            <div style="position:absolute;width: 200px;height:95px;top:0px;left:0px;cursor:pointer;border-radius:4px;">
                <img src="catalog/view/theme/cnstorm/images/video_hover.png"/>
            </div>
</div>
<?php } ?>


                        <?php if (empty($saier['videourl']) && !empty($saier['imgurl'])){ ?>          
                            <div class="bask_rec_images_new" img_src="<?php echo $saier['strFile']; ?>">
                                <img src="<?php echo $saier['imgurl']; ?>">
                            </div>
                        <?php } ?>


                        <div class="f-clear"></div>
                        <div id="<?php echo $saier['message_id']?>" class="bask_rec_like" login="<?php echo $logged; ?>"><span class="image"></span><span class="tot"><?php echo $saier['points']; ?></span></div>
                        <div class="bask_rec_com_share">
                            <span id="<?php echo "com_r_".$saier['message_id']; ?>" login="<?php echo $logged; ?>"><a href="index.php?route=social/comment&message_id=<?php echo $saier['message_id'];?>"><?php echo $text_Comment ; ?>(<?php echo $saier['comments']; ?>)</a></span>
     
                            <div class="comment_share_box" id="slider_share_1"></div>
                        </div>
                        <div class="f-clear"></div>
                        <div class="bask_rec_dividing"></div>
<?php }?>
                    </div>
<?php } ?>
                    <div class="tarento"><?php echo $text_Master ; ?></div>
                    <?php foreach($daren_info as $info ) {   ?>
                    <div class="tarento_item"><span class="tarento_top"></span><img src="<?php echo $info['face'];?>" width="30px"/><span><?php echo $info['firstname']; ?></span><span class="vip"><img src="<?php echo 'catalog/view/theme/cnstorm/images/social/vip'.$info['utype'].'.jpg'?>" /></span><span class="country"><?php echo $info['sns_daren'];?></span></div>
                    <?php }  ?>
                </div>
    <div class="sina_iframe" style="width:330px;padding-top:12px">
                    </div>
            </div>


            
<div class="dlg_box" id="dlg_box" >
  <div class="ui-dialog-titlebar" id="dlg_box_title"><span id="ui-dialog-title-tasks" class="ui-dialog-title"><?php echo $text_answer ; ?></span><a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="#"><span class="ui-icon ui-icon-closethick">X</span></a></div>
  <div id="dlg_box_contents"></div>
</div>
<div class="dlg_bg" id="dlg_bg" > </div>
<script src="catalog/view/javascript/jquery2/orderlist.js"></script> 
<script src="catalog/view/javascript/jquery2/jquery-lunbo.js"></script> 
<script>
var isHover = false;
function calendarclick(uname_id,uname){
	$('#calendar').eCalendar({uname_id:uname_id,uname:uname});
	$('.calendar').fadeIn(300);
	$(".qiandao").hover(function() {
		isHover = true;
		$(".calendar").show();
	}, function() {
		isHover = false;
		setTimeout(function() {
			if (!isHover) {
				$(".calendar").fadeOut();
			}
		}, 100);
	});
	$(".calendar").hover(function() {
		isHover = true;
	}, function() {
		isHover = false;
		$(".calendar").fadeOut();
	});
}
</script>
