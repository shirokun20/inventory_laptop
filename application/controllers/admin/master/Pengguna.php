<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->shiro_lib->cekLogin();
		$this->load->model('user_model', 'us');
		$this->load->model('semua_bisa_model', 'sb');
	}

	public function index($jabatan_id = 0)
	{
		$userType = 'Semua Pengguna';
		if ($jabatan_id == 1) {
			$userType = 'Admin';
		} else if ($jabatan_id == 2) {
			$userType = 'Operator';
		}
		$data = [
			'title' => 'Master Data',
		];
		$data['breadcrumb'] = [
				[
					'href' => true,
					'icon' => 'fa-user',
					'tujuan' => site_url('master/pengguna/'. $jabatan_id),
					'title' => ''
				],
				[
					'href' => false,
					'icon' => '',
					'tujuan' => '',
					'title' => 'Data Pengguna'
				],
				[
					'href' => false,
					'icon' => '',
					'tujuan' => '',
					'title' => $userType
				]
		];
		
		$data['subtitle'] = 'Master Data ' . $userType;
		$data['type_user_nama'] = $userType;
		$data['jabatan_id'] = $jabatan_id;
		$this->shiro_lib->admin('master/pengguna/vPengguna', $data);
	}

	public function showDataPengguna() 
	{
		$data = $this->us->getDataTables();
		echo json_encode($data);
	}

	public function getPengguna()
	{
		$input['user_id'] = $this->input->get('user_id');
		$ada = false;
		$output = '';
		if ($input['user_id'] !== '') {
			$q = $this->sb->mengambil('tb_user', $input);
			if ($q->num_rows() > 0) {
				$ada = true;
				$output = $q->row();
				$output->user_password = '';
			}
		} 

		echo json_encode([
			'jasaprint' => [
				'status' => $ada ? 'success' : 'error',
				'data' => $output,
			]
		]);
	}

	private function _getDetail($input) 
	{
		$this->us->_setJoin();
		return $this->sb->mengambil('tb_user u', $input);
	}

	public function getDetail()
	{
		$input['user_id'] = $this->input->get('user_id');
		$ada = false;
		$output = '';
		$jumlah_order = 0;
		if ($input['user_id'] !== '') {
			$q = $this->_getDetail([
				'u.user_id' => $input['user_id'],
			]);

			if ($q->num_rows() > 0) {
				$jumlah_order = $this->sb->mengambil('tb_transaction', $input)->num_rows();
				$ada = true;
				$output = $q->row();
				$output->user_password = '';
			}
		} 

		echo json_encode([
			'jasaprint' => [
				'status' => $ada ? 'success' : 'error',
				'data' => $output,
				'jumlah_order' => number_format($jumlah_order),
			]
		]);
	}

	public function simpan()
	{
		$error = true;
		$message = '';
		if (!empty($this->input->post('simpan'))) {
			if (!empty($this->input->post('type_input'))) {
				$response = $this->_simpan();
				$error = $response['error'];				
				$message = $response['message'];				
			} else {
				$message = 'aksi tidak terdeteksi!';
			}
		} else {
			$message = 'harap periksa kembali inputan yang anda kirim';
		}

		echo json_encode([
			'jasaprint' => [
				'status' => $error ? 'error' : 'success',
				'message' => $message,
			]
		]);
	}

	private function _simpan()
	{
		// 
		$input = $this->input->post();
		$data = [
			'user_nama' => $input['user_nama'],
			'user_email' => $input['user_email'],
		];
		// 
		$error = true;
		$message = '';
		// 
		if ($input['type_input'] == 'tambah') {
			$data['status_user_id'] = 1;
		}

		if (strlen($input['user_password']) > 0) {
			$data['user_password'] = sha256Encode($input['user_password']);
		}

		if ($input['jabatan_id'] !== '') {
			$data['jabatan_id'] = $input['jabatan_id'];
		}

		if ($input['user_id'] !== '' && $input['type_input'] == 'edit') {
			$cek = $this->sb->mengambil('tb_user', [
				'user_id !=' => $input['user_id'],
				'user_email' => $data['user_email'],
			]);

			if ($cek->num_rows() > 0) {
				$message = 'email sudah digunakan!';
			} else {
				$response = $this->sb->mengubah('tb_user', [
					'user_id' => $input['user_id'],
				], $data);

				if ($response['status'] == 'success') {
					$error = false;
					$message = 'mengubah data pengguna';
				} else {
					$message = 'mengubah data pengguna';
				}
			}
		} else if ($input['type_input'] == 'tambah') {
			$cek = $this->sb->mengambil('tb_user', [
				'user_email' => $data['user_email'],
			]);

			if ($cek->num_rows() > 0) {
				$message = 'email sudah digunakan!';
			} else {
				$response = $this->sb->menambah('tb_user', $data);

				if ($response['status'] == 'success') {
					$error = false;
					$message = 'menambah data pengguna';
				} else {
					$message = 'menambah data pengguna';
				}
			}
		} 

		return [
			'error' => $error,
			'message' => $message,
		];
	}

	public function hapusData() 
	{
		$error = true;
		$message = '';
		// 
		if (!empty($this->input->post('time'))) {
			// 
			if (!empty($this->input->post('user_id'))) {
				// 
				$user_id = $this->input->post('user_id');
				// 
				$cek = $this->sb->mengambil('tb_user', [
					'user_id' => $user_id,
				]);
				// 
				if ($user_id == $this->session->admin->user_id) {
					$message = 'Tidak bisa menghapus akun yang sedang dipakai!';
				} else if ($cek->num_rows() > 0) {
					$response = $this->sb->menghapus('tb_user', [
						'user_id' => $user_id,
					]);

					if ($response['status'] == 'success') {
						$error = false;
						$message = 'menghapus data pengguna';
					} else {
						$message = 'menghapus data pengguna';
					}
				} else {
					$message = 'Pengguna yang akan dihapus tidak ditemukan!';
				}
			} else {
				$message = 'ID Pengguna tidak boleh kosong!';
			}
		} else {
			$message = 'harap periksa kembali data yang dikirimkan!';
		}

		echo json_encode([
			'jasaprint' => [
				'status' => $error ? 'error' : 'success',
				'message' => $message,
			]
		]);
	}

	public function statusChange() 
	{
		$error = true;
		$message = '';
		// 
		if (!empty($this->input->post('time'))) {
			// 
			if (!empty($this->input->post('user_id'))) {
				// 
				$user_id = $this->input->post('user_id');
				$status_user_id = $this->input->post('status_user_id') ?? 2;
				$status_user_name = 'mengsuspend';
				if ($status_user_id == 1) {
					$status_user_name = 'mengaktifkan';
				}
				// 
				$cek = $this->sb->mengambil('tb_user', [
					'user_id' => $user_id,
				]);
				// 
				if ($user_id == $this->session->admin->user_id) {
					$message = 'Tidak bisa mengubah status akun yang sedang dipakai!';
				} else if ($cek->num_rows() > 0) {
					$response = $this->sb->mengubah('tb_user', [
						'user_id' => $user_id,
					], [
						'status_user_id' => $status_user_id,
					]);
					
					if ($response['status'] == 'success') {
						$error = false;
						$message = $status_user_name . ' data pengguna';
					} else {
						$message = $status_user_name . ' data pengguna';
					}
				} else {
					$message = 'Pengguna tidak ditemukan!';
				}
			} else {
				$message = 'ID Pengguna tidak boleh kosong!';
			}
		} else {
			$message = 'harap periksa kembali data yang dikirimkan!';
		}

		echo json_encode([
			'jasaprint' => [
				'status' => $error ? 'error' : 'success',
				'message' => $message,
			]
		]);
	}


	public function getJumlahPengguna()
	{
		$data['jumlah'] = [
			'total_pengguna' => number_format($this->us->jumlah_pengguna(0)),
			'total_admin' => number_format($this->us->jumlah_pengguna(1)),
			'total_operator' => number_format($this->us->jumlah_pengguna(2)),
		];

		echo json_encode([
			'jasaprint' => [
				'status' =>'success',
				'data' => $data['jumlah'],
			]
		]);
	}
}

/* End of file pengguna.php */
/* Location: ./application/controllers/admin/master/pengguna.php */
