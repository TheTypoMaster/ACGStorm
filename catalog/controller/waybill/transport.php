<?php
/**
  * start page for waybill
  *
  * PHP version 5
  *
  * @category  PHP
  * @package   PSI_Web
  * @author    Kenne Wei <wk@cnstorm.com>
  * @copyright 2014 cnstorm
  * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
  * @link      http://www.acgstorm.com
  */
 
  
class Controllerwaybilltransport extends Controller {

    public function index() {
        
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('order/order_myhome', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
       
        //获取收货地址
        $this->load->model('waybill/transport');
        
        $address_count = $this->model_waybill_transport->getaddresscount();
        
        $this->data['address_count'] =  $address_count;
       
        $customer_id = $this->customer->getId();
        
        $address_info = $this->model_waybill_transport->getaddress($customer_id);
        
        foreach($address_info as &$info) {
            
            if($info['zone_id']) {
                 $info['city'] = $this->model_waybill_transport->getcitybyzid($info['zone_id']);   
            } else {
                 $info['city'] = '';
            }  
            
            $info['del'] = 'index.php?route=account/address/delete&address_id='.$info['address_id'];
           
        }
        
        $this->data['address'] = $address_info;

        $this->data['student'] = $this->customer->getVerify();
        
        //获取是否是新用户
        $this->load->model('account/customer');
        
        $this->data['shippingnumber'] = $this->model_account_customer->get_shippingnumber();

        
        //标记已经提交的商品
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            if (isset($this->request->post['selected']) && $this->request->post['selected']) {

                $order_id_array = $this->request->post['selected'];

                $this->model_waybill_transport->updateshipping_order($order_id_array,2);
            }
        }        
        
        //获取所有的准备提交运送的商品
        $order_id_array = $this->model_waybill_transport->getshipping_order();
        
        $order_id_group = $order_id_array;

        foreach($order_id_group as $key=>$value) {
            
            $order_id_combination[] = $value['order_id'];
        }
        
        $this->data['order_id_combination'] = implode(',',$order_id_combination);
        
        $sensitive = array();
        
        $brand = array();
        
        foreach($order_id_array as &$order_id) {
            
            $order_id['good_info'] =  $this->model_waybill_transport->getshipping_order_product($order_id['order_id']);
            
            $order_id['weight'] = 0.00;
            
            for($i = 0; $i<count($order_id['good_info']); $i++) {
                $order_id['weight'] += $order_id['good_info'][$i]['weight'];
                $sensitive[] = $order_id['good_info'][$i]['order_sensitive'];  
                $brand[] = $order_id['good_info'][$i]['order_branding'];
            }
        }
        
        $this->data['order_info'] = $order_id_array;
        
        if(in_array(2,$sensitive)) {
            $this->data['sensitive'] = 1;
        }else{
            $this->data['sensitive'] = 0;
        }
        
        
        if(in_array(2,$brand)) {
            $this->data['brand'] = 1;
        }else{
            $this->data['brand'] = 0;
        }
        

        //获取总重量
        $total_weight = 0;
        
        for($j = 0; $j<count($order_id_array); $j++) {
            
            $total_weight += $order_id_array[$j]['weight'];
        }
        
        $this->data['total_weight'] = $total_weight;
        
         //所在国家
		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();
        
        //清除防重复提交session
        unset($this->session->data['old_sid']);

        $this->template = 'cnstorm/template/waybill/transport.tpl';

        $this->children = array(
            'common/header_cart',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }
    
    
    //新增收货地址
    public function newaddress() {
        
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('waybill/transport', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('account/address');
        $this->load->model('waybill/transport');
        
        
        if(isset($this->request->post['newaddress_id']) && $this->request->post['newaddress_id']) {
            
            $newaddress_id = $this->request->post['newaddress_id'];   
        } else {
            $newaddress_id = 0;
        }
        
            
        if(isset($this->request->post['lastname']) && $this->request->post['lastname']) {
            
            $lastname = $this->request->post['lastname'];   
        } 
        
        if(isset($this->request->post['country_id']) && $this->request->post['country_id']) {
            
            $country_id = $this->request->post['country_id'];   
        } 
        
        if(isset($this->request->post['zone_id']) && $this->request->post['zone_id']) {
            
            $zone_id = $this->request->post['zone_id'];   
        } else {
            
            $zone_id = 0;
        }
        
        if(isset($this->request->post['address_details']) && $this->request->post['address_details']) {
            
            $address_details = $this->request->post['address_details'];   
        } 
        
        if(isset($this->request->post['postcode']) && $this->request->post['postcode']) {
            
            $postcode = $this->request->post['postcode'];   
        } 
        
        if(isset($this->request->post['telephone']) && $this->request->post['telephone']) {
            
            $telephone = $this->request->post['telephone'];   
        } 
        
        $data = array( 
            'lastname'  => $lastname,
            'country_id' => $country_id,
            'zone_id' =>  $zone_id ,
            'address_details' => $address_details ,
            'postcode' =>  $postcode, 
            'telephone' => $telephone        
        );
 
        if($newaddress_id) {
           
            $address_id = $this->model_account_address->editAddress($newaddress_id,$data);
            
        }else{
            
            $address_id = $this->model_account_address->addAddress($data);
        }
        
        //返回值
        if($zone_id) {
            $city = $this->model_waybill_transport->getcitybyzid($zone_id);
        }else{
            $city = '';
        }
        
        
        $data_back = array(
            'address_id' => $address_id,
            'lastname'  => $lastname,
            'country' => $this->model_waybill_transport->getcountrybycid($country_id),
            'city' =>  $city,
            'address_details' => $address_details , 
            'telephone' => substr_replace($telephone,'****',3,4)  
               
        );
        
        $this->response->setOutput(json_encode($data_back));
    }
    
    //删除收货地址
    public function deladdress() {
        
         if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('waybill/transport', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('account/address');
            
        if(isset($this->request->post['address_id']) && $this->request->post['address_id']) {
            
            $address_id = $this->request->post['address_id'];   
            
            $result = $this->model_account_address->deleteAddress($address_id);
            
            if($result) {
                
                $this->response->setOutput(json_encode($result));
                
            }
        }
            
    }
    
    //修改收货地址
    public function editaddress() {
        
         if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('waybill/transport', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $this->load->model('waybill/transport');
            
        if(isset($this->request->post['address_id']) && $this->request->post['address_id']) {
            
            $address_id = $this->request->post['address_id'];   
            
            $result = $this->model_waybill_transport->getaddressbyaid($address_id);
            
            if($result) {
                
                $this->response->setOutput(json_encode($result));
                
            }
        }
            
    }
    

    //获取该地址的运输方式
    public function getdelivery() {
         
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('waybill/transport', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        if(isset($this->request->get['address_id']) && $this->request->get['address_id']) {
        
            $this->load->model('waybill/transport');
            $this->load->model('account/customer');
            
            $business = $this->model_account_customer->getBusiness();
            
            //获取地址id
            if(isset($this->request->get['address_id']) && $this->request->get['address_id']) {
                $address_id = $this->request->get['address_id'];
            }
            
            //获取敏感标志
            if(isset($this->request->get['sensitive'])) {
                $sensitive = $this->request->get['sensitive'];
            }
            
            //获取品牌标志
            if(isset($this->request->get['brand'])) {
                $brand = $this->request->get['brand'];
            }
            
            //获取包裹总重量
            if(isset($this->request->get['weight'])) {
                $weight = $this->request->get['weight'];
            }
            
            if(isset($this->request->get['order_id_combination'])) {
                $order_id_combination = $this->request->get['order_id_combination'];
            }
			
		
				
            if ($address_id) {
                
                $data = array(
                    'address_id' => $address_id,
                    'customer_id' => $this->customer->getId(),
                    'sensitive' => $sensitive,
                    'brand' => $brand
                );
               
                $deliver_array = $this->model_waybill_transport->getdelivery($data);
                
                if($weight < 21000 || !$business) {
                    for($i=0;$i<count($deliver_array);$i++) {
                        if('大货特惠价' == $deliver_array[$i]['deliveryname']) {
                            unset($deliver_array[$i]);
                            break;
                        }
                    }
                    
                }
                
                $area_id = $this->model_waybill_transport->getareaid($address_id);
                
                if($sensitive && 6 != $area_id && strpos($order_id_combination,',')) {
                    
                    $data = array(
                        'address_id' => $address_id,
                        'customer_id' => $this->customer->getId(),
                        'sensitive' => 0,
                        'brand' => $brand
                    );
                    
                    $deliver_sensitive_array = $this->model_waybill_transport->getdelivery($data);

					foreach($deliver_sensitive_array as $key=>$v){
						$deliver_sensitive_array[$key]['carrierDesc']=str_replace('&lt;','<',$v['carrierDesc']);
						$deliver_sensitive_array[$key]['carrierDesc']=str_replace('&gt;','>',$v['carrierDesc']);
					}
					
                     if($weight < 21000 || !$business) {
                        for($i=0;$i<count($deliver_sensitive_array);$i++) {
                            if('大货特惠价' == $deliver_sensitive_array[$i]['deliveryname']) {
                                unset($deliver_sensitive_array[$i]);
                                break;
                            }
                        }
                        
                    }
                    
                    if(is_array($deliver_array) && !empty($deliver_array) && is_array($deliver_sensitive_array) && !empty($deliver_sensitive_array)) {
                        for($j=0;$j<count($deliver_sensitive_array);$j++) {
                            for($k=0;$k<count($deliver_array);$k++) {
                                if($deliver_sensitive_array[$j]['did'] == $deliver_array[$k]['did']) {
                                    array_splice($deliver_sensitive_array,$j,1);
                                }
                                
                            }
                        }
                    }
                    
                    $this->data['deliver_sensitive_array'] = $deliver_sensitive_array;
                
                }
                	
                $this->data['deliver_array'] = $deliver_array;
                
                if(isset($deliver_sensitive_array) && $deliver_sensitive_array) {
                    $this->template = 'cnstorm/template/waybill/transport_sensitive_delivery.tpl';
                } else {
                    $this->template = 'cnstorm/template/waybill/transport_delivery.tpl';    
                }
    
                $this->response->setOutput($this->render());
            }
        
        }else{
            
            $this->template = 'cnstorm/template/waybill/transport_address_choose.tpl';
            
            $this->response->setOutput($this->render());
   
        }
       
    }
    
    //将商品放回仓库
    public function layback() {
        
         //获取商品id
        if(isset($this->request->get['order_id']) && $this->request->get['order_id']) {
            
            $this->load->model('waybill/transport');
            
            $order_id = $this->request->get['order_id'];
            
            $this->model_waybill_transport->updateshipping_order($order_id,1);
            
            //获取所有的准备提交运送的商品
            $order_id_array = $this->model_waybill_transport->getshipping_order();
            
            if($order_id_array) {
                
                $order_id_group = $order_id_array;
    
                foreach($order_id_group as $key=>$value) {
                    
                    $order_id_combination[] = $value['order_id'];
                }
                
                $this->data['order_id_combination'] = implode(',',$order_id_combination);
                
                $sensitive = array();
                
                $brand = array();
                
                foreach($order_id_array as &$order_id) {
                    
                    $order_id['good_info'] =  $this->model_waybill_transport->getshipping_order_product($order_id['order_id']);
                    
                    $order_id['weight'] = 0.00;
                    
                    for($i = 0; $i<count($order_id['good_info']); $i++) {
                        
                        $order_id['weight'] += $order_id['good_info'][$i]['weight'];
                        $sensitive[] = $order_id['good_info'][$i]['order_sensitive'];
                        $brand[] = $order_id['good_info'][$i]['order_branding'];
                        
                    }
                }
                
                $this->data['order_info'] = $order_id_array;
                
                if(in_array(2,$sensitive)) {
                    $this->data['sensitive'] = 1;
                }else{
                    $this->data['sensitive'] = 0;
                }
                
                if(in_array(2,$brand)) {
                    $this->data['brand'] = 1;
                }else{
                    $this->data['brand'] = 0;
                }
                //获取总重量
                $total_weight = 0;
                
                for($j = 0; $j<count($order_id_array); $j++) {
                    
                    $total_weight += $order_id_array[$j]['weight'];
                }
                
                $this->data['total_weight'] = $total_weight;
                
            } else {
                $this->data['order_info'] = '';
                $this->data['total_weight'] = 0;
                $this->data['sensitive'] = 0;
                $this->data['order_id_combination'] = '';
            }
            
           
            $this->template = 'cnstorm/template/waybill/transport_goodinfo.tpl';
            
            $this->response->setOutput($this->render());
            
        }
        
    }
    
    
    //获取自选增值服务的费用和包装耗材的费用
    public function getfee() {
        
        //获取重量
        if(isset($this->request->post['order_id_combination']) && $this->request->post['order_id_combination']) {
            $order_id_combination = $this->request->post['order_id_combination'];
        }else{
    	    $order_id_combination = '';
    	}
       
        //获取运输方式
        if(isset($this->request->post['did']) && $this->request->post['did']) {
            $did = $this->request->post['did'];
        }else{
            $did = 0;
        }
        
        if(isset($this->request->post['did_sensitive']) && $this->request->post['did_sensitive']) {
            $did_sensitive = $this->request->post['did_sensitive'];
        }else{
            $did_sensitive = 0;
        }
        
        if(isset($this->request->post['address_id']) && $this->request->post['address_id']) {
            $address_id = $this->request->post['address_id'];
        }else{
            $address_id = 0;
        }
        
        if(isset($this->request->post['areaid']) && $this->request->post['areaid']) {
            $areaid = $this->request->post['areaid'];
        }else{
            $areaid = 0;
        }
        
        if(isset($this->request->post['pak']) && $this->request->post['pak']) {
            $pak = $this->request->post['pak'];
        }else{
            $pak = 0;
        }
        $this->data['usr'] = $this->customer->getFirstName();
        
        $this->data['order_id_combination'] = $order_id_combination;
        
        $this->data['did'] = $did;
        
        $this->data['did_sensitive'] = $did_sensitive;
        
        $this->data['areaid'] = $areaid;
        
        $this->data['address_id'] = $address_id;
        
        $this->data['pak'] = $pak;
        
        $this->data['student'] = $this->customer->getVerify();
        
        $this->load->model('account/customer');
        
        $this->data['shippingnumber'] = $this->model_account_customer->get_shippingnumber();
        
       // echo $order_id_combination,'-',$did,'-' ,$areaid;
		
        if($order_id_combination && $did && $areaid) {
            //如果含有敏感品
            if(isset($did_sensitive) && $did_sensitive) {
        //  echo  1;die;
		
                $this->load->model('waybill/transport');
                
                $order_id_sensitive = $this->get_sensitive_order($order_id_combination);
            
                $order_id_array = explode(',',$order_id_combination);
                
                $order_id_array = array_diff($order_id_array,$order_id_sensitive);
                 if( $order_id_array ){
					$new_order_id_combination = implode(',',$order_id_array);
              
					$this->data['new_order_id_combination'] = $new_order_id_combination;
                
					$this->data['new_order_id_combination_array'] = explode(',',$new_order_id_combination);
				
					$data = $this->getfee_details($new_order_id_combination,$did_sensitive,$areaid);
					 
					 $this->data['servicefee'] =  $data;
               
					 $this->data['freight'] = $data['freight'];
               
                     $this->data['estimate_total'] = round(($data['freight'] + $data['unpack_fee1'] + $data['checkorder_fee1'] + $data['wrapper_fee1'] + 8.00),2);
			 }
			  
                $new_order_id_sensitive = implode(',',$order_id_sensitive);
				
                $this->data['new_order_id_sensitive'] = $new_order_id_sensitive;
                
                $this->data['new_order_id_sensitive_array'] = explode(',',$new_order_id_sensitive);
                
         
               
                $data_sensitive = $this->getfee_details($new_order_id_sensitive,$did,$areaid);
                
               
                
                $this->data['servicefee_sensitive'] =  $data_sensitive;
               
                $this->data['freight_sensitive'] = $data_sensitive['freight'];
               
                $this->data['estimate_total_sensitive'] = round(($data_sensitive['freight'] + $data_sensitive['unpack_fee1'] + $data_sensitive['checkorder_fee1'] + $data_sensitive['wrapper_fee1'] + 8.00),2);
                
                $this->data['lasstep'] = $this->url->Link('waybill/transport');
               
                $this->template = 'cnstorm/template/waybill/transport_sensitive_service.tpl';
               
           }else{
                 //echo 2;
               $data = $this->getfee_details($order_id_combination,$did,$areaid);
                
               $this->data['servicefee'] =  $data;
               
               $this->data['freight'] = $data['freight'];
               
               $this->data['estimate_total'] = round(($data['freight'] + $data['unpack_fee1'] + $data['checkorder_fee1'] + $data['wrapper_fee1'] + 8.00),2);
              
               $this->data['lasstep'] = $this->url->Link('waybill/transport');
            
               $this->template = 'cnstorm/template/waybill/transport_service.tpl';
           } 
            
           $this->children = array(
                'common/header_cart',
                'common/footer',
            );
            
           $this->response->setOutput($this->render());
           
        }
        
    }
    
    protected function get_sensitive_order($order_id_combination) {
        
        $order_id_sensitive = array();
        
        $this->load->model('waybill/transport');
                
        $order_id_array = explode(',',$order_id_combination);
        
        foreach($order_id_array as $order_id) {
		
			$sensitive = $this->model_waybill_transport->getsensitive($order_id);
			
			foreach($sensitive as $v){
					
						if(in_array(2,$v)) {
						
							$order_id_sensitive[] = $order_id;
							
							break;
						}
						
			}
        }
        return $order_id_sensitive;
    }
    
    
    protected function getfee_details($order_id_combination,$did,$areaid){

        $this->load->model('waybill/transport');
        
        $order_id_array = explode(',',$order_id_combination);
        
        $total_weight = $this->model_waybill_transport->gettotalweight($order_id_array);
                
        $data = array(
            'did' => $did,
            'areaid' => $areaid
        );
        
        $delivery_info = $this->model_waybill_transport->getdeliverybyid($data);
        
        //var_dump($delivery_info);
        
        $freight = 0.00;
        
        if ($total_weight <= $delivery_info['first_weight']) {
            
                  $freight = (float)$delivery_info['first_fee'];
            
        } else if($total_weight > $delivery_info['first_weight'] && $total_weight <= 30000) {
            
                 $first_fee = $delivery_info['first_fee'];
                 
                 $continue_fee = $delivery_info['continue_fee']*ceil(($total_weight - $delivery_info['first_weight'])/$delivery_info['continue_weight'] );
                 
                 $freight = (float)$first_fee + (float)$continue_fee;

        } else {
               
               $first_fee = $delivery_info['first_fee'];
               
               $continue_fee = $delivery_info['continue_fee']*ceil(($total_weight - $delivery_info['first_weight'])/$delivery_info['continue_weight'] );
               
               $subcontracting_fee =  $delivery_info['first_fee'] - $delivery_info['continue_fee'];
               
               $freight = (float)$first_fee +  (float)$continue_fee +  (float)$subcontracting_fee;
       }
       
       $this->load->model('account/customer');
      
       //获取订单总费用
       $total_fee = $this->model_waybill_transport->getTotalByoid($order_id_combination);
      
       //个人版or商户版
       $business = $this->model_account_customer->getBusiness();
       
       if($business) {
           $data = array(
                'freight'   => round($freight,2),
                //'unpack_fee1' => round(($freight+$total_fee)*0.012,2),
                'unpack_fee1' => 0,
                'unpack_fee2' => round(($freight+$total_fee)*0.025,2),
                'unpack_fee3' => round(($freight+$total_fee)*0.032,2),
                //'checkorder_fee1' => round(($freight+$total_fee)*0.018,2),
                'checkorder_fee1' => 0,
                'checkorder_fee2' => round(($freight+$total_fee)*0.029,2),
                'checkorder_fee3' => round(($freight+$total_fee)*0.038,2),
                'wrapper_fee1' => round(($freight+$total_fee)*0.008,2),
                'wrapper_fee2' => round(($freight+$total_fee)*0.018,2)
           );  
       }else{
           $data = array(
                'freight'   => round($freight,2),
                //'unpack_fee1' => round(($freight+$total_fee)*0.01,2),
                'unpack_fee1' => 0,
                'unpack_fee2' => round(($freight+$total_fee)*0.02,2),
                'unpack_fee3' => round(($freight+$total_fee)*0.03,2),
                //'checkorder_fee1' => round(($freight+$total_fee)*0.018,2),
                'checkorder_fee1' => 0,
                'checkorder_fee2' => round(($freight+$total_fee)*0.029,2),
                'checkorder_fee3' => round(($freight+$total_fee)*0.038,2),
                'wrapper_fee1' => round(($freight+$total_fee)*0.015,2),
                'wrapper_fee2' => round(($freight+$total_fee)*0.025,2)
           );  
        
       }
     
       return $data;
               
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