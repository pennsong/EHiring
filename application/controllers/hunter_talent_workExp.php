<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Hunter_talent_workExp extends CW_Controller
{
	public function newWorkExp($talentId)
	{
		$this->display('hunter_talent_workExp_input', '人才简历-工作经历', array('talentId'=>$talentId));
	}

	public function saveNewWorkExp($talentId)
	{
		$this->setValidate();
		if ($this->form_validation->run() == TRUE)
		{
			$this->db->trans_start();
			$tmpParam=array(
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
					$this->db->trans_commit();
					echo $tmpResult[0].":".$tmpResult[1];
					$this->newWorkExp($talentId);
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

	public function reEditWorkExp($talentId=0, $company=0, $position=0, $startDate=0)
	{
		$displayData = $this->getWorkExpInfo($talentId, $company, $position, $startDate);
		if ($displayData != null)
		{
			$tmpArray = array(
		'talentId' => $talentId,
		'company' => $company,
		'position' => $position,
		'startDate' => $startDate
			);
			$this->display('hunter_talent_workExp_input', '人才简历-工作经历', $tmpArray);
		}
		else
		{
			$tmpArray = null;
			echo "没有对应记录,转到记录新建";
			$this->newWorkExp($talentId);
		}
	}

	public function editWorkExp($talentId=0, $company=0, $position=0, $startDate=0)
	{
		$displayData = $this->getWorkExpInfo($talentId, $company, $position, $startDate);
		if ($displayData != null)
		{
			$tmpArray = array(
		'talentId' => $talentId,
		'company' => $company,
		'position' => $position,
		'startDate' => $startDate
			);
			$_POST['talentId'] = $displayData['hunter_talent_work_experience_Talent_id'];
			$_POST['company'] = $displayData['hunter_talent_work_experience_Company'];
			//把date转换成月份
			$_POST['startDate'] = substr($displayData['hunter_talent_work_experience_Start_date'], 0, 7);
			$_POST['endDate'] = $displayData['hunter_talent_work_experience_End_date'];
			$_POST['position'] = $displayData['hunter_talent_work_experience_Position'];
			$_POST['salary'] = $displayData['hunter_talent_work_experience_Salary'];
			$_POST['reasonType'] = $displayData['hunter_talent_work_experience_Job_quit_reason_type'];
			$_POST['reasonDetail'] = $displayData['hunter_talent_work_experience_Job_quit_reason_Des'];
			$this->display('hunter_talent_workExp_input', '人才简历-工作经历', $tmpArray);
		}
		else
		{
			$tmpArray = null;
			echo "没有对应记录,转到记录新建";
			$this->newWorkExp($talentId);
		}
	}

	private function getWorkExpInfo($talentId, $company, $position, $startDate)
	{
		$sql = 'SELECT * FROM T_Hunter_Talent_Work_experience ';
		$sql .= 'WHERE hunter_talent_work_experience_Talent_id = ? ';
		$sql .= 'AND hunter_talent_work_experience_Hunter_account = ? ';
		$sql .= 'AND hunter_talent_work_experience_Company = ? ';
		$sql .= 'AND hunter_talent_work_experience_Position = ? ';
		$sql .= 'AND hunter_talent_work_experience_Start_date = ?';
		$tmpParam = array(
		$talentId,
		$this->session->userdata('user'),
		$company,
		$position,
		$startDate
		);
		$tmpRes = $this->db->query($sql, $tmpParam);
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
			}
			$tmpRes->free_all();
		}
		return $displayData;
	}

	public function saveEditWorkExp($talentId)
	{
		$this->setValidate();
		if ($this->form_validation->run() == TRUE)
		{
			$this->db->trans_start();
			$tmpParam=array(
			$talentId,
			$this->session->userdata('user'),
			$this->input->post('company'),
			$this->convertToDate($this->input->post('startDate')),
			$this->input->post('position')
			);
			//del old record
			$sql = 'DELETE FROM T_Hunter_Talent_Work_experience ';
			$sql .= 'WHERE hunter_talent_work_experience_Talent_id = ? ';
			$sql .= 'AND hunter_talent_work_experience_Hunter_account = ? ';
			$sql .= 'AND hunter_talent_work_experience_Company = ? ';
			$sql .= 'AND hunter_talent_work_experience_Start_date = ?';
			$sql .= 'AND hunter_talent_work_experience_Position = ?';
			$tmpRes = $this->db->query($sql, $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_rollback();
				show_error('过期数据删除失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}

			//add new record
			$tmpParam=array(
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
					$this->db->trans_commit();
					echo $tmpResult[0].":".$tmpResult[1];
				}
				else
				{
					$this->db->trans_rollback();
					echo $tmpResult[0].":".$tmpResult[1];
					$this->editWorkExp($this->input->post('talentId'), $this->input->post('company'), $this->input->post('position'), $this->input->post('startDate'));
				}
			}
			$this->db->trans_off();
		}
		else
		{
			$this->reEditWorkExp($this->input->post('talentId'), $this->input->post('company'), $this->input->post('position'), $this->input->post('startDate'));

		}
	}


	private function display($content_view, $page_title, $displayData = array())
	{
		$vars['displayData'] = $displayData;
		$vars['content_view'] = $content_view;
		$hunterAccount = $this->session->userdata('user');
		$vars['page_title'] = $page_title;

		//get exists worExp
		if (count($displayData) == 1)
		{//新建状态
			$tmpParam = array(
			$displayData['talentId'],
			$this->session->userdata('user')
			);
			$sql = 'SELECT * FROM T_Hunter_Talent_Work_experience ';
			$sql .= 'WHERE hunter_talent_work_experience_Talent_id = ? ';
			$sql .= 'AND hunter_talent_work_experience_Hunter_account = ? ';
			$sql .= 'ORDER BY hunter_talent_work_experience_Start_date';
			$tmpRes = $this->db->query($sql, $tmpParam);
		}
		else
		{//编辑状态
			$tmpParam = array(
			$displayData['talentId'],
			$this->session->userdata('user'),
			$displayData['company'],
			$displayData['position'],
			$displayData['startDate']
			);
			$sql = 'SELECT * FROM T_Hunter_Talent_Work_experience ';
			$sql .= 'WHERE hunter_talent_work_experience_Talent_id = ? ';
			$sql .= 'AND hunter_talent_work_experience_Hunter_account = ? ';
			$sql .= 'AND (hunter_talent_work_experience_Company != ?';
			$sql .= 'OR hunter_talent_work_experience_Position != ?';
			$sql .= 'OR hunter_talent_work_experience_Start_date != ?)';
			$sql .= 'ORDER BY hunter_talent_work_experience_Start_date';
			$tmpRes = $this->db->query($sql, $tmpParam);
		}
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		$vars['existWorkExp'] = $tmpRes->result_array();
		$tmpRes->free_all();

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

		$this->load->helper('form');
		$this->load->view('template', $vars);
	}

	private function setValidate()
	{
		$this->load->library('form_validation');
		$config = array(
		array(
						'field'=>'company',
						'label'=>'公司名称',
						'rules'=>'trim|required'
						),
						array(
						'field'=>'startDate',
						'label'=>'开始日期',
						'rules'=>'required|callback_checkDate'
						),
						array(
						'field'=>'endDate',
						'label'=>'结束日期',
						'rules'=>'callback_checkDate'
						),
						array(
						'field'=>'position',
						'label'=>'职位',
						'rules'=>'required'
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

	//把月份转为每个月的第一天
	private function convertToDate($str)
	{
		if ($str != null)
		{
			return $str."-01";
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
