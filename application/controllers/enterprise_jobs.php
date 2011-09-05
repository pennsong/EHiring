<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Enterprise_jobs extends CW_Controller
{
	public function index($offset=0)
	{
		$pageSize = 10;
		$vars['nowPage'] = 'enterpriseJobs';
		$vars['content_view'] = 'enterprise_jobs';
		$vars['navigation_menu'] = 'navigation_menu';
		$enterpriseAccount = $this->session->userdata('user');
		$config['base_url'] = site_url('enterprise_jobs/index');
		$config['per_page'] = $pageSize;
		$config['uri_segment'] = '3';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['anchor_class'] = 'class="blue" ';
		//P_activeJobListForEnterprise 查询该企业用户的职位
		$tmpRes = $this->db->multi_query("call P_activeJobListForEnterprise(?,null,?,?)", array($enterpriseAccount, $offset, $pageSize));
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!');
		}
		$vars['jobs'] = $tmpRes->result_array();
		$tmpRes->free_result();
		$tmpRes->next_result();
		$tmpRes = $tmpRes->store_result();
		$tmpArray = $tmpRes->result_array();
		$config['total_rows'] = $tmpArray[0]['R_total_rows'];
		$tmpRes->free_result();
		$tmpRes->free_all();

		$this->load->library('pagination');
		$this->pagination->initialize($config);
		//P_jobLocations 查询指定职位的location
		foreach ($vars['jobs'] as &$job)
		{
			$tmpRes = $this->db->multi_query("call P_jobLocations(?)", $job['job_Id']);
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
		$vars['page_title'] = '项目';
		$this->load->view('template', $vars);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
