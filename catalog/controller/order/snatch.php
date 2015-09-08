<?php

/* * ****************************************************************************
 * @description：对搜索值进行判断，如果是淘宝或者天猫的商品url地址，则跳转相应的
  商品详情页面
 * @author：  kennewei<wk@cnstorm.com>

 * @date:     2014.5.28
 * ***************************************************************************** */

class ControllerOrdersnatch extends Controller {

    private $error = array();

    public function index() {

        $this->language->load('product/product');

        $url = '';

        $result = array();

        $storename_array = array();

        $this->data['order_zizhu'] = $this->url->link('order/order/order_zizhu', '', 'SSL');
        $this->data['snatch_cul'] = $this->url->link('order/snatch', '', 'SSL');

        if (isset($this->request->post['daigouurl'])) {
            $url = $this->request->post['daigouurl'];
        } else if (isset($this->request->get['search'])) {
            $url = $this->request->get['search'];
        } else {
            $url = "";
        }

        $this->data['url'] = $url;

        $this->load->model('order/order');

		
		if($this->customer->getId()){

			$username_id = $this->customer->getId();
			  if(!empty($_COOKIE['taobao_id'])){
					$taobaoId=$_COOKIE['taobao_id'];
					$arrTaobaoId=explode(',',$taobaoId);
					for($i=0;$i<count($arrTaobaoId);$i++){
						$sql='update '.DB_PREFIX.'taobao_product set custom_id='.$username_id.' where id= '.$arrTaobaoId[$i];
						$this->db->query($sql);
						//echo $sql.'-';
						$sql="update ".DB_PREFIX."taobao_order set custom_id=".$username_id." where id=(select taobao_order_id from ".DB_PREFIX."taobao_product where id=".$arrTaobaoId[$i].")";
						$this->db->query($sql);
						//	echo $sql.'-';
						}
					setcookie('taobao_id','',-1);
				}
		  }
		
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

        $this->data['action'] = $this->url->link('order/snatch');
        $this->data['customer_name'] = $this->customer->getFirstname();
        $this->data ['api'] = 0;
        $this->data['searchcolor'] = '';
        $this->data['searchsize'] = '';

        if (!empty($url)) {
            $search = htmlspecialchars_decode($url);

            if (preg_match('/[http|https]:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $search)) {

                if (false !== strpos ( $search, 'taobao.com' ) || false !== strpos ( $search, 'tmall.com' ) || false != strpos($search, 'yao.95095')) {

                    include_once(DIR_SYSTEM . 'taobao.class.php');
                    $url_info = parse_url($search);
					if($url_info['host']=='world.taobao.com'){
				
						$productId = substr(strstr($url_info['path'],".htm",true),6);
						$url='https://item.taobao.com/item.htm?id='.$productId;
			
						$url_info = parse_url($url);
					}
					
                    parse_str($url_info['query'], $param);

                    if (isset($param['id']) && isset($param['tradeID']) && !$param['id'] && $param['tradeID'])
                        $param['id'] = $param['tradeID'];
                    if (isset($param['id']) && isset($param['meal_id']) && !$param['id'] && $param['meal_id'])
                        $param['id'] = $param['meal_id'];
                    $result = TAOBAO::getItemInfo($param);

                    if ($result) {
                        $result = array_map('strip_tags', $result);
                        $result = array_map('trim', $result);
                    }

                    $search_result = $result;

                    if (isset($search_result['goodsname'])) {

                        $this->document->setTitle($search_result['goodsname']);
                        $this->document->setDescription($search_result['goodsname']);
                        $this->document->setKeywords($search_result['goodsname']);

                        $this->data['heading_title'] = $search_result['goodsname'];

                        $this->data['points'] = '';

                        $this->load->model('tool/image');

                        if ($search_result['goodsprice']) {
                            $this->data['price'] = $search_result['goodsprice'];
                        } else {
                            $this->data['price'] = false;
                        }

                        //add by weikun 商品详情页面获取商品的国内运费，商品来源，颜色分类，尺码分类，图片来源
                        //商品地址
                        if ($search) {
                            $this->data['search'] = $search;
                        } else {
                            $this->data['search'] = '';
                        }

                        //商品主图
                        if ($search_result['goodsimg']) {
                            $this->data['goodsimg'] = $search_result['goodsimg'];
                        } else {
                            $this->data['goodsimg'] = '';
                        }

                        //商场名称
                        if ($search_result['model']) {
                            $this->data['model'] = $search_result['model'];
                        } else {
                            $this->data['model'] = '';
                        }

                        //卖家名称
                        if ($search_result['storename']) {
                            $this->data['storename'] = $search_result['storename'];
                        } else {
                            $this->data['storename'] = '';
                        }

                        //店铺名称
                        if ($search_result['goodsseller']) {
                            $this->data['upc'] = $search_result['goodsseller'];
                        } else {
                            $this->data['upc'] = '';
                        }

                        //店铺地址
                        if ($search_result['storeurl']) {
                            $this->data['storeurl'] = $search_result['storeurl'];
                        } else {
                            $this->data['storeurl'] = '';
                        }


                        //商品颜色
                        $ean_array = json_decode($search_result['color_number'], true);
                        if (count($ean_array)) {
                            foreach ($ean_array as $key => $value) {
                                $ean[] = $value;
                            }
                            $this->data['ean'] = $ean;
                        } else {
                            $this->data['ean'] = '';
                        }

                        //商品尺寸
                        $jan_array = json_decode($search_result['size_number'], true);
                        if (count($jan_array)) {
                            foreach ($jan_array as $key => $value) {
                                $jan[] = $value;
                            }
                            $this->data['jan'] = $jan;
                        } else {
                            $this->data['jan'] = '';
                        }

                        //国内运费
                        if ($search_result['yunfei']) {
                            $this->data['isbn'] = $search_result['yunfei'];
                        } else {
                            $this->data['isbn'] = '';
                        }


                        
                        $this->data['item_imgs'] = json_decode($search_result['item_imgs']);
                        $this->data['size_number'] = json_decode($search_result['size_number'], true);
                        $this->data['color_number'] = json_decode($search_result['color_number'], true);
                        $this->session->data['size_color_price'] = json_decode($search_result['price'], true);
                        $this->session->data['quantity'] = json_decode($result['quantity'], true);
                        $this->session->data['size_number'] = json_decode($search_result['size_number'], true);
                        $this->session->data['color_number'] = json_decode($search_result['color_number'], true);
                        $this->session->data['size'] = $search_result['size'];
                        $this->session->data['color'] = $search_result['color'];
                        $this->session->data['img_color'] = json_decode($search_result['img_color'], true);

                        $this->data['minimum'] = 1;
                        $this->data['num_iid'] = $search_result['num_iid'];

                        $this->data ['api'] = 1;

                      
                        $this->template = 'cnstorm/template/order/make_zzg_business.tpl';

                        $this->children = array(
                            'common/header_cart',
                            'common/footer',
                            'common/uc_business');


                        $this->response->setOutput($this->render());
                    }
                } else if (false !== strpos($search, '1688.com')) {

                    $result = array();

                    $html = $this->gethtmlcontent($search);
                    $html = iconv('GBK', 'UTF-8', $html);

                    // 商品编号
                    if (preg_match('#1688.com/offer/(.*).html#isU', $search, $matches)) {

                        if (!empty($matches)) {
                            $result ['num_iid'] = $matches [1];
                        }
                    }
                    $date = array();
                    // 商品名
                    if (preg_match('#d-title\">(.*)</h1>#isU', $html, $matches)) {
                        if (!empty($matches [1]))
                            $date [0] = strip_tags($matches [1]);
                        ;
                    }
                    // 图片地址
                    if (preg_match('#vertical-img\">(.*)<\/div>#isU', $html, $matches) && preg_match('#<img[^>]*src=\"(.*)\"[^>]*>#isU', $matches [1], $src)) {
                        if (!empty($src [1]))
                            $date [1] = $src [1];
                    }
                    // 商品价格
                    if ((preg_match('#price-original-sku\">(.*)<\/div>#isU', $html, $matches) && preg_match_all('#value\">(.*)<\/span>#isU', $matches [1], $matches)) || preg_match('#price-length-[4-8]\">(.*)<\/span>#isU', $html, $matches) || preg_match('#\"n.{10}t\">(.*)<\/span>#isU', $html, $matches) || preg_match('#<span[^>]*class=\"price\">(.*)<\/span>#isU', $html, $matches)) {
                        if (is_array($matches [1]))
                            $matches [1] = end($matches [1]);
                        if (!empty($matches [1]))
                            if (is_numeric($matches [1]))
                                $date [3] = $matches [1];
                    }
                    // 商品颜色
                    if ((preg_match('#list-leading\">(.*)<\/ul>#isU', $html, $matches) && preg_match_all('#text text-single-line\">(.*)<\/span>#isU', $matches [1], $matches)) || (preg_match('#list-leading\">(.*)<\/ul>#isU', $html, $matches) && preg_match_all('#<img[^>]*alt="(.*)"[^>]*>#isU', $matches [1], $matches)))
                        if (!empty($matches [1]))
                            $date [4] = $matches [1];

                    // 商品尺寸
                    if (((preg_match('#table-sku"[^>]*>(.*)<\/table>#isU', $html, $matches) || preg_match('#full "[^>]*>(.*)<\/table>#isU', $html, $matches)) && preg_match_all('#<td[^>]*class=\"name\"[^>]*>(.*)<\/td>#isU', $matches [1], $matches)) || preg_match_all('#text text-single-line\">(.*)<\/span>#isU', $html, $matches)) {
                        foreach ($matches [1] as $v) {
                            if (preg_match('#<img[^>]*alt=\"(.*)\"[^>]*>#isU', $v, $matches)) {
                                if (!empty($matches [1]))
                                    $date [5] [] = $matches [1];
                            } else {
                                $v = strip_tags($v);
                                if (!empty($v))
                                    $date [5] [] = $v;
                            }
                        }
                    }
                    // 商品运费
                    if (preg_match('#<\/span><em[^>]*class="value">(.*)<\/em>#isU', $html, $matches)) {
                        if (!empty($matches[1]))
                            $date [6] = $matches[1];
                    }

                    // var_dump($date);
                    if (array_key_exists('0', $date) && $date [0])
                        $result ['goodsname'] = $date [0];

                    if (array_key_exists('1', $date) && $date [1])
                        $result ['goodsimg'] = $date [1];

                    if (array_key_exists('3', $date) && $date [3])
                        $result ['goodsprice'] = $date [3];

                    if (array_key_exists('4', $date) && $date [4]) {

                        $result ['ean'] = $date [4];
                    }

                    if (array_key_exists('5', $date) && $date [5]) {

                        $result ['jan'] = $date [5];
                    }

                    if (array_key_exists('6', $date) && $date [6])
                        $result ['yunfei'] = $date ['6'];

                    $result ['storename'] = "阿里巴巴";

                    $result ['storeurl'] = "http://www.1688.com/";

                    if ($search) {
                        $this->data ['search'] = $search;
                    } else {
                        $this->data ['search'] = '';
                    }

                    // 商品编号 $result['num_iid']
                    if (isset($result ['num_iid']) && $result ['num_iid']) {
                        $this->data ['num_iid'] = $result ['num_iid'];
                    } else {
                        $this->data ['num_iid'] = '';
                    }

                    // 商品名字 $result['goodsname']
                    if (isset($result ['goodsname']) && $result ['goodsname']) {
                        $this->data ['heading_title'] = $result ['goodsname'];
                    } else {
                        $this->data ['heading_title'] = '';
                    }

                    // 商品主图 $result['goodsimg']
                    if (isset($result ['goodsimg']) && $result ['goodsimg']) {
                        $this->data ['goodsimg'] = $result ['goodsimg'];
                    } else {
                        $this->data ['goodsimg'] = '';
                    }

                    // 商品价格 $result['price']
                    if (isset($result ['goodsprice'])) {
                        $this->data ['price'] = $result ['goodsprice'];
                    } else {
                        $this->data ['price'] = '';
                    }

                    // 颜色分类 $result['ean']
                    if (isset($result ['ean']) && $result ['ean']) {
                        $this->data ['ean'] = $result ['ean'];
                    } else {
                        $this->data ['ean'] = '';
                    }

                    // 尺码大小 $result['jan']
                    if (isset($result ['jan']) && $result ['jan']) {
                        $this->data ['jan'] = $result ['jan'];
                    } else {
                        $this->data ['jan'] = '';
                    }

                    // 店铺名称
                    if (isset($result ['storename']) && $result ['storename']) {
                        $this->data ['storename'] = $result ['storename'];
                    } else {
                        $this->data ['storename'] = '';
                    }

                    // 店铺地址
                    if (isset($result ['storeurl']) && $result ['storeurl']) {
                        $this->data ['storeurl'] = $result ['storeurl'];
                    } else {
                        $this->data ['storeurl'] = '';
                    }

                    // 国内运费
                    if (isset($result ['yunfei'])) {
                        $this->data ['isbn'] = $result ['yunfei'];
                    } else {
                        $this->data ['isbn'] = '';
                    }

                    
                    $this->template = 'cnstorm/template/order/make_zzg_business.tpl';

                    $this->children = array(
                        'common/header_cart',
                        'common/footer',
                        'common/uc_business');


                    $this->response->setOutput($this->render());
                } else if (false !== strpos($search, 'dangdang.com')) {

                    $result = array();

                    $html = $this->gethtmlcontent($search);
                    $html = mb_convert_encoding($html, 'UTF-8', 'gbk');

                    // 商品编号
                    if (preg_match('#dangdang.com/(.*).html#isU', $search, $matches)) {
                        // var_dump($matches);
                        if (!empty($matches)) {
                            $result ['num_iid'] = $matches [1];
                        }
                    }

                    // 商品名称
                    if (preg_match('#<h1>(.*)<span#iU', $html, $matches)) {
                        if (!empty($matches)) {
                            $result ['goodsname'] = strip_tags($matches [1]);
                        }
                    }

                    // 商品价格
                    if (preg_match('#<span id=[\"|\']promo_price[\"|\']>(.*)</span>#isU', $html, $matches)) {
                        //var_dump ( $matches );
                        if (!empty($matches)) {
                            $result ['goodsprice'] = $matches [1];
                            $result ['goodsprice'] = trim($result ['goodsprice'], '&yen;');
                        }
                    } elseif (preg_match('#<span id=[\"|\']salePriceTag[\"|\']>(.*)</span>#isU', $html, $matches)) {
                        if (!empty($matches)) {
                            $result ['goodsprice'] = $matches [1];
                        }
                    }

                    // 商品主图
                    if (preg_match('#wsrc=[\"|\'](.*)[\"|\']#isU', $html, $matches)) {
                        // var_dump($matches);
                        if (!empty($matches)) {
                            $result ['goodsimg'] = $matches [1];
                        }
                    }

                    // 商品颜色
                    if (preg_match('#<ul class=[\"|\']color[\"|\']>(.*)</ul>#isU', $html, $matches)) {

                        if (preg_match_all('#title=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['ean'] = $matches [1];
                            }
                        }
                    }

                    // 商品尺寸规格
                    if (preg_match('#<ul class=[\"|\']size[\"|\']>(.*)</ul>#isU', $html, $matches)) {

                        if (preg_match_all('#<a[^>]+>(.*)</a>#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['jan'] = $matches [1];
                                unset($result ['jan'] [array_search("尺码对照表", $result ['jan'])]);
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
                    if (isset($result ['num_iid']) && $result ['num_iid']) {
                        $this->data ['num_iid'] = $result ['num_iid'];
                    } else {
                        $this->data ['num_iid'] = '';
                    }

                    // 商品名字 $result['goodsname']
                    if (isset($result ['goodsname']) && $result ['goodsname']) {
                        $this->data ['heading_title'] = $result ['goodsname'];
                    } else {
                        $this->data ['heading_title'] = '';
                    }

                    // 商品主图 $result['goodsimg']
                    if (isset($result ['goodsimg']) && $result ['goodsimg']) {
                        $this->data ['goodsimg'] = $result ['goodsimg'];
                    } else {
                        $this->data ['goodsimg'] = '';
                    }

                    // 商品价格 $result['price']
                    if (isset($result ['goodsprice'])) {
                        $this->data ['price'] = $result ['goodsprice'];
                    } else {
                        $this->data ['price'] = '';
                    }

                    // 颜色分类 $result['ean']
                    if (isset($result ['ean']) && $result ['ean']) {
                        $this->data ['ean'] = $result ['ean'];
                    } else {
                        $this->data ['ean'] = '';
                    }

                    // 尺码大小 $result['jan']
                    if (isset($result ['jan']) && $result ['jan']) {
                        $this->data ['jan'] = $result ['jan'];
                    } else {
                        $this->data ['jan'] = '';
                    }

                    // 店铺名称
                    if (isset($result ['storename']) && $result ['storename']) {
                        $this->data ['storename'] = $result ['storename'];
                    } else {
                        $this->data ['storename'] = '';
                    }

                    // 店铺地址
                    if (isset($result ['storeurl']) && $result ['storeurl']) {
                        $this->data ['storeurl'] = $result ['storeurl'];
                    } else {
                        $this->data ['storeurl'] = '';
                    }

                    // 国内运费
                    if (isset($result ['yunfei'])) {
                        $this->data ['isbn'] = $result ['yunfei'];
                    } else {
                        $this->data ['isbn'] = '';
                    }

                    
                    $this->template = 'cnstorm/template/order/make_zzg_business.tpl';

                    $this->children = array(
                        'common/header_cart',
                        'common/footer',
                        'common/uc_business');

                    $this->response->setOutput($this->render());
                } else if (false !== strpos($search, 'amazon.cn')) {

                    $result = array();

                    $html = $this->gethtmlcontent($search);

                    // 商品名
                    if (preg_match('#a-size-large\">(.*)<\/span>#isU', $html, $matches) || preg_match('#parseasinTitle\">(.*)<\/h1>#isU', $html, $matches)) {
                        $matches [0] = strip_tags($matches [1]);
                        if (!empty($matches [1]))
                            $date [0] = strip_tags($matches [1]);
                    }
                    // 图片地址
                    if (preg_match('#<div id=[\"|\']kib-ma-container-0[\"|\'][^>]+>(.*)</div>#isU', $html, $matches)) {
                        if (preg_match('#src=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['goodsimg'] = $matches [1];
                            }
                        }
                    } else if (preg_match('#<tr id=[\"|\']prodImageContainer[\"|\']>(.*)</tr>#isU', $html, $matches)) {

                        if (preg_match('#src=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['goodsimg'] = $matches [1];
                            }
                        }
                    } else if (preg_match('#<div class=[\"|\']main-image-inner-wrapper[\"|\']>(.*)</div>#isU', $html, $matches)) {

                        if (preg_match('#src=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['goodsimg'] = $matches [1];
                            }
                        }
                    } else if (preg_match('#<div id=[\"|\']imgTagWrapperId[\"|\'] class=[\"|\']imgTagWrapper[\"|\']>(.*)</div>#isU', $html, $matches)) {

                        if (preg_match('#data-a-dynamic-image=[\"|\'](.*)[\"|\']#isU', $matches [1], $matches)) {
                            if (preg_match('#http(.*)jpg#isU', $matches [1], $matches)) {
                                if (!empty($matches [1])) {
                                    $result ['goodsimg'] = 'http' . $matches [1] . 'jpg';
                                }
                            }
                        }
                    }

                    // 商品价格
                    if (preg_match('#id=\"priceblock_ourprice\"[^>]*>(.*)<\/span>#isU', $html, $matches) || preg_match('#priceLarge\"[^>]*>(.*)<\/b>#isU', $html, $matches) || preg_match('#id=\"listPriceValue\"[^>]*>(.*)<\/span>#isU', $html, $matches) || preg_match('#a-size-medium a-color-price offer-price a-text-normal\"[^>]*>(.*)<\/span>#isU', $html, $matches) || preg_match('#id=\"priceblock_saleprice\"[^>]*>(.*)<\/span>#isU', $html, $matches)) {
                        if (!empty($matches [1])) {
                            $matches [1] = str_replace('￥', '', $matches [1]);
                            $matches [1] = is_array($matches [1] = explode('-', $matches [1])) ? trim(end($matches [1]), ' ') : $matches [1];
                            $date [3] = $matches [1];
                        }
                    }
                    if (preg_match('#priceLarge kitsunePrice\"[^>]*>(.*)<\/b>#isU', $html, $matches)) {
                        $matches [1] = str_replace('￥', '', $matches [1]);
                        $matches [1] = is_array($matches [1] = explode('-', $matches [1])) ? trim(end($matches [1]), ' ') : $matches [1];
                        $date [3] = $matches [1];
                    }
                    // 商品颜色
                    if (preg_match_all('#<li id=\"color_name_[0-9]*\"[^>]*>(.*)<\/li>#isU', $html, $matches) || preg_match_all('#<div id=\"variation_color_name*\"[^>]*>(.*)<\/div>#isU', $html, $matches)) {

                        foreach ($matches [1] as $v) {
                            if (preg_match('#<img[^>]*alt=\"(.*)\"[^>]*>#isU', $v, $matches) || preg_match('#selection\">(.*)<\/span>#isU', $html, $matches)) {
                                if (!empty($matches [1]))
                                    $date [4] [] = $matches [1];
                            }
                        }
                    }
                    // 商品规格
                    if (preg_match_all('#<div class=[\"|\']swatchInnerText[\"|\'][^>]+>(.*)</div>#isU', $html, $matches) || (preg_match('#native_dropdown_selected_size_name\"[^>]*>(.*)<\/select>#isU', $html, $matches) && preg_match_all('#<option[^>]*>(.*)<\/option>#isU', $matches [1], $matches)) || preg_match_all('#<li id=\"size_name_[0-9]*\"[^>]*>(.*)<\/li>#isU', $html, $matches) || (preg_match('#a-spacing-top-micro swatches swatchesSquare\">(.*)<\/ul>#isU', $html, $matches) && preg_match_all('#<li[^>]*>(.*)<\/li>#isU', $matches [1], $matches))) {
                        if (!is_array($matches [1])) {
                            $date [5] = $matches [1];
                        } else {
                            if (array_search("选择", $matches [1], true) !== null)
                                unset($matches [1] [array_search("选择", $matches [1])]);
                            foreach ($matches [1] as $v) {
                                if (preg_match('#text\">(.*)<\/div>#isU', $v, $matches)) {
                                    if (!empty($matches [1])) {
                                        $matches [1] = strip_tags($v);
                                        $date [5] [] = $matches [1];
                                    }
                                } else {
                                    if (!empty($v)) {
                                        $matches [1] = strip_tags($v);
                                        $date [5] [] = $matches [1];
                                    }
                                }
                            }
                        }
                    }
                    // 商品运费
                    if (preg_match('#ddmMerchantMessage\">(.*)<\/span>#isU', $html, $matches) || preg_match('#a-size-base a-color-base\">(.*)<\/span>#isU', $html, $matches)) {
                        $matches [1] = strip_tags($matches [1]);
                        if (is_numeric($matches [1]))
                            if (!empty($matches [1]))
                                $date [6] = $matches [1];
                    }

                    // var_dump ( $date );

                    if (array_key_exists('0', $date) && $date [0])
                        $result ['goodsname'] = $date [0];

                    if (array_key_exists('3', $date) && $date [3])
                        $result ['goodsprice'] = $date [3];

                    if (array_key_exists('4', $date) && $date [4]) {

                        $result ['ean'] = $date [4];
                    }

                    if (array_key_exists('5', $date) && $date [5]) {
                        // unset( $date[5][array_search (" ", $date [5] )] );
                        //var_dump ( $date [5] );
                        $result ['jan'] = array_filter($date [5]);
                        //var_dump ( $date [5] );
                    }

                    if (array_key_exists('6', $date) && $date [6]) {

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
                    if (isset($result ['num_iid']) && $result ['num_iid']) {
                        $this->data ['num_iid'] = $result ['num_iid'];
                    } else {
                        $this->data ['num_iid'] = '';
                    }

                    // 商品名字 $result['goodsname']
                    if (isset($result ['goodsname']) && $result ['goodsname']) {
                        $this->data ['heading_title'] = $result ['goodsname'];
                    } else {
                        $this->data ['heading_title'] = '';
                    }

                    // 商品主图 $result['goodsimg']
                    if (isset($result ['goodsimg']) && $result ['goodsimg']) {
                        $this->data ['goodsimg'] = $result ['goodsimg'];
                    } else {
                        $this->data ['goodsimg'] = '';
                    }

                    // 商品价格 $result['price']
                    if (isset($result ['goodsprice'])) {
                        $this->data ['price'] = $result ['goodsprice'];
                    } else {
                        $this->data ['price'] = '';
                    }

                    // 颜色分类 $result['ean']
                    if (isset($result ['ean']) && $result ['ean']) {
                        $this->data ['ean'] = $result ['ean'];
                    } else {
                        $this->data ['ean'] = '';
                    }

                    // 尺码大小 $result['jan']
                    if (isset($result ['jan']) && $result ['jan']) {
                        $this->data ['jan'] = $result ['jan'];
                    } else {
                        $this->data ['jan'] = '';
                    }

                    // 店铺名称
                    if (isset($result ['storename']) && $result ['storename']) {
                        $this->data ['storename'] = $result ['storename'];
                    } else {
                        $this->data ['storename'] = '';
                    }

                    // 店铺地址
                    if (isset($result ['storeurl']) && $result ['storeurl']) {
                        $this->data ['storeurl'] = $result ['storeurl'];
                    } else {
                        $this->data ['storeurl'] = '';
                    }

                    // 国内运费
                    if (isset($result ['yunfei'])) {
                        $this->data ['isbn'] = $result ['yunfei'];
                    } else {
                        $this->data ['isbn'] = 0.00;
                    }

                    
                    $this->template = 'cnstorm/template/order/make_zzg_business.tpl';

                    $this->children = array(
                        'common/header_cart',
                        'common/footer',
                        'common/uc_business');


                    $this->response->setOutput($this->render());
                } else if (false !== strpos($search, 'jd.com')) {

                    $result = array();

                    $html = $this->gethtmlcontent($search);
                    $html = mb_convert_encoding($html, 'UTF-8', 'gb2312');

                    // 商品编号
                    if (preg_match('#jd.com/(.*).html#isU', $search, $matches)) {
                        // var_dump($matches);
                        if (!empty($matches)) {
                            $result ['num_iid'] = $matches [1];
                        }
                    }

                    // 商品名称
                    if (preg_match('#<h1>(.*)</h1>#isU', $html, $matches)) {
                        if (!empty($matches)) {
                            $result ['goodsname'] = strip_tags($matches [1]);
                        }
                    }

                    // 商品价格
                    if (isset($result ['num_iid']) && $result ['num_iid']) {
                        $price_url = 'http://p.3.cn/prices/get?skuid=J_' . $result ['num_iid'];
                        $price_html = $this->gethtmlcontent($price_url);

                        $p_price = explode(',', $price_html);
                        $price = explode(':', $p_price [1]);
                        $price = trim($price [1], '"');
                        $result ['goodsprice'] = trim($price, '"');
                    }

                    // 商品主图
                    if (preg_match('#jqimg=[\"|\'](.*)[\"|\']#isU', $html, $matches)) {
                        // var_dump($matches);
                        if (!empty($matches)) {
                            $result ['goodsimg'] = $matches [1];
                        }
                    } elseif (preg_match('#<img width=[\"|\']350[\"|\'] height=[\"|\']350[\"|\']  data-img=[\"|\']1[\"|\'] src=[\"|\'](.*)[\"|\'] alt=[\"|\'](.*)[\"|\']>#isU', $html, $matches)) {

                        if (!empty($matches)) {
                            $result ['goodsimg'] = $matches [1];
                        }
                    }

                    // 商品颜色
                    if (preg_match('#<li id=[\"|\']choose-color[\"|\'] class=[\"|\']choose-color-shouji[\"|\']>(.*)</li>#isU', $html, $matches)) {

                        if (preg_match_all('#<i>(.*)</i>#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['ean'] = $matches [1];
                            }
                        }
                    }

                    // 商品尺寸规格
                    if (preg_match('#<li id=[\"|\']choose-version[\"|\']>(.*)</li>#isU', $html, $matches)) {

                        if (preg_match_all('#<a[^>]+>(.*)</a>#isU', $matches [1], $matches)) {
                            if (!empty($matches)) {
                                $result ['jan'] = $matches [1];
                            }
                        }
                    }
                    $result ['yunfei'] = 0.00;

                    $result ['storename'] = "京东商城";

                    $result ['storeurl'] = "http://www.jd.com/";

                    if ($search) {
                        $this->data ['search'] = $search;
                    } else {
                        $this->data ['search'] = '';
                    }

                    // 商品编号 $result['num_iid']
                    if (isset($result ['num_iid']) && $result ['num_iid']) {
                        $this->data ['num_iid'] = $result ['num_iid'];
                    } else {
                        $this->data ['num_iid'] = '';
                    }

                    // 商品名字 $result['goodsname']
                    if (isset($result ['goodsname']) && $result ['goodsname']) {
                        $this->data ['heading_title'] = $result ['goodsname'];
                    } else {
                        $this->data ['heading_title'] = '';
                    }

                    // 商品主图 $result['goodsimg']
                    if (isset($result ['goodsimg']) && $result ['goodsimg']) {
                        $this->data ['goodsimg'] = $result ['goodsimg'];
                    } else {
                        $this->data ['goodsimg'] = '';
                    }

                    // 商品价格 $result['price']
                    if (isset($result ['goodsprice'])) {
                        $this->data ['price'] = $result ['goodsprice'];
                    } else {
                        $this->data ['price'] = '';
                    }

                    // 颜色分类 $result['ean']
                    if (isset($result ['ean']) && $result ['ean']) {
                        $this->data ['ean'] = $result ['ean'];
                    } else {
                        $this->data ['ean'] = '';
                    }

                    // 尺码大小 $result['jan']
                    if (isset($result ['jan']) && $result ['jan']) {
                        $this->data ['jan'] = $result ['jan'];
                    } else {
                        $this->data ['jan'] = '';
                    }

                    // 店铺名称
                    if (isset($result ['storename']) && $result ['storename']) {
                        $this->data ['storename'] = $result ['storename'];
                    } else {
                        $this->data ['storename'] = '';
                    }

                    // 店铺地址
                    if (isset($result ['storeurl']) && $result ['storeurl']) {
                        $this->data ['storeurl'] = $result ['storeurl'];
                    } else {
                        $this->data ['storeurl'] = '';
                    }

                    // 国内运费
                    if (isset($result ['yunfei'])) {
                        $this->data ['isbn'] = $result ['yunfei'];
                    } else {
                        $this->data ['isbn'] = '';
                    }

                    $this->template = 'cnstorm/template/order/make_zzg_business.tpl';

                    $this->children = array(
                        'common/header_cart',
                        'common/footer',
                        'common/uc_business');

                    $this->response->setOutput($this->render());
                } else {

                    $this->document->setTitle($this->language->get('text_error'));

                    $this->data['heading_title'] = $this->language->get('text_error');

                    $this->data['text_error'] = $this->language->get('text_error');

                    $this->data['button_continue'] = $this->language->get('button_continue');

                    $this->data['continue'] = $this->url->link('common/home');

                    $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');


                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/snatch_noresults.tpl')) {

                        $this->template = $this->config->get('config_template') . '/template/error/snatch_noresults.tpl';
                    } else {
                        $this->template = 'cnstorm/template/error/snatch_noresults.tpl';
                    }

                    $this->children = array(
                        'common/column_left',
                        'common/footer',
                        'common/header'
                    );


                    $this->response->setOutput($this->render());

                    $this->redirect($this->url->link('order/snatch', '', 'SSL'));
                }
            }
        } else {

            $this->template = 'cnstorm/template/order/make_zzg_business.tpl';

            $this->children = array(
                'common/header_cart',
                'common/footer',
                'common/uc_business');

            $this->response->setOutput($this->render());
        }
    }

    /**     * ************************************************************************************* 
     *  @function：定义函数gethtmlcontent()用于通过url获取整个网页内容 

     *  @param： string $url 参数为输入的url地址 

     *  @return： string $html 返回整个网页内容 

     *  @author： kennewei<wk@cnstorm.com> 

     *  @date: 2014.8.19 
     * ******************************************************************** */
    protected function gethtmlcontent($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置URL，可以放入curl_init参数中
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1");
        // 设置UA
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。 如果不加，即使没有echo,也会自动输出
        $content = curl_exec($ch);
        // 执行
        curl_close($ch);

        return $content;
    }

    /**     * *************************************************************************************
     * @function：定义函数getcolorsizeinfo()用于通过淘宝API接口获取单件商品的颜色尺寸对应的价格

     * @param：   string $key  参数为该单件商品选定的颜色尺寸键值

     * @return：  json  $data  返回该单件商品的价格

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.5.15
     * ************************************************************************************** */
    public function getcolorsizeinfo() {
        $size = '';

        $color = '';

        $data = array();

        if (isset($this->request->post['size'])) {
            $size = trim($this->request->post['size']);
            $size = htmlspecialchars_decode($size);
        }
        if (isset($this->request->post['color'])) {
            $color = trim($this->request->post['color']);
            $color = htmlspecialchars_decode($color);
        }

        //var_dump($size);
        //var_dump($color);

        $color = str_replace('_', ':', $color);

        $color_number = $this->session->data['color_number'];

        $color = $color_number[$color];

        $size = str_replace('_', ':', $size);

        $size_number = $this->session->data['size_number'];

        $size = $size_number[$size];

        $size_color_price = $this->session->data['size_color_price'];

        //var_dump($size_color_price);

        $key = $size . '_' . $color;

        $data['price'] = $size_color_price[$key];

        $this->response->setOutput(json_encode($data));
    }

    /*     * *************************************************************************************
     * @funtion：定义函数getcolorsizeinfo()用于通过淘宝API接口获取单件商品的选择颜色对应的尺寸

     * @param：   string $key  参数为该单件商品选定的颜色

     * @return：  json  $data  返回该单件商品的缺失尺寸

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.5.15
     * *************************************************************************************** */

    public function getsizeinfo() {


        $color = '';

        $data = array();

        $size_array = array();

        if (isset($this->request->post['color'])) {
            $color = trim($this->request->post['color']);
            $color = htmlspecialchars_decode($color);
        }

        $color_number = $this->session->data['color_number'];

        //var_dump($color_number);

        $color = str_replace('_', ':', $color);

        $color = $color_number[$color];

        //var_dump($color);
        //var_dump($size_color_price);

        $quantity = $this->session->data['quantity'];

        //var_dump($quantity);

        $size_value = $this->session->data['size'];

        $size_number = $this->session->data['size_number'];

        $color_number = $this->session->data['color_number'];

        $size_array = explode(',', $size_value);

        //var_dump($size_array);

        foreach ($size_array as $size) {

            if (!array_key_exists($size . '_' . $color, $quantity) || $quantity[$size . '_' . $color] < 0) {
                $getSize = array_keys($size_number, $size);
                $data[] = str_replace(':', '_', $getSize[0]);
            }
        }

        //var_dump($data);
        $this->response->setOutput(json_encode($data));
    }

    /*     * **********************************************************************************
     * @function：定义函数getcolorinfo()用于通过淘宝API接口获取单件商品的选择尺寸对应的颜色

     * @param：   string $key  参数为该单件商品选定的尺寸

     * @return：  json  $data  返回该单件商品的缺失颜色

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.5.15
     * ********************************************************************************** */

    public function getcolorinfo() {

        //var_dump("weikun");
        $size = '';

        $data = array();

        $color_array = array();

        if (isset($this->request->post['size'])) {
            $size = trim($this->request->post['size']);
            $size = htmlspecialchars_decode($size);
        }

        $size = str_replace('_', ':', $size);

        $size_number = $this->session->data['size_number'];

        $size = $size_number[$size];

        //var_dump($size);
        // $size_color_price = $this->session->data['size_color_price'];

        $quantity = $this->session->data['quantity'];

        //var_dump($size_color_price);

        $color_value = $this->session->data['color'];

        $color_number = $this->session->data['color_number'];

        $color_array = explode(',', $color_value);

        foreach ($color_array as $color) {
            if (!array_key_exists($size . '_' . $color, $quantity) || $quantity[$size . '_' . $color] < 0) {
                $getColor = array_keys($color_number, $color);
                $data[] = str_replace(':', '_', $getColor[0]);
            }
        }

        $this->response->setOutput(json_encode($data));
    }

    /*     * *************************************************************************************
     * @funtion：定义函数getimg()用于通过淘宝API接口获取单件商品的选择颜色对应的主图URL地址

     * @param：   string $key  参数为该单件商品选定的颜色代码

     * @return：  json  $data  返回该单件商品的选择颜色对应的主图URL地址

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.5.17
     * *************************************************************************************** */

    public function getimg() {
        $color = '';

        $data = '';

        $color_number = array();

        if (isset($this->request->post['color'])) {
            $color = trim($this->request->post['color']);
            $color = htmlspecialchars_decode($color);
        }

        $color_number = $this->session->data['color_number'];

        //var_dump($color_number);

        $color = str_replace('_', ':', $color);

        $color = $color_number[$color];


        //var_dump($color_number);
        $getColor = array_keys($color_number, $color);
        $color_num = $getColor[0];

        $result = $this->session->data['img_color'];

        //var_dump($color_num);
        // var_dump($result); 
        if (array_keys($result, $color_num))
            $data = $result[$color_num];
        else
            $data = $result;
        $this->response->setOutput(json_encode($data));
    }

    //ajax 刷新淘宝订单数据
    public function ajax_taobao_order() {
        
        $this->load->model('order/order');
		if(isset($this->session->data['customer_id'])){
			$username_id = $this->session->data['customer_id'];
		}else{
			$username_id =0;
		}
        if (isset($this->request->post['heading_title'])) {
            $heading_title = $this->request->post['heading_title'];
        } else {
            $heading_title = null;
        }


        if (isset($this->request->post['price'])) {
            $price = $this->request->post['price'];
        } else {
            $price = null;
        }

        if (isset($this->request->post['searchfreight'])) {
            $searchfreight = $this->request->post['searchfreight'];
        } else {
            $searchfreight = null;
        }

        if (isset($this->request->post['qty'])) {
            $qty = $this->request->post['qty'];
        } else {
            $qty = null;
        }

        if (isset($this->request->post['remark'])) {
            $remark = $this->request->post['remark'];
        } else {
            $remark = null;
        }

        if (isset($this->request->post['seller'])) {
            $seller = $this->request->post['seller'];
        } else {
            $seller = null;
        }

        if (isset($this->request->post['color'])) {
            $color = $this->request->post['color'];
        } else {
            $color = null;
        }

        if (isset($this->request->post['size'])) {
            $size = $this->request->post['size'];
        } else {
            $size = null;
        }


        if (isset($this->request->post['Shop_id'])) {
            $Shop_id = $this->request->post['Shop_id'];
        } else {
            $Shop_id = null;
        }

        if (isset($this->request->post['img'])) {
            $img = $this->request->post['img'];
        } else {
            $img = null;
        }


        if (isset($this->request->post['storename'])) {
            $storename = $this->request->post['storename'];
        } else {
            $storename = null;
        }

        if (isset($this->request->post['producturl'])) {
            $producturl = $this->request->post['producturl'];
        } else {
            $producturl = null;
        }

        if (isset($this->request->post['storeurl'])) {
            $storeurl = $this->request->post['storeurl'];
        } else {
            $storeurl = null;
        }

//张力升链接转换框架V1.0 beta, 淘宝/Tmall链接识别
        /* $url_info = parse_url($producturl);

          parse_str($url_info['query'], $param);
          if (false !== strpos($producturl, 'taobao.com') || false !== strpos($producturl, 'tmall.com')) {

          if (!$param['id'] && $param['tradeID'])
          $param['id'] = $param['tradeID'];
          if (!$param['id'] && $param['meal_id'])
          $param['id'] = $param['meal_id'];

          $product_id = $param['id'];
          } */

        $data_product = array(
            'producturl' => $producturl,
            'heading_title' => $heading_title,
            'price' => $price,
            'searchfreight' => $searchfreight,
            'color' => $color,
            'size' => $size,
            'qty' => $qty,
            'time' => time(),
            'seller' => $seller,
            'remark' => $remark,
            'img' => $img,
            'storename' => $storename,
            'storeurl' => $storeurl,
            'custom_id' =>  $username_id
        );
        
        if (isset($this->request->post['heading_title'])) {
            $taobao_product_id = $this->model_order_order->insert_zizhu($data_product);
			    if(!$this->customer->getId()){
					 if(isset($_COOKIE['taobao_id'])){
						if(!empty($_COOKIE['taobao_id'])){
							$temp = $_COOKIE['taobao_id'];
							setcookie('taobao_id',$temp.",$taobao_product_id");
						}
					}else{
						setcookie('taobao_id',$taobao_product_id); 
					}	
				}
			$this->response->setOutput(1);
        }
    }

    /*     * *************************************************************************************
     * @funtion：定义函数gaddorder_self()用于将自助购中的商品数据插入订单表生成订单，

      成功插入后删除自助够中的商品

     * @return：  json  $data  返回插表操作是否成功

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.6.27
     * *************************************************************************************** */

    public function addorder_self() {
        $storename_array = array();

		if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
		
		
        $this->load->model('order/order');

        $custom_id = $this->customer->getId();

        $self_products = $this->model_order_order->get_selfproduct();

        foreach ($self_products as $self_product) {
            $storename_array[$self_product['store_url']] = $self_product['store_name'];

            $storename_array = array_unique($storename_array);
        }

        foreach ($storename_array as $storeurl => $storename) {

            $data = array();

            $product_data = array();

            $data['invoice_prefix'] = $this->config->get('config_invoice_prefix');

            $data['store_id'] = $this->config->get('config_store_id');

            $data['storename'] = $storename;

            $data['storeurl'] = $storeurl;

            if ($this->customer->isLogged()) {

                $data['customer_id'] = $this->customer->getId();

                $data['customer_group_id'] = $this->customer->getCustomerGroupId();

                $data['firstname'] = $this->customer->getFirstName();

                $data['lastname'] = $this->customer->getLastName();

                $data['email'] = $this->customer->getEmail();

                $data['telephone'] = $this->customer->getTelephone();

                $data['money'] = $this->customer->getMoney();
            } elseif (isset($this->session->data['guest'])) {

                $data['customer_id'] = 0;

                $data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];

                $data['firstname'] = $this->session->data['guest']['firstname'];

                $data['lastname'] = $this->session->data['guest']['lastname'];

                $data['email'] = $this->session->data['guest']['email'];

                $data['telephone'] = $this->session->data['guest']['telephone'];

                $data['money'] = $this->session->data['guest']['money'];
            }

            //店铺地址
            $data['order_cul_home'] = $storeurl;

            $data['order_shipping'] = '';

            $data['total'] = '';

            foreach ($self_products as $product) {
                if ($product['store_name'] == $storename) {


                    $product_data[] = array(
                        'product_id' => '',
                        'producturl' => $product['producturl'],
                        'model' => '',
                        'download' => '',
                        'subtract' => '',
                        'total' => 0.00,
                        'name' => $product['product_name'],
                        'quantity' => $product['qty'],
                        'color' => $product['color'],
                        'size' => $product['size'],
                        'price' => $product['price'],
                        'note' => $product['remark'],
                        'source' => 0,
                        'img' => $product['img']
                    );
                }
            }

            $data['products'] = $product_data;

            $data['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {

                $data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {

                $data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {

                $data['forwarded_ip'] = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {

                $data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {

                $data['user_agent'] = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {

                $data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {

                $data['accept_language'] = '';
            }

            //订单购买状态，默认 1:代购 2:自助   3:代寄
            $data['order_status_buy'] = 2;
            //订单状态 3 待发货
            $data['order_status_id'] = 3;

            $this->load->model('checkout/order');


            $self_order = $this->model_checkout_order->addOrder($data);


            if ($self_order) {
                $this->model_order_order->del_selfproduct();

                $this->response->setOutput(1);
            } else {
                $this->response->setOutput(0);
            }
        }
    }

    /*     * *************************************************************************************
     * @funtion：定义函数del_one_selfproduct用于将自助购中的商品数据插入订单表生成订单，

      成功插入后删除自助够中的商品

     * @return：  json  $data  返回插表操作是否成功

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.6.27
     * *************************************************************************************** */

    public function del_one_selfproduct() {
        $this->load->model('order/order');
	
        if (isset($this->request->post['id']) && $this->request->post['id']) {

            $id = $this->request->post['id'];

            $data = array(
                'id' => $id
            );
		if (isset($this->request->post['type']) && $this->request->post['type']) {
				$type = $this->request->post['type'];
			}else{
				$type="";
			}
			
            $this->model_order_order->del_one_selfproduct($data);
			if($type=='cookie'){
				if($_COOKIE['taobao_id']){
					$uTaobao_id=$_COOKIE['taobao_id'];
					$arrTaobao_id=explode(',',$uTaobao_id);
					for($i=0;$i<count($arrTaobao_id);$i++){
						if($arrTaobao_id[$i]==$id ){
							unset($arrTaobao_id[$i]);
						}
					}
					setcookie('taobao_id',implode(',',$arrTaobao_id));
				}
			}
            echo "1";
        }

        echo "0";
    }

}

?>
