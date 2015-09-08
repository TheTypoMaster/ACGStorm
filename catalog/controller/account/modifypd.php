<?php 
class ControllerAccountModifypd extends Controller {

	public function index(){
	
		if (isset($this->request->get['code'])){
		
            $code= $this->request->get['code'];
			
		 }else{
		 
            $code= '';
			
		 }
		 
	    if (isset($this->request->get['vcode'])){
		
			$vcode= $this->request->get['vcode'];
			
		 }else{
		 
			$vcode= '';
			
		 }
			 
		   $email=base64_decode($code);

		 
		 	 if($vcode){
			 
				$sql="select expire_time from oc_customer_rspwd_url_expire where random_md5 = '".$vcode."' AND email = '". $email ."' AND type = 0 ";
			
				$rows=$this->db->query($sql);
			
				
				if(isset($rows->row['expire_time'] ) && !empty($rows->row['expire_time'])){
				
					$expire_time=$rows->row['expire_time'];
					
					if( time() < $expire_time ){
					
						$this->data['is_valid']=1;
						
					}else{
							$this->data['is_valid']=0;
					}
				}else{
					
						$this->data['is_valid']=0;
						
					}
			 }else{
					
						$this->data['is_valid']=0;
						
					}
			 
		 //print($this->data['is_valid']);
		$this->data['code']= $code;
		$this->data['vcode']= $vcode;
		$this->template = 'cnstorm/template/account/modifypd.tpl';
        $this->response->setOutput($this->render());
	}
	
	public function confirmPwd(){
	
		if($this->request->post){
	
			if (isset($this->request->post['code'])){
				$code= $this->request->post['code'];
			 }else{
				$code= '';
			 }
			 
			 if (isset($this->request->post['vcode'])){
				$vcode= $this->request->post['vcode'];
			 }else{
				$vcode= '';
			 }
			 
			  if (isset($this->request->post['password'])){
					$password= $this->request->post['password'];
			 }else{
					$password= '';
			 }
			 
			  $email=base64_decode($code);
			  
			 //判断地址是否过期
			
		 
			 $this->load->model('account/customer');
			 
			 $this->model_account_customer->editPassword( $email,$password);
			 
			 $this->db->query("UPDATE oc_customer_rspwd_url_expire set type = 1 where email='".$email."' and random_md5 = '".$vcode."'");
			 
			 $this->response->setOutput(1);

		}else{
				  $this->redirect($this->url->link('/', '', 'SSL'));
	 }
			 
	}
}