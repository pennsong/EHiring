<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Hunter_submit_update extends CW_Controller
{
	public function index($offset=0)
	{
		$pageSize = 5;
		$vars['nowPage'] = 'submitUpdate';
		$vars['page_title'] = '人员动态';
		$vars['content_view'] = 'hunter_submit_update';
		$vars['navigation_menu'] = 'navigation_menu';
		$hunterAccount = $this->session->userdata('user');
		//P_talentJobStatusUpdateForHunter 查询人员动态
		$config['base_url'] = site_url('hunter_submit_update/index');
		$config['per_page'] = $pageSize;
		$config['uri_segment'] = '3';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['anchor_class'] = 'class="blue" ';
		$tmpRes = $this->db->multi_query("call P_talentJobStatusUpdateForHunter(?, null, null, ?, ?)", array($hunterAccount, $offset, $pageSize));
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['submit_update_list'] = $tmpRes->result_array();
		$tmpRes->free_result();
		$tmpRes->next_result();
		$tmpRes = $tmpRes->store_result();
		$tmpArray = $tmpRes->result_array();
		$config['total_rows'] = $tmpArray[0]['R_total_rows'];
		$tmpRes->free_result();
		$tmpRes->free_all();

		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
