<?php
/**
 *
 */
class CW_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!CW_Controller::_checkLogin())
		{
			redirect(base_url()."index.php/login");
		}
	}

	public function _checkLogin()
	{
		if ($this->session->userdata('user') && $this->session->userdata('type'))
		{
			if ($this->session->userdata('type') == 'hunter')
			{
				$tmpRes = $this->db->query("SELECT * FROM T_Hunter WHERE hunter_Account = '{$this->session->userdata('user')}';");
				if ($tmpRes && $tmpRes->num_rows > 0)
				{
					return TRUE;
				}
			}
			else if ($this->session->userdata('type') == 'hr')
			{
				$tmpRes = $this->db->query("SELECT * FROM T_Enterprise_user WHERE enterprise_user_Account = '{$this->session->userdata('user')}';");
				if ($tmpRes && $tmpRes->num_rows > 0)
				{
					return TRUE;
				}
			}
			return FALSE;
		}
	}

}
