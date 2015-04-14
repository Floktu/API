<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./css/bootstrap.css?1344983435">
	<link rel="stylesheet" href="./css/bootstrap-responsive.css?1344983435">
	<style type="text/css">
	body { font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif; color: #474747; padding: 30px; background-color: #F5F5F5 }
	p { font-size: 12pt; line-height: 16pt; padding-top: 8px; padding-bottom: 8px; }
	.btn { font-family: helvetica, arial, sans-serif; }
	h1 { font-size: 30pt; }
	</style>
</head>
<body>
	<br/><br/><br/>
	<div class="row">
		<div class="span2">&nbsp;</div>
		<div class="span8 center">
			<h1>Attend It!</h1>
			<em>A Floktu API V2 client example.</em>
			<br/>
			
			<?php
			if (isset($location) && $location == 'index')
			{
				?>Connect to my Floktu Account<?php
			}
			else
			{
				?><a href="./">Connect to my Floktu Account</a><?php
			}
			
			if (isset($location) && $location == 'events')
			{
				?>| View Events<?php
			}
			else
			{
				?>| <a href="./events.php">View Events</a><?php
			}
			?>
			
			<br/><br/>