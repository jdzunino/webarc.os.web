<?php
class Estados_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get($q = null){
        $this->db->select('estados.*');
        $this->db->from('estados');
        if($q){
            $where = 'nome like \'%'.$q.'%\' OR sigla LIKE \'%'.$q.'%\'';
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result();;
    }

    public function autoCompleteEstado($q){

        $query = $this->get($q);
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = array('label'=>$row['sigla'].' | '.$row['nome'], 'id'=>$row['idEstado']);
            }
            echo json_encode($row_set);
        }
    }

    function getById($id){
        $this->db->where('idEstado',$id);
        $this->db->limit(1);
        return $this->db->get('estados')->row();
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
}
