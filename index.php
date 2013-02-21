<?php

// Create OAuth2Client object
require_once('./OAuth2Client/OAuth2Exception.php');
require_once('./OAuth2Client/OAuth2Client.php');
require_once('./OAuth2Client/FL_OAuth2Client.php');
$client = new FL_OAuth2Client();

// Get the OAuth2 login uri
$loginUri = $client->getLoginUri(array('state'=>1));

session_start();
session_destroy();

// Render the page
$location = 'index';
include('./includes/htmltop.php');
?>

	<p>Connect your Floktu account to Attendee Mountain to automatically import attendees for your event.</p>
	<a href="<?php echo $loginUri;?>" class="btn btn-success">Connect with Floktu</a>

<?php
include('./includes/htmlbottom.php');
?>