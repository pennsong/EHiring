<div class="container">
	<div class="span-24 maintext blue">
		<hr class="space"/>
		<div class="span-15 prepend-1">
			<label>城市:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<select style="width:200px;color:#999999">
				<option>上海</option>
				<option>北京</option>
			</select>
			<div style="clear:both"></div>
			<label>姓名模糊查询:&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input class='text' value = "请输入模糊查询条件..." style="width:198px;padding:0px;border:1px solid #7F9CBA;height:20px;padding-top:6px;color:#999999" />
		</div>
		<div style="clear:both"></div>
		<div  class="prepend-1" >
			<hr class="space" />
			<span class="rbs1">
				<input class="rb1" type="button"  title="查询" value="查询">
			</span>
		</div>
		<hr class="space" />
		<hr />
		<hr class="space" />
		<div class="prepend-1 append-1">
			<table>
				<thead>
					<tr>
						<th class="span-2">姓名</th>
						<th class="span-3">人才所在城市</th>
						<th class="span-3">应聘职位</th>
						<th class="span-2">年龄</th>
						<th class="span-2">性别</th>
						<th class="span-2">状态</th>
						<th class="span-3">操作时间</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($submit_update_list as $submit_update)
					{
						echo "<tr>\n";
						echo "	<td><a href=\"\">{$submit_update['hunter_talent_job_Talent_name']}</a></td>\n";
						echo "	<td>{$submit_update['R_city']}</td>\n";
						echo "	<td><a href=\"\">{$submit_update['job_Title']}</a></td>\n";
						echo "	<td>{$submit_update['R_age']}</td>\n";
						echo "	<td>{$submit_update['R_sex']}</td>\n";
						echo "	<td>{$submit_update['hunter_talent_job_submit_status_Des']}</td>\n";
						echo "	<td>{$submit_update['hunter_talent_job_Status_update_time']}</td>\n";
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
