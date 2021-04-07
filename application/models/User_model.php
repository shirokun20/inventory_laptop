<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	// Tabel
	private $table = 'tb_user u';
	private $table_type = 'tb_jabatan t';
	private $table_status = 'tb_status_user s';
	// Pengurutan
	private $columnOrder 	= [
		'u.user_id', 
		'u.user_nama', 
		'u.user_email', 
		't.jabatan_nama',
		's.status_user_nama',
		null,
	];
	// Pencarian
	private $columnSearch 	= [
		'u.user_id', 
		'u.user_nama', 
		'u.user_email', 
		't.jabatan_nama',
		's.status_user_nama',
	];
	// Urukan
	private $orderBy 		= ['u.user_id' => 'DESC'];
	// Select field
	public function _setSelect()
	{
		$this->db->select('u.*');
		$this->db->select('t.jabatan_nama');
		$this->db->select('s.status_user_nama');
	}
	// Relasi
	public function _setJoin()
	{
		$this->db->join($this->table_type, 't.jabatan_id = u.jabatan_id');
		$this->db->join($this->table_status, 's.status_user_id = u.status_user_id');
	}
	// 
	public function _setWhere()
	{
		$jabatan_id = $this->input->post('jabatan_id');
		if ($jabatan_id != 0) {
			$this->db->where('u.jabatan_id', $jabatan_id);
		}
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
		$this->_setWhere();
		$this->_setLimit();
		$this->db->from($this->table);
		$this->datatables->generate($this->columnOrder, $this->columnSearch, $this->orderBy);
	}
	// 
	private function _countResult() 
	{
		$this->_setWhere();
		return $this->db->count_all_results($this->table);
	}
	// 
	private function _statusUser($status_user_nama, $status_user_id = 1) 
	{
		if ($status_user_id == 1) {
			return '<b style="color: green">'.$status_user_nama.'</b>';
		} else {
			return '<b style="color: red">'.$status_user_nama.'</b>';
		}
	}
	// 
	private function _buttonUser($data) 
	{
		$button = '<div class="dropdown-primary dropdown open">';
        $button .= '<button class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" type="button" id="dropdown-'.$data->user_id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Aksi</button>';
        $button .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-'.$data->user_id.'" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">';
        if ($data->jabatan_id == 2) {
    	// 
    	$button .= '<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="detailPengguna('."'".$data->user_id."'".')">Detail</a>';
    	// 
    	}
        $button .= '<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="editClick('."'".$data->user_id."'".')">Edit</a>';
        $button .= '<div class="dropdown-divider"></div>';
        if ($data->status_user_id == 1) {
        	$button .= '<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="ubahStatusConfirm('."'".$data->user_id."', 2".')">Suspend</a>';
        } else {
        	$button .= '<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="ubahStatusConfirm('."'".$data->user_id."', 1".')">Aktifkan</a>';
        }
        $button .= '<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="hapusDataConfirm('."'". $data->user_id ."'".')">Hapus</a>';
        $button .= '</div>';
        $button .='</div>';
        return $button;
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
	   	 	$row[]	= $field->user_nama ? ucwords($field->user_nama) : '-';
	   	 	$row[]	= $field->user_email ? $field->user_email : '-';
	   	 	$row[]	= $field->jabatan_nama ? $field->jabatan_nama : '-';
	   	 	$row[]	= $field->status_user_nama ? $this->_statusUser($field->status_user_nama, $field->status_user_id) : '-';
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
	public function jumlah_pengguna($jabatan_id = 0) 
	{
		if ($jabatan_id != 0) {
			$this->db->where('u.jabatan_id', $jabatan_id);
		}
		return $this->db->count_all_results($this->table);
	}

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */