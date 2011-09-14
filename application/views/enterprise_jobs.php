<div class="span-24 maintext blue">
	<hr class="space" />
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
				$tmpCount = 0;
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
	</div>
	<hr class="space" />
	<div class="span-18 prepend-7">
		<?php echo $this->pagination->create_links();?>
	</div>
	<hr class="space" />
	<hr />
</div>