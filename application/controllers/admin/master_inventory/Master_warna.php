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
}

/* End of file Master_warna.php */
/* Location: ./application/controllers/admin/master_inventory/Master_warna.php */
