<script>
	$(document).ready(function()
	{
		processReason();
		$("#reasonTypeDiv").change(function()
		{
			processReason();
		});
	});
	function processReason()
	{
		if($("#reasonType").val() == 1)
		{
			$("#reasonDetailDiv").show();
		}
		else
		{
			$("#reasonDetailDiv").hide();
		}
	}

	function resetForm()
	{
		document.formWorkExp.reset();
		processReason();
	}
</script>
<div class="span-24 maintext blue">
	<hr class="space" />
	<h3 class="prepend-1 bord" style="margin-top: 20px">人才简历</h3>
	<div class="prepend-1">
		<?php
		if ($type == 'display')
		{
			echo '<span class="rbs1 append-1">';
			$tmpAttr = array('class'=>'rb1');
			echo anchor(site_url('hunter_talent_workExp/newWorkExp').'/'.$displayData['talentId'], '添加', $tmpAttr);
			echo '</span>';
			echo '<span class="rbs1 append-1">';
			$tmpAttr = array('class'=>'rb1');
			echo anchor(site_url('hunter_talent_resume/editResume').'/'.$displayData['talentId'], '上一步', $tmpAttr);
			echo '</span>';
			echo '<span class="rbs1 append-1">';
			$tmpAttr = array('class'=>'rb1');
			echo anchor('', '下一步', $tmpAttr);
			echo '</span>';
		}
		?>
	</div>
	<hr />
	<div class="gray prepend-1">
		<span class="append-1">第一步：基本信息</span><span class="bord append-1" style="color: #000000">第二步：工作经历</span><span class="append-1" style="color: #000000">第三步：教育经历</span>
	</div>
	<hr class="space" />
	<?php
	if ($type == 'new' || ($type == 'edit'))
	{
		echo validation_errors();
		if ($type == 'new')
		{
			$tmpAttr = array();
			$url = site_url('hunter_talent_workExp/saveNewWorkExp').'/'.$displayData['talentId'];
		}
		else if ($type == 'edit')
		{
			$tmpAttr = array(
					'company'=>set_value('company'),
					'startDate'=>set_value('startDate'),
					'position'=>set_value('position')
			);
			$url = site_url('hunter_talent_workExp/saveEditWorkExp').'/'.$displayData['talentId'].'/'.$displayData['company'].'/'.$displayData['position'].'/'.$displayData['startDate'];
		}
		echo form_open($url, array('name'=>'formWorkExp'), $tmpAttr);
		echo <<<HTMLDOC
	<div class="prepend-1 bord">
		经历
	</div>
	<div class="prepend-1">
		<label class="append-1">公司名称:&nbsp;&nbsp;&nbsp;&nbsp;</label>
HTMLDOC;
		if ($type == 'edit')
		{
			$tmpAttr = array('class'=>'text');
			echo form_label(set_value('company'), '', $tmpAttr);
		}
		else if ($type == 'new')
		{
			$tmpAttr = array(
					'name'=>'company',
					'value'=>set_value('company'),
					'class'=>'text'
			);
			echo form_input($tmpAttr);
		}
		echo <<<HTMLDOC
	</div>
	<div class="prepend-1">
		<label class="append-1">在职日期:&nbsp;&nbsp;&nbsp;&nbsp;</label>
HTMLDOC;
		if ($type == 'edit')
		{
			$tmpAttr = array('class'=>'text');
			echo form_label(set_value('startDate'), '', $tmpAttr);
		}
		else if ($type == 'new')
		{
			$tmpAttr = array(
					'name'=>'startDate',
					'value'=>set_value('startDate'),
					'class'=>'text'
			);
			echo form_input($tmpAttr);
		}
		$set_value = 'set_value';
		echo <<<HTMLDOC
		<label>至:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<input name="endDate" value="{$set_value('endDate')}" class='text' />
	</div>
	<div class="prepend-1">
		<label class="append-1">职位:&nbsp;&nbsp;&nbsp;&nbsp;</label>
HTMLDOC;
		if ($type == 'edit')
		{
			$tmpAttr = array('class'=>'text');
			echo form_label(set_value('position'), '', $tmpAttr);
		}
		else if ($type == 'new')
		{
			$tmpAttr = array(
					'name'=>'position',
					'value'=>set_value('position'),
					'class'=>'text'
			);
			echo form_input($tmpAttr);
		}
		echo <<<HTMLDOC
	</div>
	<div class="prepend-1">
		<label class="append-1">最后工资:&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<input name="salary" value="{$set_value('salary')}" class='text' />
	</div>
	<div id="reasonTypeDiv" class="prepend-1">
		<label class="append-1">离职原因:&nbsp;&nbsp;&nbsp;&nbsp;</label>
HTMLDOC;
		$tmpAttr = 'id = "reasonType" style="width: 300px;"';
		echo form_dropdown('reasonType', $reasonType, set_value('reasonType'), $tmpAttr);
		echo <<<HTMLDOC
	</div>
	<div id="reasonDetailDiv" class="prepend-1">
		<textarea name="reasonDetail" class='text' style="width: 198px; padding: 0px; border: 1px solid #7F9CBA; padding-top: 6px; color: #999999; height: 100px;">{$set_value('reasonDetail')}</textarea>
	</div>
	<span class="rbs1">
		<input class="rb1" type="submit" title="查询" value="保存">
	</span><span class="rbs1">
		<input class="rb1" type="button" onClick="resetForm();" title="查询" value="重置">
	</span>
	<span class="rbs1">
HTMLDOC;
		$tmpAttr = array('class'=>'rb1');
		echo anchor(site_url('hunter_talent_workExp/displayWorkExp').'/'.$displayData['talentId'], '取消', $tmpAttr);
		echo form_close();
		echo "</span>";
	}
	?>
	<hr class="space" />
	<hr class="space" />
	<?php
	foreach ($existWorkExp as $workExp)
	{
		$workExp['hunter_talent_work_experience_Start_date'] = substr($workExp['hunter_talent_work_experience_Start_date'], 0, 7);
		$workExp['hunter_talent_work_experience_End_date'] = substr($workExp['hunter_talent_work_experience_End_date'], 0, 7);
		if ($type == 'display')
		{
			echo anchor(site_url('hunter_talent_workExp/editWorkExp').'/'.$workExp['hunter_talent_work_experience_Talent_id'].'/'.$workExp['hunter_talent_work_experience_Company'].'/'.$workExp['hunter_talent_work_experience_Position'].'/'.$workExp['hunter_talent_work_experience_Start_date'], '编辑');
			echo "<br>";
			echo anchor(site_url('hunter_talent_workExp/delWorkExp').'/'.$workExp['hunter_talent_work_experience_Talent_id'].'/'.$workExp['hunter_talent_work_experience_Company'].'/'.$workExp['hunter_talent_work_experience_Position'].'/'.$workExp['hunter_talent_work_experience_Start_date'], '删除');
		}
		echo "<pre>";
		if ($workExp['hunter_talent_work_experience_Company'] == set_value('company') && $workExp['hunter_talent_work_experience_Position'] == set_value('position') && $workExp['hunter_talent_work_experience_Start_date'] == set_value('startDate'))
		{
			echo "<b>";
			print_r($workExp);
			echo "</b>";
		}
		else
		{
			print_r($workExp);
		}
		echo "</pre><br>";
	}
	?>
	</div>
