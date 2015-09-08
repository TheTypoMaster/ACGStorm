<?php

class ControllerGuojiGuoji extends Controller {

    public function index() {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('guoji/guoji');


        $username_id = $this->session->data['customer_id'];
        $this->data['score'] = $this->customer->getScore();
        $address = $this->model_guoji_guoji->address($username_id);
        $this->data['address'] = $address;
        $this->data['student'] = $this->customer->getVerify();
        
        //获取所有可用优惠卷
        $this->load->model('account/coupon');
        
        //所有优惠卷的获取
        $coupon_info = $this->model_account_coupon->getCouponsByid();
        
        foreach($coupon_info as $coupon){
      
	        $enddate = date("Y-m-d",$coupon['endtime']);
	       
	        $today  = date("Y-m-d",time());
	        
	        if($today > $enddate)
	        {
	            $this->model_account_coupon->updateCoupon($coupon['cid'],4);
	        }
        }
        
        //优惠卷总数
        $coupon_info = $this->model_account_coupon->getCouponsByState();
                
        $this->data['coupon_total'] = count($coupon_info);
        $this->data['coupon_info']  = $coupon_info;
        //end


        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            if (isset($this->request->post['selected'])) {

                $yundan_order = $this->request->post['selected'];

                $cc = $this->model_guoji_guoji->insert_yundan($yundan_order);
            }
        }

        if (isset($this->request->get['order_dede_id'])) {

            $order_dede_id = $this->request->get['order_dede_id'];

            $product = $this->model_guoji_guoji->del($order_dede_id);
        }



        //$results = $this->model_guoji_guoji->getOrders($username_id);
        $results = $this->model_guoji_guoji->getOrders_guoji($username_id);

        $all_weight = $this->model_guoji_guoji->Total_weight($results);
        $this->data['all_weight'] = $all_weight;

        $all_order_id = array();

        foreach ($results as $result) {

            $all_order_id[] = $result['order_id'];

            $product = $this->model_guoji_guoji->getOrderProducts($result['order_id']);

            $tot_weight = $this->model_guoji_guoji->tot_weight($result['order_id']);

            $product_str = '';
            $order_sensitive = '';
            $order_branding = '';
            foreach ($product as $key => $value) {
                $product_url = $value['producturl'];
                $product_str .= $value['name'] . '<br/>';
                $order_sensitive .= $value['order_sensitive'];
                $order_branding .= $value['order_branding'];
            }

            $sensitive = '';
            $pan = "2";                                         //2表示敏感字眼
            $con = explode($pan, $order_sensitive);
            $con2 = explode($pan, $order_branding);
            if (count($con) > 1) {
                $sensitive = "敏感品";
                $this->data['order_all_mingan'] = 'sensitive';
            } else if (count($con2) > 1) {
                $sensitive = "品牌";
                $this->data['order_all_mingan'] = 'branding';
            }

            $this->data['orders'][] = array(
                'order_id' => $result['order_id'],
                'order_product_id' => $product[0]['order_product_id'],
                'name' => $product_str,
                'link' => $product_url,
                'sensitive' => $sensitive,
                'weight' => $tot_weight,
                'all_weight' => $all_weight
            );
        }


        $this->data['all_order_id'] = implode(',', $all_order_id);

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        $this->data['utype'] = $this->customer->getUtype();

        //清除防重复提交session
        unset($this->session->data['old_sid']);

        $this->template = 'cnstorm/template/order/national_post_address.tpl';

        $this->children = array(
            'common/header',
            'common/footer',
            'common/column_left'
        );

