<?php
/*
 * *****************************************************************************************
 * @description：对搜索值进行判断，如果是淘宝或者天猫的商品url地址,则跳转相应的商品详情页面 
 * @author： kennewei<wk@cnstorm.com> 
 * @date: 2014.5.28 
 * *****************************************************************************************
 */
class Controllerproductzzgsnatch extends Controller {
    
	private $error = array ();
    
    
    public function index() {
        if($this->customer->getId()){
			$this->redirect($this->url->link('order/snatch', '', 'SSL'));
		}
        $this->data['title'] = "我要自助购";
        
        $this->data['keywords'] = "我要自助购";
        
        $this->data['description'] = "我要自助购";
        
       	if (isset($this->request->get['search'])) {
       	    
		    $search = $this->request->get['search'];
        
    	}else{
    		$search = '';
    	}
	
		$this->data['customer_id']=$this->customer->getId();
        $this->data['search'] = $search;
        $this->data['url'] = $search;
    	if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch.tpl' )) {
    	   
			$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch.tpl';
		} else {
		  
			$this->template = 'default/template/product/zzg_snatch.tpl';
		}
		
		$this->children = array (
				'common/footer',
				'common/header_cart' 
		);
	
		$this->response->setOutput($this->render());
        
    }
	
    public function iteminfo() {  
        
        	error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );
        $this->load->model('order/order');
        
        $total_taobao = $this->model_order_order->get_selfproduct_total();

        $this->data['selfproduct_total'] = $total_taobao;
        
        $orders = $this->model_order_order->get_selfproduct();

        if ($orders) {
            $this->data['orders'] = $orders;

            foreach ($orders as $order) {
                $storename_array[$order['store_url']] = $order['store_name'];
                $storename_array = array_unique($storename_array);
            }

            $this->data['storenames'] = $storename_array;
        } else {
            $this->data['orders'] = '';
        }

        
		$this->language->load ( 'product/product' );
		
		$url = '';
		
		$result = array ();
		
		if (isset($this->request->get['search'])) {
			
			$url = $this->request->get['search'];
		}

		//插件抓取商品
		//add by fc
		$flag = false;
		if (isset ($this->request->post['url'])) {
			$url = $this->request->post['url'];
			$flag = true;
		}
		//end
        
        $search = urldecode($url);
        
		$search = htmlspecialchars_decode($url);
		
		$this->data ['searchcolor'] = '';
		$this->data ['searchsize'] = '';
		$this->data ['colorname'] = '';
		$this->data ['sizename'] = '';
		$this->data ['api'] = 0;
		

    	if (false !== strpos ( $search, 'taobao.com' ) || false !== strpos ( $search, 'tmall.com' ) || false != strpos($search, 'yao.95095')) {
    		include_once (DIR_SYSTEM . 'taobao.class.php');
    		
    	$url_info = parse_url($search);
            
			if($url_info['host']=='world.taobao.com'){
				
				$productId = substr(strstr($url_info['path'],".htm",true),6);
				$url='https://item.taobao.com/item.htm?id='.$productId;
			
				$url_info = parse_url($url);
			}
			
    		$url_info ['query'] = isset($url_info ['query'])?$url_info ['query']:'';
            
    		$param ['id'] = '';
            
            $url_info['query'] = str_replace('&amp;', '&' ,$url_info['query']);
            
    		parse_str($url_info['query'], $param);
            
    		if (!isset($param ['id'] )&& isset($param['tradeID']))
    			$param['id'] = $param['tradeID'];
    		if (!isset($param ['id']) && isset($param['meal_id']))
    			$param['id'] = $param['meal_id'];
                
    		$result = TAOBAO::getItemInfo($param);
			  $customer_id = $this->customer->getId();
			
    	
    		if ($result) {
    			$result = array_map ( 'strip_tags', $result );
    			$result = array_map ( 'trim', $result );
    		}
    		$this->load->model ( 'catalog/product' );
    		
    		$search_result = $result;
    		
    		if (isset($search_result ['goodsname'])) {
    		    
                $this->data['title'] = $search_result ['goodsname'];
                
                $this->data['keywords'] = $search_result ['goodsname'];
                
                $this->data['description'] = $search_result ['goodsname'];
    
    			
    			$this->data ['heading_title'] = $search_result ['goodsname'];
    			
    			$this->data ['points'] = '';
    			
    			$this->load->model ( 'tool/image' );
    			
    			if ($search_result ['goodsprice']) {
    				$this->data ['price'] = $search_result ['goodsprice'];
    			} else {
    				$this->data ['price'] = false;
    			}
    			
    			// add by weikun 商品详情页面获取商品的国内运费，商品来源，颜色分类，尺码分类，图片来源
    			// 商品地址
    			if ($search) {
    				$this->data ['search'] = $search;
    			} else {
    				$this->data ['search'] = '';
    			}
    			
    			// 商品主图
    			if ($search_result ['goodsimg']) {
    				$this->data ['goodsimg'] = $search_result ['goodsimg'];
    			} else {
    				$this->data ['goodsimg'] = '';
    			}
    			
    			// 商场名称
    			if ($search_result ['model']) {
    				$this->data ['model'] = $search_result ['model'];
    			} else {
    				$this->data ['model'] = '';
    			}
    			
    			// 店铺名称
    			if ($search_result ['storename']) {
    				$this->data ['storename'] = $search_result ['storename'];
    			} else {
    				$this->data ['storename'] = '';
    			}
    			
    			// 店铺地址
    			if ($search_result ['storeurl']) {
    				$this->data ['storeurl'] = $search_result ['storeurl'];
    			} else {
    				$this->data ['storeurl'] = '';
    			}
    			
    			// 卖家名称
    			if ($search_result ['goodsseller']) {
    				$this->data ['upc'] = $search_result ['goodsseller'];
    			} else {
    				$this->data ['upc'] = '';
    			}
    			
    			// 商品颜色
    			$ean_array = json_decode ( $search_result ['color_number'], true );
    			if (count ( $ean_array )) {
    				foreach ( $ean_array as $key => $value ) {
    					$ean [] = $value;
    				}
    				$this->data ['ean'] = $ean;
    			} else {
    				$this->data ['ean'] = '';
    			}
    			
    			// 商品尺寸
    			$jan_array = json_decode ( $search_result ['size_number'], true );
    			if (count ( $jan_array )) {
    				foreach ( $jan_array as $key => $value ) {
    					$jan [] = $value;
    				}
    				$this->data ['jan'] = $jan;
    			} else {
    				$this->data ['jan'] = '';
    			}
    			
    			// 国内运费
    			if ($search_result ['yunfei']) {
    				$this->data ['isbn'] = $search_result ['yunfei'];
    			} else {
    				$this->data ['isbn'] = 0.00;
    			}
    			
    			$this->data ['item_imgs'] = json_decode ( $search_result ['item_imgs'] );
    			$this->data ['size_number'] = json_decode ( $search_result ['size_number'], true );
    			$this->data ['color_number'] = json_decode ( $search_result ['color_number'], true );
    			
    			$this->session->data ['size_color_price'] = json_decode ( $search_result ['price'], true );
    			$this->session->data ['quantity'] = json_decode ( $result ['quantity'], true );
    			$this->session->data ['size_number'] = json_decode ( $search_result ['size_number'], true );
    			$this->session->data ['color_number'] = json_decode ( $search_result ['color_number'], true );
    			$this->session->data ['size'] = $search_result ['size'];
    			$this->session->data ['color'] = $search_result ['color'];
    			$this->session->data ['img_color'] = json_decode ( $search_result ['img_color'], true );
    			
    			$this->data ['minimum'] = 1;
    			$this->data ['num_iid'] = $search_result ['num_iid'];
    		}
    		
    		$this->data ['api'] = 1;
    		
    		if ($flag) {
    			$this->data['prifex'] = 'TB';
    			$this->data['search'] = isset($this->data['num_iid'])?'http://item.taobao.com/item.htm?id=' . $this->data['num_iid']:'';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = isset($this->data['jan'])?$this->data['jan']:'';
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = isset($this->data['ean'])?$this->data['ean']:'';
    			$this->data['promotion_in_item'] = $this->session->data['size_color_price'];
    			if ((isset($this->data['jan']) && is_array($this->data['jan'])) || isset($this->data['ean'])) {
    				$not_quantity = '';
    				foreach ($this->data['jan'] as $size) {
    					foreach ($this->data['ean'] as $color) {
    						if (!in_array($size . '_' . $color, array_keys($this->session->data['quantity']))) {
    							$not_quantity = $not_quantity . $size . $color . ',';
    						}
    					}
    				}
    				if ($not_quantity != '') {
    					// $not_quantity = substr($not_quantity, 0, strlen($not_quantity) - 1);
    					$this->data['not_quantity'] = explode(',', $not_quantity);
    				}
    			}
    			echo(json_encode($this->data));
    		} else {
    			// var_dump($this->data);
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    			$this->response->setOutput($this->render());
    		}
    	} else if (false !== strpos ( $search, '1688.com' )) {
    		$result = array ();
    		
    		$html = $this->gethtmlcontent ($search);
    		$html = iconv ( 'GBK', 'UTF-8', $html );
    		
    		// 商品编号
    		if (preg_match ( '#1688.com/offer/(.*).html#isU', $search, $matches )) {
    			
    			if (! empty ( $matches )) {
    				$result ['num_iid'] = $matches [1];
    			}
    		}
    		
    		// 商品名
    		if (preg_match ( '#d-title\">(.*)</h1>#isU', $html, $matches )) {
    			if (! empty ( $matches [1] ))
    				$date [0] = strip_tags ( $matches [1] );
    			;
    		}
    		// 图片地址
    		if (preg_match ( '#vertical-img\">(.*)<\/div>#isU', $html, $matches ) && preg_match ( '#<img[^>]*src=\"(.*)\"[^>]*>#isU', $matches [1], $src )) {
    			if (! empty ( $src [1] ))
    				$date [1] = $src [1];
    		}
    		// 商品价格
    		if ((preg_match ( '#price-original-sku\">(.*)<\/div>#isU', $html, $matches ) && preg_match_all ( '#value\">(.*)<\/span>#isU', $matches [1], $matches )) || preg_match ( '#price-length-[4-8]\">(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#\"n.{10}t\">(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#<span[^>]*class=\"price\">(.*)<\/span>#isU', $html, $matches )) {
    			if (is_array ( $matches [1] ))
    				$matches [1] = end ( $matches [1] );
    			if (! empty ( $matches [1] ))
    				if (is_numeric ( $matches [1] ))
    					$date [3] = $matches [1];
    		}
    		// 商品颜色
    		if ((preg_match ( '#list-leading\">(.*)<\/ul>#isU', $html, $matches ) && preg_match_all ( '#text text-single-line\">(.*)<\/span>#isU', $matches [1], $matches )) || (preg_match ( '#list-leading\">(.*)<\/ul>#isU', $html, $matches ) && preg_match_all ( '#<img[^>]*alt="(.*)"[^>]*>#isU', $matches [1], $matches )) || (preg_match_all ( '#unit-detail-spec-operator\"[\s]*data-unit-config=\'\{\"name\":\"(.*)\"\}\'#isU', $html , $matches )))
    			if (! empty ( $matches [1] ))
    				$date [4] = $matches [1];
    			
    			// 商品尺寸
    		if (((preg_match ( '#table-sku"[^>]*>(.*)<\/table>#isU', $html, $matches ) || preg_match ( '#full "[^>]*>(.*)<\/table>#isU', $html, $matches )) && preg_match_all ( '#<td[^>]*class=\"name\"[^>]*>(.*)<\/td>#isU', $matches [1], $matches )) || preg_match_all ( '#text text-single-line\">(.*)<\/span>#isU', $html, $matches ) || (preg_match_all ( '#tr[\s]*.*data-sku-config=\'\{\"skuName":\"(.*)\"#isU', $html , $matches ))) {
    			foreach ( $matches [1] as $v ) {
    				if (preg_match ( '#<img[^>]*alt=\"(.*)\"[^>]*>#isU', $v, $matches )) {
    					if (! empty ( $matches [1] ))
    						$date [5] [] = $matches [1];
    				} else {
    					$v = strip_tags ( $v );
    					if (! empty ( $v ))
    						$date [5] [] = $v;
    				}
    			}
    		}
    		// 商品运费
    		if (preg_match ( '#<\/span><em[^>]*class="value">(.*)<\/em>#isU', $html, $matches )) {
    			if (! empty ( $matches [1] ))
    				$date [6] = $matches [1];
    		}
    		
    		// 商铺名称
    		if (preg_match ( '#<a[^>]*class="has-tips"[^>]*href="(.*)"[^>]*><span class="info">(.*)<\/span><\/a>#isU', $html, $matches )) {
    			if (! empty ( $matches [1] )) {
    				$pos = strpos($matches[1], '.');
    				$str = substr($matches[1], 0 ,$pos);
    				//var_dump ( $str );
    				$date [8] = $str.'.1688.com';
    			}
    			if (! empty ( $matches [2] ))
    				$date [7] = $matches [2];
    		}
    		
    		if (isset($date)){
    			if (array_key_exists ( '0', $date ) && $date [0])
    				$result ['goodsname'] = $date [0];
    			
    			if (array_key_exists ( '1', $date ) && $date [1])
    				$result ['goodsimg'] = $date [1];
    			
    			if (array_key_exists ( '3', $date ) && $date [3])
    				$result ['goodsprice'] = $date [3];
    			
    			if (array_key_exists ( '4', $date ) && $date [4]) {
    				
    				$result ['ean'] = $date [4];
    			}
    			
    			if (array_key_exists ( '5', $date ) && $date [5]) {
    				
    				$result ['jan'] = $date [5];
    			}
    			
    			if (array_key_exists ( '6', $date ) && $date [6])
    				$result ['yunfei'] = $date ['6'];
    			
    			if (array_key_exists ( '7', $date ) && $date [7])
    				$result ['storename'] = $date ['7'];
    			
    			if (array_key_exists ( '8', $date ) && $date [8])
    				$result ['storeurl'] = $date ['8'];
    		}
    		
    		if ($search) {
    			$this->data ['search'] = $search;
    		} else {
    			$this->data ['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset ( $result ['num_iid'] ) && $result ['num_iid']) {
    			$this->data ['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data ['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result ['goodsname'] ) && $result ['goodsname']) {
    			$this->data ['heading_title'] = $result ['goodsname'];
    		} else {
    			$this->data ['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result ['goodsimg'] ) && $result ['goodsimg']) {
    			$this->data ['goodsimg'] = $result ['goodsimg'];
    		} else {
    			$this->data ['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result ['goodsprice'] )) {
    			$this->data ['price'] = $result ['goodsprice'];
    		} else {
    			$this->data ['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result ['ean'] ) && $result ['ean']) {
    			$this->data ['ean'] = $result ['ean'];
    		} else {
    			$this->data ['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result ['jan'] ) && $result ['jan']) {
    			$this->data ['jan'] = $result ['jan'];
    		} else {
    			$this->data ['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset ( $result ['storename'] ) && $result ['storename']) {
    			$this->data ['storename'] = $result ['storename'];
    		} else {
    			$this->data ['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset ( $result ['storeurl'] ) && $result ['storeurl']) {
    			$this->data ['storeurl'] = $result ['storeurl'];
    		} else {
    			$this->data ['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset ( $result ['yunfei'] )) {
    			$this->data ['isbn'] = $result ['yunfei'];
    		} else {
    			$this->data ['isbn'] = '';
    		}
    		
    		if ($flag) {
    			$this->data['prifex'] = 'AL';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    		
    			
    			$this->response->setOutput ( $this->render () );
    		}
    	} else if (false !== strpos ( $search, 'dangdang.com' )) {
    		
    		$result = array ();
    		
    		$html = $this->gethtmlcontent ( $search );
    		$html = mb_convert_encoding ( $html, 'UTF-8', 'gbk' );
    		
    		// 商品编号
    		if (preg_match ( '#dangdang.com/(.*).html#isU', $search, $matches )) {
    			// var_dump($matches);
    			if (! empty ( $matches )) {
    				$result ['num_iid'] = $matches [1];
    			}
    		}
    		
    		// 商品名称
    		if (preg_match ( '#<h1>(.*)<span#iU', $html, $matches )) {
    			if (! empty ( $matches )) {
    				$result ['goodsname'] = strip_tags ( $matches [1] );
    			}
    		}
    		
    		// 商品价格
    		if (preg_match ( '#<span id=[\"|\']promo_price[\"|\']>(.*)</span>#isU', $html, $matches )) {
    			// var_dump ( $matches );
    			if (! empty ( $matches )) {
    				$result ['goodsprice'] = $matches [1];
    				$result ['goodsprice'] = trim ( $result ['goodsprice'], '&yen;' );
    			}
    		} elseif (preg_match ( '#<span id=[\"|\']salePriceTag[\"|\']>(.*)</span>#isU', $html, $matches )) {
    			if (! empty ( $matches )) {
    				$result ['goodsprice'] = $matches [1];
    			}
    		}
    		
    		// 商品主图
    		if (preg_match ( '#wsrc=[\"|\'](.*)[\"|\']#isU', $html, $matches )) {
    			// var_dump($matches);
    			if (! empty ( $matches )) {
    				$result ['goodsimg'] = $matches [1];
    			}
    		}
    		
    		// 商品颜色
    		if (preg_match ( '#<ul class=[\"|\']color[\"|\']>(.*)</ul>#isU', $html, $matches )) {
    			
    			if (preg_match_all ( '#title=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['ean'] = $matches [1];
    				}
    			}
    		}
    		
    		// 商品尺寸规格
    		if (preg_match ( '#<ul class=[\"|\']size[\"|\']>(.*)</ul>#isU', $html, $matches )) {
    			
    			if (preg_match_all ( '#<a[^>]+>(.*)</a>#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['jan'] = $matches [1];
    					unset ( $result ['jan'] [array_search ( "尺码对照表", $result ['jan'] )] );
    				}
    			}
    		}
    		
    		// $result['yunfei'] = 0.00;
    		
    		$result ['storename'] = "当当网";
    		
    		$result ['storeurl'] = "http://www.dangdang.com/";
    		
    		if ($search) {
    			$this->data ['search'] = $search;
    		} else {
    			$this->data ['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset ( $result ['num_iid'] ) && $result ['num_iid']) {
    			$this->data ['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data ['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result ['goodsname'] ) && $result ['goodsname']) {
    			$this->data ['heading_title'] = $result ['goodsname'];
    		} else {
    			$this->data ['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result ['goodsimg'] ) && $result ['goodsimg']) {
    			$this->data ['goodsimg'] = $result ['goodsimg'];
    		} else {
    			$this->data ['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result ['goodsprice'] )) {
    			$this->data ['price'] = $result ['goodsprice'];
    		} else {
    			$this->data ['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result ['ean'] ) && $result ['ean']) {
    			$this->data ['ean'] = $result ['ean'];
    		} else {
    			$this->data ['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result ['jan'] ) && $result ['jan']) {
    			$this->data ['jan'] = $result ['jan'];
    		} else {
    			$this->data ['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset ( $result ['storename'] ) && $result ['storename']) {
    			$this->data ['storename'] = $result ['storename'];
    		} else {
    			$this->data ['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset ( $result ['storeurl'] ) && $result ['storeurl']) {
    			$this->data ['storeurl'] = $result ['storeurl'];
    		} else {
    			$this->data ['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset ( $result ['yunfei'] )) {
    			$this->data ['isbn'] = $result ['yunfei'];
    		} else {
    			$this->data ['isbn'] = 0.00;
    		}
    		
    		if ($flag) {
    			$this->data['prifex'] = 'DD';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    		
    			
    			$this->response->setOutput ($this->render());
    		}
    	} else if (false !== strpos ( $search, 'amazon.cn' )) {
    		
    		$result = array ();
    		
    		$html = $this->gethtmlcontent ( $search );
    		
    		// 商品名
    		if (preg_match ( '#a-size-large\">(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#parseasinTitle\">(.*)<\/h1>#isU', $html, $matches )) {
    			$matches [0] = strip_tags ( $matches [1] );
    			if (! empty ( $matches [1] ))
    				$date [0] = strip_tags ( $matches [1] );
    		}
    		// 图片地址
    		if (preg_match ( '#<div id=[\"|\']kib-ma-container-0[\"|\'][^>]+>(.*)</div>#isU', $html, $matches )) {
    			if (preg_match ( '#src=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['goodsimg'] = $matches [1];
    				}
    			}
    		} else if (preg_match ( '#<tr id=[\"|\']prodImageContainer[\"|\']>(.*)</tr>#isU', $html, $matches )) {
    			
    			if (preg_match ( '#src=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['goodsimg'] = $matches [1];
    				}
    			}
    		} else if (preg_match ( '#<div class=[\"|\']main-image-inner-wrapper[\"|\']>(.*)</div>#isU', $html, $matches )) {
    			
    			if (preg_match ( '#src=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['goodsimg'] = $matches [1];
    				}
    			}
    		} else if (preg_match ( '#<div id=[\"|\']imgTagWrapperId[\"|\'] class=[\"|\']imgTagWrapper[\"|\']>(.*)</div>#isU', $html, $matches )) {
    			
    			if (preg_match ( '#data-a-dynamic-image=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches )) {
    				if (preg_match ( '#http(.*)jpg#isU', $matches [1], $matches )) {
    					if (! empty ( $matches [1] )) {
    						$result ['goodsimg'] = 'http' . $matches [1] . 'jpg';
    					}
    				}
    			}
    		}
    		
    		// 商品价格
    		if (preg_match ( '#id=\"priceblock_ourprice\"[^>]*>(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#priceLarge\"[^>]*>(.*)<\/b>#isU', $html, $matches ) || preg_match ( '#id=\"listPriceValue\"[^>]*>(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#a-size-medium a-color-price offer-price a-text-normal\"[^>]*>(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#id=\"priceblock_saleprice\"[^>]*>(.*)<\/span>#isU', $html, $matches )) {
    			if (! empty ( $matches [1] )) {
    				$matches [1] = str_replace ( '￥', '', $matches [1] );
    				$matches [1] = is_array ( $matches [1] = explode ( '-', $matches [1] ) ) ? trim ( end ( $matches [1] ), ' ' ) : $matches [1];
    				$date [3] = $matches [1];
    			}
    		}
    		if (preg_match ( '#priceLarge kitsunePrice\"[^>]*>(.*)<\/b>#isU', $html, $matches )) {
    			$matches [1] = str_replace ( '￥', '', $matches [1] );
    			$matches [1] = is_array ( $matches [1] = explode ( '-', $matches [1] ) ) ? trim ( end ( $matches [1] ), ' ' ) : $matches [1];
    			$date [3] = $matches [1];
    		}
    		// 商品颜色
    		if (preg_match_all ( '#<li id=\"color_name_[0-9]*\"[^>]*>(.*)<\/li>#isU', $html, $matches ) || preg_match_all ( '#<div id=\"variation_color_name*\"[^>]*>(.*)<\/div>#isU', $html, $matches )) {
    			
    			foreach ( $matches [1] as $v ) {
    				if (preg_match ( '#<img[^>]*alt=\"(.*)\"[^>]*>#isU', $v, $matches ) || preg_match ( '#selection\">(.*)<\/span>#isU', $html, $matches )) {
    					if (! empty ( $matches [1] ))
    						$date [4] [] = $matches [1];
    				}
    			}
    		}
    		// 商品规格
    		if (preg_match_all ( '#<div class=[\"|\']swatchInnerText[\"|\'][^>]+>(.*)</div>#isU', $html, $matches ) || (preg_match ( '#native_dropdown_selected_size_name\"[^>]*>(.*)<\/select>#isU', $html, $matches ) && preg_match_all ( '#<option[^>]*>(.*)<\/option>#isU', $matches [1], $matches )) || preg_match_all ( '#<li id=\"size_name_[0-9]*\"[^>]*>(.*)<\/li>#isU', $html, $matches ) || (preg_match ( '#a-spacing-top-micro swatches swatchesSquare\">(.*)<\/ul>#isU', $html, $matches ) && preg_match_all ( '#<li[^>]*>(.*)<\/li>#isU', $matches [1], $matches ))) {
    			if (! is_array ( $matches [1] )) {
    				$date [5] = $matches [1];
    			} else {
    				if (array_search ( "选择", $matches [1], true ) !== null)
    					unset ( $matches [1] [array_search ( "选择", $matches [1] )] );
    				foreach ( $matches [1] as $v ) {
    					if (preg_match ( '#text\">(.*)<\/div>#isU', $v, $matches )) {
    						if (! empty ( $matches [1] )) {
    							$matches [1] = strip_tags ( $v );
    							$date [5] [] = $matches [1];
    						}
    					} else {
    						if (! empty ( $v )) {
    							$matches [1] = strip_tags ( $v );
    							$date [5] [] = $matches [1];
    						}
    					}
    				}
    			}
    		}
    		// 商品运费
    		if (preg_match ( '#ddmMerchantMessage\">(.*)<\/span>#isU', $html, $matches ) || preg_match ( '#a-size-base a-color-base\">(.*)<\/span>#isU', $html, $matches )) {
    			$matches [1] = strip_tags ( $matches [1] );
    			if (is_numeric ( $matches [1] ))
    				if (! empty ( $matches [1] ))
    					$date [6] = $matches [1];
    		}
    		
    		// var_dump ( $date );
    		
    		if (array_key_exists ( '0', $date ) && $date [0])
    			$result ['goodsname'] = $date [0];
    		
    		if (array_key_exists ( '3', $date ) && $date [3])
    			$result ['goodsprice'] = $date [3];
    		
    		if (array_key_exists ( '4', $date ) && $date [4]) {
    			
    			$result ['ean'] = $date [4];
    		}
    		
    		if (array_key_exists ( '5', $date ) && $date [5]) {
    			// unset( $date[5][array_search (" ", $date [5] )] );
    			// var_dump ( $date [5] );
    			$result ['jan'] = array_filter ( $date [5] );
    			// var_dump ( $date [5] );
    		}
    		
    		if (array_key_exists ( '6', $date ) && $date [6]) {
    			
    			$result ['yunfei'] = $date ['6'];
    		}
    		
    		$result ['storename'] = "亚马逊";
    		
    		$result ['storeurl'] = "http://www.amazon.cn/";
    		
    		if ($search) {
    			$this->data ['search'] = $search;
    		} else {
    			$this->data ['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset ( $result ['num_iid'] ) && $result ['num_iid']) {
    			$this->data ['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data ['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result ['goodsname'] ) && $result ['goodsname']) {
    			$this->data ['heading_title'] = $result ['goodsname'];
    		} else {
    			$this->data ['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result ['goodsimg'] ) && $result ['goodsimg']) {
    			$this->data ['goodsimg'] = $result ['goodsimg'];
    		} else {
    			$this->data ['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result ['goodsprice'] )) {
    			$this->data ['price'] = $result ['goodsprice'];
    		} else {
    			$this->data ['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result ['ean'] ) && $result ['ean']) {
    			$this->data ['ean'] = $result ['ean'];
    		} else {
    			$this->data ['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result ['jan'] ) && $result ['jan']) {
    			$this->data ['jan'] = $result ['jan'];
    		} else {
    			$this->data ['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset ( $result ['storename'] ) && $result ['storename']) {
    			$this->data ['storename'] = $result ['storename'];
    		} else {
    			$this->data ['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset ( $result ['storeurl'] ) && $result ['storeurl']) {
    			$this->data ['storeurl'] = $result ['storeurl'];
    		} else {
    			$this->data ['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset ( $result ['yunfei'] )) {
    			$this->data ['isbn'] = $result ['yunfei'];
    		} else {
    			$this->data ['isbn'] = 0.00;
    		}
    		if ($flag) {
    			$this->data['prifex'] = 'AM';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    			$this->response->setOutput ($this->render());
    		}
    	} else if (false !== strpos ( $search, 'jd.com' )) {
    		
    		$result = array ();
    		
    		$html = $this->gethtmlcontent ( $search );
    		$html = mb_convert_encoding ( $html, 'UTF-8', 'gb2312' );
    		
    		// 商品编号
    		if (preg_match ( '#jd.com/(.*).html#isU', $search, $matches )) {
    			// var_dump($matches);
    			if (! empty ( $matches )) {
    				$result ['num_iid'] = $matches [1];
    			}
    		}
    		
    		// 商品名称
            if (preg_match('#<div id="name">(.*)</div>#isU',$html, $matches)) {
                if (preg_match ( '#<h1>(.*)</h1>#isU', $matches[1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['goodsname'] = strip_tags ( $matches [1] );
    				}
    			}
                
            }
    	
    		
    		// 商品价格
    		if (isset ( $result ['num_iid'] ) && $result ['num_iid']) {
    			$price_url = 'http://p.3.cn/prices/get?skuid=J_' . $result ['num_iid'];
    			$price_html = $this->gethtmlcontent ( $price_url );
    			
    			$p_price = explode ( ',', $price_html );
			if (isset($p_price [1])){
    				$price = explode ( ':', $p_price [1] );
    				$price = trim ( $price [1], '"' );
			}else{
				$price = '';
			}
    			$result ['goodsprice'] = trim ( $price, '"' );
    		}
    		
    		// 商品主图
    		if (preg_match ( '#jqimg=[\"|\'](.*)[\"|\']#isU', $html, $matches )) {
    		
    			if (! empty ( $matches )) {
    				$result ['goodsimg'] = $matches [1];
    			}
    		} elseif (preg_match ( '#<img width=[\"|\']350[\"|\'] height=[\"|\']350[\"|\']  data-img=[\"|\']1[\"|\'] src=[\"|\'](.*)[\"|\'] alt=[\"|\'](.*)[\"|\']>#isU', $html, $matches )) {
    			
    			if (! empty ( $matches )) {
    				$result ['goodsimg'] = $matches [1];
    			}
    		}
    		
    		// 商品颜色
    		if (preg_match ( '#<li id=[\"|\']choose-color[\"|\'] class=[\"|\']choose-color-shouji[\"|\']>(.*)</li>#isU', $html, $matches )) {
    			
    			if (preg_match_all ( '#<i>(.*)</i>#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['ean'] = $matches [1];
    				}
    			}
    		}
    		
    		// 商品尺寸规格
    		if (preg_match ( '#<li id=[\"|\']choose-version[\"|\']>(.*)</li>#isU', $html, $matches )) {
    			
    			if (preg_match_all ( '#<a[^>]+>(.*)</a>#isU', $matches [1], $matches )) {
    				if (! empty ( $matches )) {
    					$result ['jan'] = $matches [1];
    				}
    			}
    		}
    		$result ['yunfei'] = 0.00;
    		
    		$result ['storename'] = "京东商城";
    		
    		$result ['storeurl'] = "http://www.jd.com/";
    		
    		if ($search) {
    		    if(!strstr($search,'http') || !strstr($search,'HTTP')) {
    		        $this->data ['search'] = "http://".$search;
    		    } else {
    		        $this->data ['search'] = $search;
    		    }
    			
    		} else {
    			$this->data ['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset ( $result ['num_iid'] ) && $result ['num_iid']) {
    			$this->data ['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data ['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result ['goodsname'] ) && $result ['goodsname']) {
    			$this->data ['heading_title'] = $result ['goodsname'];
    		} else {
    			$this->data ['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result ['goodsimg'] ) && $result ['goodsimg']) {
    			$this->data ['goodsimg'] = $result ['goodsimg'];
    		} else {
    			$this->data ['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result ['goodsprice'] )) {
    			$this->data ['price'] = $result ['goodsprice'];
    		} else {
    			$this->data ['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result ['ean'] ) && $result ['ean']) {
    			$this->data ['ean'] = $result ['ean'];
    		} else {
    			$this->data ['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result ['jan'] ) && $result ['jan']) {
    			$this->data ['jan'] = $result ['jan'];
    		} else {
    			$this->data ['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset ( $result ['storename'] ) && $result ['storename']) {
    			$this->data ['storename'] = $result ['storename'];
    		} else {
    			$this->data ['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset ( $result ['storeurl'] ) && $result ['storeurl']) {
    			$this->data ['storeurl'] = $result ['storeurl'];
    		} else {
    			$this->data ['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset ( $result ['yunfei'] )) {
    			$this->data ['isbn'] = $result ['yunfei'];
    		} else {
    			$this->data ['isbn'] = '';
    		}
    		if ($flag) {
    			$this->data['prifex'] = 'JD';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {
    				
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    			$this->response->setOutput ($this->render ());
    		}
    	} else if (false !== strpos($search, 'mogujie.com' )) {
    	 		 
            $result = array();
    		
    		$html = $this->gethtmlcontent($search);
    		
    		// 商品名称
    		if (preg_match ('#<h1 class="goods-title">(.*)</h1>#isU', $html, $matches)) {
    			if (!empty($matches)) {
    				$result['goodsname'] = strip_tags ($matches[1]);
    			}
    		}
            
            
           
    		
    		// 商品价格
    
    		if (preg_match('#<span id=[\"|\']J_NowPrice[\"|\'] class=[\"|\']price-n[\"|\']>(.*)</span>#isU', $html, $matches)) {
    			
    			if (!empty($matches)) {
    				$result['goodsprice'] = $matches[1];
    			
    			}
    		} 
            
          
            
    		
    		// 商品主图
           
    		if (preg_match ('#<img id=[\"|\']J_BigImg[\"|\'] src=[\"|\'](.*)[\"|\'][^>]+>#isU', $html, $matches)) {
    		    
                $result ['goodsimg'] = $matches[1];	
    		}
            
        
            
    		
    		// 商品颜色和尺寸规格
            
    		if (preg_match('#var detailInfo = {(.*)};#isU', $html, $matches)) {
    		
    			if (preg_match_all('#[\"|\']style[\"|\']:[\"|\'](.*)[\"|\']#isU', $matches[1], $matches )) {
    			   
    				if (! empty ( $matches )) {
    					$result['ean'] = $matches[1];
    				}
    			}
    
    		}
            
            if(isset($result['ean']) && $result['ean']) {
                
                $result['ean'] = array_flip(array_flip($result['ean']));
            
                foreach($result['ean'] as &$ean) {
    
                        $ean = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $ean);
                    
                }
                
            }
    
            
            if (preg_match('#var detailInfo = {(.*)};#isU', $html, $matches)) {
    
                if (preg_match_all('#[\"|\']size[\"|\']:[\"|\'](.*)[\"|\']#isU', $matches[1], $matches)) {
    			   
    				if (! empty ( $matches )) {
    					$result['jan'] = $matches[1];
    				}
    			}
    		}
            
            if(isset($result['jan']) && $result['jan']) {
                
                $result['jan'] = array_flip(array_flip($result['jan']));
    
                foreach($result['jan'] as &$jan) {
    
                        $jan = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $jan);
    
                }
            }
            
            
            
           
            
    		$result ['yunfei'] = 0.00;
    		
            //店铺名称
            if (preg_match('#<span class=[\"|\']name-wrap clearfix[\"|\'](.*)</span>#isU',$html,$matches)) {
                
                if (preg_match('#<a[^>]+>(.*)</a>#isU', $matches[1], $matches)) {
                     
                     $result['storename'] = $matches[1];
                }
    
                if (preg_match('#href=[\"|\'](.*)[\"|\']#isU', $matches[0], $matches)) {
                   
                    $result['storeurl'] = $matches[1];
                }
            }
            
          
            
    		
    		if ($search) {
    			$this->data['search'] = $search;
    		} else {
    			$this->data['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset($result['num_iid']) && $result['num_iid']) {
    			$this->data['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result['goodsname']) && $result['goodsname']) {
    			$this->data['heading_title'] = $result['goodsname'];
    		} else {
    			$this->data['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result['goodsimg'] ) && $result['goodsimg']) {
    			$this->data['goodsimg'] = $result['goodsimg'];
    		} else {
    			$this->data['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result['goodsprice'] )) {
    			$this->data['price'] = $result['goodsprice'];
    		} else {
    			$this->data['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result['ean'] ) && $result['ean']) {
    			$this->data['ean'] = $result['ean'];
    		} else {
    			$this->data['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result['jan'] ) && $result['jan']) {
    			$this->data['jan'] = $result['jan'];
    		} else {
    			$this->data['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset ( $result['storename'] ) && $result['storename']) {
    			$this->data['storename'] = $result['storename'];
    		} else {
    			$this->data['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset($result['storeurl']) && $result['storeurl']) {
    			$this->data['storeurl'] = $result['storeurl'];
    		} else {
    			$this->data['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset($result['yunfei'])) {
    			$this->data['isbn'] = $result['yunfei'];
    		} else {
    			$this->data['isbn'] = '';
    		}
            
    		if ($flag) {
    			$this->data['prifex'] = 'MGJ';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {						
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    		
    			$this->response->setOutput($this->render());
            }
    
        }else if (false !== strpos($search, 'meilishuo.com' )) {
    	 		 
            $result = array();
    		
    		$html = $this->gethtmlcontent($search);
            
    		
    		//商品名称
    		if (preg_match ('#<h3 class="s_tle">(.*)</h3>#isU', $html, $matches)) {
    			if (!empty($matches)) {
    				$result['goodsname'] = strip_tags ($matches[1]);
    			}
    		} else if(preg_match ('#<h3 class="item-title">(.*)</h3>#isU', $html, $matches)) {
    		    if (!empty($matches)) {
                    $result['goodsname'] = strip_tags($matches[1]);
    		    }
    		}
            
           
           
    		
    		// 商品价格
    		if (preg_match('#<ul class="sku_meta">(.*)</ul>#isU', $html, $matches)) {
    			//var_dump($matches);
                if(preg_match('#<span class="price">(.*)</span>#isU', $matches[1], $matches)) {
                    
                        if(!empty($matches)) {
    					  $result['goodsprice'] = $matches[1];
                          $result ['goodsprice'] = trim($result ['goodsprice'], '¥');
    				    }
                    
                }
    			
    		} 
            
           if(!isset($result ['goodsprice'])) {
                 if(preg_match('#<i id="price-now"[^>]+>(.*)</i>#isU', $html, $matches)) {
                  if(!empty($matches)) {
    					  $result['goodsprice'] = $matches[1];
                          $result ['goodsprice'] = trim($result ['goodsprice'], '¥');
    				    }
    		      }
           }
            

    		// 商品主图
            
    		if (preg_match ('#<img class="j_big_show twitter_pic"[^>]+>#isU', $html, $matches)) {
    		   
                if(preg_match('#src="(.*)"#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsimg'] = $matches[1];	
                    }
                }
                
                
    		}else if(preg_match ('#<img class="j-big-pic twitter_pic"[^>]+>#isU', $html, $matches)) {
    		      
                  if(preg_match('#src="(.*)"#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsimg'] = $matches[1];	
                    }
                }
              
    		}
            
    		
    		// 商品颜色和尺寸规格
    		if (preg_match('#<ul id="colorList">(.*)</ul>#isU', $html, $matches)) {
    			if (preg_match_all('#title="(.*)"#isU', $matches[1], $matches )) {
    			  
    				if (! empty ( $matches )) {
    					$result['ean'] = $matches[1];
    				}
                    
    			}
    
    		}else if(preg_match('#<ul id="colorList" class="item-colorlist ">(.*)</ul>#isU', $html, $matches)) {
    		  
                 if(preg_match_all('#<a [^>]+>(.*)</a>#isU', $matches[1], $matches)){
                    
    			    if (! empty ( $matches )) {
    					$result['ean'] = $matches[1];
    				}
                    
    			}
              
    		}
            
    
            
            if (preg_match('#<ul id="sizeList">(.*)</ul>#isU', $html, $matches)) {
    
                if (preg_match_all('#title="(.*)"#isU', $matches[1], $matches)) {
    			   
    				if (! empty ( $matches )) {
    					$result['jan'] = $matches[1];
    				}
    			}
    		}
           
            
    		$result ['yunfei'] = 0.00;
    		
            //店铺名称
            if (preg_match('#<div class=[\"|\']shop-wrap[\"|\']>(.*)</div>#isU',$html,$matches)) {
               
                if (preg_match('#<a[^>]+>(.*)</a>#isU', $matches[1], $matches)) {
                     
                     $result['storename'] = $matches[1];
                }
    
                if (preg_match('#href=[\"|\'](.*)[\"|\']#isU', $matches[0], $matches)) {
                   
                    $result['storeurl'] = $matches[1];
                }
            }
            
    		
    		if ($search) {
    			$this->data['search'] = $search;
    		} else {
    			$this->data['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset($result['num_iid']) && $result['num_iid']) {
    			$this->data['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result['goodsname']) && $result['goodsname']) {
    			$this->data['heading_title'] = $result['goodsname'];
    		} else {
    			$this->data['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result['goodsimg'] ) && $result['goodsimg']) {
    			$this->data['goodsimg'] = $result['goodsimg'];
    		} else {
    			$this->data['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result['goodsprice'] )) {
    			$this->data['price'] = $result['goodsprice'];
    		} else {
    			$this->data['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result['ean'] ) && $result['ean']) {
    			$this->data['ean'] = $result['ean'];
    		} else {
    			$this->data['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result['jan'] ) && $result['jan']) {
    			$this->data['jan'] = $result['jan'];
    		} else {
    			$this->data['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset ( $result['storename'] ) && $result['storename']) {
    			$this->data['storename'] = $result['storename'];
    		} else {
    			$this->data['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset($result['storeurl']) && $result['storeurl']) {
    			$this->data['storeurl'] = "http://www.meilishuo.com" . $result['storeurl'];
    		} else {
    			$this->data['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset($result['yunfei'])) {
    			$this->data['isbn'] = $result['yunfei'];
    		} else {
    			$this->data['isbn'] = '';
    		}
            
    		if ($flag) {
    			$this->data['prifex'] = 'MGJ';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {						
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    		
    			$this->response->setOutput($this->render());
            } 
        
        
        } else if (false !== strpos($search, 'vip.com')) {
    	 		 
            $result = array();
    		
    		$html = $this->gethtmlcontent($search);
            
    		
            // 商品编号
    		if (preg_match('#<dl class="other clearfix">(.*)</dl>#isU', $html, $matches )) {
                if(preg_match('#<dd class="other_box">(.*)</dd>#isU',$matches[1],$matches)) {
                    
                    if (! empty ( $matches )) {
    					$result['num_iid'] = $matches[1];
    				}
                }	
    		}
          
            
    		//商品名称
    		if (preg_match ('#<p class="pib_title_detail">(.*)</p>#isU', $html, $matches)) {
    			if (!empty($matches)) {
    				$result['goodsname'] = strip_tags($matches[1]);
    			}
    		}
    
    		// 商品价格
    		if (preg_match('#<span class="pbox_price">(.*)</span>#isU', $html, $matches)) {
    			
                if(preg_match('#<em>(.*)</em>#isU', $matches[1], $matches)) {
                    
                        if(!empty($matches)) {
    					  $result['goodsprice'] = $matches[1];
                          $result ['goodsprice'] = trim($result ['goodsprice'], '¥');
    				    }
                    
                }
    			
    		} 
    		
    		// 商品主图
    		if (preg_match('#<div class=[\"|\']show_midpic [\"|\']>(.*)</div>#isU', $html, $matches)) {
                if(preg_match('#src="(.*)"#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsimg'] = $matches[1];	
                    }
                }
                
                
    		}

    		// 商品颜色和尺寸规格
            
    		if (preg_match('#<dd class="color_list"(.*)</dd>#isU', $html, $matches)) {
    		
    			if (preg_match_all('#alt="(.*)"#isU', $matches[1], $matches )) {
    			   
    				if (! empty ( $matches )) {
    					$result['ean'] = $matches[1];
    				}
    			}
    
    		}
            

            if (preg_match('#<dd class="size_list">(.*)</dd>#isU', $html, $matches)) {
    
                if (preg_match_all('#<span class="size_list_item_name">(.*)</span>#isU', $matches[1], $matches)) {
    			   
    				if (! empty ( $matches )) {
    					$result['jan'] = $matches[1];
    				}
    			}
    		}
            
            
    		$result ['yunfei'] = 0.00;
    		
            //店铺名称
    
            $result['storename'] = "唯品会";
    
            $result['storeurl'] = "http://www.vip.com/"; 
    		
    		if ($search) {
    			$this->data['search'] = $search;
    		} else {
    			$this->data['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset($result['num_iid']) && $result['num_iid']) {
    			$this->data['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result['goodsname']) && $result['goodsname']) {
    			$this->data['heading_title'] = $result['goodsname'];
    		} else {
    			$this->data['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result['goodsimg'] ) && $result['goodsimg']) {
    			$this->data['goodsimg'] = $result['goodsimg'];
    		} else {
    			$this->data['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result['goodsprice'] )) {
    			$this->data['price'] = $result['goodsprice'];
    		} else {
    			$this->data['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result['ean'] ) && $result['ean']) {
    			$this->data['ean'] = $result['ean'];
    		} else {
    			$this->data['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result['jan'] ) && $result['jan']) {
    			$this->data['jan'] = $result['jan'];
    		} else {
    			$this->data['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset($result['storename']) && $result['storename']) {
    			$this->data['storename'] = $result['storename'];
    		} else {
    			$this->data['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset($result['storeurl']) && $result['storeurl']) {
    			$this->data['storeurl'] = $result['storeurl'];
    		} else {
    			$this->data['storeurl'] = '';
    		}
    		
            
            
    		// 国内运费
    		if (isset($result['yunfei'])) {
    			$this->data['isbn'] = $result['yunfei'];
    		} else {
    			$this->data['isbn'] = '';
    		}
            
    		if ($flag) {
    			$this->data['prifex'] = 'MGJ';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
    		} else {
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_snatch_info.tpl';
    			} else {						
    				$this->template = 'default/template/product/zzg_snatch_info.tpl';
    			}
    			
    			$this->response->setOutput($this->render());
            } 
        
        
        } else if(false !== strpos($search, 'jumei.com') || false !== strpos($search,'jumeiglobal.com')) {
            
            $result = array();
    		
    		$html = $this->gethtmlcontent($search);
            
    		//商品名称                    
    		if (preg_match ('#<div class="newdeal_breadcrumbs_wrap_b">(.*)</div>#isU', $html, $matches)) {
    			if (!empty($matches)) {
    				$result['goodsname'] = strip_tags($matches[1]);
    			}
    		} else if(preg_match('#<div class="location">(.*)</div>#isU', $html, $matches)) {
    		   if(preg_match('#<span>(.*)</span>#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsname'] = $matches[1];	
                    }
                } 
    		} else if(preg_match('#<h1 class="pop_detail_tit">(.*)</h1>#isU',$html,$matches)) {
    		  if(!empty($matches)) {
                        $result ['goodsname'] = $matches[1];	
              }
    		} else if(preg_match('#<h1>(.*)</h1>#isU',$html,$matches)) {
 		     
    		  if(!empty($matches)) {
                        $result ['goodsname'] = $matches[1];	
              }
    		}
            
            //var_dump($result['goodsname']);
   
    		// 商品价格
    		if (preg_match('#<input type="hidden" id="discounted_price" value=[\"|\'](.*)[\"|\']>#isU', $html, $matches)) {
    			if (!empty($matches)) {
				  $result['goodsprice'] = $matches[1];
                }
    		} else if(preg_match('#<span id="mall_price">(.*)</span>#isU', $html, $matches)) {
  		        if (!empty($matches)) {
    				  $result['goodsprice'] = $matches[1];
                }
    		} else if(preg_match('#<strong class="red_price">(.*)</strong>#isU', $html, $matches)) {
    		   if(preg_match('#</span>(.*)</strong>#isU', $matches[0], $matches)){
    		       if (!empty($matches)) {
    				  $result['goodsprice'] = $matches[1];
                   }
    		   }
    		  
    		} else if(preg_match('#<span class="price_now ">(.*)</span>#isU', $html, $matches)) {
    		    if(preg_match('#</em>(.*)</span>#isU', $matches[0], $matches)){
    		       if (!empty($matches)) {
    				  $result['goodsprice'] = $matches[1];
                   }
    		   }   
    		}
            
            //var_dump($result['goodsprice']);
    		
    		// 商品主图 
    		if (preg_match('#<td rowspan=[\"|\']7[\"|\'] style=[\"|\']padding-right:0;[\"|\']>(.*)</td>#isU', $html, $matches)) {
                if(preg_match('#src="(.*)"#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsimg'] = $matches[1];	
                    }
                } 
    		} else if(preg_match('#<td  rowspan=[\"|\']7[\"|\'] align=[\"|\']right[\"|\'] valign=[\"|\']bottom[\"|\']>(.*)</td>#isU', $html, $matches)) {
    		 
    		     if(preg_match('#src="(.*)"#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsimg'] = $matches[1];	
                    }
                } 
    		} else if(preg_match('#</table>(.*)</div>#isU', $html, $matches)) {
    		
    		     if(preg_match('#src="(.*)"#isU',$matches[0],$matches)) {
                    if(!empty($matches)) {
                        $result ['goodsimg'] = $matches[1];	
                    }
                } 
    		}
            
            

            if (preg_match('#<ul class="J_size_wrap">(.*)</ul>#isU', $html, $matches)) {
    
                if (preg_match_all('#<span>(.*)</span>#isU', $matches[1], $matches)) {
    			   
    				if (! empty ( $matches )) {
    					$result['jan'] = $matches[1];
    				}
    			}
    		}
            
            //var_dump($result['jan']);
            
    		$result ['yunfei'] = 0.00;
    		
            //店铺名称
    
            $result['storename'] = "聚美优品";
    
            $result['storeurl'] = "http://www.jumei.com/"; 
    		
    		if ($search) {
    			$this->data['search'] = $search;
    		} else {
    			$this->data['search'] = '';
    		}
    		
    		// 商品编号 $result['num_iid']
    		if (isset($result['num_iid']) && $result['num_iid']) {
    			$this->data['num_iid'] = $result ['num_iid'];
    		} else {
    			$this->data['num_iid'] = '';
    		}
    		
    		// 商品名字 $result['goodsname']
    		if (isset ( $result['goodsname']) && $result['goodsname']) {
    			$this->data['heading_title'] = $result['goodsname'];
    		} else {
    			$this->data['heading_title'] = '';
    		}
    		
    		// 商品主图 $result['goodsimg']
    		if (isset ( $result['goodsimg'] ) && $result['goodsimg']) {
    			$this->data['goodsimg'] = $result['goodsimg'];
    		} else {
    			$this->data['goodsimg'] = '';
    		}
    		
    		// 商品价格 $result['price']
    		if (isset ( $result['goodsprice'] )) {
    			$this->data['price'] = $result['goodsprice'];
    		} else {
    			$this->data['price'] = '';
    		}
    		
    		// 颜色分类 $result['ean']
    		if (isset ( $result['ean'] ) && $result['ean']) {
    			$this->data['ean'] = $result['ean'];
    		} else {
    			$this->data['ean'] = '';
    		}
    		
    		// 尺码大小 $result['jan']
    		if (isset ( $result['jan'] ) && $result['jan']) {
    			$this->data['jan'] = $result['jan'];
    		} else {
    			$this->data['jan'] = '';
    		}
    		
    		// 店铺名称
    		if (isset($result['storename']) && $result['storename']) {
    			$this->data['storename'] = $result['storename'];
    		} else {
    			$this->data['storename'] = '';
    		}
    		
    		// 店铺地址
    		if (isset($result['storeurl']) && $result['storeurl']) {
    			$this->data['storeurl'] = $result['storeurl'];
    		} else {
    			$this->data['storeurl'] = '';
    		}
    		
    		// 国内运费
    		if (isset($result['yunfei'])) {
    			$this->data['isbn'] = $result['yunfei'];
    		} else {
    			$this->data['isbn'] = '';
    		}
            
    		if ($flag) {
    			$this->data['prifex'] = 'JM';
    			$this->data['property'] = array();
    			if ($this->data['jan']) $this->data['property']['尺码'] = $this->data['jan'];
    			if ($this->data['ean']) $this->data['property']['颜色分类'] = $this->data['ean'];
    			echo(json_encode($this->data));
                
    		} else {
    		  
    			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/zzg_zzg_snatch_info.tpl' )) {
    				$this->template = $this->config->get ( 'config_template' ) . '/template/product/zzg_zzg_snatch_info.tpl';
    			} else {						
    				$this->template = 'default/template/product/zzg_zzg_snatch_info.tpl';
    			}
    			
    			$this->response->setOutput($this->render());
            }     
        
        } else {
            
    		
    		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/error/snatch_noresults.tpl' )) {
    		    
    			$this->template = $this->config->get ( 'config_template' ) . '/template/error/snatch_noresults.tpl';
                
    		} else {
    		    
    			$this->template = 'default/template/error/snatch_noresults.tpl';
                
    		}
    		
    		$this->response->setOutput($this->render());
    	}
	
	}
    
	/*
	 * *************************************************************************************
     * @function：定义函数gethtmlcontent()用于通过url获取整个网页内容 
     * @param： string $url 参数为输入的url地址 
     * @return： string $html 返回整个网页内容 
     * @author： kennewei<wk@cnstorm.com> 
     * @date: 2014.8.19 
     **************************************************************************************
	 */
	protected function gethtmlcontent($url) {
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_URL, $url );
		// 设置URL，可以放入curl_init参数中
		curl_setopt ( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1" );
		// 设置UA
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		// 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。 如果不加，即使没有echo,也会自动输出
		$content = curl_exec ( $ch );
		// 执行
		curl_close ( $ch );
		
		return $content;
	}
	
	/*
	 * **************************************************************************************
     * @function：定义函数getprice()用于通过淘宝API接口获取单件商品的颜色对应价格或者尺寸对应价格 
     * @param： string $key 参数为该单件商品选定的颜色或者尺寸键值 
     * @return： json $data 返回该单件颜色或者尺寸对应的价格 
     * @author： kennewei<wk@cnstorm.com> 
     * @date: 2014.8.29 
     **************************************************************************************
	 */
	public function getprice() {
		if (isset ( $this->request->post ['key'] ) && $this->request->post ['key']) {
			$key = trim ( $this->request->post ['key'] );
		}
		if (isset($this->session->data ['size_color_price'])){
			$array_price = $this->session->data ['size_color_price'];
		}else{
			$array_price = array();
		}
		
		if (array_key_exists ( '_' . $key, $array_price ) && $array_price ['_' . $key]) {
			$data ['price'] = $array_price ['_' . $key];
			$this->response->setOutput ( json_encode ( $data ['price'] ) );
		} else if (array_key_exists ( $key . '_', $array_price ) && $array_price [$key . '_']) {
			$data ['price'] = $array_price [$key . '_'];
			$this->response->setOutput ( json_encode ( $data ['price'] ) );
		}
	}
	
	/*
	 * ****************************************************************************************
     * @function：定义函数getcolorsizeinfo()用于通过淘宝API接口获取单件商品的颜色尺寸对应的价格 
     * @param： string $key 参数为该单件商品选定的颜色尺寸键值 
     * @return： json $data 返回该单件商品的价格 
     * @author： kennewei<wk@cnstorm.com> 
     * @date: 2014.5.15 
     ******************************************************************************************
	 */
	public function getcolorsizeinfo() {
		$size = '';
		
		$color = '';
		
		$data = array ();
		
		if (isset ( $this->request->post ['size'] )) {
		  
			$size = trim ( $this->request->post ['size'] );
            
			$size = htmlspecialchars_decode ( $size );
		}
		if (isset ( $this->request->post ['color'] )) {
		  
			$color = trim ( $this->request->post ['color'] );
            
			$color = htmlspecialchars_decode ( $color );
		}
		
		$color = str_replace ( '_', ':', $color );
		
		$color_number = $this->session->data ['color_number'];
		
		$color = $color_number [$color];
		
		$size = str_replace ( '_', ':', $size );
		
		$size_number = $this->session->data ['size_number'];
		
		$size = $size_number [$size];
		
		$size_color_price = $this->session->data ['size_color_price'];
		
		$key = $size . '_' . $color;
		
		$data ['price'] = $size_color_price [$key];
		
		$this->response->setOutput ( json_encode ( $data ) );
	}
	
	/*
	 * ***************************************************************************************
     * @funtion：定义函数getcolorsizeinfo()用于通过淘宝API接口获取单件商品的选择颜色对应的尺寸 
     * @param： string $key 参数为该单件商品选定的颜色 
     * @return： json $data 返回该单件商品的缺失尺寸 
     * @author： kennewei<wk@cnstorm.com> 
     * @date: 2014.5.15 
     *****************************************************************************************
	 */
	public function getsizeinfo() {
		$color = '';
		
		$data = array ();
		
		$size_array = array ();
		
		if (isset ( $this->request->post ['color'] )) {
		  
			$color = trim ( $this->request->post ['color'] );
            
			$color = htmlspecialchars_decode ( $color );
		}
		if (isset($this->session->data ['color_number'])){
			$color_number = $this->session->data ['color_number'];
		}else{
			$color_number = array();
		}
		
		$color = str_replace ( '_', ':', $color );
		
		$color = $color_number [$color];
		
		if (isset($this->session->data ['quantity'])){
			$quantity = $this->session->data ['quantity'];
		}else{
			$quantity = array();
		}
		if (isset($this->session->data ['size'])){
			$size_value = $this->session->data ['size'];
		}else{
			$size_value = '';
		}
		if (isset($this->session->data ['size_number'])){
			$size_number = $this->session->data ['size_number'];
		}else{
			$size_number = array();
		}
		if (isset($this->session->data ['color_number'])){
			$color_number = $this->session->data ['color_number'];
		}else{
			$color_number = array();
		}
		
		$size_array = explode ( ',', $size_value );
		
		foreach ( $size_array as $size ) {
			
			if (! array_key_exists ( $size . '_' . $color, $quantity ) || $quantity [$size . '_' . $color] < 0) {
			 
				$getSize = array_keys ( $size_number, $size );
                if (isset($getSize[0])){
					$data [] = str_replace ( ':', '_', $getSize[0] );
				}else{
					$data [] = "no";
				}
                
			}
		}
		
		$this->response->setOutput ( json_encode ( $data ) );
	}
	
	/*
	 * ************************************************************************************
     * @function：定义函数getcolorinfo()用于通过淘宝API接口获取单件商品的选择尺寸对应的颜色 
     * @param： string $key 参数为该单件商品选定的尺寸 
     * @return： json $data 返回该单件商品的缺失颜色 
     * @author： kennewei<wk@cnstorm.com> 
     * @date: 2014.5.15 
     **************************************************************************************
	 */
	public function getcolorinfo() {
		
		$size = '';
		
		$data = array ();
		
		$color_array = array ();
		
		if (isset ( $this->request->post ['size'] )) {
		  
			$size = trim ( $this->request->post ['size'] );
            
			$size = htmlspecialchars_decode ( $size );
		}
		
		$size = str_replace ( '_', ':', $size );
		
		$size_number = $this->session->data ['size_number'];
		
		$size = $size_number [$size];
		
		$quantity = $this->session->data ['quantity'];
		
		$color_value = $this->session->data ['color'];
		
		$color_number = $this->session->data ['color_number'];
		
		$color_array = explode ( ',', $color_value );
		
		foreach ( $color_array as $color ) {
		  
			if (! array_key_exists ( $size . '_' . $color, $quantity ) || $quantity [$size . '_' . $color] < 0) {
			 
				$getColor = array_keys ( $color_number, $color );
                if (isset($getColor[0])){
					$data [] = str_replace ( ':', '_', $getColor[0] );
				}else{
					$data [] = "no";
				}
			}
		}
		
		$this->response->setOutput ( json_encode ( $data ) );
	}
	
	/*
	 * ************************************************************************************
     * @funtion：定义函数getimg()用于通过淘宝API接口获取单件商品的选择颜色对应的主图URL地址 
     @param： string $key 参数为该单件商品选定的颜色代码 
     @return： json $data 返回该单件商品的选择颜色对应的主图URL地址 
     @author： kennewei<wk@cnstorm.com> 
     @date: 2014.5.17 
     ***************************************************************************************
	 */
	public function getimg() {
		$color = '';
		
		$data = '';
		
		$color_number = array ();
		
		if (isset ( $this->request->post ['color'] )) {
		  
			$color = trim ( $this->request->post ['color'] );
            
			$color = htmlspecialchars_decode ( $color );
		}
		
		$color_number = $this->session->data ['color_number'];
		
		$color = str_replace ( '_', ':', $color );
		
		$color = $color_number [$color];
		
		$getColor = array_keys ( $color_number, $color );
        
		$color_num = $getColor[0];
		if (isset($this->session->data ['img_color'])){
			$result = $this->session->data ['img_color'];
		}else{
			$result = array();
		}
		if ( isset( $result[$color_num] ) ){	
			$data = $result [$color_num];
			$this->response->setOutput ( json_encode ( $data ) );
		}
	}
}

?>
