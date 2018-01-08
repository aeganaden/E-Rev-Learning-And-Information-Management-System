<?php

class Crud_model extends CI_Model {

    public function fetch($table, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }


    public function fetch_or($table, $where = NULL, $orwhere = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
            $this->db->or_where($orwhere);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function countResult($table, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    public function insert_batch($table, $data) {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    public function update($table, $data, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function delete($table, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->delete($table);
        return $this->db->last_query();
    }
    public function make_query()

    {
      $table = "lecturer_attendance";
      $column = array("lecturer_attendance_id","lecturer_attendance_date","lecturer_attendance_in","lecturer_attendance_out","offering_id");
      $order_column = array(null,"lecturer_attendance_date","lecturer_attendance_in","lecturer_attendance_out",null);

      $this->db->select($column);
      $this->db->from($table);
      if (isset($_POST["order"])) {     
          $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);  
      }
      else{       
        $this->db->order_by("lecturer_attendance_id","DESC");    
    }
}


public function make_datatables()
{
 $this->make_query();
 if ($_POST["length"] != -1) {
    $this->db->limit($_POST["length"], $_POST["start"]);
}
$query = $this->db->get();
return $query->result();
}

public function get_filtered_data()
{
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
}

public function get_all_data()
{
    $table = "lecturer_attendance";
    $this->db->select("*");
    $this->db->from($table);
    return $this->db->count_all_results();
}










}

?>