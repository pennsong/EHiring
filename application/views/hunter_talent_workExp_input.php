<script type="text/javascript" src="<?php echo base_url()."js/jquery.js" ?>"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		if($("#reasonType").val() == 1)
		{
			$("#reasonDetailDiv").show();
		}
		else
		{
			$("#reasonDetailDiv").hide();
		}
		$("#reasonTypeDiv").change(function()
		{
			if($("#reasonType").val() == 1)
			{
				$("#reasonDetailDiv").show();
			}
			else
			{
				$("#reasonDetailDiv").hide();
			}
		});
	});

</script>
<?php
if (count($displayData) == 1)
{
	//新建
	echo form_open(site_url('hunter_talent_workExp/saveNewWorkExp').'/'.$displayData['talentId']);
}
else
{
	//编辑
	echo form_open(site_url('hunter_talent_workExp/saveEditWorkExp').'/'.$displayData['talentId'].'/'.$displayData['company'].'/'.$displayData['position'].'/'.$displayData['startDate'], '', array('talentId'=>set_value('talentId'), 'company'=>set_value('company'), 'startDate'=>set_value('startDate'), 'position'=>set_value('position')));
}
?>
<div class="span-24 maintext blue">
	<hr class="space" />
	<h3 class="prepend-1 bord" style="margin-top: 20px">人才简历</h3>
	<hr />
	<div class="gray prepend-1">
		<span class="append-1">第一步：基本信息</span><span class="bord append-1" style="color: #000000">第二步：工作经历</span><span class="append-1" style="color: #000000">第三步：教育经历</span>
	</div>
	<hr class="space" />
	<?php echo validation_errors(); ?>
	<div class="prepend-1 bord">经历</div>
	<div class="prepend-1">
		<label class="append-1">公司名称:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="company" value="<?php echo set_value('company');?>" class='text' />
	</div>
	<div class="prepend-1">
		<label class="append-1">在职日期:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="startDate" value="<?php echo set_value('startDate');?>" class='text' /> <label>至:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="endDate" value="<?php echo set_value('endDate');?>" class='text' />
	</div>
	<div class="prepend-1">
		<label class="append-1">职位简述:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="position" value="<?php echo set_value('position');?>" class='text' />
	</div>
	<div class="prepend-1">
		<label class="append-1">最后工资:&nbsp;&nbsp;&nbsp;&nbsp;</label> <input name="salary" value="<?php echo set_value('salary');?>" class='text' />
	</div>
	<div id="reasonTypeDiv" class="prepend-1">
		<label class="append-1">离职原因:&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<?php $tmpAttr = 'id = "reasonType" style="width: 300px;"';
		echo form_dropdown('reasonType', $reasonType, set_value('reasonType'), $tmpAttr);
		?>
	</div>
	<div id="reasonDetailDiv" class="prepend-1">
		<textarea name="reasonDetail" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; padding-top: 6px; color: #999999; height: 100px;">
		<?php echo set_value('reasonDetail');?>
		</textarea>
	</div>
	<hr class="space" />
	<hr class="space" />
	<div class="prepend-1">
		<span class="rbs1 append-1"> <input class="rb1" type="button" title="添加" value="添加"> </span><span class="rbs1 append-1"> <span class="rbs1 append-1"> <input class="rb1" type="button" title="查询" value="上一步"> </span><span class="rbs1 append-1"> <input class="rb1" type="submit" title="查询" value="下一步"> </span><span class="rbs1"> <input class="rb1" type="button" title="查询" value="清空"> </span>
	
	</div>
	<?php
	foreach ($existWorkExp as $workExp)
	{
		echo "<pre>";
		print_r($workExp);
		echo "</pre><br>";
	}
	?>
</div>
	<?php echo form_close();?>
