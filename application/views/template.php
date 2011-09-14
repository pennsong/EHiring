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
		<title><?php echo $page_title;?></title>
		<?php
		echo '<link rel="stylesheet" href="'.base_url().'blueprint/screen.css" type="text/css" media="screen, projection">';
		echo '<link rel="stylesheet" href="'.base_url().'blueprint/print.css" type="text/css" media="print">';
		echo '<link href="'.base_url().'style.css" rel="stylesheet" type="text/css" media="screen" />';
		echo "<script src='".base_url()."/js/jquery.js'></script>";
		?>
		<style type="text/css" media="screen">
			p, table, hr, .box {
				margin-bottom: 25px;
			}
			.box p {
				margin-bottom: 10px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<?php $this->load->view('user_controls');?>
			<?php $this->load->view($content_view);?>
		</div>
	</body>
</html>
