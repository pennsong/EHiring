<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class Enterprise_new_job extends CW_Controller
{
	var $saveResult;
	public function index()
	{
		if (isset($this->saveResult))
		{
			$vars['saveResult'] = $this->saveResult;
		}
		$vars['content_view'] = 'enterprise_new_job';
		$hunterAccount = $this->session->userdata('user');
		$vars['page_title'] = '创建新职位';
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
	
	public function saveJob()
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
						'rules'=>'is_natural|callback_isDate'
						),
						array(
						'field'=>'endDate',
						'label'=>'有效期结束',
						'rules'=>'is_natural|callback_isDate'
						),
						array(
						'field'=>'jobDetailDes',
						'label'=>'职位详述',
						'rules'=>'max_length[1000]'
						)
						);
						$this->form_validation->set_rules($config);
						$this->form_validation->set_message('isDate', '%s不正确');
						if ($this->form_validation->run() == TRUE)
						{
							//call P_G_createNewJob 创建新职位
							$tmpParam = array(
							$this->input->post('jobTitle'),
							null,
							$this->input->post('jobSimpleDes'),
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
							$tmpRes = $this->db->query('call P_G_createNewJob(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $tmpParam);
							if (!$tmpRes)
							{
								$this->db->trans_complete();
								show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
							}
							else
							{
								$tmpRes->free_all();
								$this->db->trans_complete();
							}
							$this->db->trans_off();
							$this->saveResult = '保存成功!';
							$this->index();
						}
						else
						{
							$this->index();
						}
	}

	public function editJob()
	{
		
	}
	
	public function isDate($str)
	{
		if ($str != NULL)
		{

			$year = substr($str, 0, 4);
			$month = substr($str, 4, 2);
			$day = substr($str, 6, 2);
			return checkdate($month, $day, $year);
		}
		else
		{
			return TRUE;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
