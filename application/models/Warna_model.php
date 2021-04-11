<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warna_model extends CI_Model {

	private $tabel = 'tb_warna';

	public function getData()
	{
		return $this->db->get($this->tabel);
	}

	public function where($data = []) 
	{
		return $this->db->where($data);
	}

	public function insert($data) 
	{
		if ($this->db->insert($this->tabel, $data)) {
			return [
				'status' => 'berhasil',
				'insert_id' => $this->db->insert_id(),
			];
		} else {
			return [
				'status' => 'gagal',
			];
		}
	}

	public function update($where, $data) 
	{
		if ($this->db
			->where($where)
			->update($this->tabel, $data)) {
			return [
				'status' => 'berhasil',
			];
		} else {
			return [
				'status' => 'gagal',
			];
		}
	}
}

/* End of file Warna_model.php */
/* Location: ./application/models/Warna_model.php */