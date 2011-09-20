<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Hunter_talent_workExp extends CW_Controller
{
	public function checkLegal($talentId)
	{
		if ($talentId != null)
		{
			$sql = 'SELECT COUNT(*) R_num FROM T_Hunter_Talent WHERE ';
			$sql .= 'hunter_talent_Hunter_account = ?';
			$sql .= 'AND hunter_talent_Talent_id = ?';
			$tmpParam = array(
					$this->session->userdata('user'),
					$talentId
			);
			$tmpRes = $this->db->query($sql, $tmpParam);
			if (!$tmpRes)
			{
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				if ($tmpRes->row()->R_num == 0)
				{
					EXIT("记录不存在！");
				}
			}
		}
		else
		{
			EXIT("记录不存在！");
		}
	}

	public function displayWorkExp($talentId = null)
	{
		$this->checkLegal($talentId);
		$tmpParam = array('talentId'=>$talentId);
		$this->display('hunter_talent_workExp_input', '人才简历-工作经历', 'display', $tmpParam);
	}

	public function newWorkExp($talentId = null)
	{
		$this->checkLegal($talentId);
		$this->display('hunter_talent_workExp_input', '人才简历-工作经历', 'new', array('talentId'=>$talentId));
	}

	public function saveNewWorkExp($talentId)
	{
		$this->setValidate('new');
		if ($this->form_validation->run() == TRUE)
		{
			$this->db->trans_start();
			$tmpParam = array(
					$talentId,
					$this->session->userdata('user'),
					$this->input->post('company'),
					$this->convertToDate($this->input->post('startDate')),
					$this->convertToDate($this->input->post('endDate')),
					$this->input->post('position'),
					$this->input->post('salary'),
					$this->input->post('reasonType'),
					$this->input->post('reasonDetail')
			);
			$tmpRes = $this->db->query('SELECT F_G_createNewHunterTalentWorkExp(?,?,?,?,?,?,?,?,?) Result', $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_rollback();
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				$tmpResult = explode('@', $tmpRes->row()->Result);
				$tmpRes->free_all();
				if ($tmpResult[0] == 'SUCCESS')
				{
					echo $tmpResult[0].":".$tmpResult[1];
					$this->db->trans_commit();
					$this->displayWorkExp($talentId);
				}
				else
				{
					$this->db->trans_rollback();
					echo $tmpResult[0].":".$tmpResult[1];
					$this->newWorkExp($talentId);
				}
			}
			$this->db->trans_off();
		}
		else
		{
			$this->newWorkExp($talentId);
		}
	}

	public function delWorkExp($talentId = 0, $company = 0, $position = 0, $startDate = 0)
	{
		$this->checkLegal($talentId);
		$this->db->trans_start();
		$tmpParam = array(
				$this->session->userdata('user'),
				$talentId,
				$company,
				$position,
				$this->convertToDate($startDate)
		);
		$tmpRes = $this->db->query('SELECT F_delHunterTalentWorkExp(?,?,?,?,?) Result', $tmpParam);
		if (!$tmpRes)
		{
			$this->db->trans_rollback();
			show_error('数据删除失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		else
		{
			$tmpResult = $tmpRes->row()->Result;
			if ($tmpResult > 0)
			{
				$this->db->trans_commit();
				echo "删除成功！";
				redirect(site_url('hunter_talent_workExp/displayWorkeXP').'/'.$talentId);
			}
			else
			{
				$this->db->trans_rollback();
				echo "删除失败！";
				redirect(site_url('hunter_talent_workExp/displayWorkeXP').'/'.$talentId);
			}
		}
		$this->db->trans_off();
	}

	public function editWorkExp($talentId = 0, $company = 0, $position = 0, $startDate = 0)
	{
		$displayData = $this->getWorkExpInfo($talentId, $company, $position, $startDate);
		if ($displayData != null)
		{
			$tmpArray = array(
					'talentId'=>$talentId,
					'company'=>$company,
					'position'=>$position,
					'startDate'=>$startDate
			);
			$_POST['company'] = $displayData['hunter_talent_work_experience_Company'];
			$_POST['startDate'] = $displayData['hunter_talent_work_experience_Start_date'];
			$_POST['endDate'] = $displayData['hunter_talent_work_experience_End_date'];
			$_POST['position'] = $displayData['hunter_talent_work_experience_Position'];
			$_POST['salary'] = $displayData['hunter_talent_work_experience_Salary'];
			$_POST['reasonType'] = $displayData['hunter_talent_work_experience_Job_quit_reason_type'];
			$_POST['reasonDetail'] = $displayData['hunter_talent_work_experience_Job_quit_reason_Des'];
			$this->display('hunter_talent_workExp_input', '人才简历-工作经历', 'edit', $tmpArray);
		}
		else
		{
			$tmpArray = null;
			EXIT("没有对应记录,请访问记录新建");
		}
	}

	private function getWorkExpInfo($talentId, $company, $position, $startDate)
	{
		$tmpParam = array(
				$this->session->userdata('user'),
				$talentId,
				rawurldecode($company),
				rawurldecode($position),
				$this->convertToDate($startDate)
		);
		$tmpRes = $this->db->query('CALL P_getHunterTalentWorkExp(?,?,?,?,?)', $tmpParam);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		else
		{
			if ($tmpRes->num_rows() == 0)
			{
				$this->generalInfo = '未找到相应记录';
				return null;
			}
			else
			{
				$displayData = $tmpRes->row_array();
				//转换日期为月份格式
				$displayData['hunter_talent_work_experience_Start_date'] = substr($displayData['hunter_talent_work_experience_Start_date'], 0, 7);
				$displayData['hunter_talent_work_experience_End_date'] = substr($displayData['hunter_talent_work_experience_End_date'], 0, 7);
			}
			$tmpRes->free_all();
		}
		return $displayData;
	}

	public function saveEditWorkExp($talentId, $company, $position, $startDate)
	{
		$this->setValidate('edit');
		if ($this->form_validation->run() == TRUE)
		{
			//update record
			$this->db->trans_start();
			$tmpParam = array(
					$talentId,
					$this->session->userdata('user'),
					$company,
					$this->convertToDate($startDate),
					$this->convertToDate($this->input->post('endDate')),
					$position,
					$this->input->post('salary'),
					$this->input->post('reasonType'),
					$this->input->post('reasonDetail')
			);
			$tmpRes = $this->db->query('SELECT F_updateHunterTalentWorkExp(?,?,?,?,?,?,?,?,?) Result', $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_rollback();
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				$tmpResult = $tmpRes->row()->Result;
				if ($tmpResult > 0)
				{
					$this->db->trans_commit();
					echo "保存成功！";
					$this->displayWorkExp($talentId);
				}
				else
				{
					$this->db->trans_commit();
					echo "数据没有改动！";
					$this->displayWorkExp($talentId);
				}
			}
			$this->db->trans_off();
		}
		else
		{
			$this->EditWorkExp($talentId, $company, $position, $startDate);
		}
	}

	private function display($content_view, $page_title, $displayType, $displayData = array())
	{
		$vars['displayData'] = $displayData;
		$vars['content_view'] = $content_view;
		$vars['type'] = $displayType;
		$hunterAccount = $this->session->userdata('user');
		$vars['page_title'] = $page_title;
		//get exists worExp
		if ($displayType == 'new' || $displayType == 'display')
		{
			//新建状态
			$tmpParam = array(
					$displayData['talentId'],
					$this->session->userdata('user')
			);
			$sql = 'SELECT *';
			$sql .= ' FROM T_Hunter_Talent_Work_experience ';
			$sql .= 'WHERE hunter_talent_work_experience_Talent_id = ? ';
			$sql .= 'AND hunter_talent_work_experience_Hunter_account = ? ';
			$sql .= 'ORDER BY hunter_talent_work_experience_Start_date';
			$tmpRes = $this->db->query($sql, $tmpParam);
		}
		else if ($displayType == 'edit')
		{
			//编辑状态
			$tmpParam = array(
					$displayData['talentId'],
					$this->session->userdata('user'),
					$displayData['company'],
					$displayData['position'],
					$this->convertToDate($displayData['startDate'])
			);
			$sql = 'SELECT *';
			$sql .= ' FROM T_Hunter_Talent_Work_experience ';
			$sql .= ' WHERE hunter_talent_work_experience_Talent_id = ? ';
			$sql .= ' AND hunter_talent_work_experience_Hunter_account = ? ';
			$sql .= ' AND (hunter_talent_work_experience_Company != ?';
			$sql .= ' OR hunter_talent_work_experience_Position != ?';
			$sql .= ' OR hunter_talent_work_experience_Start_date != ?)';
			$sql .= ' ORDER BY hunter_talent_work_experience_Start_date';
			$tmpRes = $this->db->query($sql, $tmpParam);
		}
		else
		{
			EXIT("访问页面不存在！");
		}
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		$vars['existWorkExp'] = $tmpRes->result_array();
		$tmpRes->free_all();
		if ($displayType == 'new' || $displayType == 'edit')
		{
			//init job quit reason type list
			$tmpRes = $this->db->query('SELECT * FROM T_Job_quit_normal_reason ORDER BY job_quit_normal_reason_Id DESC');
			if (!$tmpRes)
			{
				show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			$tmpArray = $tmpRes->result_array();
			$tmpRes->free_all();
			$vars['reasonType'] = array();
			$vars['reasonType'][''] = '请选择';
			foreach ($tmpArray as $reason)
			{
				$vars['reasonType'][$reason['job_quit_normal_reason_Id']] = $reason['job_quit_normal_reason_Des'];
			}
		}
		$this->load->helper('form');
		$this->load->view('template', $vars);
	}

	private function setValidate($type)
	{
		$this->load->library('form_validation');
		$config = array(
				array(
						'field'=>'endDate',
						'label'=>'结束日期',
						'rules'=>'callback_checkDate'
				),
				array(
						'field'=>'salary',
						'label'=>'最后工资',
						'rules'=>'required|is_natural|max_length[6]'
				),
				array(
						'field'=>'reasonType',
						'label'=>'离职原因',
						'rules'=>'required|is_natural|callback_reasonCheck'
				),
				array(
						'field'=>'reasonDetails',
						'label'=>'离职详情',
						'rules'=>'max_length[200]'
				)
		);
		if ($type == 'new')
		{
			array_push($config, array(
					'field'=>'company',
					'label'=>'公司名称',
					'rules'=>'trim|required'
			), array(
					'field'=>'startDate',
					'label'=>'开始日期',
					'rules'=>'required|callback_checkDate'
			), array(
					'field'=>'position',
					'label'=>'职位',
					'rules'=>'required'
			));
		}
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('checkDate', '日期格式不正确');
		$this->form_validation->set_message('reasonCheck', '离职原因为其他时需要填写具体离职原因');
	}

	public function checkDate($str)
	{
		if ($str <> '')
		{
			if (substr_count($str, '-') <> 1)
			{
				return FALSE;
			}
			else
			{
				list($y, $m) = explode('-', $str);
				return checkdate($m, '01', $y);
			}
		}
	}

	//转换为月份日期形式
	private function convertToDate($str)
	{
		if ($str != null)
		{
			return $str."-00";
		}
		else
		{
			return NULL;
		}
	}

	public function reasonCheck($str)
	{
		//当原因为‘其他’时，离职详情需要填写
		if ($this->input->post('reasonType') == 1)
		{
			return (trim($this->input->post('reasonDetail')) != null);
		}
		else
		{
			return TRUE;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
