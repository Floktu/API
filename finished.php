<?php

require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');

$client = new FL_OAuth2Client();

session_start();

?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="./css/bootstrap.css?1344983435">
	<link rel="stylesheet" href="./css/bootstrap-responsive.css?1344983435">
	<style type="text/css">
	
	body
	{
		font-family: Georgia;
		
		color: #474747;
	}
	
	p
	{
		font-size: 12pt;
		line-height: 16pt;
		padding-top: 8px;
		padding-bottom: 8px;
	}
	
	li
	{
		padding-top: 3px;
		padding-bottom: 3px;
	}
	
	h1, h2, h3
	{
		/*font-family: helvetica, arial, sans-serif;*/
		font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
	}
	
	.btn
	{
		font-family: helvetica, arial, sans-serif;
	}
	
	</style>
</head>
<body style="background-color: #F5F5F5">
	<div class="container">
		<br/><br/><br/>
		<div class="row" style="margin-top: 50px;">
			<div class="span2">&nbsp;</div>
			<div class="span8 center">
				<h1>Attendee Mountain</h1>
				<h2>Connected</h2>
				<p>
					You are now connected to your Floktu account.
					<br/><a href="./attendees.php">View attendees</a>
				</p>
<?php


if (isset($_REQUEST['code']))
{
	$_SESSION['code'] = $_REQUEST['code'];
}


?>

			</div>
			<div class="span2">&nbsp;</div>
		</div>
	</div>

<br/>

</body>
</html>