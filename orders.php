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
$orders = NULL;

if (isset($_SESSION['access_token']))
{
	if (isset($_REQUEST['eventid']))
	{
		// Get attendees from the Floktu API
		curl_setopt_array($cha = curl_init(), array (
				CURLOPT_URL => FLOKTU_API_BASE_URI . "events/" . $_REQUEST['eventid'] . "/orders",
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $accessToken),
				CURLOPT_SSL_VERIFYPEER => 0
			)
		);
		$result = curl_exec($cha);
		curl_close($cha);
		$orders = json_decode($result);
	}
}

// Render the page
include('./includes/htmltop.php');

if (isset($_SESSION['access_token']))
{
	if ($orders)
	{
		?>
		
		<h2>Order List</h2>
		
		<?php
		foreach($orders as $order)
		{
			echo '<strong>' . $order->{'id'} . ' - ' . $order->{'first_name'} . ' ' . $order->{'last_name'} . '</strong>' . ' - ';
			echo '<a href="./order.php?eventid=' . $_REQUEST['eventid'] . '&orderid=' . $order->{'id'} . '">View order details.</a><br>';
		}
	}
	else
	{
	?>
		<p>Could not load orders for this event.</p>
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