<?php 

/**
 * 
 */
class Shiro_lib
{
	
	protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function page($content, $data = null)
    {
        return $this->ci->load->view($content, $data);
    }

    public function admin($content, $data = null)
    {
        $datas = array(
            'header'  		=> $this->ci->load->view('template/header', $data, true),
            'sidebar' 		=> $this->ci->load->view('template/sidebar', $data, true),
            'footer'		=> $this->ci->load->view('template/footer', $data, true),
            'breadcrumb'	=> $this->ci->load->view('template/breadcrumb', $data, true),
            'content' 		=> $this->ci->load->view('admin/' . $content, $data, true),
        );
        return $this->ci->load->view('template/page', $datas);
    }

    public function cekLogin() 
    {
        if (empty($this->ci->session->admin)) {
            redirect(site_url());
        }
    }
}