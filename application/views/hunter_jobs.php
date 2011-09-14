<div class="span-24 maintext blue">
	<hr class="space" />
	<hr class="space" />
	<?php
	foreach ($jobs as $job)
	{
		echo "<div>\n";
		$tmpAtts = array('class'=>'prepend-2 last bluebord append-2');
		$tempHunterAccount = $this->session->userdata('user');
		echo anchor_popup("job_info_to_hunter/index/$job[job_Id]/0", $job['job_Title'], $tmpAtts);
		echo "<span class=\"rbs1 prepend-18\"> <input class=\"rb1\" type=\"button\" title=\"推荐\" value=\"推荐人才\"> </span>\n";
		echo "<div class=\"prepend-2 blue\">\n";
		echo "	<div class=\"span-4\">\n";
		echo "		地点:        <span class=\"gray\">{$job['location_display']}</span>\n";
		echo "	</div>\n";
		echo "	<div class=\"span-4\">\n";
		echo "		基本工资:  <span class=\"gray\">{$job['R_salary']}</span>\n";
		echo "	</div>\n";
		echo "	<div class=\"span-6\">\n";
		echo "		佣金:        <span class=\"gray\">{$job['R_commission']}</span>\n";
		echo "	</div>\n";
		echo "	<div style=\"clear: both\"></div>\n";
		echo "	<div class=\"span-4\">\n";
		echo "		人数:        <span class=\"gray\">{$job['job_Recruit_num']}</span>\n";
		echo "	</div>\n";
		echo "	<div class=\"span-4\">\n";
		echo "		需要经验: <span class=\"gray\">{$job['R_work_experience']}</span>\n";
		echo "	</div>\n";
		echo "	<div class=\"span-6\">\n";
		echo "		有效期:     <span class=\"gray\">{$job['R_period_of_validity']}</span>\n";
		echo "	</div>\n";
		echo "	<div style=\"clear: both\"></div>\n";
		echo "	<div class=\"span-24\">\n";
		echo anchor(site_url('Hunter_submit_update'), '推荐:'.$job['totalPersonNum'].'人').'&nbsp';
		echo anchor(site_url('Hunter_submit_update'), '待选择:'.$job['R_1status'].'人').'&nbsp';
		echo anchor(site_url('Hunter_submit_update'), '已选择:'.$job['R_2status'].'人').'&nbsp';
		echo anchor(site_url('Hunter_submit_update'), '已拒绝:'.$job['R_3status'].'人').'&nbsp';
		echo "	</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "<hr class=\"space\" />";
	}
	?>
	<div class="span-18 prepend-7">
		<?php echo $this->pagination->create_links();?>
	</div>
	<hr class="space" />
	<hr />
</div>