<div class="span-24" style="background-color: #FFFFFF">
	<div class="span-17">
		<hr class="space" />
		<h3 class="prepend-1 blue bord" style="margin-top: 20px;">现有职位</h3>
		<hr />
		<div>
			<?php
			foreach ($jobs as $job)
			{
				$tmpAtts = array('class'=>'prepend-2 last bluebord');
				$tempHunterAccount = $this->session->userdata('user');
				echo anchor_popup("job_info_to_hunter/index/$job[job_Id]/0", $job['job_Title'], $tmpAtts);
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
				echo "<hr class=\"space\" />";
			}
			?>
		</div>
		<hr class="space" />
		<div class="span-5 prepend-2 blue bord">
			<?php echo anchor(site_url('hunter_jobs'), '更多职位');?>
		</div>
		<hr class="space" />
		<div class="span-17">
			<h3 class="prepend-1 blue bord" style="margin-top: 20px">求职人员动态</h3>
			<hr />
			<div class="prepend-1 append-1">
				<table style="color: #666666">
					<thead>
						<tr>
							<th class="span-2">姓名</th>
							<th class="span-2">职位</th>
							<th class="span-4">操作时间</th>
							<th class="span-4">操作内容</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tmpCount = 0;
						foreach ($statusList as $status)
						{
							$tmpCount++;
							if ($tmpCount % 2 == 0)
							{
								echo '<tr class="even">';
							}
							else
							{
								echo '<tr>';
							}
							echo "<td><a href=\"\">{$status['hunter_talent_job_Talent_name']} </a></td>\n";
							echo "<td>{$status['job_Title']} </td>\n";
							echo "<td>{$status['hunter_talent_job_Status_update_time']} </td>\n";
							echo "<td>{$status['hunter_talent_job_submit_status_Des']} </td>\n";
							echo "</tr>";
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td><?php echo anchor(site_url('Hunter_submit_update'), '更多求职人员动态');?></td>
							<td><a href="">新建人才</a></td>
							<td><a href="">批量导入人才</a></td>
							<td><a href="">去系统人才库筛选人才</a></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>