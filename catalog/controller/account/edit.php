<?php

class ControllerAccountEdit extends Controller {

    private $error = array();

    public function index() {
	
        if (!$this->customer->isLogged()) {
		
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('account/edit');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/customer');

		$this->load->model('account/promoter');
		
		$this->load->model('account/pm');
		 
		$commission=$this->model_account_promoter->true_ratio();
		
		$commission_ratio=$commission*0.01;
		//查用户生效时间
		$Efftime=$this->model_account_promoter->getUserEff($this->session->data['customer_id']);
		
		$numCanQuxian=$this->model_account_promoter->getCanQuxian($commission_ratio,$Efftime);
		
		$numCanQuxian=$numCanQuxian > 0? $numCanQuxian:0;
		 
		$sql="SELECT opp.grade,SUM(os.`score`)AS allscore,oc.money FROM oc_promotion_personnel opp  LEFT JOIN oc_scorerecord os ON os.`uid`=opp.`uid`  LEFT JOIN oc_customer oc ON oc.`customer_id` =opp.`uid`  LEFT JOIN oc_withdraw_cash owc ON oc.`customer_id`=owc.`uid` WHERE opp.`uid`=".$this->customer->getId();
		$row=$this->db->query($sql);
		
		 $this->data['grade']=$row->row['grade'];
		 $this->data['allscore']=$row->row['allscore'];
		 $this->data['money']=$row->row['money'];
		 $this->data['CanQuxian']=$numCanQuxian;
        $face=$this->model_account_pm->getFaceAndVerification();
        $this->data['face']=$face['face'];
		$sql="select sum(money)as totalmoney  from oc_withdraw_cash where status=0 and Acceptance_state!=3 and uid =".$this->customer->getId();
		$row=$this->db->query($sql);
		$totalmoney=$row->row['totalmoney'];
		$this->data['totalmoney']=$totalmoney;
		
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_account_customer->editCustomer($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            //$this->redirect($this->url->link('account/account', '', 'SSL'));
            $this->redirect($this->url->link('account/edit', '', 'SSL'));
        }

		
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_edit'),
            'href' => $this->url->link('account/edit', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_your_details'] = $this->language->get('text_your_details');

        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_fax'] = $this->language->get('entry_fax');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['button_back'] = $this->language->get('button_back');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        /* 
        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }
        */

        if (isset($this->error['lastname'])) {
            $this->data['error_lastname'] = $this->error['lastname'];
        } else {
            $this->data['error_lastname'] = '';
        }
        /*
          if (isset($this->error['email'])) {
          $this->data['error_email'] = $this->error['email'];
          } else {
          $this->data['error_email'] = '';
          }
         */
        if (isset($this->error['telephone'])) {
            $this->data['error_telephone'] = $this->error['telephone'];
        } else {
            $this->data['error_telephone'] = '';
        }

        if (isset($this->error['mobile'])) {
            $this->data['error_mobile'] = $this->error['mobile'];
        } else {
            $this->data['error_mobile'] = '';
        }

        $this->data['action'] = $this->url->link('account/edit', '', 'SSL');

        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
        }

        if (isset($this->request->get['id'])) {
            $this->data['id'] = $this->request->get['id'];
        } else {
            $this->data['id'] = 1;
        }

        if (isset($this->request->post['firstname'])) {
            $this->data['firstname'] = $this->request->post['firstname'];
        } elseif (isset($customer_info)) {
            $this->data['firstname'] = $customer_info['firstname'];
        } else {
            $this->data['firstname'] = '';
        }


        if (isset($this->request->post['sex'])) {
            $this->data['sex'] = $this->request->post['sex'];
        } elseif (isset($customer_info)) {
            $this->data['sex'] = $customer_info['sex'];
        } else {
            $this->data['sex'] = '';
        }

        if (isset($this->request->post['sexuality'])) {
            $this->data['sexuality'] = $this->request->post['sexuality'];
        } elseif (isset($customer_info)) {
            $this->data['sexuality'] = $customer_info['sexuality'];
        } else {
            $this->data['sexuality'] = '';
        }

        if (isset($this->request->post['birthday'])) {
            $this->data['birthday'] = $this->request->post['birthday'];
        } elseif (isset($customer_info)) {
            $this->data['birthday'] = $customer_info['birthday'];
        } else {
            $this->data['birthday'] = '';
        }

        if (isset($this->request->post['marriage'])) {
            $this->data['marriage'] = $this->request->post['marriage'];
        } elseif (isset($customer_info)) {
            $this->data['marriage'] = $customer_info['marriage'];
        } else {
            $this->data['marriage'] = '';
        }

        if (isset($this->request->post['children'])) {
            $this->data['children'] = $this->request->post['children'];
        } elseif (isset($customer_info)) {
            $this->data['children'] = $customer_info['children'];
        } else {
            $this->data['children'] = '';
        }

        if (isset($this->request->post['education'])) {
            $this->data['education'] = $this->request->post['education'];
        } elseif (isset($customer_info)) {
            $this->data['education'] = $customer_info['education'];
        } else {
            $this->data['education'] = '';
        }

        if (isset($this->request->post['job'])) {
            $this->data['job'] = $this->request->post['job'];
        } elseif (isset($customer_info)) {
            $this->data['job'] = $customer_info['job'];
        } else {
            $this->data['job'] = '';
        }

        if (isset($this->request->post['salary'])) {
            $this->data['salary'] = $this->request->post['salary'];
        } elseif (isset($customer_info)) {
            $this->data['salary'] = $customer_info['salary'];
        } else {
            $this->data['salary'] = '';
        }


        if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
        } elseif (isset($customer_info)) {
            $this->data['lastname'] = $customer_info['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        /*
          if (isset($this->request->post['email'])) {
          $this->data['email'] = $this->request->post['email'];
          } elseif (isset($customer_info)) {
          $this->data['email'] = $customer_info['email'];
          } else {
          $this->data['email'] = '';
          }
         */

        if (isset($this->request->post['telephone'])) {
            $this->data['telephone'] = $this->request->post['telephone'];
        } elseif (isset($customer_info)) {
            $this->data['telephone'] = $customer_info['telephone'];
        } else {
            $this->data['telephone'] = '';
        }

        if (isset($this->request->post['mobile'])) {
            $this->data['mobile'] = $this->request->post['mobile'];
        } elseif (isset($customer_info)) {
            $this->data['mobile'] = $customer_info['mobile'];
        } else {
            $this->data['mobile'] = '';
        }

        if (isset($this->request->post['hometown'])) {
            $this->data['hometown'] = $this->request->post['hometown'];
        } elseif (isset($customer_info)) {
            $this->data['hometown'] = $customer_info['hometown'];
        } else {
            $this->data['hometown'] = '';
        }

        if (isset($this->request->post['live'])) {
            $this->data['live'] = $this->request->post['live'];
        } elseif (isset($customer_info)) {
            $this->data['live'] = $customer_info['live'];
        } else {
            $this->data['live'] = '';
        }

        if (isset($this->request->post['blog'])) {
            $this->data['blog'] = $this->request->post['blog'];
        } elseif (isset($customer_info)) {
            $this->data['blog'] = $customer_info['blog'];
        } else {
            $this->data['blog'] = '';
        }
        /*
          if (isset($this->request->post['fax'])) {
          $this->data['fax'] = $this->request->post['fax'];
          } elseif (isset($customer_info)) {
          $this->data['fax'] = $customer_info['fax'];
          } else {
          $this->data['fax'] = '';
          }
         */

        //$this->data['back'] = $this->url->link('account/account', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
        } else {
            $this->template = 'default/template/account/edit.tpl';
        }

        
        
        $this->template = 'cnstorm/template/account/edit_business.tpl';
/*
        $this->children = array(
            'common/header',
            'common/footer',
            'common/uc_business');
	*/		
         $this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);       
       

