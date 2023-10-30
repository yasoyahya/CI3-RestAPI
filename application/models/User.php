<?php

class User extends CI_Model
{
    private $user = 'user';
    public function doLogin($username, $password)
    {
        $query = $this->db->get_where($this->user, ['username' => $username, 'password' => $password]);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getData($id = null)
    {
        // if ($id == null) {
        //     return $this->db->get($this->user)->result_array();
        // } else {
        //     return $this->db->get_where($this->user, ['id' => $id])->result_array();
        // }

        if ($id == null) {
            $this->db->select('id, name, username');
            return $this->db->get($this->user)->result_array();
        } else {
            $this->db->select('id, name, username');
            return $this->db->get_where($this->user,
                ['id' => $id]
            )->result_array();
        }

    }
}
