<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {
	//
	private $table = 'tb_transaksi_barang ttb';
	//
	public function uniqCode($transaksi_barang_jenis = 0, $tanggal) 
	{
		$this->db->select('MAX(RIGHT(ttb.transaksi_barang_no_faktur,5)) AS kd_max');
		$this->db->where('ttb.transaksi_barang_jenis', $transaksi_barang_jenis);
		$this->db->where('date(ttb.transaksi_barang_tanggal)', $tanggal);
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
        return ($transaksi_barang_jenis == 0 ? 'M' : 'K') . str_replace('-', '', $tanggal) . $kd;
	}
	

}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */