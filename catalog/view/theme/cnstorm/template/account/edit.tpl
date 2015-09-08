<title>个人资料-设置您的CNstorm账户的个人资料</title>
<meta name="keywords" content="账户管理, CNstorm账户,个人账户，个人设置，个人资料" />
<meta name="description" content="欢迎到CNstrom个人设置中心，修改个人资料" />
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/common.css" type="text/css" />
<link rel="stylesheet" href="catalog/view/theme/cnstorm/stylesheet/jquery.Jcrop.css" type="text/css" />
<?php echo $header;?>
<script charset="UTF-8" type="text/javascript">
function clickFun()
{  
  $('#person_center_1').hide();
  $('#person_center_2').hide();
        $('#person_center_'+<?php echo $id ?>).fadeIn();
        $('#pc'+<?php echo $id ?>).addClass('on');
}
</script>
<script type="text/javascript">
$(function(){
    $("#gg").sjSelect();
    var api = {};
    function isIE(){
      //判断是否是IE浏览器
      if(!+[ 1, ]){
        //是IE浏览器
        createJCrop(1);
        return true;
      }else{
        //单独判断IE10
        if(document.documentMode == 10) {
          createJCrop(1);
          return true;
        }else {
          //非IE浏览器
          createJCrop(0);
          return false;
        }
      }
    }
    //分两种情况创建Jcrop实例，即下面的createJCrop()方法
    function createJCrop(flag) {
      if(flag==0) {
        //非IE下创建
        $('#big').Jcrop({
          onSelect :updateCoords,
          onChange :updateCoords,
          aspectRatio : 1
        });
      }else{
        //IE下创建
        api=$.Jcrop('#big', { 
          onSelect:updateCoords,
          onChange:updateCoords, 
          aspectRatio : 1
        }); 
      } 
    }
    function updateCoords(obj){
      $("#x").val(obj.x);
      $("#y").val(obj.y);
      $("#w").val(obj.w);
      $("#h").val(obj.h);
      $('#imgsrc').val($('#big').attr('src'));
      if(parseInt(obj.w) > 0){
        var rx = $("#preview_box").width() / obj.w; 
        var ry = $("#preview_box").height() / obj.h;
        $("#crop_preview").css({
          width:Math.round(rx * $("#big").width()) + "px",
          height:Math.round(rx * $("#big").height()) + "px",
          marginLeft:"-" + Math.round(rx * obj.x) + "px",
          marginTop:"-" + Math.round(ry * obj.y) + "px"
        });
      }
    }
    $("#crop_submit").click(function(){
      if(parseInt($("#x").val()) >= 0){
        $("#loading").show();
        $.ajax({
            url:"index.php?route=account/save",
            dataType:"json",
            data:{
            x : $('#x').val(),
            y : $('#y').val(),
            w : $('#w').val(),
            h : $('#h').val(),
            src : $('#imgsrc').val()
          },
            type:"POST",
            success:function(req){
                $("#loading").hide();
                $("#callinfo").html(' ');
                setTimeout(function(){
                  $("#callinfo").html(req.msg);
                  $(".images img").attr('src',req.img_r);
                },300);
                var bigimg = '<img alt="上传图片" id="big1" src="'+$('#imgsrc').val()+'"/>';
                var smallimg = '<span id="preview_box" class="crop_preview">';
                    smallimg += '<img alt="上传图片" id="crop_preview" src="'+req.img_r+'" width="100" height="100"/>';
                    smallimg += '</span><p>100*100像素</p>';
                    $("#div_upload_big").html('');
                    $("#div_upload_big").html(bigimg);
                    $("#bigger").html('');
                    $("#bigger").html(smallimg);
                    $("#crop_form").html(" ");
                var hidimg = '<input type="button" value="已保存" id="crop_submit1"><span id="callinfo"></span>';
                $("#crop_form").html(hidimg);
            },
            error:function(){
                alert("请求失败！");
            }
        });
      }else{
        alert("请先上传图片！");  
      }
    });
$('body').delegate('#fileToUpload','change',function(){
        $("#loading").show();
        $.ajaxFileUpload({
            url:'index.php?route=account/upload&time='+new Date(),//处理图片脚本
            secureuri :false,
            fileElementId :'fileToUpload',//file控件id
            dataType : 'json',
            success : function (data, status){
                if(typeof(data.error) != 'undefined'){
                    if(data.error != ''){
                        alert(data.error);
                    }else{
                      $("#loading").hide();
                      var bigimg = '<img alt="上传图片" id="big" src="'+data.msg+'"/>';
                      var smallimg = '<span id="preview_box" class="crop_preview">';
                      smallimg += '<img alt="上传图片" id="crop_preview" src="'+data.msg+'"/>';
                      smallimg += '</span><p>100*100像素</p>';
                      $("#div_upload_big").html('');
                      $("#div_upload_big").html(bigimg);
                      $("#bigger").html('');
                      $("#bigger").html(smallimg);
                      $("#callinfo").html(' ');
                      isIE();
                    }
                }
            },
            error: function(data, status, e){
                alert('fail');
            }
      });
      return false;
    });
});
</script>
<style>
.lSelect { width: 90px; height: 25px; }
.btn { height: 30px; line-height: 30px; width: 200px; color: #ffffff; margin-left: 50px; background: #FB6E52; border: 5px solid #FB6E52; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; font: normal 12px Tahoma; }
.fileToUpload { height: 30px; line-height: 30px; width: 200px; margin-left: 50px; position: absolute; left: 30px; filter: alpha(opacity =0); -moz-opacity: 0; -khtml-opacity: 0; opacity: 0; }
.hid_img { position: absolute; left: 200px; top: 370px; }
#crop_submit, #crop_submit1 { width: 50px; height: 30px; line-height: 30px; color: #ffffff; background: #FB6E52; border: 5px solid #FB6E52; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; font: normal 12px Tahoma; }
#callinfo { width: 80px; height: 18px; line-height: 18px; color: green; }
</style>

<div class="goods_details_bg">
  <div class="yhzx wrap">
    <div class="user_center"> <?php echo $column_left ;?>
      <div class="daigou_list">
        <div class="dl_head">
          <h3 class="bg1">个人资料</h3>
        </div>
        <div class="all_dingdan">
          <ul class="dingdan_list">
            <li><a id="pc1" href="javascript:void(0);">基本资料</a></li>
            <li><a id="pc2" href="javascript:void(0);">头像修改</a></li>
            <!--<p class="percent">资料完整度：<b>30</b>%</p>-->
          </ul>
          <div class="basic_informs" id="person_center_1">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <!--
              <div class="cont"> <span class="cont_left"><b>*</b>昵称：</span>
                <input class="bi_input" readonly="readonly" name="firstname" value="<?php echo $firstname; ?>" type="text" />
              </div>
              -->
              <div class="cont">
                <label class="cont_left">性别：</label>
                <span class="sex">
                <?php if("male" == $sex){ ?>
                <input type="radio" name="sex" value="male" checked="checked" />
                <span>男</span> </span> <span class="sex">
                <input type="radio" name="sex" value="female" />
                <span>女</span> </span>
                <?php }else if("female" == $sex){  ?>
                <input type="radio" name="sex" value="male"/>
                <span>男</span> </span> <span class="sex">
                <input type="radio" name="sex" value="female" checked="checked" />
                <span>女</span> </span>
                <?php }else{ ?>
                <input type="radio" name="sex" value="male" checked="checked" />
                <span>男</span> </span> <span class="sex">
                <input type="radio" name="sex" value="female" />
                <span>女</span> </span>
                <?php } ?>
              </div>
              <div class="cont">
                <label class="cont_left">性取向：</label>
                <span class="sex">
                <?php if("male" == $sexuality){ ?>
                <input type="radio" name="sex_choose" value="male" checked="checked" />
                <span>男</span> </span> <span class="sex">
                <input type="radio" name="sex_choose" value="female"/>
                <span>女</span> </span>
                <?php }else if("female" == $sexuality){  ?>
                <input type="radio" name="sex_choose" value="male"/>
                <span>男</span> </span> <span class="sex">
                <input type="radio" name="sex_choose" value="female" checked="checked" />
                <span>女</span> </span>
                <?php }else{ ?>
                <input type="radio" name="sex_choose" value="male"/>
                <span>男</span> </span> <span class="sex">
                <input type="radio" name="sex_choose" value="female" checked="checked"/>
                <span>女</span> </span>
                <?php } ?>
              </div>
              <div class="cont">
                <label class="cont_left">生日：</label>
                <input type="hidden" id="gg" sel="2014,08,19" />
              </div>
              <div class="cont"> <span class="cont_left">真实姓名：</span>
                <input class="bi_input" name="lastname" value="<?php echo $lastname; ?>"  type="text" />
              </div>
              <!-- <div class="cont"> <span class="cont_left">移动电话：</span>
                <input class="bi_input" name="mobile" value="<?php echo $mobile; ?>" type="text" />
                <?php if ($error_mobile) { ?>
                <span class="error"><?php echo $error_mobile; ?></span>
                <?php } ?>
              </div>
              <div class="cont"> <span class="cont_left">固定电话：</span>
                <input class="bi_input" name="telephone" value="<?php echo $telephone; ?>"type="text" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php } ?>
              </div> -->
              <div class="cont"> <span class="cont_left">感情状况</span>
                <select class="bi_select" name="marriage">
                  <?php if("请选择" == $marriage) {  ?>
                  <option selected>请选择</option>
                  <?php }else{  ?>
                  <option>请选择</option>
                  <?php } ?>
                  <?php if("单身" == $marriage) {  ?>
                  <option selected>单身</option>
                  <?php }else{  ?>
                  <option>单身</option>
                  <?php } ?>
                  <?php if("求交往" == $marriage) {  ?>
                  <option selected>求交往</option>
                  <?php }else{  ?>
                  <option>求交往</option>
                  <?php } ?>
                  <?php if("暗恋中" == $marriage) {  ?>
                  <option selected>暗恋中</option>
                  <?php }else{  ?>
                  <option>暗恋中</option>
                  <?php } ?>
                  <?php if("暧昧中" == $marriage) {  ?>
                  <option selected>暧昧中</option>
                  <?php }else{  ?>
                  <option>暧昧中</option>
                  <?php } ?>
                  <?php if("恋爱中" == $marriage) {  ?>
                  <option selected>恋爱中</option>
                  <?php }else{  ?>
                  <option>恋爱中</option>
                  <?php } ?>
                  <?php if("订婚" == $marriage) {  ?>
                  <option selected>订婚</option>
                  <?php }else{  ?>
                  <option>订婚</option>
                  <?php } ?>
                  <?php if("已婚" == $marriage) {  ?>
                  <option selected>已婚</option>
                  <?php }else{  ?>
                  <option>已婚</option>
                  <?php } ?>
                  <?php if("分居" == $marriage) {  ?>
                  <option selected>分居</option>
                  <?php }else{  ?>
                  <option>分居</option>
                  <?php } ?>
                  <?php if("离异" == $marriage) {  ?>
                  <option selected>离异</option>
                  <?php }else{  ?>
                  <option>离异</option>
                  <?php } ?>
                  <?php if("丧偶" == $marriage) {  ?>
                  <option selected>丧偶</option>
                  <?php }else{  ?>
                  <option>丧偶</option>
                  <?php } ?>
                </select>
              </div>
              <div class="cont">
                <label class="cont_left">有无子女：</label>
                <span class="sex">
                <?php if(1 == $children){ ?>
                <input type="radio" name="children" value=1 checked="checked" />
                <?php }else{  ?>
                <input type="radio" name="children" value=1 />
                <?php } ?>
                <span>有</span> </span> <span class="sex">
                <?php if(0 == $children){ ?>
                <input type="radio" name="children" value=0 checked="checked" />
                <?php }else{  ?>
                <input type="radio" name="children" value=0 />
                <?php } ?>
                <span>无</span> </span> </div>
              <div class="cont"> <span class="cont_left">教育程度：</span>
                <select class="bi_select" name="education">
                  <?php if("请选择" == $education) {  ?>
                  <option selected>请选择</option>
                  <?php }else{  ?>
                  <option>请选择</option>
                  <?php } ?>
                  <?php if("高中及以下" == $education) {  ?>
                  <option selected>高中及以下</option>
                  <?php }else{  ?>
                  <option>高中及以下</option>
                  <?php } ?>
                  <?php if("大学专科" == $education) {  ?>
                  <option selected>大学专科</option>
                  <?php }else{  ?>
                  <option>大学专科</option>
                  <?php } ?>
                  <?php if("大学本科" == $education) {  ?>
                  <option selected>大学本科</option>
                  <?php }else{  ?>
                  <option>大学本科</option>
                  <?php } ?>
                  <?php if("硕士" == $education) {  ?>
                  <option selected>硕士</option>
                  <?php }else{  ?>
                  <option>硕士</option>
                  <?php } ?>
                  <?php if("博士及以上" == $education) {  ?>
                  <option selected>博士及以上</option>
                  <?php }else{  ?>
                  <option>博士及以上</option>
                  <?php } ?>
                </select>
              </div>
              <div class="cont"> <span class="cont_left">从事行业：</span>
                <select class="bi_select" name="job" class="bi_select">
                <?php if("请选择" == $job) {  ?>
                <option selected>请选择</option>
                <?php }else{  ?>
                <option>请选择</option>
                <?php } ?>
                <?php if("政府机关/社会团体" == $job) {  ?>
                <option selected>政府机关/社会团体</option>
                <?php }else{  ?>
                <option>政府机关/社会团体</option>
                <?php } ?>
                <?php if("邮电通讯" == $job) {  ?>
                <option selected>邮电通讯</option>
                <?php }else{  ?>
                <option>邮电通讯</option>
                <?php } ?>
                <?php if("IT业/互联网" == $job) {  ?>
                <option selected>IT业/互联网</option>
                <?php }else{  ?>
                <option>IT业/互联网</option>
                <?php } ?>
                <?php if("商业/贸易" == $job) {  ?>
                <option selected>商业/贸易</option>
                <?php }else{  ?>
                <option>商业/贸易</option>
                <?php } ?>
                <?php if("旅游/餐饮/酒店" == $job) {  ?>
                <option selected>旅游/餐饮/酒店</option>
                <?php }else{  ?>
                <option>旅游/餐饮/酒店</option>
                <?php } ?>
                <?php if("银行/金融/证券/保险/投资" == $job) {  ?>
                <option selected>银行/金融/证券/保险/投资</option>
                <?php }else{  ?>
                <option>银行/金融/证券/保险/投资</option>
                <?php } ?>
                <?php if("健康/医疗服务" == $job) {  ?>
                <option selected>健康/医疗服务</option>
                <?php }else{  ?>
                <option>健康/医疗服务</option>
                <?php } ?>
                <?php if("建筑/房地产" == $job) {  ?>
                <option selected>建筑/房地产</option>
                <?php }else{  ?>
                <option>建筑/房地产</option>
                <?php } ?>
                <?php if("交通运输/物流仓储" == $job) {  ?>
                <option selected>交通运输/物流仓储</option>
                <?php }else{  ?>
                <option>交通运输/物流仓储</option>
                <?php } ?>
                <?php if("法律/司法" == $job) {  ?>
                <option selected>法律/司法</option>
                <?php }else{  ?>
                <option>法律/司法</option>
                <?php } ?>
                <?php if("文化/娱乐/体育" == $job) {  ?>
                <option selected>文化/娱乐/体育</option>
                <?php }else{  ?>
                <option>文化/娱乐/体育</option>
                <?php } ?>
                <?php if("媒介/广告" == $job) {  ?>
                <option selected>媒介/广告</option>
                <?php }else{  ?>
                <option>媒介/广告</option>
                <?php } ?>
                <?php if("教育/科研" == $job) {  ?>
                <option selected>教育/科研</option>
                <?php }else{  ?>
                <option>教育/科研</option>
                <?php } ?>
                <?php if("农/林/渔/牧" == $job) {  ?>
                <option selected>农/林/渔/牧</option>
                <?php }else{  ?>
                <option>农/林/渔/牧</option>
                <?php } ?>
                <?php if("制造业（轻工业）" == $job) {  ?>
                <option selected>制造业（轻工业）</option>
                <?php }else{  ?>
                <option>制造业（轻工业）</option>
                <?php } ?>
                <?php if("制造业（重工业）" == $job) {  ?>
                <option selected>制造业（重工业）</option>
                <?php }else{  ?>
                <option>制造业（重工业）</option>
                <?php } ?>
                <?php if("能源/公用事业" == $job) {  ?>
                <option selected>能源/公用事业）</option>
                <?php }else{  ?>
                <option>能源/公用事业</option>
                <?php } ?>
                <?php if("其他" == $job) {  ?>
                <option selected>其他</option>
                <?php }else{  ?>
                <option>其他</option>
                <?php } ?>
                </select>
              </div>
              <div class="cont"> <span class="cont_left">月收入：</span>
                <select class="bi_select"  name="salary">
                  <?php if("请选择" == $salary) {  ?>
                  <option selected>请选择</option>
                  <?php }else{  ?>
                  <option>请选择</option>
                  <?php } ?>
                  <?php if("无收入" == $salary) {  ?>
                  <option selected>无收入</option>
                  <?php }else{  ?>
                  <option>无收入</option>
                  <?php } ?>
                  <?php if("2000以下" == $salary) {  ?>
                  <option selected>2000以下</option>
                  <?php }else{  ?>
                  <option>2000以下</option>
                  <?php } ?>
                  <?php if("2000-3999" == $salary) {  ?>
                  <option selected>2000-3999</option>
                  <?php }else{  ?>
                  <option>2000-3999</option>
                  <?php } ?>
                  <?php if("4000-5999" == $salary) {  ?>
                  <option selected>4000-5999</option>
                  <?php }else{  ?>
                  <option>4000-5999</option>
                  <?php } ?>
                  <?php if("6000-7999" == $salary) {  ?>
                  <option selected>6000-7999</option>
                  <?php }else{  ?>
                  <option>6000-7999</option>
                  <?php } ?>
                  <?php if("8000-9999" == $salary) {  ?>
                  <option selected>8000-9999</option>
                  <?php }else{  ?>
                  <option>8000-9999</option>
                  <?php } ?>
                  <?php if("10000-15000" == $salary) {  ?>
                  <option selected>10000-15000</option>
                  <?php }else{  ?>
                  <option>10000-15000</option>
                  <?php } ?>
                  <?php if("15000以上" == $salary) {  ?>
                  <option selected>15000以上</option>
                  <?php }else{  ?>
                  <option>15000以上</option>
                  <?php } ?>
                </select>
              </div>
              <div class="cont"> <span class="cont_left">家乡：</span>
                <input class="bi_input" name="hometown" value="<?php echo $hometown; ?>" type="text" />
              </div>
              <div class="cont"> <span class="cont_left">现居：</span>
                <input class="bi_input" name="live" value="<?php echo $live; ?>" type="text" />
              </div>
              <div class="cont"> <span class="cont_left">博客：</span>
                <input class="bi_input" name="blog" value="<?php echo $blog; ?>" type="text" />
              </div>
              <div class="bi_btn">
                <input value="提交" type="submit" />
                <!--<span>立即完善基本资料，即可获赠<b>100</b>积分</span>--> </div>
            </form>
          </div>
          <div class="basic_informs" style="display:none;" id="person_center_2">
            <div class="image_left">
              <div class="big_size" id="div_upload_big">
                <?php if($face) {  ?>
                <img id="big" alt="头像" src="<?php echo $face; ?>" height="248" width="398">
                <?php }else{  ?>
                <img id="big" alt="头像" src="image/head1.jpg" height="248" width="398">
                <?php } ?>
              </div>
              <p class="about_image">仅支持JPG、GIF、PNG、JPEG、BMP格式，文件小于4M</p>
              <div>
                <input type="button" id="btn" class="btn" value="选择您要上传的头像">
                <input name="fileToUpload" type="file" class="fileToUpload" id="fileToUpload">
                <img alt="loading" id="loading" src="image/loading.gif" style="display:none;" class="hid_img"> </div>
            </div>
            <div class="image_right">
              <h3>效果预览</h3>
              <p class="about_upload ml10">您上传的图片会自动生成小尺寸，请注意小尺寸的头像是否清晰</p>
              <ul class="upload_list">
                <li class="bigger"  id="bigger"> <span id="preview_box" class="crop_preview">
                  <?php if($face) {  ?>
                  <img alt="预览头像" id="crop_preview" src="<?php echo $face; ?>" height="100" width="100">
                  <?php }else{  ?>
                  <img alt="预览头像" id="crop_preview" src="image/head1.jpg" width="100" height="100"/>
                  <?php } ?>
                  </span>
                  <p>100*100像素</p>
                </li>
              </ul>
              <div id="crop_form">
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="imgsrc" name="imgsrc" />
                <input type="button" value="保存" id="crop_submit">
                <span id="callinfo"></span> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
clickFun();
</script> 
<!--<script type="text/javascript" src="catalog/view/javascript/jquery2/effects.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.imgareaselect.min.js"></script> --> 
<script type="text/javascript" src="catalog/view/javascript/jquery2/ajaxfileupload.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery2/jquery.Jcrop.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery2/jdate.js"></script> 
<?php echo $footer; ?>