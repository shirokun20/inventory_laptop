<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basic_model extends CI_Model 
{
	public function menambah($tabel, $data)
    {
        if ($this->db->insert($tabel, $data)) {
            return array(
                'status' => 'berhasil',
                'nilai'  => $this->db->insert_id(),
            );
        } else {
            return array('status' => 'gagal');
        }
    }

    public function menghapus($tabel, $data)
    {
        $this->db->where($data);
        if ($this->db->delete($tabel)) {
            return array('status' => 'berhasil');
        } else {
            return array('status' => 'gagal');
        }
    }

    public function mengubah($tabel, $where, $data)
    {
        $this->db->where($where);
        if ($this->db->update($tabel, $data)) {
            return array('status' => 'berhasil');
        } else {
            return array('status' => 'gagal');
        }
    }
}

/* End of file Basic_model.php */
/* Location: ./application/models/Basic_model.php */