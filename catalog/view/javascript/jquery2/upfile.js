var iframe = '<div id="add" style="float: left;width: 93px;height:93px;padding:0px;margin:0px;margin-top:6px"><iframe id="upfile" name="upfile" src="index.php?route=order/upfile" style="border:none"></iframe></div>';
var picNumber = 0;// 上传图片数
var ajaxUpImg = '';// 显示上传图片的大字符串
$(function() {
	startUp($(".male"));
});
// 出发上传事件
function startUp(obj) {
	obj.change(function() {
		var strSrc = $(this).val();
		checkImg(strSrc);
		$(this).prev().find('img').attr("src", getFullPath(this));
		$("form").submit();
	});
}
// 上传多张图片
function get_file_path(filename) {
	var addImageFileHTML = document.getElementById("add_image_file");
	var number = document.getElementById('number');
	var imgTail = (picNumber == 5) ? '' : iframe;
	addImageFileHTML.innerHTML = '';
	ajaxUpImg += '<div class="add_image image_1" style="float: left;width: 93px;height: 93px;position: relative;border: 1px #bfbfbf solid;background: #ffffff;padding: 1px;margin-right: 6px;">'
			+ '<div class="u-image-del" style="width:11px;height:12px;cursor:pointer;top:1px;left:83px; position: absolute;background: url(../image/ico.png) 85.5% 86.3% no-repeat;"  onclick="del_img( this )"></div>'
			+ '<div class="up-file"><img style="width: 93px;height: 93px;" src="' + filename + '"/></div>'
			+ '<input name="massageImage[]'
			+ '"  hidden="hidden" type="text" class="male" value="' + filename
			+ '" style="display: none"/>' + '</div>';
	picNumber++;
	number.innerHTML = 6 - picNumber;
	addImageFileHTML.innerHTML = ajaxUpImg + imgTail;
}
// 删除多张图片
function del_img(sub) {
	var number = document.getElementById('number');
	var addImageFileHTML = document.getElementById("add_image_file");
	addImageFileHTML.removeChild(sub.parentNode);
	if (picNumber == 6)
		addImageFileHTML.innerHTML += iframe;
	var children = addImageFileHTML.children;
	ajaxUpImg = '';
	for ( var i = 0; i < children.length - 1; i++) {
		ajaxUpImg += children[i].outerHTML;
	}
	picNumber--;
	number.innerHTML = 6 - picNumber;
}
// 修改图片
/*
 * function modify(id) { id.parentNode.parentNode.outerHTML = iframe;
 * document.getElementById("male_1").change();
 * alert(id.parentNode.parentNode.outerHTML); }
 */
// 获取图片路径
function getFullPath(obj) {
	if (obj) {// ie
		if (window.navigator.userAgent.indexOf("MSIE") >= 1) {
			if (document.selection) {
				return obj.value;
			}
		}// firefox
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
// 上传图片限制
function checkImg(strSrc) {
	img = new Image();
	img.src = getFullPath(strSrc);
	if (img.height / img.width > 1.5 || img.height / img.width < 1.25) {
		alert("您上传的图片比例超出范围，宽高比应介于1.25-1.5");
		return;
	}
	if (img.fileSize / 1024 > 150) {
		alert("您上传的文件大小超出了150K限制！");
		return false;
	}
}