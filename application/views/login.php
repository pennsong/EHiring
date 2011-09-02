<div class="span-24" style="background-color: #FFFFFF; height: 600px">
	<div class="span-8 border"
	style="background-color: #FFFFFF; height: 600px"
	>
		<hr class="space" />
		<?php
		echo form_open('login/submit_validate');
		?>
		<div class="span-10 blue bord prepend-1">
			用户名:&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text"
			value="<?php echo set_value('username');?>" id="search-text"
			name="username" style="height: 20px"
			>
			<?php
			$errStr = str_replace(array('<p>', '</p>'), array('', ''), form_error('username'));
			echo $errStr;
			?>
		</div>
		<hr class="space" />
		<div class="span-10 blue bord prepend-1">
			密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;&nbsp;&nbsp;
			<input
			type="text" value="" id="search-text" name="password"
			style="height: 20px"
			>
			<?php
			$errStr = str_replace(array('<p>', '</p>'), array('', ''), form_error('password'));
			echo $errStr;
			?>
		</div>
		<hr class="space" />
		<div class="span-10 blue bord prepend-1">
			<input type="checkbox" />
			<b class="prepend-1">下次自动登录</b>
		</div>
		<hr class="space" />
		<div class="span-10 blue bord prepend-1">
			<input type="radio" name="type" value="hunter"
			<?php
			echo set_radio('type', 'hunter', TRUE);
			?>
			/>
			<b class="append-1">猎头</b>
			<input type="radio" name="type"
			value="hr"
			<?php
			echo set_radio('type', 'hr');
			?>
			/>
			<b class="append-1">公司</b>
		</div>
		<hr class="space" />
		<div class="span-10 blue bord prepend-1">
			<span class="rbs1">
				<input class="rb1" type="submit" title="登录"
				value="登录"
				/>
			</span>
			<?php
			echo form_close();
			?>
			<a class="prepend-1" href="#">忘记密码</a>
		</div>
	</div>
