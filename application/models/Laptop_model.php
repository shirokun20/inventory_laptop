<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laptop_model extends CI_Model {
	// Tabel
	private $table = 'tb_barang bar';
	private $table_brand = 'tb_brand bra';
	// Pengurutan
	private $columnOrder 	= [
		'bar.barang_kode', 
		'bar.barang_name', 
		'bra.brand_nama', 
		'bar.barang_model',
		null,
		null,
	];
	// Pencarian
	private $columnSearch 	= [
		'bar.barang_kode', 
		'bar.barang_name', 
		'bra.brand_nama', 
		'bar.barang_model',
	];
	// Urukan
	private $orderBy 		= ['bar.barang_kode' => 'DESC'];
	// Select field
	public function _setSelect()
	{
		$this->db->select('bar.*');
		$this->db->select('bra.brand_nama');
		$this->db->select('(SELECT sum(stok.stok_qty) from tb_stok stok where stok.barang_kode = bar.barang_kode) as stok');
	}
	// Relasi
	public function _setJoin()
	{
		$this->db->join($this->table_brand, 'bar.brand_id = bra.brand_id');
	}
	// 
	private function _setLimit()
	{
		$limit = $this->input->post('length') + 1 + $this->input->post('start');
		$this->db->limit($limit);
	}
	// 
	private function _getBuilder()
	{
		$this->_setSelect();
		$this->_setJoin();
		$this->_setLimit();
		$this->db->from($this->table);
		$this->datatables->generate($this->columnOrder, $this->columnSearch, $this->orderBy);
	}
	// 
	private function _countResult() 
	{
		return $this->db->count_all_results($this->table);
	}
	//
	public function getDataTables()
	{
		$query 	= $this->datatables->getResult($this->_getBuilder());
		$data 	= array();
		$start  = $this->input->post('start');
		$no  	= $start + 1;
		foreach ($query as $field) {
		    $row    = array();
		    $row[]  = $no++;
	   	 	$row[]	= $field->barang_kode ? ucwords($field->barang_kode) : '-';
	   	 	$row[]	= $field->barang_name ? $field->barang_name : '-';
	   	 	$row[]	= $field->brand_nama ? $field->brand_nama : '-';
	   	 	$row[]	= $field->barang_model ? $field->barang_model : '-';
	   	 	$row[]	= $field->stok ? $field->stok : '0';
		    $row[]	= $this->_buttonUser($field);
		    $data[] = $row;
		}

		$output = [
			'draw' 				=> $this->input->post('draw'), 
			'recordsTotal' 	 	=> $this->_countResult(), 
			'recordsFiltered'	=> $this->db->get($this->_getBuilder())->num_rows(), 
			'data' 				=> $data, 
		];

		return $output;
	}
	// 
	private function _buttonUser($data) 
	{
		$button = '<div class="dropdown-primary dropdown open">';
        $button .= '<button class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" type="button" id="dropdown-'.$data->barang_kode.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Aksi</button>';
        $button .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-'.$data->barang_kode.'" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">';
    	// 
    	$button .= '<a class="dropdown-item waves-light waves-effect" href="'. site_url('admin/master_inventory/master_laptop/detail/' . md5($data->barang_kode)) .'">Detail</a>';
    	// 
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item waves-light waves-effect" href="'. site_url('admin/master_inventory/master_laptop/edit/' . md5($data->barang_kode)) .'">Edit</a>';
        $button .= '<div class="dropdown-divider"></div>';
        $button .= '<a class="dropdown-item waves-light waves-effect" href="'. site_url('admin/master_inventory/master_laptop/hapus/' . md5($data->barang_kode)) .'" onclick="return confirm('."'Apakah anda yakin?'".')">Hapus</a>';
        $button .= '</div>';
        $button .='</div>';
        return $button;
	}
	// 
}

/* End of file Laptop_model.php */
/* Location: ./application/models/Laptop_model.php */