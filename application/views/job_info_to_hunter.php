<div class="container">
	<div class="span-24 maintext blue">
		<hr class="space" />
		<h3 class="prepend-1 blue bord" style="margin-top: 20px"> <?php echo $jobInfo[0]['job_Title'];?></h3>
		<hr class="space" />
		<div class="prepend-1 blue">
			<div class="span-3 append-1">
				地点:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray"><?php echo $location_display;?></span>
			</div>
			<div class="span-3 append-1">
				基本工资:&nbsp;&nbsp;<span class="gray"><?php echo $jobInfo[0]['R_salary'];?></span>
			</div>
			<div class="span-5 append-1">
				佣金:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray"><?php echo $jobInfo[0]['R_commission'];?></span>
			</div>
			<div style="clear: both">
			</div>
			<div class="span-3 append-1">
				人数:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray"><?php echo $jobInfo[0]['job_Recruit_num'];?></span>
			</div>
			<div class="span-3 append-1">
				需要经验:&nbsp;<span class="gray"><?php echo $jobInfo[0]['R_work_experience'];?>年</span>
			</div>
			<div class="span-5 append-1">
				有效期:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray"><?php echo $jobInfo[0]['R_period_of_validity'];?></span>
			</div>
			<div style="clear: both">
			</div>
			<div class="span-3 append-1">
				学历标准:&nbsp;<span class="gray"> <?php
				if (count($degrees) > 0)
				{
					foreach ($degrees as $degree)
					{
						echo $degree['degree_Des'];
					}
				}
				else
				{
					echo '无限制';
				}
					?></span>
			</div>
			<div class="span-8 append-1">
				简述:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray"><?php echo $jobInfo[0]['job_Simple_des'];?></span>
			</div>
			<div style="clear: both">
			</div>
			<div class="span-11 append-1">
				职位详述:&nbsp;<span class="gray"><?php echo $jobInfo[0]['job_Detail_des'];?></span>
			</div>
			<div style="clear: both">
			</div>
			<hr class="space">
		</div>
		<hr class="space">
		<hr />
		<div class="span-15 prepend-1">
			<label>城市:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<select style="width: 200px; color: #999999">
				<option>上海</option>
				<option>北京</option>
			</select>
			<div style="clear: both">
			</div>
			<label>姓名模糊查询:&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input class='text' value="请输入模糊查询条件..." style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 16px; padding-top: 3px; color: #999999" />
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
						<th class="span-1">姓名</th>
						<th class="span-1">年龄</th>
						<th class="span-1">性别</th>
						<th class="span-1">城市</th>
						<th class="span-3">联系方式</th>
						<th class="span-2">QQ</th>
						<th class="span-2">评定结果</th>
						<th class="span-2">推荐职位</th>
						<th class="span-3">操作内容</th>
					</tr>
				</thead>
				<tbody>
					<?php $tmpCount = 0;
					foreach ($talentList as $talentInfo)
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
						echo "<td>\n";
						echo "<input type=\"checkbox\" />\n";
						echo "</td>\n";
						echo "<td><a href=\"\">{$talentInfo['hunter_talent_Talent_Name']} </a></td>\n";
						echo "<td>{$talentInfo['R_age']}</td>\n";
						echo "<td>{$talentInfo['sex_Name']} </td>\n";
						echo "<td>{$talentInfo['R_city_name']} </td>\n";
						echo "<td>{$talentInfo['hunter_talent_Talent_mobile']} </td>\n";
						echo "<td>{$talentInfo['hunter_talent_Talent_qq']}</td>\n";
						echo "<td>{$talentInfo['R_star']} </td>\n";
						echo "<td>{$talentInfo['preferJobs']}</td>\n";
						echo "<td><a href=\"\">看简历</a>    <a href=\"\">推荐</a></td>\n";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
			<span class="rbs1">
				<input class="rb1" type="button" title="推荐" value="推荐">
			</span>
		</div>
		<hr class="space" />
		<div class="span-18 prepend-7">
			<?php echo $this->pagination->create_links();?>
		</div>
	</div>
</div>
