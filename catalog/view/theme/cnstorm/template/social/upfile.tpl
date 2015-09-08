<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="catalog/view/javascript/jquery2/jquery.min.js"></script>
        <style>
            .add_image{width: 96px;height:96px;position:relative;margin-right:9px;padding:1px;left:-10px;top:-2px}
            .add_image img{width:96px;height:95px;}
            .u-image-del{width:11px;height:12px;cursor:pointer;top:1px;left:83px; position: absolute;background: url('images/ico.png') 85.5% 86.3% no-repeat; }
        </style>  
    </head>
    <body>
        <form action="index.php?route=social/upfile/upload" method="post" enctype="multipart/form-data">
        <div class="add_image image_1">
             <label class="up-file" for="male_1" style="display:block;text-align:center;"><img src="catalog/view/theme/cnstorm/images/social/add_image.png" style="width:95px;height:95px;padding-left:1px;"/></label>
                 <input name="fileToUpload"  hidden="hidden" type="file" class="male" id="male_1" style="display: none"/>
                 <input type="submit" style="display:none" />
         </div>
        </form>
        <script>
        
$(function(){
$(".male").change(function(){
$(this).prev().find('img').attr("src","catalog/view/theme/cnstorm/images/social/load_img.gif").css({width:'auto',height:'auto'});
var strSrc = $(this).val();  
img = new Image();  
img.src = getFullPath(strSrc);  
//验证上传文件格式是否正确  
var pos = strSrc.lastIndexOf(".");  
var lastname = strSrc.substring(pos, strSrc.length);

if (img.height / img.width > 1.5 || img.height / img.width < 1.25) {  
    alert("您上传的图片比例超出范围，宽高比应介于1.25-1.5");   
    return;  
}  
//验证上传文件是否超出了大小  
if (img.fileSize / 1024 > 150) {  
    alert("您上传的文件大小超出了150K限制！");  
    return false;  
} 

//$(this).prev().find('img').attr("src",getFullPath(this));
$('.add_image').eq(($(".male").index(this)+1)).show();
$("form").submit();

});
$('.u-image-del').click(function(){
  $(this).next().find('img').attr("src","images/add_image.png");
  $(this).nextAll('input').val(''); 
  //$('.'+$(this).attr('id')).hide(); 
});
});
function getFullPath(obj) {    //得到图片的完整路径 
        if (obj) {  
            //ie  
            if (window.navigator.userAgent.indexOf("MSIE") >= 1) { 
             if(document.selection){
                return obj.value;
             }
            }  
            //firefox  
            else if (window.navigator.userAgent.indexOf("Firefox") >= 1) {  
                if (obj.files) {  
                    return window.URL.createObjectURL(obj.files[0]);  
                }  
            }
            if (obj.files) {  
                    return window.URL.createObjectURL(obj.files[0]);  
            }
        }
        
}

        </script>        
    </body>
</html>
