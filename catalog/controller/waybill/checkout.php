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
 
  
class Controllerwaybillcheckout extends Controller {

    public function index() {
        
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('order/order_myhome', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $this->load->model('waybill/transport');
        
        //获取用户id
        $customer_id = $this->customer->getId();
        
        //获取用户名
        $firstname = $this->customer->getFirstName();
        
        //获取用户邮箱
        $email = $this->customer->getEmail();
        
        //获取用户积分
        $score = $this->customer->getScore();
        
        //获取用户会员等级
        $utype = $this->customer->getUtype();
        
        //获取收货地址id
        if(isset($this->request->post['address_id']) && $this->request->post['address_id']) {
            
            $address_id = $this->request->post['address_id'];
            
            $address_info = $this->model_waybill_transport->getaddressbyaid($address_id);
            
			//获取用户真实姓名
            $lastname = $address_info['lastname'];
			
            //获取国家名称
            $country = $this->model_waybill_transport->getcountrybycid($address_info['country_id']);
            
            //获取城市名称
            if($address_info['zone_id']) {
                $city = $this->model_waybill_transport->getcitybyzid($address_info['zone_id']);
            }else{
                $city = '';
            }
            
        } else {
            $address_id = 0;
        }
        
        //是否精简包装
        if(isset($this->request->post['pak'])) {
            $pak = $this->request->post['pak'];
        } 
        
        //计算订单商品重量
        if(isset($this->request->post['order_id_combination']) && $this->request->post['order_id_combination']) {
            $order_id_combination = $this->request->post['order_id_combination'];
        }else{
	        $order_id_combination = '';
	    }
        
        //获取运输方式信息
        
        if(isset($this->request->post['did']) && $this->request->post['did']) {
            $did = $this->request->post['did'];
        }else{
            $did = 0;
        }
        
        if(isset($this->request->post['areaid']) && $this->request->post['areaid']) {
            $areaid = $this->request->post['areaid'];
        }else{
            $areaid = 0;
	    }
        
        
        //打包策略
        if(isset($this->request->post['unpack'])) {
            $unpack = $this->request->post['unpack'];
        }else{
    	    $unpack = 0;
    	}
        
        //订单处理
        if(isset($this->request->post['checkorder'])) {
            $checkorder = $this->request->post['checkorder'];
        }else{
    	    $checkorder = 0;
    	}

        //打赏
        if(isset($this->request->post['donation'])) {
            $donation = $this->request->post['donation'];
        }else{
            $donation = 0.00;
        }
        
        //增值服务  
        
        //大包裹方案
        if(isset($this->request->post['valueadded_bag'])) {
            $valueadded_bag = $this->request->post['valueadded_bag'];
        } else {
            $valueadded_bag = 0;
        }
        
        //给订单拍照
        if(isset($this->request->post['valueadded_photo'])) {
            $valueadded_photo = $this->request->post['valueadded_photo'];
        } else {
            $valueadded_photo = 0;
        }
        
        
        //包装耗材
        if(isset($this->request->post['wrapper']) && $this->request->post['wrapper']) {
            $wrapper = $this->request->post['wrapper'];
        }else{
    	    $wrapper = 0;
    	}
        
       $data_fee = $this->getfee_details($order_id_combination,$did,$areaid); 
        
       //打包策略费用
       if(0 ==  $unpack) {
            $dabaofee = 0.00;
       } else if(1 == $unpack) {
            $dabaofee = $data_fee['unpack_fee1'];
       } else if(2 == $unpack) {
            $dabaofee = $data_fee['unpack_fee2'];
       } else if(3 == $unpack) {
            $dabaofee = $data_fee['unpack_fee3'];
       }
   
       //订单处理费用
       if(0 ==  $checkorder) {
            $checkorderfee = 0.00;
       } else if(1 == $checkorder) {
            $checkorderfee = $data_fee['checkorder_fee1'];
       } else if(2 == $checkorder) {
            $checkorderfee = $data_fee['checkorder_fee2'];
       } else if(3 == $checkorder) {
            $checkorderfee = $data_fee['checkorder_fee3'];
       }
       
        //包装耗材
       if(1 == $wrapper) {
            $wrapperfee = $data_fee['wrapper_fee1'];
       } else if(2 == $wrapper) {
            $wrapperfee = $data_fee['wrapper_fee2'];
       }else{
            $wrapperfee = 0;
       }
           
       
       //增值服务费用
       $zengzhi = '';
       
       if(0 == $valueadded_bag) {
            $valueadded_bagfee = 0.00;
       } else if(1 == $valueadded_bag) {
            $valueadded_bagfee = 1.50;
            $zengzhi = '1';
       }
       
       if(0 == $valueadded_photo) {
            $valueadded_photofee = 0.00;
       } else if(1 == $valueadded_photo) {
            $valueadded_photofee = 3.50;
            if($zengzhi){
                $zengzhi = $zengzhi.',2';
            } else {
                $zengzhi = '2';
            }
       }
       
       $zengzhifee = $valueadded_photofee + $valueadded_bagfee;
       
       $serverfee = $dabaofee + $checkorderfee + $zengzhifee;
       
       $oldtotalfee = round(($data_fee['freight'] + $serverfee + $wrapperfee + 8.00),2);
    
       if(1 == $utype) {
          $totalfee = round($oldtotalfee*0.99,2) + $donation;
    	}else if(2 == $utype) {
          $totalfee = round($oldtotalfee*0.98,2) + $donation;
    	}else if(3 == $utype) {
          $totalfee = round($oldtotalfee*0.97,2) + $donation;	
    	}else if(4 == $utype) {
          $totalfee = round($oldtotalfee*0.96,2) + $donation;	
    	}else if(5 == $utype) {
          $totalfee = round($oldtotalfee*0.95,2) + $donation;	
    	}else if(0 == $utype){
          $totalfee = $oldtotalfee + $donation;		
    	}
        
        //插入待付款订单 0 未付款 
        $state = 0;
       
        if (array_key_exists('old_sid', $this->session->data)) {
            $this->load->model('order/sendorder');
            $sendorder = $this->model_order_sendorder->getSendorderById($this->session->data['old_sid']);
        }

        if (isset($sendorder)) {
            $sendorder_id = $this->session->data['old_sid'];
        } else {
            if($did && $address_id) {
               //组装运单表sendorder插入数据
               $data = array(
                        'uid'   => $customer_id,
                        'uname' => $firstname,
                        'consignee' => $lastname,
                        'email' => $email,
                        'oids'  => $order_id_combination,
                        'freight' => $data_fee['freight'],
                        'serverfee' =>  $serverfee,
                        'wrapperfee' => $wrapperfee,
                        'customsfee' => 8.00,
                        'totalfee' => $totalfee,
                        'oldtotalfee' => $oldtotalfee,
                        'country' => $country,
                        'city' => $city,
                        'zip' => $address_info['postcode'],
                        'tel' => $address_info['telephone'],
                        'address' => $address_info['address_details'],
                        'did' => $did,
                        'deliveryname' => $data_fee['deliveryname'],
                        'countweight' => $data_fee['countweight'],
                        'donation' => $donation,
                        'pak_free' => $pak,
                        'dabao' => $unpack,
                        'dingdan' => $checkorder,
                        'zengzhi' => $zengzhi,
                        'baozhuang' => $wrapper,
                        'state' => $state,
                        'dabaofee' => $dabaofee,
                        'dingdanfee' => $checkorderfee,
                        'zengzhifee' => $zengzhifee,
                     
                    );
                    
                $sendorder_id  = $this->model_waybill_transport->addsendorder($data);
        
                $this->model_account_customer->add_shippingnumber();
        
                $this->sendemail($sendorder_id,$firstname,$email);
            }
            
        }
        
        if(isset($sendorder_id) && $sendorder_id) {
            
            $this->session->data['old_sid'] = $sendorder_id;
            
            $this->data['sendorder_id'] = $sendorder_id;
            
            $this->data['freight'] = $data_fee['freight'];
            
            $this->data['customsfee'] = 8.00;
            
            $this->data['wrapperfee'] = $wrapperfee;
            
            $this->data['serverfee'] = $serverfee;
            
            $this->data['totalfee'] = $totalfee;
            
            $this->data['oldtotalfee'] = $oldtotalfee;
            
            $this->data['unpack'] = $unpack;
            
            $this->data['checkorder'] = $checkorder;
            
            $this->data['valueadded_bag'] = $valueadded_bag;
            
            $this->data['valueadded_photo'] = $valueadded_photo;
            
            $this->data['wrapper'] = $wrapper;
            
            $this->data['unpackfee'] = $dabaofee;
            
            $this->data['checkorderfee'] = $checkorderfee;
            

            //获取所有可用优惠卷
            $this->load->model('account/coupon');
            
            //所有优惠卷的获取
            $coupon_info = $this->model_account_coupon->getCouponsByid();
            
            foreach($coupon_info as $coupon){
          
    	        $enddate = date("Y-m-d",$coupon['endtime']);
    	       
    	        $today  = date("Y-m-d",time());
    	        
    	        if($today > $enddate && $coupon['state'] != 3)
    	        {
    	            $this->model_account_coupon->updateCoupon($coupon['cid'],4);
    	        }
            }
            
            //优惠卷总数
            $coupon_info = $this->model_account_coupon->getCouponsByState();
                    
            $this->data['coupon_total'] = count($coupon_info);
            $this->data['coupon_info']  = $coupon_info;
            //end
            
            //加载积分
            $this->data['score'] = $score;
           
            $this->template = 'cnstorm/template/waybill/checkout.tpl';
    
            $this->children = array(
                'common/header',
                'common/footer',
            );
    
            $this->response->setOutput($this->render());
            
        }else{
            //我的仓库
            $this->data['order_myhome'] = HTTP_SERVER.'order-order-order_myhome.html'; 
            
            $this->template = 'cnstorm/template/waybill/recheckout.tpl';
    
            $this->children = array(
                'common/header',
                'common/footer',
            );
    
            $this->response->setOutput($this->render());
            
        }
             
    }
    
    
    public function mixsendorder() {
        
        //var_dump($this->request->post);
        
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('order/order_myhome', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $this->load->model('waybill/transport');
        
        //获取用户id
        $customer_id = $this->customer->getId();
        
        //获取用户名
        $firstname = $this->customer->getFirstName();
        
        //获取用户邮箱
        $email = $this->customer->getEmail();
        
        //获取用户积分
        $score = $this->customer->getScore();
        
        //获取用户会员等级
        $utype = $this->customer->getUtype();
        
        //获取收货地址id
        if(isset($this->request->post['address_id']) && $this->request->post['address_id']) {
            
            $address_id = $this->request->post['address_id'];
            
            $address_info = $this->model_waybill_transport->getaddressbyaid($address_id);
            
			//获取用户真实姓名
            $lastname = $address_info['lastname'];
			
            //获取国家名称
            $country = $this->model_waybill_transport->getcountrybycid($address_info['country_id']);
            
            //获取城市名称
            if($address_info['zone_id']) {
                $city = $this->model_waybill_transport->getcitybyzid($address_info['zone_id']);
            }else{
                $city = '';
            }
            
        } else {
            
            $address_id = 0;
            
        }
        
        //是否精简包装
        if(isset($this->request->post['pak'])) {
            $pak = $this->request->post['pak'];
        } 
        
        //获取敏感包裹和非敏感包裹订单号
        if(isset($this->request->post['new_order_id_combination']) && $this->request->post['new_order_id_combination']) {
            $new_order_id_combination = $this->request->post['new_order_id_combination'];
        }else{
	        $new_order_id_combination = '';
	    }
        
        if(isset($this->request->post['new_order_id_sensitive']) && $this->request->post['new_order_id_sensitive']) {
            $new_order_id_sensitive = $this->request->post['new_order_id_sensitive'];
        }else{
	        $new_order_id_sensitive = '';
	    }
        
        //获取敏感包裹运输方式信息
        if(isset($this->request->post['did']) && $this->request->post['did']) {
            $did = $this->request->post['did'];
        }else{
            $did = 0;
        }
        
        //获取非敏感包裹运输方式
        if(isset($this->request->post['did_sensitive']) && $this->request->post['did_sensitive']) {
            $did_sensitive = $this->request->post['did_sensitive'];
        }else{
            $did_sensitive = 0;
        }
        
        //获取区域id
        if(isset($this->request->post['areaid']) && $this->request->post['areaid']) {
            $areaid = $this->request->post['areaid'];
        }else{
            $areaid = 0;
	    }
        
        //打包策略
        if(isset($this->request->post['unpack_sensitive'])) {
            $unpack_sensitive = $this->request->post['unpack_sensitive'];
        }else{
    	    $unpack_sensitive = 0;
    	}
        
        
        if(isset($this->request->post['unpack'])) {
            $unpack = $this->request->post['unpack'];
        }else{
    	    $unpack = 0;
    	}
        
        //订单处理
        if(isset($this->request->post['checkorder_sensitive'])) {
            $checkorder_sensitive = $this->request->post['checkorder_sensitive'];
        }else{
    	    $checkorder_sensitive = 0;
    	}
        
        
        if(isset($this->request->post['checkorder'])) {
            $checkorder = $this->request->post['checkorder'];
        }else{
    	    $checkorder = 0;
    	}
        
        //大包裹方案
        if(isset($this->request->post['valueadded_bag_sensitive'])) {
            $valueadded_bag_sensitive = $this->request->post['valueadded_bag_sensitive'];
        } else {
            $valueadded_bag_sensitive = 0;
        }
        
        if(isset($this->request->post['valueadded_bag'])) {
            $valueadded_bag = $this->request->post['valueadded_bag'];
        } else {
            $valueadded_bag = 0;
        }
        
        //给订单拍照
        if(isset($this->request->post['valueadded_photo_sensitive'])) {
            $valueadded_photo_sensitive = $this->request->post['valueadded_photo_sensitive'];
        } else {
            $valueadded_photo_sensitive = 0;
        }
        
        if(isset($this->request->post['valueadded_photo'])) {
            $valueadded_photo = $this->request->post['valueadded_photo'];
        } else {
            $valueadded_photo = 0;
        }
        
        
        //包装耗材
        if(isset($this->request->post['wrapper_sensitive']) && $this->request->post['wrapper_sensitive']) {
            $wrapper_sensitive = $this->request->post['wrapper_sensitive'];
        }else{
    	    $wrapper_sensitive = 0;
    	}
        
        if(isset($this->request->post['wrapper']) && $this->request->post['wrapper']) {
            $wrapper = $this->request->post['wrapper'];
        }else{
    	    $wrapper = 0;
    	}
        
        //打赏
        if(isset($this->request->post['donation'])) {
            $donation = $this->request->post['donation'];
        }else{
            $donation = 0.00;
        }

       $data_fee = $this->getfee_details($new_order_id_sensitive,$did,$areaid); 
       
       $data_fee_normal =  $this->getfee_details($new_order_id_combination,$did_sensitive,$areaid);
        
       //打包策略费用
       if(0 ==  $unpack) {
            $dabaofee = 0.00;
       } else if(1 == $unpack) {
            $dabaofee = $data_fee['unpack_fee1'];
       } else if(2 == $unpack) {
            $dabaofee = $data_fee['unpack_fee2'];
       } else if(3 == $unpack) {
            $dabaofee = $data_fee['unpack_fee3'];
       }
       
       if(0 ==  $unpack_sensitive) {
            $dabaofee_normal = 0.00;
       } else if(1 == $unpack_sensitive) {
            $dabaofee_normal = $data_fee_normal['unpack_fee1'];
       } else if(2 == $unpack_sensitive) {
            $dabaofee_normal = $data_fee_normal['unpack_fee2'];
       } else if(3 == $unpack_sensitive) {
            $dabaofee_normal = $data_fee_normal['unpack_fee3'];
       }
       
   
       //订单处理费用
       if(0 ==  $checkorder) {
            $checkorderfee = 0.00;
       } else if(1 == $checkorder) {
            $checkorderfee = $data_fee['checkorder_fee1'];
       } else if(2 == $checkorder) {
            $checkorderfee = $data_fee['checkorder_fee2'];
       } else if(3 == $checkorder) {
            $checkorderfee = $data_fee['checkorder_fee3'];
       }
       
       if(0 ==  $checkorder_sensitive) {
            $checkorderfee_normal = 0.00;
       } else if(1 == $checkorder_sensitive) {
            $checkorderfee_normal = $data_fee_normal['checkorder_fee1'];
       } else if(2 == $checkorder_sensitive) {
            $checkorderfee_normal = $data_fee_normal['checkorder_fee2'];
       } else if(3 == $checkorder_sensitive) {
            $checkorderfee_normal = $data_fee_normal['checkorder_fee3'];
       }
       
        //包装耗材
       if(1 == $wrapper) {
            $wrapperfee = $data_fee['wrapper_fee1'];
       } else if(2 == $wrapper) {
            $wrapperfee = $data_fee['wrapper_fee2'];
       }else{
            $wrapperfee = 0;
       }
           
       if(1 == $wrapper_sensitive) {
            $wrapperfee_normal = $data_fee_normal['wrapper_fee1'];
       } else if(2 == $wrapper_sensitive) {
            $wrapperfee_normal = $data_fee_normal['wrapper_fee2'];
       }else{
            $wrapperfee_normal = 0;
       }
       
       //增值服务费用
       $zengzhi = '';
       $zengzhi_normal = '';
       
       if(0 == $valueadded_bag) {
            $valueadded_bagfee = 0.00;
       } else if(1 == $valueadded_bag) {
            $valueadded_bagfee = 1.50;
            $zengzhi = '1';
       }
       
       if(0 == $valueadded_photo) {
            $valueadded_photofee = 0.00;
       } else if(1 == $valueadded_photo) {
            $valueadded_photofee = 3.50;
            if($zengzhi){
                $zengzhi = $zengzhi.',2';
            } else {
                $zengzhi = '2';
            }
       }
       
       if(0 == $valueadded_bag_sensitive) {
            $valueadded_bagfee_normal = 0.00;
       } else if(1 == $valueadded_bag_sensitive) {
            $valueadded_bagfee_normal = 1.50;
            $zengzhi_normal = '1';
       }
       
       if(0 == $valueadded_photo_sensitive) {
            $valueadded_photofee_normal = 0.00;
       } else if(1 == $valueadded_photo_sensitive) {
            $valueadded_photofee_normal = 3.50;
            if($zengzhi_normal){
                $zengzhi_normal = $zengzhi_normal.',2';
            } else {
                $zengzhi_normal = '2';
            }
       }
       
       $zengzhifee = $valueadded_photofee + $valueadded_bagfee;
       
       $zengzhifee_normal = $valueadded_photofee_normal + $valueadded_bagfee_normal;
       
       $serverfee = $dabaofee + $checkorderfee + $zengzhifee;
       
       $serverfee_normal = $dabaofee_normal + $checkorderfee_normal + $zengzhifee_normal;
       
       $oldtotalfee = round(($data_fee['freight'] + $serverfee + $wrapperfee + 8.00),2);
       
       $oldtotalfee_normal = round(($data_fee_normal['freight'] + $serverfee_normal + $wrapperfee_normal + 8.00),2);
    
       if(1 == $utype) {
          $totalfee = round($oldtotalfee*0.99,2);
          $totalfee_normal = round($oldtotalfee_normal*0.99,2);
    	}else if(2 == $utype) {
          $totalfee = round($oldtotalfee*0.98,2);
          $totalfee_normal = round($oldtotalfee_normal*0.98,2);
    	}else if(3 == $utype) {
          $totalfee = round($oldtotalfee*0.97,2);	
          $totalfee_normal = round($oldtotalfee_normal*0.97,2);
    	}else if(4 == $utype) {
          $totalfee = round($oldtotalfee*0.96,2);	
          $totalfee_normal = round($oldtotalfee_normal*0.96,2);
    	}else if(5 == $utype) {
          $totalfee = round($oldtotalfee*0.95,2);	
          $totalfee_normal = round($oldtotalfee_normal*0.95,2);
    	}else if(0 == $utype){
          $totalfee = $oldtotalfee;		
          $totalfee_normal = $oldtotalfee_normal;
    	}
        
        //插入待付款订单 0 未付款 
        $state = 0;
        
        if (array_key_exists('old_sid', $this->session->data)) {
            $this->load->model('order/sendorder');
            $sendorder = $this->model_order_sendorder->getSendorderById($this->session->data['old_sid']);
        }

        if (isset($sendorder)) {
            $sendorder_id = $this->session->data['old_sid'];
        } else {
            if($did && $did_sensitive && $address_id) {
                
                unset($this->session->data['sendorder_id_combination']);
                
               //组装运单表sendorder插入数据               
               $data_sensitive = array(
                        'uid'   => $customer_id,
                        'uname' => $firstname,
                        'consignee' => $lastname,
                        'email' => $email,
                        'oids'  => $new_order_id_sensitive,
                        'freight' => $data_fee['freight'],
                        'serverfee' =>  $serverfee,
                        'wrapperfee' => $wrapperfee,
                        'customsfee' => 8.00,
                        'totalfee' => $totalfee,
                        'oldtotalfee' => $oldtotalfee,
                        'country' => $country,
                        'city' => $city,
                        'zip' => $address_info['postcode'],
                        'tel' => $address_info['telephone'],
                        'address' => $address_info['address_details'],
                        'did' => $did,
                        'donation' => $donation,
                        'deliveryname' => $data_fee['deliveryname'],
                        'countweight' => $data_fee['countweight'],
                        'pak_free' => $pak,
                        'dabao' => $unpack,
                        'dingdan' => $checkorder,
                        'zengzhi' => $zengzhi,
                        'baozhuang' => $wrapper,
                        'state' => $state,
                        'dabaofee' => $dabaofee,
                        'dingdanfee' => $checkorderfee,
                        'zengzhifee' => $zengzhifee,
						'donation'=>$donation
                    );
                    
                 $data_normal = array(
                        'uid'   => $customer_id,
                        'uname' => $firstname,
                        'consignee' => $lastname,
                        'email' => $email,
                        'oids'  => $new_order_id_combination,
                        'freight' => $data_fee_normal['freight'],
                        'serverfee' =>  $serverfee_normal,
                        'wrapperfee' => $wrapperfee_normal,
                        'customsfee' => 8.00,
                        'totalfee' => $totalfee_normal,
                        'oldtotalfee' => $oldtotalfee_normal,
                        'country' => $country,
                        'city' => $city,
                        'zip' => $address_info['postcode'],
                        'tel' => $address_info['telephone'],
                        'address' => $address_info['address_details'],
                        'did' => $did_sensitive,
                        'deliveryname' => $data_fee_normal['deliveryname'],
                        'countweight' => $data_fee_normal['countweight'],
                        'pak_free' => $pak,
                        'dabao' => $unpack_sensitive,
                        'dingdan' => $checkorder_sensitive,
                        'zengzhi' => $zengzhi_normal,
                        'baozhuang' => $wrapper_sensitive,
                        'state' => $state,
                        'dabaofee' => $dabaofee_normal,
                        'dingdanfee' => $checkorderfee_normal,
                        'zengzhifee' => $zengzhifee_normal,
                     
                    );   
                
                $data_sendinfo = array($data_sensitive,$data_normal);
                
                $sendorder_id_combination = array();
                
                foreach($data_sendinfo as $data) {
                    
                    $sendorder_id = $this->model_waybill_transport->addsendorder($data);
        
                    $this->model_account_customer->add_shippingnumber();
                    
                    $sendorder_id_combination[] = $sendorder_id;
                    
                }    
                
                $sendorder_id = $sendorder_id_combination[0];
                
                $sendorder_id_normal = $sendorder_id_combination[1];
                
                $sendorder_id_combination = implode(',',$sendorder_id_combination);
                
                $this->session->data['sendorder_id_combination'] =  $sendorder_id_combination;
                
                $this->sendemail($sendorder_id_combination,$firstname,$email);
            }
            
        }


        if(isset($sendorder_id) && $sendorder_id ) {
            
            $this->data['waybillbatch_pay'] = $this->session->data['sendorder_id_combination'];
            
            $this->session->data['old_sid'] = $sendorder_id;
            
            $this->data['sendorder_id'] = $sendorder_id;
            
            $this->data['freight'] = $data_fee['freight'];
            
            $this->data['freight_normal'] = $data_fee_normal['freight'];
            
            $this->data['customsfee'] = 8.00;
            
            $this->data['customsfee_normal'] = 8.00;
            
            $this->data['wrapperfee'] = $wrapperfee;
            
            $this->data['wrapperfee_normal'] = $wrapperfee_normal;
            
            $this->data['serverfee'] = $serverfee;
            
            $this->data['serverfee_normal'] = $serverfee_normal;
            
            $this->data['totalfee'] = $totalfee;
            
            $this->data['totalfee_normal'] = $totalfee_normal;
            
            $this->data['oldtotalfee'] = $oldtotalfee;
            
            $this->data['oldtotalfee_normal'] = $oldtotalfee_normal;
            
            $this->data['unpack'] = $unpack;
            
            $this->data['unpack_normal'] = $unpack_sensitive;
            
            $this->data['checkorder'] = $checkorder;
            
            $this->data['checkorder_normal'] = $checkorder_sensitive;
            
            $this->data['valueadded_bag'] = $valueadded_bag;
            
            $this->data['valueadded_bag_normal'] = $valueadded_bag_sensitive;
            
            $this->data['valueadded_photo'] = $valueadded_photo;
            
            $this->data['valueadded_photo_normal'] = $valueadded_photo_sensitive;
            
            $this->data['wrapper'] = $wrapper;
            
            $this->data['wrapper_normal'] = $wrapper_sensitive;
            
            $this->data['unpackfee'] = $dabaofee;
            
            $this->data['unpackfee_normal'] = $dabaofee_normal;
            
            $this->data['checkorderfee'] = $checkorderfee;
            
            $this->data['checkorderfee_normal'] = $checkorderfee_normal;
            
            //获取所有可用优惠卷
            $this->load->model('account/coupon');
            
            //所有优惠卷的获取
            $coupon_info = $this->model_account_coupon->getCouponsByid();
            
            foreach($coupon_info as $coupon){
          
    	        $enddate = date("Y-m-d",$coupon['endtime']);
    	       
    	        $today  = date("Y-m-d",time());
    	        
    	        if($today > $enddate && $coupon['state'] != 3)
    	        {
    	            $this->model_account_coupon->updateCoupon($coupon['cid'],4);
    	        }
            }
            
            //优惠卷总数
            $coupon_info = $this->model_account_coupon->getCouponsByState();
                    
            $this->data['coupon_total'] = count($coupon_info);
            $this->data['coupon_info']  = $coupon_info;
            //end
            
            //加载积分
            $this->data['score'] = $score;
           
            $this->template = 'cnstorm/template/waybill/checkout.tpl';
    
            $this->children = array(
                'common/header',
                'common/footer',
            );
    
            $this->response->setOutput($this->render());
            
        }else{
            //我的仓库
            $this->data['order_myhome'] = HTTP_SERVER.'order-order-order_myhome.html'; 
            
            $this->template = 'cnstorm/template/waybill/recheckout.tpl';
    
            $this->children = array(
                'common/header',
                'common/footer',
            );
    
            $this->response->setOutput($this->render());
            
        }
        
        $this->template = 'cnstorm/template/waybill/checkout-sensitive.tpl';
    
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
        
    }
    
    
    protected function sendemail($sendorder_id,$firstname,$email) {
        
        //发送提交运单确认邮件
        $subject = '您的CNstorm运单' . $sendorder_id . '已经提交，若运单状态为未付款请尽快付款！';

        $message = "<div style='width:600px; margin:0 auto;'>
				<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/image/data/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
				<div style='clear:both; height:20px; width:100%'></div>
				<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
				<div style='width:560px; margin:0 auto; font-size:14px'>
				<p >亲爱的&nbsp;$firstname, </p>
				<p > </p>
				<p ><strong>您的订单已提交运送！</strong> </p>
				<p >
				<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>感谢您选择并使用 CNstorm 为您服务！我们已经收到了您的运单号： $sendorder_id 提交运送申请，接下来我们将开始打包您的包裹
				 并将在 2 个工作日内(除周日)将您的包裹交付指定的快递公司.在我们发送您的包裹后，您可访问“会员中心” – “<a href='http://www.acgstorm.com/index.php?route=order/order/order_guoji' >运单</a>”查询您的物流跟踪信
				 息。 
				 如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或回复本邮件与我们取得联系。
				 我们非常荣幸能为您服务，期待您的下次访问! </br>
	                         
	                        </div>
				</p>
				<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以： </p>
				<p > </p>
				<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
				<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >代寄</a>） </p>
				<p >3、&nbsp;亲人朋友生日，重大节日，纪念日...&nbsp;CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href='http://www.acgstorm.com/index.php?route=international/express' >国内送</a>)。 </p>
				<p >4、&nbsp;立刻勾选您要邮寄的商品提交运送(<a href='http://www.acgstorm.com/index.php?route=order/order/order_myhome' >查看订单并提交</a>) </p>
				<p > </p>
				<p >我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href='http://www.acgstorm.com/index.php?route=help/normalquestion' >点此查阅</a>。 </p>
				<p > </p>
				<p >如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或通过下方电子邮件与我们取得联系。 </p>
				<p > </p>
				<p >Email:&nbsp;support@cnstorm.com </p>
				<p > </p>
				<p >我们衷心感谢您选择并使用CNstorm为您服务！ </p>
				<p > </p>
				<p > </p>
				<p >CNstorm客户关怀部 </p>
				<p > </p>
				<p  style='text-align:center'>&#169;Copyright&nbsp;2013&nbsp;CNstorm&nbsp; </p>
				</div>
				</div>
				</div>";


        $data = array(
            'sendto' => $email,
            'receiver' => $firstname,
            'subject' => $subject,
            'msg' => $message,
        );

        $this->load->model('tool/sendmail');
        $this->model_tool_sendmail->send($data);
        
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
                'wrapper_fee2' => round(($freight+$total_fee)*0.018,2),
                'deliveryname' => $delivery_info['deliveryname'],
                'countweight' => $total_weight
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
                'wrapper_fee2' => round(($freight+$total_fee)*0.025,2),
                'deliveryname' => $delivery_info['deliveryname'],
                'countweight' => $total_weight
           );  
        
       }
       
       return $data;
               
    }
    
    //上一步
    public function laststep() {
        
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('order/order_myhome', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        

        if(isset($this->request->post['sid']) && $this->request->post['sid']) {
            
            $this->load->model('waybill/transport');
            $this->load->model('account/customer');
            
            $sid = $this->request->post['sid'];
            
            //删除存入的运单数据
            $this->model_waybill_transport->delsendorder($sid);
            
            
            $shipping_number = $this->model_account_customer->get_shippingnumber();
            
            if($shipping_number-1) {
                
                 $this->model_account_customer->del_shippingnumber();
                 
            }
                  
            $this->response->setOutput(1);
        }
        
    }


}

?>