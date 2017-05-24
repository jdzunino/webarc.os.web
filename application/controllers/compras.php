<?php

class Compras extends CI_Controller {

    function __construct() {
        parent::__construct();

        if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('controle/login');
        }

		$this->load->helper(array('form','codegen_helper'));
		$this->load->model('compras_model','',TRUE);
    $this->load->model('cidades_model','',TRUE);
		$this->data['menuCompras'] = 'Compras';
	}

	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar compras.');
           redirect(base_url());
        }

        $this->load->library('pagination');


        $config['base_url'] = base_url().'index.php/compras/gerenciar/';
        $config['total_rows'] = $this->compras_model->count('compras');
        $config['per_page'] = 10;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

		$this->data['results'] = $this->compras_model->get('compras','*','',$config['per_page'],$this->uri->segment(3));

	    $this->data['view'] = 'compras/compras';
       	$this->load->view('tema/topo',$this->data);
    }

    function adicionar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para adicionar Compras.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('compras') == false) {
           $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataCompra = $this->input->post('dataCompra');

            try {

                $dataCompra = explode('/', $dataCompra);
                $dataCompra = $dataCompra[2].'-'.$dataCompra[1].'-'.$dataCompra[0];

            } catch (Exception $e) {
               $dataCompra = date('Y/m/d');
            }

            $data = array(
                'dataCompra' => $dataCompra,
                'fornecedor_id' => $this->input->post('fornecedor_id'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'faturado' => 0
            );

            if (is_numeric($id = $this->compras_model->add('compras', $data, true)) ) {
                $this->session->set_flashdata('success','Compra iniciada com sucesso, adicione os produtos.');
                redirect('compras/editar/'.$id);

            } else {

                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'compras/adicionarCompra';
        $this->load->view('tema/topo', $this->data);
    }



    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('controle');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar compras');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('compras') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $dataCompra = $this->input->post('dataCompra');

            try {

                $dataCompra = explode('/', $dataCompra);
                $dataCompra = $dataCompra[2].'-'.$dataCompra[1].'-'.$dataCompra[0];

            } catch (Exception $e) {
               $dataCompra = date('Y/m/d');
            }

            $data = array(
                'dataCompra' => $dataCompra,
                'usuarios_id' => $this->input->post('usuarios_id'),
                'fornecedor_id' => $this->input->post('fornecedor_id')
            );

            if ($this->compras_model->edit('compras', $data, 'idCompras', $this->input->post('idCompras')) == TRUE) {
                $this->session->set_flashdata('success','Compra editada com sucesso!');
                redirect(base_url() . 'index.php/compras/editar/'.$this->input->post('idCompras'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->compras_model->getById($this->uri->segment(3));
        $this->data['cidade'] = $this->cidades_model->getById($this->data['result']->cidade_id);
        $this->data['produtos'] = $this->compras_model->getProdutos($this->uri->segment(3));
        $this->data['view'] = 'compras/editarCompra';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('controle');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para visualizar compras.');
          redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('controle_model');
        $this->data['result'] = $this->compras_model->getById($this->uri->segment(3));
        $this->data['cidade'] = $this->cidades_model->getById($this->data['result']->cidade_id);
        echo json_encode($this->data['result']);
        $this->data['produtos'] = $this->compras_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->controle_model->getEmitente();

        $this->data['view'] = 'compras/visualizarCompra';
        $this->load->view('tema/topo', $this->data);

    }

    function excluir(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para excluir compras');
          redirect(base_url());
        }

        $id =  $this->input->post('id');
        if ($id == null){

            $this->session->set_flashdata('error','Erro ao tentar excluir compra.');
            redirect(base_url().'index.php/compras/gerenciar/');
        }

        $this->db->where('compras_id', $id);
        $this->db->delete('itens_de_compras');

        $this->db->where('idCompras', $id);
        $this->db->delete('compras');

        $this->session->set_flashdata('success','Compra excluída com sucesso!');
        redirect(base_url().'index.php/compras/gerenciar/');

    }

    public function adicionarProduto(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
          $this->session->set_flashdata('error','Você não tem permissão para editar compras.');
          redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required|xss_clean');
        $this->form_validation->set_rules('idComprasProduto', 'Compras', 'trim|required|xss_clean');

        if($this->form_validation->run() == false){
           echo json_encode(array('result'=> false));
        }
        else{

            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = array(
                'quantidade'=> $quantidade,
                'subTotal'=> $subtotal,
                'produtos_id'=> $produto,
                'compras_id'=> $this->input->post('idComprasProduto'),
            );

            if($this->compras_model->add('itens_de_compras', $data) == true){
                $sql = "UPDATE produtos set estoque = estoque + ? WHERE idProdutos = ?";
                $this->db->query($sql, array($quantidade, $produto));

                echo json_encode(array('result'=> true));
            }else{
                echo json_encode(array('result'=> false));
            }

        }


    }

    function excluirProduto(){

            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Compras');
              redirect(base_url());
            }

            $ID = $this->input->post('idProduto');
            if($this->compras_model->delete('itens_de_compras','idItens',$ID) == true){

                $quantidade = $this->input->post('quantidade');
                $produto = $this->input->post('produto');


                $sql = "UPDATE produtos set estoque = estoque - ? WHERE idProdutos = ?";

                $this->db->query($sql, array($quantidade, $produto));

                echo json_encode(array('result'=> true));
            }
            else{
                echo json_encode(array('result'=> false));
            }
    }



    public function faturar() {

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
              $this->session->set_flashdata('error','Você não tem permissão para editar Compras');
              redirect(base_url());
            }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';


        if ($this->form_validation->run('despesa') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $vencimento = $this->input->post('vencimento');
            $recebido = $this->input->post('recebido');
            $recebimento = $this->input->post('recebimento');

            if($recebido == '1'){
              if($recebimento != null){
                  $recebimento = explode('/', $recebimento);
                  $recebimento = $recebimento[2].'-'.$recebimento[1].'-'.$recebimento[0];
              }
            }else{
              $recebimento = null;
            }
            $vencimento = explode('/', $vencimento);
            $vencimento = $vencimento[2].'-'.$vencimento[1].'-'.$vencimento[0];

            $data = array(
                'descricao' => set_value('descricao'),
                'valor' => $this->input->post('valor'),
                'clientes_id' => $this->input->post('fornecedor_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $recebido,
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo')
            );

            if ($this->compras_model->add('lancamentos',$data) == TRUE) {

                $compra = $this->input->post('compras_id');

                $this->db->set('faturado',1);
                $this->db->set('valorTotal',$this->input->post('valor'));
                $this->db->where('idCompras', $compra);
                $this->db->update('compras');

                $this->session->set_flashdata('success','Compra faturada com sucesso!');
                $json = array('result'=>  true);
                echo json_encode($json);
                die();
            } else {
                $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar compra.');
                $json = array('result'=>  false);
                echo json_encode($json);
                die();
            }
        }

        $this->session->set_flashdata('error','Ocorreu um erro ao tentar faturar compra.');
        $json = array('result'=>  false);
        echo json_encode($json);

    }


}
