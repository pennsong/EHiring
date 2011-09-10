<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Hunter_talent_resume extends CW_Controller
{
	public function newResume()
	{
		$this->display('hunter_talent_info_input', '新建人才简历-基本信息', 'new');
	}

	public function editResume($talentId = null)
	{
		if ($talentId == null)
		{
			echo "你所访问的地址不存在!";
			return;
		}
		else
		{
			$displayData = $this->getResumeInfo($talentId);
			if ($displayData == null)
			{
				echo "记录不存在";
				return;
			}
			else
			{
				//process location data
				if ($displayData['hunter_talent_Talent_location_type_id'] == 1)
				{
					$_POST['province'] = $displayData['hunter_talent_Talent_live_id'];
					$_POST['city'] = '';
				}
				else if ($displayData['hunter_talent_Talent_location_type_id'] == 2)
				{
					$tmpRes = $this->db->query('SELECT city_Province_id FROM T_City WHERE city_Id = ?', $displayData['hunter_talent_Talent_live_id']);
					if (!$tmpRes)
					{
						show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
					}
					else
					{
						if ($tmpRes->num_rows() == 0)
						{
							$_POST['province'] = '';
							$_POST['city'] = '';
						}
						else
						{
							$_POST['province'] = $tmpRes->row()->city_Province_id;
							$_POST['city'] = $displayData['hunter_talent_Talent_live_id'];
						}
					}
				}
				else if ($displayData['hunter_talent_Talent_location_type_id'] == 3)
				{
					$tmpRes = $this->db->query('SELECT r_province_id, r_city_id FROM v_location_info WHERE location_type_id = 3 AND location_id = ?', $displayData['hunter_talent_Talent_live_id']);
					if (!$tmpRes)
					{
						show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
					}
					else
					{
						if ($tmpRes->num_rows() == 0)
						{
							$_POST['province'] = '';
							$_POST['city'] = '';
						}
						else
						{
							$_POST['province'] = $tmpRes->row()->r_province_id;
							$_POST['city'] = $tmpRes->row()->r_city_id;
							;
						}
					}
				}
				$_POST['talentId'] = $displayData['hunter_talent_Talent_id'];
				$_POST['talentName'] = $displayData['hunter_talent_Talent_name'];
				$_POST['talentSex'] = $displayData['hunter_talent_Talent_sex_id'];
				$_POST['talentMobile'] = $displayData['hunter_talent_Talent_mobile'];
				$_POST['talentQQ'] = $displayData['hunter_talent_Talent_qq'];
				$_POST['talentIdCard'] = $displayData['hunter_talent_Talent_id_card'];
				$_POST['talentBornPlace'] = $displayData['hunter_talent_Talent_born_place'];
				$_POST['talentAddress'] = $displayData['hunter_talent_Talent_live_street'];
				$_POST['talentHeight'] = $displayData['hunter_talent_Talent_height'];
				$_POST['talentWeight'] = $displayData['hunter_talent_Talent_weight'];
				$this->display('hunter_talent_info_input', '编辑人才简历-基本信息', 'edit', $talentId);
			}
		}
	}

	public function getResumeInfo($talentId)
	{
		$tmpRes = $this->db->query('SELECT * FROM T_Hunter_Talent WHERE hunter_talent_Talent_id = ?', $talentId);
		if (!$tmpRes)
		{
			show_error('数据查询失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
		}
		else
		{
			if ($tmpRes->num_rows() == 0)
			{
				//todo 处理没有查到所要编辑记录状况
				return NULL;
			}
			else
			{
				$displayData = $tmpRes->row_array();
				return $displayData;
			}
		}
	}

	public function saveEditResume($talentId)
	{
		$this->setValidate('edit');
		if ($this->form_validation->run() == TRUE)
		{
			//process live location
			if ($this->input->post('city') != null)
			{
				$locationTypeId = 2;
				$liveLocationId = $this->input->post('city');
			}
			else if ($this->input->post('province') != null)
			{
				$locationTypeId = 1;
				$liveLocationId = $this->input->post('province');
			}
			else
			{
				$locationTypeId = null;
				$liveLocationId = null;
			}
			$this->db->trans_start();
			$tmpParam = array(
					$this->session->userdata('user'),
					$talentId,
					$this->input->post('talentIdCard'),
					$this->input->post('talentName'),
					$this->input->post('talentHeight'),
					$this->input->post('talentWeight'),
					null,
					$this->input->post('talentSex'),
					$this->input->post('talentMobile'),
					null,
					$this->input->post('talentQQ'),
					null,
					$this->input->post('talentBornPlace'),
					$locationTypeId,
					$liveLocationId,
					$this->input->post('talentAddress'),
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
			$tmpRes = $this->db->query('SELECT F_updateHunterTalent(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) Result', $tmpParam);
			if (!$tmpRes)
			{
				$this->db->trans_complete();
				show_error('数据插入失败，请重试!'.$this->db->_error_number().":".$this->db->_error_message());
			}
			else
			{
				$tmpResult = $tmpRes->row()->Result;
				if ($tmpResult > 0)
				{
					$this->db->trans_commit();
					echo "保存成功！";
					redirect(site_url('hunter_talent_workExp/newWorkeXP').'/'.$talentId);
				}
				else
				{
					$this->db->trans_commit();
					echo "数据没有改动！";
					redirect(site_url('hunter_talent_workExp/newWorkeXP').'/'.$talentId);
				}
			}
			$this->db->trans_off();
		}
		else
		{
			$this->display('hunter_talent_info_input', '编辑人才简历-基本信息', 'edit', $talentId);
		}
	}

	public function saveNewResume()
	{
		$this->setValidate('new');
		if ($this->form_validation->run() == TRUE)
		{
			//process live location
			if ($this->input->post('city') != null)
			{
				$locationTypeId = 2;
				$liveLocationId = $this->input->post('city');
			}
			else if ($this->input->post('province') != null)
			{
				$locationTypeId = 1;
				$liveLocationId = $this->input->post('province');
			}
			else
			{
				$locationTypeId = null;
				$liveLocationId = null;
			}
			$this->db->trans_start();
			$tmpParam = array(
					$this->input->post('talentId'),
					$this->session->userdata('user'),
					$this->input->post('talentIdCard'),
					$this->input->post('talentName'),
					$this->input->post('talentHeight'),
					$this->input->post('talentWeight'),
					null,
					$this->input->post('talentSex'),
					$this->input->post('talentMobile'),
					null,
					$this->input->post('talentQQ'),
					null,
					$this->input->post('talentBornPlace'),
					$locationTypeId,
					$liveLocationId,
					$this->input->post('talentAddress'),
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
			$tmpRes = $this->db->query('SELECT F_G_createNewHunterTalent(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) Result', $tmpParam);
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
					redirect(site_url('hunter_talent_workExp/newWorkeXP').'/'.$this->input->post('talentId'));
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

	public function getLivePlaceDiv($provinceId = '', $cityId = '')
	{
		$vars['provinceSelected'] = $provinceId;
		$vars['citySelected'] = $cityId;
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

	private function display($content_view, $page_title, $displayType, $talentId = null)
	{
		$vars['talentId'] = $talentId;
		$vars['type'] = $displayType;
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

	private function setValidate($type)
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
						'rules'=>'trim'
				),
				array(
						'field'=>'talentQQ',
						'label'=>'QQ',
						'rules'=>'alpha_numeric'
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
		if ($type == 'new')
		{
			array_push($config, array(
					'field'=>'talentId',
					'label'=>'人才id',
					'rules'=>'required|is_natural|exact_length[11]'
			));
		}
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('checkIdCard', '身份证号码格式不对');
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
