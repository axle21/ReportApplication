<?php
class Pages extends CI_Controller {

    public function index($page = 'home')
    {
    	if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['data_1'] = array('1', '2' , '3');
        $data['data_2'] = "Data 2";
        $data['data_3'] = "Data 3";

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function sample()
    {
    	echo "<pre>";
    	echo "Another function";
    }
}