<?php
class ControllerOrderUpfile extends Controller {
//代购下单
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->template = 'cnstorm/template/order/upfile.tpl';
        $this->response->setOutput($this->render());
    }
}
?>