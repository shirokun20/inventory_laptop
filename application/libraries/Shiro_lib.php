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
        if (!@$this->ci->session->admin) redirect(site_url());
    }

    public function tanggal_indo($tanggal, $cetak_hari = false)
    {
        $hari = array(1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        );

        $bulan = array(1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        );
        $split    = explode('-', date('Y-m-d', strtotime($tanggal)));
        $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }
}