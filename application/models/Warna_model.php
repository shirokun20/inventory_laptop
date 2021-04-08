<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warna_model extends CI_Model {

	private $tabel = 'tb_warna';

	public function getData()
	{
		return $this->db->get($this->tabel);
	}
	

}

/* End of file Warna_model.php */
/* Location: ./application/models/Warna_model.php */