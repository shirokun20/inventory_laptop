<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_warna extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('warna_model', 'wm');
	}

	// List all your items
	public function index()
	{
		$data = [
			'title' => 'Master Warna',
			'subtitle' => 'Master Warna',
		];
		$data['breadcrumb'] = [
			[
				'href' => true,
				'icon' => 'fa-table',
				'tujuan' => site_url('admin/master_inventory/master_warna'),
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
				'title' => 'Warna'
			]
		];
		$this->shiro_lib->admin('master_inventory/master_warna/vWarna', $data);
	}

	public function showDataWarna() 
	{
		$data = $this->wm->getData();
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
		if ($input['warna_kode']) {
			if ($action == 't') {
				$this->_simpanTambah($input);
			} else {
				$this->_simpanEdit([
					'warna_kode' => $input['warna_kode'],
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
		$data['warna_nama'] = ucwords($data['warna_nama']);
		$check = $this->wm->update($where, $data);
		if ($check['status'] == 'berhasil') {
			$status = 'berhasil';
			$message = 'Berhasil mengubah warna!';
		} else {
			$message = 'Error ketika akan mengubah warna!!';
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
		$this->wm->where([
			'warna_kode' => $input['warna_kode']
		]);
		$check = $this->wm->getData();
		//
		if ($check->num_rows()) {
			$message = 'Kode Warna sudah digunakan!!';
		} else {
			$input['warna_nama'] = ucwords($data['warna_nama']);
			$check = $this->wm->insert($input);
			if ($check['status'] == 'berhasil') {
				$status = 'berhasil';
				$message = 'Berhasil menambah warna!';
			} else {
				$message = 'Error ketika akan menambah warna!!';
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

/* End of file Master_warna.php */
/* Location: ./application/controllers/admin/master_inventory/Master_warna.php */
