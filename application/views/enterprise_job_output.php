<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
Name       : Regeneracy
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20100529
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Regeneracy    by Free CSS Templates</title>
		<link rel="stylesheet" href="../blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="../blueprint/print.css" type="text/css" media="print">
		<!--[if lt IE 8]><link rel="stylesheet" href="../blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
		<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
		<style type="text/css" media="screen">
			p, table, hr, .box {
				margin-bottom: 25px;
			}
			.box p {
				margin-bottom: 10px;
			}
		</style>
	</head>
	<body bgcolor="#999999">
		<div class="container">
			<div id = "header-wrapper">
				<hr class="space"/>
				<img src="images/img02.jpg" class="push-1" />
				<h1 class = "span-4 prepend-2"><a href="#">E-hiring</a></h1>
				<p class = "span-4" style="margin-top:15px;color:#FFFFFF">
					&nbsp;&nbsp;&nbsp;&nbsp;综合招聘信息平台
				</p>
				<div style="clear:both"></div>
			</div>
			<!-- end #header -->
			<div class="span-24 maintext blue">
				<hr class="space"/>
				<h3 class="prepend-1 blue bord" style="margin-top:20px">招聘职位信息预览</h3>
				<hr class="space" />
				<?php
				echo "<div class=\"prepend-1\">\n";
				echo "					<label>职位名称:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Title']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1 span-8\">\n";
				echo "					<label>工作地点:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobLocation']}</span>\n";
				echo "				</div>\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>职位类别:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Type_id']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1 span-8\">\n";
				echo "					<label>佣金类别:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Commission_type_id']}</span>\n";
				echo "				</div>\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>佣金:             </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Commission']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1 span-8\">\n";
				echo "					<label>学历:             </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobDegree']}</span>\n";
				echo "				</div>\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>工作经验:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Year_low']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1 span-8\">\n";
				echo "					<label>人数:             </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Recruit_num']}</span>\n";
				echo "				</div>\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>福利待遇:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Salary_less']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>职位简述:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Simple_des']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>有效期:        </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Start_date']}</span>\n";
				echo "					<label>至:        </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_End_date']}</span>\n";
				echo "				</div>\n";
				echo "				<hr class=\"space\" />\n";
				echo "				<div class=\"prepend-1\">\n";
				echo "					<label>职位详述:    </label>\n";
				echo "					<span class=\"gray\">{$displayData['jobInfo']['job_Detail_des']}</span>\n";
				echo "				</div>";
			?>
				<hr class="space" />
			</div>
			<div class="span-24 maintext">
				<hr class="space" />
				<div class="prepend-1">
					<a class="append-1" href="">返回修改</a><a href="">确认并进入职位页面</a>
				</div>
				<hr class="space" />
			</div>
		</div>
	</body>
</html>
