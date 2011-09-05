<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Enterprise_job extends CW_Controller
{
	public function editJob($jobId)
	{
		$displayData = $this->getJobInfo($jobId);
		if ($displayData['jobInfo']['job_Enterprise_user_account'] <> $this->session->userdata('user'))
		{
			echo "您只能编辑自己创建的职位!";
		}
		else
		{
			$_POST['jobId'] = $displayData['jobInfo']['job_Id'];
			$_POST['jobTitle'] = $displayData['jobInfo']['job_Title'];
			$_POST['jobType'] = $displayData['jobInfo']['job_Type_id'];
			$_POST['commissionType'] = $displayData['jobInfo']['job_Commission_type_id'];
			$_POST['commission'] = $displayData['jobInfo']['job_Commission'];
			$_POST['workExp'] = $displayData['jobInfo']['job_Year_low'];
			$_POST['recruitNum'] = $displayData['jobInfo']['job_Recruit_num'];
			$_POST['salary'] = $displayData['jobInfo']['job_Salary_less'];
			$_POST['jobSimpleDes'] = $displayData['jobInfo']['job_Simple_des'];
			$_POST['startDate'] = $displayData['jobInfo']['job_Start_date'];
			$_POST['endDate'] = $displayData['jobInfo']['job_End_date'];
			$_POST['jobDetailDes'] = $displayData['jobInfo']['job_Detail_des'];
			$_POST['time_updated'] = $displayData['jobInfo']['time_updated'];
			$_POST['location'] = $displayData['jobLocation'];
			$_POST['degree'] = $displayData['jobDegree'];
			$this->display('enterprise_job_input', '职位编辑');
		}
	}

	public function newJob()
	{
		$this->display('enterprise_job_input', '新职位');
	}

	public function saveNewJob()
	{
		$this->setValicate();
		if ($this->form_validation->run() == TRUE)
		{
			//call P_G_createNewJob 创建新职位
			$tmpParam = array(
					$this->input->post('jobTitle'),
					$this->input->post('jobSimpleDes'),
					$this->input->post('jobDetailDes'),
					$this->session->userdata('user'),
					$this->input->post('jobType'),
					null,
					$this->input->post('recruitNum'),
					$this->input->post('workExp'),
					null,
					null,
					$this->input->post('salary'),
					null,
					$this->input->post('commissionType'),
					$this->input->post('commission'),
					$this->input->post('startDate'),
					$this->input->post('endDate'),
					$this->input->post('location'),
					$this->input->post('degree')
			);
			$this->db->trans_start();
			$tmpRes = $this->db->multi_query('call P_G_createNewJob(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_complete();
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				$tmpArray = $tmpRes->result_array();
				if ($tmpRes->free_all())
				{
					$this->db->trans_commit();
					$jobId = $tmpArray[0]['Result'];
					$displayData = $this->getJobInfo($jobId);
					$displayData['generalInfo'] = $jobId.'保存成功!';
					$this->display('enterprise_job_output', '新职位创建成功', $displayData);
				}
				else
				{
					$this->db->trans_rollback();
					echo "创建失败，请重试!";
					$this->newJob();
				}
			}
			$this->db->trans_off();
		}
		else
		{
			$this->newJob();
		}
	}

	public function saveEditJob()
	{
		$this->setValicate();
		if ($this->form_validation->run() == TRUE)
		{
			$this->db->trans_start();
			$locationAddList = $this->input->post('location');
			$degreeAddList = $this->input->post('degree');
			//call P_updateJob 更新职位信息
			$tmpParam = array(
					$this->input->post('jobId'),
					$this->input->post('time_updated'),
					$this->input->post('jobTitle'),
					$this->input->post('jobSimpleDes'),
					$this->input->post('jobDetailDes'),
					$this->session->userdata('user'),
					$this->input->post('jobType'),
					null,
					$this->input->post('recruitNum'),
					$this->input->post('workExp'),
					null,
					null,
					$this->input->post('salary'),
					null,
					$this->input->post('commissionType'),
					$this->input->post('commission'),
					$this->input->post('startDate'),
					$this->input->post('endDate'),
					$locationAddList,
					$degreeAddList,
			);
			$tmpRes = $this->db->multi_query('call P_G_updateJob(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_complete();
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				$tmpUpdateResult = FALSE;
				$tmpArray = $tmpRes->result_array();
				if ($tmpRes->free_all())
				{
					$tmpUpdateResult = TRUE;
				}
				if ($tmpUpdateResult)
				{
					$this->db->trans_commit();
					$displayData = $this->getJobInfo($this->input->post('jobId'));
					$displayData['generalInfo'] = $this->input->post('jobId').'保存成功!';
					$this->display('enterprise_job_output', '职位编辑成功', $displayData);
				}
				else
				{
					$this->db->trans_rollback();
					echo "记录编辑失败，请重新编辑!";
					$this->editJob($this->input->post('jobId'));
				}
			}
			$this->db->trans_off();
		}
		else
		{
			$this->reEditJob();
		}
	}

	private function display($content_view, $page_title, $displayData = array())
	{
		$vars['displayData'] = $displayData;
		$vars['content_view'] = $content_view;
		$hunterAccount = $this->session->userdata('user');
		$vars['page_title'] = $page_title;
		//init citylist
		$tmpRes = $this->db->query('SELECT * FROM T_city');
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['citys'] = array();
		foreach ($tmpArray as $cityInfo)
		{
			$vars['citys'][$cityInfo['city_Id']] = $cityInfo['city_Name'];
		}
		//init job type list
		$tmpRes = $this->db->query('SELECT * FROM T_Job_type');
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['jobTypes'] = array();
		foreach ($tmpArray as $jobType)
		{
			$vars['jobTypes'][$jobType['job_type_Id']] = $jobType['job_type_Des'];
		}
		//init degree list
		$tmpRes = $this->db->query('SELECT * FROM T_Degree');
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['degrees'] = array();
		foreach ($tmpArray as $degree)
		{
			$vars['degrees'][$degree['degree_Id']] = $degree['degree_Des'];
		}
		//init commission type list
		$tmpRes = $this->db->query('SELECT * FROM T_Commission_type');
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['commissionTypes'] = array();
		foreach ($tmpArray as $commissionType)
		{
			$vars['commissionTypes'][$commissionType['commission_type_Id']] = $commissionType['commission_type_Des'];
		}
		$this->load->helper('form');
		$this->load->view('template', $vars);
	}

	private function setValicate()
	{
		$this->load->library('form_validation');
		$config = array(
				array(
						'field'=>'jobTitle',
						'label'=>'职位名称',
						'rules'=>'trim|required'
				),
				array(
						'field'=>'location',
						'label'=>'工作地点',
						'rules'=>'required'
				),
				array(
						'field'=>'jobType',
						'label'=>'职位类别',
						'rules'=>'required'
				),
				array(
						'field'=>'degree',
						'label'=>'学历',
						'rules'=>'required'
				),
				array(
						'field'=>'workExp',
						'label'=>'工作经验',
						'rules'=>'is_natural_no_zero'
				),
				array(
						'field'=>'recruitNum',
						'label'=>'人数',
						'rules'=>'is_natural_no_zero'
				),
				array(
						'field'=>'salary',
						'label'=>'福利待遇',
						'rules'=>'greater_than[0]'
				),
				array(
						'field'=>'commissionType',
						'label'=>'佣金类型',
						'rules'=>'required'
				),
				array(
						'field'=>'commission',
						'label'=>'佣金',
						'rules'=>'required|greater_than[0]'
				),
				array(
						'field'=>'jobSimpleDes',
						'label'=>'职位简述',
						'rules'=>'max_length[40]'
				),
				array(
						'field'=>'startDate',
						'label'=>'有效期开始',
						'rules'=>'callback_isDate'
				),
				array(
						'field'=>'endDate',
						'label'=>'有效期结束',
						'rules'=>'callback_isDate'
				),
				array(
						'field'=>'jobDetailDes',
						'label'=>'职位详述',
						'rules'=>'max_length[1000]'
				)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('isDate', '%s不正确');
	}

	private function getJobInfo($jobId)
	{
		//call P_jobInfo 取得job信息
		$tmpRes = $this->db->query('call P_jobInfo(?)', $jobId);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		else
		{
			if ($tmpRes->num_rows() == 0)
			{
				$this->generalInfo = '未找到相应记录';
			}
			else
			{
				$displayData['jobInfo'] = $tmpRes->row_array();
			}
			$tmpRes->free_all();
		}
		//call P_jobDegrees 取得job degree信息
		$tmpRes = $this->db->query('call P_jobDegrees(?)', $jobId);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		else
		{
			if ($tmpRes->num_rows() == 0)
			{
				$displayData['jobDegree'] = null;
			}
			else
			{
				$tmpArray = $tmpRes->row_array();
				$displayData['jobDegree'] = $tmpArray['degree_Id'];
			}
			$tmpRes->free_all();
		}
		//call P_jobLocations 取得job location信息
		$tmpRes = $this->db->query('call P_jobLocations(?)', $jobId);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		else
		{
			if ($tmpRes->num_rows() == 0)
			{
				$displayData['jobLocation'] = null;
			}
			else
			{
				$tmpArray = $tmpRes->row_array();
				if ($tmpArray['location_Type_id'] == 2)
				{
					$displayData['jobLocation'] = $tmpArray['location_Id'];
				}
				else
				{
					$displayData['jobLocation'] = null;
				}
			}
			$tmpRes->free_all();
		}
		return $displayData;
	}

	private function reEditJob()
	{
		$this->display('enterprise_job_input', '职位编辑');
	}

	public function isDate($str)
	{
		if ($str <> '')
		{
			if (substr_count($str, '-') <> 2)
			{
				return FALSE;
			}
			else
			{
				list($y, $m, $d) = explode('-', $str);
				return checkdate($m, $d, $y);
			}
		}
		else
		{
			return TRUE;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
