<div class="container">
	<div class="span-24 maintext blue">
		<hr class="space" />
		<h3 class="prepend-1 blue bord" style="margin-top: 20px">
			人才库 <span style="font-size: 14px; font-weight: normal"><a class="prepend-1" href="">新建求职人员</a> </span>&nbsp;&nbsp; <span style="font-size: 14px; font-weight: normal"><a class="prepend-1" href="">求职人员批量导入</a> </span>&nbsp;&nbsp; <span style="font-size: 14px; font-weight: normal"><a class="prepend-1" href="">去系统公共资源筛选人才</a> </span>
		</h3>
		<hr class="space" />
		<div class="span-15 prepend-1">
			<label>城市:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <select style="width: 200px; color: #999999">
				<option>上海</option>
				<option>北京</option>
			</select>
			<div style="clear: both"></div>
			<label>姓名模糊查询:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input class='text' value="请输入模糊查询条件..." style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 16px; padding-top: 3px; color: #999999" />
		</div>
		<div style="clear: both"></div>
		<div class="prepend-1">
			<hr class="space" />
			<span class="rbs1"> <input class="rb1" type="button" title="查询" value="查询"> </span>
		</div>
		<hr class="space" />
		<hr />
		<div class="prepend-1 append-1">
			<label>人才库</label>
			<table>
				<thead>
					<tr>
						<th class="span-1">姓名</th>
						<th class="span-1">年龄</th>
						<th class="span-1">性别</th>
						<th class="span-3">联系方式</th>
						<th class="span-2">QQ</th>
						<th class="span-2">评定结果</th>
						<th class="span-2">推荐职位</th>
						<th class="span-2">编辑简历</th>
						<th class="span-2">人才评定</th>
						<th class="span-3">视频简历</th>
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
					echo "<td><a href=\"\">{$talentInfo['hunter_talent_Talent_Name']} </a></td>\n";
					echo "<td>{$talentInfo['R_age']}</td>\n";
					echo "<td>{$talentInfo['sex_Name']} </td>\n";
					echo "<td>{$talentInfo['hunter_talent_Talent_mobile']} </td>\n";
					echo "<td>{$talentInfo['hunter_talent_Talent_qq']}</td>\n";
					echo "<td>{$talentInfo['R_star']} </td>\n";
					echo "<td>{$talentInfo['preferJobs']}</td>\n";
					echo "<td><a href=\"\">编辑</a></td>\n";
					echo "<td><a href=\"\">评定</a></td>\n";
					echo "<td><a href=\"\">在线观看 下载视频</a></td>\n";
					echo "</tr>";
				}
				?>
				</tbody>
			</table>
			<span class="rbs1"> <input class="rb1" type="button" title="推荐" value="推荐"> </span>
		</div>
		<hr class="space" />
		<div class="span-18 prepend-7">
		<?php echo $this->pagination->create_links();?>
		</div>
	</div>
</div>