        $this->response->setOutput($this->render());
    }

    protected function validate() {

        //昵称
        /*
        if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }
        */

        //真实姓名
        if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }

        /*
          //验证邮箱地址
          if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
          $this->error['email'] = $this->language->get('error_email');
          }

          //验证邮箱地址
          if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
          $this->error['warning'] = $this->language->get('error_exists');
          }
         */
         /*
        //固定电话
        if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }

        if ((utf8_strlen($this->request->post['mobile']) < 3) || (utf8_strlen($this->request->post['mobile']) > 32)) {
            $this->error['mobile'] = $this->language->get('error_telephone');
        }
        */

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function upload() {

        // disable error if you want
//error_reporting(0);

        include_once(DIR_SYSTEM . 'upload/config.php');
        include_once(DIR_SYSTEM . 'upload/functions.php');

        if ($this->request->get['act'] == 'thumb') {
            $arr = array(
                'uploaddir' => $imgthumb,
                'tempdir' => $imgtemp,
                'height' => $_POST['height'],
                'width' => $_POST['width'],
                'x' => $_POST['x'],
                'y' => $_POST['y'],
                'img_src' => $_POST['img_src'],
                'thumb' => true,
                'fileError' => $fileError,
                'sizeError' => $sizeError,
                'maxfilesize' => $maxuploadfilesize,
                'canvasbg' => $canvasbg,
                'bigWidthPrev' => $bigWidthPrev,
                'bigHeightPrev' => $bigHeightPrev,
            );
            resizeThumb($arr);
            exit;
        } elseif ($this->request->get['act'] == 'upload') {

            $big_arr = array(
                'uploaddir' => $imgbig,
                'tempdir' => $imgtemp,
                'height' => $_POST['height'],
                'width' => $_POST['width'],
                'x' => 0,
                'y' => 0,
                'thumb' => false,
                'fileError' => $fileError,
                'sizeError' => $sizeError,
                'maxfilesize' => $maxuploadfilesize,
                'canvasbg' => $canvasbg,
                'bigWidthPrev' => $bigWidthPrev,
                'bigHeightPrev' => $bigHeightPrev,
            );

            resizeImg($big_arr);
        } else {
            //nothing to do here
        }
    }
	public function getFreeze(){

		if(isset($this->request->get['uid'])&& $this->customer->getId() == $this->request->get['uid'] ){
			 $sql="select *  from oc_withdraw_cash where status=0 and uid =".$this->customer->getId();
			$row=$this->db->query($sql);
			$rows=$row->rows;
		}else{
			$rows='';
		}
			$this->data['results']=$rows;
			  $this->template = 'cnstorm/template/account/dongjie.tpl';
			$this->response->setOutput($this->render());
	}
}

?>