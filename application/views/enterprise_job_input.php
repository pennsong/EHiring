<?php
if ($page_title == '新职位')
{
	$formUrl = 'enterprise_job/saveNewJob';
}
else if ($page_title == '职位编辑')
{
	$formUrl = 'enterprise_job/saveEditJob';
}
echo form_open($formUrl, '', array('time_updated'=>set_value('time_updated'), 'jobId'=>set_value('jobId')));
?>
<div class="span-24 maintext blue">
	<hr class="space" />
	<h3 class="prepend-1 blue bord" style="margin-top: 20px">招聘职位信息</h3>
	<hr class="space" />
	<?php echo validation_errors(); ?>
	<div class="prepend-1">
		<label>职位名称:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name='jobTitle' value="<?php echo set_value('jobTitle');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div style="clear: both"></div>
	<div class="prepend-1 span-8">
		<label>工作地点:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <select name="location" value="<?php echo set_value('location');?>" style="width: 200px; color: #999999">
		<?php echo form_dropdown('location', $citys); ?>
		</select>
	</div>
	<div class="prepend-1">
		<label>职位类别:&nbsp;&nbsp;&nbsp;&nbsp;</label> <select name="jobType" value="<?php echo set_value('jobType');?>" style="width: 200px; color: #999999">
		<?php echo form_dropdown('jobType', $jobTypes); ?>
		</select>
	</div>
	<div style="clear: both"></div>
	<div class="prepend-1 span-8">
		<label>佣金类型:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <select name="commissionType" value="<?php echo set_value('commissionType');?>" style="width: 200px; color: #999999">
		<?php echo form_dropdown('commissionType', $commissionTypes); ?>
		</select>
	</div>
	<div class="prepend-1">
		<label>佣金:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="commission" value="<?php echo set_value('commission');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div style="clear: both"></div>
	<div class="prepend-1 span-8">
		<label>学历:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <select name="degree" value="<?php echo set_value('degree');?>" style="width: 200px; color: #999999">
		<?php echo form_dropdown('degree', $degrees); ?>
		</select>
	</div>
	<div class="prepend-1">
		<label>工作经验:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="workExp" value="<?php echo set_value('workExp');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div style="clear: both"></div>
	<div class="prepend-1 span-8">
		<label>人数:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="recruitNum" value="<?php echo set_value('recruitNum');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div class="prepend-1">
		<label>福利待遇:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="salary" value="<?php echo set_value('salary');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div style="clear: both"></div>
	<div class="prepend-1">
		<label>职位简述:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="jobSimpleDes" value="<?php echo set_value('jobSimpleDes');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div style="clear: both"></div>
	<div class="prepend-1">
		<label>有效期:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="startDate" value="<?php echo set_value('startDate');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" /> <label>至:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="endDate" value="<?php echo set_value('endDate');?>" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; height: 20px; padding-top: 6px; color: #999999" />
	</div>
	<div style="clear: both"></div>
	<div style="clear: both"></div>
	<div class="prepend-1">
		<label style="vertical-align: top">职位详述:&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<textarea name="jobDetailDes" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; padding-top: 6px; color: #999999; height: 100px;"><?php echo set_value('jobDetailDes');?></textarea>
	</div>
	<hr class="space" />
</div>
<div class="span-24 maintext">
	<hr class="space" />
	<div class="prepend-1 append-1">
		<div style="clear: both"></div>
		<div>
			<span class="rbs1 append-1"> <input class="rb1" type="submit" value="保存"> </span> <span class="rbs1"> <input class="rb1" type="button" title="查询" value="清空"> </span>
		</div>
		<hr class="space" />
	</div>
</div>
		<?php echo form_close(); ?>
