<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatables
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function generate($col_order, $col_search, $order)
	{
		$start = 0;
		foreach ($col_search as $row) {
			if(@$_POST['search']['value']) {

				if($start === 0) {
					$this->ci->db->group_start();
					$this->ci->db->like($row, $_POST['search']['value']);
				} else {
					$this->ci->db->or_like($row, $_POST['search']['value']);
				}

				if(count($col_search) - 1 == $start)
					$this->ci->db->group_end();
			}
			$start++;
		}
		if(isset($_POST['order'])) {
			$this->ci->db->order_by($col_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($order)) {
			$this->ci->db->order_by(key($order), $order[key($order)]);
		}
	}

	private function get_paging()
	{
		if($this->ci->input->post('length') != -1)
		$this->ci->db->limit($this->ci->input->post('length'), $this->ci->input->post('start'));
	}

	public function getResult($query)
	{
		$this->get_paging();
		return $this->ci->db->get($query)->result();
	}

}

/* End of file Datatables.php */
/* Location: ./application/libraries/Datatables.php */
