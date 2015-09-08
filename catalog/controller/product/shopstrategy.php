<?php  
class ControllerProductShopstrategy extends Controller { 
    //請注意ControllerCompanyMain Company是文件夹名，Main是文件名
		public function index() {
		error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );
		
			$this->load->model('catalog/product');
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
			$num=5;
			$limit=($page-1)*$num.','.$num;
			
			$rows=$this->model_catalog_product->getShopstrategy($limit);
			$total=$this->model_catalog_product->getShopstrategys();
			$this->data['rows']=$rows;

			$pagination = new Pagination ();
			$pagination->total = $total;
			$pagination->page = $page;
			$pagination->limit = $num;
			$pagination->text = $this->language->get ( 'text_pagination' );
			$pagination->url = $this->url->link ( 'product/shopstrategy',  '&page={page}' );
		
			$this->data ['pagination'] = $pagination->render ();
		
		
		    //判断用户是否登陆
        if ($this->customer->isLogged()) {
            
          $this->data['logged'] = 1;
        } else {
            
          $this->data['logged'] = 0;
        }
			$this->load->model ( 'order/order' );
      //日历
		if (isset ( $this->session->data ['customer_id'] )) {
			$this->data ['customer_id'] = $this->session->data ['customer_id'];
			
			$signFlag = $this->model_order_order->getSignFlag ( $this->session->data ['customer_id'] );
			if ($signFlag ['qiandao'] == date ( 'Y-m-d', time () ))
				$this->data ['signFlag'] = 1;
			else
				$this->data ['signFlag'] = 0;
			$customer = $this->customer->getFirstname ();
			$product = $this->model_order_order->monthQiandao ( $this->data ['customer_id'] );
			$count = 0;
			if (is_array ( $product ) && !empty($product)) {
				foreach ( $product as $v ) {
					$v ['addtime'] = date ( 'Y-m-d', $v ['addtime'] );
					$v = $v ['addtime'];
					$temp [] = $v;
				}
				$temp = array_unique ( $temp );
				foreach ( $temp as $k => $v ) {
				    $ex1 = explode("-",$v);
					$ex = $ex1[1];
					if ($ex == date ( 'm', time () )) {
						$count ++;
					}
				}
			}
			$this->data ['count'] = $count;
		} else {
			$this->data ['session'] = 1;
			$customer = "";
			$this->data ['signFlag'] = 0;
		}
		$this->data ['customer_name'] = $customer;
		
		$this->data ['filesrc'] = $this->url->link ( 'social/upfile' );
		$this->data['text_answer']='我要答题';
		
		
		//以下代码定义模版文件路径
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/shop_strategy.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/shop_strategy.tpl';
			} else {
				$this->template = 'default/template/product/shop_strategy.tpl';
			}
		//以下代码定义头尾文件路径
			$this->children = array(
				'common/header_transport',
				'common/footer'
			);

			$this->response->setOutput($this->render());
		}
		
    }
?>