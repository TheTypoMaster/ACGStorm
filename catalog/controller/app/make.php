<?php
/**
 * @description：手机接口代寄部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-14
 */
Class ControllerAppMake extends Controller {

	//代寄提交
	public function submit () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);

			if ($param['expressNo'] == "") {
                $order_status_id = "3";
            } else {
                $order_status_id = "4";
            }
			$data = array(
				'username_id' => $param['customerId'],
				'order_status_id' => $order_status_id,
                'order_status_buy' => 3,
                'order_Parcel' => $param['remark'],
                'expresses' => $param['expresses'],
                'order_daiji_name' => $param['name'],
                'express_number' => $param['expressNo']
				);

			$this->load->model('order/order');
			$this->model_order_order->insert_daiji_order($data);

			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}
}