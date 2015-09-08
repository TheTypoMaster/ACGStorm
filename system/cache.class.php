<?php

/**
 * @description：缓存
 * @author：fc@cnstorm.com
 * @date：2014-10-9
 */
Class MyCache {

	/*public function cache_start($time, $dir = 'D:\\php\\') {
		$cachefile = $dir.'/'.sha1($_SERVER['REQUEST_URI']).'.html';
		$cachetime = $time;
		if (file_exists($cachefile) && (time() - filemtime($cachefile) < $cachetime)) {
			include($cachefile);
			ob_end_flush();
			exit;
		}
	}

	public function cache_end($dir = 'D:\\php\\') {
		$cachefile = $dir.'/'.sha1($_SERVER['REQUEST_URI']).'.html';
		$fp = fopen($cachefile, 'w');
		fwrite($fp, ob_get_contents());
		fclose($fp);
		ob_end_flush();
	}*/

	public function array2file($array, $dirname, $filename) {
		$dir = DIR_SYSTEM . '/cache/' . $dirname . '/';
		$this->mk_folder($dir);
		$file = $dir . $filename . '.html';
		file_put_contents($file, serialize($array));
	}

	public function file2array($dirname, $filename) {
		$file = DIR_SYSTEM . '/cache/' . $dirname . '/' . $filename . '.html';
		if (file_exists($file)) {// && time() - filemtime($file) < 3600 * 24 * 7
			return unserialize(file_get_contents($file));
		} else {
			return null;
		}
	}

	private function mk_folder($path) {
		if (!is_readable($path)) {
			$this->mk_folder(dirname($path));
			if (!is_file($path)) mkdir($path, 0777);
		}
	}
}