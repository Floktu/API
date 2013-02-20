<?php

require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');

$client = new FL_OAuth2Client();

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
				<p>Connect your Floktu account to Attendee Mountain to automatically import attendees for your event.</p>
				<a href="<?php echo $client->getLoginUri(array('state'=>1));?>" class="btn btn-success">Connect with Floktu</a>
			</div>
			<div class="span2">&nbsp;</div>
		</div>
	</div>

<br/>

<?php

if (isset($_REQUEST['code']))
{
	echo 'golden: ' . $_REQUEST['code'];
	
	// Get session
	$session = $client->getSession();
	
	if (isset($session['access_token']))
	{
		$accessToken = $session['access_token'];
		echo '<br/>bearer: ' . $accessToken;
		
		curl_setopt_array($cha = curl_init(), array
			(
				CURLOPT_URL => "http://floktu.com/api/v1/event/321/attendees",
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $accessToken)
			)
		);
		
		$result = curl_exec($cha);
		curl_close($cha);
		echo '<br/>Eagle: ';
		print_r($result);
	}

}


?>

</body>
</html>