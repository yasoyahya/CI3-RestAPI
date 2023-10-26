<?php

class Paket extends CI_Model
{
    private $paket = 'paket';

    public function getData($id=null)
    {
        if ($id==null) {
            # code...
            return $this->db->get($this->paket)->result_array();
        } else {
            return $this->db->get_where($this->paket,['id' => $id])->result_array();
        }
    }
    public function storeData($data)
    {
        $this->db->insert($this->paket, $data);
        return $this->db->affected_rows();
    }
    public function updateData($data, $id)
    {
        $this->db->update($this->paket, $data, ['id'=> $id]);
        return $this->db->affected_rows();
    }
    public function deleteData($id)
    {
        $this->db->delete($this->paket, ['id'=> $id]);
        return $this->db->affected_rows();

    }
}
