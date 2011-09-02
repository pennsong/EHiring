<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Hunter_home extends CW_Controller
{
	public function index()
	{
		$vars['nowPage'] = 'firstPage';
		$vars['content_view'] = 'hunter_home';
		$vars['navigation_menu'] = 'navigation_menu';
		$hunterAccount = $this->session->userdata('user');
		//P_activeJobListForHunter 查询向此猎头开放的职位
		$tmpRes = $this->db->query("call P_activeJobListForHunter(?,null,null,0,5)", $hunterAccount);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['jobs'] = $tmpRes->result_array();
		$tmpRes->free_all();
		foreach ($vars['jobs'] as &$job)
		{
			//P_jobLocations 查询指定项目所在地
			$tmpRes = $this->db->query("call P_jobLocations(?)", $job['job_Id']);
			if (!$tmpRes)
			{
				show_error('数据查询失败，请重试!');
			}
			$job['locations'] = $tmpRes->result_array();
			$tmpRes->free_all();
			if (count($job['locations']) == 0)
			{
				$job['location_display'] = '无限制';
			}
			else if (count($job['locations']) == 1)
			{
				$job['location_display'] = $job['locations'][0]['location_Name'];
			}
			else
			{
				$job['location_display'] = "多个地点...";
			}
		}
		//P_talentJobStatusUpdateForHunter 查询此猎头下属人才推荐工作状态
		$tmpRes = $this->db->query("call P_talentJobStatusUpdateForHunter(?,null,null,0,5)", $hunterAccount);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['statusList'] = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['page_title'] = '猎头首页';
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
