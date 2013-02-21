<?php

// Create OAuth2Client object
require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');
$client = new FL_OAuth2Client();

// Get access token from the session
session_start();
$accessToken = $_SESSION['access_token'];

// Get attendees
$attendees = NULL;

if (isset($_SESSION['access_token']))
{
	if (isset($_REQUEST['eventid']))
	{
		// Get attendees from the Floktu API
		curl_setopt_array($cha = curl_init(), array (
				CURLOPT_URL => "https://floktu.com/api/v1/events/" . $_REQUEST['eventid'] . "/attendees",
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $accessToken),
				CURLOPT_SSL_VERIFYPEER => 0
			)
		);
		$result = curl_exec($cha);
		curl_close($cha);
		$attendees = json_decode($result);
	}
}

// Render the page
include('./includes/htmltop.php');

if (isset($_SESSION['access_token']))
{
	if ($attendees)
	{
		?>
		
		<h2>Attendee List</h2>
		
		<?php
		
		foreach($attendees as $attendee)
		{
			echo '<strong>' . $attendee->{'attendee_first_name'} . ' ' . $attendee->{'attendee_last_name'} . '</strong><br/>';
			echo 'Ordered by: ' . $attendee->{'order_first_name'} . ' ' . $attendee->{'order_last_name'} . ' - Ticket: ' . $attendee->{'ticket'} . ' - OrderId: ' . $attendee->{'order_id'} . ' - AttendeeId: ' . $attendee->{'attendee_id'} . '<br/><br/>';
		}
	}
	else
	{
	?>
		<p>Could not load attendees for this event.</p>
	<?php
	}
}
else
{
?>
	<p>You need to connect to your Floktu account before you can view attendees.</p>
<?php
}
include('./includes/htmlbottom.php');
?>