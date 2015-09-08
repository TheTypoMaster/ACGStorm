<?php
class ControllerAccountUpload extends Controller{
	public function index(){
		$error = "";
		$msg = "";
		$fileElementName = 'fileToUpload';
		if (! empty ( $_FILES [$fileElementName] ['error'] )){
			switch ($_FILES [$fileElementName] ['error']) {
				case '1' :
					$error = '上传文件过大';break;
				case '2' :
					$error = '上传文件超过HTML表格中指定的大小';break;
				case '3' :
					$error = '上传的文件只有部分上传';break;
				case '4' :
					$error = '没有上传文件';break;
				case '6' :
					$error = '临时文件夹没找到';break;
				case '7' :
					$error = '无法将文件写入到磁盘';break;
				case '8' :
					$error = '文件上传扩展没开启';break;
				case '999' :
				default :
					$error = '错误';
			}
		}elseif(empty($_FILES ['fileToUpload'] ['tmp_name'] ) || $_FILES ['fileToUpload'] ['tmp_name'] == 'none') {
			$error = '没有上传文件';
		}else{
			$img = pathinfo ( $_FILES ['fileToUpload'] ['name'] );
			$extension = $img ['extension'];
			$imagecreatefromextension = 'imagecreatefrom' . $extension;
			if ($extension == 'jpg'){
				$imagecreatefromextension = 'imagecreatefromjpeg';
			}
			$im = $imagecreatefromextension ( $_FILES ['fileToUpload'] ['tmp_name'] );
			$width = imagesx($im);
			$height = imagesy($im);
			$maxwidth = '398';
			$maxheight = '248';
			$widthratio = $maxwidth / $width;
			$heightratio = $maxheight / $height;
			if ($widthratio < $heightratio) {
				$ratio = $widthratio;
			}else{
				$ratio = $heightratio;
			}
			$newwidth = $width * $ratio;
			$newheight = $height * $ratio;
			if (function_exists ( "imagecopyresampled" )){
				$newim = imagecreatetruecolor ( $newwidth, $newheight );
				imagesavealpha($im, true);
				imagealphablending($newim, false);
				imagesavealpha($newim, true);
				imagecopyresampled ( $newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
			}else{
				$newim = imagecreatetruecolor ( $width, $height );
				imagesavealpha($im, true);
				imagealphablending($newim, false);
				imagesavealpha($newim, true);
				imagecopyresized ( $newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
			}
			$newname = md5 ($_FILES ['fileToUpload']['name'].time ());
			$msg = 'uploads/big/' . $newname . '.' . $img ['extension'];
			$imageextension = 'image' . $extension;
			if ($extension == 'jpg') {
				$imageextension = 'imagejpeg';
			}
			$imageextension ( $newim, $msg );
		}
		echo "{";
		echo "error: '" . $error . "',\n";
		echo "msg: '" . $msg . "'\n";
		echo "}";
	}
}