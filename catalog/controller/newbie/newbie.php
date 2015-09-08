<?php
class ControllerNewbieNewbie extends Controller
{
    
    public function index()
    {
        $this->data['zizhugou'] = $this->url->link('newbie/newbie/zizhugou', '', 'SSL');
        $this->data['daiji']    = $this->url->link('newbie/newbie/daiji', '', 'SSL');
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/newbie/daigou.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/newbie/daigou.tpl';
        } else {
            $this->template = 'default/template/newbie/daigou.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header_transport'
        );
        
        $this->response->setOutput($this->render());
    }
    
    public function zizhugou()
    {
        
        $this->data['daigou'] = $this->url->link('newbie/newbie', '', 'SSL');
        $this->data['daiji']  = $this->url->link('newbie/newbie/daiji', '', 'SSL');
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/newbie/zizhugou.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/newbie/zizhugou.tpl';
        } else {
            $this->template = 'default/template/noviceteaching/zizhugou.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }
    
    public function daiji()
    {
        
        $this->data['daigou']   = $this->url->link('newbie/newbie', '', 'SSL');
        $this->data['zizhugou'] = $this->url->link('newbie/newbie/zizhugou', '', 'SSL');
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/newbie/daiji.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/newbie/daiji.tpl';
        } else {
            $this->template = 'default/template/noviceteaching/daiji.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }
}
?>