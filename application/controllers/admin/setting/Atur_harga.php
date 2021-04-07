<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atur_harga extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('semua_bisa_model', 'sb');
	}

	// List all your items
	public function index()
	{

	}

	public function ambilDataHarga() 
	{
		echo json_encode([
			'jasaprint' => [
				'status' =>  'success',
				'data' => [
					'hargaPrintWarna' =>  (int) $this->sb->mengambil('tb_print_price', [
						'print_price_name' => 'Print Warna',
					])->row()->print_price_amount,
					'hargaPrintHP' => (int) $this->sb->mengambil('tb_print_price', [
						'print_price_name' => 'Print Hitam Putih',
					])->row()->print_price_amount,
				]
			]
		]);
	}
}

/* End of file Atur_harga.php */
/* Location: ./application/controllers/admin/setting/Atur_harga.php */
