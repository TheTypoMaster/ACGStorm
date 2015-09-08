<?php
Class ControllerTestTest extends Controller {

	public function index() {


        $this->template = 'cnstorm/template/test/test.tpl';

        $this->children = array(
            'common/header_business',
            'common/footer_business');

        $this->response->setOutput($this->render());
		

}


}