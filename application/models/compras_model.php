<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compras_model extends CI_Model {

	function __construct() {
        parent::__construct();
    }


    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

				//TODO https://trello.com/c/wc7yzlnY/60-cadastro-de-fornecedor Ajustar chave estrangeira para Fornecedor
        $this->db->select($fields.', clientes.nomeCliente, clientes.idClientes');
        $this->db->from($table);
        $this->db->limit($perpage,$start);
        $this->db->join('clientes', 'clientes.idClientes = '.$table.'.fornecedor_id');
        $this->db->order_by('idCompras','desc');
        if($where){
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
			  //TODO https://trello.com/c/wc7yzlnY/60-cadastro-de-fornecedor Ajustar chave estrangeira para Fornecedor
        $this->db->select('compras.*, clientes.*, usuarios.telefone, usuarios.email,usuarios.nome');
        $this->db->from('compras');
        $this->db->join('clientes','clientes.idClientes = compras.fornecedor_id');
        $this->db->join('usuarios','usuarios.idUsuarios = compras.usuarios_id');
        $this->db->where('compras.idCompras',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function getProdutos($id = null){
        $this->db->select('itens_de_compras.*, produtos.*');
        $this->db->from('itens_de_compras');
        $this->db->join('produtos','produtos.idProdutos = itens_de_compras.produtos_id');
        $this->db->where('compras_id',$id);
        return $this->db->get()->result();
    }


    function add($table,$data,$returnId = false){
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1')
		{
                        if($returnId == true){
                            return $this->db->insert_id($table);
                        }
			return TRUE;
		}

		return FALSE;
    }

    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
		{
			return TRUE;
		}

		return FALSE;
    }

    function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}

		return FALSE;
    }

    function count($table){
			return $this->db->count_all($table);
    }

}
