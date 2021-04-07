<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model 
{

	private $tabel = 'tb_user';
	
	public function auth($email = '')
	{
		$this->db->where('user_email', $email);
		$this->db->limit(1);
		return $this->db->get($this->tabel);
	}

	public function getUserJabatan($jabatan_id = 0)
	{
		return $this->db->where('jabatan_id', $jabatan_id)->get('tb_jabatan');
	}
}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */