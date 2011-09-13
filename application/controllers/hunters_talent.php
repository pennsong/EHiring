<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Hunters_talent extends CW_Controller
{
	public function index($offset = 0)
	{
		$pageSize = 5;
		$vars['nowPage'] = 'huntersTalent';
		$vars['content_view'] = 'hunters_talent';
		$vars['navigation_menu'] = 'navigation_menu';
		$hunterAccount = $this->session->userdata('user');
		$config['base_url'] = site_url('hunters_talent/index');
		$config['per_page'] = $pageSize;
		$config['uri_segment'] = '3';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['anchor_class'] = 'class="blue" ';
		//P_huntersTalentSortByUpdateTime 查询此猎头的人才信息
		$tmpRes = $this->db->multi_query("call P_huntersTalentSortByUpdateTime(?,null,null,?,?)", array(
				$hunterAccount,
				$offset,
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
		$vars['page_title'] = '人才库';
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
