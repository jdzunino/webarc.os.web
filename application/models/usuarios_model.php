<?php
class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }



    function get($perpage=0,$start=0,$one=false){

        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->limit($perpage,$start);
        $this->db->join('permissoes', 'usuarios.permissoes_id = permissoes.idPermissao', 'left');

        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

     function getAllTipos(){
        $this->db->where('situacao',1);
        return $this->db->get('tiposUsuario')->result();
    }

    function getById($id){
        $this->db->where('idUsuarios',$id);
        $this->db->limit(1);
        return $this->db->get('usuarios')->row();
    }

    function add($table,$data){
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1')
		{
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

  public function autoCompleteUsuario($q){
      $this->db->select('*');
      $this->db->limit(10);
      $this->db->like('nome', $q);
      $this->db->where('situacao',1);
      $query = $this->db->get('usuarios');
      if($query->num_rows > 0){
          foreach ($query->result_array() as $row){
              $row_set[] = array('label'=>$row['nome'].' | Telefone: '.$row['telefone'],'id'=>$row['idUsuarios']);
          }
          echo json_encode($row_set);
      }
  }
}
