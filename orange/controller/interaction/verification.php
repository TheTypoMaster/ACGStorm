<?php

class ControllerInteractionVerification extends Controller {

    public function index() {
   	$this->language->load('interaction/verification');
        $this->document->setTitle("商户认证申请记录");
        $this->load->model('interaction/interaction');
        $this->getList();
    }

    protected function getList() {
	if (isset($this->request->get['filter_mid'])) {
            $filter_mid = $this->request->get['filter_mid'];
        } else {
            $filter_mid = null;
        }	
	if (isset($this->request->get['filter_uname'])) {
            $filter_uname = $this->request->get['filter_uname'];
        } else {
            $filter_uname = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'o.order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }


        $url = '';
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('interaction/verification', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );


        if (isset($this->request->post['selected']) && isset($this->request->post['filter_order_status_id'])) {
            $select = $this->request->post['selected'];
            $filter_order_status_id = $this->request->post['filter_order_status_id'];
        } else {
            $order = 'DESC';
        }

	$this->data['token'] = $this->session->data['token'];
	$this->data['manager'] = $this->user->getUserName();
        $this->data['orders'] = array();

        $data = array(
            'mid' => $filter_mid,
            'uname' => $filter_uname,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

	
        date_default_timezone_set('Asia/Shanghai');
        $results = $this->model_interaction_interaction->getMerchantApply($data);

        foreach ($results as $result) {
	    switch($result['biz_type']){
	    	case 1:$result['biz_type'] = "个人——非企业";break;
		case 2:$result['biz_type'] = "个体经营";break;
		case 3:$result['biz_type'] = "合伙经营";break;
		case 4:$result['biz_type'] = "公司";break;
		case 5:$result['biz_type'] = "LLC";break;
		case 6:$result['biz_type'] = "非盈利组织";break;
		default:$result['biz_type'] = "";break;
	    }
	    switch($result['company_industry']){
	            case 1003:$result['company_industry'] = "书籍和杂志";break;
	            case 1004:$result['company_industry'] = "企业对企业";break;
	            case 1021:$result['company_industry'] = "体育和户外活动";break;
	            case 1014:$result['company_industry'] = "保健和个人护理";break;
	            case 1001:$result['company_industry'] = "儿童用品";break;
	            case 1009:$result['company_industry'] = "娱乐和媒体";break;
	            case 1018:$result['company_industry'] = "宗教和教会（盈利性）";break;
	            case 1017:$result['company_industry'] = "宠物和动物";break;
	            case 1015:$result['company_industry'] = "家居和庭院用品";break;
		    case 1013:$result['company_industry'] = "政府";break;
		    case 1007:$result['company_industry'] = "教育";break;
		    case 1023:$result['company_industry'] = "旅游";break;
		    case 1020:$result['company_industry'] = "服务——其他";break;
		    case 1005:$result['company_industry'] = "服装、饰品和鞋子";break;
		    case 1022:$result['company_industry'] = "玩具和业余爱好";break;
		    case 1008:$result['company_industry'] = "电器和电信";break;
		    case 1012:$result['company_industry'] = "礼品和鲜花";break;
		    case 1002:$result['company_industry'] = "美容用品和香薰";break;
		    case 1000:$result['company_industry'] = "艺术品、工艺品和收藏品";break;
		    case 1006:$result['company_industry'] = "计算机、配件和服务";break;
		    case 1025:$result['company_industry'] = "车辆服务和零配件";break;
		    case 1024:$result['company_industry'] = "车辆销售";break;
		    case 1010:$result['company_industry'] = "金融服务和产品";break;
		    case 1019:$result['company_industry'] = "零售（未归类）";break;
		    case 1016:$result['company_industry'] = "非营利组织";break;
		    case 1011:$result['company_industry'] = "食品零售和服务";break;
		    default:$result['company_industry'] = "";break;
	    }
	    if (!empty($result['sale_mode'])){
		    if (strpos('1',$result['sale_mode']) >= 0){
		    	$result['sale_mode'] = str_replace('1','在线竞拍网站',$result['sale_mode']);
		    }
		    if (strpos('2',$result['sale_mode']) >= 0){
		    	$result['sale_mode'] = str_replace('2','商业网站',$result['sale_mode']);
		    }
		    if (strpos('3',$result['sale_mode']) >= 0){
		    	$result['sale_mode'] = str_replace('3','实体店铺',$result['sale_mode']);
		    }
		    if (strpos('4',$result['sale_mode']) >= 0){
		    	$result['sale_mode'] = str_replace('4','住宅/办公室',$result['sale_mode']);
		    }
	    }
            $this->data['orders'][] = array(
                'aid' => $result['aid'],
                'uname' => $result['uname'],
                'biz_type' => $result['biz_type'],
                'company_industry' => $result['company_industry'],
                'website_url' => $result['website_url'],
		'sale_mode' => $result['sale_mode'],
                'apply_time' => date("Y-m-d H:i:s", $result['apply_time']),
                'selected' => isset($this->request->post['selected']) && in_array($result['aid'], $this->request->post['selected']),
            );
        }

        $record_total = $this->model_interaction_interaction->totalMerchantApply();


        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('interaction/verification', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'interaction/verification.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
}

?>