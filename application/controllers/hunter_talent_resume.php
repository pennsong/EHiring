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
			$this->db->trans_start();
			$tmpParam=array(
			$this->session->userdata('user'),
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
			$tmpRes = $this->db->multi_query('SELECT F_G_createNewHunterTalent(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) Result', $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_rollback();
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				$tmpResult = explode('@', $tmpRes->row()->Result);
				if ($tmpResult[0] == 'SUCCESS')
				{
					$this->db->trans_commit();
					echo $tmpResult[0].":".$tmpResult[1];
					$this->newResume();
				}
				else
				{
					$this->db->trans_rollback();
					echo $tmpResult[0].":".$tmpResult[1];
					$this->newResume();
				}
			}
			$this->db->trans_off();
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
		if ($this->input->post('talentMobile') == null && $this->input->post('talentQQ') == null)
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


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
