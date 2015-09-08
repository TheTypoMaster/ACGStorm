<?php

/**
 * @description：谷歌翻译API
 * @author：fc@cnstorm.com
 * @date：2014-11-20
 */
Class Gtranslate {

	/**
	 * 调用google翻译url，将接收的汉语文字翻译成英语
	 * 目前无英语->汉语的需求，因此此处未将翻译语种分离
	 */
	public function translate($q) {
		$q = str_replace('。', '.', $q);
		$q = str_replace('！', '!', $q);
		$q = str_replace('？', '?', $q);
		$url = "translate.google.cn/translate_a/single?client=t&sl=zh-CN&tl=en&dt=t&ie=UTF-8&q=" . urlencode($q);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);
		// return $data;
		$data = explode('","', $data);
		// $data = explode('"', $data[0]);
		$data = substr($data[0], 4);
		return $data;
	}
}