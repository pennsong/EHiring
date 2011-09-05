<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class enterprise_submit_update extends CW_Controller
{
	public function index($offset=0)
	{
		$pageSize = 10;
		$vars['nowPage'] = 'enterpriseSubmitUpdate';
		$vars['page_title'] = '人员动态';
		$vars['content_view'] = 'enterprise_submit_update';
		$vars['navigation_menu'] = 'navigation_menu';
		$enterpriseUserAccount = $this->session->userdata('user');
		//P_talentJobStatusUpdateForEnterprise 查询人员动态
		$config['base_url'] = site_url('enterprise_submit_update/index');
		$config['per_page'] = $pageSize;
		$config['uri_segment'] = '3';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['anchor_class'] = 'class="blue" ';
		$tmpRes = $this->db->multi_query("call P_talentJobStatusUpdateForEnterprise(?, null, null, ?, ?)", array($enterpriseUserAccount, $offset, $pageSize));
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

		//P_jobLocations 查询职位所在城市
		foreach ($vars['submit_update_list'] as &$update_list)
		{
			$tmpRes = $this->db->query("call P_jobLocations(?)", $update_list['hunter_talent_job_Talent_Id']);
			if (!$tmpRes)
			{
				show_error('数据查询失败，请重试!');
			}
			$update_list['locations'] = $tmpRes->result_array();
			$tmpRes->free_all();
			if (count($update_list['locations']) == 0)
			{
				$update_list['location_display'] = '无限制';
			}
			else if (count($update_list['locations']) == 1)
			{
				$update_list['location_display'] = $update_list['locations'][0]['location_Name'];
			}
			else
			{
				$update_list['location_display'] = "多个地点...";
			}
		}
		//P_huntersTalentPreferJob 查询人才的适合职位
		foreach ($vars['submit_update_list'] as &$update_list)
		{
			$tmpRes = $this->db->query("call P_huntersTalentPreferJob(?, ?, 0, 2)", array($enterpriseUserAccount, $update_list['hunter_talent_job_Talent_Id']));
			if (!$tmpRes)
			{
				show_error('数据查询失败，请重试!');
			}
			$update_list['preferJobs'] = '';
			foreach ($tmpRes->result_array() as $preferJob)
			{
				$update_list['preferJobs'] .= $preferJob['job_type_Des'];
			}
			$tmpRes->free_all();
		}
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
