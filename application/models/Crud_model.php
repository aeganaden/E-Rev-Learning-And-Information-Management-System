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

    public function fetch_select($table, $col = NULL, $where = NULL, $orwherein = NULL, $distinct = NULL) {
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
        $query = $this->db->get($table);
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
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

    public function fetch_join($table, $col = NULL, $join1 = NULL, $jointype = NULL, $join2 = NULL, $where = NULL) {
        if (!empty($where)) {
            $this->db->where($where);
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
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}

?>