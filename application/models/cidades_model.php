<?php
class Cidades_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get($q){
        $this->db->select('cidades.*, estados.sigla');
        $this->db->from('cidades');
        $this->db->join('estados','estados.idEstado = cidades.estado_id');
        $where = '';
        if($q){
          $where = 'cidades.nome like \'%'.$q.'%\' ';
          $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function autoCompleteCidade($q, $estado){

        $result = $this->get($q, $estado);
            foreach ($result as $row){
                $row_set[] = array('label'=>$row['sigla'].' | '.$row['nome'], 'id'=>$row['idCidade'], 'estado_id'=>$row['estado_id']);
            }
            echo json_encode($row_set);
    }

    function getById($id){
        $this->db->select('cidades.*, estados.sigla');
        $this->db->from('cidades');
        $this->db->join('estados','estados.idEstado = cidades.estado_id');
        $this->db->where('idCidade',$id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function getByCodigoIbge($codigoIbge){
        $this->db->where('codigo_ibge',$codigoIbge);
        $this->db->limit(1);
        return $this->db->get('cidades')->row();
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
