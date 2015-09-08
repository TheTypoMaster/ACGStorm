<title>用户中心-欢迎您来到CNstorm代购用户中心，查看代购订单情况</title>
<meta name="keywords" content="用户中心，代购订单，自助购订单，转运订单，订单管理，仓储管理，运输管理，代购充值，优惠券，代寄订单" />
<meta name="description" content="cnstorm代购用户中心为你提供查看或管理代购订单，自助购订单，转运订单，及时尊享CNstorm专业客服团队及完善的售后保障体系"  />
<meta name="robots" content="nofollow" />
<?php echo $header_snsmanager;?>
<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left_snsmng ;?>
<div class='' >
            <div class="dl_head">
            <h3 class="bg1">社区消息</h3>
            </div>
        </div>
        <div class="all_dingdan">
          <ul class="dingdan_list">
            <li><a href="<?php echo $message_url; ?>" class="on" >给我评论
              </a></li>
            <li><a href="<?php echo $reply_url; ?>">给我回复       
       </a></li>
            <li><a href="<?php echo $comment_url; ?>" >我发表的评论
                   </a></li>
          </ul>


            
            
          <div class="dg_dingdan">
            <div style="padding:10px 20px;font-size:14px;border-bottom:1px #e5e5e5 solid">Hi，<?php echo $firstname; ?>，您已经收到 <span style="color:#ed5564;font-weight:bold"><?php echo $commented_total; ?></span> 条评论了，要记得及时回复他们哦！</div>
              
              <?php foreach($commented_info as $commented) {  ?>
              <div class="comment-list">
                  <div class="com_box">
                  <div class="com_img">
                  <?php if($commented['face']) {  ?>
                  <img src="<?php echo $commented['face']; ?>"/></div>
                  <?php }else{  ?>
                  <img src="uploads/big/0b4a96400b2372d25da769647bfe4059.jpg"/></div>
                  <?php } ?>
                  <div class="com_out_line" ></div>
                  <div class="com_text">
                      <div class="rp_title"><span class="re_user_name" style="color:#0c73c2;font-size: 14px;"><?php echo $commented['firstname'];  ?></span><span> 对我的<?php if(1 == $commented['message_flag']) { ?>晒单<?php }else if(2 == $commented['message_flag']){ ?>心情<?php } ?> </span><span class="comment_content" style="color:#0c73c2;font-size: 14px;">“<?php if(strlen($commented['message_text']>108)) {echo substr_replace($commented['message_text'],"..." ,108); }else{  echo $commented['message_text']; }?>”</span><span> 进行了评论。 </span>
                          <p class="comment_content"><?php echo $commented['comment_text']; ?></p>
                      </div>
                          <div style="margin-top:14px;color:#a0a0a0"><span><?php echo date("Y-m-d H:i:s",$commented['addtime']);?></span><span style="float:right"><!--<a href="#" style="color:#0c73c2">查看对话</a>  <i style="color:#d8d8d8">|</i>-->  <a href="/index.php?route=social/comment&message_id=<?php echo $commented['message_id'];?>" class="com reply" id="<?php echo "re_".$commented['comment_id']; ?>"  style="color:#0c73c2">回复</a></span></div>
                    <div class="f-clear"></div>
                  </div>
                  <div class="com_box_list_pointer"></div>
                  </div>
              </div>
              <?php }  ?>
              
          </div>
                      <div style="padding-top:11px;height:40px">

                        
                        <div style="padding-top:11px;height:40px">
                         <div class="pages_change"><?php echo $pagination; ?></div>
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
                      </div>
                     
                     
                </div>
        </div>
    
    
    
    
    
      </div>
    </div>
  </div>
  </div>
