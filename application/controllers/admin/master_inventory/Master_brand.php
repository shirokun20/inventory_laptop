<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_brand extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('brand_model', 'bm');
	}

	public function index()
	{
		$data = [
			'title' => 'Master Brand Atau Merek',
			'subtitle' => 'Master Brand Atau Merek',
		];
		$data['breadcrumb'] = [
			[
				'href' => true,
				'icon' => 'fa-table',
				'tujuan' => site_url('admin/master_inventory/master_brand'),
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
				'title' => 'Brand Atau Merek'
			]
		];
		$this->shiro_lib->admin('master_inventory/master_brand/vBrand', $data);
	}

	public function showDataBrand() 
	{
		$data = $this->bm->getData();
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
		if ($input['brand_name']) {
			if ($action == 't') {
				$this->_simpanTambah($input);
			} else {
				$this->_simpanEdit([
					'brand_id' => $input['brand_id'],
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
		$this->bm->like([
			'brand_name' => $data['brand_name'],
		]);
		$this->bm->where([
			'brand_id !=' => $data['brand_id'],
		]);
		$check = $this->bm->getData();
		if ($check->num_rows()) {
			$message = 'Nama brand/merek sudah digunakan!!';
		} else {
			$data['brand_name'] = ucwords($data['brand_name']);
			$check2 = $this->bm->update($where, $data);
			if ($check2['status'] == 'berhasil') {
				$status = 'berhasil';
				$message = 'Berhasil mengubah brand/merek!';
			} else {
				$message = 'Error ketika akan mengubah brand/merek!!';
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
		$this->bm->like([
			'brand_name' => $input['brand_name']
		]);
		$check = $this->bm->getData();
		//
		if ($check->num_rows()) {
			$message = 'Nama brand/merek sudah digunakan!!';
		} else {
			$input['brand_name'] = ucwords($input['brand_name']);
			$check = $this->bm->insert($input);
			if ($check['status'] == 'berhasil') {
				$status = 'berhasil';
				$message = 'Berhasil menambah brand/merek!';
			} else {
				$message = 'Error ketika akan menambah brand/merek!!';
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

/* End of file Master_brand.php */
/* Location: ./application/controllers/admin/master_inventory/Master_brand.php */
