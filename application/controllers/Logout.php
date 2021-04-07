<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->session->sess_destroy();
		redirect(site_url());
	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */
