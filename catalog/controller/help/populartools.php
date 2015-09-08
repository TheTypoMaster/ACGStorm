<?php

class ControllerHelpPopulartools extends Controller {

    private $error = array();

    public function index() {

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['noviceteaching'] = $this->url->link('noviceteaching/noviceteaching');

        $this->data['favorite'] = $this->url->link('product/favorite');

        if (isset($this->request->get['id'])) {
            $this->data['id'] = $this->request->get['id'];
        } else {
            $this->data['id'] = 1;
        }

        $this->data['carriers'] = array();

        if (isset($this->request->post['etype'])){
				$etype = $this->request->post['etype'];
				$this->data['etype']= $etype ;
			}else{
				$this->data['etype']= '代购' ;
			}
        if (isset($this->request->post['cost']))
            $cost = $this->request->post['cost'];

        if (isset($this->request->post['weight'])) {
            $weight = $this->request->post['weight'];
            $this->data['weight'] = $weight;
        } else {
            $this->data['weight'] = "";
        }

        if (isset($this->request->post['length']))
            $length = $this->request->post['length'];

        if (isset($this->request->post['width']))
            $width = $this->request->post['width'];

        if (isset($this->request->post['height']))
            $height = $this->request->post['height'];

        if (isset($this->request->post['area'])) {
            $this->data['area'] = $this->request->post['area'];
        } else {
            $this->data['area'] = "";
        }

        if (isset($this->request->post['area_id'])) {
            $area_id = $this->request->post['area_id'];
            $this->load->model('guoji/guoji');
            $results = $this->model_guoji_guoji->get_express($area_id);


            foreach ($results as $result) {
                $first_weight = $result['first_weight'];
                $continue_weight = $result['continue_weight'];
                $first_fee = $result['first_fee'];
                $continue_fee = $result['continue_fee'];

                if ($weight <= $first_weight) {
                    $freight = $result['first_fee'];
                } else {
                    $freight = $result['first_fee'] + ceil(($weight - $first_weight) / $continue_weight) * $continue_fee;
                }
                //$servefee = round($freight * 0.038,2);
                $servefee=0;
                $this->data['carriers'][] = array(
                    'deliveryname' => $result['deliveryname'],
                    'delivery_time' => $result['delivery_time'],
                    'carrierLogo' => $result['carrierLogo'],
                    'freight' => $freight,
                    'servefee' => $servefee,
                    'total' => round($freight+$servefee+8,2)
                );

            }
        }

        //var_dump($results);
        /* $data = array(
          'etype' => $etype,
          'area' => $area,
          'weight' => $weight,
          'length' => $length,
          'width' => $width,
          'height' => $height);
          var_dump($express); */

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/help/populartools.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/help/populartools.tpl';
        } else {
            $this->template = 'default/template/help/populartools.tpl';
        }

        $this->children = array(
            'common/help_left',
            'common/footer',
            'common/header_transport'
        );

        $this->response->setOutput($this->render());
    }

}

?>