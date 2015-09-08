<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');


        	//语言部分
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_service'] = $this->language->get('text_service');
		$this->data['text_extra'] = $this->language->get('text_extra');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');

        	$this->data['text_focusOnOur'] = $this->language->get('text_focusOnOur');
		$this->data['text_noticeDynamic'] = $this->language->get('text_noticeDynamic');
		$this->data['text_comprehensiveUpgradeOnline'] = $this->language->get('text_comprehensiveUpgradeOnline');
		$this->data['text_theElevenHolidayNotice'] = $this->language->get('text_theElevenHolidayNotice');
		$this->data['text_newUserFreightRebate'] = $this->language->get('text_newUserFreightRebate');
		$this->data['text_studentMembersFree'] = $this->language->get('text_tudentMembersFree');
		$this->data['text_commonProblem'] = $this->language->get('text_commonProblem');
		$this->data['text_theDifference'] = $this->language->get('text_theDifference');
		$this->data['text_HowToChargePurchasing'] = $this->language->get('text_HowToChargePurchasing');
		$this->data['text_purchaseOrderStatus'] = $this->language->get('text_purchaseOrderStatus');
		$this->data['text_distributionRange'] = $this->language->get('text_distributionRange');
		$this->data['text_serviceMailbox'] = $this->language->get('text_serviceMailbox');
		$this->data['text_workingTime'] = $this->language->get('text_workingTime');
		$this->data['text_contactCustomerServiceOnline'] = $this->language->get('text_contactCustomerServiceOnline');
		$this->data['text_aboutUs'] = $this->language->get('text_aboutUs');
		$this->data['text_joinUs'] = $this->language->get('text_joinUs');
		$this->data['text_thePrivacyStatement'] = $this->language->get('text_thePrivacyStatement');
		$this->data['text_helpCenter'] = $this->language->get('text_helpCenter');
		$this->data['text_TheSiteMap'] = $this->language->get('text_TheSiteMap');
		$this->data['text_friendsLinks'] = $this->language->get('text_friendsLinks');



		$this->load->model('catalog/information');

		$this->data['informations'] = array();

		//网页底部公告
        	$this->load->model('help/help');
        	$bulletins = $this->model_help_help->getBulletins(2);
        	$this->data['bulletins'] = $bulletins;

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$this->data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$this->data['contact'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
		$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer');
		$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');		
		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

                //$this->data['announcement'] = $this->url->link('help/announcement', '', 'SSL');
                //$this->data['student'] = $this->url->link('special/student', '', 'SSL');
                //$this->data['normalquestion'] = $this->url->link('help/normalquestion', '', 'SSL');
                //$this->data['aboutus'] = $this->url->link('help/aboutus', '', 'SSL');
                //$this->data['contactus'] = $this->url->link('help/contactus', '', 'SSL');
                //$this->data['joinus'] = $this->url->link('help/joinus', '', 'SSL');
                //$this->data['privacy'] = $this->url->link('help/privacy', '', 'SSL');
                //$this->data['website_map'] = $this->url->link('help/website_map', '', 'SSL');
                //$this->data['friends'] = $this->url->link('help/friends', '', 'SSL');

                $this->data['announcement'] = HTTP_SERVER."help-announcement.html";
                $this->data['student'] = HTTP_SERVER."special-student.html";
                $this->data['normalquestion'] = HTTP_SERVER."help.html";
                $this->data['aboutus'] = HTTP_SERVER."help-aboutus.html";
                $this->data['contactus'] = HTTP_SERVER."help-contactus.html";
                $this->data['joinus'] = HTTP_SERVER."help-joinus.html";
                $this->data['privacy'] = HTTP_SERVER."help-privacy.html"; 
                $this->data['website_map'] = HTTP_SERVER."help-website_map.html"; 
                $this->data['friends'] = HTTP_SERVER."help-friends.html"; 

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];	
			} else {
				$ip = ''; 
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];	
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];	
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}	

		//minicart 迷你购物车商品数量
        	$count = $this->cart->countProducts();
        	$this->data['count'] = $count;

        	$this->data['logged'] = $this->customer->isLogged();
        	$this->data['face'] = $this->customer->getFace();
        	$this->data['text_logged'] = sprintf('<a href=' . HTTP_SERVER . 'order.html>' . $this->customer->getFirstName() . "</a>");	

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}

		$this->render();
	}
}
?>