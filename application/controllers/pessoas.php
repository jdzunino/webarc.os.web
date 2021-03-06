<?php

class Pessoas extends CI_Controller {

    function __construct() {
        parent::__construct();
            if((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))){
              redirect('controle/login');
            }
            $this->load->helper(array('codegen_helper'));
            $this->load->model('pessoas_model','',TRUE);
            $this->load->model('estados_model','',TRUE);
            $this->load->model('cidades_model','',TRUE);
            $this->data['menuClientes'] = 'pessoas';
	}

	function index(){
		$this->gerenciar();
	}

	function gerenciar(){

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar pessoas.');
           redirect(base_url());
        }
        $this->load->library('table');
        $this->load->library('pagination');


        $config['base_url'] = base_url().'index.php/pessoas/gerenciar/';
        $config['total_rows'] = $this->pessoas_model->count('clientes');
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

	       $this->data['results'] = $this->pessoas_model->get('clientes','idClientes,nomeCliente,documento,telefone, tipoPessoa,celular,email,rua,numero,bairro,cidade_id,cep','',$config['per_page'],$this->uri->segment(3));

       	$this->data['view'] = 'pessoas/pessoas';
       	$this->load->view('tema/topo',$this->data);

    }

    function adicionar() {
        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'aCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para adicionar pessoas.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $data = array(
                'nomeCliente' => set_value('nomeCliente'),
                'documento' => set_value('documento'),
                'telefone' => set_value('telefone'),
                'tipoPessoa' =>  $this->input->post('tipoPessoa'),
                'celular' => set_value('celular'),
                'email' => set_value('email'),
                'rua' => set_value('rua'),
                'numero' => set_value('numero'),
                'bairro' => set_value('bairro'),
                'cidade_id' =>  set_value('cidade_id'),
                'cep' => set_value('cep'),
                'dataCadastro' => date('Y-m-d'),
                'STACLF' => 'A'
            );

            if ($this->pessoas_model->add('clientes', $data) == TRUE) {
                $this->session->set_flashdata('success','Pessoa adicionada com sucesso!');
                redirect(base_url() . 'index.php/pessoas/adicionar/');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'pessoas/adicionarPessoa';
        $this->load->view('tema/topo', $this->data);

    }

    function editar() {

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('controle');
        }


        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para editar pessoas.');
           redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $data = array(
                'nomeCliente' => $this->input->post('nomeCliente'),
                'documento' => $this->input->post('documento'),
                'telefone' => $this->input->post('telefone'),
                'tipoPessoa' => $this->input->post('tipoPessoa'),
                'celular' => $this->input->post('celular'),
                'email' => $this->input->post('email'),
                'rua' => $this->input->post('rua'),
                'numero' => $this->input->post('numero'),
                'bairro' => $this->input->post('bairro'),
                'cidade_id' => $this->input->post('cidade_id'),
                'cep' => $this->input->post('cep')
            );

            if ($this->pessoas_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == TRUE) {
                $this->session->set_flashdata('success','Pessoa editada com sucesso!');
                redirect(base_url() . 'index.php/pessoas/editar/'.$this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->pessoas_model->getById($this->uri->segment(3));
        $cidade = $this->cidades_model->getById($this->data['result']->cidade_id);
        $estado = $this->estados_model->getById($cidade->estado_id);
        $this->data['result']->cidade = $estado->sigla.' | '.$cidade->nome;

        $this->data['view'] = 'pessoas/editarPessoa';
        $this->load->view('tema/topo', $this->data);

    }

    public function visualizar(){

        if(!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))){
            $this->session->set_flashdata('error','Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('controle');
        }

        if(!$this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){
           $this->session->set_flashdata('error','Você não tem permissão para visualizar pessoas.');
           redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->pessoas_model->getById($this->uri->segment(3));

        //TODO Cidade fixa
        $cidade = $this->cidades_model->getById(1);
        $estado = $this->estados_model->getById($cidade->estado_id);
        $this->data['result']->cidade = $estado->sigla.' | '.$cidade->nome;

        $this->data['results'] = $this->pessoas_model->getOsByCliente($this->uri->segment(3));
        $this->data['view'] = 'pessoas/visualizar';
        $this->load->view('tema/topo', $this->data);


    }

    public function excluir(){


            if(!$this->permission->checkPermission($this->session->userdata('permissao'),'dCliente')){
               $this->session->set_flashdata('error','Você não tem permissão para excluir pessoas.');
               redirect(base_url());
            }


            $id =  $this->input->post('id');
            if ($id == null){

                $this->session->set_flashdata('error','Erro ao tentar excluir cliente.');
                redirect(base_url().'index.php/pessoas/gerenciar/');
            }

            //$id = 2;
            // excluindo OSs vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $os = $this->db->get('os')->result();

            if($os != null){

                foreach ($os as $o) {
                    $this->db->where('os_id', $o->idOs);
                    $this->db->delete('servicos_os');

                    $this->db->where('os_id', $o->idOs);
                    $this->db->delete('produtos_os');


                    $this->db->where('idOs', $o->idOs);
                    $this->db->delete('os');
                }
            }

            // excluindo Vendas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $vendas = $this->db->get('vendas')->result();

            if($vendas != null){

                foreach ($vendas as $v) {
                    $this->db->where('vendas_id', $v->idVendas);
                    $this->db->delete('itens_de_vendas');


                    $this->db->where('idVendas', $v->idVendas);
                    $this->db->delete('vendas');
                }
            }

            //excluindo receitas vinculadas ao cliente
            $this->db->where('clientes_id', $id);
            $this->db->delete('lancamentos');



            $this->pessoas_model->delete('clientes','idClientes',$id);

            $this->session->set_flashdata('success','Cliente excluido com sucesso!');
            redirect(base_url().'index.php/pessoas/gerenciar/');
    }

    public function autoCompleteCliente(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $tipoPessoa = 1;
            $this->pessoas_model->autoCompletePessoa($q, $tipoPessoa);
        }

    }

    public function autoCompleteFornecedor(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $tipoPessoa = 2;
            $this->pessoas_model->autoCompletePessoa($q, $tipoPessoa);
        }

    }

    public function autoCompletePessoa(){

        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $tipoPessoa = null;
            $this->pessoas_model->autoCompletePessoa($q, $tipoPessoa);
        }

    }
}
