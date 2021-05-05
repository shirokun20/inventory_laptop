<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {
	//
    private $table = 'tb_transaksi_barang ttb';
    private $table_insert = 'tb_transaksi_barang';
    private $table_insert_detail = 'tb_transaksi_barang_detail';
	private $table_update_stok = 'tb_stok';
    //
    private $columnOrder    = [
        'ttb.transaksi_barang_id', 
        'ttb.transaksi_barang_tanggal', 
        'ttb.transaksi_barang_no_faktur', 
        null,
        'p.user_nama',
        null,
    ];
    // Pencarian
    private $columnSearch   = [
        'ttb.transaksi_barang_id', 
        'ttb.transaksi_barang_tanggal', 
        'ttb.transaksi_barang_no_faktur', 
        'p.user_nama',
    ];
    //
    private $orderBy        = ['ttb.transaksi_barang_id' => 'DESC'];
    //
    public function _setSelect()
    {
        $this->db->select('ttb.*');
        $this->db->select('p.user_nama');
        $this->db->select('(SELECT sum(ttbd.transaksi_barang_detail_jml) FROM tb_transaksi_barang_detail ttbd WHERE ttbd.transaksi_barang_id = ttb.transaksi_barang_id) as jumlah_laptop');
    }
    // Relasi
    public function _setJoin()
    {
        $this->db->join('tb_user p', 'p.user_id = ttb.user_id');
    }
    // 
    public function _setWhere()
    {
        $transaksi_barang_jenis = $this->input->post('transaksi_barang_jenis');
        if ($transaksi_barang_jenis != '') {
            $this->db->where('ttb.transaksi_barang_jenis', $transaksi_barang_jenis);
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
    private function _buttonTransaksi($data) 
    {
        $button = '<div class="dropdown-primary dropdown open">';
        $button .= '<button class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" type="button" id="dropdown-'.$data->transaksi_barang_id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Aksi</button>';
        $button .= '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-'.$data->transaksi_barang_id.'" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">';
        // if ($data->jabatan_id == 2) {
        // 
        $button .= '<a class="dropdown-item waves-light waves-effect" href="'.site_url('data/transaksi/transaksi_laptop/detail/' . $data->transaksi_barang_id).'">Detail</a>';
        // $button .= '<div class="dropdown-divider"></div>';
        // $button .= '<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="hapusDataConfirm('."'". $data->transaksi_barang_id ."'".')">Hapus</a>';
        $button .= '</div>';
        $button .='</div>';
        return $button;
    }
    // 
    public function getDataTables()
    {
        $query  = $this->datatables->getResult($this->_getBuilder());
        $data   = array();
        $start  = $this->input->post('start');
        $no     = $start + 1;
        foreach ($query as $field) {
            $row    = array();
            $row[]  = $no++;
            $row[]  = $field->transaksi_barang_tanggal ? $this->shiro_lib->tanggal_indo($field->transaksi_barang_tanggal, true) : '-';
            $row[]  = $field->transaksi_barang_no_faktur ? $field->transaksi_barang_no_faktur : '-';
            $row[]  = $field->jumlah_laptop ? $field->jumlah_laptop : '-';
            $row[]  = $field->user_nama ? $field->user_nama : '-';
            $row[]  = $this->_buttonTransaksi($field);
            $data[] = $row;
        }

        $output = [
            'draw'              => $this->input->post('draw'), 
            'recordsTotal'      => $this->_countResult(), 
            'recordsFiltered'   => $this->db->get($this->_getBuilder())->num_rows(), 
            'data'              => $data, 
        ];

        return $output;
    }
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
    //
    public function simpanKeTransaksi($data) 
    {
        if ($this->db->insert($this->table_insert, $data)) {
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
    //
    public function menambahStok($detail_barang_id, $barang_kode, $qty = 0) 
    {
        $this->db->where('detail_barang_id', $detail_barang_id);
        $this->db->where('barang_kode', $barang_kode);
        $this->db->set('stok_qty', 'stok_qty+' . $qty, FALSE);
        if ($this->db->update($this->table_update_stok)) {
            return [
                'status' => 'berhasil',
            ];
        } else {
            return [
                'status' => 'gagal',
            ];
        }
    }
    //
    public function mengurangiStok($detail_barang_id, $barang_kode, $qty = 0) 
    {
        $this->db->where('detail_barang_id', $detail_barang_id);
        $this->db->where('barang_kode', $barang_kode);
        $this->db->set('stok_qty', 'stok_qty-' . $qty, FALSE);
        if ($this->db->update($this->table_update_stok)) {
            return [
                'status' => 'berhasil',
            ];
        } else {
            return [
                'status' => 'gagal',
            ];
        }
    }
    //
    public function simpanKeDt($data)
    {
        if ($this->db->insert_batch($this->table_insert_detail, $data)) {
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

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */