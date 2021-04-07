<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan_model extends CI_Model {

	private $table = 'tb_transaction tr';
	private $table_sp = 'tb_status_payment sp';
	private $table_st = 'tb_status_transaction st';
	private $table_us = 'tb_user us';
	// Pengurutan
	private $columnOrder 	= [
		'tr.transaction_id',
		'tr.transaction_invoice', 
		'tr.transaction_date', 
		'us.user_nama', 
		'tr.transaction_total_payment', 
		'st.status_transaction_nama', 
		'sp.status_payment_nama', 
		null,
	];
	// Pencarian
	private $columnSearch 	= [
		'tr.transaction_id',
		'tr.transaction_invoice', 
		'tr.transaction_date', 
		'us.user_nama', 
		'tr.transaction_total_payment', 
		'st.status_transaction_nama', 
		'sp.status_payment_nama', 
	];
	// Urukan
	private $orderBy 		= [
		'tr.transaction_id' => 'DESC'
	];
	// Select field
	public function _setSelect()
	{
		$this->db->select('tr.*');
		$this->db->select('sp.status_payment_nama');
		$this->db->select('st.status_transaction_nama');
		$this->db->select('us.user_nama');
	}
	// Relasi
	public function _setJoin()
	{
		$this->db->join($this->table_sp, 'sp.status_payment_id = tr.status_payment_id');
		$this->db->join($this->table_st, 'st.status_transaction_id = tr.status_transaction_id');
		$this->db->join($this->table_us, 'us.user_id = tr.user_id', 'left');
	}
	// 
	public function _setWhere()
	{
		$cari = $this->input->post('cari');
		$sti = $this->input->post('status_transaction_id');
		$spi = $this->input->post('status_payment_id');
		$tgl_a          = date('Y-m-d', strtotime($this->input->post('tanggal_a')));
        $tgl_b          = date('Y-m-d', strtotime($this->input->post('tanggal_b')));
		if ($cari != '' || $cari != null) {
			$this->db->group_start();
			$this->db->like('tr.transaction_invoice', $cari);
			$this->db->or_like('us.user_nama', $cari);
			$this->db->or_like('tr.transaction_total_payment', $cari);
			$this->db->group_end();
		}

		if ($sti != '' || $sti != null) {
			$this->db->where('tr.status_transaction_id', $sti);
		}

		if ($spi != '' || $spi != null) {
			$this->db->where('tr.status_payment_id', $spi);
		}

		if ($this->input->post('tanggal_a') != null && $this->input->post('tanggal_b') != null) {
            $this->db->where('DATE(tr.transaction_date) between "' . $tgl_a . '" and "' . $tgl_b . '"');
        } elseif ($this->input->post('tanggal_a') != null) {
            $this->db->where('DATE(tr.transaction_date)', $tgl_a);
        } elseif ($this->input->post('tanggal_b') != null) {
            $this->db->where('DATE(tr.transaction_date)', $tgl_b);
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
		$this->_setJoin();
		return $this->db->count_all_results($this->table);
	}
	// 
	private function _buttonPemesanan($data) 
	{
		$button = '<div class="dropdown-primary dropdown open">';
        $button .= '<button class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" type="button" id="dropdown-'.$data->transaction_id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Aksi</button>';
        $button .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-'.$data->transaction_id.'" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">';
    	$button .= '<a class="dropdown-item waves-light waves-effect" href="'.base_url('admin/transaksi/pemesanan/detail/' . base64_encode($data->transaction_id)).'">Detail</a>';
        $button .= '</div>';
        $button .='</div>';
        return $button;
	}
	// 
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
	   	 	$row[]	= $field->transaction_invoice ? ucwords($field->transaction_invoice) : '-';
	   	 	$row[]	= $field->transaction_date ? date('d M Y H:i', strtotime($field->transaction_date)) : '-';
	   	 	$row[]	= $field->user_nama ? $field->user_nama : '-';
	   	 	$row[]	= $field->transaction_total_payment ? number_format($field->transaction_total_payment) : '-';
	   	 	$row[]	= $field->status_transaction_nama ? $field->status_transaction_nama : '-';
	   	 	$row[]	= $field->status_payment_nama ? $field->status_payment_nama : '-';
		    $row[]	= $this->_buttonPemesanan($field);
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
	public function get_data($where = '') 
	{
		if ($where != null) {
			$this->db->where($where);
		}
		$this->_setSelect();
		$this->_setJoin();
		return $this->db->get($this->table);
	}
	// 
	public function jumlah_pemesanan($status_transaction_id = []) 
	{
		if ($status_transaction_id != 0) {
			$this->db->where_in('tr.status_transaction_id', $status_transaction_id);
		}
		return $this->db->count_all_results($this->table);
	}
	//
	public function uniqCode($where = null, $like = null) 
	{
		$this->db->select('MAX(RIGHT(transaction_invoice,5)) AS kd_max');
		if ($where != null) $this->db->where($where);
		if ($like != null) $this->db->like($like);
        $q  = $this->db->get($this->table);
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd  = sprintf("%05s", $tmp);
            }
        } else {
            $kd = "00001";
        }
        return "JASAPRINT/02/" . date('dmY') . "/$kd";
	} 
}

/* End of file Pemesanan_model.php */
/* Location: ./application/models/Pemesanan_model.php */