</div>
<script>
$(function(){
var emoji = {1:{i:"catalog/view/theme/cnstorm/images/social/emoji/01.jpg",a:'哈哈'},2:{i:"catalog/view/theme/cnstorm/images/social/emoji/02.jpg",a:'高兴'},3:{i:"catalog/view/theme/cnstorm/images/social/emoji/03.jpg",a:'微笑'},4:{i:"catalog/view/theme/cnstorm/images/social/emoji/04.jpg",a:'窃喜'},5:{i:"catalog/view/theme/cnstorm/images/social/emoji/05.jpg",a:'眨眼'},6:{i:"catalog/view/theme/cnstorm/images/social/emoji/06.jpg",a:'爱你'},7:{i:"catalog/view/theme/cnstorm/images/social/emoji/07.jpg",a:'飞吻'},
    8:{i:"catalog/view/theme/cnstorm/images/social/emoji/08.jpg",a:'亲一口'},9:{i:"catalog/view/theme/cnstorm/images/social/emoji/09.jpg",a:'脸红'},10:{i:"catalog/view/theme/cnstorm/images/social/emoji/10.jpg",a:'冥想'},11:{i:"catalog/view/theme/cnstorm/images/social/emoji/11.jpg",a:'微笑'},12:{i:"catalog/view/theme/cnstorm/images/social/emoji/12.jpg",a:'鬼脸'},13:{i:"catalog/view/theme/cnstorm/images/social/emoji/13.jpg",a:'闭眼'},14:{i:"catalog/view/theme/cnstorm/images/social/emoji/14.jpg",a:'不高兴'},
    15:{i:"catalog/view/theme/cnstorm/images/social/emoji/15.jpg",a:'假笑'},16:{i:"catalog/view/theme/cnstorm/images/social/emoji/16.jpg",a:'冷汗'},17:{i:"catalog/view/theme/cnstorm/images/social/emoji/17.jpg",a:'深思'},18:{i:"catalog/view/theme/cnstorm/images/social/emoji/18.jpg",a:'失望'},19:{i:"catalog/view/theme/cnstorm/images/social/emoji/19.jpg",a:'困惑'},20:{i:"catalog/view/theme/cnstorm/images/social/emoji/20.jpg",a:'失望'},
    21:{i:"catalog/view/theme/cnstorm/images/social/emoji/21.jpg",a:'糟糕'},22:{i:"catalog/view/theme/cnstorm/images/social/emoji/22.jpg",a:'害怕'},23:{i:"catalog/view/theme/cnstorm/images/social/emoji/23.jpg",a:'紧张'},24:{i:"catalog/view/theme/cnstorm/images/social/emoji/24.jpg",a:'哭泣'},25:{i:"catalog/view/theme/cnstorm/images/social/emoji/25.jpg",a:'大哭'},26:{i:"catalog/view/theme/cnstorm/images/social/emoji/26.jpg",a:'大笑'},
    27:{i:"catalog/view/theme/cnstorm/images/social/emoji/27.jpg",a:'吃惊'},28:{i:"catalog/view/theme/cnstorm/images/social/emoji/28.jpg",a:'恐怖'},29:{i:"catalog/view/theme/cnstorm/images/social/emoji/29.jpg",a:'闭嘴'},30:{i:"catalog/view/theme/cnstorm/images/social/emoji/30.jpg",a:'撅嘴'},31:{i:"catalog/view/theme/cnstorm/images/social/emoji/31.jpg",a:'困倦'},32:{i:"catalog/view/theme/cnstorm/images/social/emoji/32.jpg",a:'生病'},
    33:{i:"catalog/view/theme/cnstorm/images/social/emoji/33.jpg",a:'恶魔'},34:{i:"catalog/view/theme/cnstorm/images/social/emoji/34.jpg",a:'外星人'},35:{i:"catalog/view/theme/cnstorm/images/social/emoji/35.jpg",a:'黄心'},36:{i:"catalog/view/theme/cnstorm/images/social/emoji/36.jpg",a:'蓝心'},37:{i:"catalog/view/theme/cnstorm/images/social/emoji/37.jpg",a:'紫心'},38:{i:"catalog/view/theme/cnstorm/images/social/emoji/38.jpg",a:'粉心'},
    39:{i:"catalog/view/theme/cnstorm/images/social/emoji/39.jpg",a:'绿心'},40:{i:"catalog/view/theme/cnstorm/images/social/emoji/40.jpg",a:'红心'},41:{i:"catalog/view/theme/cnstorm/images/social/emoji/41.jpg",a:'心碎'},42:{i:"catalog/view/theme/cnstorm/images/social/emoji/42.jpg",a:'喜欢'},43:{i:"catalog/view/theme/cnstorm/images/social/emoji/43.jpg",a:'一见钟情'},44:{i:"catalog/view/theme/cnstorm/images/social/emoji/44.jpg",a:'小星星'},
    45:{i:"catalog/view/theme/cnstorm/images/social/emoji/45.jpg",a:'星星'},46:{i:"catalog/view/theme/cnstorm/images/social/emoji/46.jpg",a:'心情'},47:{i:"catalog/view/theme/cnstorm/images/social/emoji/47.jpg",a:'感叹号'},48:{i:"catalog/view/theme/cnstorm/images/social/emoji/48.jpg",a:'问号'},49:{i:"catalog/view/theme/cnstorm/images/social/emoji/49.jpg",a:'睡觉'},50:{i:"catalog/view/theme/cnstorm/images/social/emoji/50.jpg",a:'快跑'},
    51:{i:"catalog/view/theme/cnstorm/images/social/emoji/51.jpg",a:'汗水'},52:{i:"catalog/view/theme/cnstorm/images/social/emoji/52.jpg",a:'音符'},53:{i:"catalog/view/theme/cnstorm/images/social/emoji/53.jpg",a:'音乐'},54:{i:"catalog/view/theme/cnstorm/images/social/emoji/54.jpg",a:'火焰'},55:{i:"catalog/view/theme/cnstorm/images/social/emoji/55.jpg",a:'大便'},56:{i:"catalog/view/theme/cnstorm/images/social/emoji/56.jpg",a:'手势'},
    57:{i:"catalog/view/theme/cnstorm/images/social/emoji/57.jpg",a:'鄙视'},58:{i:"catalog/view/theme/cnstorm/images/social/emoji/58.jpg",a:'好'},59:{i:"catalog/view/theme/cnstorm/images/social/emoji/59.jpg",a:'拳头'},60:{i:"catalog/view/theme/cnstorm/images/social/emoji/60.jpg",a:'加油'},61:{i:"catalog/view/theme/cnstorm/images/social/emoji/61.jpg",a:'剪刀手'},62:{i:"catalog/view/theme/cnstorm/images/social/emoji/62.jpg",a:'挥手'},
    63:{i:"catalog/view/theme/cnstorm/images/social/emoji/63.jpg",a:'暂停'},64:{i:"catalog/view/theme/cnstorm/images/social/emoji/64.jpg",a:'手影'},65:{i:"catalog/view/theme/cnstorm/images/social/emoji/65.jpg",a:'上面'},66:{i:"catalog/view/theme/cnstorm/images/social/emoji/66.jpg",a:'下面'},67:{i:"catalog/view/theme/cnstorm/images/social/emoji/67.jpg",a:'右边'},68:{i:"catalog/view/theme/cnstorm/images/social/emoji/68.jpg",a:'左边'},
    69:{i:"catalog/view/theme/cnstorm/images/social/emoji/69.jpg",a:'手掌'},70:{i:"catalog/view/theme/cnstorm/images/social/emoji/70.jpg",a:'祈祷'},71:{i:"catalog/view/theme/cnstorm/images/social/emoji/71.jpg",a:'食指'},72:{i:"catalog/view/theme/cnstorm/images/social/emoji/72.jpg",a:'鼓掌'},73:{i:"catalog/view/theme/cnstorm/images/social/emoji/73.jpg",a:'强壮'},74:{i:"catalog/view/theme/cnstorm/images/social/emoji/74.jpg",a:'行人'},
75:{i:"catalog/view/theme/cnstorm/images/social/emoji/75.jpg",a:'散步'},76:{i:"catalog/view/theme/cnstorm/images/social/emoji/76.jpg",a:'跑步'},77:{i:"catalog/view/theme/cnstorm/images/social/emoji/77.jpg",a:'情侣'},78:{i:"catalog/view/theme/cnstorm/images/social/emoji/78.jpg",a:'跳舞'},79:{i:"catalog/view/theme/cnstorm/images/social/emoji/79.jpg",a:'兔女郎'},80:{i:"catalog/view/theme/cnstorm/images/social/emoji/80.jpg",a:'饶命'},
81:{i:"catalog/view/theme/cnstorm/images/social/emoji/81.jpg",a:'防御'},82:{i:"catalog/view/theme/cnstorm/images/social/emoji/82.jpg",a:'服务员'},83:{i:"catalog/view/theme/cnstorm/images/social/emoji/83.jpg",a:'鞠躬'},84:{i:"catalog/view/theme/cnstorm/images/social/emoji/84.jpg",a:'亲密'},85:{i:"catalog/view/theme/cnstorm/images/social/emoji/85.jpg",a:'夫妻'},86:{i:"catalog/view/theme/cnstorm/images/social/emoji/86.jpg",a:'按摩'},
87:{i:"catalog/view/theme/cnstorm/images/social/emoji/87.jpg",a:'理发'},88:{i:"catalog/view/theme/cnstorm/images/social/emoji/88.jpg",a:'指夹油'},89:{i:"catalog/view/theme/cnstorm/images/social/emoji/89.jpg",a:'男孩'},90:{i:"catalog/view/theme/cnstorm/images/social/emoji/90.jpg",a:'女孩'},91:{i:"catalog/view/theme/cnstorm/images/social/emoji/91.jpg",a:'女人'},92:{i:"catalog/view/theme/cnstorm/images/social/emoji/92.jpg",a:'男人'},
93:{i:"catalog/view/theme/cnstorm/images/social/emoji/93.jpg",a:'婴儿'},94:{i:"catalog/view/theme/cnstorm/images/social/emoji/94.jpg",a:'老奶奶'},95:{i:"catalog/view/theme/cnstorm/images/social/emoji/95.jpg",a:'老爷爷'},96:{i:"catalog/view/theme/cnstorm/images/social/emoji/96.jpg",a:'金发碧眼'},97:{i:"catalog/view/theme/cnstorm/images/social/emoji/97.jpg",a:'瓜皮帽'},98:{i:"catalog/view/theme/cnstorm/images/social/emoji/98.jpg",a:'包头巾'},
99:{i:"catalog/view/theme/cnstorm/images/social/emoji/99.jpg",a:'建筑工人'},100:{i:"catalog/view/theme/cnstorm/images/social/emoji/100.jpg",a:'警察'},101:{i:"catalog/view/theme/cnstorm/images/social/emoji/101.jpg",a:'天使'},102:{i:"catalog/view/theme/cnstorm/images/social/emoji/102.jpg",a:'公主'},103:{i:"catalog/view/theme/cnstorm/images/social/emoji/103.jpg",a:'卫兵'},104:{i:"catalog/view/theme/cnstorm/images/social/emoji/104.jpg",a:'头骨'},
105:{i:"catalog/view/theme/cnstorm/images/social/emoji/105.jpg",a:'脚印'},106:{i:"catalog/view/theme/cnstorm/images/social/emoji/106.jpg",a:'红唇'},107:{i:"catalog/view/theme/cnstorm/images/social/emoji/107.jpg",a:'嘴巴'},108:{i:"catalog/view/theme/cnstorm/images/social/emoji/108.jpg",a:'耳朵'},109:{i:"catalog/view/theme/cnstorm/images/social/emoji/109.jpg",a:'眼睛'},110:{i:"catalog/view/theme/cnstorm/images/social/emoji/110.jpg",a:'鼻子'}};
var emoji_strtoimg = {鼻子:'emoji/110.jpg',眼睛:'emoji/109.jpg',耳朵:'emoji/108.jpg',嘴巴:'emoji/107.jpg',红唇:'emoji/106.jpg',脚印:'emoji/105.jpg',头骨:'emoji/104.jpg',卫兵:'emoji/103.jpg',公主:'emoji/102.jpg',天使:'emoji/101.jpg',警察:'emoji/100.jpg',建筑工人:'emoji/99.jpg',包头巾:'emoji/98.jpg',瓜皮帽:'emoji/97.jpg',金发碧眼:'emoji/96.jpg',老爷爷:'emoji/95.jpg',老奶奶:'emoji/94.jpg',婴儿:'emoji/93.jpg',男人:'emoji/92.jpg',女人:'emoji/91.jpg',女孩:'emoji/90.jpg',男孩:'emoji/89.jpg',指夹油:'emoji/88.jpg',理发:'emoji/87.jpg',按摩:'emoji/86.jpg',夫妻:'emoji/85.jpg',亲密:'emoji/84.jpg',鞠躬:'emoji/83.jpg',服务员:'emoji/82.jpg',防御:'emoji/81.jpg',饶命:'emoji/80.jpg',兔女郎:'emoji/79.jpg',跳舞:'emoji/78.jpg',情侣:'emoji/77.jpg',跑步:'emoji/76.jpg',散步:'emoji/75.jpg',行人:'emoji/74.jpg',强壮:'emoji/73.jpg',鼓掌:'emoji/72.jpg',食指:'emoji/71.jpg',祈祷:'emoji/70.jpg',手掌:'emoji/69.jpg',左边:'emoji/68.jpg',右边:'emoji/67.jpg',下面:'emoji/66.jpg',上面:'emoji/65.jpg',手影:'emoji/64.jpg',暂停:'emoji/63.jpg',挥手:'emoji/62.jpg',剪刀手:'emoji/61.jpg',加油:'emoji/60.jpg',拳头:'emoji/59.jpg',好:'emoji/58.jpg',鄙视:'emoji/57.jpg',手势:'emoji/56.jpg',大便:'emoji/55.jpg',火焰:'emoji/54.jpg',音乐:'emoji/53.jpg',音符:'emoji/52.jpg',汗水:'emoji/51.jpg',快跑:'emoji/50.jpg',睡觉:'emoji/49.jpg',问号:'emoji/48.jpg',感叹号:'emoji/47.jpg',心情:'emoji/46.jpg',星星:'emoji/45.jpg',小星星:'emoji/44.jpg',一见钟情:'emoji/43.jpg',喜欢:'emoji/42.jpg',心碎:'emoji/41.jpg',红心:'emoji/40.jpg',绿心:'emoji/39.jpg',粉心:'emoji/38.jpg',紫心:'emoji/37.jpg',蓝心:'emoji/36.jpg',黄心:'emoji/35.jpg',外星人:'emoji/34.jpg',恶魔:'emoji/33.jpg',生病:'emoji/32.jpg',困倦:'emoji/31.jpg',撅嘴:'emoji/30.jpg',闭嘴:'emoji/29.jpg',恐怖:'emoji/28.jpg',吃惊:'emoji/27.jpg',大笑:'emoji/26.jpg',大哭:'emoji/25.jpg',哭泣:'emoji/24.jpg',紧张:'emoji/23.jpg',害怕:'emoji/22.jpg',糟糕:'emoji/21.jpg',失望:'emoji/20.jpg',困惑:'emoji/19.jpg',失望:'emoji/18.jpg',深思:'emoji/17.jpg',冷汗:'emoji/16.jpg',假笑:'emoji/15.jpg',不高兴:'emoji/14.jpg',闭眼:'emoji/13.jpg',鬼脸:'emoji/12.jpg',微笑:'emoji/11.jpg',冥想:'emoji/10.jpg',脸红:'emoji/09.jpg',亲一口:'emoji/08.jpg',飞吻:'emoji/07.jpg',爱你:'emoji/06.jpg',眨眼:'emoji/05.jpg',窃喜:'emoji/04.jpg',微笑:'emoji/03.jpg',高兴:'emoji/02.jpg',哈哈:'emoji/01.jpg'};

//对ubb字符转换为表情图片
for(var i=0;i<($('.comment_content').length);i++){
    var comment_content = $('.comment_content').eq(i).html();
    for(var a=0;a<111;a++){
    $.each(emoji_strtoimg,function(i,n){
        comment_content=comment_content.replace(comment_content.match('\\['+i+'\]'),'<span class="emoji_position" style="background:url(\'catalog/view/theme/cnstorm/images/social/'+n+'\') -6px -6px no-repeat"></span>');
    }); 
}
$('.comment_content').eq(i).html(comment_content);    
}    
    })    
    
</script>
 <?php echo $footer ;?>