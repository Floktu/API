<?php

// Create OAuth2Client object
require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');
$client = new FL_OAuth2Client();

// Get access token from the session
session_start();
$accessToken = $_SESSION['access_token'];

// Get the order
$order = NULL;

if (isset($_SESSION['access_token']))
{
	if (isset($_REQUEST['eventid']))
	{
		// Get attendees from the Floktu API
		curl_setopt_array($cha = curl_init(), array (
				CURLOPT_URL => FLOKTU_API_BASE_URI . "events/" . $_REQUEST['eventid'] . "/orders/" . $_REQUEST['orderid'],
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $accessToken),
				CURLOPT_SSL_VERIFYPEER => 0
			)
		);
		$result = curl_exec($cha);
		curl_close($cha);
		$order = json_decode($result);
	}
}

// Render the page
include('./includes/htmltop.php');

if (isset($_SESSION['access_token']))
{
	if ($order)
	{
		?>
		
		<h2>Order Details</h2>
		<a href="./orders.php?eventid=<?php echo $_REQUEST['eventid'] ?>">Back to orders</a><br><br>
		
		<?php
		echo '<strong>' . $order->{'id'} . ' - ' . $order->{'name'} . '</strong>' . '<br>';
		echo '<br>Order total: ' . $order->{'order_amount'};
		echo '<br>Amount paid: ' . $order->{'amount_paid'};
		echo '<br>Status: ' . $order->{'status'};
		
		?>
		<br><br>
		<h3>Order attendees</h3>
		
		<?
		if (array_key_exists('attendees', $order))
		{
			foreach($order->{'attendees'} as $attendee)
			{
				echo '<strong>' . $attendee->{'attendee_first_name'} . ' ' . $attendee->{'attendee_last_name'} . '</strong> - ';
				echo 'Ticket: ' . $attendee->{'ticket'} . ' - AttendeeId: ' . $attendee->{'attendee_id'} . '<br/>';
			}
		}
	}
	else
	{
	?>
		<p>Could not load this order for this event.</p>
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