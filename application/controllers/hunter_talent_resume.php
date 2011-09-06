<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Hunter_talent_resume extends CW_Controller
{
	public function newResume()
	{
		$this->display('hunter_talent_info_input', '新建人才简历-基本信息');
	}

	public function saveNewResume()
	{
		$this->setValicate();
		if ($this->form_validation->run() == TRUE)
		{
			//check whether mobile or QQ exists
			$tmpExists = FALSE;
			$tmpParam = array($this->session->userdata('user'), $this->input->post('talentMobile'), $this->input->post('talentQQ'));
			$tmpRes = $this->db->query("SELECT * FROM T_Hunter_Talent WHERE hunter_talent_Hunter_account=? AND (hunter_talent_talent_mobile = ? || hunter_talent_Talent_qq = ?)", $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_complete();
				show_error('1数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				if ($tmpRes->num_rows() > 0)
				{
					$tmpExists = TRUE;
				}
				$tmpRes->free_all();
			}
			if ($tmpExists)
			{
				echo "人才记录已存在，创建失败!";
			}
			else
			{
				//process live location
				if ($this->input->post('city') != null)
				{
					$locationTypeId = 3;
					$liveLocationId = $this->input->post('city');
				}
				else if ($this->input->post('province') != null)
				{
					$locationTypeId = 2;
					$liveLocationId = $this->input->post('province');
				}
				else
				{
					$locationTypeId = null;
					$liveLocationId = null;
				}

				//check T_Talent, if the talent exists, get the talent_id, otherwise create new talent in T_Talent
				$talentId = null;
				$tmpParam = array($this->input->post('talentMobile'), $this->input->post('talentQQ'));
				$tmpRes = $this->db->query("SELECT talent_Id FROM T_Talent WHERE talent_Mobile = ? || talent_QQ = ?", $tmpParam);
				if (!$tmpRes)
				{
					$this->db->trans_complete();
					show_error('2数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
				}
				else
				{
					if ($tmpRes->num_rows() > 0)
					{
						$talentId = $tmpRes->row()->talent_Id;

						$tmpRes->free_all();
						//check the whether the $talent exists in the T_Hunter_Talent
						$tmpParam = array($this->session->userdata('user'), $talentId);
						$tmpRes = $this->db->query("SELECT * FROM T_Hunter_Talent WHERE hunter_talent_Hunter_account = ? AND hunter_talent_Talent_id = ?", $tmpParam);
						if (!$tmpRes)
						{
							$this->db->trans_complete();
							show_error('2.1数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
						}
						else
						{
							if ($tmpRes->num_rows() > 0)
							{
								echo "hunter_talent数据已存在，不能新建，请转到记录编辑!";
								return;
							}
							$tmpRes->free_all();
						}
					}
					else
					{
						$tmpRes->free_all();
					}
				}
				$this->db->trans_start();
				//creat new talent in T_Talent
				if ($talentId == null)
				{
					$tmpParam = array(
					null,
					null,
					null,
					null,
					$this->input->post('talentMobile'),
					null,
					$this->input->post('talentQQ'),
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null
					);
					$tmpRes = $this->db->multi_query("CALL P_createNewTalent(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $tmpParam);
					if (!$tmpRes)
					{
						$this->db->trans_complete();
						show_error('3数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
					}
					else
					{
						if ($tmpRes->num_rows() > 0)
						{
							$talentId = $tmpRes->row()->Result;
						}
						$tmpRes->free_all();
					}
				}
				$tmpParam=array(
				$this->session->userdata('user'),
				$talentId,
				$this->input->post('talentIdCard'),
				$this->input->post('talentName'),
				null,
				$this->input->post('talentSex'),
				$this->input->post('talentMobile'),
				null,
				$this->input->post('talentQQ'),
				null,
				$this->input->post('talentBornPlace'),
				$locationTypeId,
				$liveLocationId,
				$this->input->post('talentLivePlace'),
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null,
				null
				);
				$tmpRes = $this->db->multi_query('CALL P_createNewHunterTalent(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $tmpParam);
				if (!$tmpRes)
				{
					$this->db->trans_complete();
					show_error('4数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
				}
				$tmpArray = $tmpRes->result_array();
				if ($tmpRes->free_all())
				{
					$this->db->trans_commit();
					$TalentId = $tmpArray[0]['Result'];
					//todo: switch to degree&worExp record creation
				}
				else
				{
					$this->db->trans_rollback();
					echo "创建失败，请重试!";
					$this->newResume();
				}
				$this->db->trans_off();
			}
		}
		else
		{
			$this->newResume();
		}
	}

	public function getLivePlaceDiv($provinceId='', $cityId='')
	{
		$vars['provinceSelected']=$provinceId;
		$vars['citySelected']=$cityId;
		//init province list
		$tmpRes = $this->db->query('SELECT * FROM T_Province');
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['provinces'] = array();
		$vars['provinces'][''] = '请选择';
		foreach ($tmpArray as $province)
		{
			$vars['provinces'][$province['province_Id']] = $province['province_Name'];
		}
		//init city list
		$tmpRes = $this->db->query("SELECT * FROM T_City WHERE city_Province_id = '$provinceId'");
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['cities'] = array();
		$vars['cities'][''] = '请选择';
		foreach ($tmpArray as $city)
		{
			$vars['cities'][$city['city_Id']] = $city['city_Name'];
		}

		$this->load->helper('form');
		$this->load->view('livePlaceDiv', $vars);
	}

	private function display($content_view, $page_title, $displayData = array())
	{
		$vars['displayData'] = $displayData;
		$vars['content_view'] = $content_view;
		$hunterAccount = $this->session->userdata('user');
		$vars['page_title'] = $page_title;
		//init sexlist
		$tmpRes = $this->db->query('SELECT * FROM T_Sex');
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		$tmpArray = $tmpRes->result_array();
		$tmpRes->free_all();
		$vars['sexes'] = array();
		$vars['sexes'][''] = '请选择';
		foreach ($tmpArray as $sex)
		{
			$vars['sexes'][$sex['sex_Id']] = $sex['sex_Name'];
		}

		$this->load->helper('form');
		$this->load->view('template', $vars);
	}
	//----------------
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
	private function setValicate()
	{
		$this->load->library('form_validation');
		$config = array(
		array(
						'field'=>'talentName',
						'label'=>'姓名',
						'rules'=>'trim'
						),
						array(
						'field'=>'talentMobile',
						'label'=>'手机',
						'rules'=>'is_natural|exact_length[11]|callback_checkMobileQQ'
						),
						array(
						'field'=>'talentQQ',
						'label'=>'QQ',
						'rules'=>'alpha_numeric|callback_checkMobileQQ'
						),
						array(
						'field'=>'talentIdCard',
						'label'=>'身份证号码',
						'rules'=>'is_natural|callback_checkIdCard'
						),
						array(
						'field'=>'talentHeight',
						'label'=>'身高',
						'rules'=>'is_natural|exact_length[3]|greater_than[0]'
						),
						array(
						'field'=>'talentWeight',
						'label'=>'体重',
						'rules'=>'is_natural|min_length[2]|max_length[3]|greater_than[0]'
						)
						);
						$this->form_validation->set_rules($config);
						$this->form_validation->set_message('checkMobileQQ', '手机,QQ必须填一项');
						$this->form_validation->set_message('checkIdCard', '身份证号码格式不对');
	}

	public function checkMobileQQ()
	{
		if ($this->input->post('talentMobile') == null && $this->input->post('talentMobile') == null)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function checkIdCard($str)
	{
		//todo add real idcard check function
		if ($str != '' && strlen($str) != 15 && strlen($str) != 18)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
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
