<?php

/**
 * @description：手机接口二维码部分操作
 * @author：fc@cnstorm.com
 * @date：2014-9-12
 */
Class ControllerAppQrcode extends Controller {

	public function index() {
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/app/qrcode.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/app/qrcode.tpl';
		} else {
			$this->template = 'default/template/app/qrcode.tpl';
		}
		$this->response->setOutput($this->render());
	}
}