<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_masuk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index( $offset = 0 )
	{
		$data = [
			'title' => 'Transaksi Laptop Masuk',
			'subtitle' => 'Transaksi Laptop Masuk',
		];

		$data['breadcrumb'] = [
			[
				'href' => true,
				'icon' => 'fa-exchange',
				'tujuan' => site_url('data/transaksi/barang_masuk'),
				'title' => ''
			],
			[
				'href' => false,
				'icon' => '',
				'tujuan' => '',
				'title' => 'transaksi'
			],
			[
				'href' => false,
				'icon' => '',
				'tujuan' => '',
				'title' => 'Laptop Masuk'
			]
		];

		$this->shiro_lib->admin('transaksi/laptop_masuk/vLaptopMasuk', $data);
	}
}

/* End of file barang_masuk.php */
/* Location: ./application/controllers/data/transaksi/barang_masuk.php */
