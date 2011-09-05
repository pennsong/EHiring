<div class="container">
	<div class="span-24 maintext blue">
		<hr />
		<div class="prepend-1 append-1">
			<table>
				<thead>
					<tr>
						<th class="span-2">姓名</th>
						<th class="span-3">应聘职位</th>
						<th class="span-2">项目所在地</th>
						<th class="span-1">城市</th>
						<th class="span-1">年龄</th>
						<th class="span-1">性别</th>
						<th class="span-2">状态</th>
						<th class="span-2">评定结果</th>
						<th class="span-3">推荐职位</th>
						<th class="span-2">操作内容</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$tmpCount=0;
				foreach ($submit_update_list as $submit_update)
				{
					$tmpCount++;
					if ($tmpCount % 2 == 0)
					{
						echo '<tr class="even">'."\n";
					}
					else
					{
						echo '<tr>'."\n";
					}
					echo "	<td><a href=\"\">{$submit_update['hunter_talent_job_Talent_name']}</a></td>\n";
					echo "	<td>{$submit_update['job_Title']}</td>\n";
					echo "	<td>{$submit_update['location_display']}</td>\n";
					echo "	<td>{$submit_update['R_talent_city']}</td>\n";
					echo "	<td>{$submit_update['R_age']}</td>\n";
					echo "	<td>{$submit_update['R_sex']}</td>\n";
					echo "	<td>{$submit_update['hunter_talent_job_submit_status_Des']}</td>\n";
					echo "	<td>{$submit_update['R_star']}</td>\n";
					echo "	<td>{$submit_update['preferJobs']}</td>\n";
					echo "	<td><a href=\"\">选择</a>    <a href=\"\">拒绝</a></td>\n";
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
			<tfoot>
				<tr>
					<td><a href="">更多求职人员动态</a>
					</td>
				</tr>
			</tfoot>
		</div>
		<hr class="space" />
		<hr />
		<div class="prepend-1 append-1">
			<table>
				<thead>
					<tr>
						<th class="span-2">职位编号</th>
						<th class="span-3">职位名称</th>
						<th class="span-3">职位简述</th>
						<th class="span-2">招聘地点</th>
						<th class="span-2">薪资待遇</th>
						<th class="span-2">开始时间</th>
						<th class="span-2">结束时间</th>
						<th class="span-1">推荐</th>
						<th class="span-1">待选</th>
						<th class="span-1">选择</th>
						<th class="span-1">拒绝</th>
						<th class="span-2">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$tmpCount=0;
				foreach ($jobs as $job)
				{
					$tmpCount++;
					if ($tmpCount % 2 == 0)
					{
						echo '<tr class="even">'."\n";
					}
					else
					{
						echo '<tr>'."\n";
					}
					echo "	<td><a href=\"\">{$job['job_Id']}</a>\n";
					echo "	</td>\n";
					echo "	<td><a href=\"\">{$job['job_Title']}</a>\n";
					echo "	</td>\n";
					echo "	<td>{$job['job_Simple_des']}</td>\n";
					echo "	<td>{$job['location_display']}</td>\n";
					echo "	<td>{$job['R_salary']}</td>\n";
					echo "	<td>{$job['job_Start_date']}</td>\n";
					echo "	<td>{$job['job_End_date']}</td>\n";
					echo "	<td>{$job['totalPersonNum']}</td>\n";
					echo "	<td>{$job['R_submitted']}</td>\n";
					echo "	<td>{$job['R_passed']}</td>\n";
					echo "	<td>{$job['R_rejected']}</td>\n";
					echo "	<td><a href=\"\">挑人才</a>\n";
					echo "	</td>\n";
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
			<tfoot>
				<tr>
					<td><a href="">更多职位</a>
					</td>
					<td><?php echo anchor_popup('enterprise_job/newJob', '创建新职位');?>
					</td>
				</tr>
			</tfoot>
		</div>
		<hr class="space" />
	</div>
</div>
