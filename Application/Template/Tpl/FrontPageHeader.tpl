<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Higify - <?php echo $PAGE_TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="./Static/index.css" />
		<link rel="stylesheet" type="text/css" href="./Static/slideshow.css" />
		<?php
		if (isset($CSS))
		{
			foreach ($CSS as $stylesheet)
			{
				echo '<link rel="stylesheet" type="text/css" href="static/' . $stylesheet . '.css"/> ';
			}
		}
		
		if (isset($JS))
		{
			foreach ($JS as $javascript)
			{
				echo '<script type="text/javascript" src="static/' . $javascript . '.js"></script> ';
			}
		}
		?>
	</head>
	<body id="page">
		<ul class="cb-slideshow">
			<li class="cb-slideshowelement"><span></span></li>
			<li class="cb-slideshowelement"><span></span></li>
			<li class="cb-slideshowelement"><span></span></li>
		</ul>
		<div class="pageContainer">
			<div class="centerContainer" id="mainContainer">