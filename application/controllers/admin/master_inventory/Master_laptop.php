<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_laptop extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('laptop_model', 'lapm');
		$this->load->model('semua_bisa_model', 'sb');
	}

	public function index()
	{
		$data = [
			'title' => 'Master Laptop',
			'subtitle' => 'Master Laptop',
		];
		$data['breadcrumb'] = [
			[
				'href' => true,
				'icon' => 'fa-table',
				'tujuan' => site_url('data/transaksi/barang_masuk/'),
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
				'title' => 'Laptop'
			]
		];
		$this->shiro_lib->admin('master_inventory/master_laptop/vLaptop', $data);
	}

	public function showDataLaptop() 
	{
		$data = $this->lapm->getDataTables();
		echo json_encode($data);
	}
}

/* End of file Master_laptop.php */
/* Location: ./application/controllers/admin/master_inventory/Master_laptop.php */
