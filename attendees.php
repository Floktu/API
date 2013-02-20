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
				<a href="./">Home</a>
				<h1>Attendee Mountain</h1>
				<h2>Attendee list</h2>

<?php

if (isset($_SESSION['code']))
{
	$client->setVariable('code', $_SESSION['code']);
	
	// Get session
	$session = $client->getSession();
	
	if (isset($session['access_token']))
	{
		$accessToken = $session['access_token'];
		if (isset($_REQUEST['eventid']))
		{
			$eventId = $_REQUEST['eventid'];
		}
		else
		{
			$eventId = NULL;
		}
		
		// Get events
		curl_setopt_array($cha = curl_init(), array
			(
				CURLOPT_URL => "https://floktu.com/api/v1/events",
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $accessToken),
				CURLOPT_SSL_VERIFYPEER => 0
			)
		);
		
		$result = curl_exec($cha);
		curl_close($cha);
		$events = json_decode($result);
		
		?>
		<form method="get">
			<select name="eventid" style="width:350px;">
		<?php
		foreach($events as $event)
		{
			?> 
				<option value="<?php echo $event->{'id'};?>" <?php if ($event->{'id'} == $eventId) echo 'selected="selected"';?>><?php echo $event->{'name'}; ?></option>
			<?php
		}
		?>
			</select>
			<br/>
			<input type="submit" value="Search" class="btn btn-primary"/>
		</form>
		<?php
		
		// Get attendees
		if (isset($_REQUEST['eventid']))
		{
			$eventId = $_REQUEST['eventid'];
			curl_setopt_array($cha = curl_init(), array
				(
					CURLOPT_URL => "https://floktu.com/api/v1/events/" . $eventId . "/attendees",
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $accessToken),
					CURLOPT_SSL_VERIFYPEER => 0
				)
			);
			
			$result = curl_exec($cha);
			curl_close($cha);
			$attendees = json_decode($result);
			
			foreach($attendees as $attendee)
			{
				echo '<strong>' . $attendee->{'attendee_first_name'} . ' ' . $attendee->{'attendee_last_name'} . '</strong><br/>';
				echo 'Ordered by: ' . $attendee->{'order_first_name'} . ' ' . $attendee->{'order_last_name'} . ' - Ticket: ' . $attendee->{'ticket'} . ' - OrderId: ' . $attendee->{'order_id'} . ' - AttendeeId: ' . $attendee->{'attendee_id'} . '<br/><br/>';
			}
		}
	}

}
else
{
	?><p>Could not connect to Floktu.</p><?php
}


?>

			</div>
			<div class="span2">&nbsp;</div>
		</div>
	</div>

<br/>

</body>
</html>