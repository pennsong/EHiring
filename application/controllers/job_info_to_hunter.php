<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Job_info_to_hunter extends CW_Controller
{
	public function index($jobId, $talentOffset = 0)
	{
		$pageSize = 5;
		$hunterAccount = $this->session->userdata('user');
		$vars['content_view'] = 'job_info_to_hunter';
		//P_activeJobListForHunter 查询指定职位信息
		$tmpRes = $this->db->query("call P_activeJobListForHunter(?, ?, null, null, null)", array(
				$hunterAccount,
				$jobId
		));
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['jobInfo'] = $tmpRes->result_array();
		$tmpRes->free_all();
		//P_jobLocations 查询指定职位地点
		$tmpRes = $this->db->query("call P_jobLocations(?)", $jobId);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$job['locations'] = $tmpRes->result_array();
		$tmpRes->free_all();
		if (count($job['locations']) == 0)
		{
			$vars['location_display'] = '无限制';
		}
		else if (count($job['locations']) == 1)
		{
			$vars['location_display'] = $job['locations'][0]['location_Name'];
		}
		else
		{
			$vars['location_display'] = "多个地点...";
		}
		//P_jobLocations 查询指定职位学历要求
		$tmpRes = $this->db->query("call P_jobDegrees(?)", $jobId);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['degrees'] = $tmpRes->result_array();
		$tmpRes->free_all();
		$config['base_url'] = site_url('job_info_to_hunter/index').'/'.$jobId;
		$config['per_page'] = $pageSize;
		$config['uri_segment'] = '4';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['anchor_class'] = 'class="blue" ';
		//P_huntersTalentNotInJobSortByUpdateTime 查询猎头人才库人才信息
		$tmpRes = $this->db->multi_query("call P_huntersTalentNotInJobSortByUpdateTime(?, ?, null, null, ?,  ?)", array(
				$hunterAccount,
				$jobId,
				$talentOffset,
				$pageSize
		));
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['talentList'] = $tmpRes->result_array();
		$tmpRes->free_result();
		$tmpRes->next_result();
		$tmpRes = $tmpRes->store_result();
		$tmpArray = $tmpRes->result_array();
		$config['total_rows'] = $tmpArray[0]['R_total_rows'];
		$tmpRes->free_result();
		$tmpRes->free_all();
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		foreach ($vars['talentList'] as &$talentInfo)
		{
			//P_huntersTalentPreferJob 查询猎头人才的适合职位
			$tmpRes = $this->db->query("call P_huntersTalentPreferJob(?, ?, 0, 2)", array(
					$hunterAccount,
					$talentInfo['hunter_talent_Talent_Id']
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
		}
		$vars['page_title'] = '职位信息';
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
