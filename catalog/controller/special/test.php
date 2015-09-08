<?php

class ControllerSpecialTest extends Controller {

    public function index() {

        if (isset($this->request->cookie['hometip'])) {
            $this->data['hometip'] = $this->request->cookie['hometip'];
        } else {
            $this->data['hometip'] = 0;
        }

        $this->data['logged'] = $this->customer->isLogged();
        $this->data['login'] = $this->url->link('account/login');
        $this->data['home'] = $this->url->link('common/home');
        $this->data['favorite'] = $this->url->link('product/favorite');
        $this->data['newbie'] = HTTP_SERVER . "newbie.html";
        $this->data['procurement'] = HTTP_SERVER . "procurement.html";
        $this->data['selfshopping'] = HTTP_SERVER . "selfshopping.html";
        $this->data['express'] = HTTP_SERVER . "international-express.html";

        //晒尔社区
        $this->load->model('social/saiercomment');
        $saiercomment = $this->model_social_saiercomment->getShowComments();
        $this->data['saiercomment'] = array();
        foreach ($saiercomment as $saier) {
            if ($firstImg = explode('|', $saier['imgurl'])) {
                $countFirstImg = count($firstImg);
                $saier['imgurl'] = $firstImg[0];
                $strFile = '';
                foreach ($firstImg as $k => $v) {
                    $posDot = strrpos($v, '.');
                    $strExt = substr($v, $posDot);
                    $posXie = strrpos($v, '/');
                    $strFiles = substr($v, $posXie);
                    $strFiles = explode('-', $strFiles);
                    $strFiles = $strFiles[0];
                    if ($countFirstImg > 1 && $k <= $countFirstImg - 2) {
                        $strFiles = "uploads/big" . $strFiles . $strExt;
                        $strFile .= $strFiles . '|';
                    }
                }
                $strFile .= "uploads/big" . $strFiles . $strExt;
            }
            if (!empty($saier['videourl'])) {
                include_once (DIR_SYSTEM . 'VideoUrlParser.class.php');
                $videourl = VideoUrlParser::parse($saier['videourl']);
                $video = $videourl;
            } else {
                $video = '';
            }
            $this->data['saiercomment'][] = array(
                'if_show' => $saier['if_show'],
                'message_id' => $saier['message_id'],
                'firstname' => $saier['firstname'],
                'face' => $saier['face'],
                'country' => $saier['country'],
                'message_text' => $saier['message_text'],
                'imgurl' => $saier['imgurl'],
                'strFile' => $strFile,
                'videourl' => $video,
                'comments' => $saier['comments'],
                'points' => $saier['points'],
                'utype' => $saier['utype']
            );
        }

        //网站公告
        $this->load->model('help/help');
        $bulletins = $this->model_help_help->getHomeBulletins();
        $this->data['bulletins'] = $bulletins;

        //网站评论
        $this->load->model('order/sendorder');
        $limit = 5;
        $data = array(
            'start' => 0,
            'limit' => $limit
        );

        $results = $this->model_order_sendorder->getComments($data);
        foreach ($results as $result) {

            $this->data ['comments'] [] = array(
                'face' => $result ['face'],
                'uname' => $result ['uname'],
                'from' => $result ['country'],
                'utype' => $result ['utype'],
                'message' => $result ['comment'],
            );
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/home.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/home.tpl';
        } else {
            $this->template = 'default/template/specialtpl/home.tpl';
        }

        $this->children = array(
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

    public function hometip() {
        setcookie('hometip', 1, time() + 3600 * 24 * 365 * 5, '/');
    }

}

?>