<?php

class Crud_model extends CI_Model {

    public function fetch($table, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get($table);
        return ( $query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function fetch_or($table, $where = NULL, $orwhere = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
            $this->db->or_where($orwhere);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function fetch_last($table, $column) {
        $query = $this->db->order_by($column, "desc")->limit(1)->get($table)->row();
        return ($query) ? $query : FALSE;
    } 
    public function fetch_first($table, $column,$where=NULL) {
      if (!empty($where)) {
        $this->db->where($where);
    }
    $query = $this->db->order_by($column, "asc")->limit(1)->get($table)->row();
    return ($query) ? $query : FALSE;
}

public function countResult($table, $where = NULL) {
    if (!empty($where)) {
        $this->db->where($where);
    }
    $query = $this->db->get($table);
    return $query->num_rows();
}

public function insert($table, $data) {
    if (!$this->db->insert($table, $data)) {
            return $this->db->error(); // Has keys 'code' and 'message'
        } else {
            return $this->db->affected_rows();
        }
    }

    public function insert_batch($table, $data) {
        if (!$this->db->insert_batch($table, $data)) {
            return $this->db->error(); // Has keys 'code' and 'message'
        } else {
            return $this->db->affected_rows();
        }
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

    public function table_names() {
        return $this->db->list_tables();
    }

    public function col_names($table) {
        return $this->db->list_fields($table);
    }

    public function col_data($table) {
        return $this->db->field_data($table);
    }

    public function data_distinct($table, $col, $where = NULL, $orwhere = NULL) {          //returns single data instead of duplicated ones
        $this->db->distinct();
        $this->db->select($col);
        if (!empty($where)) {
            $this->db->where($where);
        }
//        if (!empty($orwhere)) {
//            $this->db->or_where($orwhere);
//        }

        return $this->db->get($table)->result();
    }

    public function fetch_select($table, $col = NULL, $where = NULL, $orwherein = NULL, $distinct = NULL, $wherein = NULL, $like = NULL, $resultinarray = NULL, $orderby = NULL, $limit = NULL) { //wherein used only to replace orwherein if it is not used
        if ($distinct == TRUE) {
            $this->db->distinct();
        }
        if (!empty($col)) {
            $this->db->select($col);
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($orwherein)) {
            $this->db->or_where_in($orwherein[0], $orwherein[1]);
        }
        if (!empty($wherein)) {
            $this->db->where_in($wherein[0], $wherein[1]);
        }
        if (!empty($like)) {
            $this->db->like($like[0], $like[1]);
        }
        if (!empty($orderby)) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }
        if (!empty($limit) && is_array($limit)) {       //limits results - mark
            $this->db->limit($limit[0], $limit[1]);
        } else if (!empty($limit) && !is_array($limit)) {
            $this->db->limit($limit);
        }

        $query = $this->db->get($table);
        if (!empty($resultinarray) && $resultinarray == TRUE) {             //changed to if-else for compatibility issues - mark
            return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        } else {
            return ($query->num_rows() > 0) ? $query->result() : FALSE;
        }
    }

    public function fetch_array($table, $col = NULL, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($col)) {
            $this->db->select($col);
        }
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function fetch_join($table, $col = NULL, $join1 = NULL, $jointype = NULL, $join2 = NULL, $where = NULL, $distinct = NULL, $resultinarray = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($distinct == TRUE) {        //depends sa irereturn na cols
            $this->db->distinct();
        }
        if (!empty($col)) {
            $this->db->select($col);
        } else {
            $this->db->select('*');
        }
        if (!empty($table)) {
            $this->db->from($table);
        }
        if (!empty($join1) && !empty($jointype)) {
            $this->db->join($join1[0], $join1[1], $jointype);
        } else if (!empty($join1) && empty($jointype)) {
            $this->db->join($join1[0], $join1[1]);
        }
        if (!empty($join2) && !empty($jointype)) {
            $this->db->join($join2[0], $join2[1], $jointype);
        } else if (!empty($join2) && empty($jointype)) {
            $this->db->join($join2[0], $join2[1]);
        }

        $query = $this->db->get();

        if (!empty($resultinarray) && $resultinarray == TRUE) {             //changed to if-else for compatibility issues - mark
            return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        } else {
            return ($query->num_rows() > 0) ? $query->result() : FALSE;
        }
    }

    public function mobile_check($table, $col = NULL, $like = NULL) {           //authentication on mobile
        if (!empty($like)) {
            $this->db->like('LOWER(' . $like[0] . ')', strtolower($like[1]));
            $this->db->like('LOWER(' . $like[2] . ')', strtolower($like[3]));
            $this->db->like('LOWER(' . $like[4] . ')', strtolower($like[5]));
            $this->db->like($like[6], $like[7]);
        }
        if (!empty($col)) {
            $this->db->select($col);
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($table)) {
            $this->db->from($table);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    public function fetch_join2($table, $col = NULL, $join = NULL, $jointype = NULL, $where = NULL, $distinct = NULL, $resultinarray = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($distinct == TRUE) {        //depends sa irereturn na cols
            $this->db->distinct();
        }
        if (!empty($col)) {
            $this->db->select($col);
        } else {
            $this->db->select('*');
        }
        if (!empty($table)) {
            $this->db->from($table);
        }
        if (!empty($join) && !empty($jointype)) {
            foreach ($join as $val) {
                $this->db->join($val[0], $val[1], $jointype);
            }
        } else if (!empty($join) && empty($jointype)) {
            foreach ($join as $val) {
                $this->db->join($val[0], $val[1]);
            }
        }

        $query = $this->db->get();

        if (!empty($resultinarray) && $resultinarray == TRUE) {             //changed to if-else for compatibility issues - mark
            return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        } else {
            return ($query->num_rows() > 0) ? $query->result() : FALSE;
        }
    }

}

?>