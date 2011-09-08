<script type="text/javascript" src="<?php echo base_url()."js/jquery.js" ?>"></script>
<script type="text/javascript">

	$(document).ready(function()
	{
		$("#livePlace").load("<?php echo site_url('hunter_talent_resume/getLivePlaceDiv').'/'.set_value('province')."/".set_value('city')?>");
		$("#livePlace").change(function()
		{
			var url = "<?php echo site_url('hunter_talent_resume/getLivePlaceDiv').'/' ?>" + $('#province').val() + "/" + $('#city').val();
			$("#livePlace").load(url);
		});
	});

</script>
<div class="container">
	<?php
	echo form_open(site_url('hunter_talent_resume/saveNewResume'));
	?>
	<div class="span-24 maintext blue">
		<hr class="space" />
		<h3 class="prepend-1 bord" style="margin-top: 20px">人才简历</h3>
		<hr />
		<div class="gray prepend-1">
			<span class="bord append-1" style="color: #000000">第一步：基本信息</span><span class="append-1">第二步：工作经历</span><span class="append-1">第三步：教育经历</span>
		</div>
		<?php echo validation_errors();?>
		<hr class="space" />
		<div class="prepend-1">
			<label class="append-1">*姓名:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input name="talentName" value="<?php echo set_value('talentName');?>" class='text' />
		</div>
		<div class="prepend-1">
			<label class="append-1">*性别:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<?php $tmpAttr = 'style="width: 300px;"';
				echo form_dropdown('talentSex', $sexes, set_value('talentSex'), $tmpAttr);
			?>
		</div>
		<div class="prepend-1">
			<label class="append-1">*手机:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input name="talentMobile" value="<?php echo set_value('talentMobile');?>" class='text' />
			<b style="color: #FF0000" class="bord prepend-1">请输入11位手机号码</b>
		</div>
		<div class="prepend-1">
			<label class="append-1">*QQ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input name="talentQQ" value="<?php echo set_value('talentQQ');?>" class='text' />
		</div>
		<div class="prepend-1">
			<label class="append-1">*身份证:&nbsp;&nbsp;&nbsp;</label>
			<input name="talentIdCard" value="<?php echo set_value('talentIdCard');?>" class='text' />
			<b style="color: #FF0000" class="bord prepend-1">请输入正确的身份证号码</b>
		</div>
		<div class="prepend-1">
			<label class="append-1">&nbsp;出生地:&nbsp;&nbsp;&nbsp;</label>
			<input name="talentBornPlace" value="<?php echo set_value('talentBornPlace');?>" class='text' />
		</div>
		<div class="prepend-1">
			<div id="livePlace"></div>
			<label>&nbsp;地址:&nbsp;&nbsp;&nbsp;</label>
			<input name="talentAddress" value="<?php echo set_value('talentAddress');?>" class='text' style="width: 200px" />
		</div>
		<div class="prepend-1">
			<label class="append-1">&nbsp;身高:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input name="talentHeight" value="<?php echo set_value('talentHeight');?>" class='text' />
		</div>
		<div class="prepend-1">
			<label class="append-1">&nbsp;体重:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			<input name="talentWeight" value="<?php echo set_value('talentWeight');?>" class='text' />
		</div>
		<div class="prepend-1">
			<label class="append-1">&nbsp;视频:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a class="append-1" href="">在线观看</a><a class="append-1" href="">下载视频</a><a class="append-1" href="">上传视频</a>
		</div>
		<hr class="space" />
		<div class="prepend-1">
			<span class="rbs1 append-1">
				<input class="rb1" type="submit" title="查询" value="下一步">
			</span><span class="rbs1">
				<input class="rb1" type="button" title="查询" value="清空">
			</span>
		</div>
	</div>
</div>
<?php echo form_close();?>
<hr class="space" />
