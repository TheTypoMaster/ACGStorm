<?php
class ControllerHelpHelp extends Controller {

    public function index() {
        $this->load->model('help/help');

        $this->data['qc'] = array();
        $this->data['questions'] = array();
        if (array_key_exists('cid', $_REQUEST) && !array_key_exists('qid', $_REQUEST)) {
            $this->data['qc'] = $this->model_help_help->getCategory($_REQUEST['cid']);
            $this->data['questions'] = $this->model_help_help->getQuestions($_REQUEST['cid']);
        }

        if (array_key_exists('qid', $_REQUEST)) {
            $question = $this->model_help_help->getQuestion($_REQUEST['qid']);
            // $content = $this->clearHtml(htmlspecialchars_decode($question['content']));
            // $question['content'] = $content;
            $this->data['question'] = $question;
        }

        $categories = $this->model_help_help->getCategories(0);

        $result = array();
        foreach ($categories as $category) {
            $subCategories = $this->model_help_help->getCategories($category['help_category_id']);
            $sub = array();
            foreach ($subCategories as $subCategory) {
                $sub[] = array(
                    'id' => $subCategory['help_category_id'],
                    'name' => $subCategory['name']
                    );
            }

            $result[] = array(
                'id' => $category['help_category_id'],
                'name' => $category['name'],
                'sub' => $sub
                );
            
        }

		$this->data['categories'] = $result;
		$daigou=$this->model_help_help->NewgetQuestion("49,50,51");
		$jifen=$this->model_help_help->NewgetQuestion("41,65,63,66,64");
		$kefu=$this->model_help_help->NewgetQuestion("44,54,52,56");
		$peisong=$this->model_help_help->NewgetQuestion("42,62,61,58,60,59");
		$zhifu=$this->model_help_help->NewgetQuestion('40,57');
		$mima=$this->model_help_help->likeTitle('密码');
		
		$this->data['daigou'] = $daigou;
		$this->data['jifen'] = $jifen;
		$this->data['kefu'] = $kefu;
		$this->data['peisong'] = $peisong; 
		$this->data['zhifu'] = $zhifu; 
		$this->data['mima'] = $mima; 
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/help/help_center_home.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/help/help_center_home.tpl';
        } else {
            $this->template = 'default/template/help/help_center_home.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header_transport'
        );
        
        $this->response->setOutput($this->render());
    }

    public function clearHtml($content) {
        $result = preg_replace('/<a[^>]*>/i', '', $content);
        $result = preg_replace('/<\/a>/i', '', $content);
        $result = preg_replace('/<div[^>]*>/i', '', $content);
        $result = preg_replace('/<\/div>/i', '', $content);
        $result = preg_replace('/<!--[^>]*-->/i', '', $content);
        $result = preg_replace("/style=.+?['|\"]/i", '', $content);
        $result = preg_replace("/class=.+?['|\"]/i", '', $content);
        $result = preg_replace("/id=.+?['|\"]/i", '', $content);
        $result = preg_replace("/lang=.+?['|\"]/i", '', $content);
        $result = preg_replace("/width=.+?['|\"]/i", '', $content);
        $result = preg_replace("/height=.+?['|\"]/i", '', $content);
        $result = preg_replace("/border=.+?['|\"]/i", '', $content);
        $result = preg_replace("/face=.+?['|\"]/i", '', $content);
        $result = preg_replace("/face=.+?['|\"]/", '', $content);
        return $result;
    }

}
    
?>