<?php

class Estados extends CI_Controller {

    function __construct() {
        parent::__construct();

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('controle/login');
        }

		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('estados_model','',TRUE);
	}

    public function autoCompleteEstado(){

        if (isset($_GET['term'])){
          $q = $_GET['term'];
          $this->estados_model->autoCompleteEstado($q);
        }

    }

}
