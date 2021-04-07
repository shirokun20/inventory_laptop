<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (@$this->session->admin) {
			redirect(site_url('admin/dashboard'));
		}
		$this->load->model('login_model');
	}

	public function index()
	{
		$this->shiro_lib->page('vLogin', [
			'title' => 'Login',
		]);
	}

	public function logCek() 
	{
		if (@$this->input->post('btnClick')) {
			$this->_logCek();
		} else {
			$this->session->set_flashdata('error', 'Button masuk harus diklik!!.');
			redirect(site_url());
		}
	}

	private function _logCek() 
	{
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);
		$errorText = '';
		$error = false;
		if ($this->login_model->auth($email)->num_rows() > 0) {
			$cek = $this->login_model->auth($email);
			if ($cek->row()->user_password !== sha256Encode($password)) {
				$error = true;
				$errorText = "Password salah!!";
			} else if ($cek->row()->status_user_id == 2) {
				$error = true;
				$errorText = "Akun sedang di suspend!!";
			} else {
				$data = $cek->row();
				$data->user_password = sha256Encode(date('Y-m-d H:i:s'));
				$data->jabatan_nama = $this->login_model->getUserJabatan($data->jabatan_id)->row()->jabatan_nama; 
				// echo json_encode($data);
				$this->session->set_userdata(strtolower($data->jabatan_nama), $data);
				redirect(site_url());
			}
		} else {
			$error = true;
			$errorText = "Akun tidak ditemukan";
		}

		if ($error) {
			$this->session->set_flashdata('email', $email);
			$this->session->set_flashdata('error', $errorText);
			redirect(site_url());
		}
	}
}
