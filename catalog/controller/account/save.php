<?php
class ControllerAccountSave extends Controller{
	public function index(){
              header('Content-type:image/jpeg');
		if ($_SERVER ['REQUEST_METHOD'] == 'POST'){
			$targ_w = $targ_h = 150;
			$jpeg_quality = 90;
			$src = $_POST['src'];
			$extension = substr($src,strrpos($src,".")+1);
			$imagecreatefromextension = 'imagecreatefrom' . $extension;
			if ($extension == 'jpg') {
				$imagecreatefromextension = 'imagecreatefromjpeg';
			}
			$img_r = $imagecreatefromextension( $src );
			$dst_r = ImageCreateTrueColor ( $targ_w, $targ_h );
			imagesavealpha($img_r, true);
			imagealphablending($dst_r, false);
			imagesavealpha($dst_r, true);
			imagecopyresampled ( $dst_r, $img_r, 0, 0, $_POST ['x'], $_POST ['y'], $targ_w, $targ_h, $_POST ['w'], $_POST ['h'] );
			$time = md5(time ());
			$imageextension = 'image' . $extension;
			if ($extension == 'jpg') {
				$imageextension = 'imagejpeg';
			}
			$face = $this->customer->getFace();
			if (!empty($face))  @unlink($face);
			@unlink($src);
			$target_r = 'uploads/big/' . $time . '.'.$extension;
			$sql = "UPDATE " . DB_PREFIX . "customer SET face = '" . $target_r . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'";
			$info = $this->db->query($sql);
			$imageextension( $dst_r,$target_r);
			$msg=array('msg'=>"裁剪成功",'img_r'=>$target_r);
			echo json_encode($msg);
		}		
	}
}
?>