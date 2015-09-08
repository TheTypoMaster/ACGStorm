<?php

class ControllerInternationalFreight extends Controller {

    public function index() {


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/international/freight.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/international/freight.tpl';
        } else {
            $this->template = 'default/template/international/freight.tpl';
        }

        $this->children = array(
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

    public function freight2() {
		//语言部分
		$this->language->load('international/freight2');
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_internationalFreight'] = $this->language->get('text_internationalFreight');
		$this->data['text_lowestPrice'] = $this->language->get('text_lowestPrice');
		$this->data['text_oversea'] = $this->language->get('text_oversea');
		$this->data['text_fast'] = $this->language->get('text_fast');
		$this->data['text_freightPrice'] = $this->language->get('text_freightPrice');
		$this->data['text_freightEstimate'] = $this->language->get('text_freightEstimate');
		$this->data['text_chooseCountry'] = $this->language->get('text_chooseCountry');
		$this->data['text_hotCountry'] = $this->language->get('text_hotCountry');
		$this->data['text_allCountry'] = $this->language->get('text_allCountry');
		$this->data['text_transportWay'] = $this->language->get('text_transportWay');
		$this->data['text_firsrPrice'] = $this->language->get('text_firsrPrice');
		$this->data['text_secondPrice'] = $this->language->get('text_secondPrice');
		$this->data['text_limitWeight'] = $this->language->get('text_limitWeight');
		$this->data['text_expectedAging'] = $this->language->get('text_expectedAging');
		$this->data['text_noChoose'] = $this->language->get('text_noChoose');

		$this->data['text_USA'] = $this->language->get('text_USA');
		$this->data['text_Canada'] = $this->language->get('text_Canada');
		$this->data['text_Australia'] = $this->language->get('text_Australia');
		$this->data['text_Japan'] = $this->language->get('text_Japan');
		$this->data['text_Taiwan'] = $this->language->get('text_Taiwan');
		$this->data['text_NewZealand'] = $this->language->get('text_NewZealand');
		$this->data['text_UnitedKingdom'] = $this->language->get('text_UnitedKingdom');
		$this->data['text_Malaysia'] = $this->language->get('text_Malaysia');

		$this->data['text_a_f'] = $this->language->get('text_a_f');
		$this->data['text_g_j'] = $this->language->get('text_g_j');
		$this->data['text_k_n'] = $this->language->get('text_k_n');
		$this->data['text_p_s'] = $this->language->get('text_p_s');
		$this->data['text_t_z'] = $this->language->get('text_t_z');

		$this->data['text_Australia'] = $this->language->get('text_Australia');
		$this->data['text_Austria'] = $this->language->get('text_Austria');
		$this->data['text_Argentina'] = $this->language->get('text_Argentina');
		$this->data['text_Anhui'] = $this->language->get('text_Anhui');
		$this->data['text_Belgium'] = $this->language->get('text_Belgium');
		$this->data['text_Belarus'] = $this->language->get('text_Belarus');
		$this->data['text_Brazil'] = $this->language->get('text_Brazil');
		$this->data['text_Bahrain'] = $this->language->get('text_Bahrain');
		$this->data['text_Bulgaria'] = $this->language->get('text_Bulgaria');
		$this->data['text_Cambodia'] = $this->language->get('text_Cambodia');
		$this->data['text_Canada'] = $this->language->get('text_Canada');
		$this->data['text_CostaRica'] = $this->language->get('text_CostaRica');
		$this->data['text_Czechia'] = $this->language->get('text_Czechia');
		$this->data['text_Croatia'] = $this->language->get('text_Croatia');
		$this->data['text_Colombia'] = $this->language->get('text_Colombia');
		$this->data['text_Cuba'] = $this->language->get('text_Cuba');
		$this->data['text_Chongqing'] = $this->language->get('text_Chongqing');
		$this->data['text_Denmark'] = $this->language->get('text_Denmark');
		$this->data['text_Estonia'] = $this->language->get('text_Estonia');
		$this->data['text_France'] = $this->language->get('text_France');
		$this->data['text_Finland'] = $this->language->get('text_Finland');
		$this->data['text_Fiji'] = $this->language->get('text_Fiji');
		$this->data['text_Fujian'] = $this->language->get('text_Fujian');

		$this->data['text_Germany'] = $this->language->get('text_Germany');
		$this->data['text_Greece'] = $this->language->get('text_Greece');
		$this->data['text_Guangdong'] = $this->language->get('text_Guangdong');
		$this->data['text_Neimenggu'] = $this->language->get('text_Neimenggu');
		$this->data['text_Guangxi'] = $this->language->get('text_Guangxi');
		$this->data['text_Guizhou'] = $this->language->get('text_Guizhou');
		$this->data['text_HongKong'] = $this->language->get('text_HongKong');
		$this->data['text_Hungary'] = $this->language->get('text_Hungary');
		$this->data['text_Heilongjiang'] = $this->language->get('text_Heilongjiang');
		$this->data['text_Hunan'] = $this->language->get('text_Hunan');
		$this->data['text_Hubei'] = $this->language->get('text_Hubei');
		$this->data['text_Henan'] = $this->language->get('text_Henan');
		$this->data['text_Italy'] = $this->language->get('text_Italy');
		$this->data['text_Ireland'] = $this->language->get('text_Ireland');
		$this->data['text_Indonesia'] = $this->language->get('text_Indonesia');
		$this->data['text_India'] = $this->language->get('text_India');
		$this->data['text_Japan'] = $this->language->get('text_Japan');
		$this->data['text_Jordan'] = $this->language->get('text_Jordan');
		$this->data['text_JZH'] = $this->language->get('text_JZH');
		$this->data['text_Jingjinji'] = $this->language->get('text_Jingjinji');
		$this->data['text_Jiangxi'] = $this->language->get('text_Jiangxi');

		$this->data['text_Kazakhstan'] = $this->language->get('text_Kazakhstan');
		$this->data['text_Luxembourg'] = $this->language->get('text_Luxembourg');
		$this->data['text_Latvia'] = $this->language->get('text_Latvia');
		$this->data['text_Lithuania'] = $this->language->get('text_Lithuania');
		$this->data['text_MalaysiaE'] = $this->language->get('text_MalaysiaE');
		$this->data['text_MalaysiaW'] = $this->language->get('text_MalaysiaW');
		$this->data['text_Macau'] = $this->language->get('text_Macau');
		$this->data['text_Maldives'] = $this->language->get('text_Maldives');
		$this->data['text_Mexico'] = $this->language->get('text_Mexico');
		$this->data['text_Malta'] = $this->language->get('text_Malta');
		$this->data['text_NewZealand'] = $this->language->get('text_NewZealand');
		$this->data['text_Netherlands'] = $this->language->get('text_Netherlands');
		$this->data['text_Norway'] = $this->language->get('text_Norway');

		$this->data['text_Other'] = $this->language->get('text_Other');
		$this->data['text_Philippines'] = $this->language->get('text_Philippines');
		$this->data['text_Portugal'] = $this->language->get('text_Portugal');
		$this->data['text_Peru'] = $this->language->get('text_Peru');
		$this->data['text_PuertoRico'] = $this->language->get('text_PuertoRico');
		$this->data['text_Poland'] = $this->language->get('text_Poland');
		$this->data['text_Panama'] = $this->language->get('text_Panama');
		$this->data['text_Russia'] = $this->language->get('text_Russia');
		$this->data['text_Romania'] = $this->language->get('text_Romania');
		$this->data['text_SouthKorea'] = $this->language->get('text_SouthKorea');
		$this->data['text_Spain'] = $this->language->get('text_Spain');
		$this->data['text_Sweden'] = $this->language->get('text_Sweden');
		$this->data['text_Switzerland'] = $this->language->get('text_Switzerland');
		$this->data['text_Singapore'] = $this->language->get('text_Singapore');
		$this->data['text_Slovakia'] = $this->language->get('text_Slovakia');
		$this->data['text_SaudiArabia'] = $this->language->get('text_SaudiArabia');
		$this->data['text_SouthAfrica'] = $this->language->get('text_SouthAfrica');
		$this->data['text_SH'] = $this->language->get('text_SH');
		$this->data['text_Sichuan'] = $this->language->get('text_Sichuan');
		$this->data['text_SX'] = $this->language->get('text_SX');
		$this->data['text_Shenzhen'] = $this->language->get('text_Shenzhen');

		$this->data['text_Thailand'] = $this->language->get('text_Thailand');
		$this->data['text_Taiwan'] = $this->language->get('text_Taiwan');
		$this->data['text_Emirates'] = $this->language->get('text_Emirates');
		$this->data['text_Turkey'] = $this->language->get('text_Turkey');
		$this->data['text_USA'] = $this->language->get('text_USA');
		$this->data['text_UnitedKingdom'] = $this->language->get('text_UnitedKingdom');
		$this->data['text_Ukraine'] = $this->language->get('text_Ukraine');
		$this->data['text_Vietnam'] = $this->language->get('text_Vietnam');
		$this->data['text_Xinjiang'] = $this->language->get('text_Xinjiang');
		$this->data['text_Xizang'] = $this->language->get('text_Xizang');
		$this->data['text_Yunnan'] = $this->language->get('text_Yunnan');
		$this->data['text_dollar'] = $this->language->get('text_dollar');
		$this->data['text_more'] = $this->language->get('text_more');
		$this->data['text_FAQ'] = $this->language->get('text_FAQ');
		$this->data['text_Q1'] = $this->language->get('text_Q1');
		$this->data['text_Q2'] = $this->language->get('text_Q2');
		$this->data['text_Q3'] = $this->language->get('text_Q3');
		$this->data['text_A'] = $this->language->get('text_A');
		$this->data['text_A1'] = $this->language->get('text_A1');
		$this->data['text_A2'] = $this->language->get('text_A2');
		$this->data['text_A3'] = $this->language->get('text_A3');

        if (isset($this->request->get['realvalue']) && $this->request->get['realvalue']) {

            $realvalue = $this->request->get['realvalue'];

            $this->load->model('international/freight');

            $delivery_info = $this->model_international_freight->getdelivery($realvalue);

            foreach ($delivery_info as &$delivery) {

                $data = array(
                    'deliveryname' => $delivery['deliveryname'],
                    'realvalue' => $realvalue,
                    'limit' => 3
                );

                $comment_info = $this->model_international_freight->getcomment($data);

                foreach ($comment_info as &$comment) {

                    $face = $this->model_international_freight->getface($comment['uid']);

                    if ($face) {

                        $comment['face'] = $face;
                    } else {

                        $comment['face'] = "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
                    }
                }

                $delivery['comment_info'] = $comment_info;
            }

            //var_dump($delivery_info);

            $this->data['delivery_info'] = $delivery_info;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/international/freight2_content.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/international/freight2_content.tpl';
            } else {
                $this->template = 'default/template/international/freight2_content.tpl';
            }
        } else {

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/international/freight2.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/international/freight2.tpl';
            } else {
                $this->template = 'default/template/international/freight2.tpl';
            }

            $this->children = array(
                'common/footer',
                'common/header_transport'
            );
        }
        $this->response->setOutput($this->render());
    }
    public function getCity(){
	
		$keyword=$_GET['keyword'];
		$sql="select country_id,areaid,name,name_cn from oc_country where  (name like '".$keyword."%') or (name_cn like '".$keyword."%') and status =1 ";
		
		$rows=$this->db->query($sql);

		$arr=array();
		foreach($rows->rows as $key=>$row){
				$arr[]= array(
				
				'area_id'=>$row['areaid'],
				'keyword'=>$row['name'],
				'name_cn'=>$row['name_cn']
			);
		}
		echo json_encode($arr);
		
   }
   
}

?>