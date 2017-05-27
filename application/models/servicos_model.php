<?php
class Servicos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){

        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idServicos','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getById($id){
        $this->db->where('idServicos',$id);
        $this->db->limit(1);
        return $this->db->get('servicos')->row();
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

  public function autoCompleteServico($q){

      $this->db->select('*');
      $this->db->limit(10);
      $this->db->like('nome', $q);
      $query = $this->db->get('servicos');
      if($query->num_rows > 0){
          foreach ($query->result_array() as $row){
              $row_set[] = array('label'=>$row['nome'].' | Preço: R$ '.$row['preco'],'id'=>$row['idServicos'],'preco'=>$row['preco']);
          }
          echo json_encode($row_set);
      }
  }
}
