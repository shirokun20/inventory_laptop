<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_lokasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('lokasi_model', 'lm');
	}

	public function index()
	{
		$data = [
			'title' => 'Master Lokasi/Rak',
			'subtitle' => 'Master Lokasi/Rak',
		];
		$data['breadcrumb'] = [
			[
				'href' => true,
				'icon' => 'fa-table',
				'tujuan' => site_url('admin/master_inventory/master_lokasi'),
				'title' => ''
			],
			[
				'href' => false,
				'icon' => '',
				'tujuan' => '',
				'title' => 'Master Gudang'
			],
			[
				'href' => false,
				'icon' => '',
				'tujuan' => '',
				'title' => 'Lokasi/Rak'
			]
		];
		$this->shiro_lib->admin('master_inventory/master_lokasi/vLokasi', $data);
	}

	public function showDataLokasi() 
	{
		$data = $this->lm->getData();
		echo json_encode([
			'shiro' => [
				'data' => $data->result(),
				'jumlah_data' => $data->num_rows()
			]
		]);
	}

	public function simpanData($action = 't') 
	{
		$input = $this->input->post();
		//
		if ($input['lokasi_barang_name']) {
			if ($action == 't') {
				$this->_simpanTambah($input);
			} else {
				$this->_simpanEdit([
					'lokasi_barang_id' => $input['lokasi_barang_id'],
				], $input);
			}
		} else {
			echo json_encode([
				'shiro' => [
					'status' => 'gagal',
					'message' => 'Aksi tidak ditemukan!'
				]
			]);
		}
	}

	private function _simpanEdit($where, $data) 
	{
		$status = 'gagal';
		$message = '';
		//
		$this->lm->like([
			'lokasi_barang_name' => $data['lokasi_barang_name'],
		]);
		$this->lm->where([
			'lokasi_barang_id !=' => $data['lokasi_barang_id'],
		]);
		$check = $this->lm->getData();
		if ($check->num_rows()) {
			$message = 'Nama lokasi/rak sudah digunakan!!';
		} else {
			$data['lokasi_barang_name'] = ucwords($data['lokasi_barang_name']);
			$check2 = $this->lm->update($where, $data);
			if ($check2['status'] == 'berhasil') {
				$status = 'berhasil';
				$message = 'Berhasil mengubah lokasi/rak!';
			} else {
				$message = 'Error ketika akan mengubah lokasi/rak!!';
			}
		}
		//
		echo json_encode([
			'shiro' => [
				'status' => $status,
				'message' => $message
			]
		]);
	}

	private function _simpanTambah($input) 
	{
		$status = 'gagal';
		$message = '';
		//
		$this->lm->like([
			'lokasi_barang_name' => $input['lokasi_barang_name']
		]);
		$check = $this->lm->getData();
		//
		if ($check->num_rows()) {
			$message = 'Nama lokasi/rak sudah digunakan!!';
		} else {
			$input['lokasi_barang_name'] = ucwords($input['lokasi_barang_name']);
			$check = $this->lm->insert($input);
			if ($check['status'] == 'berhasil') {
				$status = 'berhasil';
				$message = 'Berhasil menambah lokasi/rak!';
			} else {
				$message = 'Error ketika akan menambah lokasi/rak!!';
			}
		}
		//
		echo json_encode([
			'shiro' => [
				'status' => $status,
				'message' => $message
			]
		]);
	}
}

/* End of file Master_lokasi.php */
/* Location: ./application/controllers/admin/master_inventory/Master_lokasi.php */
