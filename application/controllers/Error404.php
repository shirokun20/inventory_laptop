<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->shiro_lib->page('404/v404');
	}
}

/* End of file Error404.php */
/* Location: ./application/controllers/Error404.php */
