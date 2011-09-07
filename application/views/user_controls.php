<div id="header-wrapper">
	<div style="float: right; clear: right; padding-top: 4px; height: 20px">
		<?php
		$log_in = FALSE;
		if ($this->session->userdata('user') && $this->session->userdata('type'))
		{
			if ($this->session->userdata('type') == 'hunter')
			{
				$this->db->where('hunter_Account', $this->session->userdata('user'));
				$this->db->from('T_hunter');
				if ($this->db->count_all_results() > 0)
				{
					$log_in = TRUE;
				}
			}
			else if ($this->session->userdata('type') == 'hr')
			{
				$this->db->where('enterprise_user_account', $this->session->userdata('user'));
				$this->db->from('T_Enterprise_user');
				if ($this->db->count_all_results() > 0)
				{
					$log_in = TRUE;
				}
			}
		}
		if ($log_in)
		{
			echo '欢迎您:'.$this->session->userdata('user').":".$this->session->userdata('type');
		}
		else
		{
			echo "<div style=\"float: left; width: 40px; text-align: center\">\n";
			echo "	<a style=\"color: #FFFFFF;\"\n";
			echo "	href=\"{site_url(\"login\")}\">登录</a>\n";
			echo "</div>\n";
			echo "<div style=\"float: left; width: 40px; text-align: center\">\n";
			echo "	<a style=\"color: #FFFFFF;\" href=\"#\">注册</a>\n";
			echo "</div>";
		}
		?>
		<div style="float: left; width: 40px; text-align: center">
			<a style="color: #FFFFFF;" href="<?php echo site_url("login/logout");?>">退出</a>
		</div>
	</div>
	<hr class="space" />
	<img src="<?php echo base_url()?>images/img02.jpg" class="push-1" />
	<h1 class="span-4 prepend-2"><a href="#">E-hiring</a></h1>
	<p class="span-4" style="margin-top: 15px; color: #FFFFFF">
		&nbsp;&nbsp;&nbsp;&nbsp;综合招聘信息平台
	</p>
	<div style="clear: both"></div>
	<?php
	if (isset($navigation_menu) && $navigation_menu == 'navigation_menu' && $this->session->userdata('type') == 'hunter')
	{
		echo "<div id=\"menu\" style=\"float: left\">\n";
		echo "<ul";
		echo "<li";
		if ($nowPage == 'firstPage')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('hunter_home'), '首页');
		echo "</li>";
		echo "<li";
		if ($nowPage == 'hunterJobs')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('hunter_jobs'), '项目');
		echo "</li>";
		echo "<li";
		if ($nowPage == 'submitUpdate')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('hunter_submit_update'), '动态');
		echo "</li>";
		echo "<li";
		if ($nowPage == 'huntersTalent')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('hunters_talent'), '人才库');
		echo "</li>";
		echo "</ul>";
		echo "</div>\n";
		echo "<div style=\"float: right; padding-right: 30px\">\n";
		echo "	<form action=\"#\" method=\"get\">\n";
		echo "		<div>\n";
		echo "			<input type=\"text\" value=\"\" id=\"search-text\" name=\"s\"\n";
		echo "			style=\"height: 20px\"\n";
		echo "			>\n";
		echo "			<span class=\"gbs1\">\n";
		echo "				<input class=\"gb1\" type=\"button\" title=\"Go\"\n";
		echo "				value=\"Go\"\n";
		echo "				>\n";
		echo "			</span>\n";
		echo "		</div>\n";
		echo "	</form>\n";
		echo "</div>";
	}
	else if (isset($navigation_menu) && $navigation_menu == 'navigation_menu' && $this->session->userdata('type') == 'hr')
	{
		echo "<div id=\"menu\" style=\"float: left\">\n";
		echo "<ul";
		echo "<li";
		if ($nowPage == 'firstPage')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('enterprise_home'), '首页');
		echo "</li>";
		echo "<li";
		if ($nowPage == 'enterpriseSubmitUpdate')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('enterprise_submit_update'), '动态');
		echo "</li>";
		echo "<li";
		if ($nowPage == 'enterpriseJobs')
			echo ' class="nowpage" ';
		echo ">";
		echo anchor(site_url('enterprise_jobs'), '项目');
		echo "</li>";
		echo "</ul>";
		echo "</div>\n";
		echo "<div style=\"float: right; padding-right: 30px\">\n";
		echo "	<form action=\"#\" method=\"get\">\n";
		echo "		<div>\n";
		echo "			<input type=\"text\" value=\"\" id=\"search-text\" name=\"s\"\n";
		echo "			style=\"height: 20px\"\n";
		echo "			>\n";
		echo "			<span class=\"gbs1\">\n";
		echo "				<input class=\"gb1\" type=\"button\" title=\"Go\"\n";
		echo "				value=\"Go\"\n";
		echo "				>\n";
		echo "			</span>\n";
		echo "		</div>\n";
		echo "	</form>\n";
		echo "</div>";
	}
	?>
</div>
<!-- end #header -->
