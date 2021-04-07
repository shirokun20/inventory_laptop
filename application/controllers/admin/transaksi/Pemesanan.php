<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('semua_bisa_model', 'sb');
		$this->load->model('pemesanan_model', 'pm');
	}
	// List all your items
	public function index()
	{
		$data = [
			'title' => 'Data Pemesanan Print',
		];
		$data['breadcrumb'] = [
				[
					'href' => true,
					'icon' => 'fa-print',
					'tujuan' => site_url('admin/transaksi/pemesanan/'),
					'title' => ''
				],
				[
					'href' => false,
					'icon' => '',
					'tujuan' => '',
					'title' => 'Pemesanan'
				],
		];
		
		$data['subtitle'] = 'Transaksi Pemesanan';
		$this->shiro_lib->admin('transaksi/pemesanan/vPemesanan', $data);
	}

	public function showDataPemesanan() 
	{
		$data = $this->pm->getDataTables();
		echo json_encode($data);
	}

	public function detail($transaction_id = '') 
	{
		if ($transaction_id !== '') {
			$this->_detail($transaction_id);
		} else {
			redirect(site_url('transaksi/pemesanan'));
		}
	}

	private function _detail($transaction_id) 
	{
		$check = $this->pm->get_data([
			'tr.transaction_id' => base64_decode($transaction_id)
		]);
		if ($check->num_rows() > 0) {
			$data = [
				'title' => 'Detail Print',
			];
			$data['breadcrumb'] = [
					[
						'href' => true,
						'icon' => 'fa-print',
						'tujuan' => site_url('admin/transaksi/pemesanan/'),
						'title' => ''
					],
					[
						'href' => false,
						'icon' => '',
						'tujuan' => '',
						'title' => 'Pemesanan'
					],
					[
						'href' => false,
						'icon' => '',
						'tujuan' => '',
						'title' => 'Detail'
					],
			];
			
			$data['subtitle'] = 'Detail Pemesanan';
			$this->shiro_lib->admin('transaksi/pemesanan/vPemesananDetail', $data);
		} else {
			redirect(site_url('transaksi/pemesanan'));
		}
	}

	public function tambah()
	{
		$data = [
			'title' => 'Tambah Pesanan Print',
		];
		$data['breadcrumb'] = [
				[
					'href' => true,
					'icon' => 'fa-print',
					'tujuan' => site_url('admin/transaksi/pemesanan/'),
					'title' => ''
				],
				[
					'href' => false,
					'icon' => '',
					'tujuan' => '',
					'title' => 'Pemesanan'
				],
				[
					'href' => false,
					'icon' => '',
					'tujuan' => '',
					'title' => 'Tambah Pesanan Baru'
				],
		];
		
		$data['subtitle'] = 'Halaman tambah pesanan baru';
		$this->shiro_lib->admin('transaksi/pemesanan/vPemesananTambah', $data);
	}

	public function getJumlahPengguna()
	{
		$data['jumlah'] = [
			'total_pesanan_aktif' => number_format($this->pm->jumlah_pemesanan([1,2])),
			'total_pesanan_selesai' => number_format($this->pm->jumlah_pemesanan([3,4])),
			'total_pesanan_dibatalkan' => number_format($this->pm->jumlah_pemesanan([5])),
		];

		echo json_encode([
			'jasaprint' => [
				'status' =>'success',
				'data' => $data['jumlah'],
			]
		]);
	}
	//
	public function checkCodeUniq()
	{
		echo json_encode([
			'jasaprint' => [
				'uniqe' => $this->pm->uniqCode([
					'YEAR(transaction_date)' => date('Y'),
					'MONTH(transaction_date)' => date('m'),
				], [
					'transaction_invoice' => 'JASAPRINT/02/',
				]),
				'status' => 'success',
			] 
		]);
	}
	//
	private function simpan_ke_transaksi($data) {

	}
	//
	private function _simpan()
	{
		$input = $this->input->post();
		$data['error'] = false;
		$data['message'] = '';

		if (empty($input['invoice'])) {
			$data['error'] = true;
			$data['message'] = 'Invoice tidak boleh kosong!';			
		} else if (empty($input['transaction_total_payment'])) {
			$data['error'] = true;
			$data['message'] = 'Total biaya print boleh kosong!';
		} else if (empty($input['transaction_print_color_price'])) {
			$data['error'] = true;
			$data['message'] = 'Total biaya print warna tidak boleh kosong!';
		} else if (empty($input['transaction_print_color_total_page'])) {
			$data['error'] = true;
			$data['message'] = 'Total halaman print warna tidak boleh kosong!';
		} else if (empty($input['transaction_print_without_color_price'])) {
			$data['error'] = true;
			$data['message'] = 'Total biaya print hitam atau putih tidak boleh kosong!';
		} else if (empty($input['transaction_print_without_color_total_page'])) {
			$data['error'] = true;
			$data['message'] = 'Total halaman print warna atau putih tidak boleh kosong!';
		}

		if ($data['error']) {
			echo json_encode([
				'jasaprint' => [
					'status' => 'error',
					'message' => $data['message'],
				],
			]);
			exit();
		}
	}
	//
	public function simpan()
	{
		$this->_simpan();
	}
}

/* End of file Pemesanan.php */
/* Location: ./application/controllers/admin/transaksi/Pemesanan.php */
