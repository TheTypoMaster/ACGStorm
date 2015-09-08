<?php
class TAOBAO
{
    static function getrecommend($num_iid)
    {
        include_once(DIR_SYSTEM.'/taobao/TopSdk.php');
        $c            = new TopClient;
        $c->appkey    = '21423039';
        $c->secretKey = '35cf898ea5182b72ad9ad9955c8294f4';
        $req          = new ItemrecommendItemsGetRequest;
        $req->setItemId($num_iid);
        $req->setRecommendType(1);
        $req->setCount(5);
        $resp = $c->execute($req);
        return $resp;
    }
    
    static function getItemInfo($param)
    {
        include_once( DIR_SYSTEM.'/taobao/TopSdk.php');
	$param['id'] = isset($param['id'])?$param['id']:null;
        try {
            $c            = new TopClient;
            $c->appkey    = '21423039';
            $c->secretKey = '35cf898ea5182b72ad9ad9955c8294f4';
            $req          = new ItemGetRequest;
            $req->setFields("detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_url,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual");                 
            $req->setNumIid($param['id']);
            $c->format = 'json';
            $resp      = $c->execute($req);
        }
        catch (Exception $e) {
            //echo $e->getMessage();
            $resp = array();
        }
        
       //var_dump($resp);
        
        //exit;
        if(array_key_exists('item',$resp))
        {
       
        
        $resa = $resp['item'];
        //$resa = $resp->item;
        
        //var_dump($resa['desc']);

        //var_dump($resp['item']);exit;
        
        //宝贝所属的运费模板ID，如果没有返回则说明没有使用运费模板:0
        $postage_id = $resa['postage_id'];
        //卖家昵称
        $nick       = $resa['nick'];
        
        $detail_url   =  $resa['detail_url'];
        
        if(false !== strpos($detail_url,'taobao.com'))
    	{
    			     //商城名
    		$result['model'] = urlencode("淘宝网");
   	    }
        else if(false !== strpos($detail_url,'tmall.com'))
	    {
    			      //商城名
             $result['model'] = urlencode("天猫网");
        }
        //var_dump($detail_url );
        //add by weikun 返回主图及其属性图
        $item_img = array();
        //var_dump($resa['item_imgs']);
        if(array_key_exists('item_imgs',$resa))
        {
            if(array_key_exists('item_img',$resa['item_imgs']) && !empty($resa['item_imgs']['item_img']))
            {
                foreach($resa['item_imgs']['item_img'] as $item_img_value)
                {
                    $item_img[$item_img_value['position']] = $item_img_value['url'];
                }
            }
        }
        
       
        //
        //$alias['1627207:3232483'] = 20471#黑色(蝴蝶结);
        //end
        //var_dump($alias);exit;
        //var_dump($resa['prop_imgs']['prop_img']);
        $size      = array();
        $color     = array();
        $price     = array();
        $images    = array();
        $img_color = array();
        $img_data  = array();
        //带编码的尺寸数组和颜色数组
        $size_number = array();
        $color_number = array();
        
         //add by weikun  返回商品颜色数组
        $alias          = array();
        $property_alias = explode(';', $resa['property_alias']);
        foreach ($property_alias as $one) {
            if (substr($one, strrpos($one, ':') + 1))
                $alias[substr($one, 0, strrpos($one, ':'))] = substr($one, strrpos($one, ':') + 1);
                //$color[] = $alias[substr($one, 0, strrpos($one, ':'))];   
                //var_dump(substr($one, strrpos($one, ':') + 1));
                //var_dump(substr($one, 0, strrpos($one, ':')));
        }
        //var_dump($alias);
        //var_dump($property_alias);
        //商品属性图片列表
        //var_dump($resa['prop_imgs']);
       
        if(array_key_exists('prop_imgs',$resa))
        {
            $prop_imgs = $resa['prop_imgs']['prop_img'];
        }
       
            if(array_key_exists('desc',$resa))
            {
                $str = $resa['desc'];
                $reg = '/((http|https):\/\/)+(\w+\.)+(\w+)[\w\/\.\-]*(jpg)/';
                /*$reg = '/<img src=\"(.+?)\".*?>/';*/
                $matches = array();
                preg_match_all($reg, $str, $matches);
                foreach ($matches[0] as $value) {
                    $img_data[] = $value;
                }
                //去掉指定元素
                $img_data = array_unique($img_data);
                $key = array_keys($img_data,"http://img03.taobaocdn.com/imgextra/i3/224060577/T2C5K4XudXXXXXXXXX-224060577.jpg");
                $key1 = array_keys($img_data,"http://img03.taobaocdn.com/imgextra/i3/T2E4BNXfRbXXXXXXXX-350475995.jpg");
                $key2 = array_keys($img_data,"http://img02.taobaocdn.com/imgextra/i2/T2ojdSXeFcXXXXXXXX-350475995.jpg");
                $key3 = array_keys($img_data,"http://img04.taobaocdn.com/imgextra/i4/T2yz4SXjXXXXXXXXXX-350475995.jpg");
                if(array_key_exists('0',$key) && $key[0])
                {
                    unset($img_data[$key[0]]);
                }
                
                if(array_key_exists('0',$key) && $key[0])
                {
                    unset($img_data[$key1[0]]);
                }
                
                if(array_key_exists('0',$key) && $key[0])
                {
                    unset($img_data[$key2[0]]);
                }
                
                if(array_key_exists('0',$key) && $key[0])
                {
                    unset($img_data[$key3[0]]);
                }
                //var_dump($img_data);
                
            }
       
       
        
        //库存量
        $quantity  = array();
        //var_dump($resa['skus']);//exit;
        //sku列表
        if(array_key_exists('skus',$resa) && $resa['skus'])
        {
        $skus = $resa['skus'];
        //var_dump($skus);
        foreach ($skus as $_one) {
            foreach ($_one as $one) {
                $_size = '';
                $_s = array();
                $_color = '';
                if ($one['quantity'] <= 0)
                    continue;
                $properties_name = explode(';', $one['properties_name']);
                if(array_key_exists('1',$properties_name) && $properties_name[1])
                {
                       $_s  = explode(':', $properties_name[1]);
                    
                    //if (array_key_exists('$_s[0] . \':\' . $_s[1]',$alias) &&  $alias[$_s[0] . ':' . $_s[1]])
                   
                        if (!empty($alias) && array_key_exists($_s[0] . ':' . $_s[1],$alias) && $alias[$_s[0] . ':' . $_s[1]])
                        {
                        //echo "weikun";
                             $_size = $size_number[$_s[0] . ':' . $_s[1]] = $size[] = $alias[$_s[0] . ':' . $_s[1]];
                        }
                        else
                        {
                       //echo "weikun2";
                             $_size = $size_number[$_s[0] . ':' . $_s[1]] = $size[] = $_s[3]; 
                        }
                   
                    
                        
                }
                //add byweikun 获取颜色数组
                if(array_key_exists('0',$properties_name) &&  $properties_name[0])
                {    
                    $_s = explode(':', $properties_name[0]);
                    //var_dump($alias[$_s[0] . ':' . $_s[1]]);
                    
                    //if (array_key_exists('$_s[0] . \':\' . $_s[1]',$alias) && $alias[$_s[0] . ':' . $_s[1]])
                    //var_dump($alias);
                    //$flag = array_key_exists($_s[0] . ':' . $_s[1],$alias);
                    //var_dump($flag);
                    //var_dump($_s[0] . ':' . $_s[1]);
                    
                        if (!empty($alias) && array_key_exists($_s[0] . ':' . $_s[1],$alias) && $alias[$_s[0] . ':' . $_s[1]])
                        {
                            //echo "weikun";
                            $_color = $color_number[$_s[0] . ':' . $_s[1]] = $color[] = $alias[$_s[0] . ':' . $_s[1]];
                        }
                        else
                        {
                            //echo "weikun2";
                            $_color = $color_number[$_s[0] . ':' . $_s[1]] = $color[] = $_s[3];
                        }
                    
                    
                }
                //$one    = explode(';',$one['properties']);
                //$size[] = $alias[$one[1]];
                //$color[]= $alias[$one[0]];
                $price[$_size . '_' . $_color]    = $one['price'];
                
                $quantity[$_size . '_' . $_color] = $one['quantity'];
			
                if(isset($prop_imgs))
                {
                    foreach ($prop_imgs as $_img) {
                    if ($_img['properties'] == $_s[0] . ':' . $_s[1]) {
                        $images[$_color] = $_img['url'];
                        $img_color[$_s[0] . ':' . $_s[1]] = $_img['url'];
                    }
                }
                
                }
			
            }
        }
        }
        //var_dump($price);
        $result['num_iid']    = $param['id'];
        $result['goodsname']  = $resa['title'];
        $result['goodsprice'] = $resa['price'];
        $result['oldprice'] = $resa['price'];
        //echo $result['goodsprice'];
        //exit;
        //sleep(3);
        try {
            $c            = new TopClient;
            $c->appkey    = '21423039';
            $c->secretKey = '35cf898ea5182b72ad9ad9955c8294f4';
            $req          = new UmpPromotionIncrementGetRequest;
            $req->setItemId($param['id']);
            $c->format    = 'json';
            $resPromotion = $c->execute($req);
        }
        catch (Exception $e) {
            $resPromotion = array();
        }
        
        //var_dump($resPromotion);
	if (!empty($resPromotion)){
        	$resp = $resPromotion['promotions']['promotion_in_item'];
	}else{
		$resp = '';
	}
        
        /*if (empty($resp['promotion_in_item'])){
        var_dump("fuckoff");
        }else{var_dump("success");}*/
        //var_dump($resPromotion['promotions']);
        
		//var_dump($resPromotion);exit;
        
        //var_dump($resp[0]['sku_price_list']);
        //print_r($resp);
        //var_dump(gettype($resp));
        //var_dump($resp);
        //var_dump(empty($resp));
        if(!empty($resp))
        {
            foreach ($resp as $_one) {
               //var_dump(gettype($_one));
               //var_dump($_one);
               //exit;
               if(is_array($_one) && array_key_exists('item_promo_price',$_one) && $_one['item_promo_price'])
                {  
                    //echo "ko";
                   $result['goodsprice'] = $_one['item_promo_price'];
                }
                else
                {
                    //echo "weikun";
                    foreach ($_one as $one) {
                    //var_dump(gettype($one));
                    //var_dump($one);
                   
                    if(is_array($one))
                    {
                        //var_dump(array_key_exists('0',$one) && $one[0]);
                        if (array_key_exists('0',$one) && $one[0])
                        {
                            if (array_key_exists('item_promo_price',$one[0]) && $one[0]['item_promo_price'])
                            $result['goodsprice'] = $one[0]['item_promo_price'];
                        }
                        else if(array_key_exists('item_promo_price',$one) && $one['item_promo_price'])
                        {
                            $result['goodsprice'] = $one['item_promo_price'];
                        }
                    }
               
                 }
               }
              
          }
        }
        
        
		//var_dump($result['goodsprice']);
        $sku_price  = array();
        /*
        $prop_price = array();
        for($i=0;$i<count($skus['sku']);$i++)
        {
           $prop_price[] = $skus['sku'][$i]['price'];
        }
        */
        //var_dump($resp);
        //var_dump($prop_price);
        //var_dump($skus);
        //var_dump($resp);
        //var_dump("weikun");
        //var_dump(($resp['promotion_in_item']));
        if (empty($resp['promotion_in_item']) ) {
            /*
            $prop_price = $skus['sku']['price'];
            foreach ($prop_price as $_price) {
                if ($_price['properties'] == $_s[0] . ':' . $_s[1]) {
                    $price[$_color] = $_price['price'];
                   
                }
            }
            $result['price'] = json_encode($price);
            */
            //var_dump($price);
            $result['price'] = json_encode($price);
        } else {
            
            //var_dump($resPromotion['promotions']['promotion_in_item']['promotion_in_item']);
            if(array_key_exists('sku_id_list',$resPromotion['promotions']['promotion_in_item']['promotion_in_item'][0]) && $resPromotion['promotions']['promotion_in_item']['promotion_in_item'][0]['sku_id_list'])
            {
                foreach ($resPromotion['promotions']['promotion_in_item']['promotion_in_item'][0]['sku_id_list']['string'] as $key => $skuid) {
                    $sku_price[$skuid] = $resPromotion['promotions']['promotion_in_item']['promotion_in_item'][0]['sku_price_list']['price'][$key];
                }      
                //var_dump($sku_price[$skuid]);
                $size_color_price = array();
                foreach ($skus as $_one) {
                    foreach ($_one as $one) {
                        $_color = '';
                        $_size = '';
                        //var_dump($alias);
                        if ($one['quantity'] <= 0)
                            continue;
                        $properties_name = explode(';', $one['properties_name']);
                         if(array_key_exists('1',$properties_name) && $properties_name[1])
                         {
                            $_s              = explode(':', $properties_name[1]);
                            
                            //if (array_key_exists('$_s[0] . \':\' . $_s[1]',$alias) && $alias[$_s[0] . ':' . $_s[1]])
                        
                                if (!empty($alias) && array_key_exists($_s[0] . ':' . $_s[1],$alias) && $alias[$_s[0] . ':' . $_s[1]])
                                    $_size = $size_number[$_s[0] . ':' . $_s[1]] = $size[] = $alias[$_s[0] . ':' . $_s[1]];
                                else
                                    $_size = $size_number[$_s[0] . ':' . $_s[1]] = $size[] = $_s[3];
                            
                            
                        }
                         if(array_key_exists('0',$properties_name) &&  $properties_name[0])
                        {    
                            $_s = explode(':', $properties_name[0]);
                            //if (array_key_exists('$_s[0] . \':\' . $_s[1]',$alias) && $alias[$_s[0] . ':' . $_s[1]])
                          
                                 if (!empty($alias) && array_key_exists($_s[0] . ':' . $_s[1],$alias) && $alias[$_s[0] . ':' . $_s[1]])
                                    $_color = $color_number[$_s[0] . ':' . $_s[1]] = $color[] = $alias[$_s[0] . ':' . $_s[1]];
                                 else
                                    $_color = $color_number[$_s[0] . ':' . $_s[1]] = $color[] = $_s[3];
                            
                           
                        }
                         
                        if(array_key_exists((string)$one['sku_id'],$sku_price))
                        $size_color_price[$_size . '_' . $_color] = $sku_price[(string)$one['sku_id']] ? $sku_price[(string)$one['sku_id']] : $resa['price']; //$one['price'];
                        
                    }
                }
                //var_dump($sku_price);
                //var_dump($size_color_price);
                
                $result['price'] = json_encode($size_color_price);
            }
            else
            {
                $result['price'] = json_encode($price);
            }
        }
        
		//var_dump($resPromotion['promotions']['promotion_in_item']['promotion_in_item'][0]['sku_id_list']['string']);
        //var_dump($postage_id);
        try {
            $c            = new TopClient;
            $c->appkey    = '21786321';
            $c->secretKey = '1bdf8c31c8e4cc19603e16c4ed6fe767';
            $req          = new DeliveryTemplateGetRequest;
            $req->setTemplateIds($postage_id);
            $req->setFields("query_express");
            $req->setUserNick($nick);
            $c->format    = 'json';
            $resYunfei = $c->execute($req);
        }
        catch (Exception $e) {
            $resYunfei = array();
        }
        
        //var_dump($resYunfei['delivery_templates']['delivery_template'][0]['fee_list']['top_fee']);
        
        $fee_array = array();
        $fee_value = 0;
        if(array_key_exists('delivery_templates',$resYunfei) && isset($resYunfei['delivery_templates']['delivery_template'][0]['fee_list']['top_fee']))
        {   
            foreach($resYunfei['delivery_templates']['delivery_template'][0]['fee_list']['top_fee'] as $value)
            {
                $fee_array[] = $value;
            }
        }
        
        for($i=0;$i<count($fee_array);$i++)
        {
            //var_dump($fee_array[$i]);
            //var_dump($fee_array[$i]['destination']);
            if(false !== strpos($fee_array[$i]['destination'],"440000"))
            {
                $fee_value = $fee_array[$i]['start_fee'];
                break;
            }
            
            $fee_value = $fee_array[0]['start_fee'];
        }
        //var_dump($images);
        //var_dump($img_data);
        
        if($img_data)
        {
            $result['prop_imgs']   = json_encode($img_data); 
        }
        else
        {
            $result['prop_imgs']   = json_encode($images);
        }
        
        
        try {
            $c = new TopClient;
            $c->appkey = '21423039';
            $c->secretKey = '35cf898ea5182b72ad9ad9955c8294f4';
            $req = new ShopGetRequest;
            $c->format    = 'json';
            $req->setFields("sid,title");
            $req->setNick($nick);
            $resStore = $c->execute($req);
        }
        catch (Exception $e) {
            $resStore = array();
        }
        
        
        //商品所属店铺的编号
        $sid = '';
        //商品所属店铺的名字
        $title = '';
        
        if(array_key_exists('shop',$resStore) && $resStore['shop'])
        {
            if(array_key_exists('sid',$resStore['shop']) && $resStore['shop']['sid'])
            {
                
                $sid = $resStore['shop']['sid'];
            }
            
            if(array_key_exists('title',$resStore['shop']) && $resStore['shop']['title'])
            {
                $title = $resStore['shop']['title'];
            }
        }
        
        
        try {
                $c = new TopClient;
                $c->appkey = '21423039';
                $c->secretKey = '35cf898ea5182b72ad9ad9955c8294f4';
                $c->format    = 'json';
                $req = new ItemrecommendItemsGetRequest;
                $req->setItemId($param['id']);
                $req->setRecommendType(1);
                $req->setCount(5);
                $recommended = $c->execute($req);
           }
           catch (Exception $e) {
               $recommended = array();
           }
        
        
        
        if(array_key_exists('values',$recommended) && $recommended['values'])
        {
            if(array_key_exists('favorite_item',$recommended['values']) && $recommended['values']['favorite_item'])
            {
                
                $recommend = $recommended['values']['favorite_item'];
                for($i=0;$i<count($recommend);$i++)
                {
                   // var_dump($recommend);
                     $url =  explode("_",$recommend[$i]['track_iid']);
                     
                    $recommend[$i]['item_url'] = "http://item.taobao.com/item.htm?id=".$url[0];
                }
                //var_dump($recommend);
                $result['recommended'] = json_encode($recommend);
                
                
            }
        }
        
        
        //$result['prop_imgs']   = json_encode($img_data);
        
        //var_dump($result['prop_imgs']);
        $color                 = array_unique($color);
        $size                  = array_unique($size);
        $result['img_color']   = json_encode($img_color);
        $result['goodsimg']    = $resa['pic_url'];
        $result['goodsseller'] = $resa['nick'];
        $result['sellerurl']   = base64_encode('http://www.taobao.com/webww/?ver=1&touid=cntaobao' . urlencode($resa['nick']) . '&siteid=cntaobao&status=2');
        $result['storeurl']    = 'http://shop' .$sid. '.taobao.com';
        $result['mstoreurl']    = 'http://shop' .$sid. '.m.taobao.com';
        $result['storename']   = $title;
        $result['kucun']       = $resa['num'];
        $result['color_number']       = json_encode($color_number);
        $result['size_number']        = json_encode($size_number);
        $result['color']       = join(',', $color);
        $result['size']        = join(',', $size);
        //var_dump($quantity);
        $result['quantity']    = json_encode($quantity);
        $result['yunfei']      = $fee_value;
        $result['item_imgs']   = json_encode($item_img);
        //var_dump($size);
        return $result;
        }
    }
}