        $this->response->setOutput($this->render());
    }

    public function newaddress() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('account/address');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $go = $this->model_account_address->addAddress($this->request->post);
        }
        $this->response->setOutput($go);
    }

    public function address() {
        $this->load->model('guoji/guoji');

        if (isset($this->request->get['address_id'])) {

            $address_id = $this->request->get['address_id'];
            $mingan = $this->request->get['order_all_mingan'];

            $username_id = $this->session->data['customer_id'];

            $order_all_mingan = $this->model_guoji_guoji->address_yundan($address_id, $username_id, $mingan);

            $dd = "";

            for ($i = 0; $i < count($order_all_mingan); $i++) {

                $did = $order_all_mingan[$i]['did'];
                $class = "";
                if ($i == 3 || $i == 7) {
                    $class = "class='mr_none'";
                }

                if ($order_all_mingan[$i]['deliveryname']=='DHL') {
                    $dClass = 'dhl';
                } else if ($order_all_mingan[$i]['deliveryname']=='EMS') {
                    $dClass = 'ems';
                } else {
                    $dClass = 'air';
                }

                $dd .= " <li id='" . $did . "' onclick='address3(" . $did . ")'; " . $class . "  >  <p class='ic_top'><span class='" . $dClass . "' id='carrier_" . $did . "'>" . $order_all_mingan[$i]['deliveryname'] . "</span></p>
                                  <div class='ic_middle'>
                                  <table border='0' align='center' cellspacing='0' cellpadding='0'>
                                     <tbody>
                                         <tr>
                                           <td class='bg_fa'>寄达地区</td>
                                           <td class='bg_f7'>" . $order_all_mingan[$i]['areaname'] . "</td>
                                         </tr>
                                         <tr>
                                           <td class='bg_fa'>快递时效</td>
                                           <td class='bg_f7'>" . $order_all_mingan[$i]['delivery_time'] . "个工作日</td>
                                         </tr>
                                         <tr>
                                           <td class='bg_fa'>首重（元）</td>
                                           <td class='bg_f7'>￥<b id='ff_" . $did . "'>" . $order_all_mingan[$i]['first_fee'] . "</b>（<span id='fw_" . $did . "'>" . $order_all_mingan[$i]['first_weight'] . "</span>g）</td>
                                         </tr>
                                         <tr>
                                           <td class='bg_fa'>续重（元） </td>
                                           <td class='bg_f7'>￥<b id='cf_" . $did . "'>" . $order_all_mingan[$i]['continue_fee'] . "</b>（<span id='cw_" . $did . "'>" . $order_all_mingan[$i]['continue_weight'] . "</span>g）</td>
                                         </tr>
                                         <tr>
                                           <td class='bg_fa'>报关费（元） </td>
                                           <td class='bg_f7'>￥<b>" . $order_all_mingan[$i]['customs_fee'] . "</b></td>
                                         </tr>
                                     </tbody>
                                  </table>
                              </div>
                              <dl class='ic_bott'>
                                 <dt><b>特点：</b>" . $order_all_mingan[$i]['carrierDesc'] . "</dt>
	
                              </dl>
                              <i></i>
                          </li>
			";
            }
        }

        $this->response->setOutput($dd);
    }

    public function all_weight() {

        $this->load->model('guoji/guoji');
        if (isset($this->request->get['address_id'])) {

            $address_id = $this->request->get['address_id'];

            $product = $this->model_guoji_guoji->jisuan_yunfei($address_id);
            $dd = $product[0]['deliveryname'] . "快递（首重：￥<b>" . $product[0]['first_fee'] . "</b>；续重￥<b>" . $product[0]['continue_fee'] . "</b>；报关费￥<b>" . $product[0]['customs_fee'] . "</b>）";
        }

        $this->response->setOutput($dd);
    }

    public function submit() {
        $this->load->model('guoji/guoji');
        if (isset($this->request->get['all_weight'])) {
            $all_weight = $this->request->get['all_weight'];
        } else {
            $all_weight = null;
        }

        if (isset($this->request->get['over_yunfei'])) {
            $over_yunfei = $this->request->get['over_yunfei'];
        } else {
            $over_yunfei = null;
        }

        if (isset($this->request->get['dabao'])) {
            $dabao = $this->request->get['dabao'];
        } else {
            $dabao = null;
        }
        if (isset($this->request->get['dingdan'])) {
            $dingdan = $this->request->get['dingdan'];
        } else {
            $dingdan = null;
        }
        if (isset($this->request->get['cailiao'])) {
            $cailiao = $this->request->get['cailiao'];
        } else {
            $cailiao = null;
        }
        if (isset($this->request->get['zengzhi'])) {
            $zengzhi = $this->request->get['zengzhi'];
        } else {
            $zengzhi = null;
        }

        $username_id = $this->session->data['customer_id'];

        $insert_data = array(
            'username_id' => $username_id,
            'zengzhi' => $zengzhi,
            'cailiao' => $cailiao,
            'dingdan' => $dingdan,
            'dabao' => $dabao,
            'over_yunfei' => $over_yunfei,
            'all_weight' => $all_weight,
        );

        $insert_guoji_yundan = $this->model_guoji_guoji->insert_guoji_yundan($insert_data);

        $this->response->setOutput($insert_guoji_yundan);
    }

}

?>