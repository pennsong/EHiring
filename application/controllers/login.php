<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	}

	public function index()
	{
		$vars['content_view'] = 'login';
		$vars['page_title'] = '登录';
		$this->load->view('template', $vars);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url()."index.php/login");
	}

	public function submit_validate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', '用户名', 'trim|required|callback_authenticate');
		$this->form_validation->set_rules('password', '密码', 'trim|required');
		$this->form_validation->set_rules('type', '用户类别', 'required');
		$this->form_validation->set_message('required', '%s必填');
		$this->form_validation->set_message('authenticate', '登录失败');
		if ($this->form_validation->run() == TRUE)
		{
			if ($this->session->userdata('type') == 'hunter')
			{
				redirect(base_url().'index.php/hunter_home');
			}
			else if ($this->session->userdata('type') == 'hr')
			{
				redirect(base_url().'index.php/enterprise_home');
			}
			else
			{
				$vars['content_view'] = 'login';
				$vars['page_title'] = '登录';
				$this->load->view('template', $vars);
			}
		}
		else
		{
			$vars['content_view'] = 'login';
			$vars['page_title'] = '登录';
			$this->load->view('template', $vars);
		}
	}

	public function authenticate()
	{
		if ($this->input->post('type') == 'hunter')
		{
			$tmpRes = $this->db->query('SELECT hunter_Password FROM T_hunter WHERE hunter_Account = ?', $this->input->post('username'));
			if ($tmpRes && $tmpRes->num_rows() > 0)
			{
				$tmpArr = $tmpRes->first_row('array');
				if ($tmpArr['hunter_Password'] == $this->input->post('password'))
				{
					$this->session->set_userdata('user', $this->input->post('username'));
					$this->session->set_userdata('type', 'hunter');
					return TRUE;
				}
			}
			$tmpRes->free_all();
		}
		else if ($this->input->post('type') == 'hr')
		{
			$tmpRes = $this->db->query('SELECT enterprise_user_Password FROM T_Enterprise_user WHERE enterprise_user_account = ?', $this->input->post('username'));
			if ($tmpRes && $tmpRes->num_rows() > 0)
			{
				$tmpArr = $tmpRes->first_row('array');
				if ($tmpArr['enterprise_user_Password'] == $this->input->post('password'))
				{
					$this->session->set_userdata('user', $this->input->post('username'));
					$this->session->set_userdata('type', 'hr');
					return TRUE;
				}
			}
			$tmpRes->free_all();
		}
		return FALSE;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
