<?php

class Cidades extends CI_Controller {

    function __construct() {
        parent::__construct();

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('controle/login');
        }

		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('cidades_model','',TRUE);
	}

  public function getByCodigoIbge(){
      if (isset($_GET['codigoIbge'])){
        echo json_encode($this->cidades_model->getByCodigoIbge($_GET['codigoIbge']));
      }
  }

    public function autoCompleteCidade(){

        if (isset($_GET['term'])){
          $estado = $_GET['estado'];
          echo 'Estado '.$estado;
          $this->cidades_model->autoCompleteCidade($_GET['term'], $estado);
        }

    }

}
