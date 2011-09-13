<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Enterprise_home extends CW_Controller
{
	public function index()
	{
		$vars['nowPage'] = 'firstPage';
		$vars['content_view'] = 'enterprise_home';
		$vars['navigation_menu'] = 'navigation_menu';
		$enterpriseUserAccount = $this->session->userdata('user');
		//P_talentJobStatusUpdateForEnterprise 查询与此企业相关的人员推荐更新状态
		$tmpRes = $this->db->query("call P_talentJobStatusUpdateForEnterprise(?,null,null,0,5)", $enterpriseUserAccount);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['submit_update_list'] = $tmpRes->result_array();
		$tmpRes->free_all();
		foreach ($vars['submit_update_list'] as &$talentInfo)
		{
			//P_huntersTalentJobPreferJob 查询指定人员的适合岗位
			$tmpRes = $this->db->query("call P_huntersTalentJobPreferJob(?, ?, ?, 0, 2)", array(
					$talentInfo['hunter_talent_job_Hunter_account'],
					$talentInfo['hunter_talent_job_Talent_Id'],
					$talentInfo['job_Id']
			));
			if (!$tmpRes)
			{
				show_error('数据查询失败，请重试!');
			}
			$talentInfo['preferJobs'] = '';
			foreach ($tmpRes->result_array() as $preferJob)
			{
				$talentInfo['preferJobs'] .= $preferJob['job_type_Des'];
			}
			$tmpRes->free_all();
			//P_jobLocations 查询指定项目所在地
			$tmpRes = $this->db->query("call P_jobLocations(?)", $talentInfo['job_Id']);
			if (!$tmpRes)
			{
				show_error('数据查询失败，请重试!');
			}
			$talentInfo['locations'] = $tmpRes->result_array();
			$tmpRes->free_all();
			if (count($talentInfo['locations']) == 0)
			{
				$talentInfo['location_display'] = '无限制';
			}
			else if (count($talentInfo['locations']) == 1)
			{
				$talentInfo['location_display'] = $talentInfo['locations'][0]['location_Name'];
			}
			else
			{
				$talentInfo['location_display'] = "多个地点...";
			}
		}
		//P_activeJobListForEnterprise 查询向此企业开放的职位
		$tmpRes = $this->db->query("call P_activeJobListForEnterprise(?,null,0,5)", $enterpriseUserAccount);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['jobs'] = $tmpRes->result_array();
		$tmpRes->free_all();
		foreach ($vars['jobs'] as &$job)
		{
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
		$vars['page_title'] = '企业首页';
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
