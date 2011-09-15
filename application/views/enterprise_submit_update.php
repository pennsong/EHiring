<div class="container">
	<div class="span-24 maintext blue">
		<hr class="space" />
		<div class="span-15 prepend-1">
			<label>城市:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<select style="width: 200px; color: #999999">
				<option>上海</option>
				<option>北京</option>
			</select>
			<div style="clear: both">
			</div>
			<label>姓名模糊查询:&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input class='text' value="请输入模糊查询条件..." style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
		</div>
		<div style="clear: both">
		</div>
		<div class="prepend-1">
			<hr class="space" />
			<span class="rbs1">
				<input class="rb1" type="button" title="查询" value="查询">
			</span>
		</div>
		<hr class="space" />
		<hr />
		<hr class="space" />
		<div class="prepend-1 append-1">
			<table>
				<thead>
					<tr>
						<th class="span-1">
						<input type="checkbox" />
						</th>
						<th class="span-2">用户名</th>
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
					$tmpCount = 0;
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
						echo "	<td><input type=\"checkbox\" />\n";
						echo "	</td>\n";
						echo "	<td><a href=\"\">{$submit_update['hunter_talent_job_Talent_Id']}</a>\n";
						echo "	</td>\n";
						echo "	<td>{$submit_update['hunter_talent_job_Talent_name']}</td>\n";
						echo "	<td><a href=\"\">{$submit_update['job_Title']}</a>\n";
						echo "	</td>\n";
						echo "	<td>{$submit_update['location_display']}</td>\n";
						echo "	<td>{$submit_update['R_talent_city']}</td>\n";
						echo "	<td>{$submit_update['R_age']}</td>\n";
						echo "	<td>{$submit_update['R_sex']}</td>\n";
						echo "	<td>{$submit_update['hunter_talent_job_submit_status_Des']}</td>\n";
						echo "	<td>{$submit_update['R_star']}</td>\n";
						echo "	<td>{$submit_update['preferJobs']}</td>\n";
						if ($submit_update['hunter_talent_job_Status'] == 1)
						{
							echo "	<td>".anchor(site_url('enterprise_submit_update/chooseTalent').'/'.$offset.'/'.$submit_update['hunter_talent_job_Hunter_account'].'/'.$submit_update['hunter_talent_job_Talent_Id'].'/'.$submit_update['job_Id'].'/'.'2', '选择')."  ".anchor(site_url('enterprise_submit_update/chooseTalent').'/'.$offset.'/'.$submit_update['hunter_talent_job_Hunter_account'].'/'.$submit_update['hunter_talent_job_Talent_Id'].'/'.$submit_update['job_Id'].'/'.'3', '拒绝')."</td>\n";
						}
						else
						{
							echo "<td></td>\n";
						}
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="span-18 prepend-7">
			<?php echo $this->pagination->create_links();?>
		</div>
	</div>
</div>
