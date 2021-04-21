<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model {

	private $tabel = 'tb_brand';

	public function getData()
	{
		return $this->db->get($this->tabel);
	}

	public function where($data = []) 
	{
		return $this->db->where($data);
	}

	public function like($data = []) 
	{
		return $this->db->like($data);
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

/* End of file Brand_model.php */
/* Location: ./application/models/Brand_model.php */