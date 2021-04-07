<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
	}

	public function index()
	{
		$this->shiro_lib->admin('vDashboard', [
			'title' => 'Dashboard',
			'subtitle' => 'Halaman utama aplikasi Gudang Laptop Ku',
			'breadcrumb' => [
				[
					'href' => true,
					'icon' => 'fa-home',
					'tujuan' => site_url('admin/dashboard'),
					'title' => ''
				],
				[
					'href' => false,
					'icon' => '',
					'tujuan' => '',
					'title' => 'Dashbord'
				]
			]
		]);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/admin/Dashboard.php */
