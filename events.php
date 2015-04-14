<?php

// Create OAuth2Client object
require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');
$client = new FL_OAuth2Client();

// Get access token from the session
session_start();
if (isset($_SESSION['access_token']))
{
	// Get events from the Floktu API
	curl_setopt_array($cha = curl_init(), array (
			CURLOPT_URL => FLOKTU_API_BASE_URI . "events",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $_SESSION['access_token']),
			CURLOPT_SSL_VERIFYPEER => 0
		)
	);
	$result = curl_exec($cha);
	curl_close($cha);
	$events = json_decode($result);
}
// Render the page
$location = 'events';
include('./includes/htmltop.php');

if (isset($_SESSION['access_token']))
{
?>

<h2>Event List</h2>

<?php 
	if ($events)
	{
?>
<p>Choose an event to view its attendees.</p>
<form method="get" action="./orders.php">
	<select name="eventid" style="width:350px;">
	<?php
		foreach($events as $event)
		{
			?><option value="<?php echo $event->{'id'};?>"><?php echo $event->{'name'}; ?></option><?php
		}
	?>
	</select>
	<br/>
	<input type="submit" value="View Orders" class="btn btn-primary"/>
</form>

<?php
	}
	else
	{
		?>You do not have any events.<?php
	}
?>

<?php
}
else
{
?>
	<p>You need to connect to your Floktu account before you can view events.</p>
<?php
}
include('./includes/htmlbottom.php');
?>