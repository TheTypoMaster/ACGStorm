<?php

/**
 * @description：插件
 * @author：fc@cnstorm.com
 * @date：2014-8-25
 */
Class ControllerPluginCnstormassist extends Controller {

    public function add() {
        if (isset($this->session->data['customer_id'])) {
            $customer_id = $this->session->data['customer_id'];
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomer($customer_id);
            $firstname = $customer['firstname'];
        } else {
            $customer_id = 0;
            $firstname = '';
        }

        $name = $this->request->post['title'];//商品名称
        $price = $this->request->post['price'];//价格
        $freight = $this->request->post['freight'];//运费
        $nick_name = $this->request->post['nick_name'];
        $url = $this->request->post['info_url'];//商品url
        $quantity = $this->request->post['number'];//数量
        $note = $this->request->post['desc'];//备注
        $storeurl = $this->request->post['shop_url'];//店铺url
        $img = $this->request->post['pic_url'];//图片url
        $prifex = $this->request->post['prifex'];//来源，如淘宝是TB
        $num_iid = $this->request->post['goods_id'];//商品id
        $storename = $this->request->post['storename'];
        $color = '';
        $size = '';

        if ($prifex == 'TB') {
            $url = 'http://item.taobao.com/item.htm?id=' . $num_iid;
        }
        
        $data = array(
            'num_iid' => $num_iid,
            'customer_id' => $customer_id,
            'firstname' => $firstname,
            'product_name' => $name,
            'product_url' => $url,
            'store_name' => $storename,
            'store_url' => $storeurl,
            'color' => $color,
            'size' => $size,
            'quantity' => $quantity,
            'note' => $note,
            'imgurl' => $img,
            'price' => $price,
            'freight' => $freight
            );
        $this->load->model('checkout/cart');
        $cart_id = $this->model_checkout_cart->addCart($data);
        $snatch_key = 'snatch_'.$cart_id;
        $this->cart->addsearch($snatch_key, $quantity, $color, $size, $note, $freight, $price);
        if ($customer_id) {
            $this->load->model('app/user');
            $this->model_app_user->updateCart($customer_id);
        }
        $cart_count = $this->cart->countProducts();
        $result = array(
            'info' => array(
                'count' => $cart_count
                )
            );
        echo(json_encode($result));
    }

    public function batchadd() {
        if (isset($this->session->data['customer_id'])) {
            $customer_id = $this->session->data['customer_id'];
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomer($customer_id);
            $firstname = $customer['firstname'];
        } else {
            $customer_id = 0;
            $firstname = '';
        }
        $name = $this->request->post['title'];//商品名称
        $freight = $this->request->post['t_freight'];//运费
        $nick_name = $this->request->post['nick_name'];
        $url = $this->request->post['info_url'];//商品url
        $storeurl = $this->request->post['shop_url'];//店铺url
        $img = $this->request->post['pic_url'];//图片url
        $prifex = $this->request->post['prifex'];//来源，如淘宝是TB
        $num_iid = $this->request->post['goods_id'];//商品id
        $items = $this->request->post['item'];//商品列表
        $storename = $this->request->post['storename'];

        if ($prifex == 'TB') {
            $url = 'http://item.taobao.com/item.htm?id=' . $num_iid;
        }

        $this->load->model('checkout/cart');
        $this->load->model('app/user');

        foreach ($items as $item) {
            $quantity = $item['number'];
            $color = $item['color'];
            $size = $item['size'];
            $note = $item['desc'];
            $price = $item['price'];

            $data = array(
                'num_iid' => $num_iid,
                'customer_id' => $customer_id,
                'firstname' => $firstname,
                'product_name' => $name,
                'product_url' => $url,
                'store_name' => $storename,
                'store_url' => $storeurl,
                'color' => $color,
                'size' => $size,
                'quantity' => $quantity,
                'note' => $note,
                'imgurl' => $img,
                'price' => $price,
                'freight' => $freight
                );

            $cart_id = $this->model_checkout_cart->addCart($data);
            $snatch_key = 'snatch_'.$cart_id;
            $this->cart->addsearch($snatch_key, $quantity, $color, $size, $note, $freight, $price);
            if ($customer_id) {
                $this->model_app_user->updateCart($customer_id);
            }
        }
        $cart_count = $this->cart->countProducts();
        $result = array(
            'info' => array(
                'count' => $cart_count
                )
            );
        echo(json_encode($result));
    }

    public function crawl() {
        $this->data['url'] = $this->request->get['url'];

        $this->template = 'cnstorm/template/plugin/cnstormassist.tpl';

        $this->response->setOutput("<script>window.onload=function(){ document.getElementById('button').click();}</script>".$this->render());
    }

    public function quickbuy() {
        // var_dump($this->request->server);
        $cnstorm = 'http://'.$this->request->server['HTTP_HOST'].'/index.php?route=plugin/cnstormassist/crawl&url=';
	if (isset($this->request->get['u'])){
		$url = $this->request->get['u'];
	}else{
		$url = '';
	}
        
        $url = htmlspecialchars_decode($url);
		echo <<<Eof
window.CNstorm_Tool={
    b:document.body,
    d:{},
    t:{},
    f:{},
    l:{},
    init:function(){
        this.d=document.createElement("div");
        this.t=document.createElement("div");
        this.l=document.createElement("div");
        this.f=document.createElement("iframe");
        this.d.style.width="600px";
        this.d.style.height="490px";
        this.d.style.position="fixed";
        this.d.style.marginTop="-227px";
        this.d.style.marginLeft="-277px";
        this.d.style.background="#FFFFFF";
        this.d.style.top="50%";
        this.d.style.left="50%";
        this.d.style.overflow="hidden";
        this.d.style.textAlign="left";
        this.d.style.zIndex=100000000;
        this.t.style.background="url(http://www.acgstorm.com/image/logo_16.png) no-repeat 10px 9px #FB6E52";
        this.t.style.marginTop="-2px";
        this.t.style.position="relative";
        this.t.style.height="32px";
        this.t.innerHTML='<div style="color:#FFF;font-size:14px;font-weight:bold;float:left;line-height:32px;margin:0 0 0 10px;display:inline;padding-left:20px;">'+decodeURI('%E4%BB%A3%E8%B4%AD%E5%8A%A9%E6%89%8B')+'</div><a onclick="window.CNstorm_Tool.toggle()" title="" style="margin: 9px 15px 0px 0px; text-decoration: none;display:inline;width:21px;background: no-repeat 5px 5px;float:right;height:21px;cursor:pointer;"><nobr>关闭</nobr></a>';
        this.f.style.width="600px";
        this.f.style.height="490px";
        this.f.style.marginLeft="0px";
        this.f.setAttribute("border","0");
        this.f.setAttribute("allowtransparency",true);
        this.f.setAttribute("scrolling-y","auto");
        this.f.frameBorder=0;
        this.f.setAttribute("src","{$cnstorm}"+encodeURIComponent("{$url}"));
        this.l.setAttribute("style","moz-opacity:0.56;opacity: 0.56;");
        this.l.style.filter="alpha(opacity=56)";
        this.l.style.position="fixed";
        this.l.style.bottom=0;
        this.l.style.top=0;
        this.l.style.left=0;
        this.l.style.right=0;
        this.l.style.background="#000";
        this.l.style.width="100%";
        this.l.style.height="100%";
        this.l.style.zIndex=80000;
        this.d.appendChild(this.t);
        this.d.appendChild(this.f);
        this.b.appendChild(this.l);
        this.b.appendChild(this.d);
        if(typeof document.body.style.maxHeight=="undefined"){
            this.l.style.height=document.body.scrollHeight+"px";
            this.l.style.position="absolute";
            this.b.style.height="100%";
            this.d.style.position="absolute";
            this.d.style.marginTop="0px";
            var a=(document.documentElement.clientHeight-454)/2;
            this.d.style.top=(a+this.d.scrollTop).toString()+"px";
            window.onscroll=function(){
                this.d.style.top=(a+document.documentElement.scrollTop)+"px";
            };
        
        }
        return this;
    },
    open:function(){
        this.l.style.height=typeof document.body.style.maxHeight=="undefined"?(document.body.scrollHeight+"px"):"100%";
        this.l.style.display="block";
        try{
            this.f.src="{$cnstorm}"+encodeURIComponent("{$url}");
        }catch(a){}
        this.d.style.display="block";
        return this;
    },
    close:function(){
        this.l.style.display="none";
        this.d.style.display="none";
        return this;
    },
    toggle:function(){
        this.d.style.display=="none"?this.open():this.close();
    }
};
CNstorm_Tool.init();
Eof;
	}

}